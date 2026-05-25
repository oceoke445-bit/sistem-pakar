@props([
    'name',
    'id' => null,
    'icon' => null,
    'placeholder' => '',
    'autocomplete' => null,
    'required' => false,
    'value' => null,
    'inputClass' => '',
    'size' => 'default',
])

@php
    $inputId = $id ?? 'pwd-' . preg_replace('/[^a-z0-9_-]/i', '-', $name) . '-' . substr(uniqid(), -5);
    $isCompact = $size === 'compact';
    $paddingLeft = $icon ? ($isCompact ? 'pl-7' : 'pl-11') : ($isCompact ? 'pl-2' : 'pl-4');
    $paddingRight = $isCompact ? 'pr-8' : 'pr-12';
    $inputSizeClass = $isCompact
        ? 'rounded-lg py-1 text-xs'
        : 'rounded-xl py-3 text-sm font-medium';
    $btnSizeClass = $isCompact ? 'right-1 h-6 w-6' : 'right-3 h-8 w-8';
    $iconLeftClass = $isCompact ? 'left-2' : 'left-4';
@endphp

<div {{ $attributes->merge(['class' => 'relative']) }}>
    @if ($icon)
        <span class="pointer-events-none absolute {{ $iconLeftClass }} top-1/2 -translate-y-1/2 text-slate-400">
            <i class="bi {{ $icon }} {{ $isCompact ? 'text-xs' : 'text-base' }}"></i>
        </span>
    @endif
    <input
        id="{{ $inputId }}"
        type="password"
        name="{{ $name }}"
        @if ($placeholder !== '') placeholder="{{ $placeholder }}" @endif
        @if ($autocomplete) autocomplete="{{ $autocomplete }}" @endif
        @if ($required) required @endif
        @if ($value !== null && $value !== '') value="{{ $value }}" @endif
        class="w-full border border-slate-200 bg-slate-50/60 outline-none transition-all text-slate-800 focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-500/15 {{ $paddingLeft }} {{ $paddingRight }} {{ $inputSizeClass }} {{ $inputClass }}"
    >
    <button
        type="button"
        class="password-toggle-btn absolute top-1/2 flex -translate-y-1/2 items-center justify-center rounded-md text-slate-400 transition hover:bg-slate-100 hover:text-slate-600 {{ $btnSizeClass }}"
        aria-label="Tampilkan password"
        data-target="{{ $inputId }}"
    >
        <i class="bi bi-eye-slash {{ $isCompact ? 'text-xs' : 'text-base' }}"></i>
    </button>
</div>
