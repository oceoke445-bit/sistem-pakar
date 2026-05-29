<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Hasil Diagnosa #{{ $d->id }}</title>
    <style>
        @page { margin: 28px 32px; }
        body { margin: 0; padding: 0; background: #ffffff; }
        table { border: none !important; }
        td { border: none !important; }
    </style>
</head>
<body>
    @include('exports.partials.konsultasi-hasil-document', [
        'fontFamily' => 'DejaVu Sans, sans-serif',
        'baseFontSize' => '11px',
        'metaFontSize' => '10px',
        'headingFontSize' => '13px',
        'bodyFontSize' => '11px',
    ])
</body>
</html>
