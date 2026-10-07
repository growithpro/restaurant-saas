<?php

use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Livewire\Component;

new class extends Component
{
    public ?int $editingCategoryId = null;

    public bool $showForm = false;

    public string $name = '';

    public string $description = '';

    public int $sortOrder = 0;

    public bool $isActive = true;

    public string $search = '';

    public function mount(): void
    {
        if (! Auth::user()->restaurant_id) {
            redirect()->route('restaurant.setup');

            return;
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

        $category = Category::where(
            'restaurant_id',
            $restaurantId
        )->findOrFail($id);

        $this->editingCategoryId = $category->id;
        $this->name = $category->name;
        $this->description = $category->description ?? '';
        $this->sortOrder = $category->sort_order;
        $this->isActive = $category->is_active;

        $this->showForm = true;

        $this->resetValidation();
    }

    public function save(): void
    {
        $restaurantId = Auth::user()->restaurant_id;

        $this->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('categories', 'name')
                    ->where(
                        fn ($query) => $query->where(
                            'restaurant_id',
                            $restaurantId
                        )
                    )
                    ->ignore($this->editingCategoryId),
            ],

            'description' => [
                'nullable',
                'string',
                'max:1000',
            ],

            'sortOrder' => [
                'integer',
                'min:0',
                'max:9999',
            ],

            'isActive' => [
                'boolean',
            ],
        ]);

        $data = [
            'name' => trim($this->name),
            'description' => $this->description
                ? trim($this->description)
                : null,
            'sort_order' => $this->sortOrder,
            'is_active' => $this->isActive,
        ];

        if ($this->editingCategoryId) {
            $category = Category::where(
                'restaurant_id',
                $restaurantId
            )->findOrFail($this->editingCategoryId);

            $category->update($data);

            session()->flash(
                'success',
                'Category updated successfully.'
            );
        } else {
            Category::create([
                'restaurant_id' => $restaurantId,
                ...$data,
            ]);

            session()->flash(
                'success',
                'Category created successfully.'
            );
        }

        $this->resetForm();
    }

    public function delete(int $id): void
    {
        $restaurantId = Auth::user()->restaurant_id;

        $category = Category::where(
            'restaurant_id',
            $restaurantId
        )->findOrFail($id);

        if ($category->menuItems()->exists()) {
            session()->flash(
                'error',
                'This category cannot be deleted because it has menu items. Move or delete those items first.'
            );

            return;
        }

        $category->delete();

        session()->flash(
            'success',
            'Category deleted successfully.'
        );
    }

    public function toggleStatus(int $id): void
    {
        $restaurantId = Auth::user()->restaurant_id;

        $category = Category::where(
            'restaurant_id',
            $restaurantId
        )->findOrFail($id);

        $category->update([
            'is_active' => ! $category->is_active,
        ]);
    }

    public function cancel(): void
    {
        $this->resetForm();
    }

    private function resetForm(): void
    {
        $this->reset([
            'editingCategoryId',
            'name',
            'description',
            'sortOrder',
        ]);

        $this->isActive = true;
        $this->showForm = false;

        $this->resetValidation();
    }

    public function render()
    {
        $restaurantId = Auth::user()->restaurant_id;

        $categories = Category::where(
            'restaurant_id',
            $restaurantId
        )
            ->withCount('menuItems')
            ->when(
                trim($this->search) !== '',
                function ($query) {
                    $search = '%'.trim($this->search).'%';

                    $query->where(function ($q) use ($search) {
                        $q->where('name', 'like', $search)
                            ->orWhere(
                                'description',
                                'like',
                                $search
                            );
                    });
                }
            )
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();

        return $this->view([
            'categories' => $categories,
        ])->layout('layouts.app');
    }
};
