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
        Schema::create('users', function (Blueprint $table) {
            $table->integer('id', 11);
            $table->string('employee_id', 10)->unique()->nullable();
            $table->string('image', 255)->nullable();
            $table->string('first_name', 50);
            $table->string('last_name', 50);
            $table->string('middle_name', 50)->nullable();
            $table->string('password', 60);
            $table->timestamps();
            /* $table->string('email')->unique(); */
            /* $table->timestamp('email_verified_at')->nullable(); */
            /* $table->rememberToken(); */
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
