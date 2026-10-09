<?php

use App\Models\Kot;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

new class extends Component
{
    public string $statusFilter = 'active';

    public string $branchFilter = '';

    public string $search = '';

    public function updateStatus(
        int $kotId,
        string $status
    ): void {
        $user = Auth::user();

        if (! $user->restaurant_id) {
            return;
        }

        $allowedStatuses = [
            'new',
            'preparing',
            'ready',
            'served',
            'cancelled',
        ];

        if (! in_array($status, $allowedStatuses, true)) {
            return;
        }

        $kot = Kot::where(
            'restaurant_id',
            $user->restaurant_id
        )
            ->findOrFail($kotId);

        DB::transaction(function () use ($kot, $status) {
            $data = [
                'status' => $status,
            ];

            if ($status === 'preparing' && ! $kot->started_at) {
                $data['started_at'] = now();
            }

            if ($status === 'ready') {
                $data['ready_at'] = now();
            }

            if ($status === 'served') {
                $data['served_at'] = now();
            }

            $kot->update($data);

            /*
            |--------------------------------------------------------------------------
            | Keep Order status in sync with KOT
            |--------------------------------------------------------------------------
            */

            $orderStatus = match ($status) {
                'new' => 'pending',
                'preparing' => 'preparing',
                'ready' => 'ready',
                'served' => 'served',
                'cancelled' => 'cancelled',
                default => null,
            };

            if ($orderStatus) {
                $kot->order()->update([
                    'status' => $orderStatus,
                ]);
            }

            /*
            |--------------------------------------------------------------------------
            | Release table after served/cancelled
            |--------------------------------------------------------------------------
            */

            if (
                in_array(
                    $status,
                    ['served', 'cancelled'],
                    true
                )
            ) {
                $table = $kot->table;

                if ($table) {
                    $hasActiveOrders = $table->orders()
                        ->whereIn('status', [
                            'pending',
                            'preparing',
                            'ready',
                            'served',
                        ])
                        ->where(
                            'id',
                            '!=',
                            $kot->order_id
                        )
                        ->exists();

                    if (! $hasActiveOrders) {
                        $table->update([
                            'status' => 'available',
                        ]);
                    }
                }
            }
        });
    }

    public function render()
    {
        $user = Auth::user();

        $restaurantId = $user->restaurant_id;

        $branches = collect();

        $kots = collect();

        if ($restaurantId) {
            $branches = $user->restaurant
                ? $user->restaurant->branches()
                    ->where('is_active', true)
                    ->orderBy('name')
                    ->get()
                : collect();

            $query = Kot::with([
                'order',
                'branch',
                'table',
                'items.menuItem',
            ])
                ->where(
                    'restaurant_id',
                    $restaurantId
                );

            /*
            |--------------------------------------------------------------------------
            | Status filter
            |--------------------------------------------------------------------------
            */

            if ($this->statusFilter === 'active') {
                $query->whereIn('status', [
                    'new',
                    'preparing',
                    'ready',
                ]);
            } elseif ($this->statusFilter !== 'all') {
                $query->where(
                    'status',
                    $this->statusFilter
                );
            }

            /*
            |--------------------------------------------------------------------------
            | Branch filter
            |--------------------------------------------------------------------------
            */

            if ($this->branchFilter !== '') {
                $query->where(
                    'branch_id',
                    $this->branchFilter
                );
            }

            /*
            |--------------------------------------------------------------------------
            | Search
            |--------------------------------------------------------------------------
            */

            if (trim($this->search) !== '') {
                $search = trim($this->search);

                $query->where(function ($q) use ($search) {
                    $q->where(
                        'kot_number',
                        'like',
                        '%'.$search.'%'
                    )
                        ->orWhereHas(
                            'order',
                            function ($orderQuery) use ($search) {
                                $orderQuery->where(
                                    'order_number',
                                    'like',
                                    '%'.$search.'%'
                                );
                            }
                        );
                });
            }

            $kots = $query
                ->latest()
                ->take(50)
                ->get();
        }

        $counts = [
            'new' => 0,
            'preparing' => 0,
            'ready' => 0,
        ];

        if ($restaurantId) {
            $countQuery = Kot::where(
                'restaurant_id',
                $restaurantId
            );

            $counts['new'] = (clone $countQuery)
                ->where('status', 'new')
                ->count();

            $counts['preparing'] = (clone $countQuery)
                ->where('status', 'preparing')
                ->count();

            $counts['ready'] = (clone $countQuery)
                ->where('status', 'ready')
                ->count();
        }

        return $this->view([
            'branches' => $branches,
            'kots' => $kots,
            'counts' => $counts,
        ])->layout('layouts.app');
    }
};
