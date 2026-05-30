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
    <div>
        <h1 class="text-2xl font-bold tracking-tight text-[#152238] sm:text-3xl">Diagnosa Kerusakan Printer</h1>
        <p class="mt-1.5 text-[15px] text-slate-600">Pilih gejala yang sesuai dengan kondisi printer Anda.</p>
    </div>

    <div class="flex flex-col items-stretch gap-4 sm:flex-row sm:items-center sm:justify-center md:gap-2">
        @foreach ($steps as $s)
            <div class="flex items-center justify-center gap-3 sm:gap-2">
                <div class="flex items-center gap-2 rounded-full border px-4 py-2.5 text-sm font-semibold shadow-sm
                    {{ $s['active'] ? 'border-blue-600 bg-blue-50 text-blue-800' : 'border-slate-200 bg-white text-slate-500' }}">
                    <span class="flex h-8 w-8 items-center justify-center rounded-full {{ $s['active'] ? 'bg-blue-600 text-white' : 'bg-slate-200 text-slate-600' }} text-xs font-bold">{{ $s['num'] }}</span>
                    {{ $s['label'] }}
                </div>
                @if (! $loop->last)
                    <div class="hidden h-px w-8 shrink-0 bg-slate-200 sm:block md:w-12" aria-hidden="true"></div>
                @endif
            </div>
        @endforeach
    </div>

    @if (!empty($error))
        <div class="rounded-xl border border-amber-200 bg-amber-50 p-4 text-sm text-amber-900">{{ $error }}</div>
    @endif

    <form id="formDiagnosa" method="post" action="{{ route('admin.diagnosa.store') }}" class="grid gap-6 lg:grid-cols-[1fr_300px]">
        @csrf
        <div class="rounded-2xl border border-slate-200/90 bg-white p-6 shadow-[0_4px_24px_rgba(15,23,42,0.06)] sm:p-8">
            <h2 class="text-lg font-bold text-[#152238]">Pilih Gejala</h2>
            <p class="mt-1 text-sm text-slate-500">Centang gejala yang sesuai dengan kondisi printer yang terjadi.</p>
            <div class="mt-6 grid gap-3 sm:grid-cols-2 xl:grid-cols-3">
                @forelse ($gejala as $g)
                    <label class="flex cursor-pointer items-start gap-3 rounded-xl border border-slate-200 bg-slate-50/60 p-4 transition hover:border-blue-400 hover:bg-blue-50/40">
                        <input type="checkbox" name="gejala[]" value="{{ $g->kode_gejala }}" class="mt-1 h-4 w-4 rounded border-slate-300 text-blue-600 focus:ring-blue-500">
                        <span class="text-sm leading-snug text-slate-800">
                            <span class="mr-1 font-mono text-xs text-slate-500">{{ $g->kode_gejala }}</span>
                            {{ $g->nama_gejala }}
                        </span>
                    </label>
                @empty
                    <p class="col-span-full py-8 text-center text-sm text-slate-500">Belum ada data gejala.</p>
                @endforelse
            </div>
            <div class="mt-8 flex flex-col gap-3 sm:flex-row sm:flex-wrap sm:justify-end">
                <button type="reset" class="order-2 w-full rounded-xl border border-slate-300 bg-white px-6 py-3 text-sm font-bold text-slate-800 shadow-sm hover:bg-slate-50 sm:order-1 sm:w-auto">Reset</button>
                <button type="submit" class="order-1 flex w-full items-center justify-center gap-2 rounded-xl bg-brand-600 px-8 py-3 text-sm font-bold text-white shadow-lg shadow-blue-600/25 hover:bg-brand-700 sm:order-2 sm:w-auto">
                    Proses Diagnosa <i class="bi bi-arrow-right text-lg"></i>
                </button>
            </div>
        </div>
        <aside class="h-fit rounded-2xl border border-blue-100/80 bg-gradient-to-b from-blue-50 to-white p-6 shadow-[0_4px_24px_rgba(15,23,42,0.06)]">
            <div class="flex items-center gap-2 text-blue-900">
                <i class="bi bi-lightbulb text-xl"></i>
                <h3 class="font-bold">Tips</h3>
            </div>
            <p class="mt-3 text-[14px] leading-relaxed text-slate-600">
                Pilih semua gejala yang sesuai agar sistem dapat memberikan diagnosa yang lebih akurat.
            </p>
            <div class="mt-6 flex justify-center">
                <img src="{{ asset('images/printer.png') }}" alt="" class="h-32 w-auto max-w-[220px] object-contain drop-shadow-md" width="220" height="220" decoding="async">
            </div>
        </aside>
    </form>
</div>
@endsection
