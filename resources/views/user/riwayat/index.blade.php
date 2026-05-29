@extends('layouts.dashboard')
@section('title', 'Riwayat Diagnosa')
@section('content')
<div class="mx-auto max-w-6xl space-y-6">

    @include('partials.user-page-header', ['title' => 'Riwayat Diagnosa', 'firstName' => $firstName])

    @if (!empty($notice) || request('notice'))
        <div class="rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-900">
            {{ $notice ?? request('notice') }}
        </div>
    @endif

    <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-[0_4px_24px_rgba(15,23,42,0.06)]">
        <div class="overflow-x-auto">
            <table class="w-full min-w-[720px] text-sm">
                <thead>
                    <tr class="border-b border-slate-200 bg-slate-100 text-left text-sm font-bold text-slate-800">
                        <th class="px-5 py-3.5">No</th>
                        <th class="px-5 py-3.5">Tanggal</th>
                        <th class="px-5 py-3.5">Jenis Kerusakan</th>
                        <th class="px-5 py-3.5">Tingkat</th>
                        <th class="px-5 py-3.5">Rekomendasi</th>
                        <th class="px-5 py-3.5 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($rows as $i => $r)
                        @php
                            $dp = $r->hasil_penyakit ? ($penyakitMap[$r->hasil_penyakit] ?? null) : null;
                            $jenisKerusakan = $dp?->nama_penyakit ?? ($r->hasil_penyakit ?: '—');
                            $tingkatLbl = $dp?->tingkat ? ucfirst(strtolower((string) $dp->tingkat)) : diagnosis_tingkat_label($r->confidence !== null ? (float) $r->confidence : null);
                            $rekomendasi = diagnosa_rekomendasi_label($r->tindakan ?? null, $dp?->tingkat ?? null);
                        @endphp
                        <tr class="border-t border-slate-200 text-slate-800">
                            <td class="px-5 py-4 text-slate-700">{{ $rows->firstItem() + $i }}</td>
                            <td class="whitespace-nowrap px-5 py-4">{{ format_date_id_long($r->tanggal_diagnosa) }}</td>
                            <td class="px-5 py-4">{{ $jenisKerusakan }}</td>
                            <td class="px-5 py-4">{{ $tingkatLbl }}</td>
                            <td class="px-5 py-4">{{ $rekomendasi }}</td>
                            <td class="px-5 py-4 text-center">
                                <a href="/user/riwayat/{{ $r->id }}"
                                   class="text-sm font-semibold text-blue-600 hover:text-blue-700 hover:underline">
                                    Detail
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-5 py-14 text-center text-slate-500">
                                Belum ada riwayat diagnosa. Mulai dari
                                <a href="/user/diagnosa" class="font-semibold text-blue-600 hover:underline">Konsultasi Diagnosa</a>.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($rows->total() > 0)
            @include('partials.pagination', ['paginator' => $rows, 'center' => true])
        @endif
    </div>
</div>
@endsection
