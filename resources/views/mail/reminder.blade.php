<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Reminder Isi Jadwal Wawancara</title>
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
                            <h1 style="color: #ffffff; font-size: 22px; margin: 0;">Pengingat Pengisian Jadwal Wawancara</h1>
                            <p style="color: #dbeafe; font-size: 14px; margin-top: 5px;">(No-Reply Email)</p>
                        </td>
                    </tr>

                    <!-- Body -->
                    <tr>
                        <td style="padding: 25px 30px; color: #374151;">
                            <p style="font-size: 16px; margin-bottom: 16px;">
                                Halo <strong>{{ $applicant->nama_lengkap }}</strong>,
                            </p>
                            <p style="font-size: 15px; line-height: 1.6; margin-bottom: 24px;">
                                Kami perhatikan kamu <strong>belum mengisi jadwal wawancara</strong> untuk proses seleksi Petra Civil Expo 2026.
                                Mohon segera memilih jadwal karena pada tanggal 4 November 2026 jam 10.00 WIB akan ditutup untuk pengisian jadwal.
                            </p>

                            <div style="text-align: center; margin: 28px 0;">
                                <a href="{{ $link }}" target="_blank"
                                   style="background-color: #2563eb; color: #ffffff; padding: 12px 28px; border-radius: 8px; text-decoration: none; font-weight: 600; font-size: 15px; display: inline-block;">
                                    Isi Jadwal Sekarang
                                </a>
                            </div>

                            <p style="font-size: 14px; color: #6b7280; line-height: 1.6;">
                                Apabila kamu sudah mengisi jadwal sebelumnya, abaikan email ini.  
                                Jika mengalami kendala saat mengisi, silakan hubungi panitia.
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
