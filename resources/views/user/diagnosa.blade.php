@extends('layouts.dashboard')
@section('title', 'Diagnosa')
@section('content')

<div class="mx-auto max-w-6xl space-y-6">
    <!-- Header -->
    <div>
        <h1 class="text-2xl font-bold tracking-tight text-[#152238] sm:text-3xl">Diagnosa Kerusakan Printer</h1>
        <p class="mt-1 text-[15px] text-slate-600">Pilih gejala yang sesuai dengan kondisi printer</p>
    </div>

    <!-- Stepper (exactly matches the screenshot) -->
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

    <!-- Content Grid -->
    <form id="formDiagnosa" method="post" action="/user/diagnosa" class="grid gap-6 lg:grid-cols-[1fr_320px]">
        @csrf
        
        <!-- Main Card -->
        <div class="rounded-2xl border border-slate-250 bg-white p-6 shadow-sm sm:p-8">
            <h2 class="text-lg font-bold text-[#152238]">Pilih Gejala</h2>
            <p class="mt-1 text-sm text-slate-500">Centang gejala yang sesuai dengan kondisi printer yang terjadi.</p>
            
            <!-- 3 Column Grid Checklist -->
            <div class="mt-6 grid gap-x-6 gap-y-4 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($gejala as $g)
                    <label class="flex cursor-pointer items-start gap-3 py-1 text-slate-700 hover:text-slate-900 transition-colors">
                        <input type="checkbox" name="gejala[]" value="{{ $g->kode_gejala }}" class="mt-1 h-4 w-4 rounded border-slate-350 text-blue-600 focus:ring-blue-500 transition-all">
                        <span class="text-[14px] font-medium leading-tight">
                            {{ $g->nama_gejala }}
                        </span>
                    </label>
                @endforeach
            </div>

            <!-- Bottom Buttons -->
            <div class="mt-8 flex items-center justify-between border-t border-slate-100 pt-6">
                <button type="reset" class="rounded-xl border border-slate-200 bg-white px-6 py-2.5 text-sm font-bold text-slate-600 hover:bg-slate-50 transition-colors shadow-sm">Reset</button>
                <button type="submit" class="rounded-xl bg-blue-600 px-6 py-2.5 text-sm font-bold text-white hover:bg-blue-700 transition-colors shadow-sm flex items-center gap-1.5 active:scale-95">
                    Proses Diagnosa <i class="bi bi-arrow-right"></i>
                </button>
            </div>
        </div>

        <!-- Sidebar Tips Card -->
        <aside class="h-full flex flex-col rounded-2xl border border-blue-100 bg-blue-50/50 p-6 shadow-sm">
            <div>
                <h3 class="font-bold text-slate-950">Tips</h3>
                <p class="mt-2.5 text-[14px] leading-relaxed text-slate-600">
                    Pilih semua gejala yang sesuai agar sistem dapat memberikan diagnosa yang lebih akurat.
                </p>
            </div>
            <div class="flex-1 flex items-center justify-center mt-6">
                <!-- High-fidelity Checklist + Printer illustration -->
                <svg class="h-44 w-auto drop-shadow-sm" viewBox="0 0 120 110" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <!-- Board -->
                    <rect x="20" y="5" width="76" height="96" rx="8" fill="#ffffff" stroke="#1e293b" stroke-width="3"/>
                    
                    <!-- Clip binder clip hinge -->
                    <path d="M48 6 a10 10 0 0 1 20 0" fill="none" stroke="#475569" stroke-width="2.5"/>
                    <!-- Clip body on top -->
                    <rect x="42" y="6" width="32" height="7" rx="2" fill="#475569" stroke="#1e293b" stroke-width="2"/>
                    
                    <!-- Checklist items -->
                    <!-- Item 1 -->
                    <circle cx="36" cy="26" r="6" fill="#f0fdf4" stroke="#16a34a" stroke-width="1.8"/>
                    <path d="M33 26 l2 2 l4 -4" fill="none" stroke="#16a34a" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                    <line x1="48" y1="23" x2="84" y2="23" stroke="#94a3b8" stroke-width="3" stroke-linecap="round"/>
                    <line x1="48" y1="29" x2="72" y2="29" stroke="#cbd5e1" stroke-width="3" stroke-linecap="round"/>

                    <!-- Item 2 -->
                    <circle cx="36" cy="44" r="6" fill="#f0fdf4" stroke="#16a34a" stroke-width="1.8"/>
                    <path d="M33 44 l2 2 l4 -4" fill="none" stroke="#16a34a" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                    <line x1="48" y1="41" x2="84" y2="41" stroke="#94a3b8" stroke-width="3" stroke-linecap="round"/>
                    <line x1="48" y1="47" x2="72" y2="47" stroke="#cbd5e1" stroke-width="3" stroke-linecap="round"/>

                    <!-- Item 3 -->
                    <circle cx="36" cy="62" r="6" fill="#f0fdf4" stroke="#16a34a" stroke-width="1.8"/>
                    <path d="M33 62 l2 2 l4 -4" fill="none" stroke="#16a34a" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                    <line x1="48" y1="59" x2="84" y2="59" stroke="#94a3b8" stroke-width="3" stroke-linecap="round"/>
                    <line x1="48" y1="65" x2="72" y2="65" stroke="#cbd5e1" stroke-width="3" stroke-linecap="round"/>

                    <!-- Item 4 -->
                    <circle cx="36" cy="80" r="6" fill="#f0fdf4" stroke="#16a34a" stroke-width="1.8"/>
                    <path d="M33 80 l2 2 l4 -4" fill="none" stroke="#16a34a" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                    <line x1="48" y1="77" x2="84" y2="77" stroke="#94a3b8" stroke-width="3" stroke-linecap="round"/>
                    <line x1="48" y1="83" x2="72" y2="83" stroke="#cbd5e1" stroke-width="3" stroke-linecap="round"/>

                    <!-- Black Printer overlapping bottom right of the clipboard -->
                    <!-- Input paper top tray -->
                    <path d="M68 62 v-11 h26 v11" fill="#475569" stroke="#0f172a" stroke-width="2.2" stroke-linejoin="round"/>
                    <rect x="73" y="44" width="16" height="10" fill="#ffffff" stroke="#94a3b8" stroke-width="1.2"/>
                    
                    <!-- Printer base body -->
                    <rect x="58" y="62" width="46" height="28" rx="6" fill="#1e293b" stroke="#0f172a" stroke-width="2.5"/>
                    <!-- Exit slot -->
                    <rect x="66" y="73" width="30" height="4" rx="1" fill="#0f172a"/>
                    <!-- Printed paper exiting -->
                    <rect x="70" y="76" width="22" height="8" rx="1" fill="#ffffff" stroke="#cbd5e1" stroke-width="1"/>
                    
                    <!-- Indicator LED dots -->
                    <circle cx="64" cy="68" r="1.5" fill="#eab308"/>
                    <circle cx="69" cy="68" r="1.5" fill="#22c55e"/>

                    <!-- Badge checkmark bottom right -->
                    <circle cx="98" cy="86" r="11" fill="#ffffff" stroke="#16a34a" stroke-width="2.2" />
                    <path d="M93 86 l3.5 3.5 l6 -6" fill="none" stroke="#16a34a" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </div>
        </aside>
    </form>
</div>

@endsection
