@php
    $adminNav = [
        ['/admin/dashboard', 'Dashboard', 'bi-speedometer2'],
        ['/admin/riwayat', 'Riwayat Diagnosa', 'bi-clock-history'],
        ['/admin/penyakit', 'Data Kerusakan', 'bi-exclamation-octagon'],
        ['/admin/gejala', 'Data Gejala', 'bi-clipboard2-pulse'],
        ['/admin/relasi', 'Data Rule (Aturan)', 'bi-diagram-3'],
        ['/admin/pengguna', 'Data Pengguna', 'bi-people'],
        ['/admin/laporan', 'Laporan', 'bi-file-earmark-bar-graph'],
        ['/profile', 'Pengaturan', 'bi-gear'],
    ];
    $userNav = [
        ['/user/dashboard', 'Dashboard', 'bi-speedometer2'],
        ['/user/diagnosa', 'Diagnosa Kerusakan', 'bi-search-heart'],
        ['/user/riwayat', 'Riwayat Diagnosa', 'bi-clock-history'],
        ['/profile', 'Pengaturan', 'bi-gear'],
    ];
    $items = $role === 'admin' ? $adminNav : $userNav;
    $printerUrl = asset('images/printer.jpg');
@endphp
<aside id="app-sidebar"
       class="fixed inset-y-0 left-0 z-50 flex h-[100dvh] w-[min(100vw-3rem,18rem)] max-w-[288px] -translate-x-full flex-col overflow-hidden border-r border-slate-800/90 bg-sidebar text-slate-200 shadow-2xl print:hidden motion-safe:transition-transform motion-safe:duration-200 motion-safe:ease-out sm:w-72 lg:translate-x-0">
    <div class="shrink-0 border-b border-white/10 px-4 py-5 md:px-5">
        <div class="flex items-center gap-3">
            <div class="flex h-11 w-11 shrink-0 items-center justify-center overflow-hidden rounded-xl bg-white/10 ring-1 ring-white/10">
                <img src="{{ $printerUrl }}" alt="" class="h-9 w-9 object-contain" width="36" height="36" decoding="async">
            </div>
            <div class="min-w-0">
                <p class="text-[10px] font-bold uppercase tracking-[0.22em] text-blue-300/95">Sistem Pakar</p>
                <p class="mt-0.5 text-[15px] font-bold leading-snug tracking-tight text-white">Diagnosa Printer</p>
                <p class="mt-1 text-[11px] leading-snug text-slate-400">Forward <span class="font-semibold text-slate-200">Chaining</span></p>
            </div>
        </div>
    </div>
    <nav class="flex min-h-0 flex-1 flex-col justify-start gap-0.5 overflow-hidden px-2.5 py-3 md:px-3 md:py-4" aria-label="Navigasi utama">
        @foreach ($items as $item)
            @php [$href, $label, $icon] = $item; $path = ltrim($href, '/'); @endphp
            <a href="{{ $href }}"
               class="flex min-h-0 items-center gap-2.5 rounded-xl px-2.5 py-2 text-[13px] font-semibold leading-tight transition md:gap-3 md:px-3 md:py-2.5 md:text-sm
               {{ request()->is($path) || request()->is($path.'/*')
                    ? 'bg-blue-600 text-white shadow-md shadow-blue-950/40'
                    : 'text-slate-300 hover:bg-white/5 hover:text-white' }}">
                <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg md:h-9 md:w-9 {{ request()->is($path) || request()->is($path.'/*') ? 'bg-white/15' : 'bg-slate-700/45' }}">
                    <i class="bi {{ $icon }} text-base md:text-lg"></i>
                </span>
                <span class="min-w-0 break-words">{{ $label }}</span>
            </a>
        @endforeach
    </nav>
    <form action="{{ route('logout') }}" method="post" class="shrink-0 border-t border-white/10 p-3 md:p-4">
        @csrf
        <button type="submit" class="flex w-full items-center justify-center gap-2 rounded-xl border border-white/10 bg-slate-900/30 px-3 py-2.5 text-[13px] font-semibold text-slate-100 transition hover:bg-slate-800/50 md:text-sm">
            <i class="bi bi-box-arrow-right text-lg"></i> Keluar
        </button>
    </form>
</aside>
