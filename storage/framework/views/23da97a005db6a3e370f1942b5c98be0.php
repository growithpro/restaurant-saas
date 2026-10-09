<div class="min-h-screen bg-slate-50">

    <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">

        
        <div
            class="relative mb-6 overflow-hidden rounded-3xl bg-gradient-to-br from-indigo-600 via-purple-600 to-pink-500 p-6 text-white shadow-xl sm:p-8">

            
            <div class="absolute -right-16 -top-16 h-48 w-48 rounded-full bg-white/10"></div>
            <div class="absolute -bottom-20 right-20 h-40 w-40 rounded-full bg-white/10"></div>

            <div class="relative z-10 flex flex-col gap-6 lg:flex-row lg:items-center lg:justify-between">

                <div>

                    <p class="mb-2 text-sm font-medium text-white/75">
                        <?php echo e(now()->format('l, d F Y')); ?>

                    </p>

                    <h1 class="text-3xl font-bold tracking-tight sm:text-4xl">
                        Welcome back, <?php echo e(Auth::user()->name); ?> 👋
                    </h1>

                    <p class="mt-2 max-w-xl text-sm leading-6 text-white/80 sm:text-base">
                        Manage your restaurant, orders, tables and menu
                        from one powerful dashboard.
                    </p>

                </div>

                <div class="flex flex-wrap gap-3">

                    <a href="<?php echo e(route('pos')); ?>" wire:navigate
                        class="inline-flex items-center gap-2 rounded-xl bg-white px-5 py-3 text-sm font-bold text-indigo-700 shadow-lg transition hover:-translate-y-0.5 hover:bg-gray-50">
                        <span>🛒</span>
                        Open POS
                    </a>

                    <a href="<?php echo e(route('orders')); ?>" wire:navigate
                        class="inline-flex items-center gap-2 rounded-xl border border-white/30 bg-white/10 px-5 py-3 text-sm font-bold text-white backdrop-blur transition hover:bg-white/20">
                        <span>📋</span>
                        Orders
                    </a>

                </div>

            </div>

        </div>


        
        <div class="mb-6 grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">

            
            <div class="rounded-2xl border border-emerald-100 bg-white p-5 shadow-sm">

                <div class="flex items-start justify-between">

                    <div>
                        <p class="text-sm font-medium text-gray-500">
                            Today's Revenue
                        </p>

                        <p class="mt-2 text-3xl font-bold text-gray-900">
                            ₹<?php echo e(number_format($todayRevenue, 2)); ?>

                        </p>

                        <p class="mt-2 text-xs font-medium text-emerald-600">
                            ● Today's sales
                        </p>
                    </div>

                    <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-emerald-100 text-2xl">
                        💰
                    </div>

                </div>

            </div>


            
            <div class="rounded-2xl border border-blue-100 bg-white p-5 shadow-sm">

                <div class="flex items-start justify-between">

                    <div>
                        <p class="text-sm font-medium text-gray-500">
                            Today's Orders
                        </p>

                        <p class="mt-2 text-3xl font-bold text-gray-900">
                            <?php echo e($todayOrderCount); ?>

                        </p>

                        <p class="mt-2 text-xs font-medium text-blue-600">
                            Orders received today
                        </p>
                    </div>

                    <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-blue-100 text-2xl">
                        🧾
                    </div>

                </div>

            </div>


            
            


            <a href="<?php echo e(route('orders')); ?>" wire:navigate
                class="group block rounded-2xl border border-slate-200 bg-white p-5 shadow-sm transition hover:-translate-y-1 hover:border-orange-200 hover:shadow-lg">
                <div class="flex items-start justify-between">

                    <div>
                        <p class="text-sm font-semibold text-slate-500">
                            Active Orders
                        </p>

                        <p
                            class="mt-1 text-xs font-semibold <?php echo e($pendingOrders > 0 ? 'text-orange-600' : 'text-emerald-600'); ?>">
                            <?php echo e($pendingOrders > 0 ? '● Need attention' : '✓ All clear'); ?>

                        </p>
                    </div>

                    <div
                        class="flex h-12 w-12 items-center justify-center rounded-xl bg-orange-50 text-xl transition group-hover:scale-110">
                        🔥
                    </div>

                </div>

                <div class="mt-4 flex items-center justify-between border-t border-slate-100 pt-3">
                    <span class="text-xs font-bold text-slate-400">
                        View active orders
                    </span>

                    <span class="text-sm font-black text-orange-600">
                        →
                    </span>
                </div>
            </a>


            
            <div class="rounded-2xl border border-purple-100 bg-white p-5 shadow-sm">

                <div class="flex items-start justify-between">

                    <div>
                        <p class="text-sm font-medium text-gray-500">
                            Tables
                        </p>

                        <p class="mt-2 text-3xl font-bold text-gray-900">
                            <?php echo e($occupiedTables); ?>

                            <span class="text-lg font-medium text-gray-400">
                                / <?php echo e($tablesCount); ?>

                            </span>
                        </p>

                        <p class="mt-2 text-xs font-medium text-purple-600">
                            <?php echo e($availableTables); ?> available
                        </p>
                    </div>

                    <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-purple-100 text-2xl">
                        🪑
                    </div>

                </div>

            </div>

        </div>


        
        <div class="mb-6">

            <div class="mb-4 flex items-center justify-between">

                <div>
                    <h2 class="text-lg font-bold text-gray-900">
                        Quick Actions
                    </h2>

                    <p class="text-sm text-gray-500">
                        Frequently used restaurant tools
                    </p>
                </div>

            </div>


            <div class="grid grid-cols-2 gap-4 md:grid-cols-4">

                <a href="<?php echo e(route('pos')); ?>" wire:navigate
                    class="group rounded-2xl bg-gradient-to-br from-indigo-500 to-indigo-700 p-5 text-white shadow-sm transition hover:-translate-y-1 hover:shadow-lg">

                    <div class="text-3xl">
                        🛒
                    </div>

                    <p class="mt-4 font-bold">
                        New Order
                    </p>

                    <p class="mt-1 text-xs text-white/70">
                        Open restaurant POS
                    </p>

                </a>


                <a href="<?php echo e(route('menu-items')); ?>" wire:navigate
                    class="group rounded-2xl bg-gradient-to-br from-emerald-500 to-emerald-700 p-5 text-white shadow-sm transition hover:-translate-y-1 hover:shadow-lg">

                    <div class="text-3xl">
                        🍔
                    </div>

                    <p class="mt-4 font-bold">
                        Menu
                    </p>

                    <p class="mt-1 text-xs text-white/70">
                        Manage menu items
                    </p>

                </a>


                <a href="<?php echo e(route('tables')); ?>" wire:navigate
                    class="group rounded-2xl bg-gradient-to-br from-orange-500 to-orange-700 p-5 text-white shadow-sm transition hover:-translate-y-1 hover:shadow-lg">

                    <div class="text-3xl">
                        🪑
                    </div>

                    <p class="mt-4 font-bold">
                        Tables
                    </p>

                    <p class="mt-1 text-xs text-white/70">
                        Manage tables
                    </p>

                </a>


                <a href="<?php echo e(route('orders')); ?>" wire:navigate
                    class="group rounded-2xl bg-gradient-to-br from-pink-500 to-rose-600 p-5 text-white shadow-sm transition hover:-translate-y-1 hover:shadow-lg">

                    <div class="text-3xl">
                        📋
                    </div>

                    <p class="mt-4 font-bold">
                        Orders
                    </p>

                    <p class="mt-1 text-xs text-white/70">
                        Track all orders
                    </p>

                </a>

            </div>

        </div>


        
        <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">


            
            <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm lg:col-span-2">

                <div class="flex items-center justify-between border-b border-gray-100 px-5 py-4">

                    <div>
                        <h2 class="font-bold text-gray-900">
                            Recent Orders
                        </h2>

                        <p class="text-xs text-gray-500">
                            Latest activity
                        </p>
                    </div>

                    <a href="<?php echo e(route('orders')); ?>" wire:navigate
                        class="text-sm font-semibold text-indigo-600 hover:text-indigo-700">
                        View all →
                    </a>

                </div>


                <div class="divide-y divide-gray-100">

                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $recentOrders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>

                        <div class="flex items-center justify-between gap-4 px-5 py-4 hover:bg-gray-50">

                            <div class="flex min-w-0 items-center gap-3">

                                <div
                                    class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-indigo-50 text-lg">
                                    🧾
                                </div>

                                <div class="min-w-0">

                                    <p class="truncate font-semibold text-gray-900">
                                        <?php echo e($order->order_number); ?>

                                    </p>

                                    <p class="mt-1 truncate text-xs text-gray-500">

                                        <?php echo e($order->branch?->name); ?>


                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($order->table): ?>
                                            · Table <?php echo e($order->table->name); ?>

                                        <?php else: ?>
                                            · Takeaway
                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                                    </p>

                                </div>

                            </div>


                            <div class="shrink-0 text-right">

                                <p class="font-bold text-gray-900">
                                    ₹<?php echo e(number_format($order->grand_total, 2)); ?>

                                </p>

                                <?php
                                    $statusClasses = match ($order->status) {
                                        'pending' => 'bg-yellow-100 text-yellow-700',
                                        'preparing' => 'bg-blue-100 text-blue-700',
                                        'ready' => 'bg-purple-100 text-purple-700',
                                        'served' => 'bg-indigo-100 text-indigo-700',
                                        'completed' => 'bg-emerald-100 text-emerald-700',
                                        'cancelled' => 'bg-red-100 text-red-700',
                                        default => 'bg-gray-100 text-gray-700',
                                    };
                                ?>

                                <span
                                    class="mt-1 inline-flex rounded-full px-2 py-1 text-[10px] font-bold uppercase <?php echo e($statusClasses); ?>">
                                    <?php echo e($order->status); ?>

                                </span>

                            </div>

                        </div>

                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>

                        <div class="px-5 py-12 text-center">

                            <div class="text-4xl">
                                📋
                            </div>

                            <p class="mt-3 font-semibold text-gray-700">
                                No orders yet
                            </p>

                            <p class="mt-1 text-sm text-gray-500">
                                Your recent orders will appear here.
                            </p>

                            <a href="<?php echo e(route('pos')); ?>" wire:navigate
                                class="mt-4 inline-flex rounded-lg bg-gray-900 px-4 py-2 text-sm font-semibold text-white">
                                Create First Order
                            </a>

                        </div>

                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                </div>

            </div>


            
            <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">

                <div class="mb-5">

                    <h2 class="font-bold text-gray-900">
                        Restaurant Overview
                    </h2>

                    <p class="text-xs text-gray-500">
                        Your current setup
                    </p>

                </div>


                <div class="space-y-3">

                    
                    <a href="<?php echo e(route('branches')); ?>" wire:navigate
                        class="flex items-center justify-between rounded-xl bg-blue-50 p-4 transition hover:bg-blue-100">

                        <div class="flex items-center gap-3">

                            <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-blue-100">
                                🏢
                            </div>

                            <div>

                                <p class="text-sm font-semibold text-gray-900">
                                    Branches
                                </p>

                                <p class="text-xs text-gray-500">
                                    Restaurant locations
                                </p>

                            </div>

                        </div>

                        <span class="text-xl font-bold text-blue-700">
                            <?php echo e($branchesCount); ?>

                        </span>

                    </a>


                    
                    <a href="<?php echo e(route('tables')); ?>" wire:navigate
                        class="flex items-center justify-between rounded-xl bg-orange-50 p-4 transition hover:bg-orange-100">

                        <div class="flex items-center gap-3">

                            <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-orange-100">
                                🪑
                            </div>

                            <div>

                                <p class="text-sm font-semibold text-gray-900">
                                    Tables
                                </p>

                                <p class="text-xs text-gray-500">
                                    <?php echo e($occupiedTables); ?> occupied
                                </p>

                            </div>

                        </div>

                        <span class="text-xl font-bold text-orange-700">
                            <?php echo e($tablesCount); ?>

                        </span>

                    </a>


                    
                    <a href="<?php echo e(route('categories')); ?>" wire:navigate
                        class="flex items-center justify-between rounded-xl bg-purple-50 p-4 transition hover:bg-purple-100">

                        <div class="flex items-center gap-3">

                            <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-purple-100">
                                🗂️
                            </div>

                            <div>

                                <p class="text-sm font-semibold text-gray-900">
                                    Categories
                                </p>

                                <p class="text-xs text-gray-500">
                                    Menu organization
                                </p>

                            </div>

                        </div>

                        <span class="text-xl font-bold text-purple-700">
                            <?php echo e($categoriesCount); ?>

                        </span>

                    </a>


                    
                    <a href="<?php echo e(route('menu-items')); ?>" wire:navigate
                        class="flex items-center justify-between rounded-xl bg-emerald-50 p-4 transition hover:bg-emerald-100">

                        <div class="flex items-center gap-3">

                            <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-emerald-100">
                                🍔
                            </div>

                            <div>

                                <p class="text-sm font-semibold text-gray-900">
                                    Menu Items
                                </p>

                                <p class="text-xs text-gray-500">
                                    <?php echo e($availableMenuItems); ?> available
                                </p>

                            </div>

                        </div>

                        <span class="text-xl font-bold text-emerald-700">
                            <?php echo e($menuItemsCount); ?>

                        </span>

                    </a>

                </div>

            </div>

        </div>


        
        <div class="mt-6 rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">

            <div class="mb-5">

                <h2 class="font-bold text-gray-900">
                    Popular Menu Items
                </h2>

                <p class="text-xs text-gray-500">
                    Based on orders
                </p>

            </div>


            <div class="grid grid-cols-1 gap-3 sm:grid-cols-2 lg:grid-cols-5">

                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $popularItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>

                    <div class="rounded-xl border border-gray-100 bg-gray-50 p-4">

                        <div class="flex items-start justify-between gap-2">

                            <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-white text-lg shadow-sm">
                                🍽️
                            </div>

                            <span class="rounded-full bg-indigo-100 px-2 py-1 text-[10px] font-bold text-indigo-700">
                                #<?php echo e($loop->iteration); ?>

                            </span>

                        </div>

                        <p class="mt-4 truncate font-semibold text-gray-900">
                            <?php echo e($item->name); ?>

                        </p>

                        <div class="mt-2 flex items-center justify-between">

                            <span class="text-xs text-gray-500">
                                Sold
                            </span>

                            <span class="text-sm font-bold text-gray-900">
                                <?php echo e($item->sold_quantity); ?>

                            </span>

                        </div>

                    </div>

                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>

                    <div class="col-span-full rounded-xl bg-gray-50 p-8 text-center">

                        <p class="text-sm font-medium text-gray-600">
                            Popular items will appear after orders are placed.
                        </p>

                    </div>

                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

            </div>

        </div>


        
        <div
            class="mt-6 flex flex-col gap-3 rounded-2xl border border-gray-200 bg-white p-5 shadow-sm sm:flex-row sm:items-center sm:justify-between">

            <div>

                <p class="font-semibold text-gray-900">
                    Restaurant system
                </p>

                <p class="text-xs text-gray-500">
                    Core modules are connected and ready.
                </p>

            </div>

            <div class="flex items-center gap-2">

                <span class="h-2.5 w-2.5 rounded-full bg-emerald-500"></span>

                <span class="text-sm font-semibold text-emerald-600">
                    All systems operational
                </span>

            </div>

        </div>

    </div>

</div><?php /**PATH D:\ITDA\restaurant-saas\storage\framework\views/livewire/views/52021f0a.blade.php ENDPATH**/ ?>