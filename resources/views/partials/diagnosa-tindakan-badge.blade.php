@php
    $badge = diagnosa_tindakan_badge($tindakan ?? null);
@endphp
@if (! empty($href))
    <a href="{{ $href }}" class="{{ $badge['class'] }}">{{ $badge['label'] }}</a>
@else
    <span class="{{ $badge['class'] }}">{{ $badge['label'] }}</span>
@endif
