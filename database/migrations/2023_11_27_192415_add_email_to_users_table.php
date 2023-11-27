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
        Schema::connection('secondary')->table('users', function (Blueprint $table) {
            //
            $table->string('email', 255)->nullable()->default(NULL)->unique();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection('secondary')->table('users', function (Blueprint $table) {
            //
            $table->dropColumn('email');
        });
    }
};
