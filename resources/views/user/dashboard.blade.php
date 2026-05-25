@extends('layouts.dashboard')
@section('title', 'Dashboard')
@section('content')
<div class="mx-auto max-w-7xl space-y-6">

    @if (!empty($dbError))
        <div class="rounded-xl border border-amber-200 bg-amber-50 px-4 py-3 text-sm text-amber-900">
            Database belum merespons. Coba refresh beberapa saat lagi.
        </div>
    @endif

    {{-- Banner selamat datang --}}
    <div class="relative overflow-hidden rounded-2xl bg-gradient-to-r from-[#1d4ed8] to-[#2563eb] px-6 py-8 shadow-lg shadow-blue-600/20 sm:px-8 sm:py-10">
        <div class="pointer-events-none absolute -right-8 -top-8 h-40 w-40 rounded-full bg-white/10"></div>
        <div class="pointer-events-none absolute -bottom-12 right-24 h-32 w-32 rounded-full bg-white/5"></div>
        <div class="relative flex flex-col gap-6 lg:flex-row lg:items-center lg:justify-between">
            <div class="max-w-2xl">
                <h1 class="text-2xl font-extrabold tracking-tight text-white sm:text-3xl">
                    Halo, {{ $firstName }}! 👋
                </h1>
                <p class="mt-2 text-sm leading-relaxed text-blue-100 sm:text-base">
                    Selamat datang di Sistem Pakar Printer. Kami siap membantu mendeteksi masalah printer Anda.
                </p>
            </div>
            <div class="flex shrink-0 flex-col items-stretch gap-3 sm:items-end">
                <span class="inline-flex items-center justify-center gap-2 self-start rounded-full border border-white/20 bg-white/95 px-4 py-2 text-xs font-medium text-slate-600 shadow-sm backdrop-blur-sm sm:self-end sm:text-sm">
                    <i class="bi bi-calendar3 text-slate-400"></i>
                    <span id="toolbar-datetime-text"></span>
                </span>
                <a href="/user/diagnosa"
                   class="inline-flex items-center justify-center gap-2 rounded-full bg-white px-6 py-3 text-sm font-bold text-[#1d4ed8] shadow-md transition hover:bg-blue-50 active:scale-[0.98]">
                    <i class="fa-solid fa-stethoscope text-base"></i>
                    Mulai Diagnosa Baru
                </a>
            </div>
        </div>
    </div>

    {{-- Stat cards --}}
    <div class="grid gap-4 sm:grid-cols-2">
        <div class="flex items-center gap-4 rounded-2xl border border-slate-200/90 bg-white p-5 shadow-[0_4px_24px_rgba(15,23,42,0.06)] sm:p-6">
            <div class="flex h-14 w-14 shrink-0 items-center justify-center rounded-2xl bg-blue-50 text-[#1d4ed8]">
                <i class="bi bi-clipboard2-check text-2xl"></i>
            </div>
            <div class="min-w-0">
                <p class="text-[11px] font-bold uppercase tracking-wider text-slate-400">Total Diagnosa Anda</p>
                <p class="mt-1 text-2xl font-extrabold tabular-nums text-slate-900 sm:text-3xl">
                    {{ $count }} <span class="text-lg font-bold text-slate-600">Kali</span>
                </p>
            </div>
        </div>
        <div class="flex items-center gap-4 rounded-2xl border border-slate-200/90 bg-white p-5 shadow-[0_4px_24px_rgba(15,23,42,0.06)] sm:p-6">
            <div class="flex h-14 w-14 shrink-0 items-center justify-center rounded-2xl bg-amber-50 text-amber-500">
                <i class="bi bi-clock-history text-2xl"></i>
            </div>
            <div class="min-w-0">
                <p class="text-[11px] font-bold uppercase tracking-wider text-slate-400">Diagnosa Terakhir</p>
                <p class="mt-1 text-xl font-extrabold text-slate-900 sm:text-2xl">{{ $lastDiagnosaHuman }}</p>
            </div>
        </div>
    </div>

    {{-- Aktivitas + Tips --}}
    <div class="grid gap-5 lg:grid-cols-[1fr_320px] xl:grid-cols-[1fr_360px]">
        <div class="rounded-2xl border border-slate-200/90 bg-white p-5 shadow-[0_4px_24px_rgba(15,23,42,0.06)] sm:p-6">
            <div class="mb-5 flex items-center justify-between gap-3">
                <h2 class="flex items-center gap-2 text-lg font-bold text-[#152238]">
                    <i class="bi bi-clock-history text-[#1d4ed8]"></i>
                    Aktivitas Terbaru
                </h2>
                <a href="/user/riwayat" class="text-sm font-semibold text-[#1d4ed8] transition hover:underline">Lihat Semua</a>
            </div>

            <div class="overflow-x-auto rounded-xl border border-slate-100">
                <table class="w-full min-w-[520px] text-sm">
                    <thead class="border-b border-slate-100 bg-slate-50/80 text-left text-[11px] font-bold uppercase tracking-wider text-slate-400">
                        <tr>
                            <th class="px-4 py-3.5">Tanggal</th>
                            <th class="px-4 py-3.5">Hasil Kerusakan</th>
                            <th class="px-4 py-3.5 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($rows as $r)
                            @php
                                $dt = wib_from_db($r->tanggal_diagnosa);
                                $hasil = $r->hasil_penyakit
                                    ? ($namaByKode[$r->hasil_penyakit] ?? $r->hasil_penyakit)
                                    : null;
                            @endphp
                            <tr class="border-t border-slate-100 odd:bg-white even:bg-slate-50/50">
                                <td class="px-4 py-4">
                                    @if ($dt)
                                        <p class="font-bold text-slate-800">{{ $dt->translatedFormat('d F Y') }}</p>
                                        <p class="mt-0.5 text-xs text-slate-400">{{ $dt->format('H:i') }} WIB</p>
                                    @else
                                        <span class="text-slate-400">—</span>
                                    @endif
                                </td>
                                <td class="px-4 py-4">
                                    @if ($hasil)
                                        <span class="inline-flex rounded-full bg-emerald-50 px-3 py-1 text-xs font-semibold text-emerald-700 ring-1 ring-emerald-100">
                                            {{ $hasil }}
                                        </span>
                                    @else
                                        <span class="text-slate-400">—</span>
                                    @endif
                                </td>
                                <td class="px-4 py-4 text-right">
                                    <a href="/user/riwayat/{{ $r->id }}"
                                       class="inline-flex rounded-lg border border-slate-200 bg-white px-3 py-1.5 text-xs font-semibold text-slate-600 transition hover:border-slate-300 hover:bg-slate-50">
                                        Detail
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="px-4 py-10 text-center text-slate-500">
                                    Belum ada aktivitas diagnosa. Mulai diagnosa pertama Anda!
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="rounded-2xl border border-slate-200/90 bg-white p-5 shadow-[0_4px_24px_rgba(15,23,42,0.06)] sm:p-6">
            <h2 class="flex items-center gap-2 text-lg font-bold text-[#152238]">
                <i class="bi bi-lightbulb-fill text-amber-400"></i>
                Tips Printer
            </h2>
            <div class="mt-5 space-y-3">
                <div class="rounded-xl bg-slate-50 px-4 py-3.5 text-sm leading-relaxed text-slate-600 ring-1 ring-slate-100">
                    Selalu gunakan tinta original untuk menjaga keawetan print head printer Anda.
                </div>
                <div class="rounded-xl bg-slate-50 px-4 py-3.5 text-sm leading-relaxed text-slate-600 ring-1 ring-slate-100">
                    Lakukan <span class="font-medium text-slate-700">cleaning</span> secara berkala jika hasil cetakan mulai bergaris.
                </div>
                <div class="rounded-xl bg-slate-50 px-4 py-3.5 text-sm leading-relaxed text-slate-600 ring-1 ring-slate-100">
                    Matikan printer dengan benar setelah digunakan agar komponen internal tidak cepat aus.
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
