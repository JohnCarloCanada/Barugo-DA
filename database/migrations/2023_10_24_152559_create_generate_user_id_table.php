<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::unprepared('
            CREATE TRIGGER id_store BEFORE INSERT ON users FOR EACH ROW
            BEGIN
                SET NEW.employee_id = CONCAT("EMP-", LPAD((SELECT COALESCE(MAX(SUBSTRING(employee_id, 5) + 1), 1) FROM users), 5, "0"));
            END
        ');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared('DROP TRIGGER IF EXISTS id_store');
    }
};
