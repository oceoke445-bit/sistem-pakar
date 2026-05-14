@extends('layouts.dashboard')
@section('title', 'Data Kerusakan')
@section('content')
<div class="mx-auto max-w-6xl space-y-6">
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Data Kerusakan</h1>
            <p class="mt-1 text-sm text-slate-500">Master jenis kerusakan (penyakit).</p>
        </div>
    </div>
    @if (request('success'))
        <div class="rounded-xl border border-emerald-200 bg-emerald-50 p-4 text-sm text-emerald-900">{{ request('success') == '1' ? 'Berhasil disimpan.' : request('success') }}</div>
    @endif
    @if (request('notice'))
        <div class="rounded-xl border border-sky-200 bg-sky-50 p-4 text-sm text-sky-900">{{ request('notice') }}</div>
    @endif
    @if (request('error'))
        <div class="rounded-xl border border-red-200 bg-red-50 p-4 text-sm text-red-900">{{ request('error') }}</div>
    @endif

    <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
        <h2 class="text-lg font-semibold text-slate-900">+ Tambah kerusakan</h2>
        <form method="post" action="/admin/penyakit" class="mt-6 grid gap-4 md:grid-cols-2">
            @csrf
            <div>
                <label class="mb-1 block text-xs font-semibold uppercase text-slate-500">Kode</label>
                <input name="kode_penyakit" required class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-2.5 text-sm focus:border-blue-500 focus:bg-white focus:ring-2 focus:ring-blue-500/20">
            </div>
            <div>
                <label class="mb-1 block text-xs font-semibold uppercase text-slate-500">Nama</label>
                <input name="nama_penyakit" required class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-2.5 text-sm focus:border-blue-500 focus:bg-white focus:ring-2 focus:ring-blue-500/20">
            </div>
            <div class="md:col-span-2">
                <label class="mb-1 block text-xs font-semibold uppercase text-slate-500">Deskripsi</label>
                <textarea name="deskripsi" rows="2" class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-2.5 text-sm focus:border-blue-500 focus:bg-white focus:ring-2 focus:ring-blue-500/20"></textarea>
            </div>
            <div>
                <label class="mb-1 block text-xs font-semibold uppercase text-slate-500">Solusi</label>
                <textarea name="solusi" rows="2" class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-2.5 text-sm focus:border-blue-500 focus:bg-white focus:ring-2 focus:ring-blue-500/20"></textarea>
            </div>
            <div>
                <label class="mb-1 block text-xs font-semibold uppercase text-slate-500">Pencegahan</label>
                <textarea name="pencegahan" rows="2" class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-2.5 text-sm focus:border-blue-500 focus:bg-white focus:ring-2 focus:ring-blue-500/20"></textarea>
            </div>
            <div class="md:col-span-2">
                <button type="submit" class="rounded-xl bg-brand-600 px-6 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-brand-700">Simpan</button>
            </div>
        </form>
    </div>

    @if ($editing)
        <div class="rounded-2xl border border-amber-200 bg-amber-50/50 p-6 shadow-sm">
            <h2 class="text-lg font-semibold text-amber-950">Edit {{ $editing->kode_penyakit }}</h2>
            <form method="post" action="/admin/penyakit/update" class="mt-4 grid gap-4 md:grid-cols-2">
                @csrf
                <input type="hidden" name="kode_penyakit" value="{{ $editing->kode_penyakit }}">
                <div class="md:col-span-2">
                    <label class="mb-1 block text-xs font-semibold uppercase text-slate-500">Nama</label>
                    <input name="nama_penyakit" required value="{{ $editing->nama_penyakit }}" class="w-full rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm">
                </div>
                <div class="md:col-span-2">
                    <label class="mb-1 block text-xs font-semibold uppercase text-slate-500">Deskripsi</label>
                    <textarea name="deskripsi" rows="2" class="w-full rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm">{{ $editing->deskripsi }}</textarea>
                </div>
                <div>
                    <label class="mb-1 block text-xs font-semibold uppercase text-slate-500">Solusi</label>
                    <textarea name="solusi" rows="2" class="w-full rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm">{{ $editing->solusi }}</textarea>
                </div>
                <div>
                    <label class="mb-1 block text-xs font-semibold uppercase text-slate-500">Pencegahan</label>
                    <textarea name="pencegahan" rows="2" class="w-full rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm">{{ $editing->pencegahan }}</textarea>
                </div>
                <div class="md:col-span-2">
                    <button type="submit" class="rounded-xl bg-amber-600 px-6 py-2.5 text-sm font-semibold text-white hover:bg-amber-700">Update</button>
                </div>
            </form>
        </div>
    @endif

    <div class="overflow-x-auto rounded-2xl border border-slate-200 bg-white shadow-sm">
        <table class="w-full min-w-[560px] text-sm">
            <thead class="border-b border-slate-100 bg-slate-50 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">
                <tr><th class="px-4 py-3">No</th><th class="px-4 py-3">Kode</th><th class="px-4 py-3">Nama kerusakan</th><th class="px-4 py-3 text-right">Aksi</th></tr>
            </thead>
            <tbody>
                @foreach ($rows as $i => $row)
                    <tr class="border-t border-slate-100">
                        <td class="px-4 py-3 text-slate-500">{{ $i + 1 }}</td>
                        <td class="px-4 py-3 font-mono text-xs text-slate-600">{{ $row->kode_penyakit }}</td>
                        <td class="px-4 py-3 font-medium text-slate-900">{{ $row->nama_penyakit }}</td>
                        <td class="px-4 py-3 text-right">
                            <a href="/admin/penyakit?edit={{ urlencode($row->kode_penyakit) }}" class="mr-3 inline-flex h-9 w-9 items-center justify-center rounded-lg border border-slate-200 text-brand-600 hover:bg-slate-50" title="Edit"><i class="bi bi-pencil"></i></a>
                            <form method="post" action="/admin/penyakit/hapus" class="inline" onsubmit="return confirm('Hapus?');">
                                @csrf
                                <input type="hidden" name="kode_penyakit" value="{{ $row->kode_penyakit }}">
                                <button type="submit" class="inline-flex h-9 w-9 items-center justify-center rounded-lg border border-red-100 text-red-600 hover:bg-red-50" title="Hapus"><i class="bi bi-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
