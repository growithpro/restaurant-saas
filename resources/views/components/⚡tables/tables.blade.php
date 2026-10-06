<div class="min-h-[calc(100vh-73px)] bg-gray-50">

    <div class="mx-auto max-w-7xl px-6 py-8 lg:px-8">

        {{-- Header --}}
        <div class="mb-8 flex flex-col gap-5 lg:flex-row lg:items-center lg:justify-between">

            <div>

                <div class="flex items-center gap-3">

                    <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-gray-900 text-xl text-white">
                        🪑
                    </div>

                    <div>

                        <h1 class="text-2xl font-bold text-gray-900">
                            Floors & Tables
                        </h1>

                        <p class="mt-1 text-sm text-gray-500">
                            Manage floors, dining tables and seating capacity.
                        </p>

                    </div>

                </div>

            </div>


            {{-- Actions --}}
            <div class="flex flex-wrap gap-3">

                <button
                    type="button"
                    wire:click="openCreateFloor"
                    class="rounded-xl border border-gray-300 bg-white px-5 py-3 text-sm font-semibold text-gray-700 shadow-sm transition hover:bg-gray-50"
                >
                    + Add Floor
                </button>

                <button
                    type="button"
                    wire:click="openCreateTable"
                    class="rounded-xl bg-gray-900 px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-gray-700"
                >
                    + Add Table
                </button>

            </div>

        </div>


        {{-- Flash Success --}}
        @if (session('success'))

            <div class="mb-6 flex items-center gap-3 rounded-xl border border-green-200 bg-green-50 px-5 py-4 text-sm font-medium text-green-700">

                <span class="flex h-7 w-7 items-center justify-center rounded-full bg-green-100">
                    ✓
                </span>

                {{ session('success') }}

            </div>

        @endif


        {{-- Flash Error --}}
        @if (session('error'))

            <div class="mb-6 flex items-center gap-3 rounded-xl border border-red-200 bg-red-50 px-5 py-4 text-sm font-medium text-red-700">

                <span class="flex h-7 w-7 items-center justify-center rounded-full bg-red-100">
                    !
                </span>

                {{ session('error') }}

            </div>

        @endif


        {{-- Branch Selector --}}
        <div class="mb-8 rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">

            <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">

                <div>

                    <p class="text-xs font-semibold uppercase tracking-wider text-gray-400">
                        Current Branch
                    </p>

                    <p class="mt-1 text-lg font-semibold text-gray-900">
                        {{ $branches->firstWhere('id', $selectedBranchId)?->name ?? 'No branch selected' }}
                    </p>

                </div>


                <div class="w-full md:w-72">

                    <select
                        wire:model.live="selectedBranchId"
                        class="w-full rounded-xl border border-gray-300 bg-white px-4 py-3 text-sm font-medium text-gray-700 outline-none transition focus:border-gray-900 focus:ring-2 focus:ring-gray-200"
                    >

                        @foreach ($branches as $branch)

                            <option value="{{ $branch->id }}">
                                {{ $branch->name }} ({{ $branch->code }})
                            </option>

                        @endforeach

                    </select>

                </div>

            </div>

        </div>


        {{-- Floor Form --}}
        @if ($showFloorForm)

            <div class="mb-8 rounded-2xl border border-gray-200 bg-white shadow-sm">

                <div class="border-b border-gray-100 px-6 py-5">

                    <div class="flex items-center justify-between">

                        <div>

                            <h2 class="font-semibold text-gray-900">
                                {{ $editingFloorId ? 'Edit Floor' : 'Add Floor' }}
                            </h2>

                            <p class="mt-1 text-sm text-gray-500">
                                Configure a floor for this branch.
                            </p>

                        </div>

                        <button
                            type="button"
                            wire:click="cancelFloor"
                            class="flex h-9 w-9 items-center justify-center rounded-lg text-gray-400 hover:bg-gray-100"
                        >
                            ✕
                        </button>

                    </div>

                </div>


                <form wire:submit="saveFloor" class="p-6">

                    <div class="grid gap-6 md:grid-cols-3">

                        <div class="md:col-span-2">

                            <label class="mb-2 block text-sm font-medium text-gray-700">
                                Floor Name
                            </label>

                            <input
                                type="text"
                                wire:model="floorName"
                                placeholder="e.g. Ground Floor"
                                class="w-full rounded-xl border border-gray-300 px-4 py-3 text-sm outline-none focus:border-gray-900 focus:ring-2 focus:ring-gray-200"
                            >

                            @error('floorName')
                                <p class="mt-2 text-sm text-red-600">
                                    {{ $message }}
                                </p>
                            @enderror

                        </div>


                        <div>

                            <label class="mb-2 block text-sm font-medium text-gray-700">
                                Sort Order
                            </label>

                            <input
                                type="number"
                                min="0"
                                wire:model="floorSortOrder"
                                class="w-full rounded-xl border border-gray-300 px-4 py-3 text-sm outline-none focus:border-gray-900 focus:ring-2 focus:ring-gray-200"
                            >

                            @error('floorSortOrder')
                                <p class="mt-2 text-sm text-red-600">
                                    {{ $message }}
                                </p>
                            @enderror

                        </div>


                        <div class="md:col-span-3">

                            <label class="flex items-center gap-3">

                                <input
                                    type="checkbox"
                                    wire:model="floorIsActive"
                                    class="h-5 w-5 rounded border-gray-300"
                                >

                                <span>

                                    <span class="block text-sm font-medium text-gray-700">
                                        Active Floor
                                    </span>

                                    <span class="text-xs text-gray-400">
                                        This floor is available for table management.
                                    </span>

                                </span>

                            </label>

                        </div>

                    </div>


                    <div class="mt-6 flex justify-end gap-3 border-t border-gray-100 pt-6">

                        <button
                            type="button"
                            wire:click="cancelFloor"
                            class="rounded-xl border border-gray-300 px-5 py-3 text-sm font-medium text-gray-700 hover:bg-gray-50"
                        >
                            Cancel
                        </button>

                        <button
                            type="submit"
                            wire:loading.attr="disabled"
                            class="rounded-xl bg-gray-900 px-6 py-3 text-sm font-semibold text-white hover:bg-gray-700 disabled:opacity-50"
                        >

                            <span wire:loading.remove>
                                {{ $editingFloorId ? 'Update Floor' : 'Create Floor' }}
                            </span>

                            <span wire:loading>
                                Saving...
                            </span>

                        </button>

                    </div>

                </form>

            </div>

        @endif


        {{-- Table Form --}}
        @if ($showTableForm)

            <div class="mb-8 rounded-2xl border border-gray-200 bg-white shadow-sm">

                <div class="border-b border-gray-100 px-6 py-5">

                    <div class="flex items-center justify-between">

                        <div>

                            <h2 class="font-semibold text-gray-900">
                                {{ $editingTableId ? 'Edit Table' : 'Add Table' }}
                            </h2>

                            <p class="mt-1 text-sm text-gray-500">
                                Configure the table and its seating capacity.
                            </p>

                        </div>

                        <button
                            type="button"
                            wire:click="cancelTable"
                            class="flex h-9 w-9 items-center justify-center rounded-lg text-gray-400 hover:bg-gray-100"
                        >
                            ✕
                        </button>

                    </div>

                </div>


                <form wire:submit="saveTable" class="p-6">

                    <div class="grid gap-6 md:grid-cols-2">


                        {{-- Floor --}}
                        <div>

                            <label class="mb-2 block text-sm font-medium text-gray-700">
                                Floor
                            </label>

                            <select
                                wire:model="selectedFloorForTable"
                                class="w-full rounded-xl border border-gray-300 bg-white px-4 py-3 text-sm outline-none focus:border-gray-900 focus:ring-2 focus:ring-gray-200"
                            >

                                <option value="">
                                    Select Floor
                                </option>

                                @foreach ($floors as $floor)

                                    <option value="{{ $floor->id }}">
                                        {{ $floor->name }}
                                    </option>

                                @endforeach

                            </select>

                            @error('selectedFloorForTable')
                                <p class="mt-2 text-sm text-red-600">
                                    {{ $message }}
                                </p>
                            @enderror

                        </div>


                        {{-- Table Name --}}
                        <div>

                            <label class="mb-2 block text-sm font-medium text-gray-700">
                                Table Name
                            </label>

                            <input
                                type="text"
                                wire:model="tableName"
                                placeholder="e.g. Table 1"
                                class="w-full rounded-xl border border-gray-300 px-4 py-3 text-sm outline-none focus:border-gray-900 focus:ring-2 focus:ring-gray-200"
                            >

                            @error('tableName')
                                <p class="mt-2 text-sm text-red-600">
                                    {{ $message }}
                                </p>
                            @enderror

                        </div>


                        {{-- Code --}}
                        <div>

                            <label class="mb-2 block text-sm font-medium text-gray-700">
                                Table Code
                            </label>

                            <input
                                type="text"
                                wire:model="tableCode"
                                placeholder="e.g. T01"
                                class="w-full rounded-xl border border-gray-300 px-4 py-3 text-sm uppercase outline-none focus:border-gray-900 focus:ring-2 focus:ring-gray-200"
                            >

                            <p class="mt-2 text-xs text-gray-400">
                                Unique within this branch.
                            </p>

                            @error('tableCode')
                                <p class="mt-2 text-sm text-red-600">
                                    {{ $message }}
                                </p>
                            @enderror

                        </div>


                        {{-- Capacity --}}
                        <div>

                            <label class="mb-2 block text-sm font-medium text-gray-700">
                                Seating Capacity
                            </label>

                            <input
                                type="number"
                                min="1"
                                max="100"
                                wire:model="capacity"
                                class="w-full rounded-xl border border-gray-300 px-4 py-3 text-sm outline-none focus:border-gray-900 focus:ring-2 focus:ring-gray-200"
                            >

                            @error('capacity')
                                <p class="mt-2 text-sm text-red-600">
                                    {{ $message }}
                                </p>
                            @enderror

                        </div>


                        {{-- Status --}}
                        <div>

                            <label class="mb-2 block text-sm font-medium text-gray-700">
                                Status
                            </label>

                            <select
                                wire:model="status"
                                class="w-full rounded-xl border border-gray-300 bg-white px-4 py-3 text-sm outline-none focus:border-gray-900 focus:ring-2 focus:ring-gray-200"
                            >

                                <option value="available">
                                    Available
                                </option>

                                <option value="occupied">
                                    Occupied
                                </option>

                                <option value="reserved">
                                    Reserved
                                </option>

                                <option value="maintenance">
                                    Maintenance
                                </option>

                            </select>

                            @error('status')
                                <p class="mt-2 text-sm text-red-600">
                                    {{ $message }}
                                </p>
                            @enderror

                        </div>


                        {{-- Active --}}
                        <div>

                            <label class="flex h-full items-center gap-3">

                                <input
                                    type="checkbox"
                                    wire:model="tableIsActive"
                                    class="h-5 w-5 rounded border-gray-300"
                                >

                                <span>

                                    <span class="block text-sm font-medium text-gray-700">
                                        Active Table
                                    </span>

                                    <span class="text-xs text-gray-400">
                                        Available for restaurant operations.
                                    </span>

                                </span>

                            </label>

                        </div>


                        {{-- Notes --}}
                        <div class="md:col-span-2">

                            <label class="mb-2 block text-sm font-medium text-gray-700">
                                Notes
                            </label>

                            <textarea
                                wire:model="notes"
                                rows="3"
                                placeholder="Optional notes about this table..."
                                class="w-full resize-none rounded-xl border border-gray-300 px-4 py-3 text-sm outline-none focus:border-gray-900 focus:ring-2 focus:ring-gray-200"
                            ></textarea>

                            @error('notes')
                                <p class="mt-2 text-sm text-red-600">
                                    {{ $message }}
                                </p>
                            @enderror

                        </div>

                    </div>


                    <div class="mt-6 flex justify-end gap-3 border-t border-gray-100 pt-6">

                        <button
                            type="button"
                            wire:click="cancelTable"
                            class="rounded-xl border border-gray-300 px-5 py-3 text-sm font-medium text-gray-700 hover:bg-gray-50"
                        >
                            Cancel
                        </button>

                        <button
                            type="submit"
                            wire:loading.attr="disabled"
                            class="rounded-xl bg-gray-900 px-6 py-3 text-sm font-semibold text-white hover:bg-gray-700 disabled:opacity-50"
                        >

                            <span wire:loading.remove>
                                {{ $editingTableId ? 'Update Table' : 'Create Table' }}
                            </span>

                            <span wire:loading>
                                Saving...
                            </span>

                        </button>

                    </div>

                </form>

            </div>

        @endif


        {{-- Floors --}}
        <div class="mb-8">

            <div class="mb-4 flex items-center justify-between">

                <div>

                    <h2 class="text-lg font-semibold text-gray-900">
                        Floors
                    </h2>

                    <p class="mt-1 text-sm text-gray-500">
                        {{ $floors->count() }}
                        {{ $floors->count() === 1 ? 'floor' : 'floors' }}
                        configured.
                    </p>

                </div>

            </div>


            @if ($floors->count())

                <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">

                    @foreach ($floors as $floor)

                        <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">

                            <div class="flex items-start justify-between">

                                <div class="flex items-center gap-3">

                                    <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-gray-100 text-xl">
                                        🏢
                                    </div>

                                    <div>

                                        <h3 class="font-semibold text-gray-900">
                                            {{ $floor->name }}
                                        </h3>

                                        <p class="mt-1 text-xs text-gray-500">
                                            {{ $floor->tables_count }}
                                            {{ $floor->tables_count === 1 ? 'table' : 'tables' }}
                                        </p>

                                    </div>

                                </div>


                                @if ($floor->is_active)

                                    <span class="rounded-full bg-green-50 px-2.5 py-1 text-xs font-semibold text-green-700">
                                        Active
                                    </span>

                                @else

                                    <span class="rounded-full bg-gray-100 px-2.5 py-1 text-xs font-semibold text-gray-500">
                                        Inactive
                                    </span>

                                @endif

                            </div>


                            <div class="mt-5 flex gap-2">

                                <button
                                    type="button"
                                    wire:click="editFloor({{ $floor->id }})"
                                    class="flex-1 rounded-lg border border-gray-200 px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50"
                                >
                                    Edit
                                </button>

                                <button
                                    type="button"
                                    wire:click="deleteFloor({{ $floor->id }})"
                                    wire:confirm="Delete this floor?"
                                    class="rounded-lg border border-red-200 px-3 py-2 text-sm font-medium text-red-600 hover:bg-red-50"
                                >
                                    Delete
                                </button>

                            </div>

                        </div>

                    @endforeach

                </div>

            @else

                <div class="rounded-2xl border border-dashed border-gray-300 bg-white px-6 py-14 text-center">

                    <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-gray-100 text-2xl">
                        🏢
                    </div>

                    <h3 class="mt-4 font-semibold text-gray-900">
                        No floors yet
                    </h3>

                    <p class="mt-1 text-sm text-gray-500">
                        Create a floor before adding tables.
                    </p>

                    <button
                        type="button"
                        wire:click="openCreateFloor"
                        class="mt-5 rounded-xl bg-gray-900 px-5 py-3 text-sm font-semibold text-white hover:bg-gray-700"
                    >
                        Add First Floor
                    </button>

                </div>

            @endif

        </div>


        {{-- Tables --}}
        <div>

            <div class="mb-4 flex items-center justify-between">

                <div>

                    <h2 class="text-lg font-semibold text-gray-900">
                        Tables
                    </h2>

                    <p class="mt-1 text-sm text-gray-500">
                        {{ $tables->count() }}
                        {{ $tables->count() === 1 ? 'table' : 'tables' }}
                        configured.
                    </p>

                </div>

            </div>


            @if ($tables->count())

                <div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">

                    @foreach ($tables as $table)

                        @php
                            $statusClasses = match ($table->status) {
                                'available' => 'bg-green-50 text-green-700 border-green-200',
                                'occupied' => 'bg-red-50 text-red-700 border-red-200',
                                'reserved' => 'bg-yellow-50 text-yellow-700 border-yellow-200',
                                'maintenance' => 'bg-gray-100 text-gray-600 border-gray-200',
                                default => 'bg-gray-100 text-gray-600 border-gray-200',
                            };

                            $statusLabel = match ($table->status) {
                                'available' => 'Available',
                                'occupied' => 'Occupied',
                                'reserved' => 'Reserved',
                                'maintenance' => 'Maintenance',
                                default => ucfirst($table->status),
                            };
                        @endphp


                        <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm transition hover:-translate-y-0.5 hover:shadow-md">

                            <div class="flex items-start justify-between">

                                <div>

                                    <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-gray-900 text-lg text-white">
                                        {{ $table->code }}
                                    </div>

                                </div>

                                <span class="rounded-full border px-3 py-1 text-xs font-semibold {{ $statusClasses }}">
                                    {{ $statusLabel }}
                                </span>

                            </div>


                            <div class="mt-5">

                                <h3 class="font-semibold text-gray-900">
                                    {{ $table->name }}
                                </h3>

                                <p class="mt-1 text-sm text-gray-500">
                                    {{ $table->floor?->name ?? 'No floor' }}
                                </p>

                            </div>


                            <div class="mt-4 flex items-center justify-between border-t border-gray-100 pt-4">

                                <div>

                                    <p class="text-xs text-gray-400">
                                        Capacity
                                    </p>

                                    <p class="mt-1 font-semibold text-gray-800">
                                        {{ $table->capacity }} people
                                    </p>

                                </div>


                                @if ($table->is_active)

                                    <button
                                        type="button"
                                        wire:click="toggleTableStatus({{ $table->id }})"
                                        class="text-xs font-medium text-green-600 hover:text-green-700"
                                    >
                                        Active
                                    </button>

                                @else

                                    <button
                                        type="button"
                                        wire:click="toggleTableStatus({{ $table->id }})"
                                        class="text-xs font-medium text-gray-400 hover:text-gray-600"
                                    >
                                        Inactive
                                    </button>

                                @endif

                            </div>


                            <div class="mt-4 flex gap-2">

                                <button
                                    type="button"
                                    wire:click="editTable({{ $table->id }})"
                                    class="flex-1 rounded-lg border border-gray-200 px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50"
                                >
                                    Edit
                                </button>

                                <button
                                    type="button"
                                    wire:click="deleteTable({{ $table->id }})"
                                    wire:confirm="Delete this table?"
                                    class="rounded-lg border border-red-200 px-3 py-2 text-sm font-medium text-red-600 hover:bg-red-50"
                                >
                                    Delete
                                </button>

                            </div>

                        </div>

                    @endforeach

                </div>

            @else

                <div class="rounded-2xl border border-dashed border-gray-300 bg-white px-6 py-14 text-center">

                    <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-gray-100 text-2xl">
                        🪑
                    </div>

                    <h3 class="mt-4 font-semibold text-gray-900">
                        No tables yet
                    </h3>

                    <p class="mt-1 text-sm text-gray-500">
                        Add tables to your selected branch.
                    </p>

                    @if ($floors->count())

                        <button
                            type="button"
                            wire:click="openCreateTable"
                            class="mt-5 rounded-xl bg-gray-900 px-5 py-3 text-sm font-semibold text-white hover:bg-gray-700"
                        >
                            Add First Table
                        </button>

                    @else

                        <button
                            type="button"
                            wire:click="openCreateFloor"
                            class="mt-5 rounded-xl bg-gray-900 px-5 py-3 text-sm font-semibold text-white hover:bg-gray-700"
                        >
                            Create Floor First
                        </button>

                    @endif

                </div>

            @endif

        </div>

    </div>

</div>