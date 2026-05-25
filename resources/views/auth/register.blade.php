@extends('layouts.guest')
@section('title', 'Daftar | '.config('app.name', 'Sistem Pakar'))
@section('content')
<style>
    input[type="password"]::-ms-reveal,
    input[type="password"]::-ms-clear {
        display: none !important;
    }
</style>
@php
    $printerUrl = asset('images/printer.png');
    $logoUrl = asset('images/logo.png');
    $brand = config('app.name', 'Sistem Pakar');
    $tagline = config('app.tagline', 'Diagnosa Kerusakan Printer pada Fotocopy Berkah Andirra');
@endphp

<div class="grid min-h-screen grid-cols-1 bg-white lg:grid-cols-2">
    {{-- Left Panel: sama dengan halaman login --}}
    <div class="relative flex min-h-0 flex-col items-center justify-center overflow-hidden bg-gradient-to-br from-[#0e3d78] to-[#092c57] px-8 py-12 text-white sm:px-12 sm:py-16 lg:min-h-screen lg:px-16 lg:py-12">

        <div class="absolute left-6 top-8 text-[#60a5fa]/10 pointer-events-none">
            <svg class="h-24 w-24" fill="none" stroke="currentColor" stroke-width="1.2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
            </svg>
        </div>

        <div class="absolute left-8 top-1/3 text-[#60a5fa]/10 pointer-events-none">
            <svg class="h-16 w-16" fill="none" stroke="currentColor" stroke-width="1.2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
            </svg>
        </div>

        <div class="absolute right-8 top-1/4 text-[#60a5fa]/10 pointer-events-none">
            <svg class="h-20 w-20" fill="none" stroke="currentColor" stroke-width="1.2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
            </svg>
        </div>

        <div class="absolute right-12 bottom-12 text-[#60a5fa]/10 pointer-events-none">
            <svg class="h-24 w-24" fill="none" stroke="currentColor" stroke-width="1.2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
            </svg>
        </div>

        <div class="relative z-10 flex w-full max-w-xl sm:max-w-2xl flex-col items-center gap-8 sm:gap-12 text-center">
            <header class="w-full space-y-4">
                <h1 class="text-3xl sm:text-4xl font-extrabold uppercase tracking-wider text-white">
                    SISTEM PAKAR
                </h1>
                <p class="text-xl sm:text-2xl md:text-3xl font-semibold text-white/95 max-w-2xl mx-auto leading-relaxed">
                    Diagnosa Kerusakan Printer<br class="hidden sm:inline"> pada Fotocopy Berkah Andirra
                </p>
            </header>

            <div class="flex w-full justify-center px-4">
                <img src="{{ $printerUrl }}" alt="Printer"
                     class="h-auto w-full max-w-[260px] object-contain drop-shadow-[0_20px_50px_rgba(0,0,0,0.3)] sm:max-w-[300px] md:max-w-[340px] transition duration-500 hover:scale-[1.03]"
                     width="400" height="400" decoding="async">
            </div>

            <p class="text-sm sm:text-base font-normal tracking-wide text-white/90">
                Metode Forward Chaining
            </p>
        </div>
    </div>

    {{-- Right Panel: layout identik dengan login --}}
    <div class="relative flex min-h-screen flex-col items-center bg-[#f8fafc] px-6 pt-12 pb-14 sm:px-12 sm:pt-16 sm:pb-16 lg:px-16 lg:pt-[4.5rem]">
        <div class="flex w-full max-w-[420px] flex-col items-center">

            <div class="mb-8 w-full text-center">
                <img src="{{ $logoUrl }}" alt="Logo Fotocopy Berkah Andirra"
                     class="mx-auto mb-5 h-24 w-24 object-contain sm:h-28 sm:w-28"
                     width="112" height="112" decoding="async">
                <h2 class="text-2xl font-extrabold tracking-tight text-[#133075] sm:text-3xl">Daftar Akun</h2>
                <p class="mt-2 min-h-[2.5rem] text-sm font-normal text-slate-500 sm:text-base">Buat akun untuk mulai menggunakan diagnosa</p>
            </div>

            <div class="w-full rounded-2xl border border-slate-100/80 bg-white p-6 shadow-[0_8px_30px_rgba(0,0,0,0.02)] sm:p-8">

                @if (!empty($error) || session('error'))
                    <div class="mb-5 rounded-lg border border-amber-200 bg-amber-50 p-3.5 text-sm text-amber-900">{{ $error ?? session('error') }}</div>
                @endif

                <form method="post" action="/register" class="space-y-5" id="form-register">
                    @csrf
                    <div>
                        <label class="mb-2 block text-xs sm:text-sm font-semibold text-slate-800 text-left">Nama Lengkap</label>
                        <input type="text" name="nama_lengkap" required autocomplete="name"
                               class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3.5 text-sm text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-[#1d4ed8] focus:ring-4 focus:ring-[#1d4ed8]/10"
                               value="{{ old('nama_lengkap') }}" placeholder="Masukkan nama lengkap">
                    </div>
                    <div>
                        <label class="mb-2 block text-xs sm:text-sm font-semibold text-slate-800 text-left">Email</label>
                        <input type="email" name="email" required autocomplete="email"
                               class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3.5 text-sm text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-[#1d4ed8] focus:ring-4 focus:ring-[#1d4ed8]/10"
                               value="{{ old('email') }}" placeholder="Masukkan email">
                    </div>
                    <div>
                        <label class="mb-2 block text-xs sm:text-sm font-semibold text-slate-800 text-left">Password</label>
                        <div class="relative">
                            <input id="register-password" type="password" name="password" required autocomplete="new-password"
                                   class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3.5 pr-12 text-sm text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-[#1d4ed8] focus:ring-4 focus:ring-[#1d4ed8]/10"
                                   placeholder="Masukkan password">
                            <button type="button" id="register-password-toggle" class="absolute right-3 top-1/2 flex h-8 w-8 -translate-y-1/2 items-center justify-center rounded-md text-slate-400 transition hover:bg-slate-100 hover:text-slate-600" aria-label="Tampilkan password">
                                <i class="bi bi-eye-slash text-base"></i>
                            </button>
                        </div>
                    </div>

                    <button type="submit" class="w-full rounded-xl bg-[#1d4ed8] py-3.5 text-sm font-semibold text-white shadow-md shadow-blue-500/5 transition duration-150 hover:bg-[#1a4bbf] active:scale-[0.98]">
                        Daftar
                    </button>
                </form>

                <p class="mt-6 text-center text-xs sm:text-sm text-slate-500 font-medium">
                    Sudah punya akun? <a href="/login" class="font-semibold text-[#1d4ed8] hover:underline transition">Masuk</a>
                </p>
            </div>
        </div>
    </div>
</div>

<script>
    (function () {
        var input = document.getElementById('register-password');
        var btn = document.getElementById('register-password-toggle');
        if (!input || !btn) return;
        btn.addEventListener('click', function () {
            var icon = btn.querySelector('i');
            var show = input.type === 'password';
            input.type = show ? 'text' : 'password';
            if (icon) {
                icon.classList.toggle('bi-eye', show);
                icon.classList.toggle('bi-eye-slash', !show);
            }
            btn.setAttribute('aria-label', show ? 'Sembunyikan password' : 'Tampilkan password');
        });
    })();
</script>
@endsection
