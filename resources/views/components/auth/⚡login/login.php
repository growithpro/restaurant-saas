<?php

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

new class extends Component
{
    public string $email = '';

    public string $password = '';

    public function login()
    {
        $this->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt([
            'email' => $this->email,
            'password' => $this->password,
        ])) {
            session()->regenerate();

            return redirect()->intended('/dashboard');
        }

        $this->addError(
            'email',
            'Invalid email or password.'
        );
    }

    public function render()
    {
        return $this->view()
            ->layout('layouts.guest');
    }
};
