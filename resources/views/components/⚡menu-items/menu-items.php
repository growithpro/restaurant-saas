<?php

use App\Models\Category;
use App\Models\MenuItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithFileUploads;

new class extends Component
{
    use WithFileUploads;

    public ?int $editingMenuItemId = null;

    public bool $showForm = false;

    public string $search = '';

    public ?int $filterCategoryId = null;

    public ?int $categoryId = null;

    public string $name = '';

    public string $code = '';

    public string $description = '';

    public string $price = '';

    public $image = null;

    public ?string $existingImage = null;

    public int $sortOrder = 0;

    public bool $isAvailable = true;

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

        $menuItem = MenuItem::where(
            'restaurant_id',
            $restaurantId
        )->findOrFail($id);

        $this->editingMenuItemId = $menuItem->id;

        $this->categoryId = $menuItem->category_id;
        $this->name = $menuItem->name;
        $this->code = $menuItem->code;
        $this->description = $menuItem->description ?? '';
        $this->price = (string) $menuItem->price;
        $this->existingImage = $menuItem->image;
        $this->sortOrder = $menuItem->sort_order;
        $this->isAvailable = $menuItem->is_available;

        $this->image = null;

        $this->showForm = true;

        $this->resetValidation();
    }

    public function save(): void
    {
        $restaurantId = Auth::user()->restaurant_id;

        $this->validate([
            'categoryId' => [
                'required',
                'integer',
                Rule::exists('categories', 'id')
                    ->where(
                        fn ($query) => $query->where(
                            'restaurant_id',
                            $restaurantId
                        )
                    ),
            ],

            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'code' => [
                'required',
                'string',
                'max:50',
                Rule::unique(
                    'menu_items',
                    'code'
                )
                    ->where(
                        fn ($query) => $query->where(
                            'restaurant_id',
                            $restaurantId
                        )
                    )
                    ->ignore($this->editingMenuItemId),
            ],

            'description' => [
                'nullable',
                'string',
                'max:2000',
            ],

            'price' => [
                'required',
                'numeric',
                'min:0',
                'max:99999999.99',
            ],

            'image' => [
                'nullable',
                'image',
                'max:2048',
            ],

            'sortOrder' => [
                'integer',
                'min:0',
                'max:9999',
            ],

            'isAvailable' => [
                'boolean',
            ],
        ]);

        $data = [
            'category_id' => $this->categoryId,
            'name' => trim($this->name),
            'code' => strtoupper(trim($this->code)),
            'description' => $this->description
                ? trim($this->description)
                : null,
            'price' => $this->price,
            'sort_order' => $this->sortOrder,
            'is_available' => $this->isAvailable,
        ];

        if ($this->image) {
            $data['image'] = $this->image->store(
                'menu-items',
                'public'
            );
        }

        if ($this->editingMenuItemId) {

            $menuItem = MenuItem::where(
                'restaurant_id',
                $restaurantId
            )->findOrFail($this->editingMenuItemId);

            if (
                $this->image &&
                $menuItem->image &&
                Storage::disk('public')->exists($menuItem->image)
            ) {
                Storage::disk('public')->delete(
                    $menuItem->image
                );
            }

            $menuItem->update($data);

            session()->flash(
                'success',
                'Menu item updated successfully.'
            );

        } else {

            MenuItem::create([
                'restaurant_id' => $restaurantId,
                ...$data,
            ]);

            session()->flash(
                'success',
                'Menu item created successfully.'
            );
        }

        $this->resetForm();
    }

    public function delete(int $id): void
    {
        $restaurantId = Auth::user()->restaurant_id;

        $menuItem = MenuItem::where(
            'restaurant_id',
            $restaurantId
        )->findOrFail($id);

        if (
            $menuItem->image &&
            Storage::disk('public')->exists($menuItem->image)
        ) {
            Storage::disk('public')->delete(
                $menuItem->image
            );
        }

        $menuItem->delete();

        session()->flash(
            'success',
            'Menu item deleted successfully.'
        );
    }

    public function toggleAvailability(int $id): void
    {
        $restaurantId = Auth::user()->restaurant_id;

        $menuItem = MenuItem::where(
            'restaurant_id',
            $restaurantId
        )->findOrFail($id);

        $menuItem->update([
            'is_available' => ! $menuItem->is_available,
        ]);
    }

    public function cancel(): void
    {
        $this->resetForm();
    }

    private function resetForm(): void
    {
        $this->reset([
            'editingMenuItemId',
            'categoryId',
            'name',
            'code',
            'description',
            'price',
            'image',
            'existingImage',
            'sortOrder',
        ]);

        $this->isAvailable = true;
        $this->showForm = false;

        $this->resetValidation();
    }

    public function removeExistingImage(): void
    {
        $restaurantId = Auth::user()->restaurant_id;

        if (! $this->editingMenuItemId) {
            return;
        }

        $menuItem = MenuItem::where(
            'restaurant_id',
            $restaurantId
        )->findOrFail($this->editingMenuItemId);

        if (
            $menuItem->image &&
            Storage::disk('public')->exists($menuItem->image)
        ) {
            Storage::disk('public')->delete(
                $menuItem->image
            );
        }

        $menuItem->update([
            'image' => null,
        ]);

        $this->existingImage = null;

        session()->flash(
            'success',
            'Menu item image removed.'
        );
    }

    public function render()
    {
        $restaurantId = Auth::user()->restaurant_id;

        $categories = Category::where(
            'restaurant_id',
            $restaurantId
        )
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();

        $menuItems = MenuItem::where(
            'restaurant_id',
            $restaurantId
        )
            ->with('category')
            ->when(
                $this->filterCategoryId,
                function ($query) {
                    $query->where(
                        'category_id',
                        $this->filterCategoryId
                    );
                }
            )
            ->when(
                trim($this->search) !== '',
                function ($query) {
                    $search = '%'.trim($this->search).'%';

                    $query->where(function ($q) use ($search) {
                        $q->where(
                            'name',
                            'like',
                            $search
                        )
                            ->orWhere(
                                'code',
                                'like',
                                $search
                            )
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
            'menuItems' => $menuItems,
        ])->layout('layouts.app');
    }
};
