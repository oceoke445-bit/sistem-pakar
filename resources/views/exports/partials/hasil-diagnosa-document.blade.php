@php
    $tingkatLabel = $tingkat ? ucfirst(strtolower((string) $tingkat)) : '—';
@endphp

<div style="font-family: {{ $fontFamily ?? 'DejaVu Sans, sans-serif' }}; font-size: {{ $baseFontSize ?? '11px' }}; color: #334155; line-height: 1.6;">

    {{-- Meta --}}
    <p style="margin: 0 0 16px; font-size: {{ $metaFontSize ?? '10px' }}; color: #64748b;">
        Diagnosa #{{ $d->id }} · {{ format_date_id($d->tanggal_diagnosa) }}
    </p>

    {{-- Diagnosis header card --}}
    <div style="border: 1px solid #fecaca; background-color: #fef2f2; border-radius: 14px; padding: 20px 22px; margin-bottom: 28px;">
        <table cellpadding="0" cellspacing="0" border="0" width="100%">
            <tr>
                <td width="90" valign="middle" style="padding-right: 16px;">
                    <img src="{{ export_printer_icon_data_uri() }}" width="72" height="72" alt="Printer" style="display: block;">
                </td>
                <td valign="middle">
                    <p style="margin: 0 0 6px; font-size: {{ $labelFontSize ?? '10px' }}; font-weight: bold; letter-spacing: 0.08em; text-transform: uppercase; color: #64748b;">
                        Diagnosa Kerusakan
                    </p>
                    @if ($penyakit)
                        <p style="margin: 0 0 10px; font-size: {{ $titleFontSize ?? '20px' }}; font-weight: bold; line-height: 1.25; color: #dc2626;">
                            {{ $penyakit->nama_penyakit }}
                        </p>
                        <span style="display: inline-block; padding: 4px 12px; border: 1px solid #fecaca; background-color: #fee2e2; border-radius: 999px; font-size: {{ $badgeFontSize ?? '10px' }}; font-weight: bold; color: #b91c1c;">
                            Tingkat Kerusakan : {{ $tingkatLabel }}
                        </span>
                    @else
                        <p style="margin: 0; font-size: {{ $titleFontSize ?? '18px' }}; font-weight: bold; color: #334155;">
                            Tidak ada kerusakan terdeteksi
                        </p>
                    @endif
                </td>
            </tr>
        </table>
    </div>

    @if ($penyakit)
        {{-- Penyebab --}}
        <div style="margin-bottom: 22px;">
            <p style="margin: 0 0 8px; font-size: {{ $headingFontSize ?? '13px' }}; font-weight: bold; color: #0f172a;">
                Penyebab
            </p>
            <p style="margin: 0; font-size: {{ $bodyFontSize ?? '11px' }}; color: #334155; line-height: 1.65;">
                {{ $penyakit->deskripsi }}
            </p>
        </div>

        {{-- Solusi --}}
        <div style="margin-bottom: 28px;">
            <p style="margin: 0 0 8px; font-size: {{ $headingFontSize ?? '13px' }}; font-weight: bold; color: #0f172a;">
                Solusi
            </p>
            @if (count($solusiLines))
                <ol style="margin: 0; padding-left: 20px; font-size: {{ $bodyFontSize ?? '11px' }}; color: #334155; line-height: 1.65;">
                    @foreach ($solusiLines as $line)
                        <li style="margin-bottom: 6px;">{{ $line }}</li>
                    @endforeach
                </ol>
            @else
                <p style="margin: 0; font-size: {{ $bodyFontSize ?? '11px' }}; color: #334155; line-height: 1.65;">
                    {{ $penyakit->solusi }}
                </p>
            @endif
        </div>
    @endif

    {{-- Gejala --}}
    <div style="border-top: 1px solid #e2e8f0; padding-top: 18px;">
        <p style="margin: 0 0 12px; font-size: {{ $labelFontSize ?? '10px' }}; font-weight: bold; letter-spacing: 0.08em; text-transform: uppercase; color: #64748b;">
            Gejala yang Anda Pilih
        </p>
        @if (count($kodes))
            @foreach ($kodes as $k)
                <span style="display: inline-block; margin: 0 8px 8px 0; padding: 5px 12px; border: 1px solid #e2e8f0; background-color: #f8fafc; border-radius: 8px; font-size: {{ $tagFontSize ?? '10px' }}; font-weight: 600; color: #334155;">
                    {{ $namaGejala[$k] ?? $k }}
                </span>
            @endforeach
        @else
            <span style="color: #94a3b8;">—</span>
        @endif
    </div>
</div>
