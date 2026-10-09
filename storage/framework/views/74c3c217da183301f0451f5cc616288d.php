<div
    class="min-h-screen bg-slate-50"
    wire:poll.10s
>
    <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">

        
        <div class="mb-6 flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">

            <div>
                <p class="text-sm font-medium text-orange-600">
                    Kitchen Management
                </p>

                <h1 class="mt-1 text-3xl font-black tracking-tight text-slate-900">
                    Kitchen Orders
                </h1>

                <p class="mt-1 text-sm text-slate-500">
                    Manage KOTs and keep your kitchen workflow moving.
                </p>
            </div>

            <a
                href="<?php echo e(route('pos')); ?>"
                wire:navigate
                class="inline-flex items-center justify-center gap-2 rounded-xl bg-slate-900 px-5 py-3 text-sm font-bold text-white shadow-sm transition hover:bg-slate-800"
            >
                <span>＋</span>
                New Order
            </a>
        </div>

        
        <div class="mb-6 grid grid-cols-1 gap-4 sm:grid-cols-3">

            <div class="rounded-2xl border border-blue-100 bg-white p-5 shadow-sm">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-semibold text-slate-500">
                            New
                        </p>

                        <p class="mt-2 text-3xl font-black text-blue-600">
                            <?php echo e($counts['new']); ?>

                        </p>
                    </div>

                    <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-blue-50 text-xl">
                        🔔
                    </div>
                </div>
            </div>

            <div class="rounded-2xl border border-amber-100 bg-white p-5 shadow-sm">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-semibold text-slate-500">
                            Preparing
                        </p>

                        <p class="mt-2 text-3xl font-black text-amber-600">
                            <?php echo e($counts['preparing']); ?>

                        </p>
                    </div>

                    <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-amber-50 text-xl">
                        👨‍🍳
                    </div>
                </div>
            </div>

            <div class="rounded-2xl border border-emerald-100 bg-white p-5 shadow-sm">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-semibold text-slate-500">
                            Ready
                        </p>

                        <p class="mt-2 text-3xl font-black text-emerald-600">
                            <?php echo e($counts['ready']); ?>

                        </p>
                    </div>

                    <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-emerald-50 text-xl">
                        ✓
                    </div>
                </div>
            </div>

        </div>

        
        <div class="mb-6 rounded-2xl border border-slate-200 bg-white p-4 shadow-sm">

            <div class="grid grid-cols-1 gap-3 md:grid-cols-3">

                <div>
                    <label class="mb-1.5 block text-xs font-bold uppercase tracking-wide text-slate-500">
                        Status
                    </label>

                    <select
                        wire:model.live="statusFilter"
                        class="w-full rounded-xl border-slate-200 text-sm focus:border-orange-500 focus:ring-orange-500"
                    >
                        <option value="active">Active KOTs</option>
                        <option value="all">All KOTs</option>
                        <option value="new">New</option>
                        <option value="preparing">Preparing</option>
                        <option value="ready">Ready</option>
                        <option value="served">Served</option>
                        <option value="cancelled">Cancelled</option>
                    </select>
                </div>

                <div>
                    <label class="mb-1.5 block text-xs font-bold uppercase tracking-wide text-slate-500">
                        Branch
                    </label>

                    <select
                        wire:model.live="branchFilter"
                        class="w-full rounded-xl border-slate-200 text-sm focus:border-orange-500 focus:ring-orange-500"
                    >
                        <option value="">All Branches</option>

                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $branches; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $branch): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                            <option value="<?php echo e($branch->id); ?>">
                                <?php echo e($branch->name); ?>

                            </option>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                    </select>
                </div>

                <div>
                    <label class="mb-1.5 block text-xs font-bold uppercase tracking-wide text-slate-500">
                        Search
                    </label>

                    <input
                        type="text"
                        wire:model.live.debounce.300ms="search"
                        placeholder="Search KOT or Order..."
                        class="w-full rounded-xl border-slate-200 text-sm focus:border-orange-500 focus:ring-orange-500"
                    >
                </div>

            </div>
        </div>

        
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($kots->count()): ?>

            <div class="grid grid-cols-1 gap-5 md:grid-cols-2 xl:grid-cols-3">

                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $kots; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $kot): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>

                    <?php
                        $statusClasses = match ($kot->status) {
                            'new' => 'border-blue-200 bg-blue-50/40',
                            'preparing' => 'border-amber-200 bg-amber-50/40',
                            'ready' => 'border-emerald-200 bg-emerald-50/40',
                            'served' => 'border-slate-200 bg-slate-50',
                            'cancelled' => 'border-red-200 bg-red-50/40',
                            default => 'border-slate-200 bg-white',
                        };

                        $badgeClasses = match ($kot->status) {
                            'new' => 'bg-blue-100 text-blue-700',
                            'preparing' => 'bg-amber-100 text-amber-700',
                            'ready' => 'bg-emerald-100 text-emerald-700',
                            'served' => 'bg-slate-200 text-slate-700',
                            'cancelled' => 'bg-red-100 text-red-700',
                            default => 'bg-slate-100 text-slate-700',
                        };
                    ?>

                    <div
                        <?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::$currentLoop['key'] = 'kot-'.e($kot->id).''; ?>wire:key="kot-<?php echo e($kot->id); ?>"
                        class="overflow-hidden rounded-2xl border-2 <?php echo e($statusClasses); ?> shadow-sm"
                    >

                        
                        <div class="border-b border-slate-200/70 bg-white/80 px-5 py-4">

                            <div class="flex items-start justify-between gap-3">

                                <div>
                                    <p class="text-xs font-bold uppercase tracking-wider text-slate-400">
                                        Kitchen Order
                                    </p>

                                    <h2 class="mt-1 text-xl font-black text-slate-900">
                                        <?php echo e($kot->kot_number); ?>

                                    </h2>

                                    <p class="mt-1 text-xs text-slate-500">
                                        Order #<?php echo e($kot->order?->order_number); ?>

                                    </p>
                                </div>

                                <span class="rounded-full px-3 py-1 text-xs font-bold uppercase <?php echo e($badgeClasses); ?>">
                                    <?php echo e($kot->status); ?>

                                </span>

                            </div>

                            <div class="mt-4 flex flex-wrap gap-2 text-xs font-semibold text-slate-600">

                                <span class="rounded-lg bg-slate-100 px-2.5 py-1.5">
                                    🏢 <?php echo e($kot->branch?->name); ?>

                                </span>

                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($kot->table): ?>
                                    <span class="rounded-lg bg-slate-100 px-2.5 py-1.5">
                                        🪑 <?php echo e($kot->table->name); ?>

                                    </span>
                                <?php else: ?>
                                    <span class="rounded-lg bg-slate-100 px-2.5 py-1.5">
                                        🛍 Takeaway
                                    </span>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                            </div>

                        </div>

                        
                        <div class="bg-white px-5 py-4">

                            <p class="mb-3 text-xs font-bold uppercase tracking-wider text-slate-400">
                                Items
                            </p>

                            <div class="space-y-3">

                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $kot->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>

                                    <div class="flex items-start gap-3">

                                        <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-orange-100 text-sm font-black text-orange-700">
                                            <?php echo e($item->quantity); ?>

                                        </div>

                                        <div class="min-w-0 flex-1">

                                            <p class="font-bold text-slate-900">
                                                <?php echo e($item->item_name); ?>

                                            </p>

                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($item->notes): ?>
                                                <p class="mt-1 text-xs text-slate-500">
                                                    Note: <?php echo e($item->notes); ?>

                                                </p>
                                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                                        </div>

                                    </div>

                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>

                            </div>

                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($kot->notes): ?>
                                <div class="mt-4 rounded-xl bg-yellow-50 p-3">
                                    <p class="text-xs font-bold uppercase text-yellow-700">
                                        Kitchen Note
                                    </p>

                                    <p class="mt-1 text-sm text-yellow-900">
                                        <?php echo e($kot->notes); ?>

                                    </p>
                                </div>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                        </div>

                        
                        <div class="border-t border-slate-200 bg-white px-5 py-4">

                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($kot->status === 'new'): ?>

                                <button
                                    wire:click="updateStatus(<?php echo e($kot->id); ?>, 'preparing')"
                                    wire:loading.attr="disabled"
                                    class="w-full rounded-xl bg-amber-500 px-4 py-3 text-sm font-black text-white transition hover:bg-amber-600 disabled:opacity-50"
                                >
                                    👨‍🍳 Start Preparing
                                </button>

                            <?php elseif($kot->status === 'preparing'): ?>

                                <button
                                    wire:click="updateStatus(<?php echo e($kot->id); ?>, 'ready')"
                                    wire:loading.attr="disabled"
                                    class="w-full rounded-xl bg-emerald-600 px-4 py-3 text-sm font-black text-white transition hover:bg-emerald-700 disabled:opacity-50"
                                >
                                    ✓ Mark Ready
                                </button>

                            <?php elseif($kot->status === 'ready'): ?>

                                <button
                                    wire:click="updateStatus(<?php echo e($kot->id); ?>, 'served')"
                                    wire:loading.attr="disabled"
                                    class="w-full rounded-xl bg-blue-600 px-4 py-3 text-sm font-black text-white transition hover:bg-blue-700 disabled:opacity-50"
                                >
                                    🍽 Mark Served
                                </button>

                            <?php elseif($kot->status === 'served'): ?>

                                <div class="rounded-xl bg-slate-100 px-4 py-3 text-center text-sm font-bold text-slate-600">
                                    ✓ Order Served
                                </div>

                            <?php elseif($kot->status === 'cancelled'): ?>

                                <div class="rounded-xl bg-red-100 px-4 py-3 text-center text-sm font-bold text-red-700">
                                    KOT Cancelled
                                </div>

                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                        </div>

                    </div>

                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>

            </div>

        <?php else: ?>

            <div class="rounded-2xl border border-dashed border-slate-300 bg-white px-6 py-16 text-center">

                <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-2xl bg-orange-50 text-3xl">
                    👨‍🍳
                </div>

                <h3 class="mt-5 text-xl font-black text-slate-900">
                    No kitchen orders
                </h3>

                <p class="mx-auto mt-2 max-w-md text-sm text-slate-500">
                    New KOTs will automatically appear here when an order is placed from POS.
                </p>

                <a
                    href="<?php echo e(route('pos')); ?>"
                    wire:navigate
                    class="mt-6 inline-flex rounded-xl bg-slate-900 px-5 py-3 text-sm font-bold text-white hover:bg-slate-800"
                >
                    Open POS
                </a>

            </div>

        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    </div>
</div><?php /**PATH D:\ITDA\restaurant-saas\storage\framework\views/livewire/views/c429daa6.blade.php ENDPATH**/ ?>