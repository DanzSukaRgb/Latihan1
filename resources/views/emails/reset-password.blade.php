<!DOCTYPE html>
<html>
<head>
    <title>Reset Password</title>
</head>
<body>
    <h2>Halo {{ $user->name }},</h2>
    <p>Kami menerima permintaan untuk mereset kata sandi Anda. Klik link berikut untuk mengatur ulang kata sandi:</p>

    <a href="{{ url('/reset-password/' . $token) }}"
       style="background-color: #4CAF50; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;">
        Reset Password
    </a>

    <p>Link ini akan kedaluwarsa dalam 1 jam. Jika Anda tidak meminta reset password, abaikan email ini.</p>
</body>
</html>
