@extends('layouts.dashboard')
@section('title', 'Data Printer')
@section('content')
<div class="mx-auto max-w-6xl space-y-6">
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-[#152238] sm:text-3xl">Data Printer</h1>
            <p class="mt-1 text-[15px] text-slate-600">Kelola data unit printer yang digunakan.</p>
        </div>
        <div>
            <button onclick="toggleForm()" class="inline-flex items-center gap-2 rounded-xl bg-brand-600 px-5 py-3 text-sm font-bold text-white shadow-sm hover:bg-brand-700 transition-all active:scale-95">
                <i class="bi bi-plus-lg"></i> Tambah Printer
            </button>
        </div>
    </div>

    @if (request('success'))
        <div class="rounded-xl border border-emerald-200 bg-emerald-50 p-4 text-sm font-medium text-emerald-900 flex items-center gap-2">
            <i class="bi bi-check-circle-fill text-emerald-600"></i> Berhasil memperbarui data printer.
        </div>
    @endif
    @if (request('notice'))
        <div class="rounded-xl border border-sky-200 bg-sky-50 p-4 text-sm font-medium text-sky-900 flex items-center gap-2">
            <i class="bi bi-info-circle-fill text-sky-600"></i> {{ request('notice') }}
        </div>
    @endif
    @if (request('error'))
        <div class="rounded-xl border border-red-200 bg-red-50 p-4 text-sm font-medium text-red-900 flex items-center gap-2">
            <i class="bi bi-exclamation-triangle-fill text-red-600"></i> {{ request('error') }}
        </div>
    @endif

    {{-- Edit Form (Show only when editing) --}}
    @if ($editing)
    <div class="rounded-2xl border border-blue-200 bg-blue-50/30 p-5 shadow-sm sm:p-6">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-lg font-bold text-[#152238] flex items-center gap-2">
                <i class="bi bi-pencil-square text-blue-600"></i> Edit Printer
            </h2>
            <a href="/admin/printer" class="inline-flex h-8 w-8 items-center justify-center rounded-lg hover:bg-blue-100 text-blue-400 hover:text-blue-600 transition-colors" title="Batal">
                <i class="bi bi-x-lg text-[14px]"></i>
            </a>
        </div>
        <form method="post" action="/admin/printer/update" onsubmit="event.preventDefault(); confirmUpdate(this, 'Perbarui Printer?', 'Apakah Anda yakin ingin menyimpan perubahan data printer ini?');" class="grid gap-4 md:grid-cols-4 items-end">
            @csrf
            <input type="hidden" name="id" value="{{ $editing->id }}">
            <div>
                <label class="mb-1.5 block text-xs font-bold uppercase tracking-wider text-slate-500">Nama Printer</label>
                <input name="nama_printer" value="{{ $editing->nama_printer }}" required class="w-full rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-medium text-slate-800 focus:border-brand-500 focus:bg-white focus:outline-none focus:ring-1 focus:ring-brand-500 transition-all">
            </div>
            <div>
                <label class="mb-1.5 block text-xs font-bold uppercase tracking-wider text-slate-500">Model</label>
                <input name="model" value="{{ $editing->model }}" required class="w-full rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-medium text-slate-800 focus:border-brand-500 focus:bg-white focus:outline-none focus:ring-1 focus:ring-brand-500 transition-all">
            </div>
            <div>
                <label class="mb-1.5 block text-xs font-bold uppercase tracking-wider text-slate-500">Lokasi</label>
                <input name="lokasi" value="{{ $editing->lokasi }}" required class="w-full rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-medium text-slate-800 focus:border-brand-500 focus:bg-white focus:outline-none focus:ring-1 focus:ring-brand-500 transition-all">
            </div>
            <div>
                <label class="mb-1.5 block text-xs font-bold uppercase tracking-wider text-slate-500">Status</label>
                <select name="status" class="w-full rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-medium text-slate-800 focus:border-brand-500 focus:bg-white focus:outline-none focus:ring-1 focus:ring-brand-500 transition-all">
                    <option value="aktif" @selected($editing->status === 'aktif')>Aktif</option>
                    <option value="perlu_perawatan" @selected($editing->status === 'perlu_perawatan')>Perlu Perawatan</option>
                </select>
            </div>
            <div class="md:col-span-4 flex justify-end gap-2">
                <a href="/admin/printer" class="rounded-xl border border-slate-200 bg-white px-5 py-2.5 text-sm font-bold text-slate-600 hover:bg-slate-50 transition-colors shadow-sm">Batal</a>
                <button type="submit" class="rounded-xl bg-brand-600 px-6 py-2.5 text-sm font-bold text-white hover:bg-brand-700 transition-colors shadow-sm">Simpan Perubahan</button>
            </div>
        </form>
    </div>
    @endif

    {{-- Add Form (Hidden by default) --}}
    <div id="tambah-form" class="hidden rounded-2xl border border-slate-200/90 bg-white p-5 shadow-[0_4px_24px_rgba(15,23,42,0.06)] sm:p-6">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-lg font-bold text-[#152238] flex items-center gap-2">
                <i class="bi bi-plus-circle text-brand-600"></i> Tambah Printer
            </h2>
            <button type="button" onclick="toggleForm()" class="inline-flex h-8 w-8 items-center justify-center rounded-lg hover:bg-slate-100 text-slate-400 hover:text-slate-600 transition-colors" title="Tutup">
                <i class="bi bi-x-lg text-[14px]"></i>
            </button>
        </div>
        <form method="post" action="/admin/printer" onsubmit="event.preventDefault(); confirmSave(this, 'Tambah Printer?', 'Apakah Anda yakin ingin menambahkan data printer baru ini?');" class="grid gap-4 md:grid-cols-4 items-end">
            @csrf
            <div>
                <label class="mb-1.5 block text-xs font-bold uppercase tracking-wider text-slate-500">Nama Printer</label>
                <input name="nama_printer" required placeholder="Contoh: Unit 5" class="w-full rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-medium text-slate-800 placeholder-slate-400 focus:border-brand-500 focus:bg-white focus:outline-none focus:ring-1 focus:ring-brand-500 transition-all">
            </div>
            <div>
                <label class="mb-1.5 block text-xs font-bold uppercase tracking-wider text-slate-500">Model</label>
                <input name="model" required placeholder="Contoh: Canon IR 3045" class="w-full rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-medium text-slate-800 placeholder-slate-400 focus:border-brand-500 focus:bg-white focus:outline-none focus:ring-1 focus:ring-brand-500 transition-all">
            </div>
            <div>
                <label class="mb-1.5 block text-xs font-bold uppercase tracking-wider text-slate-500">Lokasi</label>
                <input name="lokasi" required placeholder="Contoh: Mesin Fotocopy 5" class="w-full rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-medium text-slate-800 placeholder-slate-400 focus:border-brand-500 focus:bg-white focus:outline-none focus:ring-1 focus:ring-brand-500 transition-all">
            </div>
            <div>
                <label class="mb-1.5 block text-xs font-bold uppercase tracking-wider text-slate-500">Status</label>
                <select name="status" class="w-full rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-medium text-slate-800 focus:border-brand-500 focus:bg-white focus:outline-none focus:ring-1 focus:ring-brand-500 transition-all">
                    <option value="aktif">Aktif</option>
                    <option value="perlu_perawatan">Perlu Perawatan</option>
                </select>
            </div>
            <div class="md:col-span-4 flex justify-end gap-2">
                <button type="button" onclick="toggleForm()" class="rounded-xl border border-slate-200 bg-white px-5 py-2.5 text-sm font-bold text-slate-600 hover:bg-slate-50 transition-colors shadow-sm">Batal</button>
                <button type="submit" class="rounded-xl bg-brand-600 px-6 py-2.5 text-sm font-bold text-white hover:bg-brand-700 transition-colors shadow-sm">Simpan</button>
            </div>
        </form>
    </div>

    {{-- Search Input (Seamless backdrop, transparent bg card container) --}}
    <form method="get" action="/admin/printer" class="flex flex-col gap-3 sm:flex-row sm:items-center bg-transparent p-0 border-0 shadow-none">
        <div class="relative min-w-0 flex-1 w-full">
            <i class="bi bi-search pointer-events-none absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400"></i>
            <input type="search" name="q" value="{{ $q }}" placeholder="Cari printer..."
                   class="w-full rounded-xl border border-slate-200 bg-white py-3 pl-11 pr-4 text-sm outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 shadow-sm">
        </div>
        <div class="flex items-center gap-2 shrink-0">
            <button type="submit" class="rounded-xl bg-brand-600 px-6 py-3 text-sm font-bold text-white shadow-sm hover:bg-brand-700 transition-colors">Cari</button>
            @if ($q !== '')
                <a href="/admin/printer" class="rounded-xl border border-slate-200 bg-white px-5 py-3 text-center text-sm font-semibold text-slate-600 hover:bg-slate-50 shadow-sm transition-colors">Reset</a>
            @endif
        </div>
    </form>

    {{-- Printers Table --}}
    <div class="overflow-x-auto rounded-2xl border border-slate-200/90 bg-white shadow-[0_2px_12px_rgba(15,23,42,0.03)]">
        <table class="w-full min-w-[700px] text-sm">
            <thead class="border-b border-slate-100 bg-slate-50 text-left text-xs font-bold uppercase tracking-wider text-slate-500">
                <tr>
                    <th class="px-5 py-4 w-16 text-center">No</th>
                    <th class="px-5 py-4">Nama Printer</th>
                    <th class="px-5 py-4">Model</th>
                    <th class="px-5 py-4">Lokasi</th>
                    <th class="px-5 py-4 text-center">Status</th>
                    <th class="px-5 py-4 text-center w-32">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse ($rows as $row)
                    <tr class="hover:bg-slate-50/40 transition-colors">
                        <td class="px-5 py-4 text-center font-bold text-slate-400">{{ $loop->iteration }}</td>
                        <td class="px-5 py-4 font-semibold text-slate-800">{{ $row->nama_printer }}</td>
                        <td class="px-5 py-4 text-slate-600 font-medium">{{ $row->model }}</td>
                        <td class="px-5 py-4 text-slate-600 font-medium">{{ $row->lokasi }}</td>
                        <td class="px-5 py-4 text-center">
                            @if ($row->status === 'aktif')
                                <span class="inline-flex items-center rounded-lg bg-emerald-50 px-3 py-1 text-xs font-bold text-emerald-700 border border-emerald-100/50">
                                    Aktif
                                </span>
                            @else
                                <span class="inline-flex items-center rounded-lg bg-amber-50 px-3 py-1 text-xs font-bold text-amber-700 border border-amber-100/50">
                                    Perlu Perawatan
                                </span>
                            @endif
                        </td>
                        <td class="px-5 py-4 text-center">
                            <div class="flex items-center justify-center gap-1.5">
                                <a href="?edit={{ $row->id }}" class="inline-flex h-9 w-9 items-center justify-center rounded-lg border border-blue-100 text-blue-600 hover:bg-blue-50 transition-colors" title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form method="post" action="/admin/printer/hapus" class="inline" onsubmit="event.preventDefault(); confirmDelete(this, 'Hapus Printer?', 'Apakah Anda yakin ingin menghapus unit printer ini? Tindakan ini tidak dapat dibatalkan.');">
                                    @csrf
                                    <input type="hidden" name="id" value="{{ $row->id }}">
                                    <button type="submit" class="inline-flex h-9 w-9 items-center justify-center rounded-lg border border-red-100 text-red-600 hover:bg-red-50 transition-colors" title="Hapus">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-5 py-12 text-center text-slate-500 font-medium">
                            <div class="flex flex-col items-center justify-center gap-2">
                                <i class="bi bi-printer text-3xl text-slate-300"></i>
                                <span>Tidak ada data printer ditemukan.</span>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@push('scripts')
<script>
    function toggleForm() {
        const form = document.getElementById('tambah-form');
        const input = document.querySelector('input[name="nama_printer"]');
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
