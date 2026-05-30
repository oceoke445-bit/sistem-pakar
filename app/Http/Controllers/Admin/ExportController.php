<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class ExportController extends Controller
{
    public function laporan(Request $request)
    {
        if ($request->session()->get('auth.role') !== 'admin') {
            return response()->json(['error' => 'Forbidden'], 403);
        }

        $format = $request->query('format', 'pdf');
        $start_date = (string) $request->query('start_date', '');
        $end_date = (string) $request->query('end_date', '');

        $isExcel = in_array($format, ['excel', 'xlsx'], true);

        if ($start_date && $end_date) {
            $startTs = $start_date.'T00:00:00.000Z';
            $endTs = $end_date.'T23:59:59.999Z';
            $rows = DB::table('diagnosa')
                ->where('tanggal_diagnosa', '>=', $startTs)
                ->where('tanggal_diagnosa', '<=', $endTs)
                ->orderByDesc('tanggal_diagnosa')
                ->get();
        } else {
            $rows = DB::table('diagnosa')->orderByDesc('tanggal_diagnosa')->get();
        }

        $userIds = $rows->pluck('id_user')->unique()->filter()->values()->all();
        $namaUser = [];
        if ($userIds !== []) {
            $namaUser = DB::table('users')->whereIn('id', $userIds)->pluck('nama_lengkap', 'id')->all();
        }

        $kodes = $rows->pluck('hasil_penyakit')->filter()->unique()->values()->all();
        $namaPenyakit = [];
        if ($kodes !== []) {
            $namaPenyakit = DB::table('penyakit')->whereIn('kode_penyakit', $kodes)->pluck('nama_penyakit', 'kode_penyakit')->all();
        }

        $tableBody = [];
        foreach ($rows as $i => $r) {
            $tableBody[] = [
                (string) ($i + 1),
                format_date_id((string) $r->tanggal_diagnosa),
                $namaUser[$r->id_user] ?? '—',
                $r->hasil_penyakit ? ($namaPenyakit[$r->hasil_penyakit] ?? $r->hasil_penyakit) : '—',
                $r->confidence !== null ? number_format((float) $r->confidence * 100, 2).'%' : '—',
            ];
        }

        $reportMeta = $this->laporanReportMeta($start_date, $end_date);

        if ($isExcel) {
            return $this->laporanExcelResponse($tableBody, $reportMeta);
        }

        $pdf = Pdf::loadView('exports.laporan-pdf', array_merge($reportMeta, [
            'rows' => $tableBody,
        ]))->setPaper('a4', 'landscape');

        return $pdf->download('laporan-diagnosa-printer.pdf');
    }

    /** @return array{reportTitle: string, appName: string, unitName: string, periodLabel: string, printedAt: string} */
    private function laporanReportMeta(string $start_date, string $end_date): array
    {
        return [
            'reportTitle' => 'Laporan Diagnosa Kerusakan Printer',
            'appName' => (string) config('app.name', 'Sistem Pakar'),
            'unitName' => 'Fotocopy Berkah Andirra',
            'periodLabel' => format_report_period_range($start_date ?: null, $end_date ?: null),
            'printedAt' => Carbon::now('Asia/Jakarta')->format('d/m/Y, H:i').' WIB',
        ];
    }

    /**
     * @param  array<int, array<int, string>>  $tableBody
     * @param  array{reportTitle: string, appName: string, unitName: string, periodLabel: string, printedAt: string}  $meta
     */
    private function laporanExcelResponse(array $tableBody, array $meta)
    {
        $sheetData = [
            [$meta['reportTitle']],
            [$meta['appName']],
            [$meta['unitName']],
            ['Periode: '.$meta['periodLabel']],
            ['Dicetak: '.$meta['printedAt']],
            [],
            ['No', 'Tanggal', 'Nama Pengguna', 'Hasil Kerusakan', 'Kecocokan'],
            ...$tableBody,
        ];

        $spreadsheet = new Spreadsheet;
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Laporan Diagnosa');
        $sheet->fromArray($sheetData);

        $sheet->mergeCells('A1:E1');
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);

        $sheet->getStyle('A7:E7')->getFont()->setBold(true)->setColor(new \PhpOffice\PhpSpreadsheet\Style\Color('FFFFFFFF'));
        $sheet->getStyle('A7:E7')->getFill()
            ->setFillType(Fill::FILL_SOLID)
            ->getStartColor()->setRGB('1E40AF');
        $sheet->getStyle('A7:E7')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        foreach (range('A', 'E') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        $writer = new Xlsx($spreadsheet);
        $tmp = tempnam(sys_get_temp_dir(), 'xlsx');
        $writer->save($tmp);
        $content = file_get_contents($tmp);
        @unlink($tmp);

        return response($content, 200, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'Content-Disposition' => 'attachment; filename="laporan-diagnosa-printer.xlsx"',
        ]);
    }
}
