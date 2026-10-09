<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('stock_transactions', function (Blueprint $table) {
            $table->id();

            $table->foreignId('restaurant_id')
                ->constrained('restaurants')
                ->cascadeOnDelete();

            $table->foreignId('inventory_item_id')
                ->constrained('inventory_items')
                ->cascadeOnDelete();

            $table->enum('type', [
                'in',
                'out',
                'adjustment',
                'wastage',
            ]);

            $table->decimal('quantity', 12, 3);

            $table->decimal('stock_before', 12, 3);

            $table->decimal('stock_after', 12, 3);

            $table->string('reference')->nullable();

            $table->text('notes')->nullable();

            $table->timestamps();

            $table->index([
                'restaurant_id',
                'inventory_item_id',
            ]);

            $table->index([
                'restaurant_id',
                'type',
            ]);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('stock_transactions');
    }
};
