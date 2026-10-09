<?php

// namespace App\Livewire;

use App\Models\Branch;
use App\Models\Category;
use App\Models\InventoryItem;
use App\Models\Kot;
use App\Models\KotItem;
use App\Models\MenuItem;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Recipe;
use App\Models\RestaurantTable;
use App\Models\StockTransaction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

return new class extends Component
{
    /*
    |--------------------------------------------------------------------------
    | POS State
    |--------------------------------------------------------------------------
    */

    public $branchId = null;

    public $tableId = null;

    public $categoryId = null;

    public string $orderType = 'dine_in';

    public string $search = '';

    public $discount = 0;

    public $tax = 0;

    public string $notes = '';

    /*
    |--------------------------------------------------------------------------
    | Cart
    |--------------------------------------------------------------------------
    |
    | Cart structure:
    |
    | [
    |     1 => [
    |         'id' => 1,
    |         'name' => 'Paneer Tikka',
    |         'price' => 150,
    |         'quantity' => 2,
    |         'notes' => '',
    |     ],
    | ]
    |
    */

    public array $cart = [];

    /*
    |--------------------------------------------------------------------------
    | Mount
    |--------------------------------------------------------------------------
    */

    public function mount(): void
    {
        $restaurantId = Auth::user()->restaurant_id;

        if (! $restaurantId) {
            abort(403, 'Restaurant is not configured.');
        }

        $branch = Branch::where('restaurant_id', $restaurantId)
            ->where('is_active', true)
            ->orderBy('id')
            ->first();

        if ($branch) {
            $this->branchId = $branch->id;
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Branch Changed
    |--------------------------------------------------------------------------
    */

    public function updatedBranchId(): void
    {
        $this->tableId = null;
    }

    /*
    |--------------------------------------------------------------------------
    | Order Type Changed
    |--------------------------------------------------------------------------
    */

    public function updatedOrderType(): void
    {
        if ($this->orderType === 'takeaway') {
            $this->tableId = null;
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Add Item To Cart
    |--------------------------------------------------------------------------
    */

    public function addToCart(int $menuItemId): void
    {
        $restaurantId = Auth::user()->restaurant_id;

        $menuItem = MenuItem::where('restaurant_id', $restaurantId)
            ->where('is_available', true)
            ->findOrFail($menuItemId);

        if (isset($this->cart[$menuItem->id])) {

            $this->cart[$menuItem->id]['quantity']++;

        } else {

            $this->cart[$menuItem->id] = [
                'id' => $menuItem->id,
                'name' => $menuItem->name,
                'price' => (float) $menuItem->price,
                'quantity' => 1,
                'notes' => '',
            ];
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Increase Quantity
    |--------------------------------------------------------------------------
    */

    public function increaseQuantity(int $menuItemId): void
    {
        if (! isset($this->cart[$menuItemId])) {
            return;
        }

        $this->cart[$menuItemId]['quantity']++;
    }

    /*
    |--------------------------------------------------------------------------
    | Decrease Quantity
    |--------------------------------------------------------------------------
    */

    public function decreaseQuantity(int $menuItemId): void
    {
        if (! isset($this->cart[$menuItemId])) {
            return;
        }

        if ($this->cart[$menuItemId]['quantity'] > 1) {

            $this->cart[$menuItemId]['quantity']--;

        } else {

            unset($this->cart[$menuItemId]);
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Remove Item
    |--------------------------------------------------------------------------
    */

    public function removeFromCart(int $menuItemId): void
    {
        unset($this->cart[$menuItemId]);
    }

    /*
    |--------------------------------------------------------------------------
    | Clear Cart
    |--------------------------------------------------------------------------
    */

    public function clearCart(): void
    {
        $this->cart = [];
    }

    /*
    |--------------------------------------------------------------------------
    | Update Item Notes
    |--------------------------------------------------------------------------
    */

    public function updateItemNotes(int $menuItemId, string $notes): void
    {
        if (! isset($this->cart[$menuItemId])) {
            return;
        }

        $this->cart[$menuItemId]['notes'] = $notes;
    }

    /*
    |--------------------------------------------------------------------------
    | Computed: Subtotal
    |--------------------------------------------------------------------------
    */

    public function getSubtotalProperty(): float
    {
        return collect($this->cart)
            ->sum(function ($item) {
                return (float) $item['price'] * (int) $item['quantity'];
            });
    }

    /*
    |--------------------------------------------------------------------------
    | Computed: Grand Total
    |--------------------------------------------------------------------------
    */

    public function getGrandTotalProperty(): float
    {
        $subtotal = $this->subtotal;

        $discount = max(0, (float) $this->discount);

        $tax = max(0, (float) $this->tax);

        return max(
            0,
            $subtotal - $discount + $tax
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Place Order
    |--------------------------------------------------------------------------
    */

    public function placeOrder()
    {
        $restaurantId = Auth::user()->restaurant_id;

        if (! $restaurantId) {
            abort(403, 'Restaurant is not configured.');
        }

        /*
        |--------------------------------------------------------------------------
        | Basic Validation
        |--------------------------------------------------------------------------
        */

        $this->validate([
            'branchId' => [
                'required',
                'integer',
            ],

            'orderType' => [
                'required',
                'in:dine_in,takeaway',
            ],

            'tableId' => [
                'nullable',
                'integer',
            ],

            'discount' => [
                'nullable',
                'numeric',
                'min:0',
            ],

            'tax' => [
                'nullable',
                'numeric',
                'min:0',
            ],

            'notes' => [
                'nullable',
                'string',
                'max:2000',
            ],
        ]);

        /*
        |--------------------------------------------------------------------------
        | Cart Check
        |--------------------------------------------------------------------------
        */

        if (empty($this->cart)) {

            $this->addError(
                'cart',
                'Please add at least one item to the cart.'
            );

            return;
        }

        /*
        |--------------------------------------------------------------------------
        | Branch Check
        |--------------------------------------------------------------------------
        */

        $branch = Branch::where('restaurant_id', $restaurantId)
            ->where('id', $this->branchId)
            ->where('is_active', true)
            ->firstOrFail();

        /*
        |--------------------------------------------------------------------------
        | Table Check
        |--------------------------------------------------------------------------
        */

        $table = null;

        if ($this->orderType === 'dine_in') {

            if (! $this->tableId) {

                $this->addError(
                    'tableId',
                    'Please select a table for dine-in orders.'
                );

                return;
            }

            $table = RestaurantTable::where(
                'branch_id',
                $branch->id
            )
                ->where('id', $this->tableId)
                ->where('is_active', true)
                ->firstOrFail();

            /*
            |--------------------------------------------------------------------------
            | Prevent Ordering On Occupied/Maintenance Table
            |--------------------------------------------------------------------------
            */

            if (in_array($table->status, ['occupied', 'maintenance'])) {

                $this->addError(
                    'tableId',
                    'This table is currently not available.'
                );

                return;
            }
        }

        /*
        |--------------------------------------------------------------------------
        | Recalculate Totals On Server
        |--------------------------------------------------------------------------
        */

        $menuItemIds = collect($this->cart)
            ->pluck('id')
            ->map(fn ($id) => (int) $id)
            ->values()
            ->all();

        $menuItems = MenuItem::where(
            'restaurant_id',
            $restaurantId
        )
            ->where('is_available', true)
            ->whereIn('id', $menuItemIds)
            ->get()
            ->keyBy('id');

        /*
        |--------------------------------------------------------------------------
        | Verify Every Cart Item
        |--------------------------------------------------------------------------
        */

        foreach ($this->cart as $cartItem) {

            $menuItemId = (int) ($cartItem['id'] ?? 0);

            if (! $menuItemId || ! $menuItems->has($menuItemId)) {

                $this->addError(
                    'cart',
                    'One or more selected menu items are no longer available.'
                );

                return;
            }

            $quantity = (int) ($cartItem['quantity'] ?? 0);

            if ($quantity < 1) {

                $this->addError(
                    'cart',
                    'Invalid item quantity.'
                );

                return;
            }
        }

        /*
        |--------------------------------------------------------------------------
        | Calculate Subtotal
        |--------------------------------------------------------------------------
        */

        $subtotal = 0;

        foreach ($this->cart as $cartItem) {

            $menuItemId = (int) $cartItem['id'];

            $quantity = (int) $cartItem['quantity'];

            $menuItem = $menuItems->get($menuItemId);

            $subtotal +=
                (float) $menuItem->price * $quantity;
        }

        $discount = max(
            0,
            (float) ($this->discount ?? 0)
        );

        $tax = max(
            0,
            (float) ($this->tax ?? 0)
        );

        /*
        |--------------------------------------------------------------------------
        | Prevent Discount Greater Than Subtotal
        |--------------------------------------------------------------------------
        */

        if ($discount > $subtotal) {
            $discount = $subtotal;
        }

        $grandTotal =
            max(
                0,
                $subtotal - $discount + $tax
            );

        /*
        |--------------------------------------------------------------------------
        | Database Transaction
        |--------------------------------------------------------------------------
        */

        try {

            $order = DB::transaction(function () use (
                $restaurantId,
                $branch,
                $table,
                $subtotal,
                $discount,
                $tax,
                $grandTotal,
                $menuItems
            ) {

                /*
                |--------------------------------------------------------------------------
                | Generate Order Number
                |--------------------------------------------------------------------------
                */

                $orderNumber =
                    $this->generateOrderNumber(
                        $restaurantId
                    );

                /*
                |--------------------------------------------------------------------------
                | Create Order
                |--------------------------------------------------------------------------
                */

                $order = Order::create([

                    'restaurant_id' => $restaurantId,

                    'branch_id' => $branch->id,

                    'table_id' => $table?->id,

                    'order_number' => $orderNumber,

                    'order_type' => $this->orderType,

                    'status' => 'pending',

                    'subtotal' => $subtotal,

                    'discount' => $discount,

                    'tax' => $tax,

                    'grand_total' => $grandTotal,

                    'notes' => $this->notes ?: null,
                ]);

                /*
                |--------------------------------------------------------------------------
                | Create Order Items
                |--------------------------------------------------------------------------
                */

                foreach ($this->cart as $cartItem) {

                    $menuItemId =
                        (int) $cartItem['id'];

                    $quantity =
                        (int) $cartItem['quantity'];

                    $menuItem =
                        $menuItems->get($menuItemId);

                    OrderItem::create([

                        'order_id' => $order->id,

                        'menu_item_id' => $menuItem->id,

                        'item_name' => $menuItem->name,

                        'unit_price' => $menuItem->price,

                        'quantity' => $quantity,

                        'total' => (float) $menuItem->price
                            * $quantity,

                        'notes' => $cartItem['notes'] ?? null,
                    ]);
                }

                /*
                |--------------------------------------------------------------------------
                | AUTOMATIC INVENTORY DEDUCTION
                |--------------------------------------------------------------------------
                |
                | Example:
                |
                | Paneer Tikka recipe:
                | Paneer = 0.200 kg
                |
                | Order:
                | Paneer Tikka x 4
                |
                | Stock deduction:
                | 0.200 × 4 = 0.800 kg
                |
                */

                foreach ($this->cart as $cartItem) {

                    /*
                    |--------------------------------------------------------------------------
                    | IMPORTANT
                    |--------------------------------------------------------------------------
                    | Cart uses "id", NOT "menu_item_id".
                    */

                    $menuItemId =
                        (int) $cartItem['id'];

                    $orderedQuantity =
                        (int) $cartItem['quantity'];

                    /*
                    |--------------------------------------------------------------------------
                    | Find Recipe
                    |--------------------------------------------------------------------------
                    */

                    $recipes = Recipe::where(
                        'restaurant_id',
                        $restaurantId
                    )
                        ->where(
                            'menu_item_id',
                            $menuItemId
                        )
                        ->get();

                    /*
                    |--------------------------------------------------------------------------
                    | Deduct Every Ingredient
                    |--------------------------------------------------------------------------
                    */

                    foreach ($recipes as $recipe) {

                        $requiredQuantity =
                            (float) $recipe->quantity
                            * $orderedQuantity;

                        /*
                        |--------------------------------------------------------------------------
                        | Lock Inventory Row
                        |--------------------------------------------------------------------------
                        */

                        $inventoryItem =
                            InventoryItem::where(
                                'restaurant_id',
                                $restaurantId
                            )
                                ->where(
                                    'id',
                                    $recipe->inventory_item_id
                                )
                                ->lockForUpdate()
                                ->first();

                        if (! $inventoryItem) {

                            throw new \RuntimeException(
                                'Inventory item not found.'
                            );
                        }

                        /*
                        |--------------------------------------------------------------------------
                        | Current Stock
                        |--------------------------------------------------------------------------
                        */

                        $before =
                            (float) $inventoryItem->current_stock;

                        /*
                        |--------------------------------------------------------------------------
                        | Check Stock
                        |--------------------------------------------------------------------------
                        */

                        if (
                            $before <
                            $requiredQuantity
                        ) {

                            throw new \RuntimeException(
                                "Insufficient stock for {$inventoryItem->name}. ".
                                "Required: {$requiredQuantity} {$inventoryItem->unit}, ".
                                "Available: {$before} {$inventoryItem->unit}."
                            );
                        }

                        /*
                        |--------------------------------------------------------------------------
                        | New Stock
                        |--------------------------------------------------------------------------
                        */

                        $after =
                            $before -
                            $requiredQuantity;

                        /*
                        |--------------------------------------------------------------------------
                        | Update Inventory
                        |--------------------------------------------------------------------------
                        */

                        $inventoryItem->update([

                            'current_stock' => $after,

                        ]);

                        /*
                        |--------------------------------------------------------------------------
                        | Create Stock Transaction
                        |--------------------------------------------------------------------------
                        */

                        StockTransaction::create([

                            'restaurant_id' => $restaurantId,

                            'inventory_item_id' => $inventoryItem->id,

                            'type' => 'out',

                            'quantity' => $requiredQuantity,

                            'stock_before' => $before,

                            'stock_after' => $after,

                            'reference' => $order->order_number,

                            'notes' => 'Automatic deduction from POS order.',
                        ]);
                    }
                }

                /*
                |--------------------------------------------------------------------------
                | Create KOT
                |--------------------------------------------------------------------------
                */

                $kotNumber =
                    $this->generateKotNumber(
                        $restaurantId
                    );

                $kot = Kot::create([

                    'restaurant_id' => $restaurantId,

                    'order_id' => $order->id,

                    'branch_id' => $branch->id,

                    'table_id' => $table?->id,

                    'kot_number' => $kotNumber,

                    'status' => 'new',

                    'notes' => $this->notes ?: null,
                ]);

                /*
                |--------------------------------------------------------------------------
                | Create KOT Items
                |--------------------------------------------------------------------------
                */

                foreach ($this->cart as $cartItem) {

                    $menuItemId =
                        (int) $cartItem['id'];

                    $quantity =
                        (int) $cartItem['quantity'];

                    $menuItem =
                        $menuItems->get($menuItemId);

                    KotItem::create([

                        'kot_id' => $kot->id,

                        'menu_item_id' => $menuItem->id,

                        'item_name' => $menuItem->name,

                        'quantity' => $quantity,

                        'notes' => $cartItem['notes'] ?? null,

                        'status' => 'new',
                    ]);
                }

                /*
                |--------------------------------------------------------------------------
                | Mark Table Occupied
                |--------------------------------------------------------------------------
                */

                if ($table) {

                    $table->update([

                        'status' => 'occupied',

                    ]);
                }

                return $order;
            });

            /*
            |--------------------------------------------------------------------------
            | Success
            |--------------------------------------------------------------------------
            */

            session()->flash(
                'success',
                "Order {$order->order_number} placed successfully. KOT sent to kitchen."
            );

            /*
            |--------------------------------------------------------------------------
            | Reset POS
            |--------------------------------------------------------------------------
            */

            $this->cart = [];

            $this->discount = 0;

            $this->tax = 0;

            $this->notes = '';

            $this->tableId = null;

            /*
            |--------------------------------------------------------------------------
            | Go To Orders
            |--------------------------------------------------------------------------
            */

            return $this->redirect(
                route('orders'),
                navigate: true
            );

        } catch (\Throwable $e) {

            /*
            |--------------------------------------------------------------------------
            | Show Error
            |--------------------------------------------------------------------------
            */

            $this->addError(
                'cart',
                $e->getMessage()
            );

            return;
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Generate Order Number
    |--------------------------------------------------------------------------
    */

    private function generateOrderNumber(
        int $restaurantId
    ): string {

        $lastOrder =
            Order::where(
                'restaurant_id',
                $restaurantId
            )
                ->latest('id')
                ->first();

        $nextNumber =
            $lastOrder
                ? $lastOrder->id + 1
                : 1;

        return 'ORD-'.
            str_pad(
                $nextNumber,
                6,
                '0',
                STR_PAD_LEFT
            );
    }

    /*
    |--------------------------------------------------------------------------
    | Generate KOT Number
    |--------------------------------------------------------------------------
    */

    private function generateKotNumber(
        int $restaurantId
    ): string {

        $lastKot =
            Kot::where(
                'restaurant_id',
                $restaurantId
            )
                ->latest('id')
                ->first();

        $nextNumber =
            $lastKot
                ? $lastKot->id + 1
                : 1;

        return 'KOT-'.
            str_pad(
                $nextNumber,
                6,
                '0',
                STR_PAD_LEFT
            );
    }

    /*
    |--------------------------------------------------------------------------
    | Render
    |--------------------------------------------------------------------------
    */

    public function render()
    {
        $restaurantId =
            Auth::user()->restaurant_id;

        /*
        |--------------------------------------------------------------------------
        | Branches
        |--------------------------------------------------------------------------
        */

        $branches =
            Branch::where(
                'restaurant_id',
                $restaurantId
            )
                ->where(
                    'is_active',
                    true
                )
                ->orderBy('name')
                ->get();

        /*
        |--------------------------------------------------------------------------
        | Categories
        |--------------------------------------------------------------------------
        */

        $categories =
            Category::where(
                'restaurant_id',
                $restaurantId
            )
                ->where(
                    'is_active',
                    true
                )
                ->orderBy('sort_order')
                ->orderBy('name')
                ->get();

        /*
        |--------------------------------------------------------------------------
        | Menu Items
        |--------------------------------------------------------------------------
        */

        $menuItemsQuery =
            MenuItem::with('category')
                ->where(
                    'restaurant_id',
                    $restaurantId
                )
                ->where(
                    'is_available',
                    true
                );

        /*
        |--------------------------------------------------------------------------
        | Search
        |--------------------------------------------------------------------------
        */

        if (
            trim($this->search) !== ''
        ) {

            $search =
                '%'.
                trim($this->search).
                '%';

            $menuItemsQuery->where(
                function ($query) use ($search) {

                    $query
                        ->where(
                            'name',
                            'like',
                            $search
                        )
                        ->orWhere(
                            'code',
                            'like',
                            $search
                        );
                }
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Category Filter
        |--------------------------------------------------------------------------
        */

        if ($this->categoryId) {

            $menuItemsQuery->where(
                'category_id',
                $this->categoryId
            );
        }

        $menuItems =
            $menuItemsQuery
                ->orderBy('sort_order')
                ->orderBy('name')
                ->get();

        /*
        |--------------------------------------------------------------------------
        | Tables
        |--------------------------------------------------------------------------
        */

        $tables = collect();

        if ($this->branchId) {

            $tables =
                RestaurantTable::where(
                    'branch_id',
                    $this->branchId
                )
                    ->where(
                        'is_active',
                        true
                    )
                    ->whereNotIn(
                        'status',
                        [
                            'occupied',
                            'maintenance',
                        ]
                    )
                    ->with('floor')
                    ->orderBy('floor_id')
                    ->orderBy('name')
                    ->get();
        }

        return view(
            'components.⚡pos.pos',
            [
                'branches' => $branches,

                'categories' => $categories,

                'menuItems' => $menuItems,

                'tables' => $tables,
            ]
        );
    }
};