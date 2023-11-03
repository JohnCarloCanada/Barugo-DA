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
        Schema::create('livestocks', function (Blueprint $table) {
            $table->id('LiveStockID');
            $table->string('RSBSA_No', 24);
            $table->foreign('RSBSA_No')->references('RSBSA_No')->on('personal_informations')->onDelete('cascade')->onUpdate('cascade');
            $table->string('LSAnimals', 255);
            $table->string('Sex_LS', 10);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('livestocks');
    }
};
