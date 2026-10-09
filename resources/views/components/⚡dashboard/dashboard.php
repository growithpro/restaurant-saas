<?php

use App\Models\Branch;
use App\Models\Category;
use App\Models\MenuItem;
use App\Models\Order;
use App\Models\RestaurantTable;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

new class extends Component
{
    public function render()
    {
        $user = Auth::user();
        $restaurantId = $user->restaurant_id;

        if (!$restaurantId) {
            return $this->view()
                ->layout('layouts.app');
        }

        $todayOrders = Order::where('restaurant_id', $restaurantId)
            ->whereDate('created_at', today());

        $todayRevenue = (clone $todayOrders)
            ->where('status', '!=', 'cancelled')
            ->sum('grand_total');

        $todayOrderCount = (clone $todayOrders)->count();

        $pendingOrders = Order::where('restaurant_id', $restaurantId)
            ->whereIn('status', [
                'pending',
                'preparing',
                'ready',
                
            ])
            ->count();

        $branchesCount = Branch::where(
            'restaurant_id',
            $restaurantId
        )->count();

        $tablesCount = RestaurantTable::whereHas(
            'branch',
            function ($query) use ($restaurantId) {
                $query->where(
                    'restaurant_id',
                    $restaurantId
                );
            }
        )->count();

        $occupiedTables = RestaurantTable::whereHas(
            'branch',
            function ($query) use ($restaurantId) {
                $query->where(
                    'restaurant_id',
                    $restaurantId
                );
            }
        )
            ->where('status', 'occupied')
            ->count();

        $availableTables = RestaurantTable::whereHas(
            'branch',
            function ($query) use ($restaurantId) {
                $query->where(
                    'restaurant_id',
                    $restaurantId
                );
            }
        )
            ->where('status', 'available')
            ->count();

        $categoriesCount = Category::where(
            'restaurant_id',
            $restaurantId
        )->count();

        $menuItemsCount = MenuItem::where(
            'restaurant_id',
            $restaurantId
        )->count();

        $availableMenuItems = MenuItem::where(
            'restaurant_id',
            $restaurantId
        )
            ->where('is_available', true)
            ->count();

        $recentOrders = Order::with([
            'branch',
            'table',
        ])
            ->where(
                'restaurant_id',
                $restaurantId
            )
            ->latest()
            ->take(8)
            ->get();

        $popularItems = MenuItem::where(
            'restaurant_id',
            $restaurantId
        )
            ->withCount([
                'orderItems as sold_quantity' => function ($query) {
                    $query->whereHas('order', function ($orderQuery) {
                        $orderQuery->where(
                            'status',
                            '!=',
                            'cancelled'
                        );
                    });
                },
            ])
            ->orderByDesc('sold_quantity')
            ->take(5)
            ->get();

        return $this->view([
            'todayRevenue' => $todayRevenue,
            'todayOrderCount' => $todayOrderCount,
            'pendingOrders' => $pendingOrders,
            'branchesCount' => $branchesCount,
            'tablesCount' => $tablesCount,
            'occupiedTables' => $occupiedTables,
            'availableTables' => $availableTables,
            'categoriesCount' => $categoriesCount,
            'menuItemsCount' => $menuItemsCount,
            'availableMenuItems' => $availableMenuItems,
            'recentOrders' => $recentOrders,
            'popularItems' => $popularItems,
        ])->layout('layouts.app');
    }
};