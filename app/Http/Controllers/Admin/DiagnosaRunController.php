<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\DiagnosisService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DiagnosaRunController extends Controller
{
    public function index(Request $request)
    {
        $gejala = DB::table('gejala')->orderBy('kode_gejala')->get();

        return view('admin.diagnosa.index', [
            'gejala' => $gejala,
            'error' => $request->query('error'),
        ]);
    }

    public function store(Request $request)
    {
        $auth = $request->session()->get('auth');
        $selected = array_filter((array) $request->input('gejala', []));
        if ($selected === []) {
            return redirect()->route('admin.diagnosa.index', ['error' => 'Pilih minimal satu gejala.']);
        }

        $relRows = DB::table('relasi')
            ->join('penyakit', 'relasi.kode_penyakit', '=', 'penyakit.kode_penyakit')
            ->select('relasi.kode_penyakit', 'relasi.kode_gejala', 'penyakit.nama_penyakit')
            ->get();

        $hasil = DiagnosisService::compute($selected, $relRows->all());
        $top = $hasil[0] ?? null;
        $hasil_penyakit = $top['kode_penyakit'] ?? null;
        $confidence = $top['confidence'] ?? 0;

        $id = DB::transaction(function () use ($auth, $hasil_penyakit, $confidence, $selected) {
            $id = (int) DB::table('diagnosa')->insertGetId([
                'id_user' => $auth['id'],
                'hasil_penyakit' => $hasil_penyakit,
                'confidence' => $confidence,
                'tanggal_diagnosa' => now()->utc(),
            ]);
            foreach ($selected as $k) {
                DB::table('diagnosa_detail')->insertOrIgnore([
                    'id_diagnosa' => $id,
                    'kode_gejala' => $k,
                ]);
            }

            return $id;
        });

        return redirect()->route('admin.diagnosa.hasil', ['id' => $id]);
    }

    public function hasil(Request $request, int $id)
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

        return view('admin.diagnosa.hasil', compact('d', 'penyakit', 'kodes', 'namaGejala', 'pct'));
    }

    public function setTindakan(Request $request, int $id)
    {
        $request->validate([
            'tindakan' => 'required|in:sendiri,teknisi',
        ]);

        $auth = $request->session()->get('auth');
        $row = DB::table('diagnosa')->where('id', $id)->where('id_user', $auth['id'])->first();
        if (! $row) {
            abort(404);
        }

        DB::table('diagnosa')
            ->where('id', $id)
            ->where('id_user', $auth['id'])
            ->update(['tindakan' => $request->input('tindakan')]);

        return redirect()->route('admin.riwayat', ['notice' => 'Diagnosa telah disimpan ke riwayat.']);
    }
}
