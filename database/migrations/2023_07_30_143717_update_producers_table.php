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
        Schema::table('producers', function (Blueprint $table) {
            // Drop City Name and State Name
            $table->dropColumn('city_name');
            $table->dropColumn('state_name');

            // Get the city by database ref
            $table->unsignedInteger('city_id');
            $table->foreign('city_id')->references('id')->on('cities');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('producers', function (Blueprint $table) {
            // Drop the city id
            $table->dropConstrainedForeignId('city_id');

            // Return to city name and state name
            $table->string('city_name',100);
            $table->string('state_name',50);
        });
    }
};
