<div class="min-h-screen bg-slate-50 px-4 py-6 sm:px-6 lg:px-8">

    <div class="mx-auto max-w-7xl">

        {{-- Header --}}
        <div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

            <div>
                <h1 class="text-3xl font-black tracking-tight text-slate-900">
                    Billing
                </h1>

                <p class="mt-1 text-sm text-slate-500">
                    Manage bills, payments and invoices.
                </p>
            </div>

            <div class="rounded-2xl bg-white px-5 py-3 shadow-sm ring-1 ring-slate-200">
                <p class="text-xs font-semibold uppercase tracking-wider text-slate-400">
                    Payment Flow
                </p>

                <p class="mt-1 text-sm font-bold text-slate-700">
                    Order → Bill → Payment
                </p>
            </div>

        </div>


        {{-- Flash --}}
        @if (session()->has('success'))
            <div class="mb-6 rounded-2xl border border-emerald-200 bg-emerald-50 px-5 py-4 text-sm font-semibold text-emerald-700">
                ✓ {{ session('success') }}
            </div>
        @endif


        {{-- Filters --}}
        <div class="mb-6 rounded-3xl bg-white p-5 shadow-sm ring-1 ring-slate-200">

            <div class="grid gap-4 md:grid-cols-3">

                <div class="md:col-span-2">
                    <label class="mb-2 block text-sm font-bold text-slate-700">
                        Search
                    </label>

                    <input
                        type="text"
                        wire:model.live.debounce.300ms="search"
                        placeholder="Search bill or order number..."
                        class="w-full rounded-2xl border-slate-200 px-4 py-3 text-sm outline-none transition focus:border-orange-400 focus:ring-orange-200"
                    >
                </div>

                <div>
                    <label class="mb-2 block text-sm font-bold text-slate-700">
                        Payment Status
                    </label>

                    <select
                        wire:model.live="statusFilter"
                        class="w-full rounded-2xl border-slate-200 px-4 py-3 text-sm font-semibold outline-none focus:border-orange-400 focus:ring-orange-200"
                    >
                        <option value="unpaid">Unpaid</option>
                        <option value="partial">Partial</option>
                        <option value="paid">Paid</option>
                        <option value="all">All Bills</option>
                    </select>
                </div>

            </div>

        </div>


        {{-- Bills --}}
        <div class="overflow-hidden rounded-3xl bg-white shadow-sm ring-1 ring-slate-200">

            <div class="overflow-x-auto">

                <table class="w-full min-w-[900px]">

                    <thead class="bg-slate-50">
                        <tr class="border-b border-slate-200">

                            <th class="px-6 py-4 text-left text-xs font-black uppercase tracking-wider text-slate-400">
                                Bill
                            </th>

                            <th class="px-6 py-4 text-left text-xs font-black uppercase tracking-wider text-slate-400">
                                Order
                            </th>

                            <th class="px-6 py-4 text-left text-xs font-black uppercase tracking-wider text-slate-400">
                                Type
                            </th>

                            <th class="px-6 py-4 text-right text-xs font-black uppercase tracking-wider text-slate-400">
                                Total
                            </th>

                            <th class="px-6 py-4 text-right text-xs font-black uppercase tracking-wider text-slate-400">
                                Paid
                            </th>

                            <th class="px-6 py-4 text-center text-xs font-black uppercase tracking-wider text-slate-400">
                                Status
                            </th>

                            <th class="px-6 py-4 text-right text-xs font-black uppercase tracking-wider text-slate-400">
                                Action
                            </th>

                        </tr>
                    </thead>

                    <tbody class="divide-y divide-slate-100">

                        @forelse ($bills as $bill)

                            @php
                                $paid = (float) $bill->payments->sum('amount');
                                $remaining = max(
                                    0,
                                    (float) $bill->grand_total - $paid
                                );
                            @endphp

                            <tr class="transition hover:bg-slate-50">

                                <td class="px-6 py-5">

                                    <p class="font-black text-slate-900">
                                        {{ $bill->bill_number }}
                                    </p>

                                    <p class="mt-1 text-xs text-slate-400">
                                        {{ $bill->created_at->format('d M Y, h:i A') }}
                                    </p>

                                </td>


                                <td class="px-6 py-5">

                                    <p class="font-bold text-slate-700">
                                        {{ $bill->order->order_number }}
                                    </p>

                                    @if ($bill->order->branch)
                                        <p class="mt-1 text-xs text-slate-400">
                                            {{ $bill->order->branch->name }}
                                        </p>
                                    @endif

                                </td>


                                <td class="px-6 py-5">

                                    @if ($bill->order->order_type === 'dine_in')

                                        <span class="rounded-full bg-blue-50 px-3 py-1 text-xs font-bold text-blue-600">
                                            Dine In
                                        </span>

                                        @if ($bill->order->table)
                                            <p class="mt-2 text-xs font-semibold text-slate-500">
                                                Table {{ $bill->order->table->name }}
                                            </p>
                                        @endif

                                    @else

                                        <span class="rounded-full bg-purple-50 px-3 py-1 text-xs font-bold text-purple-600">
                                            Takeaway
                                        </span>

                                    @endif

                                </td>


                                <td class="px-6 py-5 text-right">

                                    <p class="font-black text-slate-900">
                                        ₹{{ number_format((float) $bill->grand_total, 2) }}
                                    </p>

                                </td>


                                <td class="px-6 py-5 text-right">

                                    <p class="font-bold text-emerald-600">
                                        ₹{{ number_format($paid, 2) }}
                                    </p>

                                    @if ($remaining > 0)
                                        <p class="mt-1 text-xs font-semibold text-orange-500">
                                            Due ₹{{ number_format($remaining, 2) }}
                                        </p>
                                    @endif

                                </td>


                                <td class="px-6 py-5 text-center">

                                    @if ($bill->payment_status === 'paid')

                                        <span class="rounded-full bg-emerald-50 px-3 py-1.5 text-xs font-black text-emerald-600">
                                            ✓ Paid
                                        </span>

                                    @elseif ($bill->payment_status === 'partial')

                                        <span class="rounded-full bg-amber-50 px-3 py-1.5 text-xs font-black text-amber-600">
                                            Partial
                                        </span>

                                    @else

                                        <span class="rounded-full bg-red-50 px-3 py-1.5 text-xs font-black text-red-600">
                                            Unpaid
                                        </span>

                                    @endif

                                </td>


                                <td class="px-6 py-5 text-right">

                                    <div class="flex justify-end gap-2">

                                        <button
                                            wire:click="openBill({{ $bill->id }})"
                                            class="rounded-xl bg-slate-100 px-4 py-2 text-xs font-black text-slate-700 transition hover:bg-slate-200"
                                        >
                                            View
                                        </button>

                                        @if ($bill->payment_status !== 'paid')

                                            <button
                                                wire:click="openPayment({{ $bill->id }})"
                                                class="rounded-xl bg-orange-500 px-4 py-2 text-xs font-black text-white shadow-sm transition hover:bg-orange-600"
                                            >
                                                Pay
                                            </button>

                                        @else

                                            <button
                                                wire:click="openBill({{ $bill->id }})"
                                                class="rounded-xl bg-emerald-50 px-4 py-2 text-xs font-black text-emerald-700"
                                            >
                                                Invoice
                                            </button>

                                        @endif

                                    </div>

                                </td>

                            </tr>

                        @empty

                            <tr>
                                <td colspan="7" class="px-6 py-16 text-center">

                                    <div class="mx-auto max-w-sm">

                                        <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-2xl bg-slate-100 text-3xl">
                                            🧾
                                        </div>

                                        <h3 class="mt-4 text-lg font-black text-slate-900">
                                            No bills found
                                        </h3>

                                        <p class="mt-2 text-sm text-slate-500">
                                            Served orders will automatically appear here.
                                        </p>

                                    </div>

                                </td>
                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>


            @if ($bills->hasPages())

                <div class="border-t border-slate-100 px-6 py-4">
                    {{ $bills->links() }}
                </div>

            @endif

        </div>

    </div>


    {{-- Payment Modal --}}
    @if ($showPaymentModal && $selectedBill)

        <div
            class="fixed inset-0 z-50 flex items-center justify-center bg-slate-950/60 p-4"
            wire:keydown.escape="closePayment"
        >

            <div class="w-full max-w-lg rounded-3xl bg-white shadow-2xl">

                <div class="border-b border-slate-100 px-6 py-5">

                    <div class="flex items-center justify-between">

                        <div>
                            <h2 class="text-xl font-black text-slate-900">
                                Receive Payment
                            </h2>

                            <p class="mt-1 text-xs font-semibold text-slate-400">
                                {{ $selectedBill->bill_number }}
                            </p>
                        </div>

                        <button
                            wire:click="closePayment"
                            class="flex h-9 w-9 items-center justify-center rounded-xl bg-slate-100 text-slate-500 hover:bg-slate-200"
                        >
                            ✕
                        </button>

                    </div>

                </div>


                <div class="space-y-5 p-6">

                    <div class="grid grid-cols-2 gap-3">

                        <div class="rounded-2xl bg-slate-50 p-4">
                            <p class="text-xs font-bold uppercase text-slate-400">
                                Bill Total
                            </p>

                            <p class="mt-1 text-xl font-black text-slate-900">
                                ₹{{ number_format((float) $selectedBill->grand_total, 2) }}
                            </p>
                        </div>

                        <div class="rounded-2xl bg-orange-50 p-4">
                            <p class="text-xs font-bold uppercase text-orange-500">
                                Remaining
                            </p>

                            <p class="mt-1 text-xl font-black text-orange-600">
                                ₹{{ number_format($selectedBill->remaining_amount, 2) }}
                            </p>
                        </div>

                    </div>


                    <div>
                        <label class="mb-2 block text-sm font-bold text-slate-700">
                            Payment Method
                        </label>

                        <select
                            wire:model="method"
                            class="w-full rounded-2xl border-slate-200 px-4 py-3 text-sm font-semibold"
                        >
                            <option value="cash">💵 Cash</option>
                            <option value="upi">📱 UPI</option>
                            <option value="card">💳 Card</option>
                            <option value="other">Other</option>
                        </select>
                    </div>


                    <div>
                        <label class="mb-2 block text-sm font-bold text-slate-700">
                            Amount
                        </label>

                        <input
                            type="number"
                            step="0.01"
                            min="0.01"
                            wire:model="paymentAmount"
                            class="w-full rounded-2xl border-slate-200 px-4 py-3 text-lg font-black"
                        >

                        @error('paymentAmount')
                            <p class="mt-2 text-xs font-semibold text-red-500">
                                {{ $message }}
                            </p>
                        @enderror

                    </div>


                    <div>
                        <label class="mb-2 block text-sm font-bold text-slate-700">
                            Reference <span class="font-normal text-slate-400">(optional)</span>
                        </label>

                        <input
                            type="text"
                            wire:model="reference"
                            placeholder="UPI transaction ID / reference"
                            class="w-full rounded-2xl border-slate-200 px-4 py-3 text-sm"
                        >
                    </div>


                    <div>
                        <label class="mb-2 block text-sm font-bold text-slate-700">
                            Notes
                        </label>

                        <textarea
                            wire:model="paymentNotes"
                            rows="2"
                            placeholder="Payment notes..."
                            class="w-full rounded-2xl border-slate-200 px-4 py-3 text-sm"
                        ></textarea>
                    </div>


                    <div class="flex gap-3 pt-2">

                        <button
                            wire:click="closePayment"
                            class="flex-1 rounded-2xl bg-slate-100 px-5 py-3 text-sm font-black text-slate-700 hover:bg-slate-200"
                        >
                            Cancel
                        </button>

                        <button
                            wire:click="makePayment"
                            wire:loading.attr="disabled"
                            class="flex-1 rounded-2xl bg-orange-500 px-5 py-3 text-sm font-black text-white hover:bg-orange-600 disabled:opacity-50"
                        >
                            <span wire:loading.remove>
                                Record Payment
                            </span>

                            <span wire:loading>
                                Processing...
                            </span>
                        </button>

                    </div>

                </div>

            </div>

        </div>

    @endif


    {{-- Invoice Modal --}}
    @if ($showBillModal && $selectedBill)

        <div class="fixed inset-0 z-50 overflow-y-auto bg-slate-950/60 p-4">

            <div class="mx-auto my-8 max-w-2xl rounded-3xl bg-white shadow-2xl">

                <div class="flex items-center justify-between border-b border-slate-100 px-6 py-5">

                    <div>
                        <h2 class="text-xl font-black text-slate-900">
                            Invoice
                        </h2>

                        <p class="mt-1 text-xs font-semibold text-slate-400">
                            {{ $selectedBill->bill_number }}
                        </p>
                    </div>

                    <button
                        wire:click="closeBill"
                        class="flex h-9 w-9 items-center justify-center rounded-xl bg-slate-100 text-slate-500 hover:bg-slate-200"
                    >
                        ✕
                    </button>

                </div>


                <div class="p-8">

                    {{-- Invoice Header --}}
                    <div class="flex flex-col gap-4 border-b border-slate-200 pb-6 sm:flex-row sm:items-start sm:justify-between">

                        <div>
                            <h3 class="text-2xl font-black text-slate-900">
                                Restaurant Invoice
                            </h3>

                            <p class="mt-1 text-sm text-slate-500">
                                {{ $selectedBill->order->branch->name ?? 'Restaurant' }}
                            </p>
                        </div>

                        <div class="text-left sm:text-right">

                            <p class="text-sm font-bold text-slate-500">
                                Invoice
                            </p>

                            <p class="text-lg font-black text-slate-900">
                                {{ $selectedBill->bill_number }}
                            </p>

                            <p class="mt-1 text-xs text-slate-400">
                                {{ $selectedBill->created_at->format('d M Y, h:i A') }}
                            </p>

                        </div>

                    </div>


                    {{-- Order Information --}}
                    <div class="grid grid-cols-2 gap-4 border-b border-slate-200 py-6">

                        <div>
                            <p class="text-xs font-bold uppercase text-slate-400">
                                Order
                            </p>

                            <p class="mt-1 font-black text-slate-800">
                                {{ $selectedBill->order->order_number }}
                            </p>
                        </div>

                        <div>
                            <p class="text-xs font-bold uppercase text-slate-400">
                                Order Type
                            </p>

                            <p class="mt-1 font-black text-slate-800">
                                {{ $selectedBill->order->order_type === 'dine_in' ? 'Dine In' : 'Takeaway' }}
                            </p>
                        </div>

                    </div>


                    {{-- Items --}}
                    <div class="py-6">

                        <div class="mb-3 grid grid-cols-12 gap-2 border-b border-slate-200 pb-3 text-xs font-black uppercase text-slate-400">

                            <div class="col-span-6">
                                Item
                            </div>

                            <div class="col-span-2 text-center">
                                Qty
                            </div>

                            <div class="col-span-2 text-right">
                                Price
                            </div>

                            <div class="col-span-2 text-right">
                                Total
                            </div>

                        </div>


                        <div class="space-y-3">

                            @foreach ($selectedBill->order->items as $item)

                                <div class="grid grid-cols-12 gap-2 text-sm">

                                    <div class="col-span-6 font-bold text-slate-700">
                                        {{ $item->item_name }}
                                    </div>

                                    <div class="col-span-2 text-center text-slate-500">
                                        {{ $item->quantity }}
                                    </div>

                                    <div class="col-span-2 text-right text-slate-500">
                                        ₹{{ number_format((float) $item->unit_price, 2) }}
                                    </div>

                                    <div class="col-span-2 text-right font-bold text-slate-800">
                                        ₹{{ number_format((float) $item->total, 2) }}
                                    </div>

                                </div>

                            @endforeach

                        </div>

                    </div>


                    {{-- Totals --}}
                    <div class="border-t border-slate-200 pt-5">

                        <div class="ml-auto max-w-sm space-y-3">

                            <div class="flex justify-between text-sm">
                                <span class="text-slate-500">
                                    Subtotal
                                </span>

                                <span class="font-bold text-slate-800">
                                    ₹{{ number_format((float) $selectedBill->subtotal, 2) }}
                                </span>
                            </div>


                            <div class="flex justify-between text-sm">
                                <span class="text-slate-500">
                                    Discount
                                </span>

                                <span class="font-bold text-red-500">
                                    - ₹{{ number_format((float) $selectedBill->discount, 2) }}
                                </span>
                            </div>


                            <div class="flex justify-between text-sm">
                                <span class="text-slate-500">
                                    Tax
                                </span>

                                <span class="font-bold text-slate-800">
                                    ₹{{ number_format((float) $selectedBill->tax, 2) }}
                                </span>
                            </div>


                            <div class="flex justify-between border-t border-slate-200 pt-3">

                                <span class="text-base font-black text-slate-900">
                                    Grand Total
                                </span>

                                <span class="text-xl font-black text-orange-600">
                                    ₹{{ number_format((float) $selectedBill->grand_total, 2) }}
                                </span>

                            </div>

                        </div>

                    </div>


                    {{-- Payments --}}
                    <div class="mt-8 rounded-2xl bg-slate-50 p-5">

                        <h4 class="font-black text-slate-900">
                            Payments
                        </h4>

                        <div class="mt-4 space-y-3">

                            @forelse ($selectedBill->payments as $payment)

                                <div class="flex items-center justify-between">

                                    <div>

                                        <p class="font-bold capitalize text-slate-700">
                                            {{ $payment->method }}
                                        </p>

                                        @if ($payment->reference)
                                            <p class="text-xs text-slate-400">
                                                Ref: {{ $payment->reference }}
                                            </p>
                                        @endif

                                    </div>

                                    <p class="font-black text-emerald-600">
                                        ₹{{ number_format((float) $payment->amount, 2) }}
                                    </p>

                                </div>

                            @empty

                                <p class="text-sm text-slate-400">
                                    No payment received yet.
                                </p>

                            @endforelse

                        </div>

                    </div>


                    <div class="mt-6 flex items-center justify-between rounded-2xl border border-slate-200 p-5">

                        <span class="font-bold text-slate-600">
                            Payment Status
                        </span>

                        @if ($selectedBill->payment_status === 'paid')

                            <span class="rounded-full bg-emerald-50 px-4 py-2 text-xs font-black text-emerald-600">
                                ✓ PAID
                            </span>

                        @elseif ($selectedBill->payment_status === 'partial')

                            <span class="rounded-full bg-amber-50 px-4 py-2 text-xs font-black text-amber-600">
                                PARTIAL
                            </span>

                        @else

                            <span class="rounded-full bg-red-50 px-4 py-2 text-xs font-black text-red-600">
                                UNPAID
                            </span>

                        @endif

                    </div>


                    @if ($selectedBill->remaining_amount > 0)

                        <div class="mt-4 flex items-center justify-between rounded-2xl bg-orange-50 p-5">

                            <span class="font-bold text-orange-700">
                                Remaining Amount
                            </span>

                            <span class="text-xl font-black text-orange-600">
                                ₹{{ number_format($selectedBill->remaining_amount, 2) }}
                            </span>

                        </div>

                    @endif

                </div>

            </div>

        </div>

    @endif

</div>