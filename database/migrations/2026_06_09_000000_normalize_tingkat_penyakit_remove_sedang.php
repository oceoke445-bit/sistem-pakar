<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('penyakit')
            ->whereRaw("LOWER(tingkat) = 'sedang'")
            ->update(['tingkat' => 'Ringan']);
    }

    public function down(): void
    {
        // intentionally not reversible
    }
};
