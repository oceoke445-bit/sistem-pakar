<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('users')
            ->where('role', 'admin')
            ->where('email', env('ADMIN_EMAIL', 'admin@local.id'))
            ->update(['nama_lengkap' => 'Gemma Galgani Ajum']);
    }

    public function down(): void
    {
        DB::table('users')
            ->where('role', 'admin')
            ->where('email', env('ADMIN_EMAIL', 'admin@local.id'))
            ->update(['nama_lengkap' => 'Administrator']);
    }
};
