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
        Schema::create('itineraries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('trip_id')->constrained()->cascadeOnDelete();
    
            $table->date('date')->nullable();
            $table->string('type')->nullable(); // move, food, stay, spot
            $table->string('title')->nullable();
            $table->text('note')->nullable();
    
            $table->integer('cost')->nullable();
    
            $table->string('transport')->nullable();
            $table->string('from_place')->nullable();
            $table->string('to_place')->nullable();
            $table->integer('duration_minutes')->nullable();
            $table->decimal('distance_km', 6, 2)->nullable();
    
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();
    
            $table->timestamps();
            $table->integer('sort_order')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('itineraries');
    }
};
