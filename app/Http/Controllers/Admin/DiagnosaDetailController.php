<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DiagnosaDetailController extends Controller
{
    public function show(Request $request, int $id)
    {
        $d = DB::table('diagnosa')->where('id', $id)->first();
        if (! $d) {
            abort(404);
        }

        $userProf = DB::table('users')->where('id', $d->id_user)->select('nama_lengkap', 'email')->first();
        $p = $d->hasil_penyakit
            ? DB::table('penyakit')->where('kode_penyakit', $d->hasil_penyakit)->first()
            : null;

        $kodeList = DB::table('diagnosa_detail')->where('id_diagnosa', $id)->pluck('kode_gejala')->all();
        $namaGejala = [];
        if ($kodeList !== []) {
            $namaGejala = DB::table('gejala')->whereIn('kode_gejala', $kodeList)->pluck('nama_gejala', 'kode_gejala')->all();
        }

        $pct = $d->confidence !== null ? (float) $d->confidence * 100 : null;

        return view('admin.diagnosa.show', compact('d', 'userProf', 'p', 'kodeList', 'namaGejala', 'pct'));
    }

    public function destroy(Request $request)
    {
        $id = (int) $request->input('id');
        if ($id <= 0) {
            return redirect('/admin/riwayat?error='.urlencode('ID diagnosa tidak valid.'));
        }

        $t = DB::table('diagnosa')->where('id', $id)->value('tanggal_diagnosa');
        if (! $t) {
            return redirect('/admin/riwayat?error='.urlencode('Data diagnosa tidak ditemukan.'));
        }

        try {
            DB::table('diagnosa')->where('id', $id)->delete();
        } catch (\Throwable $e) {
            return redirect('/admin/riwayat?error='.urlencode('Gagal menghapus data diagnosa.'));
        }

        $when = format_date_id((string) $t);

        return redirect('/admin/riwayat?notice='.urlencode("Diagnosa #{$id} ({$when}) berhasil dihapus dari riwayat."));
    }
}
