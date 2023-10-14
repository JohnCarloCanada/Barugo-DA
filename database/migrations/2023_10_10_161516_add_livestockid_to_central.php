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
        Schema::table('central', function (Blueprint $table) {
            $table->unsignedBigInteger('LiveStockID');
            $table->foreign('LiveStockID')->references('LiveStockID')->on('livestocks')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('central', function (Blueprint $table) {
            //
            $table->dropColumn('LiveStockID');
        });
    }
};
