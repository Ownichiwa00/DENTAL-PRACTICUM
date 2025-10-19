<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Reset Password - ToothTalk</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f4f4f4; padding: 20px; }
        .container { max-width: 600px; margin: 0 auto; background: #fff; padding: 30px; border-radius: 12px; }
        a.button { display: inline-block; padding: 12px 20px; background-color: #0A7C7D; color: #fff; border-radius: 8px; text-decoration: none; font-weight: bold; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Reset Your ToothTalk Password</h2>
        <p>Hello,</p>
        <p>We received a request to reset your password. Click the button below to reset it:</p>
        <p><a href="{{ $resetLink }}" class="button">Reset Password</a></p>
        <p>If you did not request a password reset, no action is needed.</p>
        <p>Thanks,<br>The ToothTalk Team</p>
    </div>
</body>
</html>
