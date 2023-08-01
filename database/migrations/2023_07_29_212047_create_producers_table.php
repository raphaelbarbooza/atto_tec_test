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
        Schema::create('producers', function (Blueprint $table) {
            // Primary key as uuid
            $table->uuid('id')->primary();
            $table->timestamps();
            $table->softDeletes();

            $table->string('company_name',200);
            $table->string('trading_name',200);
            $table->string('social_number',25);
            $table->string('state_registration',25)->nullable();
            $table->string('phone',50)->nullable();
            $table->string('city_name',100);
            $table->string('state_name',50);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('producers');
    }
};
