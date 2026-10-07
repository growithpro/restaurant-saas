<div class="min-h-screen bg-gray-50">

    <div class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">

        {{-- Header --}}
        <div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

            <div>
                <h1 class="text-3xl font-bold text-gray-900">
                    Categories
                </h1>

                <p class="mt-1 text-sm text-gray-500">
                    Organize your restaurant menu into categories.
                </p>
            </div>

            <button
                wire:click="openCreate"
                class="rounded-xl bg-gray-900 px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-gray-800"
            >
                + Add Category
            </button>

        </div>

        {{-- Flash Messages --}}
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
                        {{ $editingCategoryId ? 'Edit Category' : 'Create Category' }}
                    </h2>

                    <p class="mt-1 text-sm text-gray-500">
                        Add category information below.
                    </p>
                </div>

                <form wire:submit="save" class="space-y-6">

                    <div class="grid gap-6 md:grid-cols-2">

                        <div>
                            <label class="mb-2 block text-sm font-semibold text-gray-700">
                                Category Name
                            </label>

                            <input
                                type="text"
                                wire:model="name"
                                placeholder="e.g. Starters"
                                class="w-full rounded-xl border border-gray-300 px-4 py-3 text-sm outline-none transition focus:border-gray-900 focus:ring-2 focus:ring-gray-900/10"
                            >

                            @error('name')
                                <p class="mt-2 text-sm text-red-600">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <div>
                            <label class="mb-2 block text-sm font-semibold text-gray-700">
                                Sort Order
                            </label>

                            <input
                                type="number"
                                min="0"
                                wire:model="sortOrder"
                                class="w-full rounded-xl border border-gray-300 px-4 py-3 text-sm outline-none transition focus:border-gray-900 focus:ring-2 focus:ring-gray-900/10"
                            >

                            @error('sortOrder')
                                <p class="mt-2 text-sm text-red-600">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-semibold text-gray-700">
                            Description
                        </label>

                        <textarea
                            wire:model="description"
                            rows="3"
                            placeholder="Short description of this category..."
                            class="w-full rounded-xl border border-gray-300 px-4 py-3 text-sm outline-none transition focus:border-gray-900 focus:ring-2 focus:ring-gray-900/10"
                        ></textarea>

                        @error('description')
                            <p class="mt-2 text-sm text-red-600">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <label class="flex items-center gap-3">
                        <input
                            type="checkbox"
                            wire:model="isActive"
                            class="h-4 w-4 rounded border-gray-300"
                        >

                        <span class="text-sm font-medium text-gray-700">
                            Active category
                        </span>
                    </label>

                    <div class="flex gap-3">

                        <button
                            type="submit"
                            class="rounded-xl bg-gray-900 px-5 py-3 text-sm font-semibold text-white hover:bg-gray-800"
                        >
                            {{ $editingCategoryId ? 'Update Category' : 'Create Category' }}
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

        {{-- Search --}}
        <div class="mb-6">

            <div class="relative">

                <input
                    type="text"
                    wire:model.live.debounce.300ms="search"
                    placeholder="Search categories..."
                    class="w-full rounded-xl border border-gray-300 bg-white px-4 py-3 text-sm outline-none focus:border-gray-900 focus:ring-2 focus:ring-gray-900/10"
                >

            </div>

        </div>

        {{-- Categories --}}
        @if ($categories->count())

            <div class="grid gap-5 md:grid-cols-2 lg:grid-cols-3">

                @foreach ($categories as $category)

                    <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm transition hover:shadow-md">

                        <div class="flex items-start justify-between">

                            <div>
                                <h3 class="text-lg font-bold text-gray-900">
                                    {{ $category->name }}
                                </h3>

                                <p class="mt-1 text-sm text-gray-500">
                                    {{ $category->description ?: 'No description added.' }}
                                </p>
                            </div>

                            @if ($category->is_active)
                                <span class="rounded-full bg-green-100 px-3 py-1 text-xs font-semibold text-green-700">
                                    Active
                                </span>
                            @else
                                <span class="rounded-full bg-gray-100 px-3 py-1 text-xs font-semibold text-gray-500">
                                    Inactive
                                </span>
                            @endif

                        </div>

                        <div class="mt-5 grid grid-cols-2 gap-3">

                            <div class="rounded-xl bg-gray-50 p-3">
                                <p class="text-xs text-gray-500">
                                    Menu Items
                                </p>

                                <p class="mt-1 text-lg font-bold text-gray-900">
                                    {{ $category->menu_items_count }}
                                </p>
                            </div>

                            <div class="rounded-xl bg-gray-50 p-3">
                                <p class="text-xs text-gray-500">
                                    Sort Order
                                </p>

                                <p class="mt-1 text-lg font-bold text-gray-900">
                                    {{ $category->sort_order }}
                                </p>
                            </div>

                        </div>

                        <div class="mt-5 flex flex-wrap gap-2">

                            <button
                                wire:click="edit({{ $category->id }})"
                                class="rounded-lg bg-gray-900 px-3 py-2 text-xs font-semibold text-white hover:bg-gray-800"
                            >
                                Edit
                            </button>

                            <button
                                wire:click="toggleStatus({{ $category->id }})"
                                class="rounded-lg border border-gray-300 px-3 py-2 text-xs font-semibold text-gray-700 hover:bg-gray-50"
                            >
                                {{ $category->is_active ? 'Disable' : 'Enable' }}
                            </button>

                            <button
                                wire:click="delete({{ $category->id }})"
                                wire:confirm="Are you sure you want to delete this category?"
                                class="rounded-lg border border-red-200 px-3 py-2 text-xs font-semibold text-red-600 hover:bg-red-50"
                            >
                                Delete
                            </button>

                        </div>

                    </div>

                @endforeach

            </div>

        @else

            <div class="rounded-2xl border border-dashed border-gray-300 bg-white px-6 py-16 text-center">

                <div class="mx-auto max-w-md">

                    <h3 class="text-lg font-bold text-gray-900">
                        No categories found
                    </h3>

                    <p class="mt-2 text-sm text-gray-500">
                        Create your first menu category to start building your restaurant menu.
                    </p>

                    <button
                        wire:click="openCreate"
                        class="mt-5 rounded-xl bg-gray-900 px-5 py-3 text-sm font-semibold text-white hover:bg-gray-800"
                    >
                        + Create First Category
                    </button>

                </div>

            </div>

        @endif

    </div>

</div>