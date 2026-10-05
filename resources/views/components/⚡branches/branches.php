<?php

use App\Models\Branch;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Livewire\Component;

new class extends Component
{
    public ?int $editingId = null;

    public string $name = '';

    public string $code = '';

    public string $phone = '';

    public string $email = '';

    public string $address = '';

    public bool $is_active = true;

    public bool $showForm = false;

    public function mount(): void
    {
        if (! Auth::user()->restaurant_id) {
            redirect()->route('restaurant.setup');
        }
    }

    public function openCreate(): void
    {
        $this->resetForm();

        $this->showForm = true;
    }

    public function edit(int $id): void
    {
        $restaurantId = Auth::user()->restaurant_id;

        $branch = Branch::where('restaurant_id', $restaurantId)
            ->findOrFail($id);

        $this->editingId = $branch->id;

        $this->name = $branch->name;
        $this->code = $branch->code;
        $this->phone = $branch->phone ?? '';
        $this->email = $branch->email ?? '';
        $this->address = $branch->address ?? '';
        $this->is_active = $branch->is_active;

        $this->showForm = true;
    }

    public function save(): void
    {
        $restaurantId = Auth::user()->restaurant_id;

        if (! $restaurantId) {
            $this->addError(
                'name',
                'Please setup your restaurant first.'
            );

            return;
        }

        $this->validate([
            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'code' => [
                'required',
                'string',
                'max:50',

                Rule::unique('branches', 'code')
                    ->where(
                        fn ($query) => $query->where(
                            'restaurant_id',
                            $restaurantId
                        )
                    )
                    ->ignore($this->editingId),
            ],

            'phone' => [
                'nullable',
                'string',
                'max:30',
            ],

            'email' => [
                'nullable',
                'email',
                'max:255',
            ],

            'address' => [
                'nullable',
                'string',
            ],

            'is_active' => [
                'boolean',
            ],
        ]);

        $data = [
            'name' => $this->name,
            'code' => strtoupper(trim($this->code)),
            'phone' => $this->phone ?: null,
            'email' => $this->email ?: null,
            'address' => $this->address ?: null,
            'is_active' => $this->is_active,
        ];

        if ($this->editingId) {

            $branch = Branch::where(
                'restaurant_id',
                $restaurantId
            )->findOrFail($this->editingId);

            $branch->update($data);

            session()->flash(
                'success',
                'Branch updated successfully.'
            );

        } else {

            Branch::create([
                'restaurant_id' => $restaurantId,
                ...$data,
            ]);

            session()->flash(
                'success',
                'Branch created successfully.'
            );
        }

        $this->resetForm();
    }

    public function delete(int $id): void
    {
        $restaurantId = Auth::user()->restaurant_id;

        $branch = Branch::where(
            'restaurant_id',
            $restaurantId
        )->findOrFail($id);

        $branch->delete();

        session()->flash(
            'success',
            'Branch deleted successfully.'
        );
    }

    public function toggleStatus(int $id): void
    {
        $restaurantId = Auth::user()->restaurant_id;

        $branch = Branch::where(
            'restaurant_id',
            $restaurantId
        )->findOrFail($id);

        $branch->update([
            'is_active' => ! $branch->is_active,
        ]);
    }

    public function cancel(): void
    {
        $this->resetForm();
    }

    private function resetForm(): void
    {
        $this->reset([
            'editingId',
            'name',
            'code',
            'phone',
            'email',
            'address',
        ]);

        $this->is_active = true;
        $this->showForm = false;

        $this->resetValidation();
    }

    public function render()
    {
        $restaurantId = Auth::user()->restaurant_id;

        return $this->view([
            'branches' => Branch::where(
                'restaurant_id',
                $restaurantId
            )
                ->latest()
                ->get(),
        ])->layout('layouts.app');
    }
};
