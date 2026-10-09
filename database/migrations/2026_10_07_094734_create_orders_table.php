<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();

            $table->foreignId('restaurant_id')
                ->constrained('restaurants')
                ->cascadeOnDelete();

            $table->foreignId('branch_id')
                ->constrained('branches')
                ->cascadeOnDelete();

            $table->foreignId('table_id')
                ->nullable()
                ->constrained('restaurant_tables')
                ->nullOnDelete();

            $table->string('order_number');

            $table->enum('order_type', [
                'dine_in',
                'takeaway',
            ])->default('dine_in');

            $table->enum('status', [
                'pending',
                'preparing',
                'ready',
                'served',
                'completed',
                'cancelled',
            ])->default('pending');

            $table->decimal('subtotal', 10, 2)->default(0);
            $table->decimal('discount', 10, 2)->default(0);
            $table->decimal('tax', 10, 2)->default(0);
            $table->decimal('grand_total', 10, 2)->default(0);

            $table->text('notes')->nullable();

            $table->timestamps();

            $table->unique([
                'restaurant_id',
                'order_number',
            ]);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
