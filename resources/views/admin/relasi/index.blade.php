@extends('layouts.dashboard')
@section('title', 'Data Rule')
@section('content')
<div class="mx-auto max-w-6xl space-y-6">
    <div>
        <h1 class="text-2xl font-bold text-slate-900">Data Rule (Aturan)</h1>
        <p class="mt-1 text-sm text-slate-500">Relasi IF gejala THEN kerusakan untuk forward chaining.</p>
    </div>
    @if (request('success'))<div class="rounded-xl border border-emerald-200 bg-emerald-50 p-4 text-sm text-emerald-900">Berhasil.</div>@endif
    @if (request('notice'))<div class="rounded-xl border border-sky-200 bg-sky-50 p-4 text-sm text-sky-900">{{ request('notice') }}</div>@endif
    @if (request('error'))<div class="rounded-xl border border-red-200 bg-red-50 p-4 text-sm text-red-900">{{ request('error') }}</div>@endif

    <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
        <h2 class="text-lg font-semibold text-slate-900">+ Tambah rule</h2>
        <form method="post" action="/admin/relasi" class="mt-6 grid gap-4 sm:grid-cols-2 lg:grid-cols-[1fr_1fr_auto] lg:items-end">
            @csrf
            <div>
                <label class="mb-1 block text-xs font-semibold uppercase text-slate-500">Kerusakan (THEN)</label>
                <select name="kode_penyakit" required class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-2.5 text-sm focus:border-blue-500 focus:bg-white focus:ring-2 focus:ring-blue-500/20">
                    <option value="">— Pilih —</option>
                    @foreach ($penyakit as $p)
                        <option value="{{ $p->kode_penyakit }}">{{ $p->kode_penyakit }} — {{ $p->nama_penyakit }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="mb-1 block text-xs font-semibold uppercase text-slate-500">Gejala (IF)</label>
                <select name="kode_gejala" required class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-2.5 text-sm focus:border-blue-500 focus:bg-white focus:ring-2 focus:ring-blue-500/20">
                    <option value="">— Pilih —</option>
                    @foreach ($gejala as $g)
                        <option value="{{ $g->kode_gejala }}">{{ $g->kode_gejala }} — {{ $g->nama_gejala }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="h-fit rounded-xl bg-brand-600 px-6 py-2.5 text-sm font-semibold text-white hover:bg-brand-700">Tambah</button>
        </form>
    </div>

    <div class="overflow-x-auto rounded-2xl border border-slate-200 bg-white shadow-sm">
        <table class="w-full min-w-[720px] text-sm">
            <thead class="border-b border-slate-100 bg-slate-50 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">
                <tr><th class="px-4 py-3">No</th><th class="px-4 py-3">IF (Gejala)</th><th class="px-4 py-3">THEN (Kerusakan)</th><th class="px-4 py-3 text-right">Aksi</th></tr>
            </thead>
            <tbody>
                @foreach ($relasi as $i => $r)
                    <tr class="border-t border-slate-100">
                        <td class="px-4 py-3 text-slate-500">{{ $i + 1 }}</td>
                        <td class="px-4 py-3">
                            <span class="inline-block rounded-lg bg-blue-50 px-2 py-1 font-mono text-xs font-semibold text-blue-800">{{ $r->kode_gejala }}</span>
                            <span class="mt-1 block text-xs text-slate-600">{{ $gn[$r->kode_gejala] ?? '' }}</span>
                        </td>
                        <td class="px-4 py-3">
                            <span class="inline-block rounded-lg bg-amber-50 px-2 py-1 font-mono text-xs font-semibold text-amber-900">{{ $r->kode_penyakit }}</span>
                            <span class="mt-1 block text-xs text-slate-600">{{ $pn[$r->kode_penyakit] ?? '' }}</span>
                        </td>
                        <td class="px-4 py-3 text-right">
                            <form method="post" action="/admin/relasi/hapus" onsubmit="return confirm('Hapus relasi?');">@csrf<input type="hidden" name="id" value="{{ $r->id }}"><button type="submit" class="inline-flex h-9 w-9 items-center justify-center rounded-lg border border-red-100 text-red-600 hover:bg-red-50"><i class="bi bi-trash"></i></button></form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
