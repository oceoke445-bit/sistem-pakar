<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pendaftaran Berhasil</title>
</head>
<body style="margin:0;padding:0;background:#f8fafc;font-family:Inter,Segoe UI,Arial,sans-serif;color:#0f172a;">
<table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="background:#f8fafc;padding:32px 16px;">
    <tr>
        <td align="center">
            <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="max-width:560px;background:#ffffff;border:1px solid #e2e8f0;border-radius:16px;overflow:hidden;">
                <tr>
                    <td style="background:linear-gradient(135deg,#0e3d78,#092c57);padding:28px 32px;">
                        <h1 style="margin:0;font-size:22px;font-weight:800;color:#ffffff;letter-spacing:0.04em;text-transform:uppercase;">
                            {{ config('app.name', 'Sistem Pakar') }}
                        </h1>
                        <p style="margin:8px 0 0;font-size:14px;color:#dbeafe;">
                            Pendaftaran akun berhasil
                        </p>
                    </td>
                </tr>
                <tr>
                    <td style="padding:32px;">
                        <p style="margin:0 0 16px;font-size:15px;line-height:1.6;">
                            Halo <strong>{{ $namaLengkap }}</strong>,
                        </p>
                        <p style="margin:0 0 24px;font-size:15px;line-height:1.6;color:#334155;">
                            Akun Anda telah berhasil dibuat. Berikut detail login Anda:
                        </p>

                        <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="background:#f1f5f9;border-radius:12px;margin-bottom:24px;">
                            <tr>
                                <td style="padding:20px 24px;">
                                    <p style="margin:0 0 12px;font-size:13px;color:#64748b;text-transform:uppercase;letter-spacing:0.06em;font-weight:600;">Email</p>
                                    <p style="margin:0 0 20px;font-size:15px;font-weight:600;color:#0f172a;">{{ $email }}</p>

                                    <p style="margin:0 0 12px;font-size:13px;color:#64748b;text-transform:uppercase;letter-spacing:0.06em;font-weight:600;">Password</p>
                                    <p style="margin:0;font-size:15px;font-weight:600;color:#0f172a;font-family:Consolas,Monaco,monospace;">{{ $password }}</p>
                                </td>
                            </tr>
                        </table>

                        <p style="margin:0 0 24px;font-size:14px;line-height:1.6;color:#475569;">
                            Anda sudah langsung masuk ke sistem setelah mendaftar. Simpan email ini sebagai referensi password Anda.
                        </p>

                        <a href="{{ config('app.url') }}/login"
                           style="display:inline-block;background:#1d4ed8;color:#ffffff;text-decoration:none;font-size:14px;font-weight:600;padding:12px 24px;border-radius:10px;">
                            Masuk ke Sistem
                        </a>
                    </td>
                </tr>
                <tr>
                    <td style="padding:20px 32px;border-top:1px solid #e2e8f0;background:#f8fafc;">
                        <p style="margin:0;font-size:12px;line-height:1.5;color:#94a3b8;text-align:center;">
                            Email otomatis dari {{ config('app.name', 'Sistem Pakar') }}. Jangan bagikan password Anda kepada siapapun.
                        </p>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
</body>
</html>
