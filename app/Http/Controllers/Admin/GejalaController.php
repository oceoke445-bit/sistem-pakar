<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GejalaController extends Controller
{
    public function index(Request $request)
    {
        $q = trim((string) $request->query('q', ''));
        $builder = DB::table('gejala');
        if ($q !== '') {
            $builder->where(function ($w) use ($q) {
                $w->where('nama_gejala', 'ilike', '%'.$q.'%')
                    ->orWhere('kode_gejala', 'ilike', '%'.$q.'%');
            });
        }
        $rows = $builder->orderBy('kode_gejala')->paginate(10)->withQueryString();
        $editing = $request->query('edit')
            ? DB::table('gejala')->where('kode_gejala', $request->query('edit'))->first()
            : null;

        return view('admin.gejala.index', [
            'rows' => $rows,
            'editing' => $editing,
            'success' => $request->query('success'),
            'notice' => $request->query('notice'),
            'error' => $request->query('error'),
            'q' => $q,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_gejala' => 'required|string|max:50',
            'nama_gejala' => 'required|string|max:255',
        ]);

        try {
            DB::table('gejala')->insert([
                'kode_gejala' => trim($request->input('kode_gejala')),
                'nama_gejala' => trim($request->input('nama_gejala')),
            ]);
        } catch (\Throwable $e) {
            $msg = str_contains($e->getMessage(), 'duplicate') || str_contains($e->getMessage(), 'unique')
                ? 'Kode gejala sudah ada di database. Gunakan kode lain atau edit gejala yang sudah tersimpan.'
                : 'Gagal menyimpan.';

            return redirect('/admin/gejala?error='.urlencode($msg));
        }

        return redirect('/admin/gejala?success=1');
    }

    public function update(Request $request)
    {
        $request->validate([
            'kode_gejala' => 'required|string|max:50',
            'nama_gejala' => 'required|string|max:255',
        ]);

        DB::table('gejala')
            ->where('kode_gejala', trim($request->input('kode_gejala')))
            ->update(['nama_gejala' => trim($request->input('nama_gejala'))]);

        return redirect('/admin/gejala?success=1');
    }

    public function destroy(Request $request)
    {
        $kode = trim((string) $request->input('kode_gejala'));
        DB::table('gejala')->where('kode_gejala', $kode)->delete();

        return redirect('/admin/gejala?notice='.urlencode("Gejala {$kode} berhasil dihapus dari daftar."));
    }
}
