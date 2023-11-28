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
        Schema::connection('secondary')->create('user_logs', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id', false, false)->autoIncrement(false);
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->integer('app_id', false, false)->autoIncrement(false)->nullable();
            $table->foreign('app_id')->references('id')->on('applications')->onDelete('cascade')->onUpdate('cascade');
            $table->string('description', 255)->nullable();
            $table->string('date_time', 255)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection('secondary')->dropIfExists('user_logs');
    }
};
