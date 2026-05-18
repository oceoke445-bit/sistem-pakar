<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $auth = $request->session()->get('auth');
        $count = 0;
        $rows = collect();
        $dbError = false;
        $gejalaMaster = 0;
        $penyakitMaster = 0;
        $chartLabels = [];
        $chartSeries = [];
        $donut = ['ringan' => 0, 'sedang' => 0, 'berat' => 0];

        try {
            // 1. Consolidate base counts
            $counts = DB::select("
                SELECT 
                  (SELECT COUNT(*) FROM diagnosa WHERE id_user = ?) as user_diagnosa_count,
                  (SELECT COUNT(*) FROM gejala) as gejala_count,
                  (SELECT COUNT(*) FROM penyakit) as penyakit_count
            ", [$auth['id']])[0];

            $count = (int) $counts->user_diagnosa_count;
            $gejalaMaster = (int) $counts->gejala_count;
            $penyakitMaster = (int) $counts->penyakit_count;

            $rows = DB::table('diagnosa')
                ->where('id_user', $auth['id'])
                ->orderByDesc('tanggal_diagnosa')
                ->limit(5)
                ->get();

            // 2. Consolidate group-by queries for different ranges
            $today = Carbon::now();
            
            // A. 30 Days (for 1 Month range calculations if needed) & 7 Days
            $thirtyDaysAgo = (clone $today)->subDays(29)->startOfDay();
            $diagnosaByDate = DB::table('diagnosa')
                ->where('id_user', $auth['id'])
                ->whereDate('tanggal_diagnosa', '>=', $thirtyDaysAgo->format('Y-m-d'))
                ->selectRaw('DATE(tanggal_diagnosa) as date, COUNT(*) as count')
                ->groupByRaw('DATE(tanggal_diagnosa)')
                ->pluck('count', 'date')
                ->all();

            // 7 Days (Default)
            $chartLabels = [];
            $chartSeries = [];
            for ($i = 6; $i >= 0; $i--) {
                $day = (clone $today)->subDays($i)->startOfDay();
                $chartLabels[] = $day->format('d/m');
                $dateKey = $day->format('Y-m-d');
                $countVal = 0;
                foreach ($diagnosaByDate as $k => $v) {
                    if (str_starts_with($k, $dateKey)) {
                        $countVal = $v;
                        break;
                    }
                }
                $chartSeries[] = (int) $countVal;
            }

            // 3 Days
            $threeDaysLabels = [];
            $threeDaysSeries = [];
            for ($i = 2; $i >= 0; $i--) {
                $day = (clone $today)->subDays($i)->startOfDay();
                $threeDaysLabels[] = $day->format('d/m');
                $dateKey = $day->format('Y-m-d');
                $countVal = 0;
                foreach ($diagnosaByDate as $k => $v) {
                    if (str_starts_with($k, $dateKey)) {
                        $countVal = $v;
                        break;
                    }
                }
                $threeDaysSeries[] = (int) $countVal;
            }

            // Hari Ini (Hourly Buckets for Today)
            $todayStart = (clone $today)->startOfDay();
            $diagnosaToday = DB::table('diagnosa')
                ->where('id_user', $auth['id'])
                ->where('tanggal_diagnosa', '>=', $todayStart->format('Y-m-d H:i:s'))
                ->selectRaw('CAST(EXTRACT(HOUR FROM tanggal_diagnosa) AS INTEGER) as hour, COUNT(*) as count')
                ->groupByRaw('EXTRACT(HOUR FROM tanggal_diagnosa)')
                ->pluck('count', 'hour')
                ->all();

            $todayLabels = ['06:00', '09:00', '12:00', '15:00', '18:00', '21:00'];
            $todaySeries = [];
            $hoursRange = [
                '06:00' => [6, 7, 8],
                '09:00' => [9, 10, 11],
                '12:00' => [12, 13, 14],
                '15:00' => [15, 16, 17],
                '18:00' => [18, 19, 20],
                '21:00' => [21, 22, 23, 0, 1, 2, 3, 4, 5],
            ];
            foreach ($todayLabels as $lbl) {
                $sum = 0;
                foreach ($hoursRange[$lbl] as $h) {
                    $sum += (int) ($diagnosaToday[$h] ?? 0);
                }
                $todaySeries[] = $sum;
            }

            // 1 Bulan Terakhir / Per Bulan (Months of the year)
            $thisYearStart = (clone $today)->subMonths(11)->startOfMonth();
            $diagnosaByMonth = DB::table('diagnosa')
                ->where('id_user', $auth['id'])
                ->where('tanggal_diagnosa', '>=', $thisYearStart->format('Y-m-d'))
                ->selectRaw('TO_CHAR(tanggal_diagnosa, \'YYYY-MM\') as ym, COUNT(*) as count')
                ->groupByRaw('TO_CHAR(tanggal_diagnosa, \'YYYY-MM\')')
                ->pluck('count', 'ym')
                ->all();

            $monthLabels = [];
            $monthSeries = [];
            $indonesianMonths = [
                1 => 'Jan', 2 => 'Feb', 3 => 'Mar', 4 => 'Apr', 5 => 'Mei', 6 => 'Jun',
                7 => 'Jul', 8 => 'Ags', 9 => 'Sep', 10 => 'Okt', 11 => 'Nov', 12 => 'Des'
            ];
            for ($i = 11; $i >= 0; $i--) {
                $monthObj = (clone $today)->subMonths($i)->startOfMonth();
                $ymKey = $monthObj->format('Y-m');
                $monthNum = (int) $monthObj->format('n');
                $monthLabels[] = $indonesianMonths[$monthNum];
                $monthSeries[] = (int) ($diagnosaByMonth[$ymKey] ?? 0);
            }

            // 3. Optimize donut queries directly in SQL
            $donutCounts = DB::table('diagnosa')
                ->where('id_user', $auth['id'])
                ->selectRaw("
                    COUNT(CASE WHEN confidence >= 0.8 THEN 1 END) as berat,
                    COUNT(CASE WHEN confidence >= 0.5 AND confidence < 0.8 THEN 1 END) as sedang,
                    COUNT(CASE WHEN confidence < 0.5 OR confidence IS NULL THEN 1 END) as ringan
                ")
                ->first();

            $donut = [
                'ringan' => (int) ($donutCounts->ringan ?? 0),
                'sedang' => (int) ($donutCounts->sedang ?? 0),
                'berat' => (int) ($donutCounts->berat ?? 0),
            ];

        } catch (\Throwable $e) {
            $dbError = true;
        }

        $kodes = $rows->pluck('hasil_penyakit')->filter()->unique()->values()->all();
        $namaByKode = [];
        if ($kodes !== []) {
            $namaByKode = DB::table('penyakit')->whereIn('kode_penyakit', $kodes)->pluck('nama_penyakit', 'kode_penyakit')->all();
        }

        return view('user.dashboard', compact(
            'auth',
            'count',
            'rows',
            'namaByKode',
            'dbError',
            'gejalaMaster',
            'penyakitMaster',
            'chartLabels',
            'chartSeries',
            'threeDaysLabels',
            'threeDaysSeries',
            'todayLabels',
            'todaySeries',
            'monthLabels',
            'monthSeries',
            'donut',
        ));
    }
}
