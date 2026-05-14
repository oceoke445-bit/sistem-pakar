@extends('layouts.dashboard')
@section('title', 'Data Pengguna')
@section('content')
<div class="mx-auto max-w-6xl space-y-6">
    <div>
        <h1 class="text-2xl font-bold text-slate-900">Data Pengguna</h1>
        <p class="mt-1 text-sm text-slate-500">Akun admin dan pengguna aplikasi.</p>
    </div>
    @if (request('success'))<div class="rounded-xl border border-emerald-200 bg-emerald-50 p-4 text-sm text-emerald-900">Berhasil.</div>@endif
    @if (request('notice'))<div class="rounded-xl border border-sky-200 bg-sky-50 p-4 text-sm text-sky-900">{{ request('notice') }}</div>@endif
    @if (request('error'))<div class="rounded-xl border border-red-200 bg-red-50 p-4 text-sm text-red-900">{{ request('error') }}</div>@endif

    <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
        <h2 class="text-lg font-semibold text-slate-900">+ Tambah pengguna</h2>
        <form method="post" action="/admin/pengguna" class="mt-4 grid gap-4 md:grid-cols-2">
            @csrf
            <div>
                <label class="mb-1 block text-xs font-semibold uppercase text-slate-500">Nama</label>
                <input name="nama_lengkap" required class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-2.5 text-sm">
            </div>
            <div>
                <label class="mb-1 block text-xs font-semibold uppercase text-slate-500">Email</label>
                <input type="email" name="email" required class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-2.5 text-sm">
            </div>
            <div>
                <label class="mb-1 block text-xs font-semibold uppercase text-slate-500">Password</label>
                <input type="password" name="password" required class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-2.5 text-sm">
            </div>
            <div>
                <label class="mb-1 block text-xs font-semibold uppercase text-slate-500">Role</label>
                <select name="role" class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-2.5 text-sm">
                    <option value="user">user</option>
                    <option value="admin">admin</option>
                </select>
            </div>
            <div class="md:col-span-2"><button type="submit" class="rounded-xl bg-brand-600 px-6 py-2.5 text-sm font-semibold text-white hover:bg-brand-700">Simpan</button></div>
        </form>
    </div>

    <div class="overflow-x-auto rounded-2xl border border-slate-200 bg-white shadow-sm">
        <table class="w-full min-w-[640px] text-sm">
            <thead class="border-b border-slate-100 bg-slate-50 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">
                <tr><th class="px-4 py-3">Nama</th><th class="px-4 py-3">Email</th><th class="px-4 py-3">Role</th><th class="px-4 py-3">Aksi</th></tr>
            </thead>
            <tbody>
                @foreach ($users as $u)
                    <tr class="border-t border-slate-100 align-top">
                        <td class="px-4 py-3 font-medium text-slate-900">{{ $u->nama_lengkap }}</td>
                        <td class="px-4 py-3 text-slate-600">{{ $u->email }}</td>
                        <td class="px-4 py-3">
                            <span class="rounded-full bg-slate-100 px-2.5 py-0.5 text-xs font-semibold capitalize text-slate-700">{{ $u->role }}</span>
                        </td>
                        <td class="px-4 py-3">
                            <form method="post" action="/admin/pengguna/update" class="mb-2 flex flex-wrap gap-2">
                                @csrf
                                <input type="hidden" name="id" value="{{ $u->id }}">
                                <input name="nama_lengkap" value="{{ $u->nama_lengkap }}" class="w-32 rounded-lg border border-slate-200 px-2 py-1 text-xs">
                                <input name="email" value="{{ $u->email }}" class="w-40 rounded-lg border border-slate-200 px-2 py-1 text-xs">
                                <select name="role" class="rounded-lg border border-slate-200 px-2 py-1 text-xs">
                                    <option value="user" @selected($u->role==='user')>user</option>
                                    <option value="admin" @selected($u->role==='admin')>admin</option>
                                </select>
                                <input name="password" placeholder="Pwd baru" class="w-28 rounded-lg border border-slate-200 px-2 py-1 text-xs">
                                <button type="submit" class="rounded-lg bg-brand-600 px-3 py-1 text-xs font-semibold text-white">Simpan</button>
                            </form>
                            <form method="post" action="/admin/pengguna/hapus" class="inline" onsubmit="return confirm('Hapus user?');">@csrf<input type="hidden" name="id" value="{{ $u->id }}"><button type="submit" class="text-xs font-semibold text-red-600 hover:underline">Hapus</button></form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
