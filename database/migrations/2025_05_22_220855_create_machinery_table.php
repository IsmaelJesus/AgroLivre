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
        Schema::create('machinery', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('type');
            $table->string('brand');
            $table->string('model');
            $table->dateTime('acquisition_date');
            $table->integer('hours_use')->default('0');
            $table->decimal('acquisition_value',12,2);
            $table->decimal('useful_life');
            $table->boolean('status');
            $table->timestamps();

            $table->foreignId('farm_id')->constrained('farms')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('machinery');
    }
};
