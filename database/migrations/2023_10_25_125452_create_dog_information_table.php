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
        Schema::create('dog_information', function (Blueprint $table) {
            $table->id();
            $table->string('Dog_Name', 99);
            $table->string('Owner_Name', 99);
            $table->string('Species', 99);
            $table->string('Sex', 9);
            $table->integer('Age', false, false);
            $table->string('Neutering', 9);
            $table->string('Color', 19);
            $table->date('Date_of_Registration');
            $table->date('Last_Vac_Month')->nullable();
            $table->string('Remarks', 255)->nullable();
            $table->unsignedBigInteger('personal_information_id')->nullable()->default(NULL);
            $table->foreign('personal_information_id')->references('id')->on('personal_informations')->onDelete('cascade')->onUpdate('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dog_information');
    }
};
