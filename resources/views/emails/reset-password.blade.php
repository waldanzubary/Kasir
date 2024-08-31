<!-- resources/views/emails/reset-password.blade.php -->

<!DOCTYPE html>
<html>
<head>
    <title>Reset Your Password</title>
</head>
<body>
    <h1>Hello,</h1>
    <p>You are receiving this email because we received a password reset request for your account.</p>
    <p>Please click the button below to reset your password:</p>
    <a href="{{ url('reset-password/' . $token . '?email=' . urlencode($email)) }}" style="display: inline-block; padding: 10px 20px; font-size: 16px; color: #fff; background-color: #007bff; text-decoration: none; border-radius: 5px;">
        Reset Password
    </a>
    <p>If you did not request a password reset, no further action is required.</p>
    <p>Regards,<br>UMKM Store Team</p>
</body>
</html>
