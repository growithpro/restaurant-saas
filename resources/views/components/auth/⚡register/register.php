<?php

use App\Models\Restaurant;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Password;
use Livewire\Component;

new class extends Component
{
    public string $ownerName = '';

    public string $ownerEmail = '';

    public string $password = '';

    public string $passwordConfirmation = '';

    public string $restaurantName = '';

    public string $restaurantPhone = '';

    public string $restaurantEmail = '';

    public string $restaurantAddress = '';

    public function register(): void
    {
        $this->validate([
            'ownerName' => [
                'required',
                'string',
                'max:255',
            ],

            'ownerEmail' => [
                'required',
                'email',
                'max:255',
                'unique:users,email',
            ],

            'password' => [
                'required',
                'confirmed:passwordConfirmation',
                Password::min(8),
            ],

            'restaurantName' => [
                'required',
                'string',
                'max:255',
            ],

            'restaurantPhone' => [
                'nullable',
                'string',
                'max:30',
            ],

            'restaurantEmail' => [
                'nullable',
                'email',
                'max:255',
            ],

            'restaurantAddress' => [
                'nullable',
                'string',
                'max:1000',
            ],
        ]);

        DB::transaction(function () {
            $slug = $this->generateUniqueSlug(
                $this->restaurantName
            );

            $restaurant = Restaurant::create([
                'name' => trim($this->restaurantName),
                'slug' => $slug,
                'phone' => $this->restaurantPhone
                    ? trim($this->restaurantPhone)
                    : null,
                'email' => $this->restaurantEmail
                    ? trim($this->restaurantEmail)
                    : null,
                'address' => $this->restaurantAddress
                    ? trim($this->restaurantAddress)
                    : null,
            ]);

            $user = User::create([
                'name' => trim($this->ownerName),
                'email' => strtolower(trim($this->ownerEmail)),
                'password' => Hash::make($this->password),
                'restaurant_id' => $restaurant->id,
            ]);

            Auth::login($user);

            request()->session()->regenerate();
        });

        session()->flash(
            'success',
            'Restaurant account created successfully. Welcome!'
        );

        $this->redirect(
            route('dashboard'),
            navigate: true
        );
    }

    private function generateUniqueSlug(string $name): string
    {
        $baseSlug = Str::slug($name);

        if ($baseSlug === '') {
            $baseSlug = 'restaurant';
        }

        $slug = $baseSlug;

        $counter = 1;

        while (
            Restaurant::where('slug', $slug)->exists()
        ) {
            $slug = $baseSlug.'-'.$counter;

            $counter++;
        }

        return $slug;
    }

    public function render()
    {
        return $this->view()
            ->layout('layouts.guest');
    }
};
