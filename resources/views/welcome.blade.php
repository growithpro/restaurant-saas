<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Restaurant SaaS — The operating system for modern restaurants</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        html {
            scroll-behavior: smooth;
        }

        body {
            overflow-x: hidden;
        }

        .hero-glow {
            background:
                radial-gradient(circle at 20% 20%, rgba(255, 90, 95, .22), transparent 30%),
                radial-gradient(circle at 80% 30%, rgba(255, 180, 80, .18), transparent 30%),
                radial-gradient(circle at 50% 90%, rgba(120, 90, 255, .14), transparent 35%);
        }

        .grid-pattern {
            background-image:
                linear-gradient(rgba(0, 0, 0, .035) 1px, transparent 1px),
                linear-gradient(90deg, rgba(0, 0, 0, .035) 1px, transparent 1px);
            background-size: 42px 42px;
        }

        .floating-card {
            animation: float 6s ease-in-out infinite;
        }

        .floating-card-delay {
            animation: float 7s ease-in-out 1s infinite;
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-10px);
            }
        }

        .gradient-text {
            background: linear-gradient(110deg,
                    #111827 10%,
                    #ff385c 50%,
                    #8b5cf6 90%);

            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }

        .card-shine {
            position: relative;
            overflow: hidden;
        }

        .card-shine::before {
            content: "";
            position: absolute;
            inset: 0;
            background: linear-gradient(120deg,
                    transparent 30%,
                    rgba(255, 255, 255, .45),
                    transparent 70%);
            transform: translateX(-120%);
            transition: transform .7s ease;
        }

        .card-shine:hover::before {
            transform: translateX(120%);
        }
    </style>
</head>

<body class="bg-white text-gray-950 antialiased">

    <!-- ===================================================== -->
    <!-- NAVBAR -->
    <!-- ===================================================== -->

    <header class="fixed left-0 right-0 top-0 z-50 px-4 pt-4">

        <div class="mx-auto max-w-7xl">

            <nav
                class="flex h-16 items-center justify-between rounded-full border border-white/60 bg-white/80 px-4 shadow-lg shadow-gray-900/5 backdrop-blur-xl sm:px-6">

                <!-- Logo -->

                <a href="/" class="flex items-center gap-3">

                    <div
                        class="flex h-10 w-10 items-center justify-center rounded-full bg-[#ff385c] text-lg text-white shadow-lg shadow-[#ff385c]/20">
                        🍽
                    </div>

                    <span class="hidden text-lg font-bold tracking-tight sm:block">
                        Restaurant<span class="text-[#ff385c]">SaaS</span>
                    </span>

                </a>


                <!-- Desktop Navigation -->

                <div class="hidden items-center gap-8 md:flex">

                    <a href="#features" class="text-sm font-medium text-gray-600 transition hover:text-gray-950">
                        Features
                    </a>

                    <a href="#workflow" class="text-sm font-medium text-gray-600 transition hover:text-gray-950">
                        How it works
                    </a>

                    <a href="#pricing" class="text-sm font-medium text-gray-600 transition hover:text-gray-950">
                        Pricing
                    </a>

                </div>


                <!-- Actions -->

                <div class="flex items-center gap-2">

                    <a href="{{ route('login') }}"
                        class="hidden rounded-full px-4 py-2.5 text-sm font-semibold text-gray-700 transition hover:bg-gray-100 sm:block">
                        Log in
                    </a>

                    <a href="{{ route('login') }}"
                        class="rounded-full bg-gray-950 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-gray-800">
                        Get started
                    </a>

                </div>

            </nav>

        </div>

    </header>


    <!-- ===================================================== -->
    <!-- HERO -->
    <!-- ===================================================== -->

    <section class="hero-glow grid-pattern relative min-h-screen overflow-hidden pt-32">

        <!-- Decorative blobs -->

        <div class="absolute -left-40 top-40 h-96 w-96 rounded-full bg-[#ff385c]/10 blur-3xl"></div>

        <div class="absolute -right-40 top-60 h-96 w-96 rounded-full bg-purple-300/20 blur-3xl"></div>


        <div class="relative mx-auto max-w-7xl px-6 pb-20 lg:px-8 lg:pb-28">

            <div class="grid items-center gap-16 lg:grid-cols-[.95fr_1.05fr]">


                <!-- HERO COPY -->

                <div class="pt-10">

                    <!-- Badge -->

                    <div
                        class="mb-7 inline-flex items-center gap-2 rounded-full border border-gray-200 bg-white/80 px-4 py-2 text-sm font-medium shadow-sm backdrop-blur">

                        <span class="flex h-2.5 w-2.5 rounded-full bg-green-500"></span>

                        Built for ambitious restaurants

                    </div>


                    <!-- Heading -->

                    <h1
                        class="max-w-3xl text-5xl font-black leading-[.98] tracking-[-.055em] sm:text-6xl lg:text-[5.3rem]">

                        Your restaurant.

                        <br>

                        <span class="gradient-text">
                            One beautiful system.
                        </span>

                    </h1>


                    <!-- Description -->

                    <p class="mt-8 max-w-xl text-lg leading-8 text-gray-600 sm:text-xl">

                        Run your restaurant from one powerful workspace.
                        Orders, tables, menu, kitchen, inventory and
                        business insights — beautifully connected.

                    </p>


                    <!-- CTA -->

                    <div class="mt-9 flex flex-col gap-3 sm:flex-row">

                        <a href="{{ route('login') }}"
                            class="group inline-flex items-center justify-center gap-3 rounded-full bg-[#ff385c] px-7 py-4 text-sm font-bold text-white shadow-xl shadow-[#ff385c]/20 transition hover:-translate-y-0.5 hover:bg-[#e61e4d]">

                            Start for free

                            <span class="transition group-hover:translate-x-1">
                                →
                            </span>

                        </a>

                        <a href="#features"
                            class="inline-flex items-center justify-center rounded-full border border-gray-300 bg-white/70 px-7 py-4 text-sm font-bold text-gray-800 backdrop-blur transition hover:bg-white">
                            Explore platform
                        </a>

                    </div>


                    <!-- Trust -->

                    <div class="mt-9 flex flex-wrap gap-x-6 gap-y-3 text-sm text-gray-500">

                        <span>✓ No complicated setup</span>
                        <span>✓ Cloud based</span>
                        <span>✓ Built for growth</span>

                    </div>

                </div>


                <!-- ================================================= -->
                <!-- DASHBOARD VISUAL -->
                <!-- ================================================= -->

                <div class="relative mx-auto w-full max-w-2xl lg:pt-10">


                    <!-- Background visual -->

                    <div
                        class="absolute -inset-10 rounded-[4rem] bg-gradient-to-br from-[#ff385c]/20 via-orange-100/20 to-purple-200/30 blur-3xl">
                    </div>


                    <!-- Main dashboard -->

                    <div
                        class="relative rounded-[2rem] border border-white bg-white/90 p-3 shadow-2xl shadow-gray-900/15 backdrop-blur-xl">

                        <div class="overflow-hidden rounded-[1.5rem] bg-gray-950">


                            <!-- Dashboard topbar -->

                            <div class="flex items-center justify-between border-b border-white/10 px-5 py-4">

                                <div class="flex items-center gap-3">

                                    <div
                                        class="flex h-9 w-9 items-center justify-center rounded-xl bg-[#ff385c] text-sm text-white">
                                        🍽
                                    </div>

                                    <div>

                                        <p class="text-sm font-bold text-white">
                                            The Urban Table
                                        </p>

                                        <p class="text-[11px] text-gray-500">
                                            Main Branch
                                        </p>

                                    </div>

                                </div>


                                <div class="flex items-center gap-2">

                                    <div
                                        class="hidden rounded-full bg-white/5 px-3 py-1.5 text-[10px] text-gray-400 sm:block">
                                        Today
                                    </div>

                                    <div class="h-8 w-8 rounded-full bg-gradient-to-br from-orange-300 to-[#ff385c]">
                                    </div>

                                </div>

                            </div>


                            <!-- Dashboard body -->

                            <div class="p-5 sm:p-6">


                                <!-- Greeting -->

                                <div class="mb-5">

                                    <p class="text-xs text-gray-500">
                                        THURSDAY, OCTOBER 1
                                    </p>

                                    <h2 class="mt-1 text-xl font-bold text-white">
                                        Good evening 👋
                                    </h2>

                                </div>


                                <!-- Stats -->

                                <div class="grid grid-cols-2 gap-3 sm:grid-cols-4">


                                    <div class="rounded-2xl bg-white/[.07] p-4">

                                        <p class="text-[11px] text-gray-500">
                                            SALES
                                        </p>

                                        <p class="mt-2 text-lg font-bold text-white">
                                            ₹48.2K
                                        </p>

                                        <p class="mt-1 text-[10px] text-green-400">
                                            ↑ 18.4%
                                        </p>

                                    </div>


                                    <div class="rounded-2xl bg-white/[.07] p-4">

                                        <p class="text-[11px] text-gray-500">
                                            ORDERS
                                        </p>

                                        <p class="mt-2 text-lg font-bold text-white">
                                            126
                                        </p>

                                        <p class="mt-1 text-[10px] text-gray-500">
                                            14 active
                                        </p>

                                    </div>


                                    <div class="rounded-2xl bg-white/[.07] p-4">

                                        <p class="text-[11px] text-gray-500">
                                            TABLES
                                        </p>

                                        <p class="mt-2 text-lg font-bold text-white">
                                            18/24
                                        </p>

                                        <p class="mt-1 text-[10px] text-orange-400">
                                            75% occupied
                                        </p>

                                    </div>


                                    <div class="rounded-2xl bg-white/[.07] p-4">

                                        <p class="text-[11px] text-gray-500">
                                            AVG. BILL
                                        </p>

                                        <p class="mt-2 text-lg font-bold text-white">
                                            ₹382
                                        </p>

                                        <p class="mt-1 text-[10px] text-green-400">
                                            ↑ 6.2%
                                        </p>

                                    </div>

                                </div>


                                <!-- Chart + orders -->

                                <div class="mt-3 grid gap-3 sm:grid-cols-[1.3fr_.7fr]">


                                    <!-- Chart -->

                                    <div class="rounded-2xl bg-white/[.07] p-5">

                                        <div class="flex items-center justify-between">

                                            <div>

                                                <p class="text-sm font-semibold text-white">
                                                    Revenue
                                                </p>

                                                <p class="mt-1 text-[10px] text-gray-500">
                                                    Last 7 days
                                                </p>

                                            </div>

                                            <span
                                                class="rounded-full bg-green-500/10 px-2 py-1 text-[9px] text-green-400">
                                                +18.4%
                                            </span>

                                        </div>


                                        <!-- Fake chart -->

                                        <div class="mt-8 flex h-32 items-end gap-2">

                                            <div class="h-[38%] flex-1 rounded-t bg-white/10"></div>

                                            <div class="h-[54%] flex-1 rounded-t bg-white/10"></div>

                                            <div class="h-[45%] flex-1 rounded-t bg-white/10"></div>

                                            <div class="h-[67%] flex-1 rounded-t bg-white/20"></div>

                                            <div class="h-[58%] flex-1 rounded-t bg-white/20"></div>

                                            <div class="h-[82%] flex-1 rounded-t bg-[#ff385c]/60"></div>

                                            <div class="h-[96%] flex-1 rounded-t bg-[#ff385c]"></div>

                                        </div>

                                    </div>


                                    <!-- Orders -->

                                    <div class="rounded-2xl bg-white/[.07] p-5">

                                        <p class="text-sm font-semibold text-white">
                                            Live orders
                                        </p>

                                        <div class="mt-4 space-y-3">


                                            <div class="flex items-center justify-between">

                                                <div class="flex items-center gap-2">

                                                    <span
                                                        class="flex h-7 w-7 items-center justify-center rounded-lg bg-orange-500/10 text-[10px] text-orange-400">
                                                        08
                                                    </span>

                                                    <div>

                                                        <p class="text-[11px] font-medium text-white">
                                                            Table 08
                                                        </p>

                                                        <p class="text-[9px] text-gray-500">
                                                            4 items
                                                        </p>

                                                    </div>

                                                </div>

                                                <span class="text-[10px] font-bold text-white">
                                                    ₹1,240
                                                </span>

                                            </div>


                                            <div class="flex items-center justify-between">

                                                <div class="flex items-center gap-2">

                                                    <span
                                                        class="flex h-7 w-7 items-center justify-center rounded-lg bg-purple-500/10 text-[10px] text-purple-400">
                                                        03
                                                    </span>

                                                    <div>

                                                        <p class="text-[11px] font-medium text-white">
                                                            Table 03
                                                        </p>

                                                        <p class="text-[9px] text-gray-500">
                                                            2 items
                                                        </p>

                                                    </div>

                                                </div>

                                                <span class="text-[10px] font-bold text-white">
                                                    ₹680
                                                </span>

                                            </div>


                                            <div class="flex items-center justify-between">

                                                <div class="flex items-center gap-2">

                                                    <span
                                                        class="flex h-7 w-7 items-center justify-center rounded-lg bg-green-500/10 text-[10px] text-green-400">
                                                        12
                                                    </span>

                                                    <div>

                                                        <p class="text-[11px] font-medium text-white">
                                                            Table 12
                                                        </p>

                                                        <p class="text-[9px] text-gray-500">
                                                            6 items
                                                        </p>

                                                    </div>

                                                </div>

                                                <span class="text-[10px] font-bold text-white">
                                                    ₹2,140
                                                </span>

                                            </div>

                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>


                    <!-- Floating notification -->

                    <div
                        class="floating-card absolute -left-4 top-20 hidden rounded-2xl border border-white bg-white/90 p-4 shadow-xl backdrop-blur-xl sm:block">

                        <div class="flex items-center gap-3">

                            <div
                                class="flex h-10 w-10 items-center justify-center rounded-xl bg-green-50 text-green-600">
                                ✓
                            </div>

                            <div>

                                <p class="text-xs font-bold">
                                    Payment received
                                </p>

                                <p class="mt-0.5 text-[11px] text-gray-500">
                                    Order #1042 · ₹1,240
                                </p>

                            </div>

                        </div>

                    </div>


                    <!-- Floating KOT -->

                    <div
                        class="floating-card-delay absolute -bottom-5 -right-3 hidden rounded-2xl border border-white bg-white/90 p-4 shadow-xl backdrop-blur-xl sm:block">

                        <div class="flex items-center gap-3">

                            <div
                                class="flex h-10 w-10 items-center justify-center rounded-xl bg-[#ff385c]/10 text-[#ff385c]">
                                🔥
                            </div>

                            <div>

                                <p class="text-xs font-bold">
                                    New kitchen order
                                </p>

                                <p class="mt-0.5 text-[11px] text-gray-500">
                                    Table 08 · 4 items
                                </p>

                            </div>

                        </div>

                    </div>

                </div>

            </div>


            <!-- ================================================= -->
            <!-- FLOATING SEARCH BAR -->
            <!-- ================================================= -->

            <div class="relative mx-auto mt-8 max-w-4xl">

                <div class="rounded-[2rem] border border-gray-200 bg-white p-2 shadow-2xl shadow-gray-900/10">

                    <div class="grid gap-2 md:grid-cols-[1.3fr_1fr_1fr_auto]">


                        <div class="rounded-2xl px-5 py-3 transition hover:bg-gray-50">

                            <p class="text-[10px] font-bold uppercase tracking-wider text-gray-400">
                                Manage
                            </p>

                            <p class="mt-1 text-sm font-semibold">
                                Your restaurant
                            </p>

                        </div>


                        <div class="rounded-2xl px-5 py-3 transition hover:bg-gray-50">

                            <p class="text-[10px] font-bold uppercase tracking-wider text-gray-400">
                                Operations
                            </p>

                            <p class="mt-1 text-sm font-semibold">
                                Orders & tables
                            </p>

                        </div>


                        <div class="rounded-2xl px-5 py-3 transition hover:bg-gray-50">

                            <p class="text-[10px] font-bold uppercase tracking-wider text-gray-400">
                                Insights
                            </p>

                            <p class="mt-1 text-sm font-semibold">
                                Sales & reports
                            </p>

                        </div>


                        <a href="{{ route('login') }}"
                            class="flex items-center justify-center rounded-2xl bg-[#ff385c] px-7 py-4 text-sm font-bold text-white transition hover:bg-[#e61e4d]">
                            Explore →
                        </a>

                    </div>

                </div>

            </div>

        </div>

    </section>


    <!-- ===================================================== -->
    <!-- LOGO / TRUST STRIP -->
    <!-- ===================================================== -->

    <section class="border-y border-gray-100 bg-white">

        <div class="mx-auto max-w-7xl px-6 py-10 lg:px-8">

            <div class="flex flex-col items-center justify-between gap-7 md:flex-row">

                <p class="text-sm font-medium text-gray-400">
                    Everything connected. Nothing complicated.
                </p>

                <div class="flex flex-wrap justify-center gap-x-10 gap-y-4 text-sm font-bold text-gray-300">

                    <span>ORDERS</span>
                    <span>TABLES</span>
                    <span>MENU</span>
                    <span>INVENTORY</span>
                    <span>REPORTS</span>

                </div>

            </div>

        </div>

    </section>


    <!-- ===================================================== -->
    <!-- FEATURES -->
    <!-- ===================================================== -->

    <section id="features" class="bg-[#fafafa] py-28">

        <div class="mx-auto max-w-7xl px-6 lg:px-8">


            <!-- Heading -->

            <div class="max-w-3xl">

                <span class="text-sm font-bold uppercase tracking-[.2em] text-[#ff385c]">
                    One platform
                </span>

                <h2 class="mt-5 text-4xl font-black tracking-tight sm:text-6xl">
                    Your entire restaurant,
                    <span class="text-gray-400">
                        finally connected.
                    </span>
                </h2>

                <p class="mt-6 max-w-2xl text-lg leading-8 text-gray-600">
                    From the first order of the day to the last report at night,
                    everything lives in one place.
                </p>

            </div>


            <!-- Bento Grid -->

            <div class="mt-16 grid gap-5 lg:grid-cols-3">


                <!-- POS -->

                <div class="card-shine group rounded-[2rem] bg-gray-950 p-8 text-white lg:col-span-2">

                    <div class="flex h-full flex-col justify-between">

                        <div>

                            <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-[#ff385c] text-xl">
                                ₹
                            </div>

                            <h3 class="mt-7 text-3xl font-bold">
                                A POS that keeps up.
                            </h3>

                            <p class="mt-4 max-w-lg leading-7 text-gray-400">
                                Take orders, manage tables, apply discounts,
                                generate bills and process payments without
                                slowing your team down.
                            </p>

                        </div>


                        <!-- POS mockup -->

                        <div class="mt-12 rounded-2xl border border-white/10 bg-white/[.06] p-5">

                            <div class="flex items-center justify-between">

                                <span class="text-xs text-gray-500">
                                    Current order
                                </span>

                                <span class="rounded-full bg-green-500/10 px-3 py-1 text-[10px] text-green-400">
                                    TABLE 08
                                </span>

                            </div>

                            <div class="mt-5 space-y-3">

                                <div class="flex justify-between text-sm">

                                    <span class="text-gray-300">
                                        Butter Chicken × 2
                                    </span>

                                    <span class="font-semibold">
                                        ₹640
                                    </span>

                                </div>

                                <div class="flex justify-between text-sm">

                                    <span class="text-gray-300">
                                        Garlic Naan × 4
                                    </span>

                                    <span class="font-semibold">
                                        ₹360
                                    </span>

                                </div>

                                <div class="border-t border-white/10 pt-3">

                                    <div class="flex justify-between">

                                        <span class="text-gray-400">
                                            Total
                                        </span>

                                        <span class="text-xl font-bold">
                                            ₹1,000
                                        </span>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>


                <!-- Inventory -->

                <div class="card-shine rounded-[2rem] bg-gradient-to-br from-orange-50 to-rose-100 p-8">

                    <div class="flex h-full flex-col">

                        <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-white text-xl shadow-sm">
                            📦
                        </div>

                        <h3 class="mt-7 text-2xl font-bold">
                            Know your stock.
                        </h3>

                        <p class="mt-4 leading-7 text-gray-600">
                            Track ingredients, purchases, recipes,
                            wastage and stock levels.
                        </p>


                        <div class="mt-auto pt-12">

                            <div class="rounded-2xl bg-white/80 p-5 shadow-sm">

                                <div class="flex justify-between">

                                    <span class="text-xs text-gray-500">
                                        Tomato
                                    </span>

                                    <span class="text-xs font-bold text-green-600">
                                        Healthy
                                    </span>

                                </div>

                                <div class="mt-3 h-2 overflow-hidden rounded-full bg-gray-100">

                                    <div class="h-full w-[76%] rounded-full bg-green-500"></div>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>


                <!-- Menu -->

                <div class="card-shine rounded-[2rem] bg-white p-8 shadow-sm ring-1 ring-gray-200">

                    <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-gray-100 text-xl">
                        ☰
                    </div>

                    <h3 class="mt-7 text-2xl font-bold">
                        Beautiful menus.
                    </h3>

                    <p class="mt-4 leading-7 text-gray-600">
                        Organize categories, items, prices and
                        availability with a few clicks.
                    </p>

                    <div class="mt-8 space-y-2">

                        <div class="flex items-center justify-between rounded-xl bg-gray-50 px-4 py-3">

                            <span class="text-sm font-medium">
                                Starters
                            </span>

                            <span class="text-xs text-gray-400">
                                12 items
                            </span>

                        </div>

                        <div class="flex items-center justify-between rounded-xl bg-gray-50 px-4 py-3">

                            <span class="text-sm font-medium">
                                Main Course
                            </span>

                            <span class="text-xs text-gray-400">
                                28 items
                            </span>

                        </div>

                    </div>

                </div>


                <!-- Analytics -->

                <div class="card-shine rounded-[2rem] bg-gradient-to-br from-purple-50 to-indigo-100 p-8">

                    <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-white text-xl shadow-sm">
                        📊
                    </div>

                    <h3 class="mt-7 text-2xl font-bold">
                        See what matters.
                    </h3>

                    <p class="mt-4 leading-7 text-gray-600">
                        Turn restaurant activity into simple,
                        useful business insights.
                    </p>

                    <div class="mt-8 flex items-end gap-2">

                        <div class="h-16 w-full rounded-t-lg bg-purple-200"></div>
                        <div class="h-24 w-full rounded-t-lg bg-purple-300"></div>
                        <div class="h-20 w-full rounded-t-lg bg-purple-300"></div>
                        <div class="h-32 w-full rounded-t-lg bg-purple-400"></div>
                        <div class="h-40 w-full rounded-t-lg bg-purple-600"></div>

                    </div>

                </div>


                <!-- KOT -->

                <div class="card-shine rounded-[2rem] bg-gray-100 p-8">

                    <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-white text-xl shadow-sm">
                        🔥
                    </div>

                    <h3 class="mt-7 text-2xl font-bold">
                        Kitchen, in sync.
                    </h3>

                    <p class="mt-4 leading-7 text-gray-600">
                        Keep KOTs moving from the counter to the
                        kitchen without confusion.
                    </p>

                    <div class="mt-8 rounded-2xl bg-white p-5 shadow-sm">

                        <div class="flex items-center gap-3">

                            <span class="flex h-9 w-9 items-center justify-center rounded-xl bg-orange-50">
                                🔥
                            </span>

                            <div>

                                <p class="text-sm font-bold">
                                    KOT #1042
                                </p>

                                <p class="text-xs text-gray-400">
                                    Table 08 · 4 items
                                </p>

                            </div>

                            <span class="ml-auto text-xs font-bold text-orange-500">
                                NEW
                            </span>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </section>


    <!-- ===================================================== -->
    <!-- WORKFLOW -->
    <!-- ===================================================== -->

    <section id="workflow" class="bg-white py-28">

        <div class="mx-auto max-w-7xl px-6 lg:px-8">

            <div class="grid gap-16 lg:grid-cols-2 lg:items-center">


                <!-- Left -->

                <div>

                    <span class="text-sm font-bold uppercase tracking-[.2em] text-[#ff385c]">
                        Simple by design
                    </span>

                    <h2 class="mt-5 text-4xl font-black tracking-tight sm:text-6xl">
                        Less admin.
                        <br>
                        More restaurant.
                    </h2>

                    <p class="mt-6 max-w-xl text-lg leading-8 text-gray-600">
                        Restaurant operations shouldn't feel like
                        managing five different systems at once.
                    </p>


                    <div class="mt-10 space-y-7">


                        <div class="flex gap-5">

                            <div
                                class="flex h-11 w-11 shrink-0 items-center justify-center rounded-full bg-gray-950 text-sm font-bold text-white">
                                01
                            </div>

                            <div>

                                <h3 class="text-lg font-bold">
                                    Set up once
                                </h3>

                                <p class="mt-2 leading-7 text-gray-600">
                                    Add your restaurant, branches,
                                    tables, categories and menu.
                                </p>

                            </div>

                        </div>


                        <div class="flex gap-5">

                            <div
                                class="flex h-11 w-11 shrink-0 items-center justify-center rounded-full bg-gray-950 text-sm font-bold text-white">
                                02
                            </div>

                            <div>

                                <h3 class="text-lg font-bold">
                                    Run your day
                                </h3>

                                <p class="mt-2 leading-7 text-gray-600">
                                    Handle orders, tables, kitchen
                                    tickets and payments.
                                </p>

                            </div>

                        </div>


                        <div class="flex gap-5">

                            <div
                                class="flex h-11 w-11 shrink-0 items-center justify-center rounded-full bg-gray-950 text-sm font-bold text-white">
                                03
                            </div>

                            <div>

                                <h3 class="text-lg font-bold">
                                    Understand your business
                                </h3>

                                <p class="mt-2 leading-7 text-gray-600">
                                    Review sales, expenses, inventory
                                    and performance.
                                </p>

                            </div>

                        </div>

                    </div>

                </div>


                <!-- Right visual -->

                <div class="relative">

                    <div
                        class="absolute -inset-8 rounded-[4rem] bg-gradient-to-br from-orange-100 via-rose-100 to-purple-100 blur-2xl">
                    </div>

                    <div class="relative rounded-[2.5rem] bg-gray-950 p-3 shadow-2xl">

                        <div class="rounded-[2rem] bg-gradient-to-br from-gray-900 to-gray-950 p-8">

                            <div class="flex items-center justify-between">

                                <div>

                                    <p class="text-xs text-gray-500">
                                        RESTAURANT HEALTH
                                    </p>

                                    <p class="mt-2 text-3xl font-bold text-white">
                                        Looking good.
                                    </p>

                                </div>

                                <div
                                    class="flex h-12 w-12 items-center justify-center rounded-full bg-green-500/10 text-green-400">
                                    ✓
                                </div>

                            </div>


                            <div class="mt-10 space-y-4">


                                <div class="rounded-2xl bg-white/[.06] p-5">

                                    <div class="flex justify-between">

                                        <span class="text-sm text-gray-400">
                                            Sales
                                        </span>

                                        <span class="text-sm font-bold text-green-400">
                                            +18.4%
                                        </span>

                                    </div>

                                    <div class="mt-4 h-2 rounded-full bg-white/10">

                                        <div class="h-full w-[82%] rounded-full bg-green-400"></div>

                                    </div>

                                </div>


                                <div class="rounded-2xl bg-white/[.06] p-5">

                                    <div class="flex justify-between">

                                        <span class="text-sm text-gray-400">
                                            Inventory
                                        </span>

                                        <span class="text-sm font-bold text-orange-400">
                                            76%
                                        </span>

                                    </div>

                                    <div class="mt-4 h-2 rounded-full bg-white/10">

                                        <div class="h-full w-[76%] rounded-full bg-orange-400"></div>

                                    </div>

                                </div>


                                <div class="rounded-2xl bg-white/[.06] p-5">

                                    <div class="flex justify-between">

                                        <span class="text-sm text-gray-400">
                                            Table occupancy
                                        </span>

                                        <span class="text-sm font-bold text-purple-400">
                                            75%
                                        </span>

                                    </div>

                                    <div class="mt-4 h-2 rounded-full bg-white/10">

                                        <div class="h-full w-[75%] rounded-full bg-purple-400"></div>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </section>


    <!-- ===================================================== -->
    <!-- CTA -->
    <!-- ===================================================== -->

    <section id="pricing" class="px-6 pb-24 lg:px-8">

        <div class="mx-auto max-w-7xl">

            <div class="relative overflow-hidden rounded-[3rem] bg-gray-950 px-8 py-20 text-center sm:px-16">

                <!-- Background -->

                <div class="absolute -left-32 -top-32 h-96 w-96 rounded-full bg-[#ff385c]/30 blur-3xl"></div>

                <div class="absolute -bottom-40 -right-20 h-96 w-96 rounded-full bg-purple-500/20 blur-3xl"></div>


                <div class="relative">

                    <span class="text-sm font-bold uppercase tracking-[.2em] text-[#ff6b81]">
                        Ready when you are
                    </span>

                    <h2 class="mx-auto mt-6 max-w-4xl text-4xl font-black tracking-tight text-white sm:text-6xl">
                        Build a restaurant
                        <span class="text-gray-500">
                            worth running.
                        </span>
                    </h2>

                    <p class="mx-auto mt-6 max-w-2xl text-lg leading-8 text-gray-400">
                        Bring your restaurant operations together
                        and spend less time managing software.
                    </p>

                    <div class="mt-10">

                        <a href="{{ route('login') }}"
                            class="inline-flex rounded-full bg-white px-8 py-4 text-sm font-bold text-gray-950 transition hover:-translate-y-0.5 hover:bg-gray-100">
                            Get started →
                        </a>

                    </div>

                </div>

            </div>

        </div>

    </section>


    <!-- ===================================================== -->
    <!-- FOOTER -->
    <!-- ===================================================== -->

    <footer class="border-t border-gray-100 bg-white">

        <div class="mx-auto max-w-7xl px-6 py-10 lg:px-8">

            <div class="flex flex-col gap-8 md:flex-row md:items-center md:justify-between">


                <div>

                    <a href="/" class="flex items-center gap-3">

                        <div class="flex h-9 w-9 items-center justify-center rounded-full bg-[#ff385c] text-white">
                            🍽
                        </div>

                        <span class="font-bold">
                            Restaurant<span class="text-[#ff385c]">SaaS</span>
                        </span>

                    </a>

                    <p class="mt-3 text-sm text-gray-500">
                        The operating system for modern restaurants.
                    </p>

                </div>


                <div class="flex flex-wrap gap-6 text-sm font-medium text-gray-500">

                    <a href="#features" class="transition hover:text-gray-950">
                        Features
                    </a>

                    <a href="#workflow" class="transition hover:text-gray-950">
                        How it works
                    </a>

                    <a href="#pricing" class="transition hover:text-gray-950">
                        Pricing
                    </a>

                    <a href="{{ route('login') }}" class="transition hover:text-gray-950">
                        Login
                    </a>

                </div>

            </div>


            <div class="mt-10 border-t border-gray-100 pt-6">

                <p class="text-xs text-gray-400">
                    © {{ date('Y') }} Restaurant SaaS. Built for modern restaurant teams.
                </p>

            </div>

        </div>

    </footer>

</body>

</html>