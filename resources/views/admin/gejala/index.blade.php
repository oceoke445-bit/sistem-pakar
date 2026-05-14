@extends('layouts.dashboard')
@section('title', 'Data Gejala')
@section('content')
<div class="mx-auto max-w-6xl space-y-6">
    <div>
        <h1 class="text-2xl font-bold text-slate-900">Data Gejala</h1>
        <p class="mt-1 text-sm text-slate-500">Gejala yang dapat dipilih pengguna saat diagnosa.</p>
    </div>
    @if (request('success'))<div class="rounded-xl border border-emerald-200 bg-emerald-50 p-4 text-sm text-emerald-900">Berhasil.</div>@endif
    @if (request('notice'))<div class="rounded-xl border border-sky-200 bg-sky-50 p-4 text-sm text-sky-900">{{ request('notice') }}</div>@endif
    @if (request('error'))<div class="rounded-xl border border-red-200 bg-red-50 p-4 text-sm text-red-900">{{ request('error') }}</div>@endif

    <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
        <h2 class="text-lg font-semibold text-slate-900">+ Tambah gejala</h2>
        <form method="post" action="/admin/gejala" class="mt-4 flex flex-wrap items-end gap-3">
            @csrf
            <div>
                <label class="mb-1 block text-xs font-semibold uppercase text-slate-500">Kode</label>
                <input name="kode_gejala" placeholder="G001" required class="w-36 rounded-xl border border-slate-200 bg-slate-50 px-4 py-2.5 text-sm focus:border-blue-500 focus:bg-white focus:ring-2 focus:ring-blue-500/20">
            </div>
            <div class="min-w-[200px] flex-1">
                <label class="mb-1 block text-xs font-semibold uppercase text-slate-500">Nama gejala</label>
                <input name="nama_gejala" required class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-2.5 text-sm focus:border-blue-500 focus:bg-white focus:ring-2 focus:ring-blue-500/20">
            </div>
            <button type="submit" class="rounded-xl bg-brand-600 px-6 py-2.5 text-sm font-semibold text-white hover:bg-brand-700">Tambah</button>
        </form>
    </div>

    @if ($editing)
        <div class="rounded-2xl border border-amber-200 bg-amber-50/50 p-6">
            <h2 class="font-semibold text-amber-950">Edit {{ $editing->kode_gejala }}</h2>
            <form method="post" action="/admin/gejala/update" class="mt-4 flex flex-wrap items-end gap-3">
                @csrf
                <input type="hidden" name="kode_gejala" value="{{ $editing->kode_gejala }}">
                <input name="nama_gejala" value="{{ $editing->nama_gejala }}" required class="min-w-[200px] flex-1 rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm">
                <button type="submit" class="rounded-xl bg-amber-600 px-6 py-2.5 text-sm font-semibold text-white">Update</button>
            </form>
        </div>
    @endif

    <div class="overflow-x-auto rounded-2xl border border-slate-200 bg-white shadow-sm">
        <table class="w-full min-w-[560px] text-sm">
            <thead class="border-b border-slate-100 bg-slate-50 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">
                <tr><th class="px-4 py-3">No</th><th class="px-4 py-3">Kode</th><th class="px-4 py-3">Nama gejala</th><th class="px-4 py-3 text-right">Aksi</th></tr>
            </thead>
            <tbody>
                @foreach ($rows as $i => $row)
                    <tr class="border-t border-slate-100">
                        <td class="px-4 py-3 text-slate-500">{{ $i + 1 }}</td>
                        <td class="px-4 py-3 font-mono text-xs">{{ $row->kode_gejala }}</td>
                        <td class="px-4 py-3 font-medium text-slate-900">{{ $row->nama_gejala }}</td>
                        <td class="px-4 py-3 text-right">
                            <a href="/admin/gejala?edit={{ urlencode($row->kode_gejala) }}" class="mr-2 inline-flex h-9 w-9 items-center justify-center rounded-lg border border-slate-200 text-brand-600 hover:bg-slate-50"><i class="bi bi-pencil"></i></a>
                            <form method="post" action="/admin/gejala/hapus" class="inline" onsubmit="return confirm('Hapus?');">@csrf<input type="hidden" name="kode_gejala" value="{{ $row->kode_gejala }}"><button type="submit" class="inline-flex h-9 w-9 items-center justify-center rounded-lg border border-red-100 text-red-600 hover:bg-red-50"><i class="bi bi-trash"></i></button></form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
