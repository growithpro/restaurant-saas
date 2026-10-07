<div class="min-h-screen bg-gray-50">

    <div class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">

        {{-- Header --}}
        <div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

            <div>
                <h1 class="text-3xl font-bold text-gray-900">
                    Menu Items
                </h1>

                <p class="mt-1 text-sm text-gray-500">
                    Manage dishes, prices, categories and availability.
                </p>
            </div>

            <button
                wire:click="openCreate"
                class="rounded-xl bg-gray-900 px-5 py-3 text-sm font-semibold text-white shadow-sm hover:bg-gray-800"
            >
                + Add Menu Item
            </button>

        </div>

        {{-- Flash --}}
        @if (session()->has('success'))
            <div class="mb-6 rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700">
                {{ session('success') }}
            </div>
        @endif

        @if (session()->has('error'))
            <div class="mb-6 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                {{ session('error') }}
            </div>
        @endif

        {{-- Form --}}
        @if ($showForm)

            <div class="mb-8 rounded-2xl border border-gray-200 bg-white p-6 shadow-sm">

                <div class="mb-6">
                    <h2 class="text-xl font-bold text-gray-900">
                        {{ $editingMenuItemId ? 'Edit Menu Item' : 'Create Menu Item' }}
                    </h2>

                    <p class="mt-1 text-sm text-gray-500">
                        Enter the details of your menu item.
                    </p>
                </div>

                <form wire:submit="save" class="space-y-6">

                    <div class="grid gap-6 md:grid-cols-2">

                        {{-- Category --}}
                        <div>
                            <label class="mb-2 block text-sm font-semibold text-gray-700">
                                Category
                            </label>

                            <select
                                wire:model="categoryId"
                                class="w-full rounded-xl border border-gray-300 bg-white px-4 py-3 text-sm outline-none focus:border-gray-900 focus:ring-2 focus:ring-gray-900/10"
                            >
                                <option value="">
                                    Select category
                                </option>

                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">
                                        {{ $category->name }}
                                    </option>
                                @endforeach

                            </select>

                            @error('categoryId')
                                <p class="mt-2 text-sm text-red-600">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        {{-- Name --}}
                        <div>
                            <label class="mb-2 block text-sm font-semibold text-gray-700">
                                Item Name
                            </label>

                            <input
                                type="text"
                                wire:model="name"
                                placeholder="e.g. Paneer Tikka"
                                class="w-full rounded-xl border border-gray-300 px-4 py-3 text-sm outline-none focus:border-gray-900 focus:ring-2 focus:ring-gray-900/10"
                            >

                            @error('name')
                                <p class="mt-2 text-sm text-red-600">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        {{-- Code --}}
                        <div>
                            <label class="mb-2 block text-sm font-semibold text-gray-700">
                                Item Code
                            </label>

                            <input
                                type="text"
                                wire:model="code"
                                placeholder="e.g. PT001"
                                class="w-full rounded-xl border border-gray-300 px-4 py-3 text-sm uppercase outline-none focus:border-gray-900 focus:ring-2 focus:ring-gray-900/10"
                            >

                            @error('code')
                                <p class="mt-2 text-sm text-red-600">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        {{-- Price --}}
                        <div>
                            <label class="mb-2 block text-sm font-semibold text-gray-700">
                                Price
                            </label>

                            <input
                                type="number"
                                step="0.01"
                                min="0"
                                wire:model="price"
                                placeholder="250.00"
                                class="w-full rounded-xl border border-gray-300 px-4 py-3 text-sm outline-none focus:border-gray-900 focus:ring-2 focus:ring-gray-900/10"
                            >

                            @error('price')
                                <p class="mt-2 text-sm text-red-600">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        {{-- Sort --}}
                        <div>
                            <label class="mb-2 block text-sm font-semibold text-gray-700">
                                Sort Order
                            </label>

                            <input
                                type="number"
                                min="0"
                                wire:model="sortOrder"
                                class="w-full rounded-xl border border-gray-300 px-4 py-3 text-sm outline-none focus:border-gray-900 focus:ring-2 focus:ring-gray-900/10"
                            >

                            @error('sortOrder')
                                <p class="mt-2 text-sm text-red-600">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                    </div>

                    {{-- Description --}}
                    <div>
                        <label class="mb-2 block text-sm font-semibold text-gray-700">
                            Description
                        </label>

                        <textarea
                            wire:model="description"
                            rows="4"
                            placeholder="Describe the dish..."
                            class="w-full rounded-xl border border-gray-300 px-4 py-3 text-sm outline-none focus:border-gray-900 focus:ring-2 focus:ring-gray-900/10"
                        ></textarea>

                        @error('description')
                            <p class="mt-2 text-sm text-red-600">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    {{-- Image --}}
                    <div>
                        <label class="mb-2 block text-sm font-semibold text-gray-700">
                            Menu Image
                        </label>

                        <input
                            type="file"
                            wire:model="image"
                            accept="image/*"
                            class="block w-full rounded-xl border border-gray-300 bg-white text-sm text-gray-700 file:mr-4 file:border-0 file:bg-gray-100 file:px-4 file:py-3 file:text-sm file:font-semibold"
                        >

                        <p class="mt-2 text-xs text-gray-500">
                            JPG, PNG, WEBP. Maximum 2MB.
                        </p>

                        @error('image')
                            <p class="mt-2 text-sm text-red-600">
                                {{ $message }}
                            </p>
                        @enderror

                        @if ($image)
                            <div class="mt-4">
                                <p class="mb-2 text-xs font-semibold text-gray-500">
                                    New image preview
                                </p>

                                <img
                                    src="{{ $image->temporaryUrl() }}"
                                    class="h-32 w-32 rounded-xl object-cover"
                                    alt="Preview"
                                >
                            </div>
                        @elseif ($existingImage)
                            <div class="mt-4">

                                <p class="mb-2 text-xs font-semibold text-gray-500">
                                    Current image
                                </p>

                                <div class="flex items-start gap-3">

                                    <img
                                        src="{{ asset('storage/' . $existingImage) }}"
                                        class="h-32 w-32 rounded-xl object-cover"
                                        alt="{{ $name }}"
                                    >

                                    <button
                                        type="button"
                                        wire:click="removeExistingImage"
                                        class="rounded-lg border border-red-200 px-3 py-2 text-xs font-semibold text-red-600 hover:bg-red-50"
                                    >
                                        Remove Image
                                    </button>

                                </div>

                            </div>
                        @endif

                    </div>

                    {{-- Availability --}}
                    <label class="flex items-center gap-3">

                        <input
                            type="checkbox"
                            wire:model="isAvailable"
                            class="h-4 w-4 rounded border-gray-300"
                        >

                        <span class="text-sm font-medium text-gray-700">
                            Item is currently available
                        </span>

                    </label>

                    {{-- Buttons --}}
                    <div class="flex gap-3">

                        <button
                            type="submit"
                            class="rounded-xl bg-gray-900 px-5 py-3 text-sm font-semibold text-white hover:bg-gray-800"
                        >
                            {{ $editingMenuItemId ? 'Update Menu Item' : 'Create Menu Item' }}
                        </button>

                        <button
                            type="button"
                            wire:click="cancel"
                            class="rounded-xl border border-gray-300 bg-white px-5 py-3 text-sm font-semibold text-gray-700 hover:bg-gray-50"
                        >
                            Cancel
                        </button>

                    </div>

                </form>

            </div>

        @endif

        {{-- Filters --}}
        <div class="mb-6 grid gap-4 md:grid-cols-2">

            <input
                type="text"
                wire:model.live.debounce.300ms="search"
                placeholder="Search menu items..."
                class="w-full rounded-xl border border-gray-300 bg-white px-4 py-3 text-sm outline-none focus:border-gray-900 focus:ring-2 focus:ring-gray-900/10"
            >

            <select
                wire:model.live="filterCategoryId"
                class="w-full rounded-xl border border-gray-300 bg-white px-4 py-3 text-sm outline-none focus:border-gray-900 focus:ring-2 focus:ring-gray-900/10"
            >
                <option value="">
                    All Categories
                </option>

                @foreach ($categories as $category)
                    <option value="{{ $category->id }}">
                        {{ $category->name }}
                    </option>
                @endforeach

            </select>

        </div>

        {{-- Menu Items --}}
        @if ($menuItems->count())

            <div class="grid gap-5 md:grid-cols-2 lg:grid-cols-3">

                @foreach ($menuItems as $item)

                    <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm transition hover:shadow-md">

                        {{-- Image --}}
                        @if ($item->image)

                            <img
                                src="{{ asset('storage/' . $item->image) }}"
                                alt="{{ $item->name }}"
                                class="h-48 w-full object-cover"
                            >

                        @else

                            <div class="flex h-48 w-full items-center justify-center bg-gray-100">

                                <span class="text-sm font-medium text-gray-400">
                                    No Image
                                </span>

                            </div>

                        @endif

                        <div class="p-5">

                            <div class="flex items-start justify-between gap-3">

                                <div>

                                    <p class="text-xs font-semibold uppercase tracking-wide text-gray-400">
                                        {{ $item->category?->name }}
                                    </p>

                                    <h3 class="mt-1 text-lg font-bold text-gray-900">
                                        {{ $item->name }}
                                    </h3>

                                </div>

                                @if ($item->is_available)

                                    <span class="shrink-0 rounded-full bg-green-100 px-3 py-1 text-xs font-semibold text-green-700">
                                        Available
                                    </span>

                                @else

                                    <span class="shrink-0 rounded-full bg-gray-100 px-3 py-1 text-xs font-semibold text-gray-500">
                                        Unavailable
                                    </span>

                                @endif

                            </div>

                            @if ($item->description)

                                <p class="mt-3 line-clamp-2 text-sm text-gray-500">
                                    {{ $item->description }}
                                </p>

                            @endif

                            <div class="mt-5 grid grid-cols-2 gap-3">

                                <div class="rounded-xl bg-gray-50 p-3">

                                    <p class="text-xs text-gray-500">
                                        Price
                                    </p>

                                    <p class="mt-1 text-lg font-bold text-gray-900">
                                        ₹{{ number_format((float) $item->price, 2) }}
                                    </p>

                                </div>

                                <div class="rounded-xl bg-gray-50 p-3">

                                    <p class="text-xs text-gray-500">
                                        Code
                                    </p>

                                    <p class="mt-1 text-lg font-bold text-gray-900">
                                        {{ $item->code }}
                                    </p>

                                </div>

                            </div>

                            <div class="mt-5 flex flex-wrap gap-2">

                                <button
                                    wire:click="edit({{ $item->id }})"
                                    class="rounded-lg bg-gray-900 px-3 py-2 text-xs font-semibold text-white hover:bg-gray-800"
                                >
                                    Edit
                                </button>

                                <button
                                    wire:click="toggleAvailability({{ $item->id }})"
                                    class="rounded-lg border border-gray-300 px-3 py-2 text-xs font-semibold text-gray-700 hover:bg-gray-50"
                                >
                                    {{ $item->is_available ? 'Disable' : 'Enable' }}
                                </button>

                                <button
                                    wire:click="delete({{ $item->id }})"
                                    wire:confirm="Are you sure you want to delete this menu item?"
                                    class="rounded-lg border border-red-200 px-3 py-2 text-xs font-semibold text-red-600 hover:bg-red-50"
                                >
                                    Delete
                                </button>

                            </div>

                        </div>

                    </div>

                @endforeach

            </div>

        @else

            <div class="rounded-2xl border border-dashed border-gray-300 bg-white px-6 py-16 text-center">

                <h3 class="text-lg font-bold text-gray-900">
                    No menu items found
                </h3>

                <p class="mt-2 text-sm text-gray-500">
                    Add your first menu item to start building your restaurant menu.
                </p>

                @if ($categories->count())

                    <button
                        wire:click="openCreate"
                        class="mt-5 rounded-xl bg-gray-900 px-5 py-3 text-sm font-semibold text-white hover:bg-gray-800"
                    >
                        + Add First Menu Item
                    </button>

                @else

                    <a
                        href="{{ route('categories') }}"
                        class="mt-5 inline-block rounded-xl bg-gray-900 px-5 py-3 text-sm font-semibold text-white hover:bg-gray-800"
                    >
                        Create Category First
                    </a>

                @endif

            </div>

        @endif

    </div>

</div>