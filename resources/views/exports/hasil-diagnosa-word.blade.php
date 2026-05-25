<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:w="urn:schemas-microsoft-com:office:word">
<head>
    <meta charset="utf-8">
    <title>Hasil Diagnosa #{{ $d->id }}</title>
    <!--[if gte mso 9]><xml><w:WordDocument><w:View>Print</w:View></w:WordDocument></xml><![endif]-->
    <style>
        body { font-family: Calibri, Arial, sans-serif; font-size: 11pt; color: #1e293b; line-height: 1.5; }
        h1 { font-size: 16pt; color: #152238; }
        h2 { font-size: 12pt; color: #152238; margin-top: 16pt; }
        .meta { color: #64748b; font-size: 10pt; }
    </style>
</head>
<body>
    <h1>Hasil Diagnosa Kerusakan Printer</h1>
    <p class="meta">Diagnosa #{{ $d->id }} · {{ format_date_id($d->tanggal_diagnosa) }}</p>

    @if ($penyakit)
        <p><strong>Kerusakan:</strong> {{ $penyakit->nama_penyakit }}</p>
        <p><strong>Tingkat Kerusakan:</strong> {{ $tingkat }}</p>

        <h2>Penyebab</h2>
        <p>{{ $penyakit->deskripsi }}</p>

        <h2>Solusi</h2>
        @if (count($solusiLines))
            <ol>
                @foreach ($solusiLines as $line)
                    <li>{{ $line }}</li>
                @endforeach
            </ol>
        @else
            <p>{{ $penyakit->solusi }}</p>
        @endif
    @else
        <p>Tidak ada kerusakan yang terdeteksi dari gejala yang dipilih.</p>
    @endif

    <h2>Gejala yang Dipilih</h2>
    <ul>
        @forelse ($kodes as $k)
            <li>{{ $namaGejala[$k] ?? $k }}</li>
        @empty
            <li>—</li>
        @endforelse
    </ul>

    @if ($tindakanLabel)
        <h2>Tindakan</h2>
        <p>{{ $tindakanLabel }}</p>
    @endif
</body>
</html>
