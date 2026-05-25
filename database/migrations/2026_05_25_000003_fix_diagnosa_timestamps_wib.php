<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // WIB wall clock was stored as UTC (+00); shift back 7 hours to the real instant.
        DB::statement("UPDATE diagnosa SET tanggal_diagnosa = tanggal_diagnosa - INTERVAL '7 hours'");
    }

    public function down(): void
    {
        DB::statement("UPDATE diagnosa SET tanggal_diagnosa = tanggal_diagnosa + INTERVAL '7 hours'");
    }
};
