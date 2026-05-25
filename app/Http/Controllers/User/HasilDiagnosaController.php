<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HasilDiagnosaController extends Controller
{
    public function show(Request $request, int $id)
    {
        $auth = $request->session()->get('auth');
        $d = DB::table('diagnosa')->where('id', $id)->where('id_user', $auth['id'])->first();
        if (! $d) {
            abort(404);
        }

        $penyakit = $d->hasil_penyakit
            ? DB::table('penyakit')->where('kode_penyakit', $d->hasil_penyakit)->first()
            : null;

        $kodes = DB::table('diagnosa_detail')->where('id_diagnosa', $id)->pluck('kode_gejala')->all();
        $namaGejala = [];
        if ($kodes !== []) {
            $namaGejala = DB::table('gejala')->whereIn('kode_gejala', $kodes)->pluck('nama_gejala', 'kode_gejala')->all();
        }

        $pct = $d->confidence !== null ? (float) $d->confidence * 100 : null;

        return view('user.hasil-diagnosa', compact('d', 'penyakit', 'kodes', 'namaGejala', 'pct'));
    }

    public function setTindakan(Request $request, int $id)
    {
        $request->validate([
            'tindakan' => 'required|in:sendiri,teknisi',
        ]);

        $auth = $request->session()->get('auth');
        $updated = DB::table('diagnosa')
            ->where('id', $id)
            ->where('id_user', $auth['id'])
            ->update(['tindakan' => $request->input('tindakan')]);

        if (! $updated) {
            abort(404);
        }

        return redirect('/user/riwayat');
    }
}
