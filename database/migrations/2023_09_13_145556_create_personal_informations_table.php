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
        Schema::create('personal_informations', function (Blueprint $table) {
            $table->id();
            $table->string('RSBSA_No', 24)->unique()->nullable()->default(NULL);
            $table->string('Surname', 99);
            $table->string('First_Name', 99);
            $table->string('Middle_Name', 99)->nullable();
            $table->string('Extension', 9)->nullable();
            $table->string('Address', 255);
            $table->string('Mobile_No', 20);
            $table->string('Sex', 10);
            $table->date('Date_of_birth');
            $table->string('Religion', 99);
            $table->string('Civil_Status', 9);
            $table->string('Name_of_Spouse', 99)->nullable();
            $table->string('Highest_education_qualification', 255);
            $table->string('Main_livelihood', 99);
            $table->boolean('update_status')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('personal_informations');
    }
};
