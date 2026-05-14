@extends('layouts.dashboard')
@section('title', 'Dashboard')
@section('content')
<div class="mx-auto max-w-7xl space-y-6 sm:space-y-8">
    <div>
        <h1 class="text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl">Selamat datang, {{ $auth['nama_lengkap'] }}!</h1>
        <p class="mt-1.5 text-[15px] leading-relaxed text-slate-500">Ringkasan aktivitas diagnosa printer Anda.</p>
        @if (!empty($dbError))
            <p class="mt-3 rounded-xl border border-amber-200 bg-amber-50 px-4 py-2 text-sm text-amber-900">Database belum merespons. Coba refresh beberapa saat lagi.</p>
        @endif
    </div>

    <div class="grid gap-5 sm:grid-cols-2 xl:grid-cols-4">
        <div class="flex gap-4 rounded-2xl border border-slate-200/90 bg-white p-5 shadow-sm">
            <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-blue-600 text-white shadow-lg shadow-blue-600/30"><i class="bi bi-clipboard-data text-xl"></i></div>
            <div>
                <p class="text-xs font-medium uppercase tracking-wide text-slate-500">Total diagnosa Anda</p>
                <p class="mt-1 text-2xl font-bold text-slate-900">{{ $count }}</p>
            </div>
        </div>
        <div class="flex gap-4 rounded-2xl border border-slate-200/90 bg-white p-5 shadow-sm">
            <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-emerald-600 text-white shadow-lg shadow-emerald-600/30"><i class="bi bi-clipboard2-pulse text-xl"></i></div>
            <div>
                <p class="text-xs font-medium uppercase tracking-wide text-slate-500">Gejala di basis data</p>
                <p class="mt-1 text-2xl font-bold text-slate-900">{{ $gejalaMaster }}</p>
            </div>
        </div>
        <div class="flex gap-4 rounded-2xl border border-slate-200/90 bg-white p-5 shadow-sm">
            <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-amber-500 text-white shadow-lg shadow-amber-500/30"><i class="bi bi-exclamation-octagon text-xl"></i></div>
            <div>
                <p class="text-xs font-medium uppercase tracking-wide text-slate-500">Jenis kerusakan terdata</p>
                <p class="mt-1 text-2xl font-bold text-slate-900">{{ $penyakitMaster }}</p>
            </div>
        </div>
        <div class="flex gap-4 rounded-2xl border border-slate-200/90 bg-white p-5 shadow-sm">
            <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-violet-600 text-white shadow-lg shadow-violet-600/30"><i class="bi bi-diagram-3 text-xl"></i></div>
            <div>
                <p class="text-xs font-medium uppercase tracking-wide text-slate-500">Forward chaining</p>
                <p class="mt-1 text-sm font-semibold leading-snug text-slate-700">Gejala → kesimpulan kerusakan</p>
            </div>
        </div>
    </div>

    <div class="grid gap-5 lg:grid-cols-2">
        <div class="rounded-2xl border border-slate-200/90 bg-white p-6 shadow-sm sm:p-7">
            <h2 class="text-lg font-bold tracking-tight text-slate-900">Informasi sistem</h2>
            <p class="mt-3 text-[15px] leading-relaxed text-slate-600">
                Pilih gejala yang Anda amati pada printer. Sistem mencocokkan dengan basis pengetahuan (relasi gejala–kerusakan) dan menampilkan hasil beserta tingkat kepercayaan.
            </p>
            <div class="mt-6 flex flex-col items-center justify-center gap-4 rounded-2xl bg-slate-50/90 px-6 py-8 sm:flex-row sm:py-7">
                <img src="{{ asset('images/printer.jpg') }}" alt="" class="h-28 w-auto max-w-[200px] shrink-0 object-contain sm:h-32" width="200" height="200" decoding="async">
                <p class="max-w-sm text-center text-[14px] leading-relaxed text-slate-600 sm:text-left">Gunakan menu <span class="font-semibold text-slate-800">Diagnosa Kerusakan</span> untuk memulai. Riwayat hasil tersimpan otomatis.</p>
            </div>
        </div>
        <div class="rounded-2xl border border-slate-200/90 bg-white p-6 shadow-sm sm:p-7">
            <h2 class="text-lg font-bold tracking-tight text-slate-900">Riwayat terbaru</h2>
            <div class="mt-4 overflow-x-auto rounded-xl border border-slate-100">
                <table class="w-full min-w-[480px] text-sm">
                    <thead class="bg-slate-50 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">
                        <tr><th class="px-4 py-3">Tanggal</th><th class="px-4 py-3">Hasil</th><th class="px-4 py-3">%</th></tr>
                    </thead>
                    <tbody>
                        @forelse ($rows as $r)
                            <tr class="border-t border-slate-100">
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
        <div class="rounded-2xl border border-slate-200/90 bg-white p-6 shadow-sm sm:p-7">
            <h2 class="text-lg font-bold tracking-tight text-slate-900">Statistik diagnosa (7 hari)</h2>
            <p class="text-xs text-slate-500">Jumlah diagnosa per hari — akun Anda</p>
            <div class="mt-4 h-64"><canvas id="chartLineUser"></canvas></div>
        </div>
        <div class="rounded-2xl border border-slate-200/90 bg-white p-6 shadow-sm sm:p-7">
            <h2 class="text-lg font-bold tracking-tight text-slate-900">Berdasarkan tingkat (kepercayaan)</h2>
            <p class="text-xs text-slate-500">Ringan &lt;50% · Sedang 50–79% · Berat ≥80%</p>
            <div class="mx-auto mt-2 h-56 max-w-xs"><canvas id="chartDonutUser"></canvas></div>
        </div>
    </div>
</div>
@push('scripts')
<script>
    const labels = @json($chartLabels);
    const series = @json($chartSeries);
    const donut = @json($donut);
    const totalD = donut.ringan + donut.sedang + donut.berat;
    if (typeof Chart !== 'undefined' && document.getElementById('chartLineUser')) {
        new Chart(document.getElementById('chartLineUser'), {
            type: 'line',
            data: {
                labels,
                datasets: [{
                    label: 'Diagnosa',
                    data: series,
                    borderColor: '#2563eb',
                    backgroundColor: 'rgba(37,99,235,0.12)',
                    fill: true,
                    tension: 0.35,
                    pointRadius: 4,
                }],
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    y: { beginAtZero: true, ticks: { precision: 0 } },
                },
            },
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
                plugins: {
                    legend: { position: 'bottom', labels: { boxWidth: 12, font: { size: 11 } } },
                },
            },
        });
    }
</script>
@endpush
@endsection
