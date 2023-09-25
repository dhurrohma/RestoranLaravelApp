<!DOCTYPE html>
<html>
    <head>
        <title>Verifikasi Email {{ $user->name }}</title>
    </head>
    <body>
        <h1>Halo {{ $user->name }}</h1>
        <h1>Klik tombol berikut untuk melakukan verifikasi email untuk aplikasi Restoran</h1>
        <p>Abaikan pesan ini apabila anda merasa tidak melakukan registrasi untuk aplikasi Restoran</p>
        <a href="{{ $verificationUrl }}">Verifikasi Email</a>
    </body>
</html>