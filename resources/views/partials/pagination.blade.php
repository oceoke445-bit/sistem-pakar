<div class="flex items-center justify-end gap-2 border-t border-slate-100 bg-white px-4 py-3 sm:px-5">
    @if ($paginator->onFirstPage())
        <span class="inline-flex h-9 w-9 items-center justify-center text-slate-300 cursor-not-allowed">
            <i class="bi bi-chevron-left text-[13px]"></i>
        </span>
    @else
        <a href="{{ $paginator->previousPageUrl() }}" class="inline-flex h-9 w-9 items-center justify-center text-slate-400 hover:text-slate-600 transition-colors">
            <i class="bi bi-chevron-left text-[13px]"></i>
        </a>
    @endif

    @foreach (range(1, max(1, $paginator->lastPage())) as $page)
        @if ($page == $paginator->currentPage())
            <span class="inline-flex h-9 w-9 items-center justify-center rounded-lg border-2 border-blue-200 bg-white text-sm font-bold text-blue-600 shadow-[0_1px_4px_rgba(59,130,246,0.08)]">
                {{ $page }}
            </span>
        @else
            <a href="{{ $paginator->url($page) }}" class="inline-flex h-9 w-9 items-center justify-center rounded-lg border border-slate-200 bg-white text-sm font-semibold text-slate-500 hover:bg-slate-50 transition-colors">
                {{ $page }}
            </a>
        @endif
    @endforeach

    @if ($paginator->hasMorePages())
        <a href="{{ $paginator->nextPageUrl() }}" class="inline-flex h-9 w-9 items-center justify-center text-slate-400 hover:text-slate-600 transition-colors">
            <i class="bi bi-chevron-right text-[13px]"></i>
        </a>
    @else
        <span class="inline-flex h-9 w-9 items-center justify-center text-slate-300 cursor-not-allowed">
            <i class="bi bi-chevron-right text-[13px]"></i>
        </span>
    @endif
</div>
