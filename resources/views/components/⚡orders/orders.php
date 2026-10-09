<?php

use App\Models\Order;
use App\Models\RestaurantTable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

new class extends Component
{
    use WithPagination;
    public string $search = '';

    public string $statusFilter = '';

    public string $orderTypeFilter = '';

    public ?int $selectedOrderId = null;

    public function updateStatus(int $orderId, string $status): void
    {
        $user = Auth::user();

        $allowedStatuses = [
            'pending',
            'preparing',
            'ready',
            'served',
            'completed',
            'cancelled',
        ];

        if (! in_array($status, $allowedStatuses, true)) {
            return;
        }

        $order = Order::where('restaurant_id', $user->restaurant_id)
            ->where('id', $orderId)
            ->firstOrFail();

        DB::transaction(function () use ($order, $status) {

            $order->update([
                'status' => $status,
            ]);

            if ($order->table_id) {

                $shouldReleaseTable = in_array(
                    $status,
                    ['completed', 'cancelled'],
                    true
                );

                if ($shouldReleaseTable) {

                    $hasActiveOrder = Order::where(
                        'table_id',
                        $order->table_id
                    )
                        ->where('id', '!=', $order->id)
                        ->whereIn('status', [
                            'pending',
                            'preparing',
                            'ready',
                            'served',
                        ])
                        ->exists();

                    if (! $hasActiveOrder) {
                        RestaurantTable::where(
                            'id',
                            $order->table_id
                        )->update([
                            'status' => 'available',
                        ]);
                    }
                }
            }
        });

        session()->flash(
            'success',
            'Order status updated.'
        );
    }

    public function viewOrder(int $orderId): void
    {
        $user = Auth::user();

        $exists = Order::where('restaurant_id', $user->restaurant_id)
            ->where('id', $orderId)
            ->exists();

        if ($exists) {
            $this->selectedOrderId = $orderId;
        }
    }

    public function closeOrder(): void
    {
        $this->selectedOrderId = null;
    }

    public function render()
    {
        $restaurantId = Auth::user()->restaurant_id;

        $query = Order::with([
            'branch',
            'table',
            'items',
        ])
            ->where('restaurant_id', $restaurantId);

        if (trim($this->search) !== '') {
            $search = trim($this->search);

            $query->where(function ($q) use ($search) {
                $q->where(
                    'order_number',
                    'like',
                    '%'.$search.'%'
                )
                    ->orWhereHas('table', function ($tableQuery) use ($search) {
                        $tableQuery->where(
                            'name',
                            'like',
                            '%'.$search.'%'
                        );
                    })
                    ->orWhereHas('branch', function ($branchQuery) use ($search) {
                        $branchQuery->where(
                            'name',
                            'like',
                            '%'.$search.'%'
                        );
                    });
            });
        }

        if ($this->statusFilter !== '') {
            $query->where(
                'status',
                $this->statusFilter
            );
        }

        if ($this->orderTypeFilter !== '') {
            $query->where(
                'order_type',
                $this->orderTypeFilter
            );
        }

        $orders = $query
            ->latest()
            ->paginate(15);

        $selectedOrder = null;

        if ($this->selectedOrderId) {
            $selectedOrder = Order::with([
                'branch',
                'table',
                'items.menuItem',
            ])
                ->where(
                    'restaurant_id',
                    $restaurantId
                )
                ->where(
                    'id',
                    $this->selectedOrderId
                )
                ->first();
        }

        return $this->view([
            'orders' => $orders,
            'selectedOrder' => $selectedOrder,
        ])->layout('layouts.app');
    }
};
