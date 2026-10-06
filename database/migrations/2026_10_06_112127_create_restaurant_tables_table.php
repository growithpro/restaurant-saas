<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('restaurant_tables', function (Blueprint $table) {
            $table->id();

            $table->foreignId('branch_id')
                ->constrained('branches')
                ->cascadeOnDelete();

            $table->foreignId('floor_id')
                ->constrained('floors')
                ->restrictOnDelete();

            $table->string('name');

            $table->string('code');

            $table->unsignedInteger('capacity')
                ->default(2);

            $table->string('status')
                ->default('available');

            $table->boolean('is_active')
                ->default(true);

            $table->text('notes')
                ->nullable();

            $table->timestamps();

            $table->unique([
                'branch_id',
                'code',
            ]);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('restaurant_tables');
    }
};
