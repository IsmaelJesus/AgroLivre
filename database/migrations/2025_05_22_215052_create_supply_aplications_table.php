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
        Schema::create('supply_aplications', function (Blueprint $table) {
            $table->id();
            $table->integer('used_quantity');

            $table->foreignId('activitie_id')->constrained('activities')->onDelete('cascade');
            $table->foreignId('supply_id')->constrained('supplies')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('supplie_aplications');
    }
};
