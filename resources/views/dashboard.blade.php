<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Dashboard - Restaurant SaaS</title>

    @livewireStyles
</head>

<body>

    <header>
        <h1>Restaurant SaaS</h1>

        <span>
            {{ auth()->user()->name }}
        </span>

        <form method="POST" action="{{ route('logout') }}">
            @csrf

            <button type="submit">
                Logout
            </button>
        </form>
    </header>

    <main>

        <h2>Dashboard</h2>

        @if (auth()->user()->restaurant)
            <h3>
                {{ auth()->user()->restaurant->name }}
            </h3>

            <p>
                {{ auth()->user()->restaurant->address }}
            </p>
        @else
            <p>
                Your restaurant is not configured yet.
            </p>

            <a href="{{ route('restaurant.setup') }}">
                Setup Restaurant
            </a>
        @endif

    </main>

    @livewireScripts

</body>

</html>