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
        Schema::create('activities', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('type');
            $table->dateTime('start_date');
            $table->dateTime('finish_date');
            $table->decimal('diesel_value', 12,2);
            $table->decimal('estimated_diesel_value', 12,2);
            $table->string('observations')->nullable();
            
            $table->foreignId('crop_id')->constrained('crops')->onDelete('cascade');
            $table->foreignId('plot_id')->constrained('plots')->onDelete('cascade');
            $table->foreignId('supply_id')->nullable()->constrained('supplies')->onDelete('cascade');
            $table->foreignId('seed_id')->nullable()->constrained('seeds')->onDelete('cascade');
            $table->foreignId('farm_id')->constrained('farms')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activities');
    }
};
