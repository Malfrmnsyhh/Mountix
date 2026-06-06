<!DOCTYPE html>
<html>

<head>
  <title>Verifikasi Email - Mountix</title>
</head>

<body style="font-family: Arial, sans-serif; color: #333;">
  <h2>Halo, {{ $user->name }}!</h2>
  <p>Terima kasih telah mendaftar di Mountix. Silakan verifikasi email Anda dengan mengklik tautan di bawah ini:</p>
  <p>
    <a href="{{ $url }}"
      style="display: inline-block; padding: 10px 20px; background-color: #4CAF50; color: #fff; text-decoration: none; border-radius: 5px;">
      Verifikasi Email
    </a>
  </p>
  <p>Jika Anda merasa tidak mendaftar akun ini, silakan abaikan pesan ini.</p>
</body>

</html>