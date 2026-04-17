<!-- resources/views/emails/forgot_password.blade.php -->
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Reset Password</title>
</head>
<body>
    <h2>Reset Your Password</h2>
    <p>We received a request to reset your password.</p>
    <p>
        <a href="{{ $resetUrl }}" style="color: blue; text-decoration: underline;">
            Click here to reset your password
        </a>
    </p>
    <p>This link will expire soon. If you didn’t request this, please ignore it.</p>
</body>
</html>
