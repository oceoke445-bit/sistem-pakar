<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 11px; color: #1e293b; line-height: 1.5; }
        h1 { font-size: 16px; margin: 0 0 4px; color: #152238; }
        h2 { font-size: 13px; margin: 16px 0 6px; color: #152238; }
        .meta { font-size: 10px; color: #64748b; margin-bottom: 14px; }
        .badge { display: inline-block; padding: 3px 8px; border-radius: 999px; font-size: 10px; font-weight: bold; background: #fee2e2; color: #b91c1c; }
        .section { margin-top: 12px; }
        ul, ol { margin: 6px 0 0 18px; padding: 0; }
        li { margin-bottom: 4px; }
        .gejala { margin-top: 6px; }
        .gejala span { display: inline-block; margin: 0 6px 6px 0; padding: 3px 8px; border: 1px solid #cbd5e1; border-radius: 6px; font-size: 10px; }
    </style>
</head>
<body>
    <h1>Hasil Diagnosa Kerusakan Printer</h1>
    <p class="meta">Diagnosa #{{ $d->id }} · {{ format_date_id($d->tanggal_diagnosa) }}</p>

    @if ($penyakit)
        <p><strong>Kerusakan:</strong> {{ $penyakit->nama_penyakit }}</p>
        <p><span class="badge">Tingkat: {{ $tingkat }}</span></p>

        <div class="section">
            <h2>Penyebab</h2>
            <p>{{ $penyakit->deskripsi }}</p>
        </div>

        <div class="section">
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
        </div>
    @else
        <p>Tidak ada kerusakan yang terdeteksi dari gejala yang dipilih.</p>
    @endif

    <div class="section">
        <h2>Gejala yang Dipilih</h2>
        <div class="gejala">
            @forelse ($kodes as $k)
                <span>{{ $namaGejala[$k] ?? $k }}</span>
            @empty
                <span>—</span>
            @endforelse
        </div>
    </div>

    @if ($tindakanLabel)
        <div class="section">
            <h2>Tindakan</h2>
            <p>{{ $tindakanLabel }}</p>
        </div>
    @endif
</body>
</html>
