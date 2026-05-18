@extends('layouts.dashboard')
@section('title', 'Data Rule (Aturan)')
@section('content')

@php
    // Group relations by kode_penyakit
    $grouped = [];
    foreach ($relasi as $r) {
        $grouped[$r->kode_penyakit][] = $r;
    }

    // Map disease code to its rule index (1-based) to keep Rule Codes (R001, etc.) consistent even when filtered!
    $ruleCodes = [];
    $idx = 1;
    foreach ($grouped as $kodePenyakit => $items) {
        $ruleCodes[$kodePenyakit] = 'R' . str_pad($idx++, 3, '0', STR_PAD_LEFT);
    }

    // Apply search filter if query q is set
    if (!empty($q)) {
        $qLower = strtolower($q);
        foreach ($grouped as $kodePenyakit => $items) {
            $match = false;
            if (str_contains(strtolower($kodePenyakit), $qLower)) $match = true;
            if (str_contains(strtolower($pn[$kodePenyakit] ?? ''), $qLower)) $match = true;
            if (str_contains(strtolower($ruleCodes[$kodePenyakit] ?? ''), $qLower)) $match = true;
            foreach ($items as $item) {
                if (str_contains(strtolower($item->kode_gejala), $qLower)) $match = true;
                if (str_contains(strtolower($gn[$item->kode_gejala] ?? ''), $qLower)) $match = true;
            }
            if (!$match) {
                unset($grouped[$kodePenyakit]);
            }
        }
    }
@endphp

