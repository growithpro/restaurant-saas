
<?php

use App\Models\Branch;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

return new class extends Component
{
    public string $startDate = '';

    public string $endDate = '';

    public string $branchId = '';

    public function mount(): void
    {
        $this->startDate = now()->startOfMonth()->toDateString();
        $this->endDate = now()->toDateString();
    }

    private function restaurantId(): int
    {
        return (int) Auth::user()->restaurant_id;
    }

    private function filteredOrders()
    {
        $start = $this->startDate ?: now()->startOfMonth()->toDateString();
        $end = $this->endDate ?: now()->toDateString();

        if ($start > $end) {
            [$start, $end] = [$end, $start];
        }

        return Order::query()
            ->where('orders.restaurant_id', $this->restaurantId())
            ->whereBetween('orders.created_at', [
                $start.' 00:00:00',
                $end.' 23:59:59',
            ])
            ->when($this->branchId !== '', function ($query) {
                $query->where('orders.branch_id', $this->branchId);
            });
    }

    public function resetFilters(): void
    {
        $this->startDate = now()->startOfMonth()->toDateString();
        $this->endDate = now()->toDateString();
        $this->branchId = '';
    }

    public function exportCsv()
    {
        $orders = $this->filteredOrders()
            ->where('orders.status', '!=', 'cancelled')
            ->with('branch')
            ->orderBy('orders.created_at')
            ->get();

        return response()->streamDownload(function () use ($orders) {
            $file = fopen('php://output', 'w');

            // Excel mein Indian currency / names ko sahi handle karne ke liye UTF-8 BOM.
            fwrite($file, "\xEF\xBB\xBF");

            fputcsv($file, [
                'Order Number',
                'Date',
                'Branch',
                'Order Type',
                'Status',
                'Sales Amount',
            ]);

            foreach ($orders as $order) {
                fputcsv($file, [
                    $order->order_number,
                    $order->created_at->format('Y-m-d H:i:s'),
                    $order->branch?->name ?? '',
                    $order->order_type,
                    $order->status,
                    $order->grand_total,
                ]);
            }

            fclose($file);
        }, 'restaurant-sales-report.csv', [
            'Content-Type' => 'text/csv; charset=UTF-8',
        ]);
    }

    public function render()
    {
        $restaurantId = $this->restaurantId();

        $branches = Branch::query()
            ->where('restaurant_id', $restaurantId)
            ->orderBy('name')
            ->get();

        $orders = $this->filteredOrders();

        // Cancelled orders ko sales revenue mein include nahi karna.
        $salesOrders = (clone $orders)
            ->where('orders.status', '!=', 'cancelled');

        $totalSales = (clone $salesOrders)->sum('orders.grand_total');
        $totalOrders = (clone $salesOrders)->count();

        $completedOrders = (clone $orders)
            ->where('orders.status', 'completed')
            ->count();

        $cancelledOrders = (clone $orders)
            ->where('orders.status', 'cancelled')
            ->count();

        $averageOrderValue = $totalOrders > 0
            ? $totalSales / $totalOrders
            : 0;

        $statusCounts = (clone $orders)
            ->select('orders.status', DB::raw('COUNT(*) as total'))
            ->groupBy('orders.status')
            ->pluck('total', 'status');

        $dailySales = (clone $salesOrders)
            ->selectRaw('DATE(orders.created_at) as sales_date')
            ->selectRaw('SUM(orders.grand_total) as revenue')
            ->selectRaw('COUNT(*) as order_count')
            ->groupByRaw('DATE(orders.created_at)')
            ->orderBy('sales_date')
            ->get();

        // Zero-sales days ko chart mein bhi show karo.
        $salesByDate = $dailySales->keyBy('sales_date');
        $chart = collect();

        $start = Carbon::parse($this->startDate);
        $end = Carbon::parse($this->endDate);

        // Very large ranges se page heavy na ho.
        if ($start->diffInDays($end) > 365) {
            $start = $end->copy()->subDays(365);
        }

        for ($date = $start->copy(); $date->lte($end); $date->addDay()) {
            $key = $date->toDateString();
            $row = $salesByDate->get($key);

            $chart->push([
                'date' => $key,
                'label' => $date->format('d M'),
                'revenue' => (float) ($row->revenue ?? 0),
                'orders' => (int) ($row->order_count ?? 0),
            ]);
        }

        $maxRevenue = max(1, (float) $chart->max('revenue'));

        // Snapshot item name and price se historical item sales calculate karo.
        $topItems = DB::table('order_items')
            ->join('orders', 'orders.id', '=', 'order_items.order_id')
            ->where('orders.restaurant_id', $restaurantId)
            ->where('orders.status', '!=', 'cancelled')
            ->whereBetween('orders.created_at', [
                $this->startDate.' 00:00:00',
                $this->endDate.' 23:59:59',
            ])
            ->when($this->branchId !== '', function ($query) {
                $query->where('orders.branch_id', $this->branchId);
            })
            ->select('order_items.item_name')
            ->selectRaw('SUM(order_items.quantity) as quantity_sold')
            ->selectRaw('SUM(order_items.total) as item_revenue')
            ->groupBy('order_items.item_name')
            ->orderByDesc('quantity_sold')
            ->limit(10)
            ->get();

        $recentOrders = (clone $orders)
            ->with('branch')
            ->latest('orders.created_at')
            ->limit(10)
            ->get();

        return $this->view([
            'branches' => $branches,
            'totalSales' => $totalSales,
            'totalOrders' => $totalOrders,
            'completedOrders' => $completedOrders,
            'cancelledOrders' => $cancelledOrders,
            'averageOrderValue' => $averageOrderValue,
            'statusCounts' => $statusCounts,
            'chart' => $chart,
            'maxRevenue' => $maxRevenue,
            'topItems' => $topItems,
            'recentOrders' => $recentOrders,
        ])->layout('layouts.app');
    }
};
