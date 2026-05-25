@extends('layouts.dashboard')
@section('title', 'Data Gejala')
@section('content')
@php $q = $q ?? ''; @endphp
<div class="mx-auto max-w-6xl space-y-6">
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-[#152238] sm:text-3xl">Data Gejala</h1>
            <p class="mt-1 text-[15px] text-slate-600">Kelola data gejala kerusakan printer.</p>
        </div>
        <div>
            <button onclick="toggleForm()" class="inline-flex items-center gap-2 rounded-xl bg-brand-600 px-5 py-3 text-sm font-bold text-white shadow-sm hover:bg-brand-700 transition-all active:scale-95">
                <i class="bi bi-plus-lg"></i> Tambah Gejala
            </button>
        </div>
    </div>
    @if (request('success'))<div class="rounded-xl border border-emerald-200 bg-emerald-50 p-4 text-sm text-emerald-900">Berhasil.</div>@endif
    @if (request('notice'))<div class="rounded-xl border border-sky-200 bg-sky-50 p-4 text-sm text-sky-900">{{ request('notice') }}</div>@endif
    @if (request('error'))<div class="rounded-xl border border-red-200 bg-red-50 p-4 text-sm text-red-900">{{ request('error') }}</div>@endif

    <form method="get" action="/admin/gejala" class="flex flex-col gap-3 sm:flex-row sm:items-center bg-transparent p-0 border-0 shadow-none">
        <div class="relative min-w-0 flex-1 w-full">
            <i class="bi bi-search pointer-events-none absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400"></i>
            <input type="search" name="q" value="{{ $q }}" placeholder="Cari gejala…"
                   class="w-full rounded-xl border border-slate-200 bg-white py-3 pl-11 pr-4 text-sm outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 shadow-sm">
        </div>
        <div class="flex items-center gap-2 shrink-0">
            <button type="submit" class="rounded-xl bg-brand-600 px-6 py-3 text-sm font-bold text-white shadow-sm hover:bg-brand-700 transition-colors">Cari</button>
            @if ($q !== '')
                <a href="/admin/gejala" class="rounded-xl border border-slate-200 bg-white px-5 py-3 text-center text-sm font-semibold text-slate-600 hover:bg-slate-50 shadow-sm transition-colors">Reset</a>
            @endif
        </div>
    </form>

    <div id="tambah-form" class="hidden rounded-2xl border border-slate-200/90 bg-white p-5 shadow-[0_4px_24px_rgba(15,23,42,0.06)] sm:p-6">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-lg font-bold text-[#152238] flex items-center gap-2">
                <i class="bi bi-plus-circle text-brand-600"></i> Tambah Gejala
            </h2>
            <button type="button" onclick="toggleForm()" class="inline-flex h-8 w-8 items-center justify-center rounded-lg hover:bg-slate-100 text-slate-400 hover:text-slate-600 transition-colors" title="Tutup">
                <i class="bi bi-x-lg text-[14px]"></i>
            </button>
        </div>
        <form method="post" action="/admin/gejala" onsubmit="event.preventDefault(); confirmSave(this, 'Tambah Gejala?', 'Apakah Anda yakin ingin menambahkan data gejala baru ini?');" class="flex flex-wrap items-end gap-3">
            @csrf
            <div>
                <label class="mb-1.5 block text-xs font-bold uppercase text-slate-500">Kode</label>
                <input name="kode_gejala" placeholder="G001" required class="w-36 rounded-xl border border-slate-200 bg-slate-50 px-4 py-2.5 text-sm focus:border-blue-500 focus:bg-white focus:ring-2 focus:ring-blue-500/20">
            </div>
            <div class="min-w-[200px] flex-1">
                <label class="mb-1.5 block text-xs font-bold uppercase text-slate-500">Nama gejala</label>
                <input name="nama_gejala" required class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-2.5 text-sm focus:border-blue-500 focus:bg-white focus:ring-2 focus:ring-blue-500/20">
            </div>
            <button type="submit" class="rounded-xl bg-brand-600 px-6 py-2.5 text-sm font-bold text-white shadow-md hover:bg-brand-700">Tambah</button>
        </form>
    </div>

    @if ($editing)
        <div class="rounded-2xl border border-amber-200 bg-amber-50/60 p-6">
            <h2 class="font-bold text-amber-950">Edit {{ $editing->kode_gejala }}</h2>
            <form method="post" action="/admin/gejala/update" onsubmit="event.preventDefault(); confirmUpdate(this, 'Perbarui Gejala?', 'Apakah Anda yakin ingin menyimpan perubahan data gejala ini?');" class="mt-4 flex flex-wrap items-end gap-3">
                @csrf
                <input type="hidden" name="kode_gejala" value="{{ $editing->kode_gejala }}">
                <input name="nama_gejala" value="{{ $editing->nama_gejala }}" required class="min-w-[200px] flex-1 rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm">
                <button type="submit" class="rounded-xl bg-amber-600 px-6 py-2.5 text-sm font-bold text-white">Update</button>
                <a href="/admin/gejala{{ $q !== '' ? '?q='.urlencode($q) : '' }}" class="rounded-xl border border-slate-300 bg-white px-5 py-2.5 text-sm font-semibold text-slate-700">Batal</a>
            </form>
        </div>
    @endif

    <div class="overflow-hidden rounded-2xl border border-slate-200/90 bg-white shadow-[0_4px_24px_rgba(15,23,42,0.06)]">
        <div class="overflow-x-auto">
        <table class="w-full min-w-[560px] text-sm">
            <thead class="border-b border-slate-200 bg-slate-100/90 text-left text-xs font-bold uppercase tracking-wide text-slate-600">
                <tr><th class="px-4 py-3.5">No</th><th class="px-4 py-3.5">Kode</th><th class="px-4 py-3.5">Nama gejala</th><th class="px-4 py-3.5 text-right">Aksi</th></tr>
            </thead>
            <tbody>
                @php $gq = $q !== '' ? '&q='.urlencode($q) : ''; @endphp
                @forelse ($rows as $i => $row)
                    <tr class="border-t border-slate-100 odd:bg-white even:bg-slate-50/80">
                        <td class="px-4 py-3.5 text-slate-500">{{ $rows->firstItem() + $i }}</td>
                        <td class="px-4 py-3.5 font-mono text-xs">{{ $row->kode_gejala }}</td>
                        <td class="px-4 py-3.5 font-medium text-slate-900">{{ $row->nama_gejala }}</td>
                        <td class="px-4 py-3.5">
                            <div class="flex items-center justify-end gap-2">
                                <a href="/admin/gejala?edit={{ urlencode($row->kode_gejala) }}{{ $gq }}" class="inline-flex h-9 w-9 shrink-0 items-center justify-center rounded-lg border border-slate-200 text-brand-600 hover:bg-blue-50"><i class="bi bi-pencil"></i></a>
                                <form method="post" action="/admin/gejala/hapus" class="inline-flex shrink-0 m-0" onsubmit="event.preventDefault(); confirmDelete(this, 'Hapus Gejala?', 'Apakah Anda yakin ingin menghapus data gejala ini? Tindakan ini tidak dapat dibatalkan.');">@csrf<input type="hidden" name="kode_gejala" value="{{ $row->kode_gejala }}"><button type="submit" class="inline-flex h-9 w-9 shrink-0 items-center justify-center rounded-lg border border-red-100 text-red-600 hover:bg-red-50"><i class="bi bi-trash"></i></button></form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="px-4 py-12 text-center text-slate-500">Tidak ada data.</td></tr>
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
        const form = document.getElementById('tambah-form');
        const input = document.querySelector('input[name="kode_gejala"]');
        if (form) {
            if (form.classList.contains('hidden')) {
                form.classList.remove('hidden');
                form.scrollIntoView({ behavior: 'smooth', block: 'center' });
                setTimeout(() => {
                    if (input) input.focus();
                }, 300);
            } else {
                form.classList.add('hidden');
            }
        }
    }
</script>
@endpush
@endsection
