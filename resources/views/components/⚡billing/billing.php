<?php

use App\Models\Bill;
use App\Models\Order;
use App\Models\Payment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

new class extends Component
{
    use WithPagination;

    public string $search = '';

    public string $statusFilter = 'unpaid';

    public string $method = 'cash';

    public string $paymentAmount = '';

    public string $reference = '';

    public string $paymentNotes = '';

    public ?int $selectedBillId = null;

    public bool $showPaymentModal = false;

    public bool $showBillModal = false;

    public ?Bill $selectedBill = null;

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function updatingStatusFilter(): void
    {
        $this->resetPage();
    }

    public function openPayment(int $billId): void
    {
        $restaurantId = Auth::user()->restaurant_id;

        $bill = Bill::with([
            'order.items',
            'order.branch',
            'order.table',
            'payments',
        ])
            ->where('restaurant_id', $restaurantId)
            ->findOrFail($billId);

        if ($bill->payment_status === 'paid') {
            return;
        }

        $this->selectedBillId = $bill->id;
        $this->selectedBill = $bill;

        $this->paymentAmount = number_format(
            $bill->remaining_amount,
            2,
            '.',
            ''
        );

        $this->method = 'cash';
        $this->reference = '';
        $this->paymentNotes = '';

        $this->showPaymentModal = true;
    }

    public function closePayment(): void
    {
        $this->showPaymentModal = false;

        $this->selectedBillId = null;
        $this->selectedBill = null;

        $this->reset([
            'paymentAmount',
            'reference',
            'paymentNotes',
        ]);
    }

    public function openBill(int $billId): void
    {
        $restaurantId = Auth::user()->restaurant_id;

        $this->selectedBill = Bill::with([
            'order.items.menuItem',
            'order.branch',
            'order.table',
            'payments',
        ])
            ->where('restaurant_id', $restaurantId)
            ->findOrFail($billId);

        $this->showBillModal = true;
    }

    public function closeBill(): void
    {
        $this->showBillModal = false;
        $this->selectedBill = null;
    }

    public function makePayment(): void
    {
        $restaurantId = Auth::user()->restaurant_id;

        $this->validate([
            'method' => [
                'required',
                'in:cash,upi,card,other',
            ],
            'paymentAmount' => [
                'required',
                'numeric',
                'min:0.01',
            ],
            'reference' => [
                'nullable',
                'string',
                'max:255',
            ],
            'paymentNotes' => [
                'nullable',
                'string',
                'max:1000',
            ],
        ]);

        DB::transaction(function () use ($restaurantId) {
            $bill = Bill::where('restaurant_id', $restaurantId)
                ->lockForUpdate()
                ->findOrFail($this->selectedBillId);

            $alreadyPaid = (float) $bill->payments()->sum('amount');

            $remaining = max(
                0,
                (float) $bill->grand_total - $alreadyPaid
            );

            $amount = round(
                (float) $this->paymentAmount,
                2
            );

            if ($amount > $remaining) {
                $this->addError(
                    'paymentAmount',
                    'Payment amount cannot be greater than remaining amount.'
                );

                return;
            }

            Payment::create([
                'restaurant_id' => $restaurantId,
                'bill_id' => $bill->id,
                'method' => $this->method,
                'amount' => $amount,
                'reference' => $this->reference ?: null,
                'notes' => $this->paymentNotes ?: null,
            ]);

            $totalPaid = $alreadyPaid + $amount;

            if ($totalPaid >= (float) $bill->grand_total) {
                $bill->update([
                    'payment_status' => 'paid',
                ]);

                $bill->order()->update([
                    'status' => 'completed',
                ]);
            } else {
                $bill->update([
                    'payment_status' => 'partial',
                ]);
            }
        });

        if ($this->getErrorBag()->has('paymentAmount')) {
            return;
        }

        session()->flash(
            'success',
            'Payment recorded successfully.'
        );

        $this->closePayment();
    }

    private function generateBillNumber(int $restaurantId): string
    {
        $lastBill = Bill::where(
            'restaurant_id',
            $restaurantId
        )
            ->latest('id')
            ->first();

        $nextNumber = $lastBill
            ? $lastBill->id + 1
            : 1;

        return 'BILL-'.str_pad(
            $nextNumber,
            6,
            '0',
            STR_PAD_LEFT
        );
    }

    private function createBillForOrder(
        Order $order,
        int $restaurantId
    ): Bill {
        $existingBill = Bill::where(
            'restaurant_id',
            $restaurantId
        )
            ->where('order_id', $order->id)
            ->first();

        if ($existingBill) {
            return $existingBill;
        }

        return Bill::create([
            'restaurant_id' => $restaurantId,
            'order_id' => $order->id,
            'bill_number' => $this->generateBillNumber(
                $restaurantId
            ),
            'subtotal' => $order->subtotal,
            'discount' => $order->discount,
            'tax' => $order->tax,
            'grand_total' => $order->grand_total,
            'payment_status' => 'unpaid',
        ]);
    }

    public function createBill(int $orderId): void
    {
        $restaurantId = Auth::user()->restaurant_id;

        $order = Order::where(
            'restaurant_id',
            $restaurantId
        )->findOrFail($orderId);

        $this->createBillForOrder(
            $order,
            $restaurantId
        );

        session()->flash(
            'success',
            'Bill created successfully.'
        );
    }

    public function render()
    {
        $restaurantId = Auth::user()->restaurant_id;

        if (! $restaurantId) {
            return $this->view()
                ->layout('layouts.app');
        }

        /*
        |--------------------------------------------------------------------------
        | Automatically create bills for served/completed orders
        |--------------------------------------------------------------------------
        */

        $ordersWithoutBills = Order::where(
            'restaurant_id',
            $restaurantId
        )
            ->whereIn('status', [
                'served',
                'completed',
            ])
            ->whereDoesntHave('bill')
            ->get();

        foreach ($ordersWithoutBills as $order) {
            $this->createBillForOrder(
                $order,
                $restaurantId
            );
        }

        $bills = Bill::with([
            'order.branch',
            'order.table',
            'payments',
        ])
            ->where(
                'restaurant_id',
                $restaurantId
            )
            ->when(
                $this->search,
                function ($query) {
                    $search = '%'.$this->search.'%';

                    $query->where(function ($q) use ($search) {
                        $q->where(
                            'bill_number',
                            'like',
                            $search
                        )
                            ->orWhereHas(
                                'order',
                                function ($orderQuery) use ($search) {
                                    $orderQuery
                                        ->where(
                                            'order_number',
                                            'like',
                                            $search
                                        );
                                }
                            );
                    });
                }
            )
            ->when(
                $this->statusFilter !== 'all',
                function ($query) {
                    $query->where(
                        'payment_status',
                        $this->statusFilter
                    );
                }
            )
            ->latest()
            ->paginate(10);

        return $this->view([
            'bills' => $bills,
        ])->layout('layouts.app');
    }
};
