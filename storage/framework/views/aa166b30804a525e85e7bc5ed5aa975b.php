<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?php echo e($title ?? 'Restaurant SaaS'); ?></title>

    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>

    <?php echo \Livewire\Mechanisms\FrontendAssets\FrontendAssets::styles(); ?>

</head>

<body class="bg-gray-100 text-gray-900">

    <div class="flex min-h-screen">

        <!-- Sidebar -->
        <aside class="hidden w-64 shrink-0 bg-gray-950 text-white md:block">

            <div class="border-b border-gray-800 px-6 py-5">
                <a href="<?php echo e(route('dashboard')); ?>" class="text-xl font-bold">
                    🍽 Restaurant SaaS
                </a>
            </div>

            <nav class="space-y-1 p-4">

                <a href="<?php echo e(route('dashboard')); ?>"
                    class="block rounded-lg px-4 py-3 text-sm font-medium hover:bg-gray-800">
                    Dashboard
                </a>

                <a href="<?php echo e(route('restaurant.setup')); ?>"
                    class="block rounded-lg px-4 py-3 text-sm font-medium hover:bg-gray-800">
                    Restaurant
                </a>

                <a href="<?php echo e(route('branches')); ?>"
                    class="block rounded-lg px-4 py-3 text-sm font-medium hover:bg-gray-800">
                    Branches
                </a>

                <a href="<?php echo e(route('tables')); ?>"
                    class="block rounded-lg px-4 py-3 text-sm font-medium hover:bg-gray-800">
                    Tables
                </a>


                <a href="<?php echo e(route('categories')); ?>"
                    class="block rounded-lg px-4 py-3 text-sm font-medium hover:bg-gray-800">
                    Categories
                </a>

                <a href="<?php echo e(route('menu-items')); ?>"
                    class="block rounded-lg px-4 py-3 text-sm font-medium hover:bg-gray-800">
                    Menu Items
                </a>

                

                <a href="<?php echo e(route('pos')); ?>" wire:navigate
                    class="flex items-center gap-3 rounded-lg px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-100">
                    <span>🛒</span>
                    <span>POS</span>
                </a>

                <a href="<?php echo e(route('orders')); ?>" wire:navigate
                    class="flex items-center gap-3 rounded-lg px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-100">
                    <span>📋</span>
                    <span>Orders</span>
                </a>

                <a href="<?php echo e(route('billing')); ?>" wire:navigate
                    class="flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-semibold text-slate-600 transition hover:bg-orange-50 hover:text-orange-600">
                    <span class="text-lg">💳</span>
                    <span>Billing</span>
                </a>

                <a href="<?php echo e(route('kitchen')); ?>" wire:navigate
                    class="flex items-center gap-3 rounded-lg px-3 py-2 text-sm font-semibold text-slate-600 transition hover:bg-orange-50 hover:text-orange-600">
                    <span class="text-lg">👨‍🍳</span>
                    <span>Kitchen</span>
                </a>

                <a href="<?php echo e(route('inventory')); ?>" wire:navigate
                    class="flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-semibold text-slate-600 transition hover:bg-orange-50 hover:text-orange-600">
                    <span class="text-lg">📦</span>
                    <span>Inventory</span>
                </a>

                <a href="<?php echo e(route('recipes')); ?>" wire:navigate
                    class="flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-semibold text-slate-600 transition hover:bg-orange-50 hover:text-orange-600">
                    <span class="text-lg">🧪</span>
                    <span>Recipes</span>
                </a>

                <a href="#" class="block rounded-lg px-4 py-3 text-sm font-medium hover:bg-gray-800">
                    Customers
                </a>

                <a href="#" class="block rounded-lg px-4 py-3 text-sm font-medium hover:bg-gray-800">
                    Expenses
                </a>

                <a href="<?php echo e(route('reports')); ?>" wire:navigate>
                    Reports & Analytics
                </a>

            </nav>

        </aside>

        <!-- Main -->
        <div class="flex min-w-0 flex-1 flex-col">

            <!-- Topbar -->
            <header class="border-b border-gray-200 bg-white">

                <div class="flex items-center justify-between px-6 py-4">

                    <div>
                        <h1 class="text-lg font-semibold">
                            <?php echo e(auth()->user()->restaurant?->name ?? 'Restaurant SaaS'); ?>

                        </h1>

                        <p class="text-sm text-gray-500">
                            Management Dashboard
                        </p>
                    </div>

                    <div class="flex items-center gap-4">

                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(auth()->guard()->check()): ?>
                            <span class="text-sm font-medium">
                                <?php echo e(auth()->user()->name); ?>

                            </span>

                            <form method="POST" action="<?php echo e(route('logout')); ?>">
                                <?php echo csrf_field(); ?>

                                <button type="submit"
                                    class="rounded-lg bg-gray-900 px-4 py-2 text-sm font-medium text-white hover:bg-gray-700">
                                    Logout
                                </button>
                            </form>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                    </div>

                </div>

            </header>

            <!-- Content -->
            <main class="flex-1">
                <?php echo e($slot); ?>

            </main>

        </div>

    </div>

    <?php echo \Livewire\Mechanisms\FrontendAssets\FrontendAssets::scripts(); ?>


</body>

</html><?php /**PATH D:\ITDA\restaurant-saas\resources\views/layouts/app.blade.php ENDPATH**/ ?>