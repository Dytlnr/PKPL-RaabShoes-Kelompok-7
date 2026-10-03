<!DOCTYPE html>
<html lang="id">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Sign In | Raab Shoes</title>
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=poppins:400,500,600,700,800" rel="stylesheet" />

        <style>
            :root { color-scheme: light; --orange: #ed7028; --ink: #292720; --muted: #77766e; }
            * { box-sizing: border-box; }
            body { margin: 0; background: #f5f3ee; color: var(--ink); font-family: 'Poppins', sans-serif; }
            a { color: inherit; text-decoration: none; }
            button, input { font: inherit; }
            a, button, input { -webkit-tap-highlight-color: transparent; }
            a:focus-visible, button:focus-visible { outline: 3px solid var(--orange); outline-offset: 5px; }
            .login-layout { min-height: 100svh; padding: 24px; display: grid; grid-template-columns: 1fr 1fr; gap: 24px; max-width: 1680px; margin: auto; }
            .brand-panel { min-height: 740px; border-radius: 28px; position: relative; overflow: hidden; background: #433d31; color: #fff; display: flex; flex-direction: column; padding: 40px; isolation: isolate; }
            .brand-photo { position: absolute; inset: 0; width: 100%; height: 100%; object-fit: cover; z-index: -2; }
            .brand-panel::after { content: ''; position: absolute; inset: 0; background: linear-gradient(180deg, rgba(24,25,19,.45), rgba(24,25,19,.08) 35%, rgba(24,25,19,.88)); z-index: -1; }
            .brand-header { display: flex; justify-content: space-between; align-items: center; gap: 16px; }
            .wordmark { font-size: 25px; font-weight: 800; letter-spacing: -1.2px; }
            .wordmark span { color: #ffab70; }
            .brand-tag { border: 1px solid #ffffff70; border-radius: 100px; padding: 8px 13px; font-size: 10px; letter-spacing: 1.5px; }
            .brand-story { margin-top: auto; padding-top: 180px; }
            .eyebrow { display: flex; align-items: center; gap: 10px; font-size: 11px; letter-spacing: 2px; font-weight: 600; text-transform: uppercase; }
            .eyebrow::before { content: ''; width: 24px; height: 2px; background: #ffad76; }
            .brand-story h2 { font-size: clamp(42px, 4.6vw, 72px); line-height: 1.09; letter-spacing: -3px; margin: 22px 0; font-weight: 600; }
            .brand-story h2 em { color: #ffab70; font-style: normal; }
            .brand-story p { max-width: 350px; font-size: 13px; line-height: 1.9; color: #eee7dd; }
            .service-tags { display: flex; flex-wrap: wrap; gap: 8px; margin: 26px 0 32px; }
            .service-tags span { padding: 8px 13px; border: 1px solid #ffffff45; border-radius: 100px; font-size: 10px; background: #ffffff0c; backdrop-filter: blur(8px); }
            .brand-bottom { display: flex; justify-content: space-between; align-items: center; padding-top: 22px; border-top: 1px solid #ffffff35; font-size: 10px; letter-spacing: 1.5px; }
            .spark { display: grid; place-items: center; width: 44px; height: 44px; border-radius: 50%; background: #ffab70; color: #343329; font-size: 30px; }
            .card-wrap { display: flex; flex-direction: column; padding: 18px clamp(18px, 4vw, 72px); }
            .home-link { display: inline-flex; align-items: center; gap: 8px; font-size: 12px; color: #68675f; align-self: flex-start; }
            .home-link:hover { color: #bb4b0d; }
            .home-link svg { width: 17px; height: 17px; }
            .login-card { width: 100%; max-width: 420px; margin: auto; padding: 42px 0; }
            .welcome { color: #a34818; font-size: 10px; letter-spacing: 2px; font-weight: 600; margin: 0 0 14px; }
            .title { font-size: clamp(32px, 3.2vw, 46px); line-height: 1.2; letter-spacing: -1.8px; font-weight: 600; margin: 0; }
            .intro { font-size: 12px; line-height: 1.9; color: var(--muted); margin: 14px 0 0; }
            .form-block { margin-top: 30px; }
            .field { margin-bottom: 20px; }
            .field label { display: block; margin-bottom: 9px; font-size: 12px; font-weight: 500; }
            .input-shell { position: relative; }
            .input-shell input { width: 100%; height: 54px; border: 1px solid #deddd6; border-radius: 12px; padding: 0 17px; background: #fff; color: var(--ink); font-size: 12px; outline: none; transition: border-color .2s, box-shadow .2s; }
            .input-shell input::placeholder { color: #96968e; }
            .input-shell input:focus { border-color: var(--orange); box-shadow: 0 0 0 4px #ed702815; }
            #password { padding-right: 58px; }
            .password-toggle { position: absolute; right: 6px; top: 5px; display: grid; place-items: center; width: 44px; height: 44px; border: 0; border-radius: 8px; color: #77766e; background: transparent; cursor: pointer; }
            .password-toggle svg { width: 21px; height: 21px; }
            .forgot { display: block; width: fit-content; margin: -6px 0 0 auto; font-size: 11px; color: #aa4514; }
            .forgot:hover, .signup-hint a:hover { text-decoration: underline; }
            .submit-btn { display: flex; align-items: center; justify-content: space-between; width: 100%; height: 54px; padding: 0 20px; margin-top: 25px; border: 0; border-radius: 12px; background: var(--orange); color: #fff; font-size: 13px; font-weight: 600; box-shadow: 0 7px 18px #ed702822; cursor: pointer; transition: background .2s, transform .2s; }
            .submit-btn:hover { background: #cf5917; transform: translateY(-1px); }
            .submit-btn span { font-size: 22px; font-weight: 400; }
            .divider { display: flex; align-items: center; gap: 15px; margin: 24px 0; color: #838279; font-size: 10px; }
            .divider::before, .divider::after { content: ''; height: 1px; flex: 1; background: #deddd6; }
            .social-btn { display: flex; justify-content: center; align-items: center; gap: 12px; min-height: 52px; border: 1px solid #deddd6; border-radius: 12px; background: #fff; font-size: 12px; transition: border-color .2s; }
            .social-btn:hover { border-color: #a6a396; }
            .social-icon, .social-icon svg { display: block; width: 20px; height: 20px; }
            .signup-hint { margin: 26px 0 0; text-align: center; font-size: 11px; color: var(--muted); }
            .signup-hint a { color: #aa4514; font-weight: 600; margin-left: 4px; }
            .page-footer { text-align: center; font-size: 10px; color: #85847b; margin: 0 0 6px; }
            .flash-message { margin: 20px 0 0; padding: 12px 15px; background: #fff1de; color: #864512; border-radius: 10px; font-size: 12px; }
            .flash-message.error { background: #fce9e6; color: #a23428; }
            @media (min-width: 1500px) { .brand-panel { min-height: 850px; } }
            @media (max-width: 1000px) { .login-layout { padding: 16px; gap: 12px; grid-template-columns: .9fr 1fr; } .brand-panel { padding: 28px; } .brand-tag { display: none; } .card-wrap { padding: 18px 24px; } }
            @media (max-width: 700px) { .login-layout { display: flex; flex-direction: column; padding: 12px; gap: 0; } .brand-panel { min-height: 260px; padding: 24px; border-radius: 20px; } .brand-photo { object-position: center 57%; } .brand-story { padding-top: 30px; } .brand-story h2 { font-size: 36px; letter-spacing: -1.5px; margin: 12px 0 0; } .brand-story h2 br { display: none; } .brand-story p, .service-tags, .brand-bottom, .eyebrow { display: none; } .brand-tag { display: block; font-size: 8px; } .wordmark { font-size: 22px; } .card-wrap { padding: 22px 16px 10px; } .login-card { padding: 30px 0; } .title { font-size: 34px; } }
            @media (prefers-reduced-motion: reduce) { *, *::before, *::after { transition: none !important; } }
        </style>
    </head>
    <body>
        <div class="login-layout">
            <section class="brand-panel" aria-label="RaabShoes shoe care">
                <img class="brand-photo" src="{{ asset('images/login-shoe-cleaning-bg.png') }}" alt="Perawatan sepatu dengan sikat dan pembersih">
                <div class="brand-header">
                    <a class="wordmark" href="{{ url('/') }}">raab<span>shoes.</span></a>
                    <span class="brand-tag">SHOE CARE & MORE</span>
                </div>
                <div class="brand-story">
                    <div class="eyebrow">A fresh start, every step</div>
                    <h2>Sepatu bersih.<br>Langkah baru.<br><em>Cerita seru.</em></h2>
                    <p>Perawatan sepatu kesayangan, dari tangan yang peduli pada setiap detail.</p>
                    <div class="service-tags"><span>Deep Cleaning</span><span>Repaint</span><span>Repair</span></div>
                </div>
                <div class="brand-bottom"><span>FRESH SHOES. GOOD MOOD.</span><span class="spark" aria-hidden="true">✳</span></div>
            </section>
            <div class="card-wrap">
                <a href="{{ url('/') }}" class="home-link">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path d="m10 5-7 7 7 7M3 12h18"/></svg>
                    Kembali ke beranda
                </a>
                <main class="login-card">
                    @if(app()->environment('praktikum'))
                        <p role="status" style="padding:10px 14px;border-radius:10px;background:#fff0df;color:#864512;font-size:12px">Mode Praktikum · Data demo terpisah</p>
                    @endif
                    <p class="welcome">WELCOME BACK</p>
                    <h1 class="title">Siap melangkah lagi?</h1>
                    <p class="intro">Masuk ke akun RaabShoes dan lanjutkan<br>aktivitasmu hari ini.</p>

                    @if(session('success'))
                        <div class="flash-message" role="status">{{ session('success') }}</div>
                    @endif

                    @if(session('error'))
                        <div class="flash-message error" role="alert">{{ session('error') }}</div>
                    @endif

                    @if($errors->any())
                        <div class="flash-message error" role="alert">{{ $errors->first() }}</div>
                    @endif

                    <form class="form-block" action="{{ route('login.attempt') }}" method="post">
                        @csrf
                        <div class="field is-primary">
                            <label for="email">Username atau email</label>
                            <div class="input-shell">
                                <input id="email" name="email" type="text" value="{{ old('email') }}" placeholder="Masukkan username atau email" autocomplete="username" required>
                            </div>
                        </div>

                        <div class="field">
                            <label for="password">Password</label>
                            <div class="input-shell">
                                <input id="password" name="password" type="password" placeholder="Masukkan password" autocomplete="current-password" required>
                                <button class="password-toggle" type="button" id="password-toggle" aria-label="Tampilkan password" aria-pressed="false">
                                    <svg id="password-toggle-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7-10-7-10-7Z"/>
                                        <circle cx="12" cy="12" r="3"/>
                                        <path d="M4 4l16 16"/>
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <a class="forgot" href="{{ route('password.request') }}">Lupa password?</a>

                        <button class="submit-btn" type="submit">Masuk ke akun <span aria-hidden="true">↗</span></button>

                        <div class="divider">atau masuk dengan</div>

                        <div class="social-row">
                            <a href="{{ route('social.redirect', 'google') }}" class="social-btn google">
                                <span class="social-icon" aria-hidden="true">
                                    <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path fill="#EA4335" d="M12 10.2v3.9h5.4c-.2 1.3-1.5 3.9-5.4 3.9-3.2 0-5.9-2.7-5.9-6s2.7-6 5.9-6c1.8 0 3.1.8 3.8 1.5l2.6-2.5C16.8 3.4 14.6 2.5 12 2.5A9.5 9.5 0 0 0 2.5 12 9.5 9.5 0 0 0 12 21.5c5.5 0 9.1-3.8 9.1-9.2 0-.6-.1-1.1-.2-1.6H12Z"/>
                                        <path fill="#4285F4" d="M2.5 12c0 1.5.4 2.9 1.2 4.1l3.1-2.4c-.2-.5-.3-1.1-.3-1.7s.1-1.2.3-1.7L3.7 7.9A9.4 9.4 0 0 0 2.5 12Z"/>
                                        <path fill="#FBBC05" d="M12 21.5c2.6 0 4.8-.9 6.4-2.4l-3.1-2.4c-.8.6-1.9 1.1-3.3 1.1-2.5 0-4.6-1.7-5.3-4l-3.1 2.4c1.6 3.2 4.8 5.3 8.4 5.3Z"/>
                                        <path fill="#34A853" d="M6.7 13.8c-.2-.5-.3-1.1-.3-1.8s.1-1.2.3-1.8L3.6 7.8A9.5 9.5 0 0 0 2.5 12c0 1.5.4 2.9 1.1 4.2l3.1-2.4Z"/>
                                    </svg>
                                </span>
                                <span>Lanjutkan dengan Google</span>
                            </a>
                        </div>
                    </form>
                    @if($registrationOpen)
                        <p class="signup-hint">Baru mulai? <a href="{{ route('register') }}">Daftar Admin pertama</a></p>
                    @else
                        <p class="signup-hint">Butuh akun pegawai? <a href="{{ route('register') }}">Hubungi Admin toko</a></p>
                    @endif
                </main>
                <p class="page-footer">&copy; {{ date('Y') }} RaabShoes. Every step matters.</p>
            </div>
        </div>
        <script>
            (() => {
                const passwordInput = document.getElementById('password');
                const passwordToggle = document.getElementById('password-toggle');
                const passwordToggleIcon = document.getElementById('password-toggle-icon');

                if (!passwordInput || !passwordToggle || !passwordToggleIcon) {
                    return;
                }

                const setPasswordVisible = (visible) => {
                    passwordInput.type = visible ? 'text' : 'password';
                    passwordToggle.setAttribute('aria-pressed', String(visible));
                    passwordToggle.setAttribute('aria-label', visible ? 'Sembunyikan password' : 'Tampilkan password');
                    passwordToggleIcon.innerHTML = visible
                        ? '<path d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7-10-7-10-7Z"></path><circle cx="12" cy="12" r="3"></circle>'
                        : '<path d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7-10-7-10-7Z"></path><circle cx="12" cy="12" r="3"></circle><path d="M4 4l16 16"></path>';
                };

                passwordToggle.addEventListener('click', () => {
                    setPasswordVisible(passwordInput.type === 'password');
                });
            })();
        </script>
    </body>
</html>
