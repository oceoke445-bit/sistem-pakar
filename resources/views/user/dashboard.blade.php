@extends('layouts.dashboard')
@section('title', 'Dashboard')
@section('content')
<div class="mx-auto max-w-6xl space-y-8">

    @if (session('success'))
        <div class="rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-900">
            {{ session('success') }}
        </div>
    @endif

    @if (!empty($dbError))
        <div class="rounded-xl border border-amber-200 bg-amber-50 px-4 py-3 text-sm text-amber-900">
            Database belum merespons. Coba refresh beberapa saat lagi.
        </div>
    @endif

    {{-- Header --}}
    <div class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
        <div>
            <h1 class="text-3xl font-bold tracking-tight text-[#152238] sm:text-4xl">Dashboard</h1>
            <p class="mt-2 max-w-2xl text-[15px] leading-relaxed text-slate-600">
                Selamat datang di Sistem Pakar Identifikasi Kerusakan Printer Canon IR 2425/3045
            </p>
        </div>
        <div class="flex shrink-0 items-center gap-3 self-start sm:self-auto">
            <span class="text-sm font-semibold text-slate-700">Halo, {{ $firstName }}</span>
            <span class="flex h-11 w-11 items-center justify-center rounded-full bg-slate-200 text-slate-500">
                <i class="bi bi-person-fill text-xl"></i>
            </span>
        </div>
    </div>

    {{-- Menu cards --}}
    <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
        {{-- Konsultasi Diagnosa --}}
        <div class="flex min-h-[320px] flex-col items-center rounded-2xl border border-slate-200/90 bg-white p-8 text-center shadow-[0_4px_24px_rgba(15,23,42,0.06)] sm:min-h-[340px] sm:p-10">
            <div class="flex h-20 w-20 items-center justify-center rounded-2xl bg-blue-50 text-blue-600 sm:h-24 sm:w-24">
                <i class="bi bi-clipboard2-plus text-4xl sm:text-5xl"></i>
            </div>
            <h2 class="mt-6 text-xl font-bold text-slate-900 sm:text-2xl">Konsultasi Diagnosa</h2>
            <p class="mt-3 flex-1 text-sm leading-relaxed text-slate-600 sm:text-base">
                Mulai konsultasi untuk mengetahui kerusakan printer yang Anda alami.
            </p>
            <a href="/user/diagnosa"
               class="mt-8 inline-flex w-full items-center justify-center rounded-xl bg-blue-600 px-5 py-3.5 text-sm font-bold text-white shadow-sm transition hover:bg-blue-700 active:scale-[0.98] sm:py-4 sm:text-base">
                Mulai Diagnosa
            </a>
        </div>

        {{-- Riwayat Diagnosa --}}
        <div class="flex min-h-[320px] flex-col items-center rounded-2xl border border-slate-200/90 bg-white p-8 text-center shadow-[0_4px_24px_rgba(15,23,42,0.06)] sm:min-h-[340px] sm:p-10">
            <div class="flex h-20 w-20 items-center justify-center rounded-2xl bg-emerald-50 text-emerald-600 sm:h-24 sm:w-24">
                <i class="bi bi-clock-history text-4xl sm:text-5xl"></i>
            </div>
            <h2 class="mt-6 text-xl font-bold text-slate-900 sm:text-2xl">Riwayat Diagnosa</h2>
            <p class="mt-3 flex-1 text-sm leading-relaxed text-slate-600 sm:text-base">
                Lihat hasil diagnosa yang pernah Anda lakukan sebelumnya.
            </p>
            <a href="/user/riwayat"
               class="mt-8 inline-flex w-full items-center justify-center rounded-xl bg-emerald-600 px-5 py-3.5 text-sm font-bold text-white shadow-sm transition hover:bg-emerald-700 active:scale-[0.98] sm:py-4 sm:text-base">
                Lihat Riwayat
            </a>
        </div>

        {{-- Profil Saya --}}
        <div class="flex min-h-[320px] flex-col items-center rounded-2xl border border-slate-200/90 bg-white p-8 text-center shadow-[0_4px_24px_rgba(15,23,42,0.06)] sm:col-span-2 sm:min-h-[340px] sm:p-10 lg:col-span-1">
            <div class="flex h-20 w-20 items-center justify-center rounded-2xl bg-violet-50 text-violet-600 sm:h-24 sm:w-24">
                <i class="bi bi-person-fill text-4xl sm:text-5xl"></i>
            </div>
            <h2 class="mt-6 text-xl font-bold text-slate-900 sm:text-2xl">Profil Saya</h2>
            <p class="mt-3 flex-1 text-sm leading-relaxed text-slate-600 sm:text-base">
                Kelola profil dan informasi akun Anda.
            </p>
            <a href="/profile"
               class="mt-8 inline-flex w-full items-center justify-center rounded-xl bg-violet-600 px-5 py-3.5 text-sm font-bold text-white shadow-sm transition hover:bg-violet-700 active:scale-[0.98] sm:py-4 sm:text-base">
                Lihat Profil
            </a>
        </div>
    </div>

    {{-- Informasi --}}
    <div class="rounded-2xl border border-blue-100 bg-blue-50/80 px-6 py-5">
        <h3 class="text-base font-bold text-slate-900">Informasi</h3>
        <p class="mt-2 text-sm leading-relaxed text-slate-700">
            Sistem ini membantu Anda mengidentifikasi kerusakan printer Canon IR 2425/3045 berdasarkan gejala yang Anda pilih.
        </p>
    </div>
</div>
@endsection
