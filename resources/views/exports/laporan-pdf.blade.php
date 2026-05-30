<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 10px; color: #222; }
        h1 { font-size: 15px; margin: 0 0 4px; }
        .meta { font-size: 10px; color: #444; margin: 0 0 2px; }
        table { width: 100%; border-collapse: collapse; margin-top: 14px; }
        th, td { border: 1px solid #444; padding: 5px 7px; text-align: left; }
        th { background: #1e40af; color: #fff; font-size: 9px; }
        td { font-size: 9px; }
        .empty { text-align: center; color: #666; padding: 16px; }
    </style>
</head>
<body>
    <h1>{{ $reportTitle }}</h1>
    <p class="meta">{{ $appName }}</p>
    <p class="meta">{{ $unitName }}</p>
    <p class="meta">Periode: {{ $periodLabel }}</p>
    <p class="meta">Dicetak: {{ $printedAt }}</p>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Nama Pengguna</th>
                <th>Hasil Kerusakan</th>
                <th>Kecocokan</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($rows as $row)
                <tr>
                    @foreach ($row as $cell)
                        <td>{{ $cell }}</td>
                    @endforeach
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="empty">Tidak ada data diagnosa pada periode ini.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
