<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('seeds', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('type');
            $table->integer('initial_stock_quantity');
            $table->string('measure_unity');
            $table->decimal('pms',8,2);
            $table->decimal('germination',8,2);
            $table->decimal('vigor',8,2);
            $table->decimal('value',18,2);
            $table->timestamps();

            $table->foreignId('farm_id')->constrained('farms')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('seeds');
    }
};
