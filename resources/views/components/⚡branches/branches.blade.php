<div class="min-h-[calc(100vh-73px)] bg-gray-50">

    <div class="mx-auto max-w-7xl px-6 py-8 lg:px-8">

        {{-- Header --}}
        <div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

            <div>
                <div class="flex items-center gap-3">

                    <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-gray-900 text-xl text-white">
                        🏪
                    </div>

                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">
                            Branches
                        </h1>

                        <p class="mt-1 text-sm text-gray-500">
                            Manage all locations of your restaurant.
                        </p>
                    </div>

                </div>
            </div>

            <button
                type="button"
                wire:click="openCreate"
                class="inline-flex items-center justify-center gap-2 rounded-xl bg-gray-900 px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-gray-700"
            >
                <span class="text-lg">+</span>
                Add Branch
            </button>

        </div>


        {{-- Flash Message --}}
        @if (session('success'))

            <div
                class="mb-6 flex items-center gap-3 rounded-xl border border-green-200 bg-green-50 px-5 py-4 text-sm font-medium text-green-700"
            >
                <span class="flex h-7 w-7 items-center justify-center rounded-full bg-green-100">
                    ✓
                </span>

                {{ session('success') }}
            </div>

        @endif


        {{-- Form --}}
        @if ($showForm)

            <div class="mb-8 rounded-2xl border border-gray-200 bg-white shadow-sm">

                <div class="border-b border-gray-100 px-6 py-5">

                    <div class="flex items-center justify-between">

                        <div>
                            <h2 class="text-lg font-semibold text-gray-900">
                                {{ $editingId ? 'Edit Branch' : 'Add New Branch' }}
                            </h2>

                            <p class="mt-1 text-sm text-gray-500">
                                Enter the branch information below.
                            </p>
                        </div>

                        <button
                            type="button"
                            wire:click="cancel"
                            class="flex h-9 w-9 items-center justify-center rounded-lg text-gray-400 transition hover:bg-gray-100 hover:text-gray-700"
                        >
                            ✕
                        </button>

                    </div>

                </div>


                <form
                    wire:submit="save"
                    class="p-6"
                >

                    <div class="grid gap-6 md:grid-cols-2">

                        {{-- Name --}}
                        <div>

                            <label class="mb-2 block text-sm font-medium text-gray-700">
                                Branch Name
                            </label>

                            <input
                                type="text"
                                wire:model="name"
                                placeholder="e.g. Main Branch"
                                class="w-full rounded-xl border border-gray-300 px-4 py-3 text-sm outline-none transition focus:border-gray-900 focus:ring-2 focus:ring-gray-200"
                            >

                            @error('name')
                                <p class="mt-2 text-sm text-red-600">
                                    {{ $message }}
                                </p>
                            @enderror

                        </div>


                        {{-- Code --}}
                        <div>

                            <label class="mb-2 block text-sm font-medium text-gray-700">
                                Branch Code
                            </label>

                            <input
                                type="text"
                                wire:model="code"
                                placeholder="e.g. MAIN"
                                class="w-full rounded-xl border border-gray-300 px-4 py-3 text-sm uppercase outline-none transition focus:border-gray-900 focus:ring-2 focus:ring-gray-200"
                            >

                            <p class="mt-2 text-xs text-gray-400">
                                Unique code for this restaurant.
                            </p>

                            @error('code')
                                <p class="mt-2 text-sm text-red-600">
                                    {{ $message }}
                                </p>
                            @enderror

                        </div>


                        {{-- Phone --}}
                        <div>

                            <label class="mb-2 block text-sm font-medium text-gray-700">
                                Phone
                            </label>

                            <input
                                type="text"
                                wire:model="phone"
                                placeholder="+91 9876543210"
                                class="w-full rounded-xl border border-gray-300 px-4 py-3 text-sm outline-none transition focus:border-gray-900 focus:ring-2 focus:ring-gray-200"
                            >

                            @error('phone')
                                <p class="mt-2 text-sm text-red-600">
                                    {{ $message }}
                                </p>
                            @enderror

                        </div>


                        {{-- Email --}}
                        <div>

                            <label class="mb-2 block text-sm font-medium text-gray-700">
                                Email
                            </label>

                            <input
                                type="email"
                                wire:model="email"
                                placeholder="branch@example.com"
                                class="w-full rounded-xl border border-gray-300 px-4 py-3 text-sm outline-none transition focus:border-gray-900 focus:ring-2 focus:ring-gray-200"
                            >

                            @error('email')
                                <p class="mt-2 text-sm text-red-600">
                                    {{ $message }}
                                </p>
                            @enderror

                        </div>


                        {{-- Address --}}
                        <div class="md:col-span-2">

                            <label class="mb-2 block text-sm font-medium text-gray-700">
                                Address
                            </label>

                            <textarea
                                wire:model="address"
                                rows="4"
                                placeholder="Enter branch address"
                                class="w-full resize-none rounded-xl border border-gray-300 px-4 py-3 text-sm outline-none transition focus:border-gray-900 focus:ring-2 focus:ring-gray-200"
                            ></textarea>

                            @error('address')
                                <p class="mt-2 text-sm text-red-600">
                                    {{ $message }}
                                </p>
                            @enderror

                        </div>


                        {{-- Active --}}
                        <div class="md:col-span-2">

                            <label class="flex cursor-pointer items-center gap-3">

                                <input
                                    type="checkbox"
                                    wire:model="is_active"
                                    class="h-5 w-5 rounded border-gray-300"
                                >

                                <span>

                                    <span class="block text-sm font-medium text-gray-700">
                                        Active Branch
                                    </span>

                                    <span class="block text-xs text-gray-400">
                                        Customers and staff can use this branch.
                                    </span>

                                </span>

                            </label>

                        </div>

                    </div>


                    {{-- Buttons --}}
                    <div class="mt-8 flex justify-end gap-3 border-t border-gray-100 pt-6">

                        <button
                            type="button"
                            wire:click="cancel"
                            class="rounded-xl border border-gray-300 px-5 py-3 text-sm font-medium text-gray-700 transition hover:bg-gray-50"
                        >
                            Cancel
                        </button>

                        <button
                            type="submit"
                            wire:loading.attr="disabled"
                            class="rounded-xl bg-gray-900 px-6 py-3 text-sm font-semibold text-white transition hover:bg-gray-700 disabled:cursor-not-allowed disabled:opacity-50"
                        >

                            <span wire:loading.remove>
                                {{ $editingId ? 'Update Branch' : 'Create Branch' }}
                            </span>

                            <span wire:loading>
                                Saving...
                            </span>

                        </button>

                    </div>

                </form>

            </div>

        @endif


        {{-- Branch List --}}
        <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">

            <div class="border-b border-gray-100 px-6 py-5">

                <div class="flex items-center justify-between">

                    <div>
                        <h2 class="font-semibold text-gray-900">
                            Your Branches
                        </h2>

                        <p class="mt-1 text-sm text-gray-500">
                            {{ $branches->count() }}
                            {{ $branches->count() === 1 ? 'branch' : 'branches' }}
                            configured.
                        </p>
                    </div>

                </div>

            </div>


            @if ($branches->count())

                {{-- Desktop --}}
                <div class="hidden overflow-x-auto md:block">

                    <table class="w-full text-left">

                        <thead class="bg-gray-50">

                            <tr>

                                <th class="px-6 py-4 text-xs font-semibold uppercase tracking-wider text-gray-500">
                                    Branch
                                </th>

                                <th class="px-6 py-4 text-xs font-semibold uppercase tracking-wider text-gray-500">
                                    Code
                                </th>

                                <th class="px-6 py-4 text-xs font-semibold uppercase tracking-wider text-gray-500">
                                    Contact
                                </th>

                                <th class="px-6 py-4 text-xs font-semibold uppercase tracking-wider text-gray-500">
                                    Status
                                </th>

                                <th class="px-6 py-4 text-right text-xs font-semibold uppercase tracking-wider text-gray-500">
                                    Actions
                                </th>

                            </tr>

                        </thead>


                        <tbody class="divide-y divide-gray-100">

                            @foreach ($branches as $branch)

                                <tr class="transition hover:bg-gray-50">

                                    {{-- Branch --}}
                                    <td class="px-6 py-5">

                                        <div class="flex items-center gap-3">

                                            <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-gray-100 text-lg">
                                                🏪
                                            </div>

                                            <div>

                                                <p class="font-semibold text-gray-900">
                                                    {{ $branch->name }}
                                                </p>

                                                <p class="mt-1 max-w-xs truncate text-xs text-gray-500">
                                                    {{ $branch->address ?: 'No address added' }}
                                                </p>

                                            </div>

                                        </div>

                                    </td>


                                    {{-- Code --}}
                                    <td class="px-6 py-5">

                                        <span class="rounded-lg bg-gray-100 px-3 py-1.5 text-xs font-semibold text-gray-700">
                                            {{ $branch->code }}
                                        </span>

                                    </td>


                                    {{-- Contact --}}
                                    <td class="px-6 py-5">

                                        <div class="space-y-1 text-sm">

                                            @if ($branch->phone)
                                                <p class="text-gray-700">
                                                    {{ $branch->phone }}
                                                </p>
                                            @endif

                                            @if ($branch->email)
                                                <p class="max-w-xs truncate text-gray-500">
                                                    {{ $branch->email }}
                                                </p>
                                            @endif

                                            @if (!$branch->phone && !$branch->email)
                                                <span class="text-gray-400">
                                                    No contact
                                                </span>
                                            @endif

                                        </div>

                                    </td>


                                    {{-- Status --}}
                                    <td class="px-6 py-5">

                                        @if ($branch->is_active)

                                            <button
                                                type="button"
                                                wire:click="toggleStatus({{ $branch->id }})"
                                                class="inline-flex items-center gap-2 rounded-full bg-green-50 px-3 py-1.5 text-xs font-semibold text-green-700"
                                            >
                                                <span class="h-2 w-2 rounded-full bg-green-500"></span>
                                                Active
                                            </button>

                                        @else

                                            <button
                                                type="button"
                                                wire:click="toggleStatus({{ $branch->id }})"
                                                class="inline-flex items-center gap-2 rounded-full bg-gray-100 px-3 py-1.5 text-xs font-semibold text-gray-600"
                                            >
                                                <span class="h-2 w-2 rounded-full bg-gray-400"></span>
                                                Inactive
                                            </button>

                                        @endif

                                    </td>


                                    {{-- Actions --}}
                                    <td class="px-6 py-5">

                                        <div class="flex justify-end gap-2">

                                            <button
                                                type="button"
                                                wire:click="edit({{ $branch->id }})"
                                                class="rounded-lg border border-gray-200 px-3 py-2 text-xs font-medium text-gray-700 transition hover:bg-gray-100"
                                            >
                                                Edit
                                            </button>

                                            <button
                                                type="button"
                                                wire:click="delete({{ $branch->id }})"
                                                wire:confirm="Are you sure you want to delete this branch?"
                                                class="rounded-lg border border-red-200 px-3 py-2 text-xs font-medium text-red-600 transition hover:bg-red-50"
                                            >
                                                Delete
                                            </button>

                                        </div>

                                    </td>

                                </tr>

                            @endforeach

                        </tbody>

                    </table>

                </div>


                {{-- Mobile --}}
                <div class="divide-y divide-gray-100 md:hidden">

                    @foreach ($branches as $branch)

                        <div class="p-5">

                            <div class="flex items-start justify-between gap-4">

                                <div class="flex items-center gap-3">

                                    <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-gray-100">
                                        🏪
                                    </div>

                                    <div>

                                        <h3 class="font-semibold text-gray-900">
                                            {{ $branch->name }}
                                        </h3>

                                        <p class="mt-1 text-xs text-gray-500">
                                            {{ $branch->code }}
                                        </p>

                                    </div>

                                </div>


                                @if ($branch->is_active)

                                    <span class="rounded-full bg-green-50 px-3 py-1 text-xs font-semibold text-green-700">
                                        Active
                                    </span>

                                @else

                                    <span class="rounded-full bg-gray-100 px-3 py-1 text-xs font-semibold text-gray-600">
                                        Inactive
                                    </span>

                                @endif

                            </div>


                            <div class="mt-4 space-y-2 text-sm text-gray-500">

                                @if ($branch->phone)
                                    <p>📞 {{ $branch->phone }}</p>
                                @endif

                                @if ($branch->email)
                                    <p>✉️ {{ $branch->email }}</p>
                                @endif

                                @if ($branch->address)
                                    <p>📍 {{ $branch->address }}</p>
                                @endif

                            </div>


                            <div class="mt-5 flex gap-2">

                                <button
                                    type="button"
                                    wire:click="edit({{ $branch->id }})"
                                    class="flex-1 rounded-lg border border-gray-200 px-3 py-2 text-sm font-medium text-gray-700"
                                >
                                    Edit
                                </button>

                                <button
                                    type="button"
                                    wire:click="delete({{ $branch->id }})"
                                    wire:confirm="Are you sure you want to delete this branch?"
                                    class="flex-1 rounded-lg border border-red-200 px-3 py-2 text-sm font-medium text-red-600"
                                >
                                    Delete
                                </button>

                            </div>

                        </div>

                    @endforeach

                </div>

            @else

                {{-- Empty State --}}
                <div class="px-6 py-20 text-center">

                    <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-2xl bg-gray-100 text-3xl">
                        🏪
                    </div>

                    <h3 class="mt-5 text-lg font-semibold text-gray-900">
                        No branches yet
                    </h3>

                    <p class="mx-auto mt-2 max-w-md text-sm text-gray-500">
                        Add your first branch to start managing
                        multiple restaurant locations.
                    </p>

                    <button
                        type="button"
                        wire:click="openCreate"
                        class="mt-6 rounded-xl bg-gray-900 px-5 py-3 text-sm font-semibold text-white transition hover:bg-gray-700"
                    >
                        Add Your First Branch
                    </button>

                </div>

            @endif

        </div>

    </div>

</div>