@extends('layouts.dashboard')
@section('title', 'Diagnosa')
@section('content')
@php
    $steps = [
        ['num' => 1, 'label' => 'Pilih Gejala', 'active' => true],
        ['num' => 2, 'label' => 'Hasil Diagnosa', 'active' => false],
    ];
@endphp
<div class="mx-auto max-w-6xl space-y-8">
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl">Diagnosa Kerusakan</h1>
            <p class="mt-1.5 text-[15px] leading-relaxed text-slate-500">Centang gejala pada printer Anda, lalu jalankan diagnosa.</p>
        </div>
    </div>

    <div class="flex flex-wrap items-center gap-3">
        @foreach ($steps as $s)
            <div class="flex items-center gap-2 rounded-full border px-4 py-2 text-sm font-medium
                {{ $s['active'] ? 'border-blue-600 bg-blue-50 text-blue-800' : 'border-slate-200 bg-white text-slate-500' }}">
                <span class="flex h-7 w-7 items-center justify-center rounded-full {{ $s['active'] ? 'bg-blue-600 text-white' : 'bg-slate-200 text-slate-600' }} text-xs font-bold">{{ $s['num'] }}</span>
                {{ $s['label'] }}
            </div>
            @if (!$loop->last)
                <i class="bi bi-chevron-right hidden text-slate-300 sm:inline"></i>
            @endif
        @endforeach
    </div>

    @if (!empty($error))
        <div class="rounded-xl border border-amber-200 bg-amber-50 p-4 text-sm text-amber-900">{{ $error }}</div>
    @endif

    <form id="formDiagnosa" method="post" action="/user/diagnosa" class="grid gap-6 lg:grid-cols-[1fr_280px]">
        @csrf
        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
            <h2 class="text-lg font-semibold text-slate-900">Pilih gejala</h2>
            <p class="mt-1 text-xs text-slate-500">Anda dapat memilih lebih dari satu gejala.</p>
            <div class="mt-6 grid gap-3 sm:grid-cols-2">
                @foreach ($gejala as $g)
                    <label class="flex cursor-pointer items-start gap-3 rounded-xl border border-slate-200 bg-slate-50/50 p-4 transition hover:border-blue-300 hover:bg-blue-50/30">
                        <input type="checkbox" name="gejala[]" value="{{ $g->kode_gejala }}" class="mt-1 h-4 w-4 rounded border-slate-300 text-blue-600 focus:ring-blue-500">
                        <span class="text-sm leading-snug text-slate-800">
                            <span class="mr-1 font-mono text-xs text-slate-500">{{ $g->kode_gejala }}</span>
                            {{ $g->nama_gejala }}
                        </span>
                    </label>
                @endforeach
            </div>
            <div class="mt-8 flex flex-wrap gap-3">
                <button type="reset" class="rounded-xl border border-slate-300 bg-white px-6 py-2.5 text-sm font-semibold text-slate-700 shadow-sm hover:bg-slate-50">Reset</button>
                <button type="submit" class="rounded-xl bg-brand-600 px-8 py-2.5 text-sm font-semibold text-white shadow-md shadow-blue-600/25 hover:bg-brand-700">Proses Diagnosa</button>
            </div>
        </div>
        <aside class="h-fit rounded-2xl border border-blue-100 bg-gradient-to-b from-blue-50 to-white p-6 shadow-sm">
            <div class="flex items-center gap-2 text-blue-800">
                <i class="bi bi-lightbulb text-xl"></i>
                <h3 class="font-bold tracking-tight">Tips</h3>
            </div>
            <p class="mt-3 text-[14px] leading-relaxed text-slate-600">
                Pilih gejala yang paling relevan pada printer Anda. Semakin lengkap gejala yang dicentang, semakin baik sistem mempersempit kemungkinan kerusakan.
            </p>
            <div class="mt-6 flex justify-center">
                <img src="{{ asset('images/printer.jpg') }}" alt="" class="h-28 w-auto max-w-[200px] object-contain opacity-90" width="200" height="200" decoding="async">
            </div>
        </aside>
    </form>
</div>
@endsection
