<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Notifikasi Jadwal Wawancara</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body style="margin: 0; padding: 0; background-color: #f3f4f6; font-family: 'Segoe UI', Arial, sans-serif;">
    <table align="center" cellpadding="0" cellspacing="0" width="100%" style="padding: 30px 0;">
        <tr>
            <td align="center">
                <table cellpadding="0" cellspacing="0" width="600" style="background-color: #ffffff; border-radius: 12px; box-shadow: 0 3px 10px rgba(0,0,0,0.1); overflow: hidden;">
                    <!-- Header -->
                    <tr>
                        <td align="center" style="background: linear-gradient(135deg, #2563eb, #1e40af); padding: 25px;">
                            <h1 style="color: #ffffff; font-size: 22px; margin: 0;">Notifikasi Jadwal Wawancara</h1>
                            <p style="color: #dbeafe; font-size: 14px; margin-top: 5px;">(No-Reply Email)</p>
                        </td>
                    </tr>

                    <!-- Body -->
                    <tr>
                        <td style="padding: 25px 30px; color: #374151;">
                            <p style="font-size: 16px; margin-bottom: 16px;">
                                Halo <strong>{{ $name}}</strong>,
                            </p>
                            <p style="font-size: 15px; line-height: 1.6; margin-bottom: 24px;">
                                Seorang peserta baru saja memilih jadwal wawancara. Berikut adalah detail jadwalnya:
                            </p>

                            <table cellpadding="8" cellspacing="0" width="100%" style="background-color: #f9fafb; border-radius: 8px; font-size: 15px;">
                                <tr>
                                    <td style="width: 120px; font-weight: 600; color: #1f2937;">Hari</td>
                                    <td style="color: #374151;">{{ $hari }}</td>
                                </tr>
                                <tr>
                                    <td style="font-weight: 600; color: #1f2937;">Tanggal</td>
                                    <td style="color: #374151;">{{ $tanggal }}</td>
                                </tr>
                                <tr>
                                    <td style="font-weight: 600; color: #1f2937;">Jam</td>
                                    <td style="color: #374151;">{{ $jam }}</td>
                                </tr>

                                @if ($isOnline)
                                    <tr>
                                        <td style="font-weight: 600; color: #1f2937;">Link GMeet</td>
                                        <td>
                                            <a href="{{ $link_gmeet }}" style="color: #2563eb; text-decoration: none;" target="_blank">{{ $link_gmeet }}</a>
                                        </td>
                                    </tr>
                                @else
                                    <tr>
                                        <td style="font-weight: 600; color: #1f2937;">Lokasi</td>
                                        <td style="color: #374151;">{{ $lokasi }}</td>
                                    </tr>
                                @endif
                            </table>

                            @if ($isOnline)
                            <div style="text-align: center; margin-top: 28px;">
                                <a href="{{ $link_gmeet }}" target="_blank"
                                   style="background-color: #2563eb; color: #ffffff; padding: 12px 28px; border-radius: 8px; text-decoration: none; font-weight: 600; font-size: 15px; display: inline-block;">
                                    Bergabung ke Google Meet
                                </a>
                            </div>
                            @endif

                            <p style="font-size: 14px; color: #6b7280; text-align: center; margin-top: 32px;">
                                Jika terdapat kendala atau perubahan jadwal, silakan hubungi anaknya.
                            </p>
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td align="center" style="background-color: #f9fafb; padding: 16px;">
                            <p style="font-size: 12px; color: #9ca3af; margin: 0;">
                                © 2025 Petra Civil Expo | Panitia Penerimaan Anggota Baru
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
