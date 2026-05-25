<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Hasil Diagnosa #{{ $d->id }}</title>
    <style>
        @page { margin: 28px 32px; }
        body { margin: 0; padding: 0; background: #ffffff; }
    </style>
</head>
<body>
    @include('exports.partials.hasil-diagnosa-document', [
        'fontFamily' => 'DejaVu Sans, sans-serif',
        'baseFontSize' => '11px',
        'metaFontSize' => '10px',
        'labelFontSize' => '10px',
        'titleFontSize' => '20px',
        'badgeFontSize' => '10px',
        'headingFontSize' => '13px',
        'bodyFontSize' => '11px',
        'tagFontSize' => '10px',
    ])
</body>
</html>
