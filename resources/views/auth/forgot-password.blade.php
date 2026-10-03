<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Lupa Password | Raab Shoes</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=poppins:400,500,600,700,800" rel="stylesheet">
    <link href="{{ asset('css/forgot-password.css') }}" rel="stylesheet">
</head>
<body>
    <div class="recovery-shell">
        <header class="page-header">
            <a class="brand" href="{{ url('/') }}" aria-label="Raab Shoes — Beranda"><img src="{{ asset('images/raabshoes-logo.svg') }}" alt="Raab Shoes"></a>
            <a class="back" href="{{ route('login') }}"><span aria-hidden="true">↗</span> Kembali ke login</a>
        </header>
        <main class="recovery-card">
            <section class="story" aria-labelledby="story-title">
                <span class="eyebrow"><span class="status-dot"></span> A FRESH START</span>
                <h2 id="story-title">Lupa password?<br><span>Santai dulu.</span></h2>
                <p>Langkahmu nggak berhenti di sini.<br>Yuk, buka lagi akses akunmu.</p>
                <div class="key-art" aria-hidden="true">
                    <div class="orbit orbit-one"></div><div class="orbit orbit-two"></div>
                    <span class="spark spark-one">✦</span><span class="spark spark-two">✳</span>
                    <div class="key-tile"><svg viewBox="0 0 120 120" fill="none"><circle cx="45" cy="43" r="24" stroke="currentColor" stroke-width="10"/><circle cx="40" cy="38" r="5" fill="currentColor"/><path d="m63 61 35 35m-15-15 10-10m-1 19 10-10" stroke="currentColor" stroke-width="10" stroke-linecap="round" stroke-linejoin="round"/></svg></div>
                    <span class="floating-tag"><span>↗</span> Back on track.</span>
                </div>
                <div class="story-footer"><span class="mini-star" aria-hidden="true">✳</span><span>Fresh shoes.<br><strong>Fresh start.</strong></span><span class="edition">RAAB SHOES<br>ACCOUNT RECOVERY</span></div>
            </section>
            <section class="form-panel" aria-labelledby="form-title">
                <ol class="steps" aria-label="Tahapan reset password"><li aria-current="step"><span>01</span> Cari akun</li><li><span>02</span> Password baru</li></ol>
                <div class="form-heading"><span class="eyebrow">MULAI DARI SINI</span><h1 id="form-title">Temukan akunmu<span>.</span></h1><p>Masukkan email atau username yang kamu gunakan untuk masuk ke Raab Shoes.</p></div>
                @if(session('success'))<div class="flash" role="status">{{ session('success') }}</div>@endif
                @if(session('error'))<div class="flash error" role="alert">{{ session('error') }}</div>@endif
                <form action="{{ route('password.email') }}" method="post">
                    @csrf
                    <label for="identity">Email atau username</label>
                    <div class="input-wrap"><span aria-hidden="true">@</span><input id="identity" name="identity" type="text" value="{{ old('identity') }}" placeholder="Email atau username kamu" autocomplete="username" required @error('identity') aria-invalid="true" aria-describedby="identity-error" @enderror></div>
                    @error('identity')<p class="error-text" id="identity-error" role="alert">{{ $message }}</p>@enderror
                    <p class="input-hint">Gunakan salah satu yang terdaftar di akunmu.</p>
                    <button type="submit">Lanjut reset password <span aria-hidden="true">→</span></button>
                </form>
                <div class="next-note"><span aria-hidden="true">↳</span><p><strong>Selanjutnya?</strong><br>Setelah akun ditemukan, kamu bisa membuat password baru.</p></div>
                <p class="login-note">Sudah ingat passwordnya? <a href="{{ route('login') }}">Login sekarang</a></p>
            </section>
        </main>
        <footer class="page-footer"><span>© {{ date('Y') }} Raab Shoes</span><span>Perawatan sepatu, perhatian di setiap langkah.</span></footer>
    </div>
</body>
</html>
