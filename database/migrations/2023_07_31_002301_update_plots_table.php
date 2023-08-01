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
        // To avoid erros, we need to allow cascade remove on fk
        Schema::table('plots', function (Blueprint $table) {
            // Drop Current Foreing
            $table->dropForeign('plots_farm_id_foreign');

            // Add Again with new info
            $table->foreign('farm_id')
                ->references('id')
                ->on('farms')
                ->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('plots', function (Blueprint $table) {
            // Drop Current Foreing
            $table->dropForeign('plots_farm_id_foreign');

            // Add without on delete
            $table->foreign('farm_id')
                ->references('id')
                ->on('farms');

        });
    }
};
