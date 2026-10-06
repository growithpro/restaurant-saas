<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ $title ?? 'Restaurant SaaS' }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @livewireStyles
</head>

<body class="bg-gray-100 text-gray-900">

    <div class="flex min-h-screen">

        <!-- Sidebar -->
        <aside class="hidden w-64 shrink-0 bg-gray-950 text-white md:block">

            <div class="border-b border-gray-800 px-6 py-5">
                <a href="{{ route('dashboard') }}" class="text-xl font-bold">
                    🍽 Restaurant SaaS
                </a>
            </div>

            <nav class="space-y-1 p-4">

                <a href="{{ route('dashboard') }}"
                    class="block rounded-lg px-4 py-3 text-sm font-medium hover:bg-gray-800">
                    Dashboard
                </a>

                <a href="{{ route('restaurant.setup') }}"
                    class="block rounded-lg px-4 py-3 text-sm font-medium hover:bg-gray-800">
                    Restaurant
                </a>

                <a href="{{ route('branches') }}"
                    class="block rounded-lg px-4 py-3 text-sm font-medium hover:bg-gray-800">
                    Branches
                </a>

                <a href="{{ route('tables') }}"
                    class="block rounded-lg px-4 py-3 text-sm font-medium hover:bg-gray-800">
                    Tables
                </a>

                <a href="#" class="block rounded-lg px-4 py-3 text-sm font-medium hover:bg-gray-800">
                    Menu
                </a>

                <a href="#" class="block rounded-lg px-4 py-3 text-sm font-medium hover:bg-gray-800">
                    Orders
                </a>

                <a href="#" class="block rounded-lg px-4 py-3 text-sm font-medium hover:bg-gray-800">
                    KOT
                </a>

                <a href="#" class="block rounded-lg px-4 py-3 text-sm font-medium hover:bg-gray-800">
                    Inventory
                </a>

                <a href="#" class="block rounded-lg px-4 py-3 text-sm font-medium hover:bg-gray-800">
                    Customers
                </a>

                <a href="#" class="block rounded-lg px-4 py-3 text-sm font-medium hover:bg-gray-800">
                    Expenses
                </a>

                <a href="#" class="block rounded-lg px-4 py-3 text-sm font-medium hover:bg-gray-800">
                    Reports
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
                            {{ auth()->user()->restaurant?->name ?? 'Restaurant SaaS' }}
                        </h1>

                        <p class="text-sm text-gray-500">
                            Management Dashboard
                        </p>
                    </div>

                    <div class="flex items-center gap-4">

                        @auth
                            <span class="text-sm font-medium">
                                {{ auth()->user()->name }}
                            </span>

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf

                                <button type="submit"
                                    class="rounded-lg bg-gray-900 px-4 py-2 text-sm font-medium text-white hover:bg-gray-700">
                                    Logout
                                </button>
                            </form>
                        @endauth

                    </div>

                </div>

            </header>

            <!-- Content -->
            <main class="flex-1">
                {{ $slot }}
            </main>

        </div>

    </div>

    @livewireScripts

</body>

</html>