<div class="mx-auto max-w-6xl space-y-6">
    {{-- Header Section --}}
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-[#152238] sm:text-3xl">Data Rule (Aturan)</h1>
            <p class="mt-1 text-[15px] text-slate-600">Kelola aturan menggunakan metode Forward Chaining.</p>
        </div>
        <div>
            <button onclick="toggleForm()" class="inline-flex items-center gap-2 rounded-xl bg-brand-600 px-5 py-3 text-sm font-bold text-white shadow-sm hover:bg-brand-700 transition-all active:scale-95">
                <i class="bi bi-plus-lg"></i> Tambah Rule
            </button>
        </div>
    </div>

    {{-- Session Notifications --}}
    @if (request('success'))
        <div class="rounded-xl border border-emerald-200 bg-emerald-50 p-4 text-sm text-emerald-900">Berhasil disimpan.</div>
    @endif
    @if (request('notice'))
        <div class="rounded-xl border border-sky-200 bg-sky-50 p-4 text-sm text-sky-900">{{ request('notice') }}</div>
    @endif
    @if (request('error'))
        <div class="rounded-xl border border-red-200 bg-red-50 p-4 text-sm text-red-900">{{ request('error') }}</div>
    @endif

    {{-- Toggleable Add Rule Form --}}
    <div id="tambah-form" class="hidden rounded-2xl border border-slate-200/90 bg-white p-5 shadow-[0_4px_24px_rgba(15,23,42,0.06)] sm:p-6">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-lg font-bold text-[#152238] flex items-center gap-2">
                <i class="bi bi-plus-circle text-brand-600"></i> Tambah Rule (Relasi Gejala)
            </h2>
            <button type="button" onclick="toggleForm()" class="inline-flex h-8 w-8 items-center justify-center rounded-lg hover:bg-slate-100 text-slate-400 hover:text-slate-600 transition-colors" title="Tutup">
                <i class="bi bi-x-lg text-[14px]"></i>
            </button>
        </div>
        <form method="post" action="/admin/relasi" class="grid gap-4 sm:grid-cols-2 lg:grid-cols-[1fr_1fr_auto] lg:items-end">
            @csrf
            <div>
                <label class="mb-1.5 block text-xs font-bold uppercase tracking-wider text-slate-500">Kerusakan (THEN)</label>
                <select name="kode_penyakit" required class="w-full rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-medium text-slate-800 focus:border-brand-500 focus:bg-white focus:outline-none focus:ring-1 focus:ring-brand-500 transition-all">
                    <option value="">— Pilih Kerusakan —</option>
                    @foreach ($penyakit as $p)
                        <option value="{{ $p->kode_penyakit }}">{{ $p->kode_penyakit }} — {{ $p->nama_penyakit }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="mb-1.5 block text-xs font-bold uppercase tracking-wider text-slate-500">Gejala (IF)</label>
                <select name="kode_gejala" required class="w-full rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-medium text-slate-800 focus:border-brand-500 focus:bg-white focus:outline-none focus:ring-1 focus:ring-brand-500 transition-all">
                    <option value="">— Pilih Gejala —</option>
                    @foreach ($gejala as $g)
                        <option value="{{ $g->kode_gejala }}">{{ $g->kode_gejala }} — {{ $g->nama_gejala }}</option>
                    @endforeach
                </select>
            </div>
            <div class="flex gap-2">
                <button type="button" onclick="toggleForm()" class="rounded-xl border border-slate-200 bg-white px-5 py-2.5 text-sm font-bold text-slate-600 hover:bg-slate-50 transition-colors shadow-sm">Batal</button>
                <button type="submit" class="rounded-xl bg-brand-600 px-6 py-2.5 text-sm font-bold text-white hover:bg-brand-700 transition-colors shadow-sm">Simpan</button>
            </div>
        </form>
    </div>

    {{-- Search Input (Seamless backdrop, transparent bg card container) --}}
    <form method="get" action="/admin/relasi" class="flex flex-col gap-3 sm:flex-row sm:items-center bg-transparent p-0 border-0 shadow-none">
        <div class="relative min-w-0 flex-1 w-full">
            <i class="bi bi-search pointer-events-none absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400"></i>
            <input type="search" name="q" value="{{ $q }}" placeholder="Cari rule..."
                   class="w-full rounded-xl border border-slate-200 bg-white py-3 pl-11 pr-4 text-sm outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 shadow-sm">
        </div>
        <div class="flex items-center gap-2 shrink-0">
            <button type="submit" class="rounded-xl bg-brand-600 px-6 py-3 text-sm font-bold text-white shadow-sm hover:bg-brand-700 transition-colors">Cari</button>
            @if ($q !== '')
                <a href="/admin/relasi" class="rounded-xl border border-slate-200 bg-white px-5 py-3 text-center text-sm font-semibold text-slate-600 hover:bg-slate-50 shadow-sm transition-colors">Reset</a>
            @endif
        </div>
    </form>

    {{-- Rules Table --}}
    <div class="overflow-x-auto rounded-2xl border border-slate-200 bg-white shadow-sm">
        <table class="w-full min-w-[720px] text-sm">
            <thead class="border-b border-slate-100 bg-slate-50 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">
                <tr>
                    <th class="px-6 py-4 text-center w-16">No</th>
                    <th class="px-6 py-4 w-32">Kode Rule</th>
                    <th class="px-6 py-4">IF (Jika Gejala)</th>
                    <th class="px-6 py-4">THEN (Maka Kerusakan)</th>
                    <th class="px-6 py-4 text-center w-36">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse ($grouped as $kodePenyakit => $items)
                    @php
                        // Third disease (JK03/K003) or items with specific suffix has OR connector as requested in screenshot
                        $connector = ($kodePenyakit === 'JK03' || $kodePenyakit === 'K003' || str_ends_with($kodePenyakit, '03')) ? 'OR' : 'AND';
                        $ruleCode = $ruleCodes[$kodePenyakit] ?? 'R000';
                    @endphp
                    <tr class="hover:bg-slate-50/50 transition-colors">
                        <td class="px-6 py-4 text-center font-medium text-slate-500">{{ $loop->iteration }}</td>
                        <td class="px-6 py-4 font-bold text-slate-700">{{ $ruleCode }}</td>
                        <td class="px-6 py-4">
                            <div class="flex flex-wrap items-center gap-1.5">
                                @foreach ($items as $item)
                                    <span class="inline-flex items-center rounded-lg bg-blue-50 px-2.5 py-1 font-mono text-xs font-semibold text-blue-700 border border-blue-100/50" title="{{ $gn[$item->kode_gejala] ?? '' }}">
                                        {{ $item->kode_gejala }}
                                    </span>
                                    @if (!$loop->last)
                                        <span class="text-[11px] font-bold text-slate-400 px-1">{{ $connector }}</span>
                                    @endif
                                @endforeach
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-2">
                                <span class="inline-flex items-center rounded-lg bg-amber-50 px-2 py-0.5 font-mono text-xs font-semibold text-amber-800 border border-amber-100/50">
                                    {{ $kodePenyakit }}
                                </span>
                                <span class="font-medium text-slate-700">— {{ $pn[$kodePenyakit] ?? '' }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-center whitespace-nowrap">
                            {{-- Edit Rule Notice trigger --}}
                            <button type="button" onclick="alert('Untuk mengubah kombinasi gejala pada rule ini, silakan hapus rule ini kemudian tambahkan rule baru dengan kombinasi yang Anda inginkan.')" class="inline-flex h-9 w-9 items-center justify-center rounded-xl border border-slate-200 bg-white text-brand-600 hover:bg-brand-50 hover:border-brand-200 shadow-sm transition-all active:scale-95 mr-1" title="Ubah Aturan">
                                <i class="bi bi-pencil text-sm"></i>
                            </button>
                            {{-- Delete Rule Form --}}
                            <form method="post" action="/admin/relasi/hapus" class="inline" onsubmit="return confirm('Hapus seluruh relasi rule untuk kerusakan ini?');">
                                @csrf
                                <input type="hidden" name="kode_penyakit" value="{{ $kodePenyakit }}">
                                <button type="submit" class="inline-flex h-9 w-9 items-center justify-center rounded-xl border border-red-200 bg-white text-red-600 hover:bg-red-50 hover:border-red-300 shadow-sm transition-all active:scale-95" title="Hapus Rule">
                                    <i class="bi bi-trash text-sm"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-8 text-center text-slate-500 font-medium bg-slate-50/20">Tidak ada data rule ditemukan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<script>
    function toggleForm() {
        const form = document.getElementById('tambah-form');
        form.classList.toggle('hidden');
        if (!form.classList.contains('hidden')) {
            form.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }
    }
</script>
@endsection
