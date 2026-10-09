<?php

use App\Models\InventoryItem;
use App\Models\StockTransaction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

new class extends Component
{
    use WithPagination;

    public string $search = '';

    public string $filter = 'all';

    public bool $showModal = false;

    public bool $showTransactionModal = false;

    public ?int $editingId = null;

    public ?int $transactionItemId = null;

    public string $name = '';

    public string $sku = '';

    public string $unit = 'kg';

    public string $currentStock = '0';

    public string $minimumStock = '0';

    public string $costPerUnit = '0';

    public bool $isActive = true;

    public string $notes = '';

    public string $transactionType = 'in';

    public string $transactionQuantity = '';

    public string $transactionReference = '';

    public string $transactionNotes = '';

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function openCreate(): void
    {
        $this->reset([
            'editingId',
            'name',
            'sku',
            'notes',
        ]);

        $this->unit = 'kg';
        $this->currentStock = '0';
        $this->minimumStock = '0';
        $this->costPerUnit = '0';
        $this->isActive = true;

        $this->showModal = true;
    }

    public function openEdit(int $id): void
    {
        $restaurantId = Auth::user()->restaurant_id;

        $item = InventoryItem::where(
            'restaurant_id',
            $restaurantId
        )->findOrFail($id);

        $this->editingId = $item->id;
        $this->name = $item->name;
        $this->sku = $item->sku ?? '';
        $this->unit = $item->unit;
        $this->currentStock = (string) $item->current_stock;
        $this->minimumStock = (string) $item->minimum_stock;
        $this->costPerUnit = (string) $item->cost_per_unit;
        $this->isActive = $item->is_active;
        $this->notes = $item->notes ?? '';

        $this->showModal = true;
    }

    public function closeModal(): void
    {
        $this->showModal = false;
    }

    public function save(): void
    {
        $restaurantId = Auth::user()->restaurant_id;

        $this->validate([
            'name' => [
                'required',
                'string',
                'max:255',
            ],
            'sku' => [
                'nullable',
                'string',
                'max:100',
            ],
            'unit' => [
                'required',
                'string',
                'max:30',
            ],
            'currentStock' => [
                'required',
                'numeric',
                'min:0',
            ],
            'minimumStock' => [
                'required',
                'numeric',
                'min:0',
            ],
            'costPerUnit' => [
                'required',
                'numeric',
                'min:0',
            ],
            'notes' => [
                'nullable',
                'string',
            ],
        ]);

        DB::transaction(function () use ($restaurantId) {

            if ($this->editingId) {

                $item = InventoryItem::where(
                    'restaurant_id',
                    $restaurantId
                )->findOrFail($this->editingId);

                $item->update([
                    'name' => $this->name,
                    'sku' => $this->sku ?: null,
                    'unit' => $this->unit,
                    'minimum_stock' => $this->minimumStock,
                    'cost_per_unit' => $this->costPerUnit,
                    'is_active' => $this->isActive,
                    'notes' => $this->notes ?: null,
                ]);

            } else {

                $item = InventoryItem::create([
                    'restaurant_id' => $restaurantId,
                    'name' => $this->name,
                    'sku' => $this->sku ?: null,
                    'unit' => $this->unit,
                    'current_stock' => $this->currentStock,
                    'minimum_stock' => $this->minimumStock,
                    'cost_per_unit' => $this->costPerUnit,
                    'is_active' => $this->isActive,
                    'notes' => $this->notes ?: null,
                ]);

                if ((float) $this->currentStock > 0) {
                    StockTransaction::create([
                        'restaurant_id' => $restaurantId,
                        'inventory_item_id' => $item->id,
                        'type' => 'in',
                        'quantity' => $this->currentStock,
                        'stock_before' => 0,
                        'stock_after' => $this->currentStock,
                        'reference' => 'OPENING-STOCK',
                        'notes' => 'Opening stock',
                    ]);
                }
            }
        });

        session()->flash(
            'success',
            $this->editingId
                ? 'Inventory item updated.'
                : 'Inventory item created.'
        );

        $this->closeModal();
    }

    public function openTransaction(int $id): void
    {
        $restaurantId = Auth::user()->restaurant_id;

        InventoryItem::where(
            'restaurant_id',
            $restaurantId
        )->findOrFail($id);

        $this->transactionItemId = $id;
        $this->transactionType = 'in';
        $this->transactionQuantity = '';
        $this->transactionReference = '';
        $this->transactionNotes = '';

        $this->showTransactionModal = true;
    }

    public function closeTransaction(): void
    {
        $this->showTransactionModal = false;
        $this->transactionItemId = null;

        $this->reset([
            'transactionQuantity',
            'transactionReference',
            'transactionNotes',
        ]);
    }

    public function saveTransaction(): void
    {
        $restaurantId = Auth::user()->restaurant_id;

        $this->validate([
            'transactionType' => [
                'required',
                'in:in,out,adjustment,wastage',
            ],
            'transactionQuantity' => [
                'required',
                'numeric',
                'min:0.001',
            ],
            'transactionReference' => [
                'nullable',
                'string',
                'max:255',
            ],
            'transactionNotes' => [
                'nullable',
                'string',
            ],
        ]);

        DB::transaction(function () use ($restaurantId) {

            $item = InventoryItem::where(
                'restaurant_id',
                $restaurantId
            )
                ->lockForUpdate()
                ->findOrFail($this->transactionItemId);

            $before = (float) $item->current_stock;
            $quantity = (float) $this->transactionQuantity;

            if (in_array(
                $this->transactionType,
                ['out', 'wastage']
            )) {
                if ($quantity > $before) {
                    $this->addError(
                        'transactionQuantity',
                        'Not enough stock available.'
                    );

                    return;
                }

                $after = $before - $quantity;

            } elseif ($this->transactionType === 'in') {

                $after = $before + $quantity;

            } else {

                $after = $quantity;
            }

            $item->update([
                'current_stock' => $after,
            ]);

            StockTransaction::create([
                'restaurant_id' => $restaurantId,
                'inventory_item_id' => $item->id,
                'type' => $this->transactionType,
                'quantity' => $quantity,
                'stock_before' => $before,
                'stock_after' => $after,
                'reference' => $this->transactionReference ?: null,
                'notes' => $this->transactionNotes ?: null,
            ]);
        });

        if ($this->getErrorBag()->has('transactionQuantity')) {
            return;
        }

        session()->flash(
            'success',
            'Stock transaction recorded.'
        );

        $this->closeTransaction();
    }

    public function delete(int $id): void
    {
        $restaurantId = Auth::user()->restaurant_id;

        $item = InventoryItem::where(
            'restaurant_id',
            $restaurantId
        )->findOrFail($id);

        if ($item->recipes()->exists()) {
            session()->flash(
                'error',
                'Remove this ingredient from recipes first.'
            );

            return;
        }

        $item->delete();

        session()->flash(
            'success',
            'Inventory item deleted.'
        );
    }

    public function render()
    {
        $restaurantId = Auth::user()->restaurant_id;

        $items = InventoryItem::where(
            'restaurant_id',
            $restaurantId
        )
            ->when(
                $this->search,
                function ($query) {
                    $search = '%'.$this->search.'%';

                    $query->where(function ($q) use ($search) {
                        $q->where('name', 'like', $search)
                            ->orWhere('sku', 'like', $search);
                    });
                }
            )
            ->when(
                $this->filter === 'low',
                function ($query) {
                    $query->whereColumn(
                        'current_stock',
                        '<=',
                        'minimum_stock'
                    );
                }
            )
            ->when(
                $this->filter === 'active',
                fn ($query) => $query->where('is_active', true)
            )
            ->latest()
            ->paginate(10);

        return $this->view([
            'items' => $items,
        ])->layout('layouts.app');
    }
};
