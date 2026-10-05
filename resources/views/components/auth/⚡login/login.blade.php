<div class="flex min-h-screen items-center justify-center px-6 py-12">

    <div class="w-full max-w-md">

        <!-- Logo / Brand -->

        <div class="mb-8 text-center">

            <a href="{{ url('/') }}" class="text-2xl font-bold text-gray-900">
                🍽 Restaurant SaaS
            </a>

            <p class="mt-2 text-sm text-gray-500">
                Restaurant management made simple
            </p>

        </div>


        <!-- Login Card -->

        <div class="rounded-2xl border border-gray-200 bg-white p-8 shadow-sm">

            <div class="mb-6">

                <h1 class="text-2xl font-bold text-gray-900">
                    Welcome back
                </h1>

                <p class="mt-2 text-sm text-gray-500">
                    Sign in to manage your restaurant.
                </p>

            </div>


            <!-- Login Form -->

            <form wire:submit="login" class="space-y-5">

                <!-- Email -->

                <div>

                    <label for="email" class="mb-2 block text-sm font-medium text-gray-700">
                        Email
                    </label>

                    <input id="email" type="email" wire:model="email" placeholder="admin@example.com"
                        autocomplete="email"
                        class="w-full rounded-xl border border-gray-300 px-4 py-3 outline-none transition focus:border-gray-900 focus:ring-2 focus:ring-gray-200">

                    @error('email')
                        <p class="mt-2 text-sm text-red-600">
                            {{ $message }}
                        </p>
                    @enderror

                </div>


                <!-- Password -->

                <div>

                    <div class="mb-2 flex items-center justify-between">

                        <label for="password" class="block text-sm font-medium text-gray-700">
                            Password
                        </label>

                    </div>

                    <input id="password" type="password" wire:model="password" placeholder="Enter your password"
                        autocomplete="current-password"
                        class="w-full rounded-xl border border-gray-300 px-4 py-3 outline-none transition focus:border-gray-900 focus:ring-2 focus:ring-gray-200">

                    @error('password')
                        <p class="mt-2 text-sm text-red-600">
                            {{ $message }}
                        </p>
                    @enderror

                </div>


                <!-- Login Button -->

                <button type="submit" wire:loading.attr="disabled"
                    class="w-full rounded-xl bg-gray-900 px-5 py-3 font-medium text-white transition hover:bg-gray-700 disabled:cursor-not-allowed disabled:opacity-50">

                    <span wire:loading.remove>
                        Sign In
                    </span>

                    <span wire:loading>
                        Signing in...
                    </span>

                </button>

            </form>

        </div>


        <!-- Footer -->

        <p class="mt-6 text-center text-sm text-gray-500">
            Restaurant SaaS
        </p>

    </div>

</div>