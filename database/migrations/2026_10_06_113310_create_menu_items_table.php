<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('menu_items', function (Blueprint $table) {
            $table->id();

            $table->foreignId('restaurant_id')
                ->constrained('restaurants')
                ->cascadeOnDelete();

            $table->foreignId('category_id')
                ->constrained('categories')
                ->restrictOnDelete();

            $table->string('name');

            $table->string('code');

            $table->text('description')
                ->nullable();

            $table->decimal('price', 10, 2);

            $table->string('image')
                ->nullable();

            $table->integer('sort_order')
                ->default(0);

            $table->boolean('is_available')
                ->default(true);

            $table->timestamps();

            $table->unique([
                'restaurant_id',
                'code',
            ]);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('menu_items');
    }
};
