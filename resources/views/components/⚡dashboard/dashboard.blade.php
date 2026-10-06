

    <div class="min-h-screen bg-gray-50">

        {{-- Page Header --}}
        <div class="border-b border-gray-200 bg-white">

            <div class="mx-auto max-w-7xl px-6 py-8 lg:px-8">

                <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

                    <div>

                        <p class="text-sm font-medium text-gray-500">
                            Dashboard
                        </p>

                        <h1 class="mt-1 text-3xl font-bold tracking-tight text-gray-900">
                            Welcome back, {{ auth()->user()->name }} 👋
                        </h1>

                        <p class="mt-2 text-sm text-gray-500">
                            Here's what's happening with your restaurant today.
                        </p>

                    </div>

                    <a
                        href="{{ route('restaurant.setup') }}"
                        class="inline-flex items-center justify-center rounded-xl bg-gray-900 px-5 py-3 text-sm font-semibold text-white transition hover:bg-gray-700"
                    >
                        Manage Restaurant
                    </a>

                </div>

            </div>

        </div>


        {{-- Main Content --}}
        <main class="mx-auto max-w-7xl px-6 py-8 lg:px-8">


            {{-- Stats --}}
            <div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-4">

                {{-- Orders --}}
                <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm">

                    <div class="flex items-center justify-between">

                        <div>
                            <p class="text-sm font-medium text-gray-500">
                                Today's Orders
                            </p>

                            <p class="mt-3 text-3xl font-bold text-gray-900">
                                0
                            </p>
                        </div>

                        <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-blue-50 text-xl">
                            🧾
                        </div>

                    </div>

                    <p class="mt-4 text-xs text-gray-400">
                        No orders yet
                    </p>

                </div>


                {{-- Sales --}}
                <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm">

                    <div class="flex items-center justify-between">

                        <div>
                            <p class="text-sm font-medium text-gray-500">
                                Today's Sales
                            </p>

                            <p class="mt-3 text-3xl font-bold text-gray-900">
                                ₹0
                            </p>
                        </div>

                        <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-green-50 text-xl">
                            💰
                        </div>

                    </div>

                    <p class="mt-4 text-xs text-gray-400">
                        No sales yet
                    </p>

                </div>


                {{-- Tables --}}
                <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm">

                    <div class="flex items-center justify-between">

                        <div>
                            <p class="text-sm font-medium text-gray-500">
                                Active Tables
                            </p>

                            <p class="mt-3 text-3xl font-bold text-gray-900">
                                0
                            </p>
                        </div>

                        <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-orange-50 text-xl">
                            🪑
                        </div>

                    </div>

                    <p class="mt-4 text-xs text-gray-400">
                        No tables configured
                    </p>

                </div>


                {{-- Menu --}}
                <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm">

                    <div class="flex items-center justify-between">

                        <div>
                            <p class="text-sm font-medium text-gray-500">
                                Menu Items
                            </p>

                            <p class="mt-3 text-3xl font-bold text-gray-900">
                                0
                            </p>
                        </div>

                        <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-purple-50 text-xl">
                            🍔
                        </div>

                    </div>

                    <p class="mt-4 text-xs text-gray-400">
                        No menu items yet
                    </p>

                </div>

            </div>


            {{-- Restaurant Card --}}
            <div class="mt-8 overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">

                <div class="border-b border-gray-100 px-6 py-5">

                    <div class="flex items-center justify-between">

                        <div>

                            <h2 class="text-lg font-semibold text-gray-900">
                                Your Restaurant
                            </h2>

                            <p class="mt-1 text-sm text-gray-500">
                                Restaurant information
                            </p>

                        </div>

                        <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-gray-100">
                            🍽️
                        </div>

                    </div>

                </div>


                <div class="grid gap-6 p-6 md:grid-cols-3">

                    {{-- Name --}}
                    <div>

                        <p class="text-xs font-medium uppercase tracking-wider text-gray-400">
                            Restaurant Name
                        </p>

                        <p class="mt-2 text-base font-semibold text-gray-900">
                            {{ auth()->user()->restaurant?->name ?? 'Not configured' }}
                        </p>

                    </div>


                    {{-- Phone --}}
                    <div>

                        <p class="text-xs font-medium uppercase tracking-wider text-gray-400">
                            Phone
                        </p>

                        <p class="mt-2 text-base font-semibold text-gray-900">
                            {{ auth()->user()->restaurant?->phone ?? 'Not configured' }}
                        </p>

                    </div>


                    {{-- Email --}}
                    <div>

                        <p class="text-xs font-medium uppercase tracking-wider text-gray-400">
                            Email
                        </p>

                        <p class="mt-2 text-base font-semibold text-gray-900">
                            {{ auth()->user()->restaurant?->email ?? 'Not configured' }}
                        </p>

                    </div>


                    {{-- Address --}}
                    <div class="md:col-span-3">

                        <p class="text-xs font-medium uppercase tracking-wider text-gray-400">
                            Address
                        </p>

                        <p class="mt-2 text-base font-semibold text-gray-900">
                            {{ auth()->user()->restaurant?->address ?? 'Not configured' }}
                        </p>

                    </div>

                </div>

            </div>


            {{-- Quick Actions --}}
            <div class="mt-8">

                <h2 class="mb-4 text-lg font-semibold text-gray-900">
                    Quick Actions
                </h2>

                <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">

                    <a
                        href="{{ route('restaurant.setup') }}"
                        class="group rounded-2xl border border-gray-200 bg-white p-5 shadow-sm transition hover:-translate-y-0.5 hover:border-gray-300 hover:shadow-md"
                    >

                        <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-gray-100 text-xl">
                            ⚙️
                        </div>

                        <h3 class="mt-4 font-semibold text-gray-900">
                            Restaurant Setup
                        </h3>

                        <p class="mt-1 text-sm text-gray-500">
                            Update restaurant details.
                        </p>

                    </a>


                    <a
                        href="{{ route('branches') }}"
                        class="group rounded-2xl border border-gray-200 bg-white p-5 shadow-sm transition hover:-translate-y-0.5 hover:border-gray-300 hover:shadow-md"
                    >

                        <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-gray-100 text-xl">
                            🏪
                        </div>

                        <h3 class="mt-4 font-semibold text-gray-900">
                            Branches
                        </h3>

                        <p class="mt-1 text-sm text-gray-500">
                            Manage restaurant branches.
                        </p>

                    </a>


                    <a
                        href="#"
                        class="group rounded-2xl border border-gray-200 bg-white p-5 shadow-sm transition hover:-translate-y-0.5 hover:border-gray-300 hover:shadow-md"
                    >

                        <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-gray-100 text-xl">
                            🍔
                        </div>

                        <h3 class="mt-4 font-semibold text-gray-900">
                            Menu
                        </h3>

                        <p class="mt-1 text-sm text-gray-500">
                            Add categories and menu items.
                        </p>

                    </a>


                    <a
                        href="#"
                        class="group rounded-2xl border border-gray-200 bg-white p-5 shadow-sm transition hover:-translate-y-0.5 hover:border-gray-300 hover:shadow-md"
                    >

                        <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-gray-100 text-xl">
                            🧾
                        </div>

                        <h3 class="mt-4 font-semibold text-gray-900">
                            New Order
                        </h3>

                        <p class="mt-1 text-sm text-gray-500">
                            Start taking customer orders.
                        </p>

                    </a>

                </div>

            </div>

        </main>

    </div>

