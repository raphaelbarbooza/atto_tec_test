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
        Schema::table('farms', function (Blueprint $table) {
            // Drop Current Foreing
            $table->dropForeign('farms_producer_id_foreign');

            // Add Again with new info
            $table->foreign('producer_id')
                ->references('id')
                ->on('producers')
                ->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('farms', function (Blueprint $table) {
            // Drop Current Foreing
            $table->dropForeign('farms_producer_id_foreign');

            // Add without on delete
            $table->foreign('producer_id')
                ->references('id')
                ->on('producers');

        });
    }
};
