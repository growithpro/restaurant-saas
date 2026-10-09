<div class="space-y-6">

    {{-- Page Header --}}
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-black tracking-tight text-gray-900">
                Recipes
            </h1>

            <p class="mt-1 text-sm text-gray-500">
                Configure ingredients required for each menu item.
            </p>
        </div>

        <div class="rounded-2xl border border-orange-100 bg-orange-50 px-4 py-3">
            <div class="text-xs font-bold uppercase tracking-wider text-orange-500">
                Recipe System
            </div>

            <div class="mt-1 text-sm font-semibold text-orange-900">
                Menu → Ingredients → Stock Deduction
            </div>
        </div>
    </div>


    {{-- Flash Message --}}
    @if (session()->has('success'))
        <div
            class="rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-semibold text-emerald-700"
        >
            {{ session('success') }}
        </div>
    @endif


    {{-- Validation Errors --}}
    @if ($errors->any())
        <div class="rounded-2xl border border-red-200 bg-red-50 p-4">
            <div class="font-bold text-red-800">
                Please fix the following:
            </div>

            <ul class="mt-2 list-disc space-y-1 pl-5 text-sm text-red-700">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif


    {{-- Search --}}
    <div class="rounded-2xl border border-gray-200 bg-white p-4 shadow-sm">
        <div class="relative">
            <span class="pointer-events-none absolute left-4 top-1/2 -translate-y-1/2 text-gray-400">
                🔎
            </span>

            <input
                type="text"
                wire:model.live.debounce.300ms="search"
                placeholder="Search menu items..."
                class="w-full rounded-xl border border-gray-200 bg-gray-50 py-3 pl-11 pr-4 text-sm font-medium outline-none transition focus:border-orange-400 focus:bg-white focus:ring-2 focus:ring-orange-100"
            >
        </div>
    </div>


    {{-- Menu Items --}}
    <div class="grid gap-6 xl:grid-cols-2">

        @forelse ($menuItems as $menuItem)

            <div
                wire:key="menu-item-{{ $menuItem->id }}"
                class="overflow-hidden rounded-3xl border border-gray-200 bg-white shadow-sm transition hover:shadow-md"
            >

                {{-- Menu Item Header --}}
                <div class="border-b border-gray-100 bg-gradient-to-r from-gray-50 to-white p-5">

                    <div class="flex items-start justify-between gap-4">

                        <div class="min-w-0">

                            <div class="flex flex-wrap items-center gap-2">

                                <h2 class="text-lg font-black text-gray-900">
                                    {{ $menuItem->name }}
                                </h2>

                                @if ($menuItem->category)
                                    <span
                                        class="rounded-full bg-orange-100 px-2.5 py-1 text-[11px] font-bold text-orange-700"
                                    >
                                        {{ $menuItem->category->name }}
                                    </span>
                                @endif

                            </div>

                            <div class="mt-1 text-xs font-medium text-gray-400">
                                {{ $menuItem->code }}
                            </div>

                        </div>


                        <div class="shrink-0 rounded-xl bg-gray-100 px-3 py-2 text-right">

                            <div class="text-[10px] font-bold uppercase tracking-wider text-gray-400">
                                Price
                            </div>

                            <div class="text-sm font-black text-gray-900">
                                ₹{{ number_format((float) $menuItem->price, 2) }}
                            </div>

                        </div>

                    </div>

                </div>


                {{-- Ingredients --}}
                <div class="p-5">

                    <div class="mb-4 flex items-center justify-between">

                        <div>
                            <h3 class="text-sm font-black text-gray-900">
                                Ingredients
                            </h3>

                            <p class="mt-0.5 text-xs text-gray-400">
                                Required stock per 1 serving
                            </p>
                        </div>

                        <div
                            class="rounded-full bg-gray-100 px-3 py-1 text-xs font-bold text-gray-600"
                        >
                            {{ $menuItem->recipes->count() }}
                            {{ $menuItem->recipes->count() === 1 ? 'Ingredient' : 'Ingredients' }}
                        </div>

                    </div>


                    {{-- Existing Recipe Ingredients --}}
                    @if ($menuItem->recipes->count())

                        <div class="space-y-2">

                            @foreach ($menuItem->recipes as $recipe)

                                <div
                                    wire:key="recipe-{{ $recipe->id }}"
                                    class="flex items-center justify-between gap-3 rounded-2xl border border-gray-100 bg-gray-50 p-3"
                                >

                                    <div class="flex min-w-0 items-center gap-3">

                                        <div
                                            class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-orange-100 text-lg"
                                        >
                                            🧪
                                        </div>

                                        <div class="min-w-0">

                                            <div class="truncate text-sm font-bold text-gray-900">
                                                {{ $recipe->inventoryItem->name }}
                                            </div>

                                            @if ($recipe->notes)
                                                <div class="mt-0.5 truncate text-xs text-gray-400">
                                                    {{ $recipe->notes }}
                                                </div>
                                            @endif

                                        </div>

                                    </div>


                                    <div class="shrink-0 text-right">

                                        <div class="text-sm font-black text-gray-900">
                                            {{ number_format((float) $recipe->quantity, 3) }}
                                            {{ $recipe->inventoryItem->unit }}
                                        </div>

                                        <button
                                            type="button"
                                            wire:click="removeIngredient({{ $recipe->id }})"
                                            wire:confirm="Remove this ingredient from the recipe?"
                                            wire:loading.attr="disabled"
                                            class="mt-1 text-[11px] font-bold text-red-500 transition hover:text-red-700 disabled:opacity-50"
                                        >
                                            Remove
                                        </button>

                                    </div>

                                </div>

                            @endforeach

                        </div>

                    @else

                        <div class="rounded-2xl border border-dashed border-gray-200 bg-gray-50 px-5 py-8 text-center">

                            <div class="text-3xl">
                                🧪
                            </div>

                            <div class="mt-2 text-sm font-bold text-gray-700">
                                No ingredients configured
                            </div>

                            <div class="mt-1 text-xs text-gray-400">
                                Add ingredients below to create this recipe.
                            </div>

                        </div>

                    @endif


                    {{-- Add Ingredient Form --}}
                    <div class="mt-5 rounded-2xl border border-orange-100 bg-orange-50/50 p-4">

                        <div class="mb-3">

                            <div class="text-sm font-black text-gray-900">
                                Add Ingredient
                            </div>

                            <div class="mt-0.5 text-xs text-gray-500">
                                Select the inventory item and quantity required for one serving.
                            </div>

                        </div>


                        <div class="grid gap-3 sm:grid-cols-2">

                            {{-- Inventory Item --}}
                            <div class="sm:col-span-2">

                                <label class="mb-1.5 block text-xs font-bold text-gray-700">
                                    Inventory Item
                                </label>

                                <select
                                    wire:model="inventoryItemId"
                                    class="w-full rounded-xl border border-gray-200 bg-white px-3 py-3 text-sm font-medium outline-none transition focus:border-orange-400 focus:ring-2 focus:ring-orange-100"
                                >

                                    <option value="">
                                        Select ingredient
                                    </option>

                                    @foreach ($inventoryItems as $inventoryItem)

                                        <option value="{{ $inventoryItem->id }}">
                                            {{ $inventoryItem->name }}
                                            — Stock:
                                            {{ number_format((float) $inventoryItem->current_stock, 3) }}
                                            {{ $inventoryItem->unit }}
                                        </option>

                                    @endforeach

                                </select>

                                @error('inventoryItemId')
                                    <div class="mt-1 text-xs font-semibold text-red-600">
                                        {{ $message }}
                                    </div>
                                @enderror

                            </div>


                            {{-- Quantity --}}
                            <div>

                                <label class="mb-1.5 block text-xs font-bold text-gray-700">
                                    Quantity
                                </label>

                                <input
                                    type="number"
                                    step="0.001"
                                    min="0.001"
                                    wire:model="quantity"
                                    placeholder="e.g. 0.200"
                                    class="w-full rounded-xl border border-gray-200 bg-white px-3 py-3 text-sm font-medium outline-none transition focus:border-orange-400 focus:ring-2 focus:ring-orange-100"
                                >

                                @error('quantity')
                                    <div class="mt-1 text-xs font-semibold text-red-600">
                                        {{ $message }}
                                    </div>
                                @enderror

                            </div>


                            {{-- Notes --}}
                            <div>

                                <label class="mb-1.5 block text-xs font-bold text-gray-700">
                                    Notes
                                </label>

                                <input
                                    type="text"
                                    wire:model="notes"
                                    placeholder="Optional"
                                    class="w-full rounded-xl border border-gray-200 bg-white px-3 py-3 text-sm font-medium outline-none transition focus:border-orange-400 focus:ring-2 focus:ring-orange-100"
                                >

                                @error('notes')
                                    <div class="mt-1 text-xs font-semibold text-red-600">
                                        {{ $message }}
                                    </div>
                                @enderror

                            </div>

                        </div>


                        {{-- IMPORTANT: Menu Item ID is passed directly --}}
                        <button
                            type="button"
                            wire:click="addIngredient({{ $menuItem->id }})"
                            wire:loading.attr="disabled"
                            class="mt-3 flex w-full items-center justify-center rounded-xl bg-orange-500 px-4 py-3 text-sm font-black text-white transition hover:bg-orange-600 disabled:cursor-not-allowed disabled:opacity-50"
                        >

                            <span
                                wire:loading.remove
                                wire:target="addIngredient({{ $menuItem->id }})"
                            >
                                + Add Ingredient
                            </span>

                            <span
                                wire:loading
                                wire:target="addIngredient({{ $menuItem->id }})"
                            >
                                Adding...
                            </span>

                        </button>

                    </div>

                </div>

            </div>

        @empty

            {{-- Empty State --}}
            <div class="xl:col-span-2 rounded-3xl border border-dashed border-gray-300 bg-white px-6 py-14 text-center">

                <div class="text-4xl">
                    🍽️
                </div>

                <h3 class="mt-3 text-lg font-black text-gray-900">
                    No menu items found
                </h3>

                <p class="mt-1 text-sm text-gray-500">
                    Create some menu items first, then configure their recipes here.
                </p>

            </div>

        @endforelse

    </div>


    {{-- Loading Overlay --}}
    <div
        wire:loading.flex
        wire:target="addIngredient,removeIngredient"
        class="fixed inset-0 z-50 items-center justify-center bg-black/20 backdrop-blur-[2px]"
    >
        <div class="rounded-2xl bg-white px-6 py-5 shadow-xl">

            <div class="flex items-center gap-3">

                <div class="h-5 w-5 animate-spin rounded-full border-2 border-orange-200 border-t-orange-500"></div>

                <span class="text-sm font-bold text-gray-700">
                    Updating recipe...
                </span>

            </div>

        </div>
    </div>

</div>