<div class="relative print:hidden" data-export-dropdown>
    <button type="button" data-export-dropdown-toggle
            class="inline-flex items-center gap-1.5 rounded-lg border border-blue-600 bg-white px-3 py-1.5 text-xs font-bold text-blue-600 shadow-sm transition-colors hover:bg-blue-50 whitespace-nowrap">
        <svg class="h-3.5 w-3.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M17 17h2a2 2 0 002-2v-5a2 2 0 00-2-2H5a2 2 0 00-2 2v5a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
        </svg>
        Cetak Hasil
        <i class="bi bi-chevron-down text-[10px] opacity-70"></i>
    </button>
    <div data-export-dropdown-menu
         class="absolute right-0 z-30 mt-1 hidden min-w-[11rem] overflow-hidden rounded-lg border border-slate-200 bg-white py-1 shadow-lg">
        <a href="{{ route('user.hasil-diagnosa.export.pdf', $diagnosaId) }}"
           class="flex items-center gap-2 px-3 py-2 text-xs font-semibold text-slate-700 transition-colors hover:bg-slate-50">
            <i class="bi bi-file-earmark-pdf text-red-500"></i>
            PDF
        </a>
        <a href="{{ route('user.hasil-diagnosa.export.word', $diagnosaId) }}"
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
