<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class RelasiController extends Controller
{
    public function index(Request $request)
    {
        $q = trim((string) $request->query('q', ''));

        $relasi = DB::table('relasi')->orderBy('id')->get();
        $penyakit = DB::table('penyakit')->orderBy('kode_penyakit')->get();
        $gejala = DB::table('gejala')->orderBy('kode_gejala')->get();

        $pn = DB::table('penyakit')->pluck('nama_penyakit', 'kode_penyakit')->all();
        $gn = DB::table('gejala')->pluck('nama_gejala', 'kode_gejala')->all();

        $grouped = [];
        foreach ($relasi as $r) {
            $grouped[$r->kode_penyakit][] = $r;
        }

        $ruleCodes = [];
        $idx = 1;
        foreach ($grouped as $kodePenyakit => $items) {
            $ruleCodes[$kodePenyakit] = 'R'.str_pad((string) $idx++, 3, '0', STR_PAD_LEFT);
        }

        if ($q !== '') {
            $qLower = strtolower($q);
            foreach ($grouped as $kodePenyakit => $items) {
                $match = false;
                if (str_contains(strtolower($kodePenyakit), $qLower)) {
                    $match = true;
                }
                if (str_contains(strtolower($pn[$kodePenyakit] ?? ''), $qLower)) {
                    $match = true;
                }
                if (str_contains(strtolower($ruleCodes[$kodePenyakit] ?? ''), $qLower)) {
                    $match = true;
                }
                foreach ($items as $item) {
                    if (str_contains(strtolower($item->kode_gejala), $qLower)) {
                        $match = true;
                    }
                    if (str_contains(strtolower($gn[$item->kode_gejala] ?? ''), $qLower)) {
                        $match = true;
                    }
                }
                if (! $match) {
                    unset($grouped[$kodePenyakit]);
                }
            }
        }

        $page = max(1, (int) $request->query('page', 1));
        $perPage = 10;
        $groupedCollection = collect($grouped);
        $groupedPaginator = new LengthAwarePaginator(
            $groupedCollection->slice(($page - 1) * $perPage, $perPage)->all(),
            $groupedCollection->count(),
            $perPage,
            $page,
            ['path' => $request->url(), 'query' => $request->query()]
        );

        return view('admin.relasi.index', [
            'grouped' => $groupedPaginator,
            'ruleCodes' => $ruleCodes,
            'penyakit' => $penyakit,
            'gejala' => $gejala,
            'pn' => $pn,
            'gn' => $gn,
            'q' => $q,
            'tambahPenyakit' => $request->query('tambah'),
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

        $kodePenyakit = trim((string) $request->input('kode_penyakit'));
        $kodeGejala = trim((string) $request->input('kode_gejala'));

        if (! DB::table('penyakit')->where('kode_penyakit', $kodePenyakit)->exists()) {
            return redirect('/admin/relasi?error='.urlencode('Kode kerusakan tidak ditemukan.'));
        }
        if (! DB::table('gejala')->where('kode_gejala', $kodeGejala)->exists()) {
            return redirect('/admin/relasi?error='.urlencode('Kode gejala tidak ditemukan.'));
        }

        try {
            DB::table('relasi')->insert([
                'kode_penyakit' => $kodePenyakit,
                'kode_gejala' => $kodeGejala,
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
        $kodePenyakit = trim((string) $request->input('kode_penyakit', ''));

        if ($kodePenyakit !== '') {
            if (! DB::table('penyakit')->where('kode_penyakit', $kodePenyakit)->exists()) {
                return redirect('/admin/relasi?error='.urlencode('Rule kerusakan tidak ditemukan.'));
            }

            $namaPenyakit = DB::table('penyakit')->where('kode_penyakit', $kodePenyakit)->value('nama_penyakit');
            DB::table('relasi')->where('kode_penyakit', $kodePenyakit)->delete();
            $detail = "Seluruh aturan untuk kerusakan {$kodePenyakit}".($namaPenyakit ? " ({$namaPenyakit})" : '').' berhasil dihapus.';

            return redirect('/admin/relasi?notice='.urlencode($detail));
        }

        $id = (int) $request->input('id');
        if ($id <= 0) {
            return redirect('/admin/relasi?error='.urlencode('Relasi tidak valid.'));
        }

        $r = DB::table('relasi')->where('id', $id)->first();
        if (! $r) {
            return redirect('/admin/relasi?error='.urlencode('Relasi tidak ditemukan.'));
        }

        $namaPenyakit = DB::table('penyakit')->where('kode_penyakit', $r->kode_penyakit)->value('nama_penyakit');
        $namaGejala = DB::table('gejala')->where('kode_gejala', $r->kode_gejala)->value('nama_gejala');

        DB::table('relasi')->where('id', $id)->delete();

        $detail = sprintf(
            'Relasi %s%s dengan gejala %s%s berhasil dihapus.',
            $r->kode_penyakit,
            $namaPenyakit ? " ({$namaPenyakit})" : '',
            $r->kode_gejala,
            $namaGejala ? " ({$namaGejala})" : ''
        );

        return redirect('/admin/relasi?notice='.urlencode($detail));
    }
}
