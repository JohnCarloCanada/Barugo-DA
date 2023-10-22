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
        Schema::create('app_access', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('user_id', false, false)->autoIncrement(false);
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->integer('app_id', false, false);
            $table->foreign('app_id')->references('id')->on('applications')->onDelete('cascade')->onUpdate('cascade');
            $table->datetimes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('app_access');
    }
};
