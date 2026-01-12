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
        Schema::table('trips', function (Blueprint $table) {
            $table->string('flight_number')->nullable()->after('title');
            $table->string('hotel_address')->nullable()->after('flight_number');
            $table->date('arrival_date')->nullable()->after('hotel_address');
            $table->string('departure_info')->nullable()->after('arrival_date');
        });        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('trips', function (Blueprint $table) {
            //
        });
    }
};
