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
        Schema::create('poultries', function (Blueprint $table) {
            $table->id();
            $table->string('Poultry_Type', 99);
            $table->integer('Quantity', false, false);
            $table->unsignedBigInteger('personal_information_id');
            $table->foreign('personal_information_id')->references('id')->on('personal_informations')->onDelete('cascade')->onUpdate('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('poultries');
    }
};
