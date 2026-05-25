@php
    $tingkatLabel = $tingkat ? ucfirst(strtolower((string) $tingkat)) : '—';
    $iconSrc = export_printer_icon_data_uri();
@endphp

<table border="0" cellpadding="0" cellspacing="0" width="100%" style="width:100%; border-collapse:collapse; font-family:Calibri, Arial, sans-serif; font-size:11pt; color:#334155;">
    {{-- Meta --}}
    <tr>
        <td colspan="2" style="padding:0 0 12pt 0; font-size:10pt; color:#64748b; mso-line-height-rule:exactly; line-height:14pt;">
            Diagnosa #{{ $d->id }} &middot; {{ format_date_id($d->tanggal_diagnosa) }}
        </td>
    </tr>

    {{-- Header card --}}
    <tr>
        <td colspan="2" style="padding:0 0 18pt 0;">
            <table border="0" cellpadding="0" cellspacing="0" width="100%" style="width:100%; border-collapse:collapse; border:1pt solid #fecaca; background:#fef2f2;">
                <tr>
                    <td width="84" valign="middle" style="width:84pt; padding:14pt 10pt 14pt 16pt; background:#fef2f2;">
                        <img src="{{ $iconSrc }}" width="72" height="72" alt="Printer" style="width:72px; height:72px; border:none;">
                    </td>
                    <td valign="middle" style="padding:14pt 16pt 14pt 4pt; background:#fef2f2;">
                        <p style="margin:0 0 6pt 0; font-size:9pt; font-weight:bold; letter-spacing:0.6pt; text-transform:uppercase; color:#64748b; mso-line-height-rule:exactly; line-height:12pt;">
                            Diagnosa Kerusakan
                        </p>
                        @if ($penyakit)
                            <p style="margin:0 0 8pt 0; font-size:18pt; font-weight:bold; color:#dc2626; mso-line-height-rule:exactly; line-height:22pt;">
                                {{ $penyakit->nama_penyakit }}
                            </p>
                            <table border="0" cellpadding="0" cellspacing="0" style="border-collapse:collapse;">
                                <tr>
                                    <td style="padding:4pt 10pt; border:1pt solid #fecaca; background:#fee2e2; font-size:9pt; font-weight:bold; color:#b91c1c; mso-line-height-rule:exactly; line-height:12pt;">
                                        Tingkat Kerusakan : {{ $tingkatLabel }}
                                    </td>
                                </tr>
                            </table>
                        @else
                            <p style="margin:0; font-size:16pt; font-weight:bold; color:#334155; mso-line-height-rule:exactly; line-height:20pt;">
                                Tidak ada kerusakan terdeteksi
                            </p>
                        @endif
                    </td>
                </tr>
            </table>
        </td>
    </tr>

    @if ($penyakit)
        {{-- Penyebab --}}
        <tr>
            <td colspan="2" style="padding:0 0 14pt 0;">
                <p style="margin:0 0 6pt 0; font-size:12pt; font-weight:bold; color:#0f172a; mso-line-height-rule:exactly; line-height:16pt;">
                    Penyebab
                </p>
                <p style="margin:0; font-size:11pt; color:#334155; text-align:justify; mso-line-height-rule:exactly; line-height:16pt;">
                    {{ $penyakit->deskripsi }}
                </p>
            </td>
        </tr>

        {{-- Solusi --}}
        <tr>
            <td colspan="2" style="padding:0 0 18pt 0;">
                <p style="margin:0 0 6pt 0; font-size:12pt; font-weight:bold; color:#0f172a; mso-line-height-rule:exactly; line-height:16pt;">
                    Solusi
                </p>
                @if (count($solusiLines))
                    <table border="0" cellpadding="0" cellspacing="0" width="100%" style="width:100%; border-collapse:collapse;">
                        @foreach ($solusiLines as $i => $line)
                            <tr>
                                <td width="22" valign="top" style="width:22pt; padding:0 6pt 6pt 0; font-size:11pt; font-weight:bold; color:#334155; mso-line-height-rule:exactly; line-height:16pt;">
                                    {{ $i + 1 }}.
                                </td>
                                <td valign="top" style="padding:0 0 6pt 0; font-size:11pt; color:#334155; mso-line-height-rule:exactly; line-height:16pt;">
                                    {{ $line }}
                                </td>
                            </tr>
                        @endforeach
                    </table>
                @else
                    <p style="margin:0; font-size:11pt; color:#334155; mso-line-height-rule:exactly; line-height:16pt;">
                        {{ $penyakit->solusi }}
                    </p>
                @endif
            </td>
        </tr>
    @endif

    {{-- Gejala --}}
    <tr>
        <td colspan="2" style="padding:14pt 0 0 0; border-top:1pt solid #e2e8f0;">
            <p style="margin:0 0 10pt 0; font-size:9pt; font-weight:bold; letter-spacing:0.6pt; text-transform:uppercase; color:#64748b; mso-line-height-rule:exactly; line-height:12pt;">
                Gejala yang Anda Pilih
            </p>
            @if (count($kodes))
                <table border="0" cellpadding="0" cellspacing="0" style="border-collapse:collapse;">
                    <tr>
                        @foreach ($kodes as $k)
                            <td style="padding:0 8pt 8pt 0;">
                                <table border="0" cellpadding="0" cellspacing="0" style="border-collapse:collapse;">
                                    <tr>
                                        <td style="padding:5pt 10pt; border:1pt solid #e2e8f0; background:#f8fafc; font-size:9pt; font-weight:600; color:#334155; mso-line-height-rule:exactly; line-height:12pt; white-space:nowrap;">
                                            {{ $namaGejala[$k] ?? $k }}
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        @endforeach
                    </tr>
                </table>
            @else
                <p style="margin:0; color:#94a3b8;">&mdash;</p>
            @endif
        </td>
    </tr>
</table>
