@extends('layouts.dashboard')
@section('title', 'Riwayat')
@section('content')
<div class="mx-auto max-w-6xl space-y-6">
    <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Riwayat Diagnosa</h1>
            <p class="mt-1 text-sm text-slate-500">Daftar diagnosa yang pernah Anda jalankan.</p>
        </div>
    </div>

    @if (request('notice'))
        <div class="rounded-xl border border-emerald-200 bg-emerald-50 p-4 text-sm text-emerald-900">{{ request('notice') }}</div>
    @endif

    <form method="get" action="/user/riwayat" class="flex flex-col gap-3 rounded-2xl border border-slate-200 bg-white p-4 shadow-sm sm:flex-row sm:flex-wrap sm:items-end">
        <div class="min-w-[200px] flex-1">
            <label class="mb-1 block text-xs font-semibold uppercase tracking-wide text-slate-500">Cari</label>
            <input type="search" name="q" value="{{ $q }}" placeholder="Kode, nama kerusakan, atau ID…"
                   class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-2.5 text-sm outline-none focus:border-blue-500 focus:bg-white focus:ring-2 focus:ring-blue-500/20">
        </div>
        <div class="w-full sm:w-48">
            <label class="mb-1 block text-xs font-semibold uppercase tracking-wide text-slate-500">Tingkat</label>
            <select name="tingkat" class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-2.5 text-sm outline-none focus:border-blue-500 focus:bg-white focus:ring-2 focus:ring-blue-500/20">
                <option value="" @selected($tingkat === '')>Semua</option>
                <option value="ringan" @selected($tingkat === 'ringan')>Ringan</option>
                <option value="sedang" @selected($tingkat === 'sedang')>Sedang</option>
                <option value="berat" @selected($tingkat === 'berat')>Berat</option>
            </select>
        </div>
        <button type="submit" class="rounded-xl bg-brand-600 px-6 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-brand-700">Terapkan</button>
        @if ($q !== '' || $tingkat !== '')
            <a href="/user/riwayat" class="rounded-xl border border-slate-200 px-4 py-2.5 text-center text-sm font-semibold text-slate-600 hover:bg-slate-50">Reset</a>
        @endif
    </form>

    <div class="overflow-x-auto rounded-2xl border border-slate-200 bg-white shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full min-w-[640px] text-sm">
                <thead class="bg-slate-50 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">
                    <tr>
                        <th class="px-4 py-3">No</th>
                        <th class="px-4 py-3">Tanggal</th>
                        <th class="px-4 py-3">Kerusakan</th>
                        <th class="px-4 py-3">Tingkat</th>
                        <th class="px-4 py-3">%</th>
                        <th class="px-4 py-3">Tindakan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($rows as $i => $r)
                        @php $lbl = diagnosis_tingkat_label($r->confidence !== null ? (float) $r->confidence : null); @endphp
                        <tr class="border-t border-slate-100">
                            <td class="px-4 py-3 text-slate-500">{{ $i + 1 }}</td>
                            <td class="whitespace-nowrap px-4 py-3 text-slate-600">{{ format_date_id($r->tanggal_diagnosa) }}</td>
                            <td class="px-4 py-3 font-medium text-slate-900">{{ $r->hasil_penyakit ? ($namaPenyakit[$r->hasil_penyakit] ?? $r->hasil_penyakit) : '—' }}</td>
                            <td class="px-4 py-3">
                                <span class="inline-flex rounded-full px-2.5 py-0.5 text-xs font-bold
                                    {{ $lbl === 'Berat' ? 'bg-red-100 text-red-800' : ($lbl === 'Sedang' ? 'bg-amber-100 text-amber-900' : 'bg-emerald-100 text-emerald-800') }}">{{ $lbl }}</span>
                            </td>
                            <td class="px-4 py-3 text-slate-600">{{ $r->confidence !== null ? number_format($r->confidence * 100, 1) : '—' }}</td>
                            <td class="whitespace-nowrap px-4 py-3">
                                <a href="/user/riwayat/{{ $r->id }}" class="font-semibold text-brand-600 hover:text-brand-700">Detail</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @if ($rows->isEmpty())
            <p class="px-4 py-10 text-center text-slate-500">Tidak ada data yang cocok.</p>
        @endif
    </div>
</div>
@endsection
