@extends('layouts.dashboard')
@section('title', 'Hasil Diagnosa')
@section('content')

<div class="mx-auto max-w-6xl space-y-6 print:max-w-none">
    @include('partials.user-page-header', ['title' => 'Hasil Diagnosa', 'firstName' => $firstName])

    <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm sm:p-8 print:border-0 print:shadow-none">
        @include('partials.diagnosa-stepper', ['activeStep' => 3, 'class' => 'print:hidden'])

        @if ($penyakit)
            {{-- Diagnosa Selesai --}}
            <div class="mt-6 rounded-2xl border border-emerald-200 bg-emerald-50/60 p-5 sm:p-6 print:border print:bg-white">
                <div class="flex items-start gap-3">
                    <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-emerald-500 text-white">
                        <i class="bi bi-check-lg text-xl font-bold"></i>
                    </span>
                    <div>
                        <h2 class="text-lg font-bold text-slate-900">Diagnosa Selesai</h2>
                        <p class="mt-0.5 text-sm text-slate-600">Berikut hasil identifikasi berdasarkan gejala yang Anda pilih.</p>
                    </div>
                </div>

                <div class="mt-5 rounded-xl border border-slate-200/80 bg-white p-5 shadow-sm">
                    <dl class="space-y-3 text-sm">
                        <div class="flex flex-wrap gap-x-2">
                            <dt class="font-semibold text-slate-700">Jenis Kerusakan :</dt>
                            <dd class="font-bold text-slate-900">{{ $penyakit->nama_penyakit }}</dd>
                        </div>
                        <div class="flex flex-wrap gap-x-2">
                            <dt class="font-semibold text-slate-700">Tingkat Kerusakan :</dt>
                            <dd class="font-bold text-slate-900">{{ $tingkatLabel }}</dd>
                        </div>
                        <div class="flex flex-wrap gap-x-2">
                            <dt class="font-semibold text-slate-700">Rekomendasi :</dt>
                            <dd class="font-bold text-slate-900">{{ $rekomendasi }}</dd>
                        </div>
                    </dl>
                </div>
            </div>

            {{-- Solusi Perbaikan --}}
            <div class="mt-5 rounded-2xl border border-blue-100 bg-blue-50/50 p-5 sm:p-6 print:border print:bg-white">
                <h3 class="text-base font-bold text-slate-900">Solusi Perbaikan</h3>
                @if (count($solusiLines))
                    <ol class="mt-4 list-decimal space-y-2.5 pl-5 text-sm leading-relaxed text-slate-700">
                        @foreach ($solusiLines as $line)
                            <li>{{ $line }}</li>
                        @endforeach
                    </ol>
                @elseif ($penyakit->solusi)
                    <p class="mt-4 text-sm leading-relaxed text-slate-700 whitespace-pre-line">{{ $penyakit->solusi }}</p>
                @else
                    <p class="mt-4 text-sm text-slate-500">Belum ada solusi tercatat untuk kerusakan ini.</p>
                @endif
            </div>

            {{-- Rekomendasi --}}
            <div class="mt-5 rounded-xl border border-amber-100 bg-amber-50/80 px-5 py-4 print:border">
                <div class="flex gap-3">
                    <span class="flex h-8 w-8 shrink-0 items-center justify-center text-amber-600">
                        <i class="bi bi-exclamation-triangle-fill text-xl"></i>
                    </span>
                    <div>
                        <h3 class="font-bold text-slate-900">Rekomendasi</h3>
                        <p class="mt-1 text-sm leading-relaxed text-slate-700">
                            Jika kerusakan masih berlanjut, sebaiknya hubungi teknisi.
                        </p>
                    </div>
                </div>
            </div>
        @else
            <div class="mt-6 rounded-2xl border border-slate-200 bg-slate-50 p-6 text-center">
                <h2 class="text-lg font-bold text-slate-800">Tidak ada kerusakan yang terdeteksi</h2>
                <p class="mt-2 text-sm text-slate-600">Kombinasi gejala tidak cocok dengan aturan yang ada. Coba pilih gejala lain.</p>
                <a href="/user/diagnosa" class="mt-4 inline-flex rounded-xl bg-blue-600 px-5 py-2.5 text-sm font-bold text-white hover:bg-blue-700">
                    Diagnosa Baru
                </a>
            </div>
        @endif

        {{-- Tombol aksi --}}
        @if ($penyakit)
            <div class="mt-8 grid w-full grid-cols-3 gap-2 border-t border-slate-100 pt-6 sm:gap-3 print:hidden">
                @include('partials.diagnosa-export-dropdown', ['diagnosaId' => $d->id, 'fullWidth' => true])
                <a href="/user/diagnosa"
                   class="inline-flex w-full min-w-0 items-center justify-center gap-1.5 rounded-xl border border-slate-200 bg-white px-2 py-3 text-xs font-bold text-slate-800 shadow-sm transition hover:bg-slate-50 sm:gap-2 sm:px-3 sm:text-sm">
                    <i class="bi bi-arrow-repeat shrink-0"></i>
                    <span class="truncate">Diagnosa Baru</span>
                </a>
                <a href="{{ route('user.hasil-diagnosa.simpan-riwayat', $d->id) }}"
                   class="inline-flex w-full min-w-0 items-center justify-center gap-1.5 rounded-xl bg-blue-600 px-2 py-3 text-xs font-bold text-white shadow-sm transition hover:bg-blue-700 sm:gap-2 sm:px-3 sm:text-sm">
                    <i class="bi bi-folder-check shrink-0"></i>
                    <span class="truncate">Simpan ke Riwayat</span>
                </a>
            </div>
        @endif
    </div>
</div>

@endsection
