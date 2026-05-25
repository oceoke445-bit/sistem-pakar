<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PrinterController extends Controller
{
    public function index(Request $request)
    {
        $q = $request->query('q', '');
        
        $query = DB::table('printers');
        
        if ($q !== '') {
            $query->where(function($query) use ($q) {
                $query->where('nama_printer', 'like', "%{$q}%")
                      ->orWhere('model', 'like', "%{$q}%")
                      ->orWhere('lokasi', 'like', "%{$q}%");
            });
        }
        
        $rows = $query->orderBy('nama_printer', 'asc')->paginate(10)->withQueryString();
        
        $editing = null;
        if ($request->query('edit')) {
            $editing = DB::table('printers')->where('id', $request->query('edit'))->first();
        }

        return view('admin.printer.index', [
            'rows' => $rows,
            'q' => $q,
            'editing' => $editing,
            'success' => $request->query('success'),
            'notice' => $request->query('notice'),
            'error' => $request->query('error'),
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_printer' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'lokasi' => 'required|string|max:255',
            'status' => 'required|in:aktif,perlu_perawatan',
        ]);

        try {
            DB::table('printers')->insert([
                'nama_printer' => trim($request->input('nama_printer')),
                'model' => trim($request->input('model')),
                'lokasi' => trim($request->input('lokasi')),
                'status' => $request->input('status'),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        } catch (\Throwable $e) {
            return redirect('/admin/printer?error=' . urlencode($e->getMessage()));
        }

        return redirect('/admin/printer?success=1');
    }

    public function update(Request $request)
    {
        $request->validate([
            'id' => 'required|integer',
            'nama_printer' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'lokasi' => 'required|string|max:255',
            'status' => 'required|in:aktif,perlu_perawatan',
        ]);

        try {
            DB::table('printers')->where('id', $request->input('id'))->update([
                'nama_printer' => trim($request->input('nama_printer')),
                'model' => trim($request->input('model')),
                'lokasi' => trim($request->input('lokasi')),
                'status' => $request->input('status'),
                'updated_at' => now(),
            ]);
        } catch (\Throwable $e) {
            return redirect('/admin/printer?error=' . urlencode($e->getMessage()));
        }

        return redirect('/admin/printer?success=1');
    }

    public function destroy(Request $request)
    {
        $id = $request->input('id');

        try {
            $row = DB::table('printers')->where('id', $id)->first();
            $label = $row ? $row->nama_printer : $id;
            
            DB::table('printers')->where('id', $id)->delete();
        } catch (\Throwable $e) {
            return redirect('/admin/printer?error=' . urlencode($e->getMessage()));
        }

        return redirect('/admin/printer?notice=' . urlencode("Printer {$label} berhasil dihapus dari sistem."));
    }
}
