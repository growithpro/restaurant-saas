<?php

use App\Models\Branch;
use App\Models\Floor;
use App\Models\RestaurantTable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Livewire\Component;

new class extends Component
{
    public ?int $selectedBranchId = null;

    public ?int $editingFloorId = null;

    public ?int $editingTableId = null;

    public bool $showFloorForm = false;

    public bool $showTableForm = false;

    /*
    |--------------------------------------------------------------------------
    | Floor Fields
    |--------------------------------------------------------------------------
    */

    public string $floorName = '';

    public int $floorSortOrder = 0;

    public bool $floorIsActive = true;

    /*
    |--------------------------------------------------------------------------
    | Table Fields
    |--------------------------------------------------------------------------
    */

    public string $tableName = '';

    public string $tableCode = '';

    public int $capacity = 2;

    public string $status = 'available';

    public bool $tableIsActive = true;

    public string $notes = '';

    public function mount(): void
    {
        $user = Auth::user();

        if (! $user->restaurant_id) {
            redirect()->route('restaurant.setup');

            return;
        }

        $firstBranch = Branch::where(
            'restaurant_id',
            $user->restaurant_id
        )
            ->orderBy('name')
            ->first();

        if ($firstBranch) {
            $this->selectedBranchId = $firstBranch->id;
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Branch
    |--------------------------------------------------------------------------
    */

    public function selectBranch(int $branchId): void
    {
        $branch = $this->getRestaurantBranches()
            ->firstWhere('id', $branchId);

        if (! $branch) {
            abort(404);
        }

        $this->selectedBranchId = $branchId;

        $this->closeForms();
    }

    /*
    |--------------------------------------------------------------------------
    | Floor CRUD
    |--------------------------------------------------------------------------
    */

    public function openCreateFloor(): void
    {
        $this->resetFloorForm();

        $this->showFloorForm = true;
    }

    public function editFloor(int $id): void
    {
        $branchId = $this->getSelectedBranchId();

        $floor = Floor::where('branch_id', $branchId)
            ->findOrFail($id);

        $this->editingFloorId = $floor->id;

        $this->floorName = $floor->name;

        $this->floorSortOrder = $floor->sort_order;

        $this->floorIsActive = $floor->is_active;

        $this->showFloorForm = true;

        $this->showTableForm = false;
    }

    public function saveFloor(): void
    {
        $branchId = $this->getSelectedBranchId();

        $this->validate([
            'floorName' => [
                'required',
                'string',
                'max:255',

                Rule::unique('floors', 'name')
                    ->where(
                        fn ($query) => $query->where(
                            'branch_id',
                            $branchId
                        )
                    )
                    ->ignore($this->editingFloorId),
            ],

            'floorSortOrder' => [
                'integer',
                'min:0',
                'max:999',
            ],

            'floorIsActive' => [
                'boolean',
            ],
        ]);

        $data = [
            'name' => trim($this->floorName),
            'sort_order' => $this->floorSortOrder,
            'is_active' => $this->floorIsActive,
        ];

        if ($this->editingFloorId) {

            $floor = Floor::where(
                'branch_id',
                $branchId
            )->findOrFail($this->editingFloorId);

            $floor->update($data);

            session()->flash(
                'success',
                'Floor updated successfully.'
            );

        } else {

            Floor::create([
                'branch_id' => $branchId,
                ...$data,
            ]);

            session()->flash(
                'success',
                'Floor created successfully.'
            );
        }

        $this->resetFloorForm();
    }

    public function deleteFloor(int $id): void
    {
        $branchId = $this->getSelectedBranchId();

        $floor = Floor::where(
            'branch_id',
            $branchId
        )->findOrFail($id);

        if ($floor->tables()->exists()) {

            session()->flash(
                'error',
                'This floor cannot be deleted because it has tables. Remove its tables first.'
            );

            return;
        }

        $floor->delete();

        session()->flash(
            'success',
            'Floor deleted successfully.'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Table CRUD
    |--------------------------------------------------------------------------
    */

    public function openCreateTable(): void
    {
        $this->resetTableForm();

        $this->showTableForm = true;
    }

    public function editTable(int $id): void
    {
        $branchId = $this->getSelectedBranchId();

        $table = RestaurantTable::where(
            'branch_id',
            $branchId
        )->findOrFail($id);

        $this->editingTableId = $table->id;

        $this->tableName = $table->name;

        $this->tableCode = $table->code;

        $this->capacity = $table->capacity;

        $this->status = $table->status;

        $this->tableIsActive = $table->is_active;

        $this->notes = $table->notes ?? '';

        $this->selectedFloorForTable = $table->floor_id;

        $this->showTableForm = true;

        $this->showFloorForm = false;
    }

    public ?int $selectedFloorForTable = null;

    public function saveTable(): void
    {
        $branchId = $this->getSelectedBranchId();

        $this->validate([
            'selectedFloorForTable' => [
                'required',
                'integer',

                Rule::exists('floors', 'id')
                    ->where(
                        fn ($query) => $query->where(
                            'branch_id',
                            $branchId
                        )
                    ),
            ],

            'tableName' => [
                'required',
                'string',
                'max:255',
            ],

            'tableCode' => [
                'required',
                'string',
                'max:50',

                Rule::unique(
                    'restaurant_tables',
                    'code'
                )
                    ->where(
                        fn ($query) => $query->where(
                            'branch_id',
                            $branchId
                        )
                    )
                    ->ignore($this->editingTableId),
            ],

            'capacity' => [
                'required',
                'integer',
                'min:1',
                'max:100',
            ],

            'status' => [
                'required',
                Rule::in([
                    'available',
                    'occupied',
                    'reserved',
                    'maintenance',
                ]),
            ],

            'tableIsActive' => [
                'boolean',
            ],

            'notes' => [
                'nullable',
                'string',
            ],
        ]);

        $data = [
            'floor_id' => $this->selectedFloorForTable,
            'name' => trim($this->tableName),
            'code' => strtoupper(trim($this->tableCode)),
            'capacity' => $this->capacity,
            'status' => $this->status,
            'is_active' => $this->tableIsActive,
            'notes' => $this->notes ?: null,
        ];

        if ($this->editingTableId) {

            $table = RestaurantTable::where(
                'branch_id',
                $branchId
            )->findOrFail($this->editingTableId);

            $table->update($data);

            session()->flash(
                'success',
                'Table updated successfully.'
            );

        } else {

            RestaurantTable::create([
                'branch_id' => $branchId,
                ...$data,
            ]);

            session()->flash(
                'success',
                'Table created successfully.'
            );
        }

        $this->resetTableForm();
    }

    public function deleteTable(int $id): void
    {
        $branchId = $this->getSelectedBranchId();

        $table = RestaurantTable::where(
            'branch_id',
            $branchId
        )->findOrFail($id);

        $table->delete();

        session()->flash(
            'success',
            'Table deleted successfully.'
        );
    }

    public function toggleTableStatus(int $id): void
    {
        $branchId = $this->getSelectedBranchId();

        $table = RestaurantTable::where(
            'branch_id',
            $branchId
        )->findOrFail($id);

        $table->update([
            'is_active' => ! $table->is_active,
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | Reset
    |--------------------------------------------------------------------------
    */

    public function cancelFloor(): void
    {
        $this->resetFloorForm();
    }

    public function cancelTable(): void
    {
        $this->resetTableForm();
    }

    private function resetFloorForm(): void
    {
        $this->reset([
            'editingFloorId',
            'floorName',
            'floorSortOrder',
        ]);

        $this->floorIsActive = true;

        $this->showFloorForm = false;

        $this->resetValidation();
    }

    private function resetTableForm(): void
    {
        $this->reset([
            'editingTableId',
            'tableName',
            'tableCode',
            'capacity',
            'notes',
            'selectedFloorForTable',
        ]);

        $this->status = 'available';

        $this->tableIsActive = true;

        $this->showTableForm = false;

        $this->resetValidation();
    }

    private function closeForms(): void
    {
        $this->resetFloorForm();

        $this->resetTableForm();
    }

    /*
    |--------------------------------------------------------------------------
    | Tenant / Branch Helpers
    |--------------------------------------------------------------------------
    */

    private function getSelectedBranchId(): int
    {
        $branch = $this->getRestaurantBranches()
            ->firstWhere(
                'id',
                $this->selectedBranchId
            );

        if (! $branch) {
            abort(404);
        }

        return $branch->id;
    }

    private function getRestaurantBranches()
    {
        return Branch::where(
            'restaurant_id',
            Auth::user()->restaurant_id
        )
            ->orderBy('name')
            ->get();
    }

    /*
    |--------------------------------------------------------------------------
    | Render
    |--------------------------------------------------------------------------
    */

    public function render()
    {
        $branchId = $this->selectedBranchId;

        $branches = $this->getRestaurantBranches();

        $floors = collect();

        $tables = collect();

        if ($branchId) {

            $floors = Floor::where(
                'branch_id',
                $branchId
            )
                ->withCount('tables')
                ->orderBy('sort_order')
                ->orderBy('name')
                ->get();

            $tables = RestaurantTable::where(
                'branch_id',
                $branchId
            )
                ->with('floor')
                ->orderBy('floor_id')
                ->orderBy('name')
                ->get();
        }

        return $this->view([
            'branches' => $branches,
            'floors' => $floors,
            'tables' => $tables,
        ])->layout('layouts.app');
    }
};
