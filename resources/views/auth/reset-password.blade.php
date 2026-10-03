<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Password Baru | Raab Shoes</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=poppins:400,500,600,700,800" rel="stylesheet">
    <link href="{{ asset('css/forgot-password.css') }}" rel="stylesheet">
</head>
<body class="reset-page">
    <div class="recovery-shell">
        <header class="page-header">
            <a class="brand" href="{{ url('/') }}" aria-label="Raab Shoes — Beranda"><img src="{{ asset('images/raabshoes-logo.svg') }}" alt="Raab Shoes"></a>
            <a class="back" href="{{ route('login') }}"><span aria-hidden="true">↗</span> Kembali ke login</a>
        </header>
        <main class="recovery-card">
            <section class="story" aria-labelledby="story-title">
                <span class="eyebrow"><span class="status-dot"></span> ONE MORE STEP</span>
                <h2 id="story-title">Akses baru.<br><span>Langkah baru.</span></h2>
                <p>Tinggal selangkah lagi untuk kembali.<br>Buat password baru, lalu lanjutkan harimu.</p>
                <div class="key-art" aria-hidden="true">
                    <div class="orbit orbit-one"></div><div class="orbit orbit-two"></div>
                    <span class="spark spark-one">✦</span><span class="spark spark-two">✳</span>
                    <div class="key-tile"><svg viewBox="0 0 120 120" fill="none"><rect x="25" y="49" width="70" height="56" rx="15" fill="currentColor"/><path d="M40 49V34a20 20 0 0 1 40 0v15" stroke="currentColor" stroke-width="9" stroke-linecap="round"/><circle cx="60" cy="72" r="7" fill="#fff0d1"/><path d="M60 77v10" stroke="#fff0d1" stroke-width="6" stroke-linecap="round"/></svg></div>
                    <span class="floating-tag"><span>↗</span> Ready to go.</span>
                </div>
                <div class="story-footer"><span class="mini-star" aria-hidden="true">✳</span><span>Fresh shoes.<br><strong>Fresh start.</strong></span><span class="edition">RAAB SHOES<br>ACCOUNT RECOVERY</span></div>
            </section>
            <section class="form-panel" aria-labelledby="form-title">
                <ol class="steps" aria-label="Tahapan reset password"><li class="step-done"><span aria-hidden="true">✓</span> Akun ditemukan</li><li aria-current="step"><span>02</span> Password baru</li></ol>
                <div class="form-heading"><span class="eyebrow">TINGGAL SATU LANGKAH</span><h1 id="form-title">Password baru,<br>awal yang baru<span>.</span></h1><p>Buat password yang mudah kamu ingat, tapi sulit ditebak orang lain.</p></div>
                <div class="account-chip"><span class="account-icon" aria-hidden="true">@</span><div><small>AKUN YANG DIPULIHKAN</small><strong>{{ $identity }}</strong></div><a href="{{ route('password.request') }}">Ganti</a></div>
                @if(session('success'))<div class="flash" role="status">{{ session('success') }}</div>@endif
                @if(session('error'))<div class="flash error" role="alert">{{ session('error') }}</div>@endif
                <form action="{{ route('password.update') }}" method="post">
                    @csrf
                    <div class="reset-field">
                        <label for="password">Password baru</label>
                        <div class="input-wrap"><input id="password" name="password" type="password" minlength="8" maxlength="16" placeholder="Buat password baru" autocomplete="new-password" required aria-describedby="password-hint @error('password') password-error @enderror" @error('password') aria-invalid="true" @enderror><button class="reveal" type="button" aria-controls="password" aria-label="Tampilkan password baru" aria-pressed="false">Lihat</button></div>
                        <p class="input-hint" id="password-hint">8–16 karakter. Tanpa kewajiban huruf kapital, angka, atau simbol.</p>
                        @error('password')<p class="error-text" id="password-error" role="alert">{{ $message }}</p>@enderror
                    </div>
                    <div class="reset-field">
                        <label for="password_confirmation">Konfirmasi password baru</label>
                        <div class="input-wrap"><input id="password_confirmation" name="password_confirmation" type="password" minlength="8" maxlength="16" placeholder="Ketik sekali lagi passwordmu" autocomplete="new-password" required><button class="reveal" type="button" aria-controls="password_confirmation" aria-label="Tampilkan konfirmasi password" aria-pressed="false">Lihat</button></div>
                    </div>
                    <button type="submit">Simpan password baru <span aria-hidden="true">→</span></button>
                </form>
                <div class="next-note"><span aria-hidden="true">↳</span><p><strong>Siap kembali beraktivitas.</strong><br>Setelah tersimpan, login dengan password barumu.</p></div>
            </section>
        </main>
        <footer class="page-footer"><span>© {{ date('Y') }} Raab Shoes</span><span>Perawatan sepatu, perhatian di setiap langkah.</span></footer>
    </div>
<script>
    document.querySelectorAll('.reveal').forEach((button) => {
        const input = document.getElementById(button.getAttribute('aria-controls'));
        const label = button.getAttribute('aria-label');
        button.addEventListener('click', () => {
            const visible = input.type === 'password';
            input.type = visible ? 'text' : 'password';
            button.textContent = visible ? 'Tutup' : 'Lihat';
            button.setAttribute('aria-pressed', String(visible));
            button.setAttribute('aria-label', visible ? label.replace('Tampilkan', 'Sembunyikan') : label);
        });
    });
</script>
</body>
</html>
