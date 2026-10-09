<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kot_items', function (Blueprint $table) {
            $table->id();

            $table->foreignId('kot_id')
                ->constrained('kots')
                ->cascadeOnDelete();

            $table->foreignId('menu_item_id')
                ->constrained('menu_items')
                ->restrictOnDelete();

            $table->string('item_name');

            $table->unsignedInteger('quantity');

            $table->text('notes')->nullable();

            $table->enum('status', [
                'new',
                'preparing',
                'ready',
                'served',
                'cancelled',
            ])->default('new');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kot_items');
    }
};
