<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Applicant Belum Dapat Jadwal</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f4f6f8; margin: 0; padding: 0;">
    <table width="100%" cellspacing="0" cellpadding="0" style="background-color: #f4f6f8; padding: 30px 0;">
        <tr>
            <td align="center">
                <table width="600" cellspacing="0" cellpadding="0" style="background-color: #ffffff; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 6px rgba(0,0,0,0.1);">
                    <!-- Header -->
                    <tr>
                        <td align="center" style="background: linear-gradient(135deg, #2563eb, #1e40af); color: #ffffff; padding: 20px;">
                            <h2 style="margin: 0;">Applicant Belum Mendapat Jadwal Wawancara</h2>
                        </td>
                    </tr>

                    <!-- Body -->
                    <tr>
                        <td style="padding: 30px; color: #333333;">
                            <p style="font-size: 16px; line-height: 1.6;">
                                Berikut data applicant yang belum mendapat jadwal wawancara yang sesuai:
                            </p>

                            <table width="100%" cellpadding="6" cellspacing="0" style="border-collapse: collapse; font-size: 15px;">
                                <tr>
                                    <td width="30%" style="font-weight: bold;">NRP</td>
                                    <td>{{ $applicant->nrp }}</td>
                                </tr>
                                <tr>
                                    <td style="font-weight: bold;">Nama</td>
                                    <td>{{ $applicant->nama_lengkap }}</td>
                                </tr>
                                <tr>
                                    <td style="font-weight: bold;">ID Line</td>
                                    <td>{{ $applicant->line_id }}</td>
                                </tr>
                                <tr>
                                    <td style="font-weight: bold;">No HP</td>
                                    <td>{{ $applicant->no_hp }}</td>
                                </tr>
                                <tr>
                                    <td style="font-weight: bold;">Divisi 1</td>
                                    <td>{{ $applicant->division1->name ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <td style="font-weight: bold;">Divisi 2</td>
                                    <td>{{ $applicant->division2->name ?? '-' }}</td>
                                </tr>
                            </table>

                            <p style="font-size: 16px; line-height: 1.6; margin-top: 20px;">
                                Mohon untuk segera meninjau dan menyesuaikan jadwal agar applicant dapat diproses lebih lanjut.
                            </p>

                            <p style="text-align: center; margin-top: 30px;">
                                <a href="{{ $link }}"
                                   style="display: inline-block; background-color: #0288D1; color: white; text-decoration: none; padding: 12px 24px; border-radius: 6px;">
                                    Atur Jadwal Sekarang
                                </a>
                            </p>
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td align="center" style="background-color: #eeeeee; padding: 15px; font-size: 13px; color: #777;">
                            © {{ date('Y') }} Petra Civil Expo 2026. Email ini dikirim otomatis oleh sistem.
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
