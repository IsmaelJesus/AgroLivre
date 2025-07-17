<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * 
     * 
     * Consumo Diesel Hora
     * Depreciação	
     * Manutenção
     * Valor Diesel
     * Valor Total Diesel
     */
    public function up(): void
    {
        Schema::create('machinery_use_activity', function (Blueprint $table) {
            $table->id();
            $table->decimal('diesel_consumption',6,2)->nullable();

            $table->foreignId('machinery_id')->constrained('machinery')->onDelete('cascade');
            $table->foreignId('activity_id')->constrained('activities')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('machinery_use_activity');
    }
};
