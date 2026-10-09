
<div class="min-h-screen bg-gray-50">
    <div class="mx-auto max-w-7xl space-y-6 px-4 py-6">

        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">
                    Reports & Analytics
                </h1>
                <p class="mt-1 text-sm text-gray-500">
                    Track sales, orders and your best-selling menu items.
                </p>
            </div>

            <button
                wire:click="exportCsv"
                class="rounded-lg bg-gray-900 px-4 py-2.5 text-sm font-semibold text-white hover:bg-gray-700"
            >
                Export CSV
            </button>
        </div>

        {{-- Filters --}}
        <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">
            <div class="grid grid-cols-1 gap-4 md:grid-cols-4">
                <div>
                    <label class="mb-1 block text-sm font-medium text-gray-700">
                        Start date
                    </label>
                    <input
                        type="date"
                        wire:model="startDate"
                        class="w-full rounded-lg border-gray-300 text-sm"
                    />
                </div>

                <div>
                    <label class="mb-1 block text-sm font-medium text-gray-700">
                        End date
                    </label>
                    <input
                        type="date"
                        wire:model="endDate"
                        class="w-full rounded-lg border-gray-300 text-sm"
                    />
                </div>

                <div>
                    <label class="mb-1 block text-sm font-medium text-gray-700">
                        Branch
                    </label>
                    <select
                        wire:model="branchId"
                        class="w-full rounded-lg border-gray-300 text-sm"
                    >
                        <option value="">All branches</option>
                        @foreach ($branches as $branch)
                            <option value="{{ $branch->id }}">
                                {{ $branch->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="flex items-end gap-2">
                    <button
                        wire:click="$refresh"
                        class="flex-1 rounded-lg bg-indigo-600 px-4 py-2.5 text-sm font-semibold text-white hover:bg-indigo-700"
                    >
                        Apply filters
                    </button>
                    <button
                        wire:click="resetFilters"
                        class="rounded-lg border border-gray-300 px-4 py-2.5 text-sm font-semibold text-gray-700 hover:bg-gray-50"
                    >
                        Reset
                    </button>
                </div>
            </div>
        </div>

        {{-- Summary cards --}}
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">
            <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">
                <p class="text-sm text-gray-500">Net recorded sales</p>
                <p class="mt-2 text-2xl font-bold text-gray-900">
                    ₹{{ number_format($totalSales, 2) }}
                </p>
                <p class="mt-1 text-xs text-gray-500">Excludes cancelled orders</p>
            </div>

            <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">
                <p class="text-sm text-gray-500">Non-cancelled orders</p>
                <p class="mt-2 text-2xl font-bold text-gray-900">
                    {{ number_format($totalOrders) }}
                </p>
                <p class="mt-1 text-xs text-gray-500">Orders in selected period</p>
            </div>

            <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">
                <p class="text-sm text-gray-500">Average order value</p>
                <p class="mt-2 text-2xl font-bold text-gray-900">
                    ₹{{ number_format($averageOrderValue, 2) }}
                </p>
                <p class="mt-1 text-xs text-gray-500">Sales divided by orders</p>
            </div>

            <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">
                <p class="text-sm text-gray-500">Completed orders</p>
                <p class="mt-2 text-2xl font-bold text-gray-900">
                    {{ number_format($completedOrders) }}
                </p>
                <p class="mt-1 text-xs text-gray-500">
                    Cancelled: {{ number_format($cancelledOrders) }}
                </p>
            </div>
        </div>

        {{-- Daily sales chart --}}
        <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">
            <div class="mb-5">
                <h2 class="text-lg font-bold text-gray-900">Daily sales</h2>
                <p class="text-sm text-gray-500">
                    Revenue by order date, excluding cancelled orders
                </p>
            </div>

            @if ($chart->isEmpty())
                <p class="py-10 text-center text-sm text-gray-500">
                    No sales data for this period.
                </p>
            @else
                <div class="flex h-64 items-end gap-2 overflow-x-auto border-b border-gray-200 pb-2">
                    @foreach ($chart as $day)
                        <div
                            class="flex h-full min-w-8 flex-1 flex-col items-center justify-end gap-2"
                            title="{{ $day['date'] }}: ₹{{ number_format($day['revenue'], 2) }} ({{ $day['orders'] }} orders)"
                        >
                            <div class="text-center text-xs text-gray-500">
                                @if ($day['revenue'] > 0)
                                    ₹{{ number_format($day['revenue'], 0) }}
                                @endif
                            </div>
                            <div
                                class="w-full max-w-12 rounded-t-md bg-indigo-500 hover:bg-indigo-600"
                                style="height: {{ $day['revenue'] > 0 ? max(3, ($day['revenue'] / $maxRevenue) * 150) : 2 }}px"
                            ></div>
                            <span class="whitespace-nowrap text-[10px] text-gray-500">
                                {{ $day['label'] }}
                            </span>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        {{-- Status breakdown --}}
        <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">
            <h2 class="mb-4 text-lg font-bold text-gray-900">Order status breakdown</h2>

            <div class="grid grid-cols-2 gap-3 sm:grid-cols-3 lg:grid-cols-6">
                @foreach (['pending', 'preparing', 'ready', 'served', 'completed', 'cancelled'] as $status)
                    <div class="rounded-xl bg-gray-50 p-4">
                        <p class="text-sm capitalize text-gray-500">{{ $status }}</p>
                        <p class="mt-1 text-2xl font-bold text-gray-900">
                            {{ number_format($statusCounts[$status] ?? 0) }}
                        </p>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Top items --}}
        <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">
            <div class="border-b border-gray-100 p-5">
                <h2 class="text-lg font-bold text-gray-900">Top-selling items</h2>
                <p class="text-sm text-gray-500">
                    Ranked by quantity sold
                </p>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead class="bg-gray-50 text-gray-500">
                        <tr>
                            <th class="px-5 py-3 font-medium">#</th>
                            <th class="px-5 py-3 font-medium">Item</th>
                            <th class="px-5 py-3 text-right font-medium">Quantity sold</th>
                            <th class="px-5 py-3 text-right font-medium">Sales</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse ($topItems as $index => $item)
                            <tr>
                                <td class="px-5 py-3 text-gray-500">{{ $index + 1 }}</td>
                                <td class="px-5 py-3 font-medium text-gray-900">
                                    {{ $item->item_name }}
                                </td>
                                <td class="px-5 py-3 text-right">
                                    {{ number_format($item->quantity_sold) }}
                                </td>
                                <td class="px-5 py-3 text-right font-semibold">
                                    ₹{{ number_format($item->item_revenue, 2) }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-5 py-8 text-center text-gray-500">
                                    No item sales found for this period.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Recent orders --}}
        <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">
            <div class="border-b border-gray-100 p-5">
                <h2 class="text-lg font-bold text-gray-900">Recent orders in this report</h2>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead class="bg-gray-50 text-gray-500">
                        <tr>
                            <th class="px-5 py-3 font-medium">Order</th>
                            <th class="px-5 py-3 font-medium">Date</th>
                            <th class="px-5 py-3 font-medium">Branch</th>
                            <th class="px-5 py-3 font-medium">Status</th>
                            <th class="px-5 py-3 text-right font-medium">Total</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse ($recentOrders as $order)
                            <tr>
                                <td class="px-5 py-3 font-semibold text-gray-900">
                                    {{ $order->order_number }}
                                </td>
                                <td class="px-5 py-3 text-gray-600">
                                    {{ $order->created_at->format('d M Y, h:i A') }}
                                </td>
                                <td class="px-5 py-3 text-gray-600">
                                    {{ $order->branch?->name ?? '—' }}
                                </td>
                                <td class="px-5 py-3">
                                    <span class="rounded-full bg-gray-100 px-2.5 py-1 text-xs font-medium capitalize text-gray-700">
                                        {{ $order->status }}
                                    </span>
                                </td>
                                <td class="px-5 py-3 text-right font-semibold">
                                    ₹{{ number_format($order->grand_total, 2) }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-5 py-8 text-center text-gray-500">
                                    No orders found for this period.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>
