@php
    $fullWidth = $fullWidth ?? false;
    $exportContext = $exportContext ?? 'hasil';
    $pdfRoute = $exportContext === 'detail'
        ? route('user.riwayat.export.pdf', $diagnosaId)
        : route('user.hasil-diagnosa.export.pdf', $diagnosaId);
    $wordRoute = $exportContext === 'detail'
        ? route('user.riwayat.export.word', $diagnosaId)
        : route('user.hasil-diagnosa.export.word', $diagnosaId);
    $toggleClass = $fullWidth
        ? 'inline-flex w-full min-w-0 items-center justify-center gap-1.5 rounded-xl border border-slate-200 bg-white px-2 py-3 text-xs font-bold text-slate-800 shadow-sm transition hover:bg-slate-50 sm:gap-2 sm:px-3 sm:text-sm'
        : 'inline-flex items-center gap-1.5 rounded-lg border border-blue-600 bg-white px-3 py-1.5 text-xs font-bold text-blue-600 shadow-sm transition-colors hover:bg-blue-50 whitespace-nowrap';
    $menuClass = $fullWidth ? 'left-0 right-0 w-full' : 'right-0 min-w-[11rem]';
@endphp
<div class="relative print:hidden {{ $fullWidth ? 'w-full' : '' }}" data-export-dropdown>
    <button type="button" data-export-dropdown-toggle class="{{ $toggleClass }}">
        @if ($fullWidth)
            <i class="bi bi-printer shrink-0"></i>
        @else
            <svg class="h-3.5 w-3.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M17 17h2a2 2 0 002-2v-5a2 2 0 00-2-2H5a2 2 0 00-2 2v5a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
            </svg>
        @endif
        <span class="truncate">Cetak Hasil</span>
        <i class="bi bi-chevron-down shrink-0 text-[10px] opacity-70"></i>
    </button>
    <div data-export-dropdown-menu
         class="absolute z-30 mt-1 hidden overflow-hidden rounded-lg border border-slate-200 bg-white py-1 shadow-lg {{ $menuClass }}">
        <a href="{{ $pdfRoute }}"
           class="flex items-center gap-2 px-3 py-2 text-xs font-semibold text-slate-700 transition-colors hover:bg-slate-50">
            <i class="bi bi-file-earmark-pdf text-red-500"></i>
            PDF
        </a>
        <a href="{{ $wordRoute }}"
           class="flex items-center gap-2 px-3 py-2 text-xs font-semibold text-slate-700 transition-colors hover:bg-slate-50">
            <i class="bi bi-file-earmark-word text-blue-600"></i>
            Word
        </a>
        <button type="button" onclick="window.print()"
                class="flex w-full items-center gap-2 px-3 py-2 text-left text-xs font-semibold text-slate-700 transition-colors hover:bg-slate-50">
            <i class="bi bi-printer text-slate-600"></i>
            Cetak Printer
        </button>
    </div>
</div>

@once
    @push('scripts')
        <script>
            document.addEventListener('click', function (e) {
                document.querySelectorAll('[data-export-dropdown]').forEach(function (wrap) {
                    var menu = wrap.querySelector('[data-export-dropdown-menu]');
                    var toggle = wrap.querySelector('[data-export-dropdown-toggle]');
                    if (!menu || !toggle) return;
                    if (toggle.contains(e.target)) {
                        menu.classList.toggle('hidden');
                        return;
                    }
                    if (!wrap.contains(e.target)) {
                        menu.classList.add('hidden');
                    }
                });
            });
        </script>
    @endpush
@endonce
