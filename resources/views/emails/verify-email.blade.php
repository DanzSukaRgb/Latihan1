<!DOCTYPE html>
<html>
<head>
    <title>Verifikasi Email</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&display=swap');

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            line-height: 1.6;
            color: #222;
            background-color: #f9f9f9;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 600px;
            margin: 40px auto;
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 24px rgba(0, 0, 0, 0.05);
            overflow: hidden;
        }

        .header {
            padding: 32px 40px 24px;
            border-bottom: 1px solid #f0f0f0;
        }

        .content {
            padding: 32px 40px;
        }

        .footer {
            padding: 24px 40px;
            background: #fafafa;
            color: #888;
            font-size: 14px;
            text-align: center;
            border-top: 1px solid #f0f0f0;
        }

        h1 {
            color: #222;
            font-weight: 600;
            font-size: 24px;
            margin: 0 0 8px;
        }

        p {
            margin: 16px 0;
            color: #444;
            font-size: 15px;
        }

        .button-container {
            margin: 32px 0;
            text-align: center;
        }

        .button {
            display: inline-block;
            background-color: #2563eb;
            color: white !important;
            padding: 14px 28px;
            text-decoration: none;
            border-radius: 8px;
            font-weight: 500;
            font-size: 15px;
            transition: all 0.2s ease;
            box-shadow: 0 2px 8px rgba(37, 99, 235, 0.2);
        }

        .button:hover {
            background-color: #1d4ed8;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.3);
        }

        .link {
            word-break: break-all;
            background: #f5f5f5;
            padding: 16px;
            border-radius: 8px;
            font-size: 14px;
            color: #555;
        }

        .logo {
            font-weight: 600;
            font-size: 20px;
            color: #2563eb;
        }

        .divider {
            height: 1px;
            background: linear-gradient(to right, transparent, #eee, transparent);
            margin: 24px 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="logo">Sistem Absensi</div>
        </div>

        <div class="content">
            <h1>Verifikasi Email Anda</h1>

            <p>Halo <strong>{{ $user->name }}</strong>,</p>

            <p>Terima kasih telah mendaftar di sistem absensi kami. Untuk menyelesaikan pendaftaran, silakan verifikasi alamat email Anda dengan mengklik tombol berikut:</p>

            <div class="button-container">
                <a href="{{ route('verify.email', ['token' => $user->email_verification_token]) }}"
                   class="button">
                    Verifikasi Email Sekarang
                </a>
            </div>

            <div class="divider"></div>

            <p>Jika tombol di atas tidak bekerja, salin dan tempel URL berikut ke browser Anda:</p>

            <p class="link">{{ route('verify.email', ['token' => $user->email_verification_token]) }}</p>

            <p>Link verifikasi akan kedaluwarsa dalam 24 jam. Jika Anda tidak merasa melakukan pendaftaran ini, Anda bisa mengabaikan email ini.</p>
        </div>

        <div class="footer">
            <p>&copy; 2023 Tim Absensi. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
