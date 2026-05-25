<div class="flex flex-wrap gap-1.5">
    @forelse ($kodes as $k)
        <span class="inline-flex rounded-md bg-cyan-50 px-2 py-0.5 text-xs font-bold text-cyan-700 ring-1 ring-cyan-100/80" title="{{ $namaGejala[$k] ?? '' }}">
            {{ $k }}
        </span>
    @empty
        <span class="text-slate-400">—</span>
    @endforelse
</div>
