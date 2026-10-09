<div class="min-h-screen bg-gray-50">

    <div class="mx-auto max-w-7xl px-4 py-6">

        {{-- Header --}}
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
                href="{{ route('orders') }}"
                wire:navigate
                class="rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-semibold text-gray-700 hover:bg-gray-50"
            >
                View Orders
            </a>

        </div>

        @if (session('success'))
            <div class="mb-6 rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700">
                {{ session('success') }}
            </div>
        @endif

        {{-- Main Grid --}}
        <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">

            {{-- LEFT: MENU --}}
            <div class="lg:col-span-2">

                {{-- Order Settings --}}
                <div class="mb-6 rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">

                    <div class="grid grid-cols-1 gap-4 md:grid-cols-3">

                        {{-- Branch --}}
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

                                @foreach ($branches as $branch)
                                    <option value="{{ $branch->id }}">
                                        {{ $branch->name }}
                                    </option>
                                @endforeach
                            </select>

                            @error('branchId')
                                <p class="mt-1 text-xs text-red-600">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        {{-- Order Type --}}
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

                        {{-- Table --}}
                        @if ($orderType === 'dine_in')
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

                                    @foreach ($tables as $table)
                                        <option value="{{ $table->id }}">
                                            {{ $table->name }}
                                            ({{ $table->capacity }} seats)
                                        </option>
                                    @endforeach
                                </select>

                                @error('tableId')
                                    <p class="mt-1 text-xs text-red-600">
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
                        @endif

                    </div>

                </div>

                {{-- Search --}}
                <div class="mb-4">

                    <input
                        type="text"
                        wire:model.live.debounce.300ms="search"
                        placeholder="Search menu items..."
                        class="w-full rounded-xl border-gray-300 bg-white px-4 py-3 text-sm shadow-sm focus:border-gray-900 focus:ring-gray-900"
                    >

                </div>

                {{-- Categories --}}
                <div class="mb-5 flex gap-2 overflow-x-auto pb-2">

                    <button
                        type="button"
                        wire:click="$set('categoryId', '')"
                        class="{{ !$categoryId ? 'bg-gray-900 text-white' : 'bg-white text-gray-700 border border-gray-200' }} whitespace-nowrap rounded-lg px-4 py-2 text-sm font-semibold"
                    >
                        All
                    </button>

                    @foreach ($categories as $category)

                        <button
                            type="button"
                            wire:click="$set('categoryId', {{ $category->id }})"
                            class="{{ (string) $categoryId === (string) $category->id ? 'bg-gray-900 text-white' : 'bg-white text-gray-700 border border-gray-200' }} whitespace-nowrap rounded-lg px-4 py-2 text-sm font-semibold"
                        >
                            {{ $category->name }}
                        </button>

                    @endforeach

                </div>

                {{-- Menu --}}
                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-3">

                    @forelse ($menuItems as $item)

                        <button
                            type="button"
                            wire:click="addToCart({{ $item->id }})"
                            class="group overflow-hidden rounded-2xl border border-gray-200 bg-white text-left shadow-sm transition hover:-translate-y-0.5 hover:shadow-md"
                        >

                            @if ($item->image)
                                <img
                                    src="{{ asset('storage/' . $item->image) }}"
                                    alt="{{ $item->name }}"
                                    class="h-36 w-full object-cover"
                                >
                            @else
                                <div class="flex h-36 items-center justify-center bg-gray-100 text-3xl">
                                    🍽️
                                </div>
                            @endif

                            <div class="p-4">

                                <div class="flex items-start justify-between gap-3">

                                    <div>
                                        <h3 class="font-semibold text-gray-900">
                                            {{ $item->name }}
                                        </h3>

                                        <p class="mt-1 text-xs text-gray-500">
                                            {{ $item->category?->name }}
                                        </p>
                                    </div>

                                    <span class="font-bold text-gray-900">
                                        ₹{{ number_format($item->price, 2) }}
                                    </span>

                                </div>

                            </div>

                        </button>

                    @empty

                        <div class="col-span-full rounded-2xl border border-dashed border-gray-300 bg-white p-10 text-center">

                            <p class="font-medium text-gray-700">
                                No menu items found
                            </p>

                            <p class="mt-1 text-sm text-gray-500">
                                Try another category or search.
                            </p>

                        </div>

                    @endforelse

                </div>

            </div>

            {{-- RIGHT: CART --}}
            <div class="lg:col-span-1">

                <div class="sticky top-6 overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">

                    <div class="flex items-center justify-between border-b border-gray-200 p-5">

                        <div>
                            <h2 class="font-bold text-gray-900">
                                Current Order
                            </h2>

                            <p class="text-xs text-gray-500">
                                {{ count($cart) }} item types
                            </p>
                        </div>

                        @if (count($cart))
                            <button
                                type="button"
                                wire:click="clearCart"
                                class="text-xs font-semibold text-red-600 hover:text-red-700"
                            >
                                Clear
                            </button>
                        @endif

                    </div>

                    @error('cart')
                        <div class="border-b border-red-100 bg-red-50 px-5 py-3 text-sm text-red-600">
                            {{ $message }}
                        </div>
                    @enderror

                    <div class="max-h-[420px] overflow-y-auto">

                        @forelse ($cart as $item)

                            <div class="border-b border-gray-100 p-4">

                                <div class="flex justify-between gap-3">

                                    <div class="min-w-0">

                                        <p class="font-semibold text-gray-900">
                                            {{ $item['name'] }}
                                        </p>

                                        <p class="mt-1 text-xs text-gray-500">
                                            ₹{{ number_format($item['price'], 2) }}
                                            each
                                        </p>

                                    </div>

                                    <button
                                        type="button"
                                        wire:click="removeFromCart({{ $item['id'] }})"
                                        class="text-xs text-red-500"
                                    >
                                        Remove
                                    </button>

                                </div>

                                <div class="mt-3 flex items-center justify-between">

                                    <div class="flex items-center rounded-lg border border-gray-200">

                                        <button
                                            type="button"
                                            wire:click="decreaseQuantity({{ $item['id'] }})"
                                            class="px-3 py-1.5 text-gray-600 hover:bg-gray-50"
                                        >
                                            −
                                        </button>

                                        <span class="px-3 text-sm font-semibold">
                                            {{ $item['quantity'] }}
                                        </span>

                                        <button
                                            type="button"
                                            wire:click="increaseQuantity({{ $item['id'] }})"
                                            class="px-3 py-1.5 text-gray-600 hover:bg-gray-50"
                                        >
                                            +
                                        </button>

                                    </div>

                                    <span class="font-bold text-gray-900">
                                        ₹{{ number_format($item['price'] * $item['quantity'], 2) }}
                                    </span>

                                </div>

                            </div>

                        @empty

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

                        @endforelse

                    </div>

                    {{-- Totals --}}
                    <div class="border-t border-gray-200 p-5">

                        <div class="space-y-3">

                            <div class="flex justify-between text-sm">
                                <span class="text-gray-500">
                                    Subtotal
                                </span>

                                <span class="font-medium">
                                    ₹{{ number_format($this->subtotal, 2) }}
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
                                        ₹{{ number_format($this->grandTotal, 2) }}
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

</div>