<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Raab Shoes - We Care About Your Shoes</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=poppins:400,500,600,700,800" rel="stylesheet" />

    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
</head>

<body>
    <div class="page-shell">
        <header class="nav">
            <a href="/" class="brand" aria-label="Raab Shoes">
                <img src="{{ asset('images/raabshoes-logo.svg') }}" alt="Raab Shoes" class="brand-logo">
            </a>

            <nav class="nav-links" aria-label="Primary navigation">
                <a href="#home" class="is-active">Beranda</a>
                <div class="services-dropdown">
                    <button type="button" class="services-toggle with-caret" aria-expanded="false">
                        Layanan <span class="caret" aria-hidden="true"></span>
                    </button>
                    <div class="services-menu">
                        <button type="button" class="services-menu-item" data-target="#services">Professional Cleaning</button>
                        <a href="#contact">Hubungi Kami</a>
                    </div>
                </div>
                <a href="#about">Tentang</a>
                <a href="#faq">FAQ</a>
                <a href="#contact">Kontak</a>
            </nav>

            <div class="nav-actions">
                <a href="{{ route('login') }}" class="button button-primary">Masuk ↗</a>
                <a href="{{ route('register') }}" class="button button-secondary">Daftar</a>
            </div>
        </header>

        <main class="hero" id="home">
            <section class="hero-copy">
                <p class="eyebrow"><span></span> YOUR SHOES, OUR PASSION</p>
                <h1 class="headline">Sepatu lama.<br><em>Rasa baru.</em></h1>

                <p class="description">
                    Setiap sepatu punya cerita. Biar kami rawat, supaya langkahmu berikutnya terasa lebih istimewa.
                </p>

                <div class="hero-buttons">
                    <a href="{{ route('login') }}" class="button button-primary">Masuk Manajemen <span aria-hidden="true">↗</span></a>
                    <a href="https://raabshoes.vercel.app/" target="_blank" rel="noopener" class="button button-secondary">Lihat Layanan</a>
                </div>
                <p class="hero-note"><span aria-hidden="true">✳</span> Dirawat dengan teliti. Siap menemani lagi.</p>
            </section>

            <section class="hero-visual" aria-label="Before and after shoe cleaning">
                <div class="visual-heading"><span>THE FRESH START</span><span>01 / SHOE CARE</span></div><div class="orbit" aria-hidden="true"></div><span class="visual-spark" aria-hidden="true">✳</span>

                <article class="feature-card top" id="services">
                    <div class="icon-box" aria-hidden="true">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="11" cy="11" r="7"></circle>
                            <path d="M20 20l-3.5-3.5"></path>
                        </svg>
                    </div>
                    <div>
                        <h2 class="feature-title">Deep cleaning</h2>
                        <p class="feature-text">Bersih hingga ke detail</p>
                    </div>
                </article>

                <article class="feature-card bottom">
                    <div class="icon-box" aria-hidden="true">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="5" y="4" width="14" height="17" rx="2"></rect>
                            <path d="M9 2h6"></path>
                            <path d="M9 9h6"></path>
                            <path d="M9 13h6"></path>
                            <path d="M9 17h3"></path>
                        </svg>
                    </div>
                    <div>
                        <h2 class="feature-title">Fresh again!</h2>
                        <p class="feature-text">Siap untuk cerita berikutnya</p>
                    </div>
                </article>

                <div class="shoe-showcase">
                    <img
                        class="shoe-photo"
                        src="{{ asset('images/shoes-before-after.png') }}"
                        alt="Before and after shoe cleaning"
                    >

                    <div class="labels">
                        <span class="label before">SEBELUM</span>
                        <span class="label after">SESUDAH ✦</span>
                    </div>
                </div>
            </section>
        </main>

        <div class="care-strip" aria-label="Layanan perawatan"><span>DEEP CLEAN</span><b aria-hidden="true">✳</b><span>REPAINT</span><b aria-hidden="true">✳</b><span>REGLUE</span><b aria-hidden="true">✳</b><span>UNYELLOWING</span></div>
        <section class="management-box" id="about">
            <div><span class="section-kicker">BEHIND EVERY FRESH PAIR</span><h2>Perawatan sepenuh hati.<br>Pengelolaan lebih rapi.</h2></div>
            <div><p>RaabShoes menghubungkan perawatan sepatu dengan pengelolaan toko. Pelanggan, layanan, pesanan, pembayaran, hingga laporan—semua tertata dalam satu tempat.</p><a href="{{ route('login') }}">Buka manajemen toko <span aria-hidden="true">↗</span></a></div>
        </section>
        <section class="faq-section" id="faq">
            <div class="faq-header">
                <p class="faq-eyebrow">FAQ</p>
                <h2 class="faq-title">Sebelum melangkah,<br>cari tahu dulu.</h2>
                <p class="faq-description">
                    Semua yang perlu kamu tahu tentang perawatan sepatu kesayanganmu.
                </p>
            </div>

            <div class="faq-list">
                <details class="faq-item" open>
                    <summary class="faq-question">
                        <span>Layanan apa saja yang tersedia di Raab Shoes?</span>
                        <span class="faq-icon" aria-hidden="true"></span>
                    </summary>
                    <div class="faq-answer">
                        Raab Shoes melayani deep clean, express clean, reglue, unyellowing, repaint/custom,
                        serta cleaning untuk tas dan topi. Detail pilihan layanan bisa dilihat pelanggan
                        lewat tombol <strong>Lihat Layanan</strong> di halaman utama.
                    </div>
                </details>

                <details class="faq-item">
                    <summary class="faq-question">
                        <span>Berapa lama estimasi pengerjaan tiap order?</span>
                        <span class="faq-icon" aria-hidden="true"></span>
                    </summary>
                    <div class="faq-answer">
                        Estimasi mengikuti layanan yang dipilih. Misalnya Deep Clean Reguler sekitar 1-3 hari,
                        Express sekitar 1 hari, dan beberapa layanan repair memiliki durasi berbeda. Saat order dibuat,
                        admin juga bisa melihat dan membagikan estimasi tanggal pengambilan.
                    </div>
                </details>

                <details class="faq-item">
                    <summary class="faq-question">
                        <span>Bagaimana pelanggan tahu barang sudah siap diambil?</span>
                        <span class="faq-icon" aria-hidden="true"></span>
                    </summary>
                    <div class="faq-answer">
                        Setelah pengerjaan selesai, status order bisa diubah menjadi <strong>Siap Diambil</strong>.
                        Dari sistem, admin juga bisa mengirim ringkasan order ke WhatsApp pelanggan sebagai pengingat.
                    </div>
                </details>

                <details class="faq-item">
                    <summary class="faq-question">
                        <span>Metode pembayaran apa yang tersedia?</span>
                        <span class="faq-icon" aria-hidden="true"></span>
                    </summary>
                    <div class="faq-answer">
                        Saat ini tersedia pembayaran tunai, transfer bank, dan QRIS. Untuk pembayaran tunai,
                        sistem dapat mencatat nominal uang dibayar dan menghitung kembalian pelanggan secara otomatis.
                    </div>
                </details>

                <details class="faq-item">
                    <summary class="faq-question">
                        <span>Apakah ada program member untuk pelanggan tetap?</span>
                        <span class="faq-icon" aria-hidden="true"></span>
                    </summary>
                    <div class="faq-answer">
                        Ada. Pelanggan bisa mengumpulkan stempel member dari layanan cuci yang memenuhi syarat.
                        Setiap 8 kali layanan, pelanggan berhak mendapatkan 1 free service sesuai aturan member card.
                    </div>
                </details>
            </div>
        </section>
        <section class="contact-card" id="contact"><div><span class="section-kicker">LET’S TALK SHOES</span><h2>Sepatumu butuh perhatian?</h2><p>Konsultasikan perawatan yang pas bersama kami.</p></div><a class="button" href="https://wa.me/6285385260457" target="_blank" rel="noopener">Chat via WhatsApp <span aria-hidden="true">↗</span></a></section>
        <footer class="site-footer"><span>© {{ date('Y') }} RaabShoes</span><span>Fresh shoes. Good mood.</span><a href="#home">Kembali ke atas ↑</a></footer>
    </div>

    <script>
        (() => {
            const dropdown = document.querySelector('.services-dropdown');
            const toggle = document.querySelector('.services-toggle');

            if (!dropdown || !toggle) {
                return;
            }

            const setOpen = (open) => {
                dropdown.classList.toggle('is-open', open);
                toggle.setAttribute('aria-expanded', String(open));
            };

            const scrollToSection = (selector) => {
                const target = document.querySelector(selector);

                if (!target) {
                    return;
                }

                target.scrollIntoView({
                    behavior: window.matchMedia('(prefers-reduced-motion: reduce)').matches ? 'instant' : 'smooth',
                    block: selector === '#home' || selector === '#faq' ? 'start' : 'center',
                });

                window.history.replaceState(null, '', selector);
            };

            toggle.addEventListener('click', (event) => {
                event.stopPropagation();
                setOpen(!dropdown.classList.contains('is-open'));
            });

            document.querySelectorAll('.nav-links a[href^="#"]').forEach((link) => {
                link.addEventListener('click', (event) => {
                    event.preventDefault();
                    setOpen(false);
                    scrollToSection(link.getAttribute('href'));
                });
            });

            dropdown.querySelectorAll('.services-menu a, .services-menu-item').forEach((item) => {
                item.addEventListener('click', (event) => {
                    const selector = item.dataset.target || item.getAttribute('href');

                    if (selector && selector.startsWith('#')) {
                        event.preventDefault();
                        scrollToSection(selector);
                    }

                    setOpen(false);
                });
            });

            document.addEventListener('click', (event) => {
                if (!dropdown.contains(event.target)) {
                    setOpen(false);
                }
            });

            window.addEventListener('keydown', (event) => {
                if (event.key === 'Escape') {
                    setOpen(false);
                }
            });
        })();
    </script>
</body>
</html>
