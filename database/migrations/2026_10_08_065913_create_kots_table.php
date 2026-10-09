<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kots', function (Blueprint $table) {
            $table->id();

            $table->foreignId('restaurant_id')
                ->constrained('restaurants')
                ->cascadeOnDelete();

            $table->foreignId('order_id')
                ->constrained('orders')
                ->cascadeOnDelete();

            $table->foreignId('branch_id')
                ->constrained('branches')
                ->cascadeOnDelete();

            $table->foreignId('table_id')
                ->nullable()
                ->constrained('restaurant_tables')
                ->nullOnDelete();

            $table->string('kot_number');

            $table->enum('status', [
                'new',
                'preparing',
                'ready',
                'served',
                'cancelled',
            ])->default('new');

            $table->text('notes')->nullable();

            $table->timestamp('started_at')->nullable();
            $table->timestamp('ready_at')->nullable();
            $table->timestamp('served_at')->nullable();

            $table->timestamps();

            $table->unique([
                'restaurant_id',
                'kot_number',
            ]);

            $table->index([
                'restaurant_id',
                'status',
            ]);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kots');
    }
};
