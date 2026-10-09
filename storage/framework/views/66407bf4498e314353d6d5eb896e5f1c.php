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
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $branches; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $branch): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                            <option value="<?php echo e($branch->id); ?>">
                                <?php echo e($branch->name); ?>

                            </option>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
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

        
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">
            <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">
                <p class="text-sm text-gray-500">Net recorded sales</p>
                <p class="mt-2 text-2xl font-bold text-gray-900">
                    ₹<?php echo e(number_format($totalSales, 2)); ?>

                </p>
                <p class="mt-1 text-xs text-gray-500">Excludes cancelled orders</p>
            </div>

            <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">
                <p class="text-sm text-gray-500">Non-cancelled orders</p>
                <p class="mt-2 text-2xl font-bold text-gray-900">
                    <?php echo e(number_format($totalOrders)); ?>

                </p>
                <p class="mt-1 text-xs text-gray-500">Orders in selected period</p>
            </div>

            <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">
                <p class="text-sm text-gray-500">Average order value</p>
                <p class="mt-2 text-2xl font-bold text-gray-900">
                    ₹<?php echo e(number_format($averageOrderValue, 2)); ?>

                </p>
                <p class="mt-1 text-xs text-gray-500">Sales divided by orders</p>
            </div>

            <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">
                <p class="text-sm text-gray-500">Completed orders</p>
                <p class="mt-2 text-2xl font-bold text-gray-900">
                    <?php echo e(number_format($completedOrders)); ?>

                </p>
                <p class="mt-1 text-xs text-gray-500">
                    Cancelled: <?php echo e(number_format($cancelledOrders)); ?>

                </p>
            </div>
        </div>

        
        <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">
            <div class="mb-5">
                <h2 class="text-lg font-bold text-gray-900">Daily sales</h2>
                <p class="text-sm text-gray-500">
                    Revenue by order date, excluding cancelled orders
                </p>
            </div>

            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($chart->isEmpty()): ?>
                <p class="py-10 text-center text-sm text-gray-500">
                    No sales data for this period.
                </p>
            <?php else: ?>
                <div class="flex h-64 items-end gap-2 overflow-x-auto border-b border-gray-200 pb-2">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $chart; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $day): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                        <div
                            class="flex h-full min-w-8 flex-1 flex-col items-center justify-end gap-2"
                            title="<?php echo e($day['date']); ?>: ₹<?php echo e(number_format($day['revenue'], 2)); ?> (<?php echo e($day['orders']); ?> orders)"
                        >
                            <div class="text-center text-xs text-gray-500">
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($day['revenue'] > 0): ?>
                                    ₹<?php echo e(number_format($day['revenue'], 0)); ?>

                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </div>
                            <div
                                class="w-full max-w-12 rounded-t-md bg-indigo-500 hover:bg-indigo-600"
                                style="height: <?php echo e($day['revenue'] > 0 ? max(3, ($day['revenue'] / $maxRevenue) * 150) : 2); ?>px"
                            ></div>
                            <span class="whitespace-nowrap text-[10px] text-gray-500">
                                <?php echo e($day['label']); ?>

                            </span>
                        </div>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>

        
        <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">
            <h2 class="mb-4 text-lg font-bold text-gray-900">Order status breakdown</h2>

            <div class="grid grid-cols-2 gap-3 sm:grid-cols-3 lg:grid-cols-6">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = ['pending', 'preparing', 'ready', 'served', 'completed', 'cancelled']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $status): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                    <div class="rounded-xl bg-gray-50 p-4">
                        <p class="text-sm capitalize text-gray-500"><?php echo e($status); ?></p>
                        <p class="mt-1 text-2xl font-bold text-gray-900">
                            <?php echo e(number_format($statusCounts[$status] ?? 0)); ?>

                        </p>
                    </div>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
            </div>
        </div>

        
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
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $topItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                            <tr>
                                <td class="px-5 py-3 text-gray-500"><?php echo e($index + 1); ?></td>
                                <td class="px-5 py-3 font-medium text-gray-900">
                                    <?php echo e($item->item_name); ?>

                                </td>
                                <td class="px-5 py-3 text-right">
                                    <?php echo e(number_format($item->quantity_sold)); ?>

                                </td>
                                <td class="px-5 py-3 text-right font-semibold">
                                    ₹<?php echo e(number_format($item->item_revenue, 2)); ?>

                                </td>
                            </tr>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                            <tr>
                                <td colspan="4" class="px-5 py-8 text-center text-gray-500">
                                    No item sales found for this period.
                                </td>
                            </tr>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        
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
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $recentOrders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                            <tr>
                                <td class="px-5 py-3 font-semibold text-gray-900">
                                    <?php echo e($order->order_number); ?>

                                </td>
                                <td class="px-5 py-3 text-gray-600">
                                    <?php echo e($order->created_at->format('d M Y, h:i A')); ?>

                                </td>
                                <td class="px-5 py-3 text-gray-600">
                                    <?php echo e($order->branch?->name ?? '—'); ?>

                                </td>
                                <td class="px-5 py-3">
                                    <span class="rounded-full bg-gray-100 px-2.5 py-1 text-xs font-medium capitalize text-gray-700">
                                        <?php echo e($order->status); ?>

                                    </span>
                                </td>
                                <td class="px-5 py-3 text-right font-semibold">
                                    ₹<?php echo e(number_format($order->grand_total, 2)); ?>

                                </td>
                            </tr>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                            <tr>
                                <td colspan="5" class="px-5 py-8 text-center text-gray-500">
                                    No orders found for this period.
                                </td>
                            </tr>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div><?php /**PATH D:\ITDA\restaurant-saas\storage\framework\views/livewire/views/1957d09c.blade.php ENDPATH**/ ?>