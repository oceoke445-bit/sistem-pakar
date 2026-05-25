<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $auth = $request->session()->get('auth');
        $count = 0;
        $rows = collect();
        $dbError = false;
        $lastDiagnosaHuman = 'Belum ada';
        $firstName = trim(explode(' ', trim($auth['nama_lengkap'] ?? 'Pengguna'))[0] ?: 'Pengguna');

        try {
            $count = (int) DB::table('diagnosa')->where('id_user', $auth['id'])->count();

            $rows = DB::table('diagnosa')
                ->where('id_user', $auth['id'])
                ->orderByDesc('tanggal_diagnosa')
                ->limit(5)
                ->get();

            $lastRow = $rows->first();
            if ($lastRow && $lastRow->tanggal_diagnosa) {
                $lastDt = wib_from_db($lastRow->tanggal_diagnosa);
                if ($lastDt) {
                    $lastDiagnosaHuman = $lastDt
                        ->locale('id')
                        ->diffForHumans(Carbon::now('Asia/Jakarta'));
                }
            }
        } catch (\Throwable $e) {
            $dbError = true;
        }

        $kodes = $rows->pluck('hasil_penyakit')->filter()->unique()->values()->all();
        $namaByKode = [];
        if ($kodes !== []) {
            $namaByKode = DB::table('penyakit')->whereIn('kode_penyakit', $kodes)->pluck('nama_penyakit', 'kode_penyakit')->all();
        }

        return view('user.dashboard', compact(
            'auth',
            'firstName',
            'count',
            'rows',
            'namaByKode',
            'dbError',
            'lastDiagnosaHuman',
        ));
    }
}
