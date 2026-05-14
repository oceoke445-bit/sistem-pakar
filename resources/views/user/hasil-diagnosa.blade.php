@extends('layouts.dashboard')
@section('title', 'Hasil Diagnosa')
@section('content')
@php
    $tingkat = diagnosis_tingkat_label($d->confidence !== null ? (float) $d->confidence : null);
    $tingkatClass = $tingkat === 'Berat' ? 'bg-red-100 text-red-800' : ($tingkat === 'Sedang' ? 'bg-amber-100 text-amber-900' : 'bg-emerald-100 text-emerald-800');
    $penyebabLines = $penyakit && $penyakit->deskripsi ? array_filter(preg_split('/\r\n|\r|\n/', trim($penyakit->deskripsi))) : [];
    $solusiLines = $penyakit && $penyakit->solusi ? array_filter(preg_split('/\r\n|\r|\n/', trim($penyakit->solusi))) : [];
@endphp
<div class="mx-auto max-w-4xl space-y-8">
    <div class="flex flex-col gap-3 sm:flex-row sm:flex-wrap sm:items-center sm:gap-3">
        <div class="flex items-center gap-2 rounded-full border border-slate-200 bg-white px-4 py-2 text-sm font-medium text-slate-500">
            <span class="flex h-7 w-7 items-center justify-center rounded-full bg-slate-200 text-xs font-bold text-slate-600">1</span>
            Pilih Gejala
        </div>
        <i class="bi bi-chevron-right text-slate-300"></i>
        <div class="flex items-center gap-2 rounded-full border border-blue-600 bg-blue-50 px-4 py-2 text-sm font-medium text-blue-800">
            <span class="flex h-7 w-7 items-center justify-center rounded-full bg-blue-600 text-xs font-bold text-white">2</span>
            Hasil Diagnosa
        </div>
        <div class="flex flex-wrap items-center gap-2 sm:ml-auto">
            <button type="button" onclick="window.print()" class="inline-flex items-center gap-2 rounded-xl border border-slate-200 bg-white px-4 py-2 text-sm font-semibold text-slate-700 shadow-sm hover:bg-slate-50">
                <i class="bi bi-printer"></i> Cetak hasil
            </button>
        </div>
    </div>

    <div class="overflow-hidden rounded-2xl border border-slate-200/90 bg-white shadow-sm print:border-0 print:shadow-none">
        <div class="grid gap-0 lg:grid-cols-[minmax(0,1fr)_200px]">
            <div class="border-b border-slate-100 bg-slate-50/80 px-5 py-7 sm:px-8 sm:py-8 print:bg-white lg:border-b-0 lg:border-r lg:border-slate-100">
                <div class="flex flex-col gap-4 sm:flex-row sm:items-start">
                    <div class="flex h-16 w-16 shrink-0 items-center justify-center rounded-2xl bg-red-50 text-red-500">
                        <i class="bi bi-exclamation-octagon text-3xl"></i>
                    </div>
                    <div class="min-w-0 flex-1">
                        <p class="text-[11px] font-bold uppercase tracking-[0.2em] text-slate-500">Kerusakan teridentifikasi</p>
                        @if ($penyakit)
                            <h1 class="mt-2 text-2xl font-bold leading-tight tracking-tight text-red-600 sm:text-3xl">{{ $penyakit->nama_penyakit }}</h1>
                        @else
                            <h1 class="mt-2 text-2xl font-bold tracking-tight text-slate-700">Tidak ada hasil spesifik</h1>
                        @endif
                        <div class="mt-3 flex flex-wrap items-center gap-2">
                            <span class="inline-flex items-center rounded-full px-3 py-1 text-xs font-bold {{ $tingkatClass }}">Tingkat: {{ $tingkat }}</span>
                            @if ($pct !== null)
                                <span class="rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-700">Kecocokan {{ number_format($pct, 1) }}%</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="hidden flex-col items-center justify-center bg-gradient-to-b from-slate-50 to-white px-6 py-8 lg:flex print:hidden">
                <img src="{{ asset('images/printer.jpg') }}" alt="" class="h-auto w-full max-w-[160px] object-contain opacity-95" width="180" height="180" decoding="async">
                <p class="mt-3 text-center text-xs font-medium leading-snug text-slate-500">Periksa kabel, tinta, dan driver setelah perbaikan.</p>
            </div>
        </div>

        <div class="flex justify-center border-b border-slate-100 bg-gradient-to-r from-slate-50 via-white to-slate-50 py-5 lg:hidden print:hidden">
            <img src="{{ asset('images/printer.jpg') }}" alt="" class="h-24 w-auto max-w-[200px] object-contain" width="200" height="200" decoding="async">
        </div>

        <div class="space-y-8 px-5 py-7 sm:px-8 sm:py-8">
            @if (count($penyebabLines))
                <div>
                    <h2 class="text-sm font-bold uppercase tracking-wide text-slate-500">Penyebab</h2>
                    <ul class="mt-3 list-disc space-y-2 pl-5 text-sm leading-relaxed text-slate-700">
                        @foreach ($penyebabLines as $line)
                            <li>{{ $line }}</li>
                        @endforeach
                    </ul>
                </div>
            @elseif ($penyakit && $penyakit->deskripsi)
                <div>
                    <h2 class="text-sm font-bold uppercase tracking-wide text-slate-500">Penyebab</h2>
                    <p class="mt-3 text-sm leading-relaxed text-slate-700">{{ $penyakit->deskripsi }}</p>
                </div>
            @endif

            @if (count($solusiLines))
                <div>
                    <h2 class="text-sm font-bold uppercase tracking-wide text-slate-500">Solusi</h2>
                    <ul class="mt-3 list-disc space-y-2 pl-5 text-sm leading-relaxed text-slate-700">
                        @foreach ($solusiLines as $line)
                            <li>{{ $line }}</li>
                        @endforeach
                    </ul>
                </div>
            @elseif ($penyakit && $penyakit->solusi)
                <div>
                    <h2 class="text-sm font-bold uppercase tracking-wide text-slate-500">Solusi</h2>
                    <p class="mt-3 text-sm leading-relaxed text-slate-700">{{ $penyakit->solusi }}</p>
                </div>
            @endif

            <div>
                <h2 class="text-sm font-bold uppercase tracking-wide text-slate-500">Gejala yang dipilih</h2>
                <ul class="mt-3 flex flex-wrap gap-2">
                    @foreach ($kodes as $k)
                        <li class="rounded-full border border-slate-200 bg-slate-50 px-3 py-1 text-xs font-medium text-slate-700">{{ $namaGejala[$k] ?? $k }}</li>
                    @endforeach
                </ul>
            </div>

            <div class="grid gap-4 sm:grid-cols-2">
                <div class="rounded-2xl border border-emerald-200 bg-emerald-50/60 p-5">
                    <p class="font-semibold text-emerald-900">Perbaikan sendiri</p>
                    <p class="mt-2 text-sm text-emerald-900/80">Ikuti langkah solusi di atas jika kondisi aman dan Anda memiliki perlengkapan dasar.</p>
                    <a href="/user/riwayat" class="mt-4 inline-flex rounded-xl bg-emerald-600 px-4 py-2 text-sm font-semibold text-white hover:bg-emerald-700">Lihat riwayat</a>
                </div>
                <div class="rounded-2xl border border-amber-200 bg-amber-50/60 p-5">
                    <p class="font-semibold text-amber-900">Panggil teknisi</p>
                    <p class="mt-2 text-sm text-amber-900/85">Jika tingkat kerusakan berat atau Anda tidak yakin, hubungi teknisi resmi.</p>
                    <span class="mt-4 inline-flex cursor-default rounded-xl bg-amber-500 px-4 py-2 text-sm font-semibold text-white opacity-90">Hubungi teknisi</span>
                </div>
            </div>

            <div class="border-t border-slate-100 pt-6">
                <a href="/user/riwayat" class="text-sm font-semibold text-brand-600 hover:text-brand-700">Ke riwayat diagnosa →</a>
            </div>
        </div>
    </div>
</div>
@endsection
