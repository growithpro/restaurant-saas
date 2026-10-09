<?php

use App\Models\InventoryItem;
use App\Models\MenuItem;
use App\Models\Recipe;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

new class extends Component
{
    public ?int $menuItemId = null;

    public string $inventoryItemId = '';

    public string $quantity = '';

    public string $notes = '';

    public string $search = '';

    public function selectMenuItem(int $id): void
    {
        $restaurantId = Auth::user()->restaurant_id;

        MenuItem::where('restaurant_id', $restaurantId)
            ->findOrFail($id);

        $this->menuItemId = $id;

        $this->reset([
            'inventoryItemId',
            'quantity',
            'notes',
        ]);
    }

    public function addIngredient(int $menuItemId): void
    {
        $restaurantId = Auth::user()->restaurant_id;

        $this->validate([
            'inventoryItemId' => [
                'required',
                'integer',
            ],

            'quantity' => [
                'required',
                'numeric',
                'min:0.001',
            ],

            'notes' => [
                'nullable',
                'string',
                'max:1000',
            ],
        ]);

        $menuItem = MenuItem::where(
            'restaurant_id',
            $restaurantId
        )->findOrFail($menuItemId);

        $inventoryItem = InventoryItem::where(
            'restaurant_id',
            $restaurantId
        )
            ->where('is_active', true)
            ->findOrFail($this->inventoryItemId);

        Recipe::updateOrCreate(
            [
                'restaurant_id' => $restaurantId,
                'menu_item_id' => $menuItem->id,
                'inventory_item_id' => $inventoryItem->id,
            ],
            [
                'quantity' => $this->quantity,
                'notes' => $this->notes ?: null,
            ]
        );

        $this->reset([
            'inventoryItemId',
            'quantity',
            'notes',
        ]);

        session()->flash(
            'success',
            "{$inventoryItem->name} added to {$menuItem->name} recipe."
        );
    }

    public function removeIngredient(int $id): void
    {
        $restaurantId = Auth::user()->restaurant_id;

        Recipe::where(
            'restaurant_id',
            $restaurantId
        )
            ->findOrFail($id)
            ->delete();

        session()->flash(
            'success',
            'Ingredient removed from recipe.'
        );
    }

    public function render()
    {
        $restaurantId = Auth::user()->restaurant_id;

        $menuItems = MenuItem::where(
            'restaurant_id',
            $restaurantId
        )
            ->where('is_available', true)
            ->with([
                'category',
                'recipes.inventoryItem',
            ])
            ->when(
                $this->search,
                function ($query) {
                    $query->where(
                        'name',
                        'like',
                        '%'.$this->search.'%'
                    );
                }
            )
            ->orderBy('name')
            ->get();

        $inventoryItems = InventoryItem::where(
            'restaurant_id',
            $restaurantId
        )
            ->where('is_active', true)
            ->orderBy('name')
            ->get();

        return $this->view([
            'menuItems' => $menuItems,
            'inventoryItems' => $inventoryItems,
        ])->layout('layouts.app');
    }
};
