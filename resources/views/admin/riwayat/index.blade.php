@extends('layouts.dashboard')
@section('title', 'Riwayat Admin')
@section('content')
<div class="mx-auto max-w-6xl space-y-6">
    <div>
        <h1 class="text-2xl font-bold text-slate-900">Riwayat Diagnosa</h1>
        <p class="mt-1 text-sm text-slate-500">Semua diagnosa dari pengguna.</p>
    </div>
    @if (request('notice'))<div class="rounded-xl border border-sky-200 bg-sky-50 p-4 text-sm text-sky-900">{{ request('notice') }}</div>@endif

    <div class="overflow-x-auto rounded-2xl border border-slate-200 bg-white shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full min-w-[720px] text-sm">
                <thead class="border-b border-slate-100 bg-slate-50 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">
                    <tr><th class="px-4 py-3">No</th><th class="px-4 py-3">Tanggal</th><th class="px-4 py-3">Pengguna</th><th class="px-4 py-3">Kerusakan</th><th class="px-4 py-3">Tingkat</th><th class="px-4 py-3">%</th><th class="px-4 py-3">Tindakan</th></tr>
                </thead>
                <tbody>
                    @foreach ($rows as $i => $r)
                        @php $lbl = diagnosis_tingkat_label($r->confidence !== null ? (float) $r->confidence : null); @endphp
                        <tr class="border-t border-slate-100">
                            <td class="px-4 py-3 text-slate-500">{{ $i + 1 }}</td>
                            <td class="whitespace-nowrap px-4 py-3 text-slate-600">{{ format_date_id($r->tanggal_diagnosa) }}</td>
                            <td class="px-4 py-3 font-medium text-slate-900">{{ $namaUser[$r->id_user] ?? '—' }}</td>
                            <td class="max-w-xs px-4 py-3 text-slate-800">{{ $r->hasil_penyakit ? ($namaPenyakit[$r->hasil_penyakit] ?? $r->hasil_penyakit) : '—' }}</td>
                            <td class="px-4 py-3">
                                <span class="inline-flex rounded-full px-2 py-0.5 text-xs font-bold {{ $lbl === 'Berat' ? 'bg-red-100 text-red-800' : ($lbl === 'Sedang' ? 'bg-amber-100 text-amber-900' : 'bg-emerald-100 text-emerald-800') }}">{{ $lbl }}</span>
                            </td>
                            <td class="px-4 py-3 text-slate-600">{{ $r->confidence !== null ? number_format($r->confidence * 100, 1) : '—' }}</td>
                            <td class="whitespace-nowrap px-4 py-3">
                                <a href="/admin/diagnosa/{{ $r->id }}" class="font-semibold text-brand-600 hover:text-brand-700">Detail</a>
                                <form method="post" action="/admin/riwayat/hapus" class="ml-3 inline" onsubmit="return confirm('Hapus?');">@csrf<input type="hidden" name="id" value="{{ $r->id }}"><button type="submit" class="text-xs font-semibold text-red-600 hover:underline">Hapus</button></form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
