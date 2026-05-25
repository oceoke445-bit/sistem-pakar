<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public $withinTransaction = false;

    public function up(): void
    {
        if (! Schema::hasTable('printers')) {
            return;
        }

        DB::table('printers')->whereIn('nama_printer', ['Unit 3', 'Unit 4'])->delete();

        $now = now();
        $units = [
            'Unit 1' => [
                'model' => 'Canon IR 2425',
                'lokasi' => 'Mesin Fotocopy 1',
                'status' => 'aktif',
            ],
            'Unit 2' => [
                'model' => 'Canon IR 3045',
                'lokasi' => 'Mesin Fotocopy 2',
                'status' => 'aktif',
            ],
        ];

        foreach ($units as $nama => $data) {
            $exists = DB::table('printers')->where('nama_printer', $nama)->exists();
            if ($exists) {
                DB::table('printers')->where('nama_printer', $nama)->update([
                    ...$data,
                    'updated_at' => $now,
                ]);
            } else {
                DB::table('printers')->insert([
                    'nama_printer' => $nama,
                    ...$data,
                    'created_at' => $now,
                    'updated_at' => $now,
                ]);
            }
        }
    }

    public function down(): void
    {
        // Tidak mengembalikan data lama — perubahan data master.
    }
};
