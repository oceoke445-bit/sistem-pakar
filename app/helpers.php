<?php

use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;

if (! function_exists('verify_password_hash')) {
    /** Laravel bcrypt + hash bcryptjs (Next.js) */
    function verify_password_hash(string $plain, string $hash): bool
    {
        if ($hash === '') {
            return false;
        }

        try {
            return Hash::check($plain, $hash);
        } catch (\RuntimeException) {
            return password_verify($plain, $hash);
        }
    }
}

if (! function_exists('format_date_id')) {
    function format_date_id(?string $iso): string
    {
        if (! $iso) {
            return '—';
        }

        return Carbon::parse($iso)->timezone(config('app.timezone', 'Asia/Jakarta'))->format('d/m/Y, H:i');
    }
}

if (! function_exists('diagnosis_tingkat_label')) {
    /** @param  float|null  $confidence  nilai 0–1 di kolom diagnosa.confidence */
    function diagnosis_tingkat_label(?float $confidence): string
    {
        if ($confidence === null) {
            return 'Ringan';
        }
        $p = (float) $confidence;
        if ($p >= 0.8) {
            return 'Berat';
        }
        if ($p >= 0.5) {
            return 'Sedang';
        }

        return 'Ringan';
    }
}

if (! function_exists('diagnosis_tingkat_bucket')) {
    /** @return 'ringan'|'sedang'|'berat' */
    function diagnosis_tingkat_bucket(?float $confidence): string
    {
        if ($confidence === null) {
            return 'ringan';
        }
        $p = (float) $confidence;
        if ($p >= 0.8) {
            return 'berat';
        }
        if ($p >= 0.5) {
            return 'sedang';
        }

        return 'ringan';
    }
}

if (! function_exists('diagnosa_tindakan_badge')) {
    /** @return array{label: string, class: string} */
    function diagnosa_tindakan_badge(?string $tindakan): array
    {
        return match ($tindakan) {
            'sendiri' => [
                'label' => 'Lakukan Sendiri',
                'class' => 'inline-flex items-center gap-1.5 rounded-xl border border-emerald-200 bg-emerald-50 px-3 py-1.5 text-xs font-bold text-emerald-700 shadow-sm hover:bg-emerald-100/70 transition-colors',
            ],
            'teknisi' => [
                'label' => 'Teknisi',
                'class' => 'inline-flex items-center gap-1.5 rounded-xl border border-amber-200 bg-amber-50 px-3 py-1.5 text-xs font-bold text-amber-700 shadow-sm hover:bg-amber-100/70 transition-colors',
            ],
            default => [
                'label' => 'Belum dipilih',
                'class' => 'inline-flex items-center gap-1.5 rounded-xl border border-slate-200 bg-slate-50 px-3 py-1.5 text-xs font-semibold text-slate-500',
            ],
        };
    }
}
