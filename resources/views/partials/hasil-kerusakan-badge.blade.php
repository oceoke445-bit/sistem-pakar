@props(['label' => null])

@if ($label)
    <span {{ $attributes->merge(['class' => 'inline-block max-w-[9.5rem] sm:max-w-[12rem] rounded-xl bg-emerald-50 px-2.5 py-1.5 text-center text-[10px] sm:text-xs font-semibold leading-snug text-emerald-700 ring-1 ring-inset ring-emerald-100 break-words whitespace-normal']) }}>
        {{ $label }}
    </span>
@else
    <span class="text-slate-400">—</span>
@endif
