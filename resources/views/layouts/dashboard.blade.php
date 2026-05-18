<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', config('app.name', 'Sistem Pakar'))</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['Inter', 'system-ui', 'sans-serif'] },
                    colors: {
                        navy: { DEFAULT: '#152238', 950: '#0a1628' },
                        sidebar: '#152238',
                        brand: { 600: '#2563eb', 700: '#1d4ed8' },
                    },
                },
            },
        };
    </script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    @stack('head')
</head>
<body class="overflow-hidden bg-slate-100 font-sans text-slate-800 antialiased">
    <div class="flex h-[100dvh] w-full flex-col overflow-hidden lg:h-screen">
        <div id="nav-overlay" class="fixed inset-0 z-40 hidden bg-slate-900/50 backdrop-blur-[1px] transition-opacity lg:hidden" aria-hidden="true"></div>

        @include('partials.nav', ['role' => session('auth.role')])

        <div class="flex min-h-0 min-w-0 flex-1 flex-col lg:ml-72">
            <header class="sticky top-0 z-30 flex h-14 shrink-0 items-center gap-3 border-b border-slate-200/80 bg-white/95 px-4 shadow-sm backdrop-blur-md lg:hidden print:hidden">
                <button type="button" id="nav-open" class="inline-flex h-10 w-10 items-center justify-center rounded-xl border border-slate-200 bg-white text-slate-700 shadow-sm transition hover:bg-slate-50" aria-controls="app-sidebar" aria-expanded="false" aria-label="Buka menu">
                    <i class="bi bi-list text-xl"></i>
                </button>
                <div class="min-w-0 flex-1">
                    <p class="truncate text-xs font-semibold uppercase tracking-[0.18em] text-blue-600/90">Sistem Pakar</p>
                    <p class="truncate text-sm font-bold text-slate-900">@yield('title')</p>
                </div>
            </header>

            <main class="relative main-scroll min-h-0 min-w-0 flex-1 overflow-y-auto bg-slate-100/80 px-4 py-4 sm:px-5 sm:py-6 md:px-8 md:py-8 lg:px-10 lg:py-10 print:ml-0 print:w-full print:overflow-visible print:bg-white print:p-6">
                @if (!Request::is('admin/penyakit') && !Request::is('admin/gejala') && !Request::is('admin/printer'))
                <div class="mb-5 flex justify-end sm:absolute sm:right-5 sm:top-6 md:right-8 md:top-8 lg:right-10 lg:top-10 sm:mb-0 print:hidden z-10">
                    <span class="inline-flex items-center gap-2 rounded-full border border-slate-200/90 bg-white px-4 py-2 text-xs font-medium text-slate-600 shadow-sm sm:text-sm">
                        <i class="bi bi-calendar3 text-slate-400"></i>
                        <span id="toolbar-datetime-text"></span>
                    </span>
                </div>
                @endif
                @yield('content')
            </main>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
    <script>
        (function () {
            var sidebar = document.getElementById('app-sidebar');
            var overlay = document.getElementById('nav-overlay');
            var btn = document.getElementById('nav-open');
            if (!sidebar || !overlay || !btn) return;

            function isDesktop() {
                return window.matchMedia('(min-width: 1024px)').matches;
            }

            function setOpen(open) {
                if (isDesktop()) {
                    sidebar.classList.remove('-translate-x-full');
                    overlay.classList.add('hidden');
                    document.body.classList.remove('overflow-hidden');
                    btn.setAttribute('aria-expanded', 'false');
                    return;
                }
                if (open) {
                    sidebar.classList.remove('-translate-x-full');
                    overlay.classList.remove('hidden');
                    document.body.classList.add('overflow-hidden');
                    btn.setAttribute('aria-expanded', 'true');
                } else {
                    sidebar.classList.add('-translate-x-full');
                    overlay.classList.add('hidden');
                    document.body.classList.remove('overflow-hidden');
                    btn.setAttribute('aria-expanded', 'false');
                }
            }

            btn.addEventListener('click', function () {
                var open = sidebar.classList.contains('-translate-x-full');
                setOpen(open);
            });
            overlay.addEventListener('click', function () {
                setOpen(false);
            });
            sidebar.querySelectorAll('a, button[type="submit"]').forEach(function (el) {
                el.addEventListener('click', function () {
                    if (!isDesktop()) setOpen(false);
                });
            });
            window.addEventListener('resize', function () {
                if (isDesktop()) setOpen(false);
            });
            document.addEventListener('keydown', function (e) {
                if (e.key === 'Escape' && !isDesktop()) setOpen(false);
            });
            if (isDesktop()) sidebar.classList.remove('-translate-x-full');
        })();
        (function () {
            var el = document.getElementById('toolbar-datetime-text');
            if (!el) return;
            function fmt() {
                var d = new Date();
                var months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
                var dd = d.getDate(), mm = months[d.getMonth()], yy = d.getFullYear();
                var hh = String(d.getHours()).padStart(2, '0'), mi = String(d.getMinutes()).padStart(2, '0');
                el.textContent = dd + ' ' + mm + ' ' + yy + ' | ' + hh + ':' + mi;
            }
            fmt();
            setInterval(fmt, 30000);
        })();
    </script>
    @stack('scripts')
</body>
</html>
