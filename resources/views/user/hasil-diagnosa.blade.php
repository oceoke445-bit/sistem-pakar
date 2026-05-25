@extends('layouts.dashboard')
@section('title', 'Hasil Diagnosa')
@section('content')

@php
    $tingkat = $penyakit && $penyakit->tingkat ? $penyakit->tingkat : 'Sedang';
    $tingkatClass = $tingkat === 'Berat' ? 'border-red-200 bg-red-50 text-red-700' : ($tingkat === 'Sedang' ? 'border-amber-250 bg-amber-50 text-amber-800' : 'border-emerald-200 bg-emerald-50 text-emerald-700');
    $solusiLines = $penyakit && $penyakit->solusi ? array_filter(preg_split('/\r\n|\r|\n/', trim($penyakit->solusi))) : [];
@endphp

<div class="mx-auto max-w-5xl space-y-6">
    <!-- Header Block -->
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-[#152238] sm:text-3xl">Hasil Diagnosa</h1>
            <p class="mt-1 text-[15px] text-slate-600">Berikut adalah hasil analisa berdasarkan gejala yang dipilih</p>
        </div>
        <div class="shrink-0 print:hidden">
            @include('partials.diagnosa-export-dropdown', ['diagnosaId' => $d->id])
        </div>
    </div>

    <!-- Stepper Indicator (Matches current active state) -->
    <div class="flex items-center justify-center gap-4 py-2 print:hidden">
        <div class="flex items-center gap-2">
            <span class="flex h-7 w-7 items-center justify-center rounded-full bg-blue-600 font-bold text-white text-xs shadow-sm">1</span>
            <span class="text-sm font-bold text-blue-800">Pilih Gejala</span>
        </div>
        <div class="relative mx-1 h-[2px] w-24 shrink-0 overflow-hidden rounded-full bg-slate-200">
            <div class="absolute inset-y-0 left-0 w-full rounded-full bg-blue-600"></div>
        </div>
        <div class="flex items-center gap-2">
            <span class="flex h-7 w-7 items-center justify-center rounded-full bg-blue-600 font-bold text-white text-xs shadow-sm">2</span>
            <span class="text-sm font-bold text-blue-800">Hasil Diagnosa</span>
        </div>
    </div>

    <!-- Main Results Container Card -->
    <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm sm:p-8 space-y-8 print:border-0 print:shadow-none">
        
        <!-- Red/Amber Header Box inside the main card -->
        <div class="rounded-2xl border border-red-100 bg-red-50/40 p-5 sm:p-6 print:bg-white print:border-0">
            <div class="flex flex-col gap-5 sm:flex-row sm:items-center">
                @include('partials.printer-diagnosa-icon')
                <!-- Damage details -->
                <div class="text-center sm:text-left space-y-2">
                    <p class="text-[13px] font-bold uppercase tracking-wider text-slate-500">Diagnosa Kerusakan</p>
                    @if ($penyakit)
                        <h2 class="text-2xl font-extrabold text-red-600 leading-tight tracking-tight sm:text-3xl">
                            {{ $penyakit->nama_penyakit }}
                        </h2>
                        <div class="mt-2">
                            <span class="inline-flex items-center rounded-full border border-red-200 bg-red-100/60 px-3.5 py-1 text-xs font-bold text-red-700">
                                Tingkat Kerusakan : {{ $tingkat }}
                            </span>
                        </div>
                    @else
                        <h2 class="text-2xl font-bold text-slate-700">Tidak ada kerusakan yang terdeteksi</h2>
                        <p class="text-sm text-slate-500">Kombinasi gejala yang Anda pilih tidak cocok dengan aturan kerusakan printer manapun.</p>
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
            <h4 class="text-sm font-bold uppercase tracking-wider text-slate-500 mb-3">Gejala yang Anda pilih</h4>
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

        <!-- Back Link -->
        <div class="border-t border-slate-100 pt-6 print:hidden">
            <a href="/user/diagnosa" class="inline-flex items-center gap-1 text-sm font-bold text-brand-600 hover:text-brand-700 transition-colors">
                <i class="bi bi-arrow-left"></i> Kembali ke Diagnosa
            </a>
        </div>
    </div>
</div>

@endsection
