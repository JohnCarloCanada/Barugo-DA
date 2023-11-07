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
        Schema::create('machinerys', function (Blueprint $table) {
            $table->id();
            $table->string('MachineName', 99);
            $table->decimal('Price', 14, 2);
            $table->string('Mode_Acqusition', 99);
            $table->string('Use_of_Machinery', 9);
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
        Schema::dropIfExists('machinerys');
    }
};
