<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Akses Tim | RaabShoes</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=poppins:400,500,600,700,800" rel="stylesheet">
    <link href="{{ asset('css/register.css') }}" rel="stylesheet">
</head>
<body>
    <main class="access-layout">
        <section class="access-story" aria-label="Tim RaabShoes">
            <div class="story-top"><a class="wordmark" href="{{ url('/') }}">raab<span>shoes.</span></a><span class="team-tag">TEAM ACCESS</span></div>
            <div class="story-copy"><p class="eyebrow">GOOD CARE STARTS WITH A GOOD TEAM</p><h1>Tim yang peduli.<br>Langkah yang<br><em>lebih berarti.</em></h1><p>Di balik sepatu yang kembali bersih,<br>ada tim yang bekerja sepenuh hati.</p></div>
            <div class="team-art" aria-hidden="true">
                <div class="orbit"></div><span class="art-spark">✳</span>
                <img src="{{ asset('images/auth-scooter-illustration.png') }}" alt="">
                <div class="art-label"><span>✦</span><div>Made fresh, together.<small>THE RAABSHOES TEAM</small></div></div>
            </div>
            <div class="story-footer"><span>SHOE CARE & MORE</span><span>EST. WITH CARE ↗</span></div>
        </section>
        <section class="access-content" aria-labelledby="access-title">
            <a class="back-link" href="{{ url('/') }}"><span aria-hidden="true">←</span> Kembali ke beranda</a>
            <div class="access-card">
                    @if(app()->environment('praktikum'))
                        <p role="status" style="padding:10px 14px;border-radius:10px;background:#fff0df;color:#864512;font-size:12px">Mode Praktikum · Data demo terpisah</p>
                    @endif
                <div class="access-icon" aria-hidden="true"><svg viewBox="0 0 32 32" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><rect x="6" y="13" width="20" height="15" rx="4"/><path d="M10 13V9a6 6 0 0 1 12 0v4M16 19v3"/></svg><span>✦</span></div>
                <p class="section-kicker">RUANG KERJA RAABSHOES</p>
                @if($registrationOpen)
                    <h2 id="access-title">Mulai bersama<br>RaabShoes.</h2>
                    <p class="intro">Buat akun Admin pertama untuk mengelola toko. Setelah berhasil, akun pegawai dapat ditambahkan melalui Pengaturan.</p>
                    @if(session('error'))
                        <p class="access-message" role="alert">{{ session('error') }}</p>
                    @endif
                    @if($errors->any())
                        <div class="access-message" role="alert"><ul>
                            @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
                        </ul></div>
                    @endif
                    <form class="registration-form" action="{{ route('register.store') }}" method="post">
                        @csrf
                        <label for="name">Nama lengkap</label>
                        <input id="name" name="name" value="{{ old('name') }}" autocomplete="name" maxlength="255" required>
                        <label for="username">Username</label>
                        <input id="username" name="username" value="{{ old('username') }}" autocomplete="username" maxlength="255" pattern="[a-zA-Z0-9_-]+" required>
                        <label for="email">Email</label>
                        <input id="email" name="email" type="email" value="{{ old('email') }}" autocomplete="email" maxlength="255" required>
                        <label for="phone">Nomor HP</label>
                        <input id="phone" name="phone" type="tel" value="{{ old('phone') }}" autocomplete="tel" maxlength="30" required>
                        <label for="password">Password (8–16 karakter)</label>
                        <input id="password" name="password" type="password" autocomplete="new-password" minlength="8" maxlength="16" required>
                        <label for="password_confirmation">Konfirmasi password</label>
                        <input id="password_confirmation" name="password_confirmation" type="password" autocomplete="new-password" minlength="8" maxlength="16" required>
                        <button class="login-action" type="submit">Buat akun Admin <span aria-hidden="true">↗</span></button>
                    </form>
                @else
                    <h2 id="access-title">Admin toko<br>sudah terdaftar.</h2>
                    <p class="intro">Registrasi Admin pertama sudah ditutup. Untuk mendapatkan akun pegawai, hubungi Admin toko. Akun pegawai dibuat melalui menu Pengaturan.</p>
                    @if(session('error'))
                        <p class="access-message" role="alert">{{ session('error') }}</p>
                    @endif
                @endif
                <a class="login-action" href="{{ route('login') }}">Sudah punya akun? Masuk <span aria-hidden="true">↗</span></a>
                <p class="access-note"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" aria-hidden="true"><path d="m12 3 8 3v6c0 5-8 9-8 9s-8-4-8-9V6l8-3Z"/><path d="m8 12 3 3 5-6"/></svg>Akses khusus admin dan pegawai RaabShoes.</p>
            </div>
            <footer>© {{ date('Y') }} RaabShoes. Every step matters.</footer>
        </section>
    </main>
</body>
</html>
