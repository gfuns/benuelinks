<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Password Reset Email</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f5f5f5;
    }
    .container {
      max-width: 500px;
      margin: 0 auto;
      padding: 20px;
      background-color: #ffffff;
      border-radius: 8px;
      box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.1);
    }
    .logo {
      text-align: center;
      margin-bottom: 20px;
    }
    .logo img {
      max-width: 150px;
    }
    h1 {
      color: #333333;
      font-size: 24px;
      margin-top: 0;
    }
    p {
      color: #555555;
      font-size: 16px;
      line-height: 1.5;
    }
    .code {
      margin-top: 30px;
      padding: 15px;
      background-color: #f9f9f9;
      border-radius: 8px;
      font-size: 20px;
      font-weight: bold;
      text-align: center;
    }
  </style>
</head>
<body>
  <div class="container">
    <div class="logo">
      <img src="{{ $message->embed(public_path("images/logo.png"))}}" alt="Peace Mass Transit Logo">
    </div>
    <h1>Password Reset</h1>
    <p>Dear {{ $name }},</p>
    <p>We have received a request to reset your password. Please use the following code to proceed:</p>
    <div class="code">{{ $otp }}</div>
    <p>If you didn't request a password reset, you can safely ignore this email.</p>
    <p>Thank you,<br>Peace Mass Transit Team</p>
  </div>
</body>
</html>
