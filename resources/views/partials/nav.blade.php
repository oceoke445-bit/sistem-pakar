@php
    $adminNav = [
        ['/admin/dashboard', 'Dashboard', 'bi-house-door-fill'],
        ['/admin/diagnosa', 'Diagnosa Kerusakan', 'bi-clipboard2-check'],
        ['/admin/riwayat', 'Riwayat Diagnosa', 'bi-clock-history'],
        ['/admin/penyakit', 'Data Kerusakan', 'bi-shield-exclamation'],
        ['/admin/gejala', 'Data Gejala', 'bi-clipboard2-pulse'],
        ['/admin/relasi', 'Data Rule (Aturan)', 'bi-bezier2'],
        ['/admin/printer', 'Data Printer', 'bi-printer'],
        ['/admin/pengguna', 'Data Pengguna', 'bi-people'],
        ['/admin/laporan', 'Laporan', 'bi-file-earmark-bar-graph'],
        ['/profile', 'Pengaturan', 'bi-gear'],
    ];
    $userNav = [
        ['/user/dashboard', 'Dashboard', 'bi-house-door-fill'],
        ['/user/diagnosa', 'Konsultasi Diagnosa', 'bi-clipboard2-plus'],
        ['/user/riwayat', 'Riwayat Diagnosa', 'bi-clock-history'],
        ['/profile', 'Profil Saya', 'bi-person-circle'],
    ];
    $items = $role === 'admin' ? $adminNav : $userNav;
@endphp
<aside id="app-sidebar"
       class="fixed inset-y-0 left-0 z-50 flex h-[100dvh] w-[min(100vw-3rem,18rem)] max-w-[288px] -translate-x-full flex-col overflow-hidden border-r border-slate-900/50 bg-[#152238] text-slate-200 shadow-2xl print:hidden motion-safe:transition-transform motion-safe:duration-200 motion-safe:ease-out sm:w-72 lg:translate-x-0">
    <div class="shrink-0 border-b border-white/10 px-4 py-5 md:px-5">
        <div class="flex items-center gap-3">
            <div class="flex h-12 w-12 shrink-0 items-center justify-center overflow-hidden rounded-xl bg-white/10 ring-1 ring-white/15">
                <img src="{{ asset('images/logo.png') }}" alt="" class="h-10 w-10 object-contain" width="40" height="40" decoding="async">
            </div>
            <div class="min-w-0">
                <p class="text-xs font-black uppercase tracking-wider text-white">SISTEM PAKAR</p>
                <p class="text-[11px] font-medium leading-normal text-slate-300">Fotocopy Berkah Andirra</p>
            </div>
        </div>
    </div>
    <nav class="flex min-h-0 flex-1 flex-col justify-start gap-0.5 overflow-hidden px-2.5 py-3 md:px-3 md:py-4" aria-label="Navigasi utama">
        @foreach ($items as $item)
            @php [$href, $label, $icon] = $item; $path = ltrim($href, '/'); @endphp
            <a href="{{ $href }}"
               class="flex min-h-0 items-center gap-2.5 rounded-xl px-2.5 py-2 text-[13px] font-semibold leading-tight transition md:gap-3 md:px-3 md:py-2.5 md:text-sm
               {{ request()->is($path) || request()->is($path.'/*')
                    ? 'bg-blue-600 text-white shadow-lg shadow-blue-950/50'
                    : 'text-slate-300 hover:bg-white/8 hover:text-white' }}">
                <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg md:h-9 md:w-9 {{ request()->is($path) || request()->is($path.'/*') ? 'bg-white/15' : 'bg-slate-700/50' }}">
                    <i class="bi {{ $icon }} text-base md:text-lg"></i>
                </span>
                <span class="min-w-0 break-words">{{ $label }}</span>
            </a>
        @endforeach
    </nav>
    <form id="logoutForm" action="{{ route('logout') }}" method="post" class="shrink-0 border-t border-white/10 p-3 md:p-4">
        @csrf
        <button type="button" onclick="openLogoutModal()" class="flex w-full items-center justify-center gap-2 rounded-xl border border-white/10 bg-slate-900/40 px-3 py-2.5 text-[13px] font-semibold text-slate-100 transition hover:bg-slate-800/60 md:text-sm">
            <i class="bi bi-box-arrow-right text-lg"></i> Keluar
        </button>
    </form>
</aside>
