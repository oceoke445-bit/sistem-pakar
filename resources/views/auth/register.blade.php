@extends('layouts.guest')
@section('title', 'Daftar | '.config('app.name', 'Sistem Pakar'))
@section('content')
@php $printerUrl = asset('images/printer.jpg'); @endphp
<div class="grid min-h-screen lg:min-h-0 lg:grid-cols-2">
    <div class="relative hidden min-h-0 flex-col justify-between overflow-hidden bg-sidebar px-8 py-10 text-white sm:px-10 lg:flex lg:py-12">
        <div class="pointer-events-none absolute inset-0 bg-gradient-to-br from-blue-500/20 via-transparent to-navy-950/90"></div>
        <div class="relative z-10 max-w-md">
            <p class="text-[11px] font-bold uppercase tracking-[0.28em] text-blue-200/95">Sistem Pakar</p>
            <h1 class="mt-3 text-3xl font-bold leading-[1.15] tracking-tight sm:text-4xl">Buat akun pengguna</h1>
            <p class="mt-4 text-[15px] leading-relaxed text-slate-300/95">
                Setelah terdaftar, Anda dapat menjalankan diagnosa kerusakan printer dan melihat riwayat hasil kapan saja.
            </p>
        </div>
        <div class="relative z-10 flex flex-1 items-center justify-center py-10">
            <div class="rounded-3xl border border-white/10 bg-white/[0.06] p-8 shadow-2xl backdrop-blur-md sm:p-12">
                <img src="{{ $printerUrl }}" alt="Ilustrasi printer" class="mx-auto h-auto w-[min(100%,220px)] max-w-[260px] object-contain drop-shadow-2xl" width="260" height="260" decoding="async">
            </div>
        </div>
        <p class="relative z-10 text-xs text-slate-500">&copy; {{ date('Y') }} {{ config('app.name', 'Sistem Pakar') }}</p>
    </div>
    <div class="flex flex-col justify-center px-5 py-10 sm:px-8 lg:px-14 lg:py-12">
        <div class="mx-auto w-full max-w-md">
            <div class="mb-8 flex items-center gap-4 lg:hidden">
                <div class="flex h-14 w-14 shrink-0 items-center justify-center overflow-hidden rounded-2xl bg-sidebar shadow-lg">
                    <img src="{{ $printerUrl }}" alt="" class="h-11 w-11 object-contain" width="44" height="44" decoding="async">
                </div>
                <div>
                    <p class="text-[11px] font-bold uppercase tracking-[0.22em] text-blue-600">Sistem Pakar</p>
                    <h1 class="mt-0.5 text-2xl font-bold tracking-tight text-slate-900">Daftar</h1>
                </div>
            </div>
            <h1 class="mb-1 hidden text-2xl font-bold tracking-tight text-slate-900 lg:block">Daftar</h1>
            <p class="mb-8 text-[15px] leading-relaxed text-slate-500">Lengkapi data di bawah ini untuk membuat akun.</p>
            @if (!empty($error) || session('error'))
                <div class="mb-4 rounded-xl border border-red-200 bg-red-50 p-3.5 text-sm leading-relaxed text-red-950">{{ $error ?? session('error') }}</div>
            @endif
            <form method="post" action="/register" class="space-y-4 rounded-2xl border border-slate-200/90 bg-white p-7 shadow-sm sm:p-8">
                @csrf
                <div>
                    <label class="mb-2 block text-sm font-semibold text-slate-800">Nama lengkap</label>
                    <input name="nama_lengkap" required class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-[15px] outline-none ring-blue-600/15 focus:border-blue-500 focus:bg-white focus:ring-4" value="{{ old('nama_lengkap') }}">
                </div>
                <div>
                    <label class="mb-2 block text-sm font-semibold text-slate-800">Email</label>
                    <input type="email" name="email" required class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-[15px] outline-none ring-blue-600/15 focus:border-blue-500 focus:bg-white focus:ring-4" value="{{ old('email') }}">
                </div>
                <div>
                    <label class="mb-2 block text-sm font-semibold text-slate-800">Password</label>
                    <input type="password" name="password" required class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-[15px] outline-none ring-blue-600/15 focus:border-blue-500 focus:bg-white focus:ring-4">
                </div>
                <button type="submit" class="w-full rounded-xl bg-brand-600 py-3.5 text-sm font-semibold text-white shadow-md hover:bg-brand-700">Daftar</button>
            </form>
            <p class="mt-6 text-center text-[15px] text-slate-500">
                Sudah punya akun? <a href="/login" class="font-semibold text-brand-600 hover:text-brand-700">Masuk</a>
            </p>
        </div>
    </div>
</div>
@endsection
