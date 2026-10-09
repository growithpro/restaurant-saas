<div class="min-h-screen bg-gray-50">

    <div class="mx-auto max-w-7xl px-4 py-6">

        
        <div class="mb-6 flex flex-col gap-4 md:flex-row md:items-center md:justify-between">

            <div>
                <h1 class="text-2xl font-bold text-gray-900">
                    Point of Sale
                </h1>

                <p class="text-sm text-gray-500">
                    Create a new restaurant order
                </p>
            </div>

            <a
                href="<?php echo e(route('orders')); ?>"
                wire:navigate
                class="rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-semibold text-gray-700 hover:bg-gray-50"
            >
                View Orders
            </a>

        </div>

        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session('success')): ?>
            <div class="mb-6 rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700">
                <?php echo e(session('success')); ?>

            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

        
        <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">

            
            <div class="lg:col-span-2">

                
                <div class="mb-6 rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">

                    <div class="grid grid-cols-1 gap-4 md:grid-cols-3">

                        
                        <div>
                            <label class="mb-1 block text-sm font-medium text-gray-700">
                                Branch
                            </label>

                            <select
                                wire:model.live="branchId"
                                class="w-full rounded-lg border-gray-300 text-sm focus:border-gray-900 focus:ring-gray-900"
                            >
                                <option value="">
                                    Select branch
                                </option>

                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $branches; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $branch): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                    <option value="<?php echo e($branch->id); ?>">
                                        <?php echo e($branch->name); ?>

                                    </option>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                            </select>

                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['branchId'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <p class="mt-1 text-xs text-red-600">
                                    <?php echo e($message); ?>

                                </p>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>

                        
                        <div>
                            <label class="mb-1 block text-sm font-medium text-gray-700">
                                Order Type
                            </label>

                            <select
                                wire:model.live="orderType"
                                class="w-full rounded-lg border-gray-300 text-sm focus:border-gray-900 focus:ring-gray-900"
                            >
                                <option value="dine_in">
                                    Dine In
                                </option>

                                <option value="takeaway">
                                    Takeaway
                                </option>
                            </select>
                        </div>

                        
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($orderType === 'dine_in'): ?>
                            <div>
                                <label class="mb-1 block text-sm font-medium text-gray-700">
                                    Table
                                </label>

                                <select
                                    wire:model.live="tableId"
                                    class="w-full rounded-lg border-gray-300 text-sm focus:border-gray-900 focus:ring-gray-900"
                                >
                                    <option value="">
                                        Select table
                                    </option>

                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $tables; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $table): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                        <option value="<?php echo e($table->id); ?>">
                                            <?php echo e($table->name); ?>

                                            (<?php echo e($table->capacity); ?> seats)
                                        </option>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                                </select>

                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['tableId'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <p class="mt-1 text-xs text-red-600">
                                        <?php echo e($message); ?>

                                    </p>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </div>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                    </div>

                </div>

                
                <div class="mb-4">

                    <input
                        type="text"
                        wire:model.live.debounce.300ms="search"
                        placeholder="Search menu items..."
                        class="w-full rounded-xl border-gray-300 bg-white px-4 py-3 text-sm shadow-sm focus:border-gray-900 focus:ring-gray-900"
                    >

                </div>

                
                <div class="mb-5 flex gap-2 overflow-x-auto pb-2">

                    <button
                        type="button"
                        wire:click="$set('categoryId', '')"
                        class="<?php echo e(!$categoryId ? 'bg-gray-900 text-white' : 'bg-white text-gray-700 border border-gray-200'); ?> whitespace-nowrap rounded-lg px-4 py-2 text-sm font-semibold"
                    >
                        All
                    </button>

                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>

                        <button
                            type="button"
                            wire:click="$set('categoryId', <?php echo e($category->id); ?>)"
                            class="<?php echo e((string) $categoryId === (string) $category->id ? 'bg-gray-900 text-white' : 'bg-white text-gray-700 border border-gray-200'); ?> whitespace-nowrap rounded-lg px-4 py-2 text-sm font-semibold"
                        >
                            <?php echo e($category->name); ?>

                        </button>

                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>

                </div>

                
                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-3">

                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $menuItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>

                        <button
                            type="button"
                            wire:click="addToCart(<?php echo e($item->id); ?>)"
                            class="group overflow-hidden rounded-2xl border border-gray-200 bg-white text-left shadow-sm transition hover:-translate-y-0.5 hover:shadow-md"
                        >

                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($item->image): ?>
                                <img
                                    src="<?php echo e(asset('storage/' . $item->image)); ?>"
                                    alt="<?php echo e($item->name); ?>"
                                    class="h-36 w-full object-cover"
                                >
                            <?php else: ?>
                                <div class="flex h-36 items-center justify-center bg-gray-100 text-3xl">
                                    🍽️
                                </div>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                            <div class="p-4">

                                <div class="flex items-start justify-between gap-3">

                                    <div>
                                        <h3 class="font-semibold text-gray-900">
                                            <?php echo e($item->name); ?>

                                        </h3>

                                        <p class="mt-1 text-xs text-gray-500">
                                            <?php echo e($item->category?->name); ?>

                                        </p>
                                    </div>

                                    <span class="font-bold text-gray-900">
                                        ₹<?php echo e(number_format($item->price, 2)); ?>

                                    </span>

                                </div>

                            </div>

                        </button>

                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>

                        <div class="col-span-full rounded-2xl border border-dashed border-gray-300 bg-white p-10 text-center">

                            <p class="font-medium text-gray-700">
                                No menu items found
                            </p>

                            <p class="mt-1 text-sm text-gray-500">
                                Try another category or search.
                            </p>

                        </div>

                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                </div>

            </div>

            
            <div class="lg:col-span-1">

                <div class="sticky top-6 overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">

                    <div class="flex items-center justify-between border-b border-gray-200 p-5">

                        <div>
                            <h2 class="font-bold text-gray-900">
                                Current Order
                            </h2>

                            <p class="text-xs text-gray-500">
                                <?php echo e(count($cart)); ?> item types
                            </p>
                        </div>

                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(count($cart)): ?>
                            <button
                                type="button"
                                wire:click="clearCart"
                                class="text-xs font-semibold text-red-600 hover:text-red-700"
                            >
                                Clear
                            </button>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                    </div>

                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['cart'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <div class="border-b border-red-100 bg-red-50 px-5 py-3 text-sm text-red-600">
                            <?php echo e($message); ?>

                        </div>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                    <div class="max-h-[420px] overflow-y-auto">

                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $cart; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>

                            <div class="border-b border-gray-100 p-4">

                                <div class="flex justify-between gap-3">

                                    <div class="min-w-0">

                                        <p class="font-semibold text-gray-900">
                                            <?php echo e($item['name']); ?>

                                        </p>

                                        <p class="mt-1 text-xs text-gray-500">
                                            ₹<?php echo e(number_format($item['price'], 2)); ?>

                                            each
                                        </p>

                                    </div>

                                    <button
                                        type="button"
                                        wire:click="removeFromCart(<?php echo e($item['id']); ?>)"
                                        class="text-xs text-red-500"
                                    >
                                        Remove
                                    </button>

                                </div>

                                <div class="mt-3 flex items-center justify-between">

                                    <div class="flex items-center rounded-lg border border-gray-200">

                                        <button
                                            type="button"
                                            wire:click="decreaseQuantity(<?php echo e($item['id']); ?>)"
                                            class="px-3 py-1.5 text-gray-600 hover:bg-gray-50"
                                        >
                                            −
                                        </button>

                                        <span class="px-3 text-sm font-semibold">
                                            <?php echo e($item['quantity']); ?>

                                        </span>

                                        <button
                                            type="button"
                                            wire:click="increaseQuantity(<?php echo e($item['id']); ?>)"
                                            class="px-3 py-1.5 text-gray-600 hover:bg-gray-50"
                                        >
                                            +
                                        </button>

                                    </div>

                                    <span class="font-bold text-gray-900">
                                        ₹<?php echo e(number_format($item['price'] * $item['quantity'], 2)); ?>

                                    </span>

                                </div>

                            </div>

                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>

                            <div class="px-5 py-12 text-center">

                                <div class="text-4xl">
                                    🛒
                                </div>

                                <p class="mt-3 font-semibold text-gray-700">
                                    Cart is empty
                                </p>

                                <p class="mt-1 text-sm text-gray-500">
                                    Click a menu item to add it.
                                </p>

                            </div>

                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                    </div>

                    
                    <div class="border-t border-gray-200 p-5">

                        <div class="space-y-3">

                            <div class="flex justify-between text-sm">
                                <span class="text-gray-500">
                                    Subtotal
                                </span>

                                <span class="font-medium">
                                    ₹<?php echo e(number_format($this->subtotal, 2)); ?>

                                </span>
                            </div>

                            <div>
                                <label class="mb-1 block text-xs font-medium text-gray-600">
                                    Discount
                                </label>

                                <input
                                    type="number"
                                    min="0"
                                    step="0.01"
                                    wire:model.live="discount"
                                    class="w-full rounded-lg border-gray-300 text-sm"
                                    placeholder="0.00"
                                >
                            </div>

                            <div>
                                <label class="mb-1 block text-xs font-medium text-gray-600">
                                    Tax
                                </label>

                                <input
                                    type="number"
                                    min="0"
                                    step="0.01"
                                    wire:model.live="tax"
                                    class="w-full rounded-lg border-gray-300 text-sm"
                                    placeholder="0.00"
                                >
                            </div>

                            <div>
                                <label class="mb-1 block text-xs font-medium text-gray-600">
                                    Order Notes
                                </label>

                                <textarea
                                    wire:model="notes"
                                    rows="2"
                                    class="w-full rounded-lg border-gray-300 text-sm"
                                    placeholder="Optional notes..."
                                ></textarea>
                            </div>

                            <div class="border-t border-gray-200 pt-3">

                                <div class="flex justify-between">

                                    <span class="font-bold text-gray-900">
                                        Grand Total
                                    </span>

                                    <span class="text-xl font-bold text-gray-900">
                                        ₹<?php echo e(number_format($this->grandTotal, 2)); ?>

                                    </span>

                                </div>

                            </div>

                        </div>

                        <button
                            type="button"
                            wire:click="placeOrder"
                            wire:loading.attr="disabled"
                            class="mt-5 w-full rounded-xl bg-gray-900 px-4 py-3 font-semibold text-white transition hover:bg-gray-800 disabled:cursor-not-allowed disabled:opacity-50"
                        >
                            <span wire:loading.remove wire:target="placeOrder">
                                Place Order
                            </span>

                            <span wire:loading wire:target="placeOrder">
                                Creating Order...
                            </span>
                        </button>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div><?php /**PATH D:\ITDA\restaurant-saas\resources\views/components/⚡pos/pos.blade.php ENDPATH**/ ?>