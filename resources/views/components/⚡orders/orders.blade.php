<div class="min-h-screen bg-gray-50">

    <div class="mx-auto max-w-7xl px-4 py-6">

        {{-- Header --}}
        <div class="mb-6 flex flex-col gap-4 md:flex-row md:items-center md:justify-between">

            <div>
                <h1 class="text-2xl font-bold text-gray-900">
                    Orders
                </h1>

                <p class="text-sm text-gray-500">
                    Manage restaurant orders
                </p>
            </div>

            <a
                href="{{ route('pos') }}"
                wire:navigate
                class="inline-flex items-center justify-center rounded-lg bg-gray-900 px-4 py-2.5 text-sm font-semibold text-white hover:bg-gray-800"
            >
                + New Order
            </a>

        </div>

        @if (session('success'))
            <div class="mb-6 rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700">
                {{ session('success') }}
            </div>
        @endif

        {{-- Filters --}}
        <div class="mb-6 rounded-2xl border border-gray-200 bg-white p-4 shadow-sm">

            <div class="grid grid-cols-1 gap-3 md:grid-cols-3">

                <input
                    type="text"
                    wire:model.live.debounce.300ms="search"
                    placeholder="Search order, table or branch..."
                    class="rounded-lg border-gray-300 text-sm"
                >

                <select
                    wire:model.live="statusFilter"
                    class="rounded-lg border-gray-300 text-sm"
                >
                    <option value="">
                        All Statuses
                    </option>

                    <option value="pending">
                        Pending
                    </option>

                    <option value="preparing">
                        Preparing
                    </option>

                    <option value="ready">
                        Ready
                    </option>

                    <option value="served">
                        Served
                    </option>

                    <option value="completed">
                        Completed
                    </option>

                    <option value="cancelled">
                        Cancelled
                    </option>
                </select>

                <select
                    wire:model.live="orderTypeFilter"
                    class="rounded-lg border-gray-300 text-sm"
                >
                    <option value="">
                        All Order Types
                    </option>

                    <option value="dine_in">
                        Dine In
                    </option>

                    <option value="takeaway">
                        Takeaway
                    </option>
                </select>

            </div>

        </div>

        {{-- Orders --}}
        <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">

            <div class="overflow-x-auto">

                <table class="min-w-full divide-y divide-gray-200">

                    <thead class="bg-gray-50">

                        <tr>

                            <th class="px-5 py-3 text-left text-xs font-semibold uppercase text-gray-500">
                                Order
                            </th>

                            <th class="px-5 py-3 text-left text-xs font-semibold uppercase text-gray-500">
                                Branch
                            </th>

                            <th class="px-5 py-3 text-left text-xs font-semibold uppercase text-gray-500">
                                Type
                            </th>

                            <th class="px-5 py-3 text-left text-xs font-semibold uppercase text-gray-500">
                                Items
                            </th>

                            <th class="px-5 py-3 text-left text-xs font-semibold uppercase text-gray-500">
                                Total
                            </th>

                            <th class="px-5 py-3 text-left text-xs font-semibold uppercase text-gray-500">
                                Status
                            </th>

                            <th class="px-5 py-3 text-right text-xs font-semibold uppercase text-gray-500">
                                Action
                            </th>

                        </tr>

                    </thead>

                    <tbody class="divide-y divide-gray-100">

                        @forelse ($orders as $order)

                            <tr class="hover:bg-gray-50">

                                <td class="px-5 py-4">

                                    <button
                                        type="button"
                                        wire:click="viewOrder({{ $order->id }})"
                                        class="font-semibold text-gray-900 hover:underline"
                                    >
                                        {{ $order->order_number }}
                                    </button>

                                    <p class="mt-1 text-xs text-gray-500">
                                        {{ $order->created_at->format('d M Y, h:i A') }}
                                    </p>

                                </td>

                                <td class="px-5 py-4 text-sm text-gray-700">
                                    {{ $order->branch?->name }}

                                    @if ($order->table)
                                        <div class="text-xs text-gray-400">
                                            Table {{ $order->table->name }}
                                        </div>
                                    @endif
                                </td>

                                <td class="px-5 py-4">

                                    @if ($order->order_type === 'dine_in')
                                        <span class="rounded-full bg-blue-50 px-2.5 py-1 text-xs font-semibold text-blue-700">
                                            Dine In
                                        </span>
                                    @else
                                        <span class="rounded-full bg-purple-50 px-2.5 py-1 text-xs font-semibold text-purple-700">
                                            Takeaway
                                        </span>
                                    @endif

                                </td>

                                <td class="px-5 py-4 text-sm text-gray-700">
                                    {{ $order->items->sum('quantity') }}
                                </td>

                                <td class="px-5 py-4 font-semibold text-gray-900">
                                    ₹{{ number_format($order->grand_total, 2) }}
                                </td>

                                <td class="px-5 py-4">

                                    <select
                                        wire:change="updateStatus({{ $order->id }}, $event.target.value)"
                                        class="rounded-lg border-gray-200 bg-white text-xs font-semibold"
                                    >

                                        <option
                                            value="pending"
                                            @selected($order->status === 'pending')
                                        >
                                            Pending
                                        </option>

                                        <option
                                            value="preparing"
                                            @selected($order->status === 'preparing')
                                        >
                                            Preparing
                                        </option>

                                        <option
                                            value="ready"
                                            @selected($order->status === 'ready')
                                        >
                                            Ready
                                        </option>

                                        <option
                                            value="served"
                                            @selected($order->status === 'served')
                                        >
                                            Served
                                        </option>

                                        <option
                                            value="completed"
                                            @selected($order->status === 'completed')
                                        >
                                            Completed
                                        </option>

                                        <option
                                            value="cancelled"
                                            @selected($order->status === 'cancelled')
                                        >
                                            Cancelled
                                        </option>

                                    </select>

                                </td>

                                <td class="px-5 py-4 text-right">

                                    <button
                                        type="button"
                                        wire:click="viewOrder({{ $order->id }})"
                                        class="text-sm font-semibold text-gray-700 hover:text-gray-900"
                                    >
                                        View
                                    </button>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td
                                    colspan="7"
                                    class="px-5 py-12 text-center"
                                >
                                    <div class="text-4xl">
                                        📋
                                    </div>

                                    <p class="mt-3 font-semibold text-gray-700">
                                        No orders found
                                    </p>

                                    <p class="mt-1 text-sm text-gray-500">
                                        Create your first order from POS.
                                    </p>

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

            @if ($orders->hasPages())
                <div class="border-t border-gray-200 px-5 py-4">
                    {{ $orders->links() }}
                </div>
            @endif

        </div>

    </div>

    {{-- ORDER DETAIL MODAL --}}
    @if ($selectedOrder)

        <div class="fixed inset-0 z-50 overflow-y-auto">

            <div
                class="fixed inset-0 bg-black/40"
                wire:click="closeOrder"
            ></div>

            <div class="relative mx-auto my-10 w-full max-w-2xl px-4">

                <div class="relative overflow-hidden rounded-2xl bg-white shadow-xl">

                    {{-- Modal Header --}}
                    <div class="flex items-center justify-between border-b border-gray-200 px-6 py-4">

                        <div>

                            <h2 class="text-lg font-bold text-gray-900">
                                {{ $selectedOrder->order_number }}
                            </h2>

                            <p class="text-xs text-gray-500">
                                {{ $selectedOrder->created_at->format('d M Y, h:i A') }}
                            </p>

                        </div>

                        <button
                            type="button"
                            wire:click="closeOrder"
                            class="rounded-lg p-2 text-gray-500 hover:bg-gray-100"
                        >
                            ✕
                        </button>

                    </div>

                    {{-- Order Info --}}
                    <div class="grid grid-cols-2 gap-4 border-b border-gray-100 p-6 md:grid-cols-4">

                        <div>
                            <p class="text-xs text-gray-500">
                                Branch
                            </p>

                            <p class="mt-1 font-semibold">
                                {{ $selectedOrder->branch?->name }}
                            </p>
                        </div>

                        <div>
                            <p class="text-xs text-gray-500">
                                Type
                            </p>

                            <p class="mt-1 font-semibold">
                                {{ $selectedOrder->order_type === 'dine_in' ? 'Dine In' : 'Takeaway' }}
                            </p>
                        </div>

                        <div>
                            <p class="text-xs text-gray-500">
                                Table
                            </p>

                            <p class="mt-1 font-semibold">
                                {{ $selectedOrder->table?->name ?? '—' }}
                            </p>
                        </div>

                        <div>
                            <p class="text-xs text-gray-500">
                                Status
                            </p>

                            <p class="mt-1 font-semibold capitalize">
                                {{ $selectedOrder->status }}
                            </p>
                        </div>

                    </div>

                    {{-- Items --}}
                    <div class="max-h-80 overflow-y-auto p-6">

                        <h3 class="mb-3 font-bold text-gray-900">
                            Order Items
                        </h3>

                        <div class="space-y-3">

                            @foreach ($selectedOrder->items as $item)

                                <div class="flex items-center justify-between rounded-xl bg-gray-50 p-3">

                                    <div>

                                        <p class="font-semibold text-gray-900">
                                            {{ $item->item_name }}
                                        </p>

                                        <p class="text-xs text-gray-500">
                                            {{ $item->quantity }}
                                            ×
                                            ₹{{ number_format($item->unit_price, 2) }}
                                        </p>

                                    </div>

                                    <p class="font-bold text-gray-900">
                                        ₹{{ number_format($item->total, 2) }}
                                    </p>

                                </div>

                            @endforeach

                        </div>

                    </div>

                    {{-- Totals --}}
                    <div class="border-t border-gray-200 p-6">

                        <div class="ml-auto max-w-xs space-y-2">

                            <div class="flex justify-between text-sm">
                                <span class="text-gray-500">
                                    Subtotal
                                </span>

                                <span>
                                    ₹{{ number_format($selectedOrder->subtotal, 2) }}
                                </span>
                            </div>

                            <div class="flex justify-between text-sm">
                                <span class="text-gray-500">
                                    Discount
                                </span>

                                <span>
                                    ₹{{ number_format($selectedOrder->discount, 2) }}
                                </span>
                            </div>

                            <div class="flex justify-between text-sm">
                                <span class="text-gray-500">
                                    Tax
                                </span>

                                <span>
                                    ₹{{ number_format($selectedOrder->tax, 2) }}
                                </span>
                            </div>

                            <div class="flex justify-between border-t border-gray-200 pt-3 text-lg font-bold">
                                <span>
                                    Grand Total
                                </span>

                                <span>
                                    ₹{{ number_format($selectedOrder->grand_total, 2) }}
                                </span>
                            </div>

                        </div>

                        @if ($selectedOrder->notes)

                            <div class="mt-5 rounded-xl bg-yellow-50 p-4">

                                <p class="text-xs font-semibold text-yellow-800">
                                    Notes
                                </p>

                                <p class="mt-1 text-sm text-yellow-700">
                                    {{ $selectedOrder->notes }}
                                </p>

                            </div>

                        @endif

                    </div>

                </div>

            </div>

        </div>

    @endif

</div>