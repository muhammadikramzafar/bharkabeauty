<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Your Login Code — AmsazBeauty</title>
<style>
  body { margin:0; padding:0; background:#f5f0eb; font-family:'Helvetica Neue',Arial,sans-serif; }
  .wrap { max-width:480px; margin:40px auto; background:#fff; border-radius:12px; overflow:hidden; box-shadow:0 2px 12px rgba(0,0,0,.08); }
  .header { background:#2d2016; padding:28px 40px; text-align:center; }
  .header h1 { margin:0; color:#c8a882; font-size:22px; letter-spacing:2px; text-transform:uppercase; }
  .body { padding:36px 40px; text-align:center; }
  .label { font-size:14px; color:#6b5a48; margin-bottom:20px; line-height:1.6; }
  .otp-box { display:inline-block; background:#f9f5f0; border:2px solid #c8a882; border-radius:12px; padding:18px 40px; margin:8px 0 24px; }
  .otp-code { font-size:38px; font-weight:800; letter-spacing:10px; color:#2d2016; font-family:monospace; }
  .expiry { font-size:13px; color:#a8907a; margin-bottom:8px; }
  .footer { background:#f9f5f0; padding:20px 40px; text-align:center; font-size:12px; color:#a8907a; border-top:1px solid #ede8e0; }
</style>
</head>
<body>
<div class="wrap">
  <div class="header"><h1>AmsazBeauty</h1></div>
  <div class="body">
    <p class="label">Use the code below to sign in to your account.<br>Do not share this code with anyone.</p>
    <div class="otp-box">
      <div class="otp-code">{{ $token }}</div>
    </div>
    <p class="expiry">This code expires in <strong>10 minutes</strong>.</p>
    <p style="font-size:12px;color:#a8907a;">If you didn't request this, you can safely ignore this email.</p>
  </div>
  <div class="footer">© {{ date('Y') }} AmsazBeauty. All rights reserved.</div>
</div>
</body>
</html>
