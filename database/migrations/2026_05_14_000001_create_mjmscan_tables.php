<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->string('id', 36)->primary();
            $table->string('email')->unique();
            $table->string('password_hash');
            $table->string('nama_lengkap')->default('');
            $table->string('role')->default('user');
            $table->timestampTz('created_at')->useCurrent();
        });
        DB::statement("ALTER TABLE users ADD CONSTRAINT users_role_check CHECK (role IN ('admin', 'user'))");

        Schema::create('penyakit', function (Blueprint $table) {
            $table->string('kode_penyakit')->primary();
            $table->string('nama_penyakit');
            $table->string('tingkat')->nullable();
            $table->text('deskripsi')->nullable();
            $table->text('solusi')->nullable();
            $table->text('pencegahan')->nullable();
        });

        Schema::create('gejala', function (Blueprint $table) {
            $table->string('kode_gejala')->primary();
            $table->string('nama_gejala');
        });

        Schema::create('relasi', function (Blueprint $table) {
            $table->id();
            $table->string('kode_penyakit');
            $table->string('kode_gejala');
            $table->unique(['kode_penyakit', 'kode_gejala']);
            $table->foreign('kode_penyakit')->references('kode_penyakit')->on('penyakit')->cascadeOnDelete();
            $table->foreign('kode_gejala')->references('kode_gejala')->on('gejala')->cascadeOnDelete();
        });

        Schema::create('diagnosa', function (Blueprint $table) {
            $table->id();
            $table->string('id_user', 36);
            $table->timestampTz('tanggal_diagnosa')->useCurrent();
            $table->string('hasil_penyakit')->nullable();
            $table->double('confidence')->nullable();
            $table->foreign('id_user')->references('id')->on('users')->cascadeOnDelete();
            $table->foreign('hasil_penyakit')->references('kode_penyakit')->on('penyakit')->nullOnDelete();
        });

        Schema::create('diagnosa_detail', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_diagnosa');
            $table->string('kode_gejala');
            $table->unique(['id_diagnosa', 'kode_gejala']);
            $table->foreign('id_diagnosa')->references('id')->on('diagnosa')->cascadeOnDelete();
            $table->foreign('kode_gejala')->references('kode_gejala')->on('gejala');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('diagnosa_detail');
        Schema::dropIfExists('diagnosa');
        Schema::dropIfExists('relasi');
        Schema::dropIfExists('gejala');
        Schema::dropIfExists('penyakit');
        Schema::dropIfExists('users');
    }
};
