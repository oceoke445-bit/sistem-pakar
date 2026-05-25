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

if (! function_exists('wib_from_db')) {
    function wib_from_db(?string $value): ?Carbon
    {
        if (! $value) {
            return null;
        }

        return Carbon::parse($value)->utc()->timezone('Asia/Jakarta');
    }
}

if (! function_exists('format_date_id')) {
    function format_date_id(?string $iso): string
    {
        $dt = wib_from_db($iso);

        return $dt ? $dt->format('d/m/Y, H:i') : '—';
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

if (! function_exists('export_printer_icon_data_uri')) {
    /** PNG data URI for PDF/Word export (DomPDF & Word do not render inline SVG reliably). */
    function export_printer_icon_data_uri(): string
    {
        static $cached = null;
        if ($cached !== null) {
            return $cached;
        }

        $dir = public_path('images');
        $path = $dir.DIRECTORY_SEPARATOR.'printer-diagnosa-export.png';

        if (! is_file($path)) {
            if (! is_dir($dir)) {
                mkdir($dir, 0755, true);
            }

            $w = 96;
            $h = 96;
            $im = imagecreatetruecolor($w, $h);
            imagesavealpha($im, true);
            imagealphablending($im, false);
            $transparent = imagecolorallocatealpha($im, 0, 0, 0, 127);
            imagefill($im, 0, 0, $transparent);
            imagealphablending($im, true);

            $dark = imagecolorallocate($im, 30, 41, 59);
            $white = imagecolorallocate($im, 255, 255, 255);
            $gray = imagecolorallocate($im, 148, 163, 184);
            $red = imagecolorallocate($im, 239, 68, 68);
            $slate = imagecolorallocate($im, 71, 85, 105);
            $yellow = imagecolorallocate($im, 234, 179, 8);
            $green = imagecolorallocate($im, 34, 197, 94);

            imagefilledrectangle($im, 32, 10, 64, 24, $white);
            imagerectangle($im, 32, 10, 64, 24, $gray);
            imagefilledrectangle($im, 28, 20, 72, 35, $slate);
            imagefilledrectangle($im, 12, 32, 84, 74, $dark);
            imagefilledrectangle($im, 22, 52, 78, 58, $dark);
            imagefilledrectangle($im, 24, 56, 76, 84, $white);
            imagerectangle($im, 24, 56, 76, 84, $gray);

            foreach ([62, 67, 72, 77] as $y) {
                imageline($im, 30, $y, 70, $y, $red);
            }

            imagefilledellipse($im, 20, 42, 5, 5, $yellow);
            imagefilledellipse($im, 27, 42, 5, 5, $green);

            imagepng($im, $path);
            imagedestroy($im);
        }

        $cached = 'data:image/png;base64,'.base64_encode((string) file_get_contents($path));

        return $cached;
    }
}
