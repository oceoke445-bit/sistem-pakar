@extends('layouts.dashboard')
@section('title', 'Detail Riwayat')
@section('content')

@php
    $tingkat = $penyakit && $penyakit->tingkat ? $penyakit->tingkat : 'Sedang';
    $solusiLines = $penyakit && $penyakit->solusi ? array_filter(preg_split('/\r\n|\r|\n/', trim($penyakit->solusi))) : [];
@endphp

<div class="mx-auto max-w-5xl space-y-6">
    <!-- Header Block -->
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <a href="/user/riwayat" class="inline-flex items-center gap-1.5 text-sm font-bold text-slate-500 hover:text-slate-700 transition-colors mb-2">
                <i class="bi bi-arrow-left"></i> Kembali ke Riwayat
            </a>
            <h1 class="text-2xl font-bold tracking-tight text-[#152238] sm:text-3xl">Detail Riwayat Diagnosa</h1>
            <p class="mt-1 text-[15px] text-slate-600">Diagnosa #{{ $d->id }} — {{ format_date_id($d->tanggal_diagnosa) }}</p>
        </div>
        <div class="shrink-0 flex items-center gap-2 print:hidden">
            @include('partials.diagnosa-export-dropdown', ['diagnosaId' => $d->id])
            <form method="post" action="{{ route('user.riwayat.hapus') }}" onsubmit="event.preventDefault(); confirmDelete(this, 'Hapus Riwayat?', 'Apakah Anda yakin ingin menghapus riwayat diagnosa ini? Tindakan ini tidak dapat dibatalkan.');" class="inline">
                @csrf
                <input type="hidden" name="id" value="{{ $d->id }}">
                <button type="submit" class="inline-flex items-center gap-1.5 rounded-xl border border-red-200 bg-red-50 px-5 py-2.5 text-sm font-bold text-red-700 hover:bg-red-100/70 transition-colors shadow-sm">
                    <i class="bi bi-trash"></i> Hapus
                </button>
            </form>
        </div>
    </div>

    <!-- Main Results Container Card -->
    <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm sm:p-8 space-y-8 print:border-0 print:shadow-none">
        
        <!-- Red/Amber Header Box inside the main card -->
        <div class="rounded-2xl border border-red-100 bg-red-50/40 p-5 sm:p-6 print:bg-white print:border-0">
            <div class="flex flex-col gap-5 sm:flex-row sm:items-center">
                <!-- Printer Illustration icon -->
                <div class="shrink-0 flex justify-center">
                    <svg class="h-20 w-auto text-slate-800" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2" />
                        <rect x="6 14" width="12" height="8" rx="1" />
                        <path d="M6 9V4a1 1 0 0 1 1-1h10a1 1 0 0 1 1 1v5" />
                    </svg>
                </div>
                <!-- Damage details -->
                <div class="text-center sm:text-left space-y-2">
                    <p class="text-[13px] font-bold uppercase tracking-wider text-slate-500">Diagnosa Kerusakan</p>
                    @if ($penyakit)
                        <h2 class="text-2xl font-extrabold text-red-650 leading-tight tracking-tight sm:text-3xl">
                            {{ $penyakit->nama_penyakit }}
                        </h2>
                        <div class="mt-2">
                            <span class="inline-flex items-center rounded-full border border-red-200 bg-red-100/60 px-3.5 py-1 text-xs font-bold text-red-700">
                                Tingkat Kerusakan : {{ $tingkat }}
                            </span>
                        </div>
                    @else
                        <h2 class="text-2xl font-bold text-slate-700">Tidak ada kerusakan terdeteksi</h2>
                    @endif
                </div>
            </div>
        </div>

        @if ($penyakit)
            <!-- Penyebab Section -->
            <div class="space-y-3">
                <h3 class="text-base font-bold text-slate-900">Penyebab</h3>
                <p class="text-[15px] leading-relaxed text-slate-700">
                    {{ $penyakit->deskripsi }}
                </p>
            </div>

            <!-- Solusi Section -->
            <div class="space-y-3">
                <h3 class="text-base font-bold text-slate-900">Solusi</h3>
                @if (count($solusiLines))
                    <ol class="list-decimal pl-5 text-[15px] space-y-2.5 text-slate-700 leading-relaxed">
                        @foreach ($solusiLines as $line)
                            <li>{{ $line }}</li>
                        @endforeach
                    </ol>
                @else
                    <p class="text-[15px] leading-relaxed text-slate-700">{{ $penyakit->solusi }}</p>
                @endif
            </div>
        @endif

        <!-- Selected Symptoms Badge List -->
        <div class="border-t border-slate-100 pt-6">
            <h4 class="text-sm font-bold uppercase tracking-wider text-slate-500 mb-3">Gejala yang terdeteksi</h4>
            <div class="flex flex-wrap gap-2">
                @foreach ($kodes as $k)
                    <span class="inline-flex items-center rounded-lg bg-slate-50 border border-slate-200 px-3 py-1 text-xs font-semibold text-slate-700">
                        {{ $namaGejala[$k] ?? $k }}
                    </span>
                @endforeach
            </div>
        </div>

        <!-- Action Cards Grid (Exactly matches the mockup) -->
        <div class="grid gap-6 sm:grid-cols-2 pt-4 print:hidden">
            <!-- Green Card: Perbaikan Sendiri -->
            <div class="rounded-2xl border border-slate-200 bg-white p-6 flex flex-col justify-between shadow-sm">
                <div>
                    <div class="flex items-center gap-3">
                        <span class="flex h-9 w-9 items-center justify-center rounded-xl bg-emerald-50 text-emerald-600">
                            <svg class="h-5.5 w-5.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </span>
                        <h4 class="font-bold text-slate-950 text-[15px]">Perbaikan Sendiri</h4>
                    </div>
                    <p class="mt-4 text-[14px] leading-relaxed text-slate-600">
                        Kerusakan ini dapat diperbaiki sendiri dengan langkah-langkah di atas.
                    </p>
                </div>
                <div class="mt-6">
                    <form method="post" action="{{ route('user.hasil-diagnosa.tindakan', $d->id) }}">
                        @csrf
                        <input type="hidden" name="tindakan" value="sendiri">
                        <button type="submit" class="inline-flex w-full items-center justify-center rounded-xl bg-emerald-600 px-5 py-3 text-sm font-bold text-white hover:bg-emerald-700 transition-colors shadow-sm">
                            Lakukan Sendiri
                        </button>
                    </form>
                </div>
            </div>

            <!-- Orange Card: Panggil Teknisi -->
            <div class="rounded-2xl border border-slate-200 bg-white p-6 flex flex-col justify-between shadow-sm">
                <div>
                    <div class="flex items-center gap-3">
                        <span class="flex h-9 w-9 items-center justify-center rounded-xl bg-orange-50 text-orange-600">
                            <svg class="h-5.5 w-5.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </span>
                        <h4 class="font-bold text-slate-950 text-[15px]">Panggil Teknisi</h4>
                    </div>
                    <p class="mt-4 text-[14px] leading-relaxed text-slate-600">
                        Jika kerusakan tidak dapat diatasi, sebaiknya hubungi teknisi.
                    </p>
                </div>
                <div class="mt-6">
                    <form method="post" action="{{ route('user.hasil-diagnosa.tindakan', $d->id) }}">
                        @csrf
                        <input type="hidden" name="tindakan" value="teknisi">
                        <button type="submit" class="inline-flex w-full items-center justify-center rounded-xl bg-orange-500 px-5 py-3 text-sm font-bold text-white hover:bg-orange-600 transition-colors shadow-sm">
                            Hubungi Teknisi
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
