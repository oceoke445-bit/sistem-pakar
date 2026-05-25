@extends('layouts.dashboard')
@section('title', 'Riwayat')
@section('content')
@php $tingkat = $tingkat ?? ''; @endphp
<div class="mx-auto max-w-6xl space-y-6">
    <div>
        <h1 class="text-2xl font-bold tracking-tight text-[#152238] sm:text-3xl">Riwayat Diagnosa</h1>
        <p class="mt-1 text-[15px] text-slate-600">Daftar riwayat diagnosa kerusakan printer Anda.</p>
    </div>

    @if (request('notice'))
        <div class="rounded-xl border border-emerald-200 bg-emerald-50 p-4 text-sm text-emerald-900">{{ request('notice') }}</div>
    @endif

    <form method="get" action="/user/riwayat" class="flex flex-col gap-3 sm:flex-row sm:flex-wrap sm:items-end bg-transparent p-0 border-0 shadow-none">
        <div class="relative min-w-0 flex-1">
            <i class="bi bi-search pointer-events-none absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400"></i>
            <input type="search" name="q" value="{{ $q }}" placeholder="Cari riwayat…"
                   class="w-full rounded-xl border border-slate-200 bg-white py-3 pl-11 pr-4 text-sm outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 shadow-sm">
        </div>
        <div class="w-full sm:w-52">
            <label class="mb-1 block text-xs font-bold uppercase tracking-wide text-slate-500">Tingkat</label>
            <div class="relative w-full">
                <select name="tingkat" onchange="this.form.submit()" class="w-full appearance-none rounded-xl border border-slate-200 bg-white pl-4 pr-10 py-3 text-sm outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 shadow-sm">
                    <option value="" @selected($tingkat === '')>Semua tingkat</option>
                    <option value="ringan" @selected($tingkat === 'ringan')>Ringan</option>
                    <option value="sedang" @selected($tingkat === 'sedang')>Sedang</option>
                    <option value="berat" @selected($tingkat === 'berat')>Berat</option>
                </select>
                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3.5 text-slate-400">
                    <i class="bi bi-chevron-down text-xs"></i>
                </div>
            </div>
        </div>
        @if ($q !== '' || $tingkat !== '')
            <a href="/user/riwayat" class="rounded-xl border border-slate-200 bg-white px-5 py-3 text-center text-sm font-semibold text-slate-600 hover:bg-slate-50 shadow-sm transition-colors">Reset</a>
        @endif
    </form>

    <div class="overflow-hidden rounded-2xl border border-slate-200/90 bg-white shadow-[0_4px_24px_rgba(15,23,42,0.06)]">
        <div class="overflow-x-auto">
        <table class="w-full min-w-[640px] text-sm">
            <thead class="border-b border-slate-200 bg-slate-100/90 text-left text-xs font-bold uppercase tracking-wide text-slate-600">
                <tr>
                    <th class="px-4 py-3.5">No</th>
                    <th class="px-4 py-3.5">Tanggal</th>
                    <th class="px-4 py-3.5">Gejala yang Dipilih</th>
                    <th class="px-4 py-3.5">Hasil Kerusakan</th>
                    <th class="px-4 py-3.5">Tingkat</th>
                    <th class="px-4 py-3.5">Tindakan</th>
                    <th class="px-4 py-3.5 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @php
                    static $diseasesMap = null;
                    if ($diseasesMap === null) {
                        $diseasesMap = DB::table('penyakit')->get()->keyBy('kode_penyakit')->all();
                    }
                @endphp
                @foreach ($rows as $i => $r)
                    @php
                        $dp = $r->hasil_penyakit ? ($diseasesMap[$r->hasil_penyakit] ?? null) : null;
                        $hasilKerusakan = $dp ? $dp->nama_penyakit : ($r->hasil_penyakit ?: null);
                        $lbl = $dp ? $dp->tingkat : '—';
                        $lblClass = $lbl === 'Berat' ? 'text-red-650 font-bold' : ($lbl === 'Sedang' ? 'text-amber-600 font-bold' : ($lbl === 'Ringan' ? 'text-emerald-600 font-bold' : 'text-slate-500'));
                    @endphp
                    <tr class="border-t border-slate-100 odd:bg-white even:bg-slate-50/80">
                        <td class="px-4 py-3.5 text-slate-500">{{ $rows->firstItem() + $i }}</td>
                        <td class="whitespace-nowrap px-4 py-3.5 text-slate-600">{{ format_date_id($r->tanggal_diagnosa) }}</td>
                        <td class="px-4 py-3.5">
                            @include('partials.gejala-kode-badges', [
                                'kodes' => $gejalaByDiagnosa[$r->id] ?? [],
                                'namaGejala' => $namaGejala ?? [],
                            ])
                        </td>
                        <td class="px-4 py-3.5 align-top">
                            @include('partials.hasil-kerusakan-badge', ['label' => $hasilKerusakan])
                        </td>
                        <td class="px-4 py-3.5 {{ $lblClass }}">{{ $lbl }}</td>
                        <td class="whitespace-nowrap px-4 py-3.5">
                            @include('partials.diagnosa-tindakan-badge', [
                                'tindakan' => $r->tindakan ?? null,
                            ])
                        </td>
                        <td class="whitespace-nowrap px-4 py-3.5">
                            <div class="flex items-center justify-end gap-2">
                            <a href="/user/riwayat/{{ $r->id }}"
                               class="inline-flex shrink-0 rounded-lg border border-slate-200 bg-white px-3 py-1.5 text-xs font-semibold text-slate-600 transition hover:border-slate-300 hover:bg-slate-50">
                                Detail
                            </a>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        @if ($rows->isEmpty())
            <p class="px-4 py-12 text-center text-slate-500">Tidak ada data yang cocok.</p>
        @endif
        </div>
        @include('partials.pagination', ['paginator' => $rows])
    </div>
</div>
@endsection
