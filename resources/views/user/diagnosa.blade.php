@extends('layouts.dashboard')
@section('title', 'Konsultasi Diagnosa')
@section('content')

<div class="mx-auto max-w-6xl space-y-6">

    {{-- Header --}}
    @include('partials.user-page-header', ['title' => 'Konsultasi Diagnosa', 'firstName' => $firstName])

    @include('partials.diagnosa-stepper', ['activeStep' => 1])

    @if (!empty($error))
        <div class="rounded-xl border border-amber-200 bg-amber-50 p-4 text-sm text-amber-900 shadow-sm">{{ $error }}</div>
    @endif

    <form id="formDiagnosa" method="post" action="/user/diagnosa" class="grid items-start gap-6 lg:grid-cols-[1fr_300px]">
        @csrf

        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm sm:p-8">
            <div class="rounded-xl border border-blue-100 bg-blue-50 px-4 py-3.5 text-center text-sm font-medium text-slate-700 sm:px-6">
                Pilih gejala yang Anda alami pada printer Canon IR 2425/3045
            </div>

            <div class="mt-5 divide-y divide-slate-100 rounded-xl border border-slate-200">
                @forelse ($gejala as $g)
                    <label class="flex cursor-pointer items-start gap-3 px-4 py-4 transition hover:bg-slate-50/80 has-[:checked]:bg-blue-50/40 sm:px-5">
                        <input type="checkbox" name="gejala[]" value="{{ $g->kode_gejala }}"
                               class="mt-0.5 h-4 w-4 shrink-0 rounded border-slate-300 text-blue-600 focus:ring-blue-500">
                        <span class="text-sm font-medium leading-relaxed text-slate-800">
                            <span class="mr-1.5 font-mono text-xs font-semibold text-slate-500">{{ $g->kode_gejala }}</span>
                            {{ $g->nama_gejala }}
                        </span>
                    </label>
                @empty
                    <p class="px-4 py-8 text-center text-sm text-slate-500">Belum ada data gejala.</p>
                @endforelse
            </div>

            <div class="mt-6 flex flex-col-reverse gap-3 border-t border-slate-100 pt-6 sm:flex-row sm:items-center sm:justify-between">
                <button type="reset"
                        class="rounded-xl border border-slate-200 bg-white px-6 py-2.5 text-sm font-bold text-slate-600 shadow-sm transition hover:bg-slate-50">
                    Reset
                </button>
                <button type="submit"
                        class="inline-flex items-center justify-center gap-1.5 rounded-xl bg-blue-600 px-6 py-2.5 text-sm font-bold text-white shadow-sm transition hover:bg-blue-700 active:scale-[0.98]">
                    Proses Diagnosa <i class="bi bi-arrow-right"></i>
                </button>
            </div>
        </div>

        <aside class="rounded-2xl border border-blue-100 bg-blue-50/50 p-6 shadow-sm lg:sticky lg:top-6">
            <h3 class="font-bold text-slate-950">Tips</h3>
            <p class="mt-2.5 text-[14px] leading-relaxed text-slate-600">
                Pilih semua gejala yang sesuai agar sistem dapat memberikan diagnosa yang lebih akurat.
            </p>
            <div class="mt-5 flex justify-center">
                <svg class="h-36 w-auto drop-shadow-sm" viewBox="0 0 120 110" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                    <rect x="20" y="5" width="76" height="96" rx="8" fill="#ffffff" stroke="#1e293b" stroke-width="3"/>
                    <path d="M48 6 a10 10 0 0 1 20 0" fill="none" stroke="#475569" stroke-width="2.5"/>
                    <rect x="42" y="6" width="32" height="7" rx="2" fill="#475569" stroke="#1e293b" stroke-width="2"/>
                    <circle cx="36" cy="26" r="6" fill="#f0fdf4" stroke="#16a34a" stroke-width="1.8"/>
                    <path d="M33 26 l2 2 l4 -4" fill="none" stroke="#16a34a" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                    <line x1="48" y1="23" x2="84" y2="23" stroke="#94a3b8" stroke-width="3" stroke-linecap="round"/>
                    <line x1="48" y1="29" x2="72" y2="29" stroke="#cbd5e1" stroke-width="3" stroke-linecap="round"/>
                    <circle cx="36" cy="44" r="6" fill="#f0fdf4" stroke="#16a34a" stroke-width="1.8"/>
                    <path d="M33 44 l2 2 l4 -4" fill="none" stroke="#16a34a" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                    <line x1="48" y1="41" x2="84" y2="41" stroke="#94a3b8" stroke-width="3" stroke-linecap="round"/>
                    <line x1="48" y1="47" x2="72" y2="47" stroke="#cbd5e1" stroke-width="3" stroke-linecap="round"/>
                    <circle cx="36" cy="62" r="6" fill="#f0fdf4" stroke="#16a34a" stroke-width="1.8"/>
                    <path d="M33 62 l2 2 l4 -4" fill="none" stroke="#16a34a" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                    <line x1="48" y1="59" x2="84" y2="59" stroke="#94a3b8" stroke-width="3" stroke-linecap="round"/>
                    <line x1="48" y1="65" x2="72" y2="65" stroke="#cbd5e1" stroke-width="3" stroke-linecap="round"/>
                    <circle cx="36" cy="80" r="6" fill="#f0fdf4" stroke="#16a34a" stroke-width="1.8"/>
                    <path d="M33 80 l2 2 l4 -4" fill="none" stroke="#16a34a" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                    <line x1="48" y1="77" x2="84" y2="77" stroke="#94a3b8" stroke-width="3" stroke-linecap="round"/>
                    <line x1="48" y1="83" x2="72" y2="83" stroke="#cbd5e1" stroke-width="3" stroke-linecap="round"/>
                    <path d="M68 62 v-11 h26 v11" fill="#475569" stroke="#0f172a" stroke-width="2.2" stroke-linejoin="round"/>
                    <rect x="73" y="44" width="16" height="10" fill="#ffffff" stroke="#94a3b8" stroke-width="1.2"/>
                    <rect x="58" y="62" width="46" height="28" rx="6" fill="#1e293b" stroke="#0f172a" stroke-width="2.5"/>
                    <rect x="66" y="73" width="30" height="4" rx="1" fill="#0f172a"/>
                    <rect x="70" y="76" width="22" height="8" rx="1" fill="#ffffff" stroke="#cbd5e1" stroke-width="1"/>
                    <circle cx="64" cy="68" r="1.5" fill="#eab308"/>
                    <circle cx="69" cy="68" r="1.5" fill="#22c55e"/>
                    <circle cx="98" cy="86" r="11" fill="#ffffff" stroke="#16a34a" stroke-width="2.2" />
                    <path d="M93 86 l3.5 3.5 l6 -6" fill="none" stroke="#16a34a" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </div>
        </aside>
    </form>
</div>

@endsection
