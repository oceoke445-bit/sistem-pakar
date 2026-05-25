<?php

use Illuminate\Support\Facades\Route;

Route::get('/', [\App\Http\Controllers\HomeController::class, 'index']);

Route::get('/api/health', [\App\Http\Controllers\HealthController::class, 'index']);
Route::get('/api/health/db', [\App\Http\Controllers\HealthController::class, 'db']);

Route::middleware('guest.mjm')->group(function () {
    Route::get('/login', [\App\Http\Controllers\AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [\App\Http\Controllers\AuthController::class, 'login']);
    Route::get('/register', [\App\Http\Controllers\AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [\App\Http\Controllers\AuthController::class, 'register']);
});

Route::post('/auth/signout', [\App\Http\Controllers\AuthController::class, 'logout'])
    ->middleware('auth.mjm')
    ->name('logout');

Route::middleware('auth.mjm')->group(function () {
    Route::get('/profile', [\App\Http\Controllers\ProfileController::class, 'show'])->name('profile');
    Route::post('/profile', [\App\Http\Controllers\ProfileController::class, 'update']);

    Route::prefix('user')->name('user.')->group(function () {
        Route::get('/dashboard', [\App\Http\Controllers\User\DashboardController::class, 'index'])->name('dashboard');
        Route::get('/diagnosa', [\App\Http\Controllers\User\DiagnosaController::class, 'index'])->name('diagnosa');
        Route::post('/diagnosa', [\App\Http\Controllers\User\DiagnosaController::class, 'store']);
        Route::get('/hasil-diagnosa/{id}', [\App\Http\Controllers\User\HasilDiagnosaController::class, 'show'])
            ->whereNumber('id')
            ->name('hasil-diagnosa');
        Route::post('/hasil-diagnosa/{id}/tindakan', [\App\Http\Controllers\User\HasilDiagnosaController::class, 'setTindakan'])
            ->whereNumber('id')
            ->name('hasil-diagnosa.tindakan');
        Route::get('/riwayat', [\App\Http\Controllers\User\RiwayatController::class, 'index'])->name('riwayat');
        Route::get('/riwayat/{id}', [\App\Http\Controllers\User\RiwayatController::class, 'show'])
            ->whereNumber('id')
            ->name('riwayat.show');
        Route::post('/riwayat/hapus', [\App\Http\Controllers\User\RiwayatController::class, 'destroy'])->name('riwayat.hapus');
    });

    Route::middleware('admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');
        Route::get('/penyakit', [\App\Http\Controllers\Admin\PenyakitController::class, 'index'])->name('penyakit');
        Route::post('/penyakit', [\App\Http\Controllers\Admin\PenyakitController::class, 'store']);
        Route::post('/penyakit/update', [\App\Http\Controllers\Admin\PenyakitController::class, 'update'])->name('penyakit.update');
        Route::post('/penyakit/hapus', [\App\Http\Controllers\Admin\PenyakitController::class, 'destroy'])->name('penyakit.hapus');
        Route::get('/gejala', [\App\Http\Controllers\Admin\GejalaController::class, 'index'])->name('gejala');
        Route::post('/gejala', [\App\Http\Controllers\Admin\GejalaController::class, 'store']);
        Route::post('/gejala/update', [\App\Http\Controllers\Admin\GejalaController::class, 'update'])->name('gejala.update');
        Route::post('/gejala/hapus', [\App\Http\Controllers\Admin\GejalaController::class, 'destroy'])->name('gejala.hapus');
        Route::get('/relasi', [\App\Http\Controllers\Admin\RelasiController::class, 'index'])->name('relasi');
        Route::post('/relasi', [\App\Http\Controllers\Admin\RelasiController::class, 'store']);
        Route::post('/relasi/hapus', [\App\Http\Controllers\Admin\RelasiController::class, 'destroy'])->name('relasi.hapus');
        Route::get('/pengguna', [\App\Http\Controllers\Admin\PenggunaController::class, 'index'])->name('pengguna');
        Route::post('/pengguna', [\App\Http\Controllers\Admin\PenggunaController::class, 'store']);
        Route::post('/pengguna/update', [\App\Http\Controllers\Admin\PenggunaController::class, 'update'])->name('pengguna.update');
        Route::post('/pengguna/hapus', [\App\Http\Controllers\Admin\PenggunaController::class, 'destroy'])->name('pengguna.hapus');
        Route::get('/printer', [\App\Http\Controllers\Admin\PrinterController::class, 'index'])->name('printer');
        Route::post('/printer', [\App\Http\Controllers\Admin\PrinterController::class, 'store']);
        Route::post('/printer/update', [\App\Http\Controllers\Admin\PrinterController::class, 'update'])->name('printer.update');
        Route::post('/printer/hapus', [\App\Http\Controllers\Admin\PrinterController::class, 'destroy'])->name('printer.hapus');
        Route::get('/riwayat', [\App\Http\Controllers\Admin\RiwayatController::class, 'index'])->name('riwayat');
        Route::post('/riwayat/hapus', [\App\Http\Controllers\Admin\RiwayatController::class, 'destroy'])->name('riwayat.hapus');
        Route::get('/laporan', [\App\Http\Controllers\Admin\LaporanController::class, 'index'])->name('laporan');
        Route::get('/diagnosa/{id}', [\App\Http\Controllers\Admin\DiagnosaDetailController::class, 'show'])
            ->whereNumber('id')
            ->name('diagnosa.show');
        Route::post('/diagnosa/hapus', [\App\Http\Controllers\Admin\DiagnosaDetailController::class, 'destroy'])->name('diagnosa.hapus');
    });

    Route::middleware('admin')->get('/api/admin/export/laporan', [\App\Http\Controllers\Admin\ExportController::class, 'laporan'])
        ->name('admin.export.laporan');
});
