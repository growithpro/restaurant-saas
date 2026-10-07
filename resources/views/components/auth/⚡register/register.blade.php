<div class="min-h-screen bg-gray-50 px-4 py-10">

    <div class="mx-auto max-w-2xl">

        {{-- Logo / Heading --}}
        <div class="mb-8 text-center">

            <a href="/" class="text-2xl font-bold text-gray-900">
                Restaurant SaaS
            </a>

            <h1 class="mt-6 text-3xl font-bold text-gray-900">
                Create your restaurant account
            </h1>

            <p class="mt-2 text-sm text-gray-500">
                Set up your restaurant and start managing your business.
            </p>

        </div>

        {{-- Card --}}
        <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm sm:p-8">

            <form wire:submit="register" class="space-y-8">

                {{-- Owner --}}
                <div>

                    <h2 class="text-lg font-bold text-gray-900">
                        Owner Information
                    </h2>

                    <p class="mt-1 text-sm text-gray-500">
                        Your account information.
                    </p>

                    <div class="mt-5 grid gap-5 sm:grid-cols-2">

                        {{-- Name --}}
                        <div class="sm:col-span-2">

                            <label class="mb-2 block text-sm font-semibold text-gray-700">
                                Owner Name
                            </label>

                            <input type="text" wire:model="ownerName" placeholder="Your full name" autocomplete="name"
                                class="w-full rounded-xl border border-gray-300 px-4 py-3 text-sm outline-none transition focus:border-gray-900 focus:ring-2 focus:ring-gray-900/10">

                            @error('ownerName')
                                <p class="mt-2 text-sm text-red-600">
                                    {{ $message }}
                                </p>
                            @enderror

                        </div>

                        {{-- Email --}}
                        <div class="sm:col-span-2">

                            <label class="mb-2 block text-sm font-semibold text-gray-700">
                                Owner Email
                            </label>

                            <input type="email" wire:model="ownerEmail" placeholder="you@example.com"
                                autocomplete="email"
                                class="w-full rounded-xl border border-gray-300 px-4 py-3 text-sm outline-none transition focus:border-gray-900 focus:ring-2 focus:ring-gray-900/10">

                            @error('ownerEmail')
                                <p class="mt-2 text-sm text-red-600">
                                    {{ $message }}
                                </p>
                            @enderror

                        </div>

                        {{-- Password --}}
                        <div>

                            <label class="mb-2 block text-sm font-semibold text-gray-700">
                                Password
                            </label>

                            <input type="password" wire:model="password" placeholder="Minimum 8 characters"
                                autocomplete="new-password"
                                class="w-full rounded-xl border border-gray-300 px-4 py-3 text-sm outline-none transition focus:border-gray-900 focus:ring-2 focus:ring-gray-900/10">

                            @error('password')
                                <p class="mt-2 text-sm text-red-600">
                                    {{ $message }}
                                </p>
                            @enderror

                        </div>

                        {{-- Confirm Password --}}
                        <div>

                            <label class="mb-2 block text-sm font-semibold text-gray-700">
                                Confirm Password
                            </label>

                            <input type="password" wire:model="passwordConfirmation" placeholder="Repeat password"
                                autocomplete="new-password"
                                class="w-full rounded-xl border border-gray-300 px-4 py-3 text-sm outline-none transition focus:border-gray-900 focus:ring-2 focus:ring-gray-900/10">

                        </div>

                    </div>

                </div>

                {{-- Restaurant --}}
                <div class="border-t border-gray-100 pt-8">

                    <h2 class="text-lg font-bold text-gray-900">
                        Restaurant Information
                    </h2>

                    <p class="mt-1 text-sm text-gray-500">
                        Basic information about your restaurant.
                    </p>

                    <div class="mt-5 grid gap-5 sm:grid-cols-2">

                        {{-- Restaurant Name --}}
                        <div class="sm:col-span-2">

                            <label class="mb-2 block text-sm font-semibold text-gray-700">
                                Restaurant Name
                            </label>

                            <input type="text" wire:model="restaurantName" placeholder="e.g. Sharma Restaurant"
                                class="w-full rounded-xl border border-gray-300 px-4 py-3 text-sm outline-none transition focus:border-gray-900 focus:ring-2 focus:ring-gray-900/10">

                            @error('restaurantName')
                                <p class="mt-2 text-sm text-red-600">
                                    {{ $message }}
                                </p>
                            @enderror

                        </div>

                        {{-- Phone --}}
                        <div>

                            <label class="mb-2 block text-sm font-semibold text-gray-700">
                                Restaurant Phone
                            </label>

                            <input type="text" wire:model="restaurantPhone" placeholder="+91 98765 43210"
                                autocomplete="tel"
                                class="w-full rounded-xl border border-gray-300 px-4 py-3 text-sm outline-none transition focus:border-gray-900 focus:ring-2 focus:ring-gray-900/10">

                            @error('restaurantPhone')
                                <p class="mt-2 text-sm text-red-600">
                                    {{ $message }}
                                </p>
                            @enderror

                        </div>

                        {{-- Restaurant Email --}}
                        <div>

                            <label class="mb-2 block text-sm font-semibold text-gray-700">
                                Restaurant Email
                            </label>

                            <input type="email" wire:model="restaurantEmail" placeholder="restaurant@example.com"
                                autocomplete="email"
                                class="w-full rounded-xl border border-gray-300 px-4 py-3 text-sm outline-none transition focus:border-gray-900 focus:ring-2 focus:ring-gray-900/10">

                            @error('restaurantEmail')
                                <p class="mt-2 text-sm text-red-600">
                                    {{ $message }}
                                </p>
                            @enderror

                        </div>

                        {{-- Address --}}
                        <div class="sm:col-span-2">

                            <label class="mb-2 block text-sm font-semibold text-gray-700">
                                Restaurant Address
                            </label>

                            <textarea wire:model="restaurantAddress" rows="3" placeholder="Restaurant address..."
                                class="w-full rounded-xl border border-gray-300 px-4 py-3 text-sm outline-none transition focus:border-gray-900 focus:ring-2 focus:ring-gray-900/10"></textarea>

                            @error('restaurantAddress')
                                <p class="mt-2 text-sm text-red-600">
                                    {{ $message }}
                                </p>
                            @enderror

                        </div>

                    </div>

                </div>

                {{-- Submit --}}
                <div class="border-t border-gray-100 pt-6">

                    <button type="submit" wire:loading.attr="disabled"
                        class="w-full rounded-xl bg-gray-900 px-5 py-3.5 text-sm font-semibold text-white transition hover:bg-gray-800 disabled:cursor-not-allowed disabled:opacity-60">

                        <span wire:loading.remove wire:target="register">
                            Create Restaurant Account
                        </span>

                        <span wire:loading wire:target="register">
                            Creating Account...
                        </span>

                    </button>

                </div>

            </form>

            {{-- Login --}}
            <div class="mt-6 text-center">

                <p class="text-sm text-gray-500">
                    Already have an account?

                    <a href="{{ route('login') }}" class="font-semibold text-gray-900 hover:underline">
                        Login
                    </a>
                </p>

            </div>

        </div>

        <p class="mt-6 text-center text-xs text-gray-400">
            By creating an account, you can start managing your restaurant through Restaurant SaaS.
        </p>

    </div>

</div>