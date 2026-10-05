<div class="min-h-[calc(100vh-73px)] bg-gray-50">

    <div class="mx-auto max-w-4xl px-6 py-10">

        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">
                Restaurant Setup
            </h1>

            <p class="mt-2 text-gray-600">
                Manage your restaurant's basic information.
            </p>
        </div>

        @if (session('success'))
            <div class="mb-6 rounded-xl border border-green-200 bg-green-50 px-5 py-4 text-green-700">
                {{ session('success') }}
            </div>
        @endif

        <div class="rounded-2xl border border-gray-200 bg-white p-8 shadow-sm">

            <form wire:submit="save" class="space-y-6">

                <div>
                    <label class="mb-2 block text-sm font-medium text-gray-700">
                        Restaurant Name
                    </label>

                    <input type="text" wire:model="name" placeholder="e.g. The Food House"
                        class="w-full rounded-xl border border-gray-300 px-4 py-3 outline-none focus:border-gray-900 focus:ring-2 focus:ring-gray-200">

                    @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid gap-6 md:grid-cols-2">

                    <div>
                        <label class="mb-2 block text-sm font-medium text-gray-700">
                            Phone
                        </label>

                        <input type="text" wire:model="phone" placeholder="+91 9876543210"
                            class="w-full rounded-xl border border-gray-300 px-4 py-3 outline-none focus:border-gray-900 focus:ring-2 focus:ring-gray-200">

                        @error('phone')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-medium text-gray-700">
                            Email
                        </label>

                        <input type="email" wire:model="email" placeholder="restaurant@example.com"
                            class="w-full rounded-xl border border-gray-300 px-4 py-3 outline-none focus:border-gray-900 focus:ring-2 focus:ring-gray-200">

                        @error('email')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                </div>

                <div>
                    <label class="mb-2 block text-sm font-medium text-gray-700">
                        Address
                    </label>

                    <textarea wire:model="address" rows="4" placeholder="Enter restaurant address"
                        class="w-full rounded-xl border border-gray-300 px-4 py-3 outline-none focus:border-gray-900 focus:ring-2 focus:ring-gray-200"></textarea>

                    @error('address')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex justify-end border-t border-gray-100 pt-6">

                    <button type="submit" wire:loading.attr="disabled"
                        class="rounded-xl bg-gray-900 px-6 py-3 font-medium text-white transition hover:bg-gray-700 disabled:opacity-50">

                        <span wire:loading.remove>
                            Save Changes
                        </span>

                        <span wire:loading>
                            Saving...
                        </span>

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>