@extends('layouts.dashboard')
@section('title', 'Detail Diagnosa')
@section('content')
@php
    $lbl = diagnosis_tingkat_label($d->confidence !== null ? (float) $d->confidence : null);
@endphp
<div class="mx-auto max-w-3xl space-y-6">
    <a href="/admin/riwayat" class="inline-flex items-center gap-1 text-sm font-semibold text-brand-600 hover:text-brand-700"><i class="bi bi-arrow-left"></i> Riwayat</a>
    <div class="rounded-2xl border border-slate-200 bg-white p-8 shadow-sm">
        <p class="text-xs font-semibold uppercase text-slate-500">Detail #{{ $d->id }}</p>
        <p class="mt-2 text-sm text-slate-600">{{ format_date_id($d->tanggal_diagnosa) }}</p>
        <p class="mt-4 text-sm text-slate-700"><span class="font-semibold text-slate-900">Pengguna:</span> {{ $userProf->nama_lengkap ?? '—' }} <span class="text-slate-500">({{ $userProf->email ?? '' }})</span></p>
        @if ($p)
            <h1 class="mt-6 text-2xl font-bold text-slate-900">{{ $p->nama_penyakit }}</h1>
            <span class="mt-2 inline-flex rounded-full px-3 py-1 text-xs font-bold {{ $lbl === 'Berat' ? 'bg-red-100 text-red-800' : ($lbl === 'Sedang' ? 'bg-amber-100 text-amber-900' : 'bg-emerald-100 text-emerald-800') }}">{{ $lbl }}</span>
            <p class="mt-4 text-sm leading-relaxed text-slate-600">{{ $p->deskripsi }}</p>
        @endif
        @if ($pct !== null)
            <p class="mt-4 text-sm">Kecocokan: <strong>{{ number_format($pct, 1) }}%</strong></p>
        @endif
        <h2 class="mt-8 text-sm font-bold uppercase text-slate-500">Gejala</h2>
        <ul class="mt-3 space-y-2">
            @foreach ($kodeList as $k)
                <li class="rounded-xl border border-slate-100 bg-slate-50 px-4 py-2 text-sm">{{ $namaGejala[$k] ?? $k }}</li>
            @endforeach
        </ul>
        <form method="post" action="{{ route('admin.diagnosa.hapus') }}" class="mt-8 border-t border-slate-100 pt-6" onsubmit="event.preventDefault(); confirmDelete(this, 'Hapus Diagnosa?', 'Apakah Anda yakin ingin menghapus data diagnosa ini? Tindakan ini tidak dapat dibatalkan.');">
            @csrf
            <input type="hidden" name="id" value="{{ $d->id }}">
            <button type="submit" class="rounded-xl border border-red-200 bg-red-50 px-5 py-2.5 text-sm font-semibold text-red-700 hover:bg-red-100">Hapus diagnosa</button>
        </form>
    </div>
</div>
@endsection
