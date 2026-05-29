@props(['activeStep' => 1])

@php
    $steps = [
        1 => 'Pilih Gejala',
        2 => 'Proses',
        3 => 'Hasil',
    ];
    $activeStep = max(1, min(3, (int) $activeStep));
@endphp

<div {{ $attributes->merge(['class' => 'flex flex-wrap items-center justify-center gap-2 py-2 sm:gap-4']) }}>
    @foreach ($steps as $num => $label)
        @if ($num > 1)
            <div class="relative mx-0.5 h-[2px] w-10 shrink-0 overflow-hidden rounded-full bg-slate-200 sm:w-16 md:w-24">
                <div class="absolute inset-y-0 left-0 rounded-full bg-blue-600 transition-all {{ $num <= $activeStep ? 'w-full' : 'w-0' }}"></div>
            </div>
        @endif
        <div class="flex items-center gap-2">
            <span class="flex h-7 w-7 items-center justify-center rounded-full text-xs font-bold shadow-sm {{ $num <= $activeStep ? 'bg-blue-600 text-white' : 'bg-slate-200 text-slate-500' }}">
                {{ $num }}
            </span>
            <span class="text-sm font-semibold {{ $num === $activeStep ? 'font-bold text-blue-800' : ($num < $activeStep ? 'text-blue-700' : 'text-slate-400') }}">
                {{ $label }}
            </span>
        </div>
    @endforeach
</div>
