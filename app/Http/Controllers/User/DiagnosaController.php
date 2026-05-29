<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Services\DiagnosisService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DiagnosaController extends Controller
{
    public function index(Request $request)
    {
        $auth = $request->session()->get('auth');
        $firstName = trim(explode(' ', trim($auth['nama_lengkap'] ?? 'Pengguna'))[0] ?: 'Pengguna');
        $gejala = DB::table('gejala')->orderBy('kode_gejala')->get();

        return view('user.diagnosa', [
            'gejala' => $gejala,
            'error' => $request->query('error'),
            'firstName' => $firstName,
        ]);
    }

    public function store(Request $request)
    {
        $auth = $request->session()->get('auth');
        $selected = array_filter((array) $request->input('gejala', []));
        if ($selected === []) {
            return redirect('/user/diagnosa?error='.urlencode('Pilih minimal satu gejala.'));
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

        return redirect()->route('user.diagnosa.proses', ['id' => (int) $id]);
    }

    public function proses(Request $request, int $id)
    {
        $auth = $request->session()->get('auth');
        $exists = DB::table('diagnosa')
            ->where('id', $id)
            ->where('id_user', $auth['id'])
            ->exists();

        if (! $exists) {
            abort(404);
        }

        $firstName = trim(explode(' ', trim($auth['nama_lengkap'] ?? 'Pengguna'))[0] ?: 'Pengguna');

        return view('user.diagnosa-proses', [
            'diagnosaId' => $id,
            'firstName' => $firstName,
        ]);
    }
}
