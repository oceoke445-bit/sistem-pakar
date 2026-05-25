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

    <div class="overflow-x-auto rounded-2xl border border-slate-200/90 bg-white shadow-[0_4px_24px_rgba(15,23,42,0.06)]">
        <table class="w-full min-w-[640px] text-sm">
            <thead class="border-b border-slate-200 bg-slate-100/90 text-left text-xs font-bold uppercase tracking-wide text-slate-600">
                <tr>
                    <th class="px-4 py-3.5">No</th>
                    <th class="px-4 py-3.5">Tanggal</th>
                    <th class="px-4 py-3.5">Unit Printer</th>
                    <th class="px-4 py-3.5">Kerusakan</th>
                    <th class="px-4 py-3.5">Tingkat</th>
                    <th class="px-4 py-3.5">Tindakan</th>
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
                        static $dbPrinters = null;
                        if ($dbPrinters === null) {
                            $dbPrinters = DB::table('printers')->orderBy('id', 'asc')->get();
                        }
                        
                        if ($dbPrinters->isNotEmpty()) {
                            $idx = $r->id % $dbPrinters->count();
                            $p = $dbPrinters->values()->get($idx);
                            $printerName = $p->nama_printer . ' (' . $p->model . ')';
                        } else {
                            $printerName = 'Unit 1 (Canon IR 2425)';
                        }
                        
                        $dp = $r->hasil_penyakit ? ($diseasesMap[$r->hasil_penyakit] ?? null) : null;
                        $lbl = $dp ? $dp->tingkat : '—';
                        $lblClass = $lbl === 'Berat' ? 'text-red-650 font-bold' : ($lbl === 'Sedang' ? 'text-amber-600 font-bold' : ($lbl === 'Ringan' ? 'text-emerald-600 font-bold' : 'text-slate-500'));
                    @endphp
                    <tr class="border-t border-slate-100 odd:bg-white even:bg-slate-50/80">
                        <td class="px-4 py-3.5 text-slate-500">{{ $i + 1 }}</td>
                        <td class="whitespace-nowrap px-4 py-3.5 text-slate-600">{{ format_date_id($r->tanggal_diagnosa) }}</td>
                        <td class="px-4 py-3.5 font-semibold text-slate-700">{{ $printerName }}</td>
                        <td class="px-4 py-3.5 font-medium text-slate-900">{{ $r->hasil_penyakit ? ($namaPenyakit[$r->hasil_penyakit] ?? $r->hasil_penyakit) : '—' }}</td>
                        <td class="px-4 py-3.5 {{ $lblClass }}">{{ $lbl }}</td>
                        <td class="whitespace-nowrap px-4 py-3.5">
                            @if ($lbl === 'Ringan')
                                <a href="/user/riwayat/{{ $r->id }}" class="inline-flex items-center gap-1.5 rounded-xl border border-emerald-200 bg-emerald-50 px-3 py-1.5 text-xs font-bold text-emerald-700 shadow-sm hover:bg-emerald-100/70 transition-colors">
                                    Perbaikan Sendiri
                                </a>
                            @else
                                <a href="/user/riwayat/{{ $r->id }}" class="inline-flex items-center gap-1.5 rounded-xl border border-amber-200 bg-amber-50 px-3 py-1.5 text-xs font-bold text-amber-700 shadow-sm hover:bg-amber-100/70 transition-colors">
                                    Teknisi
                                </a>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        @if ($rows->isEmpty())
            <p class="px-4 py-12 text-center text-slate-500">Tidak ada data yang cocok.</p>
        @endif
    </div>

    @if ($rows->hasPages())
        <div class="flex items-center justify-center gap-4 py-6">
            {{-- Previous Page Link --}}
            @if ($rows->onFirstPage())
                <span class="inline-flex h-10 w-10 items-center justify-center text-slate-300 cursor-not-allowed">
                    <i class="bi bi-chevron-left text-[14px]"></i>
                </span>
            @else
                <a href="{{ $rows->previousPageUrl() }}" class="inline-flex h-10 w-10 items-center justify-center text-slate-400 hover:text-slate-600 transition-colors">
                    <i class="bi bi-chevron-left text-[14px]"></i>
                </a>
            @endif

            {{-- Page Numbers --}}
            @foreach (range(1, $rows->lastPage()) as $page)
                @if ($page == $rows->currentPage())
                    <span class="inline-flex h-10 w-10 items-center justify-center rounded-xl border-2 border-blue-200 bg-white font-bold text-blue-600 shadow-[0_2px_8px_rgba(59,130,246,0.08)]">
                        {{ $page }}
                    </span>
                @else
                    <a href="{{ $rows->url($page) }}" class="inline-flex h-10 w-10 items-center justify-center rounded-xl border border-slate-200 bg-white font-semibold text-slate-500 hover:bg-slate-50 transition-colors shadow-sm">
                        {{ $page }}
                    </a>
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($rows->hasMorePages())
                <a href="{{ $rows->nextPageUrl() }}" class="inline-flex h-10 w-10 items-center justify-center text-slate-400 hover:text-slate-600 transition-colors">
                    <i class="bi bi-chevron-right text-[14px]"></i>
                </a>
            @else
                <span class="inline-flex h-10 w-10 items-center justify-center text-slate-300 cursor-not-allowed">
                    <i class="bi bi-chevron-right text-[14px]"></i>
                </span>
            @endif
        </div>
    @endif
</div>
@endsection
