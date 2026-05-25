@extends('layouts.dashboard')
@section('title', 'Data Kerusakan')
@section('content')
@php $q = $q ?? ''; @endphp
<div class="mx-auto max-w-6xl space-y-6">
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-[#152238] sm:text-3xl">Data Kerusakan</h1>
            <p class="mt-1 text-[15px] text-slate-600">Kelola data jenis kerusakan pada printer.</p>
        </div>
        <div>
            <button onclick="toggleForm()" class="inline-flex items-center gap-2 rounded-xl bg-brand-600 px-5 py-3 text-sm font-bold text-white shadow-sm hover:bg-brand-700 transition-all active:scale-95">
                <i class="bi bi-plus-lg"></i> Tambah Kerusakan
            </button>
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

    <form method="get" action="/admin/penyakit" class="flex flex-col gap-3 sm:flex-row sm:items-center bg-transparent p-0 border-0 shadow-none">
        <div class="relative min-w-0 flex-1 w-full">
            <i class="bi bi-search pointer-events-none absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400"></i>
            <input type="search" name="q" value="{{ $q }}" placeholder="Cari kerusakan…"
                   class="w-full rounded-xl border border-slate-200 bg-white py-3 pl-11 pr-4 text-sm outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 shadow-sm">
        </div>
        <div class="flex items-center gap-2 shrink-0">
            <button type="submit" class="rounded-xl bg-brand-600 px-6 py-3 text-sm font-bold text-white shadow-sm hover:bg-brand-700 transition-colors">Cari</button>
            @if ($q !== '')
                <a href="/admin/penyakit" class="rounded-xl border border-slate-200 bg-white px-5 py-3 text-center text-sm font-semibold text-slate-600 hover:bg-slate-50 shadow-sm transition-colors">Reset</a>
            @endif
        </div>
    </form>

    <details id="tambah-form-details" class="hidden group rounded-2xl border border-slate-200/90 bg-white shadow-[0_4px_24px_rgba(15,23,42,0.06)]">
        <summary class="cursor-pointer list-none rounded-2xl px-5 py-4 font-bold text-[#152238] marker:content-none sm:px-6 sm:py-5 [&::-webkit-details-marker]:hidden">
            <span class="inline-flex items-center gap-2"><i class="bi bi-plus-circle text-brand-600"></i> Tambah kerusakan</span>
            <span class="float-right text-sm font-normal text-slate-500 group-open:hidden">Buka form</span>
            <span class="float-right hidden text-sm font-normal text-slate-500 group-open:inline">Tutup</span>
        </summary>
        <div class="border-t border-slate-100 px-5 pb-6 pt-2 sm:px-6">
            <form method="post" action="/admin/penyakit" onsubmit="event.preventDefault(); confirmSave(this, 'Tambah Kerusakan?', 'Apakah Anda yakin ingin menambahkan data jenis kerusakan baru ini?');" class="grid gap-4 md:grid-cols-2">
                @csrf
                <div>
                    <label class="mb-1.5 block text-xs font-bold uppercase tracking-wide text-slate-500">Kode</label>
                    <input name="kode_penyakit" required class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-2.5 text-sm focus:border-blue-500 focus:bg-white focus:ring-2 focus:ring-blue-500/20">
                </div>
                <div>
                    <label class="mb-1.5 block text-xs font-bold uppercase tracking-wide text-slate-500">Nama</label>
                    <input name="nama_penyakit" required class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-2.5 text-sm focus:border-blue-500 focus:bg-white focus:ring-2 focus:ring-blue-500/20">
                </div>
                <div class="md:col-span-2">
                    <label class="mb-1.5 block text-xs font-bold uppercase tracking-wide text-slate-500">Tingkat Kerusakan</label>
                    <select name="tingkat" required class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-2.5 text-sm focus:border-blue-500 focus:bg-white focus:ring-2 focus:ring-blue-500/20">
                        <option value="ringan">Ringan</option>
                        <option value="sedang">Sedang</option>
                        <option value="berat">Berat</option>
                    </select>
                </div>
                <div class="md:col-span-2">
                    <label class="mb-1.5 block text-xs font-bold uppercase tracking-wide text-slate-500">Deskripsi</label>
                    <textarea name="deskripsi" rows="2" class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-2.5 text-sm focus:border-blue-500 focus:bg-white focus:ring-2 focus:ring-blue-500/20"></textarea>
                </div>
                <div>
                    <label class="mb-1.5 block text-xs font-bold uppercase tracking-wide text-slate-500">Solusi</label>
                    <textarea name="solusi" rows="2" class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-2.5 text-sm focus:border-blue-500 focus:bg-white focus:ring-2 focus:ring-blue-500/20"></textarea>
                </div>
                <div>
                    <label class="mb-1.5 block text-xs font-bold uppercase tracking-wide text-slate-500">Pencegahan</label>
                    <textarea name="pencegahan" rows="2" class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-2.5 text-sm focus:border-blue-500 focus:bg-white focus:ring-2 focus:ring-blue-500/20"></textarea>
                </div>
                <div class="md:col-span-2">
                    <button type="submit" class="rounded-xl bg-brand-600 px-6 py-2.5 text-sm font-bold text-white shadow-md hover:bg-brand-700">Simpan</button>
                </div>
            </form>
        </div>
    </details>

    @if ($editing)
        <div class="rounded-2xl border border-amber-200 bg-amber-50/60 p-6 shadow-sm">
            <h2 class="text-lg font-bold text-amber-950">Edit {{ $editing->kode_penyakit }}</h2>
            <form method="post" action="/admin/penyakit/update" onsubmit="event.preventDefault(); confirmUpdate(this, 'Perbarui Kerusakan?', 'Apakah Anda yakin ingin menyimpan perubahan data jenis kerusakan ini?');" class="mt-4 grid gap-4 md:grid-cols-2">
                @csrf
                <input type="hidden" name="kode_penyakit" value="{{ $editing->kode_penyakit }}">
                <div>
                    <label class="mb-1.5 block text-xs font-bold uppercase text-slate-500">Nama</label>
                    <input name="nama_penyakit" required value="{{ $editing->nama_penyakit }}" class="w-full rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm">
                </div>
                <div>
                    <label class="mb-1.5 block text-xs font-bold uppercase text-slate-500">Tingkat Kerusakan</label>
                    <select name="tingkat" required class="w-full rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm">
                        <option value="ringan" @selected(($editing->tingkat ?? '') === 'ringan')>Ringan</option>
                        <option value="sedang" @selected(($editing->tingkat ?? '') === 'sedang')>Sedang</option>
                        <option value="berat" @selected(($editing->tingkat ?? '') === 'berat')>Berat</option>
                    </select>
                </div>
                <div class="md:col-span-2">
                    <label class="mb-1.5 block text-xs font-bold uppercase text-slate-500">Deskripsi</label>
                    <textarea name="deskripsi" rows="2" class="w-full rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm">{{ $editing->deskripsi }}</textarea>
                </div>
                <div>
                    <label class="mb-1.5 block text-xs font-bold uppercase text-slate-500">Solusi</label>
                    <textarea name="solusi" rows="2" class="w-full rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm">{{ $editing->solusi }}</textarea>
                </div>
                <div>
                    <label class="mb-1.5 block text-xs font-bold uppercase text-slate-500">Pencegahan</label>
                    <textarea name="pencegahan" rows="2" class="w-full rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm">{{ $editing->pencegahan }}</textarea>
                </div>
                <div class="md:col-span-2 flex flex-wrap gap-2">
                    <button type="submit" class="rounded-xl bg-amber-600 px-6 py-2.5 text-sm font-bold text-white hover:bg-amber-700">Update</button>
                    <a href="/admin/penyakit{{ $q !== '' ? '?q='.urlencode($q) : '' }}" class="rounded-xl border border-slate-300 bg-white px-5 py-2.5 text-sm font-semibold text-slate-700 hover:bg-slate-50">Batal</a>
                </div>
            </form>
        </div>
    @endif

    <div class="overflow-hidden rounded-2xl border border-slate-200/90 bg-white shadow-[0_4px_24px_rgba(15,23,42,0.06)]">
        <div class="overflow-x-auto">
        <table class="w-full min-w-[560px] text-sm">
            <thead class="border-b border-slate-200 bg-slate-100/90 text-left text-xs font-bold uppercase tracking-wide text-slate-600">
                <tr>
                    <th class="px-4 py-3.5">No</th>
                    <th class="px-4 py-3.5">Kode</th>
                    <th class="px-4 py-3.5">Nama kerusakan</th>
                    <th class="px-4 py-3.5">Tingkat</th>
                    <th class="px-4 py-3.5 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($rows as $i => $row)
                    <tr class="border-t border-slate-100 odd:bg-white even:bg-slate-50/80">
                        <td class="px-4 py-3.5 text-slate-500">{{ $rows->firstItem() + $i }}</td>
                        <td class="px-4 py-3.5 font-mono text-xs text-slate-600">{{ $row->kode_penyakit }}</td>
                        <td class="px-4 py-3.5 font-medium text-slate-900">{{ $row->nama_penyakit }}</td>
                        <td class="px-4 py-3.5">
                            @if (($row->tingkat ?? '') === 'berat')
                                <span class="inline-flex rounded-full bg-red-100 px-2.5 py-0.5 text-xs font-semibold text-red-800">Berat</span>
                            @elseif (($row->tingkat ?? '') === 'sedang')
                                <span class="inline-flex rounded-full bg-amber-100 px-2.5 py-0.5 text-xs font-semibold text-amber-800">Sedang</span>
                            @else
                                <span class="inline-flex rounded-full bg-emerald-100 px-2.5 py-0.5 text-xs font-semibold text-emerald-800">Ringan</span>
                            @endif
                        </td>
                        <td class="px-4 py-3.5">
                            @php $eq = $q !== '' ? '&q='.urlencode($q) : ''; @endphp
                            <div class="flex items-center justify-end gap-2">
                                <a href="/admin/penyakit?edit={{ urlencode($row->kode_penyakit) }}{{ $eq }}" class="inline-flex h-9 w-9 shrink-0 items-center justify-center rounded-lg border border-slate-200 text-brand-600 hover:bg-blue-50" title="Edit"><i class="bi bi-pencil"></i></a>
                                <form method="post" action="/admin/penyakit/hapus" class="inline-flex shrink-0 m-0" onsubmit="event.preventDefault(); confirmDelete(this, 'Hapus Kerusakan?', 'Apakah Anda yakin ingin menghapus data jenis kerusakan ini? Tindakan ini tidak dapat dibatalkan.');">
                                    @csrf
                                    <input type="hidden" name="kode_penyakit" value="{{ $row->kode_penyakit }}">
                                    <button type="submit" class="inline-flex h-9 w-9 shrink-0 items-center justify-center rounded-lg border border-red-100 text-red-600 hover:bg-red-50" title="Hapus"><i class="bi bi-trash"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="px-4 py-12 text-center text-slate-500">Tidak ada data.</td></tr>
                @endforelse
            </tbody>
        </table>
        </div>
        @include('partials.pagination', ['paginator' => $rows])
    </div>
</div>

@push('scripts')
<script>
    function toggleForm() {
        const details = document.getElementById('tambah-form-details');
        if (details) {
            if (details.classList.contains('hidden')) {
                details.classList.remove('hidden');
                details.open = true;
                setTimeout(() => {
                    details.scrollIntoView({ behavior: 'smooth', block: 'center' });
                }, 50);
            } else {
                details.open = false;
            }
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        const details = document.getElementById('tambah-form-details');
        if (details) {
            details.addEventListener('toggle', function() {
                if (!this.open) {
                    this.classList.add('hidden');
                }
            });
        }
    });
</script>
@endpush
@endsection
