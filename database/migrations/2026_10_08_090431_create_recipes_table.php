<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('recipes', function (Blueprint $table) {
            $table->id();

            $table->foreignId('restaurant_id')
                ->constrained('restaurants')
                ->cascadeOnDelete();

            $table->foreignId('menu_item_id')
                ->constrained('menu_items')
                ->cascadeOnDelete();

            $table->foreignId('inventory_item_id')
                ->constrained('inventory_items')
                ->cascadeOnDelete();

            $table->decimal('quantity', 12, 3);

            $table->text('notes')->nullable();

            $table->timestamps();

            $table->unique([
                'menu_item_id',
                'inventory_item_id',
            ]);

            $table->index('restaurant_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('recipes');
    }
};
