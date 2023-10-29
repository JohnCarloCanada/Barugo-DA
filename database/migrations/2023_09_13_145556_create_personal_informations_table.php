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
            $table->id('RSBSA_No')->unique();

            $table->string('Surname', 99);
            $table->string('Updated_Surname', 99)->nullable();

            $table->string('First_Name', 99);
            $table->string('Updated_First_Name', 99)->nullable();

            $table->string('Middle_Name', 99)->nullable();
            $table->string('Updated_Middle_Name', 99)->nullable();

            $table->string('Extension', 9)->nullable();
            $table->string('Updated_Extension', 9)->nullable();

            $table->string('Address', 255);
            $table->string('Updated_Address', 255)->nullable();

            $table->string('Mobile_No', 20);
            $table->string('Updated_Mobile_No', 20)->nullable();

            $table->string('Sex', 10);
            $table->string('Updated_Sex', 10)->nullable();

            $table->date('Date_of_birth');
            $table->date('Updated_Date_of_birth')->nullable();

            $table->string('Religion', 99);
            $table->string('Updated_Religion', 99)->nullable();

            $table->string('Civil_Status', 9);
            $table->string('Updated_Civil_Status', 9)->nullable();

            $table->string('Name_of_Spouse', 99)->nullable();
            $table->string('Updated_Name_of_Spouse', 99)->nullable();

            $table->string('Highest_education_qualification', 255);
            $table->string('Updated_Highest_education_qualification', 255)->nullable();

            $table->string('Main_livelihood', 99);
            $table->string('Updated_Main_livelihood', 99)->nullable();

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
