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
        Schema::create('areas', function (Blueprint $table) {
            $table->id();
            $table->string('Lot_No', 32)->unique();
            $table->string('RSBSA_No', 24);
            $table->foreign('RSBSA_No')->references('RSBSA_No')->on('personal_informations')->onDelete('cascade')->onUpdate('cascade');
            $table->decimal('Hectares', 10, 2);
            $table->string('Area_Type', 99);
            $table->string('Commodity_planted', 99)->nullable();
            $table->string('Address', 255);
            $table->string('Lat', 255);
            $table->string('Lon', 255);
            $table->string('Ownership_Type', 10);
            $table->string('Tenant_Name', 99)->nullable();
            $table->string('Owner_Address', 255);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('areas');
    }
};
