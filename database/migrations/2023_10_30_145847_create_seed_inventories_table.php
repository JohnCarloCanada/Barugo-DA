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
        Schema::create('seed_inventories', function (Blueprint $table) {
            $table->id();
            $table->string('Seed_Type', 24);
            $table->string('Seed_Variety', 99)->unique();
            $table->string('Company', 99);
            $table->decimal('NoHectare', 14, 2, true)->default(0);
            $table->decimal('NoBags', 14, 2, true)->default(0);
            $table->decimal('Quantity', 14, 2, true)->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('seed_inventories');
    }
};
