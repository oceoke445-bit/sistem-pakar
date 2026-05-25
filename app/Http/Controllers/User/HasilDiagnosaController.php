<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HasilDiagnosaController extends Controller
{
    public function show(Request $request, int $id)
    {
        return view('user.hasil-diagnosa', $this->loadDiagnosa($request, $id));
    }

    public function exportPdf(Request $request, int $id)
    {
        $data = $this->loadDiagnosa($request, $id);
        $filename = 'hasil-diagnosa-'.$id.'.pdf';

        return Pdf::loadView('exports.hasil-diagnosa-pdf', $data)
            ->setPaper('a4', 'portrait')
            ->download($filename);
    }

    public function exportWord(Request $request, int $id)
    {
        $data = $this->loadDiagnosa($request, $id);
        $filename = 'hasil-diagnosa-'.$id.'.doc';
        $content = view('exports.hasil-diagnosa-word', $data)->render();
        $content = "\xEF\xBB\xBF".$content;

        return response($content, 200, [
            'Content-Type' => 'application/msword; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="'.$filename.'"',
        ]);
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

        if ($request->wantsJson()) {
            return response()->json([
                'ok' => true,
                'redirect' => url('/user/riwayat'),
            ]);
        }

        return redirect('/user/riwayat');
    }

    /** @return array<string, mixed> */
    private function loadDiagnosa(Request $request, int $id): array
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
        $tingkat = $penyakit && $penyakit->tingkat ? $penyakit->tingkat : 'Sedang';
        $solusiLines = $penyakit && $penyakit->solusi
            ? array_filter(preg_split('/\r\n|\r|\n/', trim($penyakit->solusi)))
            : [];
        $tindakanLabel = ($d->tindakan ?? null)
            ? diagnosa_tindakan_badge($d->tindakan)['label']
            : null;

        return compact('d', 'penyakit', 'kodes', 'namaGejala', 'pct', 'tingkat', 'solusiLines', 'tindakanLabel');
    }
}
