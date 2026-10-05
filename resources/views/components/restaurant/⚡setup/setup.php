<?php

use App\Models\Restaurant;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Livewire\Component;

new class extends Component
{
    public string $name = '';
    public string $phone = '';
    public string $email = '';
    public string $address = '';

    public function mount(): void
    {
        $restaurant = Auth::user()->restaurant;

        if ($restaurant) {
            $this->name = $restaurant->name;
            $this->phone = $restaurant->phone ?? '';
            $this->email = $restaurant->email ?? '';
            $this->address = $restaurant->address ?? '';
        }
    }

    public function save(): void
    {
        $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:30'],
            'email' => ['nullable', 'email', 'max:255'],
            'address' => ['nullable', 'string'],
        ]);

        $user = Auth::user();

        $restaurant = $user->restaurant;

        if (!$restaurant) {
            $restaurant = Restaurant::create([
                'name' => $this->name,
                'slug' => Str::slug($this->name) . '-' . Str::lower(Str::random(6)),
                'phone' => $this->phone ?: null,
                'email' => $this->email ?: null,
                'address' => $this->address ?: null,
            ]);

            $user->restaurant_id = $restaurant->id;
            $user->save();
        } else {
            $restaurant->update([
                'name' => $this->name,
                'phone' => $this->phone ?: null,
                'email' => $this->email ?: null,
                'address' => $this->address ?: null,
            ]);
        }

        session()->flash('success', 'Restaurant details saved successfully.');
    }
};