@extends('layouts.dashboard')
@section('title', 'Diagnosa')
@section('content')

<div class="mx-auto max-w-6xl space-y-6">
    <div>
        <h1 class="text-2xl font-bold tracking-tight text-[#152238] sm:text-3xl">Diagnosa Kerusakan Printer</h1>
        <p class="mt-1 text-[15px] text-slate-600">Pilih gejala yang sesuai dengan kondisi printer</p>
    </div>

    <div class="flex items-center justify-center gap-4 py-4">
        <div class="flex items-center gap-2">
            <span class="flex h-7 w-7 items-center justify-center rounded-full bg-blue-600 font-bold text-white text-xs shadow-sm">1</span>
            <span class="text-sm font-bold text-blue-800">Pilih Gejala</span>
        </div>
        <div class="relative mx-1 h-[2px] w-24 shrink-0 overflow-hidden rounded-full bg-slate-200">
            <div class="absolute inset-y-0 left-0 w-1/2 rounded-full bg-blue-600"></div>
        </div>
        <div class="flex items-center gap-2">
            <span class="flex h-7 w-7 items-center justify-center rounded-full bg-slate-200 font-bold text-slate-500 text-xs">2</span>
            <span class="text-sm font-semibold text-slate-400">Hasil Diagnosa</span>
        </div>
    </div>

    @if (!empty($error))
        <div class="rounded-xl border border-amber-200 bg-amber-50 p-4 text-sm text-amber-900 shadow-sm">{{ $error }}</div>
    @endif

    <form id="formDiagnosa" method="post" action="/user/diagnosa" class="grid gap-6 lg:grid-cols-[1fr_300px]">
        @csrf

        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm sm:p-8">
            <div class="flex items-start justify-between gap-4">
                <div>
                    <h2 class="text-sm font-bold uppercase tracking-wider text-slate-500">Daftar Gejala</h2>
                    <p class="mt-1 text-sm text-slate-500">Centang gejala yang sesuai dengan kondisi printer yang terjadi.</p>
                </div>
                <div class="flex shrink-0 items-center gap-2">
                    <button type="button" id="gejalaPrev" disabled
                            class="inline-flex h-9 w-9 items-center justify-center rounded-full border border-slate-200 bg-white text-slate-500 shadow-sm transition hover:bg-slate-50 disabled:cursor-not-allowed disabled:opacity-40"
                            aria-label="Gejala sebelumnya">
                        <i class="bi bi-chevron-left text-sm"></i>
                    </button>
                    <button type="button" id="gejalaNext"
                            class="inline-flex h-9 w-9 items-center justify-center rounded-full border border-slate-200 bg-white text-slate-500 shadow-sm transition hover:bg-slate-50 disabled:cursor-not-allowed disabled:opacity-40"
                            aria-label="Gejala berikutnya">
                        <i class="bi bi-chevron-right text-sm"></i>
                    </button>
                </div>
            </div>

            @php
                $perPage = 12;
                $pages = $gejala->chunk($perPage);
            @endphp

            <div id="gejalaCarousel" class="relative mt-6 min-h-[420px]">
                @foreach ($pages as $pageIndex => $pageItems)
                    <div class="gejala-page grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3 {{ $pageIndex === 0 ? '' : 'hidden' }}"
                         data-page="{{ $pageIndex }}">
                        @foreach ($pageItems as $g)
                            <label class="gejala-card group flex cursor-pointer flex-col rounded-xl border border-slate-200 bg-white p-4 shadow-[0_1px_4px_rgba(15,23,42,0.04)] transition hover:border-blue-200 hover:shadow-md has-[:checked]:border-blue-400 has-[:checked]:bg-blue-50/30 has-[:checked]:ring-1 has-[:checked]:ring-blue-200">
                                <div class="flex items-center gap-2.5">
                                    <input type="checkbox" name="gejala[]" value="{{ $g->kode_gejala }}"
                                           class="h-4 w-4 shrink-0 rounded border-slate-300 text-blue-600 focus:ring-blue-500">
                                    <span class="inline-flex rounded-md bg-blue-50 px-2 py-0.5 text-xs font-bold text-blue-600 ring-1 ring-blue-100">
                                        {{ $g->kode_gejala }}
                                    </span>
                                </div>
                                <span class="mt-3 text-[14px] font-semibold leading-snug text-slate-800 group-hover:text-slate-900">
                                    {{ $g->nama_gejala }}
                                </span>
                            </label>
                        @endforeach
                    </div>
                @endforeach
            </div>

            <p id="gejalaPageInfo" class="mt-4 text-center text-xs font-medium text-slate-400"></p>

            <div class="mt-6 flex items-center justify-between border-t border-slate-100 pt-6">
                <button type="reset" id="btnResetGejala"
                        class="rounded-xl border border-slate-200 bg-white px-6 py-2.5 text-sm font-bold text-slate-600 shadow-sm transition hover:bg-slate-50">
                    Reset
                </button>
                <button type="submit"
                        class="inline-flex items-center gap-1.5 rounded-xl bg-blue-600 px-6 py-2.5 text-sm font-bold text-white shadow-sm transition hover:bg-blue-700 active:scale-95">
                    Proses Diagnosa <i class="bi bi-arrow-right"></i>
                </button>
            </div>
        </div>

        <aside class="flex h-full flex-col rounded-2xl border border-blue-100 bg-blue-50/50 p-6 shadow-sm">
            <div>
                <h3 class="font-bold text-slate-950">Tips</h3>
                <p class="mt-2.5 text-[14px] leading-relaxed text-slate-600">
                    Pilih semua gejala yang sesuai agar sistem dapat memberikan diagnosa yang lebih akurat.
                </p>
            </div>
            <div class="mt-6 flex flex-1 items-center justify-center">
                <svg class="h-44 w-auto drop-shadow-sm" viewBox="0 0 120 110" fill="none" xmlns="http://www.w3.org/2000/svg">
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

@push('scripts')
<script>
    (function () {
        var pages = Array.from(document.querySelectorAll('.gejala-page'));
        var prevBtn = document.getElementById('gejalaPrev');
        var nextBtn = document.getElementById('gejalaNext');
        var info = document.getElementById('gejalaPageInfo');
        var current = 0;

        function renderPage() {
            pages.forEach(function (page, index) {
                page.classList.toggle('hidden', index !== current);
            });
            if (prevBtn) prevBtn.disabled = current === 0;
            if (nextBtn) nextBtn.disabled = current >= pages.length - 1;
            if (info && pages.length > 1) {
                info.textContent = 'Halaman ' + (current + 1) + ' dari ' + pages.length;
            } else if (info) {
                info.textContent = '';
            }
        }

        if (prevBtn) {
            prevBtn.addEventListener('click', function () {
                if (current > 0) {
                    current--;
                    renderPage();
                }
            });
        }

        if (nextBtn) {
            nextBtn.addEventListener('click', function () {
                if (current < pages.length - 1) {
                    current++;
                    renderPage();
                }
            });
        }

        var resetBtn = document.getElementById('btnResetGejala');
        if (resetBtn) {
            resetBtn.addEventListener('click', function () {
                current = 0;
                renderPage();
            });
        }

        renderPage();
    })();
</script>
@endpush
@endsection
