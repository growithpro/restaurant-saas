<div class="min-h-screen bg-slate-50 px-4 py-6 sm:px-6 lg:px-8">

    <div class="mx-auto max-w-7xl">

        
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


        
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session()->has('success')): ?>
            <div class="mb-6 rounded-2xl border border-emerald-200 bg-emerald-50 px-5 py-4 text-sm font-semibold text-emerald-700">
                ✓ <?php echo e(session('success')); ?>

            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>


        
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

                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $bills; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $bill): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>

                            <?php
                                $paid = (float) $bill->payments->sum('amount');
                                $remaining = max(
                                    0,
                                    (float) $bill->grand_total - $paid
                                );
                            ?>

                            <tr class="transition hover:bg-slate-50">

                                <td class="px-6 py-5">

                                    <p class="font-black text-slate-900">
                                        <?php echo e($bill->bill_number); ?>

                                    </p>

                                    <p class="mt-1 text-xs text-slate-400">
                                        <?php echo e($bill->created_at->format('d M Y, h:i A')); ?>

                                    </p>

                                </td>


                                <td class="px-6 py-5">

                                    <p class="font-bold text-slate-700">
                                        <?php echo e($bill->order->order_number); ?>

                                    </p>

                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($bill->order->branch): ?>
                                        <p class="mt-1 text-xs text-slate-400">
                                            <?php echo e($bill->order->branch->name); ?>

                                        </p>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                                </td>


                                <td class="px-6 py-5">

                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($bill->order->order_type === 'dine_in'): ?>

                                        <span class="rounded-full bg-blue-50 px-3 py-1 text-xs font-bold text-blue-600">
                                            Dine In
                                        </span>

                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($bill->order->table): ?>
                                            <p class="mt-2 text-xs font-semibold text-slate-500">
                                                Table <?php echo e($bill->order->table->name); ?>

                                            </p>
                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                                    <?php else: ?>

                                        <span class="rounded-full bg-purple-50 px-3 py-1 text-xs font-bold text-purple-600">
                                            Takeaway
                                        </span>

                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                                </td>


                                <td class="px-6 py-5 text-right">

                                    <p class="font-black text-slate-900">
                                        ₹<?php echo e(number_format((float) $bill->grand_total, 2)); ?>

                                    </p>

                                </td>


                                <td class="px-6 py-5 text-right">

                                    <p class="font-bold text-emerald-600">
                                        ₹<?php echo e(number_format($paid, 2)); ?>

                                    </p>

                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($remaining > 0): ?>
                                        <p class="mt-1 text-xs font-semibold text-orange-500">
                                            Due ₹<?php echo e(number_format($remaining, 2)); ?>

                                        </p>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                                </td>


                                <td class="px-6 py-5 text-center">

                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($bill->payment_status === 'paid'): ?>

                                        <span class="rounded-full bg-emerald-50 px-3 py-1.5 text-xs font-black text-emerald-600">
                                            ✓ Paid
                                        </span>

                                    <?php elseif($bill->payment_status === 'partial'): ?>

                                        <span class="rounded-full bg-amber-50 px-3 py-1.5 text-xs font-black text-amber-600">
                                            Partial
                                        </span>

                                    <?php else: ?>

                                        <span class="rounded-full bg-red-50 px-3 py-1.5 text-xs font-black text-red-600">
                                            Unpaid
                                        </span>

                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                                </td>


                                <td class="px-6 py-5 text-right">

                                    <div class="flex justify-end gap-2">

                                        <button
                                            wire:click="openBill(<?php echo e($bill->id); ?>)"
                                            class="rounded-xl bg-slate-100 px-4 py-2 text-xs font-black text-slate-700 transition hover:bg-slate-200"
                                        >
                                            View
                                        </button>

                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($bill->payment_status !== 'paid'): ?>

                                            <button
                                                wire:click="openPayment(<?php echo e($bill->id); ?>)"
                                                class="rounded-xl bg-orange-500 px-4 py-2 text-xs font-black text-white shadow-sm transition hover:bg-orange-600"
                                            >
                                                Pay
                                            </button>

                                        <?php else: ?>

                                            <button
                                                wire:click="openBill(<?php echo e($bill->id); ?>)"
                                                class="rounded-xl bg-emerald-50 px-4 py-2 text-xs font-black text-emerald-700"
                                            >
                                                Invoice
                                            </button>

                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                                    </div>

                                </td>

                            </tr>

                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>

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

                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                    </tbody>

                </table>

            </div>


            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($bills->hasPages()): ?>

                <div class="border-t border-slate-100 px-6 py-4">
                    <?php echo e($bills->links()); ?>

                </div>

            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

        </div>

    </div>


    
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($showPaymentModal && $selectedBill): ?>

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
                                <?php echo e($selectedBill->bill_number); ?>

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
                                ₹<?php echo e(number_format((float) $selectedBill->grand_total, 2)); ?>

                            </p>
                        </div>

                        <div class="rounded-2xl bg-orange-50 p-4">
                            <p class="text-xs font-bold uppercase text-orange-500">
                                Remaining
                            </p>

                            <p class="mt-1 text-xl font-black text-orange-600">
                                ₹<?php echo e(number_format($selectedBill->remaining_amount, 2)); ?>

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

                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['paymentAmount'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="mt-2 text-xs font-semibold text-red-500">
                                <?php echo e($message); ?>

                            </p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

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

    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>


    
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($showBillModal && $selectedBill): ?>

        <div class="fixed inset-0 z-50 overflow-y-auto bg-slate-950/60 p-4">

            <div class="mx-auto my-8 max-w-2xl rounded-3xl bg-white shadow-2xl">

                <div class="flex items-center justify-between border-b border-slate-100 px-6 py-5">

                    <div>
                        <h2 class="text-xl font-black text-slate-900">
                            Invoice
                        </h2>

                        <p class="mt-1 text-xs font-semibold text-slate-400">
                            <?php echo e($selectedBill->bill_number); ?>

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

                    
                    <div class="flex flex-col gap-4 border-b border-slate-200 pb-6 sm:flex-row sm:items-start sm:justify-between">

                        <div>
                            <h3 class="text-2xl font-black text-slate-900">
                                Restaurant Invoice
                            </h3>

                            <p class="mt-1 text-sm text-slate-500">
                                <?php echo e($selectedBill->order->branch->name ?? 'Restaurant'); ?>

                            </p>
                        </div>

                        <div class="text-left sm:text-right">

                            <p class="text-sm font-bold text-slate-500">
                                Invoice
                            </p>

                            <p class="text-lg font-black text-slate-900">
                                <?php echo e($selectedBill->bill_number); ?>

                            </p>

                            <p class="mt-1 text-xs text-slate-400">
                                <?php echo e($selectedBill->created_at->format('d M Y, h:i A')); ?>

                            </p>

                        </div>

                    </div>


                    
                    <div class="grid grid-cols-2 gap-4 border-b border-slate-200 py-6">

                        <div>
                            <p class="text-xs font-bold uppercase text-slate-400">
                                Order
                            </p>

                            <p class="mt-1 font-black text-slate-800">
                                <?php echo e($selectedBill->order->order_number); ?>

                            </p>
                        </div>

                        <div>
                            <p class="text-xs font-bold uppercase text-slate-400">
                                Order Type
                            </p>

                            <p class="mt-1 font-black text-slate-800">
                                <?php echo e($selectedBill->order->order_type === 'dine_in' ? 'Dine In' : 'Takeaway'); ?>

                            </p>
                        </div>

                    </div>


                    
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

                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $selectedBill->order->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>

                                <div class="grid grid-cols-12 gap-2 text-sm">

                                    <div class="col-span-6 font-bold text-slate-700">
                                        <?php echo e($item->item_name); ?>

                                    </div>

                                    <div class="col-span-2 text-center text-slate-500">
                                        <?php echo e($item->quantity); ?>

                                    </div>

                                    <div class="col-span-2 text-right text-slate-500">
                                        ₹<?php echo e(number_format((float) $item->unit_price, 2)); ?>

                                    </div>

                                    <div class="col-span-2 text-right font-bold text-slate-800">
                                        ₹<?php echo e(number_format((float) $item->total, 2)); ?>

                                    </div>

                                </div>

                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>

                        </div>

                    </div>


                    
                    <div class="border-t border-slate-200 pt-5">

                        <div class="ml-auto max-w-sm space-y-3">

                            <div class="flex justify-between text-sm">
                                <span class="text-slate-500">
                                    Subtotal
                                </span>

                                <span class="font-bold text-slate-800">
                                    ₹<?php echo e(number_format((float) $selectedBill->subtotal, 2)); ?>

                                </span>
                            </div>


                            <div class="flex justify-between text-sm">
                                <span class="text-slate-500">
                                    Discount
                                </span>

                                <span class="font-bold text-red-500">
                                    - ₹<?php echo e(number_format((float) $selectedBill->discount, 2)); ?>

                                </span>
                            </div>


                            <div class="flex justify-between text-sm">
                                <span class="text-slate-500">
                                    Tax
                                </span>

                                <span class="font-bold text-slate-800">
                                    ₹<?php echo e(number_format((float) $selectedBill->tax, 2)); ?>

                                </span>
                            </div>


                            <div class="flex justify-between border-t border-slate-200 pt-3">

                                <span class="text-base font-black text-slate-900">
                                    Grand Total
                                </span>

                                <span class="text-xl font-black text-orange-600">
                                    ₹<?php echo e(number_format((float) $selectedBill->grand_total, 2)); ?>

                                </span>

                            </div>

                        </div>

                    </div>


                    
                    <div class="mt-8 rounded-2xl bg-slate-50 p-5">

                        <h4 class="font-black text-slate-900">
                            Payments
                        </h4>

                        <div class="mt-4 space-y-3">

                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $selectedBill->payments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $payment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>

                                <div class="flex items-center justify-between">

                                    <div>

                                        <p class="font-bold capitalize text-slate-700">
                                            <?php echo e($payment->method); ?>

                                        </p>

                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($payment->reference): ?>
                                            <p class="text-xs text-slate-400">
                                                Ref: <?php echo e($payment->reference); ?>

                                            </p>
                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                                    </div>

                                    <p class="font-black text-emerald-600">
                                        ₹<?php echo e(number_format((float) $payment->amount, 2)); ?>

                                    </p>

                                </div>

                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>

                                <p class="text-sm text-slate-400">
                                    No payment received yet.
                                </p>

                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                        </div>

                    </div>


                    <div class="mt-6 flex items-center justify-between rounded-2xl border border-slate-200 p-5">

                        <span class="font-bold text-slate-600">
                            Payment Status
                        </span>

                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($selectedBill->payment_status === 'paid'): ?>

                            <span class="rounded-full bg-emerald-50 px-4 py-2 text-xs font-black text-emerald-600">
                                ✓ PAID
                            </span>

                        <?php elseif($selectedBill->payment_status === 'partial'): ?>

                            <span class="rounded-full bg-amber-50 px-4 py-2 text-xs font-black text-amber-600">
                                PARTIAL
                            </span>

                        <?php else: ?>

                            <span class="rounded-full bg-red-50 px-4 py-2 text-xs font-black text-red-600">
                                UNPAID
                            </span>

                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                    </div>


                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($selectedBill->remaining_amount > 0): ?>

                        <div class="mt-4 flex items-center justify-between rounded-2xl bg-orange-50 p-5">

                            <span class="font-bold text-orange-700">
                                Remaining Amount
                            </span>

                            <span class="text-xl font-black text-orange-600">
                                ₹<?php echo e(number_format($selectedBill->remaining_amount, 2)); ?>

                            </span>

                        </div>

                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                </div>

            </div>

        </div>

    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

</div><?php /**PATH D:\ITDA\restaurant-saas\storage\framework\views/livewire/views/21eec56a.blade.php ENDPATH**/ ?>