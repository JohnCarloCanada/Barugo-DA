<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::connection('secondary')->create('users', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('employee_id', 10)->unique();
            $table->string('image')->nullable();
            $table->string('first_name', 50);
            $table->string('last_name', 50);
            $table->string('middle_name', 50)->nullable();
            $table->string('password', 60);
            $table->string('user_role', 30)->default('employee');
            $table->string('status', 20)->default('active');
            $table->string('date_hired', 50);
            $table->timestamps();
            /* $table->string('email')->unique(); */
            /* $table->timestamp('email_verified_at')->nullable(); */
            $table->rememberToken();
        });


        DB::connection('secondary')->table('users')->insert([
            'employee_id' => 'EMP-00001',
            'image' => '',
            'first_name' => 'treasury',
            'last_name' => 'Admin',
            'password' => sha1('admin123'),
            'user_role' => 'employee',
            'status' => 'active',
            'date_hired' => 'Wed, Oct 23, 2023',
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection('secondary')->dropIfExists('users');
    }
};
