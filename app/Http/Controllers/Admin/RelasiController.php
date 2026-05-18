<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RelasiController extends Controller
{
    public function index(Request $request)
    {
        $q = $request->query('q', '');
        
        $relasi = DB::table('relasi')->orderBy('id')->get();
        $penyakit = DB::table('penyakit')->orderBy('kode_penyakit')->get();
        $gejala = DB::table('gejala')->orderBy('kode_gejala')->get();

        $pn = DB::table('penyakit')->pluck('nama_penyakit', 'kode_penyakit')->all();
        $gn = DB::table('gejala')->pluck('nama_gejala', 'kode_gejala')->all();

        return view('admin.relasi.index', [
            'relasi' => $relasi,
            'penyakit' => $penyakit,
            'gejala' => $gejala,
            'pn' => $pn,
            'gn' => $gn,
            'q' => $q,
            'success' => $request->query('success'),
            'notice' => $request->query('notice'),
            'error' => $request->query('error'),
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_penyakit' => 'required|string',
            'kode_gejala' => 'required|string',
        ]);

        try {
            DB::table('relasi')->insert([
                'kode_penyakit' => trim($request->input('kode_penyakit')),
                'kode_gejala' => trim($request->input('kode_gejala')),
            ]);
        } catch (\Throwable $e) {
            $msg = str_contains($e->getMessage(), 'UNIQUE') || str_contains($e->getMessage(), 'duplicate')
                ? 'Relasi sudah ada'
                : $e->getMessage();

            return redirect('/admin/relasi?error='.urlencode($msg));
        }

        return redirect('/admin/relasi?success=1');
    }

    public function destroy(Request $request)
    {
        $kodePenyakit = $request->input('kode_penyakit');
        
        if ($kodePenyakit) {
            $namaPenyakit = DB::table('penyakit')->where('kode_penyakit', $kodePenyakit)->value('nama_penyakit');
            DB::table('relasi')->where('kode_penyakit', $kodePenyakit)->delete();
            $detail = "Seluruh aturan untuk kerusakan {$kodePenyakit}" . ($namaPenyakit ? " ({$namaPenyakit})" : "") . " berhasil dihapus.";
        } else {
            $id = (int) $request->input('id');
            $r = DB::table('relasi')->where('id', $id)->first();
            $namaPenyakit = $r ? DB::table('penyakit')->where('kode_penyakit', $r->kode_penyakit)->value('nama_penyakit') : null;
            $namaGejala = $r ? DB::table('gejala')->where('kode_gejala', $r->kode_gejala)->value('nama_gejala') : null;

            DB::table('relasi')->where('id', $id)->delete();

            $detail = $r
                ? sprintf(
                    'Relasi %s%s dengan gejala %s%s berhasil dihapus.',
                    $r->kode_penyakit,
                    $namaPenyakit ? " ({$namaPenyakit})" : '',
                    $r->kode_gejala,
                    $namaGejala ? " ({$namaGejala})" : ''
                )
                : 'Relasi berhasil dihapus.';
        }

        return redirect('/admin/relasi?notice='.urlencode($detail));
    }
}
