<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('inventory_items', function (Blueprint $table) {
            $table->id();

            $table->foreignId('restaurant_id')
                ->constrained('restaurants')
                ->cascadeOnDelete();

            $table->string('name');

            $table->string('sku')->nullable();

            $table->string('unit');

            $table->decimal('current_stock', 12, 3)->default(0);

            $table->decimal('minimum_stock', 12, 3)->default(0);

            $table->decimal('cost_per_unit', 12, 2)->default(0);

            $table->boolean('is_active')->default(true);

            $table->text('notes')->nullable();

            $table->timestamps();

            $table->unique(['restaurant_id', 'name']);
            $table->unique(['restaurant_id', 'sku']);

            $table->index([
                'restaurant_id',
                'is_active',
            ]);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inventory_items');
    }
};
