@extends('layouts.dashboard')
@section('title', 'Dashboard')
@section('content')
@php $tag = config('app.tagline', ''); @endphp
<div class="mx-auto max-w-7xl space-y-6 sm:space-y-8">
    <div class="flex flex-col gap-2 lg:flex-row lg:items-end lg:justify-between">
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-[#152238] sm:text-3xl">Dashboard</h1>
            <p class="mt-1 max-w-3xl text-[15px] leading-relaxed text-slate-600">{{ $tag }}</p>
            <p class="mt-2 text-sm font-medium text-slate-500">Halo, <span class="text-slate-800">{{ $auth['nama_lengkap'] }}</span></p>
        </div>
    </div>
        @if (!empty($dbError))
            <p class="mt-3 rounded-xl border border-amber-200 bg-amber-50 px-4 py-2 text-sm text-amber-900">Database belum merespons. Coba refresh beberapa saat lagi.</p>
        @endif
    </div>

    <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
        {{-- Card 1: Total Diagnosa Anda --}}
        <div class="flex gap-4 rounded-2xl border border-slate-200/90 bg-white p-5 shadow-[0_4px_24px_rgba(15,23,42,0.06)]">
            <div class="flex h-14 w-14 shrink-0 items-center justify-center rounded-2xl bg-blue-600 text-white shadow-lg shadow-blue-600/35"><i class="fa-solid fa-stethoscope text-2xl"></i></div>
            <div class="min-w-0">
                <p class="text-2xl font-bold tabular-nums text-slate-900">{{ $count }}</p>
                <p class="mt-0.5 text-[13px] font-bold text-slate-700 truncate">Total Diagnosa</p>
                <p class="text-[11px] text-slate-400 font-medium truncate">Riwayat Anda</p>
            </div>
        </div>
        {{-- Card 2: Gejala di Basis Data --}}
        <div class="flex gap-4 rounded-2xl border border-slate-200/90 bg-white p-5 shadow-[0_4px_24px_rgba(15,23,42,0.06)]">
            <div class="flex h-14 w-14 shrink-0 items-center justify-center rounded-2xl bg-emerald-600 text-white shadow-lg shadow-emerald-600/35"><i class="bi bi-tools text-2xl"></i></div>
            <div class="min-w-0">
                <p class="text-2xl font-bold tabular-nums text-slate-900">{{ $gejalaMaster }}</p>
                <p class="mt-0.5 text-[13px] font-bold text-slate-700 truncate">Gejala Terdata</p>
                <p class="text-[11px] text-slate-400 font-medium truncate">Basis Pengetahuan</p>
            </div>
        </div>
        {{-- Card 3: Jenis Kerusakan Terdata --}}
        <div class="flex gap-4 rounded-2xl border border-slate-200/90 bg-white p-5 shadow-[0_4px_24px_rgba(15,23,42,0.06)]">
            <div class="flex h-14 w-14 shrink-0 items-center justify-center rounded-2xl bg-amber-500 text-white shadow-lg shadow-amber-500/35"><i class="bi bi-display text-2xl"></i></div>
            <div class="min-w-0">
                <p class="text-2xl font-bold tabular-nums text-slate-900">{{ $penyakitMaster }}</p>
                <p class="mt-0.5 text-[13px] font-bold text-slate-700 truncate">Jenis Kerusakan</p>
                <p class="text-[11px] text-slate-400 font-medium truncate">Dapat Didiagnosa</p>
            </div>
        </div>
        {{-- Card 4: Metode Inferensi --}}
        <div class="flex gap-4 rounded-2xl border border-slate-200/90 bg-white p-5 shadow-[0_4px_24px_rgba(15,23,42,0.06)]">
            <div class="flex h-14 w-14 shrink-0 items-center justify-center rounded-2xl bg-violet-600 text-white shadow-lg shadow-violet-600/35"><i class="bi bi-clipboard-check text-2xl"></i></div>
            <div class="min-w-0">
                <p class="text-sm font-bold leading-snug text-slate-800">Forward Chaining</p>
                <p class="mt-1 text-[13px] font-bold text-slate-700 truncate">Metode Pakar</p>
                <p class="text-[11px] text-slate-400 font-medium truncate">Pelacakan Gejala</p>
            </div>
        </div>
    </div>

    <div class="grid gap-5 lg:grid-cols-2">
        <div class="rounded-2xl border border-slate-200/90 bg-white p-5 shadow-[0_4px_24px_rgba(15,23,42,0.06)] flex flex-col justify-between h-full">
            <h2 class="text-lg font-bold tracking-tight text-[#152238] shrink-0">Informasi Sistem</h2>
            <div class="mt-2.5 flex-1 flex flex-col md:flex-row items-center gap-6">
                <div class="w-full md:w-1/2">
                    <p class="text-[14px] leading-relaxed text-slate-600 sm:text-[15px]">Sistem pakar ini digunakan untuk membantu pengguna dalam mendiagnosa kerusakan pada printer yang ada di Fotocopy Berkah Andirra menggunakan metode Forward Chaining.</p>
                    <p class="mt-2 text-xs text-slate-500">Gunakan menu <span class="font-semibold text-slate-700">Diagnosa Kerusakan</span> untuk memulai. Riwayat hasil Anda tersimpan otomatis.</p>
                </div>
                <div class="w-full md:w-1/2 flex justify-center">
                    <img src="{{ asset('images/printer.jpg') }}" alt="Printer" class="h-28 w-auto object-contain" decoding="async">
                </div>
            </div>
        </div>
        <div class="rounded-2xl border border-slate-200/90 bg-white p-6 shadow-[0_4px_24px_rgba(15,23,42,0.06)] sm:p-7">
            <h2 class="text-lg font-bold tracking-tight text-[#152238]">Riwayat terbaru</h2>
            <div class="mt-4 overflow-x-auto rounded-xl border border-slate-100">
                <table class="w-full min-w-[480px] text-sm">
                    <thead class="bg-slate-100/90 text-left text-xs font-bold uppercase tracking-wide text-slate-600">
                        <tr><th class="px-4 py-3">Tanggal</th><th class="px-4 py-3">Hasil</th><th class="px-4 py-3">%</th></tr>
                    </thead>
                    <tbody>
                        @forelse ($rows as $r)
                            <tr class="border-t border-slate-100 odd:bg-white even:bg-slate-50/80">
                                <td class="px-4 py-3 text-slate-600">{{ format_date_id($r->tanggal_diagnosa) }}</td>
                                <td class="px-4 py-3 font-medium text-slate-800">{{ $r->hasil_penyakit ? ($namaByKode[$r->hasil_penyakit] ?? $r->hasil_penyakit) : '—' }}</td>
                                <td class="px-4 py-3 text-slate-600">{{ $r->confidence !== null ? number_format($r->confidence * 100, 1) : '—' }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="3" class="px-4 py-8 text-center text-slate-500">Belum ada diagnosa</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <a href="/user/diagnosa" class="mt-4 inline-flex items-center gap-2 text-sm font-semibold text-brand-600 hover:text-brand-700">Mulai diagnosa <i class="bi bi-arrow-right"></i></a>
        </div>
    </div>

    <div class="grid gap-5 lg:grid-cols-2">
        <div class="rounded-2xl border border-slate-200/90 bg-white p-6 shadow-[0_4px_24px_rgba(15,23,42,0.06)] sm:p-7">
            <div class="flex items-center justify-between gap-4">
                <h2 class="text-lg font-bold tracking-tight text-[#152238]">Statistik Diagnosa <span class="text-sm font-medium text-slate-400 leading-none" id="chartRangeText">(7 Hari Terakhir)</span></h2>
                <div class="relative shrink-0">
                    <select id="chartRangeSelect" class="appearance-none rounded-xl border border-slate-200 bg-white pl-4 pr-10 py-1.5 text-xs font-semibold text-slate-600 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500">
                        <option value="7_days" selected>7 Hari Terakhir</option>
                        <option value="3_days">3 Hari Terakhir</option>
                        <option value="today">Hari Ini</option>
                        <option value="month">1 Bulan Terakhir</option>
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3 text-slate-400">
                        <i class="bi bi-chevron-down text-[10px]"></i>
                    </div>
                </div>
            </div>
            <div class="mt-6 h-60"><canvas id="chartLineUser"></canvas></div>
        </div>
        <div class="rounded-2xl border border-slate-200/90 bg-white p-6 shadow-[0_4px_24px_rgba(15,23,42,0.06)] sm:p-7">
            <h2 class="text-lg font-bold tracking-tight text-[#152238]">Diagnosa Berdasarkan Tingkat Kerusakan</h2>
            <div class="mt-6 flex flex-col items-center justify-center gap-6 sm:flex-row sm:gap-8">
                {{-- Donut Chart Wrapper --}}
                <div class="relative h-44 w-44 shrink-0 flex items-center justify-center">
                    <canvas id="chartDonutUser"></canvas>
                    <div class="absolute flex flex-col items-center justify-center text-center">
                        <span class="text-4xl font-black text-slate-800 leading-none" id="donutTotalCount">0</span>
                        <span class="text-[11px] font-bold text-slate-400 mt-1.5 uppercase tracking-wider">Total</span>
                    </div>
                </div>
                {{-- Custom Legend --}}
                <div class="flex-1 space-y-4 min-w-[150px]">
                    <div class="flex items-start gap-3">
                        <span class="mt-1 h-4 w-4 shrink-0 rounded-md bg-[#ef4444]"></span>
                        <div>
                            <p class="text-sm font-bold text-slate-800 leading-tight">Berat</p>
                            <p class="text-[13px] text-slate-500 font-semibold mt-1" id="legendBeratVal">0 (0%)</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-3">
                        <span class="mt-1 h-4 w-4 shrink-0 rounded-md bg-[#f59e0b]"></span>
                        <div>
                            <p class="text-sm font-bold text-slate-800 leading-tight">Sedang</p>
                            <p class="text-[13px] text-slate-500 font-semibold mt-1" id="legendSedangVal">0 (0%)</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-3">
                        <span class="mt-1 h-4 w-4 shrink-0 rounded-md bg-[#22c55e]"></span>
                        <div>
                            <p class="text-sm font-bold text-slate-800 leading-tight">Ringan</p>
                            <p class="text-[13px] text-slate-500 font-semibold mt-1" id="legendRinganVal">0 (0%)</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@push('scripts')
<script>
    const datasets = {
        'today': {
            labels: @json($todayLabels),
            data: @json($todaySeries),
            title: '(Hari Ini)'
        },
        '3_days': {
            labels: @json($threeDaysLabels),
            data: @json($threeDaysSeries),
            title: '(3 Hari Terakhir)'
        },
        '7_days': {
            labels: @json($chartLabels),
            data: @json($chartSeries),
            title: '(7 Hari Terakhir)'
        },
        'month': {
            labels: @json($monthLabels),
            data: @json($monthSeries),
            title: '(1 Bulan Terakhir)'
        }
    };
    const donut = @json($donut);
    const totalD = donut.ringan + donut.sedang + donut.berat;
    if (typeof Chart !== 'undefined' && document.getElementById('chartLineUser')) {
        const chartLine = new Chart(document.getElementById('chartLineUser'), {
            type: 'line',
            data: {
                labels: datasets['7_days'].labels,
                datasets: [{
                    label: 'Jumlah Diagnosa',
                    data: datasets['7_days'].data,
                    borderColor: '#2563eb',
                    borderWidth: 2.5,
                    backgroundColor: 'rgba(37, 99, 235, 0.08)',
                    fill: true,
                    tension: 0.35,
                    pointRadius: 4,
                    pointBackgroundColor: '#2563eb',
                    pointBorderColor: '#ffffff',
                    pointBorderWidth: 2,
                    pointHoverRadius: 6,
                    pointHoverBorderWidth: 3,
                }],
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: true,
                        position: 'bottom',
                        align: 'start',
                        labels: {
                            boxWidth: 16,
                            boxHeight: 6,
                            useBorderRadius: true,
                            borderRadius: 3,
                            font: {
                                size: 11,
                                weight: 'semibold',
                                family: 'system-ui'
                            },
                            padding: 15
                        }
                    }
                },
                scales: {
                    x: {
                        grid: { display: false }
                    },
                    y: {
                        beginAtZero: true,
                        grid: { color: '#f1f5f9' },
                        ticks: { precision: 0 }
                    }
                },
            },
        });

        document.getElementById('chartRangeSelect').addEventListener('change', function(e) {
            const val = e.target.value;
            const set = datasets[val];
            if (set) {
                document.getElementById('chartRangeText').innerText = set.title;
                chartLine.data.labels = set.labels;
                chartLine.data.datasets[0].data = set.data;
                chartLine.update();
            }
        });
    }
    if (document.getElementById('chartDonutUser') && typeof Chart !== 'undefined') {
        new Chart(document.getElementById('chartDonutUser'), {
            type: 'doughnut',
            data: {
                labels: ['Ringan', 'Sedang', 'Berat'],
                datasets: [{
                    data: totalD ? [donut.ringan, donut.sedang, donut.berat] : [1],
                    backgroundColor: totalD ? ['#22c55e', '#f59e0b', '#ef4444'] : ['#e2e8f0'],
                    borderWidth: 0,
                }],
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '70%',
                plugins: { legend: { display: false } },
            },
        });

        const pctBerat = totalD ? Math.round((donut.berat / totalD) * 100) : 0;
        const pctSedang = totalD ? Math.round((donut.sedang / totalD) * 100) : 0;
        const pctRingan = totalD ? Math.round((donut.ringan / totalD) * 100) : 0;
        document.getElementById('donutTotalCount').innerText = totalD;
        document.getElementById('legendBeratVal').innerText = `${donut.berat} (${pctBerat}%)`;
        document.getElementById('legendSedangVal').innerText = `${donut.sedang} (${pctSedang}%)`;
        document.getElementById('legendRinganVal').innerText = `${donut.ringan} (${pctRingan}%)`;
    }
</script>
@endpush
@endsection
