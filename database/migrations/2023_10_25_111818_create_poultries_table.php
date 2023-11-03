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
            $table->id('PoultryID');
            $table->string('Poultry_Type', 99);
            $table->integer('Quantity', false, false);
            $table->string('RSBSA_No', 24);
            $table->foreign('RSBSA_No')->references('RSBSA_No')->on('personal_informations')->onDelete('cascade')->onUpdate('cascade');
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
