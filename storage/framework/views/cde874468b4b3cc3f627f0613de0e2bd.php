<div class="min-h-screen bg-slate-50 px-4 py-6 sm:px-6 lg:px-8">

    <div class="mx-auto max-w-7xl">

        <div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

            <div>
                <h1 class="text-3xl font-black text-slate-900">
                    Inventory
                </h1>

                <p class="mt-1 text-sm text-slate-500">
                    Manage ingredients, stock and inventory movements.
                </p>
            </div>

            <button
                wire:click="openCreate"
                class="rounded-2xl bg-orange-500 px-5 py-3 text-sm font-black text-white shadow-lg hover:bg-orange-600"
            >
                + Add Ingredient
            </button>

        </div>


        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session()->has('success')): ?>
            <div class="mb-5 rounded-2xl bg-emerald-50 px-5 py-4 text-sm font-bold text-emerald-700">
                ✓ <?php echo e(session('success')); ?>

            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session()->has('error')): ?>
            <div class="mb-5 rounded-2xl bg-red-50 px-5 py-4 text-sm font-bold text-red-700">
                <?php echo e(session('error')); ?>

            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>


        <div class="mb-6 rounded-3xl bg-white p-5 shadow-sm ring-1 ring-slate-200">

            <div class="grid gap-4 md:grid-cols-3">

                <input
                    type="text"
                    wire:model.live.debounce.300ms="search"
                    placeholder="Search ingredient..."
                    class="rounded-2xl border-slate-200 px-4 py-3 text-sm"
                >

                <select
                    wire:model.live="filter"
                    class="rounded-2xl border-slate-200 px-4 py-3 text-sm font-semibold"
                >
                    <option value="all">All Items</option>
                    <option value="active">Active</option>
                    <option value="low">Low Stock</option>
                </select>

            </div>

        </div>


        <div class="overflow-hidden rounded-3xl bg-white shadow-sm ring-1 ring-slate-200">

            <div class="overflow-x-auto">

                <table class="w-full min-w-[900px]">

                    <thead class="bg-slate-50">

                        <tr class="border-b border-slate-200">

                            <th class="px-6 py-4 text-left text-xs font-black uppercase text-slate-400">
                                Ingredient
                            </th>

                            <th class="px-6 py-4 text-left text-xs font-black uppercase text-slate-400">
                                Unit
                            </th>

                            <th class="px-6 py-4 text-right text-xs font-black uppercase text-slate-400">
                                Stock
                            </th>

                            <th class="px-6 py-4 text-right text-xs font-black uppercase text-slate-400">
                                Minimum
                            </th>

                            <th class="px-6 py-4 text-center text-xs font-black uppercase text-slate-400">
                                Status
                            </th>

                            <th class="px-6 py-4 text-right text-xs font-black uppercase text-slate-400">
                                Actions
                            </th>

                        </tr>

                    </thead>


                    <tbody class="divide-y divide-slate-100">

                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>

                            <tr class="hover:bg-slate-50">

                                <td class="px-6 py-5">

                                    <p class="font-black text-slate-900">
                                        <?php echo e($item->name); ?>

                                    </p>

                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($item->sku): ?>
                                        <p class="mt-1 text-xs text-slate-400">
                                            SKU: <?php echo e($item->sku); ?>

                                        </p>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                                </td>


                                <td class="px-6 py-5 font-semibold text-slate-600">
                                    <?php echo e($item->unit); ?>

                                </td>


                                <td class="px-6 py-5 text-right">

                                    <p class="font-black text-slate-900">
                                        <?php echo e(number_format((float) $item->current_stock, 3)); ?>

                                    </p>

                                    <p class="text-xs text-slate-400">
                                        <?php echo e($item->unit); ?>

                                    </p>

                                </td>


                                <td class="px-6 py-5 text-right font-semibold text-slate-500">

                                    <?php echo e(number_format((float) $item->minimum_stock, 3)); ?>


                                </td>


                                <td class="px-6 py-5 text-center">

                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($item->isLowStock()): ?>

                                        <span class="rounded-full bg-red-50 px-3 py-1.5 text-xs font-black text-red-600">
                                            ⚠ Low Stock
                                        </span>

                                    <?php elseif(!$item->is_active): ?>

                                        <span class="rounded-full bg-slate-100 px-3 py-1.5 text-xs font-black text-slate-500">
                                            Inactive
                                        </span>

                                    <?php else: ?>

                                        <span class="rounded-full bg-emerald-50 px-3 py-1.5 text-xs font-black text-emerald-600">
                                            ✓ Healthy
                                        </span>

                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                                </td>


                                <td class="px-6 py-5">

                                    <div class="flex justify-end gap-2">

                                        <button
                                            wire:click="openTransaction(<?php echo e($item->id); ?>)"
                                            class="rounded-xl bg-emerald-50 px-3 py-2 text-xs font-black text-emerald-700 hover:bg-emerald-100"
                                        >
                                            Stock
                                        </button>

                                        <button
                                            wire:click="openEdit(<?php echo e($item->id); ?>)"
                                            class="rounded-xl bg-slate-100 px-3 py-2 text-xs font-black text-slate-700 hover:bg-slate-200"
                                        >
                                            Edit
                                        </button>

                                        <button
                                            wire:click="delete(<?php echo e($item->id); ?>)"
                                            wire:confirm="Delete this inventory item?"
                                            class="rounded-xl bg-red-50 px-3 py-2 text-xs font-black text-red-600 hover:bg-red-100"
                                        >
                                            Delete
                                        </button>

                                    </div>

                                </td>

                            </tr>

                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>

                            <tr>

                                <td colspan="6" class="px-6 py-16 text-center">

                                    <div class="text-4xl">
                                        📦
                                    </div>

                                    <h3 class="mt-3 font-black text-slate-900">
                                        No inventory items
                                    </h3>

                                    <p class="mt-1 text-sm text-slate-500">
                                        Add your first ingredient.
                                    </p>

                                </td>

                            </tr>

                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                    </tbody>

                </table>

            </div>


            <div class="border-t border-slate-100 px-6 py-4">
                <?php echo e($items->links()); ?>

            </div>

        </div>

    </div>


    
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($showModal): ?>

        <div class="fixed inset-0 z-50 flex items-center justify-center bg-slate-950/60 p-4">

            <div class="w-full max-w-xl rounded-3xl bg-white shadow-2xl">

                <div class="flex items-center justify-between border-b border-slate-100 px-6 py-5">

                    <h2 class="text-xl font-black text-slate-900">
                        <?php echo e($editingId ? 'Edit Ingredient' : 'Add Ingredient'); ?>

                    </h2>

                    <button
                        wire:click="closeModal"
                        class="rounded-xl bg-slate-100 px-3 py-2"
                    >
                        ✕
                    </button>

                </div>


                <div class="grid gap-5 p-6 md:grid-cols-2">

                    <div class="md:col-span-2">
                        <label class="mb-2 block text-sm font-bold">
                            Ingredient Name
                        </label>

                        <input
                            wire:model="name"
                            type="text"
                            placeholder="e.g. Paneer"
                            class="w-full rounded-2xl border-slate-200 px-4 py-3"
                        >

                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="mt-1 text-xs text-red-500"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>


                    <div>
                        <label class="mb-2 block text-sm font-bold">
                            SKU
                        </label>

                        <input
                            wire:model="sku"
                            type="text"
                            placeholder="PAN-001"
                            class="w-full rounded-2xl border-slate-200 px-4 py-3"
                        >
                    </div>


                    <div>
                        <label class="mb-2 block text-sm font-bold">
                            Unit
                        </label>

                        <select
                            wire:model="unit"
                            class="w-full rounded-2xl border-slate-200 px-4 py-3"
                        >
                            <option value="kg">kg</option>
                            <option value="g">g</option>
                            <option value="litre">litre</option>
                            <option value="ml">ml</option>
                            <option value="piece">piece</option>
                            <option value="packet">packet</option>
                            <option value="box">box</option>
                        </select>
                    </div>


                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!$editingId): ?>

                        <div>
                            <label class="mb-2 block text-sm font-bold">
                                Opening Stock
                            </label>

                            <input
                                wire:model="currentStock"
                                type="number"
                                step="0.001"
                                min="0"
                                class="w-full rounded-2xl border-slate-200 px-4 py-3"
                            >
                        </div>

                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>


                    <div>
                        <label class="mb-2 block text-sm font-bold">
                            Minimum Stock
                        </label>

                        <input
                            wire:model="minimumStock"
                            type="number"
                            step="0.001"
                            min="0"
                            class="w-full rounded-2xl border-slate-200 px-4 py-3"
                        >
                    </div>


                    <div>
                        <label class="mb-2 block text-sm font-bold">
                            Cost Per Unit
                        </label>

                        <input
                            wire:model="costPerUnit"
                            type="number"
                            step="0.01"
                            min="0"
                            class="w-full rounded-2xl border-slate-200 px-4 py-3"
                        >
                    </div>


                    <div class="md:col-span-2">

                        <label class="mb-2 block text-sm font-bold">
                            Notes
                        </label>

                        <textarea
                            wire:model="notes"
                            rows="3"
                            class="w-full rounded-2xl border-slate-200 px-4 py-3"
                        ></textarea>

                    </div>


                    <div class="md:col-span-2 flex justify-end gap-3">

                        <button
                            wire:click="closeModal"
                            class="rounded-2xl bg-slate-100 px-5 py-3 font-bold"
                        >
                            Cancel
                        </button>

                        <button
                            wire:click="save"
                            class="rounded-2xl bg-orange-500 px-5 py-3 font-black text-white"
                        >
                            Save Ingredient
                        </button>

                    </div>

                </div>

            </div>

        </div>

    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>


    
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($showTransactionModal): ?>

        <div class="fixed inset-0 z-50 flex items-center justify-center bg-slate-950/60 p-4">

            <div class="w-full max-w-lg rounded-3xl bg-white shadow-2xl">

                <div class="flex items-center justify-between border-b border-slate-100 px-6 py-5">

                    <h2 class="text-xl font-black">
                        Stock Transaction
                    </h2>

                    <button
                        wire:click="closeTransaction"
                        class="rounded-xl bg-slate-100 px-3 py-2"
                    >
                        ✕
                    </button>

                </div>


                <div class="space-y-5 p-6">

                    <div>

                        <label class="mb-2 block text-sm font-bold">
                            Transaction Type
                        </label>

                        <select
                            wire:model="transactionType"
                            class="w-full rounded-2xl border-slate-200 px-4 py-3"
                        >
                            <option value="in">
                                Stock In
                            </option>

                            <option value="out">
                                Stock Out
                            </option>

                            <option value="wastage">
                                Wastage
                            </option>

                            <option value="adjustment">
                                Set Stock
                            </option>
                        </select>

                    </div>


                    <div>

                        <label class="mb-2 block text-sm font-bold">
                            Quantity
                        </label>

                        <input
                            wire:model="transactionQuantity"
                            type="number"
                            step="0.001"
                            min="0.001"
                            class="w-full rounded-2xl border-slate-200 px-4 py-3 text-lg font-black"
                        >

                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['transactionQuantity'];
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

                        <label class="mb-2 block text-sm font-bold">
                            Reference
                        </label>

                        <input
                            wire:model="transactionReference"
                            type="text"
                            placeholder="Purchase invoice / reason"
                            class="w-full rounded-2xl border-slate-200 px-4 py-3"
                        >

                    </div>


                    <div>

                        <label class="mb-2 block text-sm font-bold">
                            Notes
                        </label>

                        <textarea
                            wire:model="transactionNotes"
                            rows="3"
                            class="w-full rounded-2xl border-slate-200 px-4 py-3"
                        ></textarea>

                    </div>


                    <div class="flex justify-end gap-3">

                        <button
                            wire:click="closeTransaction"
                            class="rounded-2xl bg-slate-100 px-5 py-3 font-bold"
                        >
                            Cancel
                        </button>

                        <button
                            wire:click="saveTransaction"
                            class="rounded-2xl bg-orange-500 px-5 py-3 font-black text-white"
                        >
                            Save Transaction
                        </button>

                    </div>

                </div>

            </div>

        </div>

    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

</div><?php /**PATH D:\ITDA\restaurant-saas\storage\framework\views/livewire/views/2efa4df3.blade.php ENDPATH**/ ?>