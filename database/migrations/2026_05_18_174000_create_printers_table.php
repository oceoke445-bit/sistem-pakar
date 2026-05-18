<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Determine if the migration should be wrapped in a transaction.
     * Required for PgBouncer/Neon transaction pooling mode.
     */
    public $withinTransaction = false;

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('printers', function (Blueprint $table) {
            $table->id();
            $table->string('nama_printer');
            $table->string('model');
            $table->string('lokasi');
            $table->string('status')->default('aktif');
            $table->timestamps();
        });

        DB::table('printers')->insert([
            [
                'nama_printer' => 'Unit 1',
                'model' => 'Canon iR 3345',
                'lokasi' => 'Mesin Fotocopy 1',
                'status' => 'aktif',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nama_printer' => 'Unit 2',
                'model' => 'Canon iR 3235',
                'lokasi' => 'Mesin Fotocopy 2',
                'status' => 'aktif',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nama_printer' => 'Unit 3',
                'model' => 'Canon iR 2520',
                'lokasi' => 'Mesin Fotocopy 3',
                'status' => 'aktif',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nama_printer' => 'Unit 4',
                'model' => 'Canon iR 2002',
                'lokasi' => 'Mesin Fotocopy 4',
                'status' => 'perlu_perawatan',
                'created_at' => now(),
                'updated_at' => now()
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('printers');
    }
};
