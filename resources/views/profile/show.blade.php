@extends('layouts.dashboard')
@section('title', 'Pengaturan')
@section('content')

<div class="mx-auto max-w-5xl space-y-6">
    <!-- Page Header -->
    <div class="flex items-center gap-3">
        <span class="flex h-12 w-12 items-center justify-center rounded-xl bg-blue-50 text-blue-600 shadow-sm border border-blue-100">
            <i class="bi bi-gear-fill text-2xl"></i>
        </span>
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-[#152238] sm:text-3xl">Pengaturan</h1>
            <p class="mt-1 text-[15px] text-slate-600">Kelola informasi profil dan keamanan akun Anda</p>
        </div>
    </div>

    <!-- Notifications/Alerts -->
    @if (request('success') === 'password')
        <div class="rounded-xl border border-emerald-200 bg-emerald-50 p-4 text-sm text-emerald-900 shadow-sm flex items-center gap-2">
            <svg class="h-5 w-5 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            Password berhasil diubah. Silakan <strong>logout</strong> lalu login kembali dengan password baru.
        </div>
    @elseif (request('success'))
        <div class="rounded-xl border border-emerald-200 bg-emerald-50 p-4 text-sm text-emerald-900 shadow-sm flex items-center gap-2">
            <svg class="h-5 w-5 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            Profil berhasil diperbarui.
        </div>
    @endif
    @if (request('error') || session('error'))
        <div class="rounded-xl border border-red-200 bg-red-50 p-4 text-sm text-red-900 shadow-sm flex items-center gap-2">
            <svg class="h-5 w-5 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            {{ request('error') ?? session('error') }}
        </div>
    @endif

    <!-- 2 Column Profile Layout -->
    <div class="grid gap-6 lg:grid-cols-[1fr_360px] items-stretch">
        
        <!-- Left Side: Profile Edit Form Card -->
        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm sm:p-8 flex flex-col justify-between">
            <div>
                <h2 class="text-xl font-bold text-slate-900">Informasi Profil</h2>
                <p class="mt-1 text-[13px] text-slate-500">Perbarui informasi profil dan alamat email akun Anda.</p>
                
                <form method="post" action="/profile" onsubmit="event.preventDefault(); confirmUpdate(this, 'Simpan Perubahan?', 'Apakah Anda yakin ingin menyimpan perubahan profil?');" class="mt-6 space-y-5">
                    @csrf
                    
                    <!-- Nama Lengkap Field -->
                    <div>
                        <label class="mb-1.5 block text-xs font-bold uppercase tracking-wider text-slate-500">Nama Lengkap</label>
                        <div class="relative">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400">
                                <i class="bi bi-person-fill text-base"></i>
                            </span>
                            <input type="text" name="nama_lengkap" required 
                                   class="w-full rounded-xl border border-slate-200 bg-slate-50/60 px-4 py-3 pl-11 text-sm outline-none focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-500/15 transition-all text-slate-800 font-medium" 
                                   value="{{ old('nama_lengkap', $user->nama_lengkap) }}">
                        </div>
                    </div>

                    <!-- Email Address Field -->
                    <div>
                        <label class="mb-1.5 block text-xs font-bold uppercase tracking-wider text-slate-500">Email Address</label>
                        <div class="relative">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400">
                                <i class="bi bi-envelope-fill text-base"></i>
                            </span>
                            <input type="email" name="email" required 
                                   class="w-full rounded-xl border border-slate-200 bg-slate-50/60 px-4 py-3 pl-11 text-sm outline-none focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-500/15 transition-all text-slate-800 font-medium" 
                                   value="{{ old('email', $user->email) }}">
                        </div>
                    </div>

                    <!-- Horizontal Divider -->
                    <hr class="my-6 border-slate-200">

                    <p class="text-[13px] font-semibold text-slate-700">Ubah Password</p>
                    <p class="mt-0.5 text-[12px] text-slate-500">Kosongkan ketiga field di bawah jika tidak ingin mengubah password.</p>

                    <!-- Password Saat Ini -->
                    <div>
                        <label class="mb-1.5 block text-xs font-bold uppercase tracking-wider text-slate-500">Password Saat Ini</label>
                        @include('partials.password-input', [
                            'name' => 'current_password',
                            'icon' => 'bi-shield-lock-fill',
                            'placeholder' => '••••••••',
                            'autocomplete' => 'current-password',
                            'inputClass' => $errors->has('current_password') ? 'border-red-400' : '',
                        ])
                        @error('current_password')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password Baru -->
                    <div>
                        <label class="mb-1.5 block text-xs font-bold uppercase tracking-wider text-slate-500">Password Baru</label>
                        @include('partials.password-input', [
                            'name' => 'password',
                            'icon' => 'bi-lock-fill',
                            'placeholder' => '••••••••',
                            'autocomplete' => 'new-password',
                            'inputClass' => $errors->has('password') ? 'border-red-400' : '',
                        ])
                        @error('password')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Konfirmasi Password Baru -->
                    <div>
                        <label class="mb-1.5 block text-xs font-bold uppercase tracking-wider text-slate-500">Konfirmasi Password Baru</label>
                        @include('partials.password-input', [
                            'name' => 'password_confirmation',
                            'icon' => 'bi-check-circle-fill',
                            'placeholder' => '••••••••',
                            'autocomplete' => 'new-password',
                        ])
                    </div>

                    <!-- Action Button -->
                    <div class="pt-4">
                        <button type="submit" class="w-full rounded-full bg-blue-600 py-3.5 text-sm font-bold text-white shadow-md hover:bg-blue-700 transition-all flex items-center justify-center gap-2 active:scale-[0.98]">
                            <i class="bi bi-lock-fill text-base"></i>
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Right Side: Cyan Presentation Card -->
        <div class="rounded-2xl bg-[#00c0f0] p-8 text-center text-white flex flex-col justify-between items-center shadow-sm relative overflow-hidden min-h-[420px] lg:min-h-0">
            <!-- Decorative circle shape in background -->
            <div class="absolute -right-16 -top-16 h-36 w-36 rounded-full bg-white/10 pointer-events-none"></div>
            <div class="absolute -left-12 -bottom-12 h-28 w-28 rounded-full bg-white/5 pointer-events-none"></div>

            <div class="flex-1 flex flex-col justify-center items-center w-full mt-4">
                <!-- Large avatar circle wrapper -->
                <div class="flex h-24 w-24 items-center justify-center rounded-full bg-white/20 shadow-inner">
                    <svg class="h-14 w-14 text-white" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                    </svg>
                </div>
                
                <!-- User name & email -->
                <h3 class="mt-4 text-2xl font-bold tracking-tight leading-tight">{{ $user->nama_lengkap }}</h3>
                <p class="text-sm text-white/80 mt-1.5 font-medium">{{ $user->email }}</p>
                
                <!-- Dynamic role badge -->
                <div class="mt-4">
                    <span class="inline-flex items-center rounded-full bg-white px-5 py-1.5 text-[11px] font-bold text-[#00c0f0] uppercase tracking-wider shadow-sm">
                        {{ $user->role === 'admin' ? 'ADMINISTRATOR' : 'USER MEMBER' }}
                    </span>
                </div>
            </div>

            <!-- Member Sejak Block at the bottom -->
            <div class="w-full mt-8">
                @php
                    $memberSince = $user->created_at ? wib_from_db((string) $user->created_at) : null;
                @endphp
                <div class="rounded-2xl bg-white/10 p-5 backdrop-blur-sm border border-white/5">
                    <p class="text-[11px] font-bold uppercase tracking-widest text-white/70">Member Sejak</p>
                    <p class="mt-2 text-base font-bold text-white">
                        {{ $memberSince ? $memberSince->translatedFormat('d F Y') : '—' }}
                    </p>
                </div>
            </div>
        </div>

    </div>
</div>

@endsection
