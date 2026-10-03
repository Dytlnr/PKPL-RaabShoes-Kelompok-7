@extends('layouts.admin')

@section('page-title', 'Pengaturan Sistem')
@section('page-subtitle', 'Kelola tim dan akses akun dalam satu tempat.')
@section('active-menu', 'settings')

@push('styles')
<style>
.settings-card{background:rgba(255,255,255,.98);border-radius:34px;box-shadow:var(--shadow);overflow:hidden}.tabs{display:flex;align-items:center;justify-content:space-between;gap:24px;padding:24px 34px 22px;border-bottom:2px solid var(--orange)}.tabs-left{display:flex;align-items:center;gap:34px;flex-wrap:wrap}.tab{display:inline-flex;align-items:center;gap:12px;font-size:.98rem;font-weight:700;color:#7f7f84}.tab svg{width:28px;height:28px}.tab.active{color:var(--orange)}.add-user-btn{min-width:290px;height:72px;padding:0 28px;border:0;border-radius:30px;background:linear-gradient(180deg,#ff8c0d 0%,#f57c00 100%);color:#fff;display:inline-flex;align-items:center;justify-content:center;font-size:1rem;font-weight:700;box-shadow:0 12px 24px rgba(245,124,0,.22);cursor:pointer}.settings-body{padding:30px 34px 34px}.flash-message{margin:0 0 18px;padding:14px 18px;border-radius:18px;background:#fff4e7;border:1px solid rgba(245,124,0,.28);color:#8a4d10;font-size:.94rem}.flash-message.error{background:#fff1ef;border-color:rgba(214,102,92,.28);color:#a54a3c}.section-title{margin:0 0 16px;font-size:1rem;font-weight:700}.user-list{display:flex;flex-direction:column;gap:28px}.user-card{min-height:142px;padding:28px 34px;background:#fff;border-radius:28px;box-shadow:var(--shadow);display:flex;align-items:center;justify-content:space-between;gap:24px}.user-name{font-size:.98rem;font-weight:700;margin-bottom:4px}.user-meta{font-size:.96rem;line-height:1.6}.role-badge{min-width:144px;height:62px;padding:0 28px;border-radius:28px;display:inline-flex;align-items:center;justify-content:center;font-size:.98rem;font-weight:700;box-shadow:0 10px 20px rgba(65,44,18,.1)}.role-badge.admin{background:#ffd29d}.role-badge.staff{background:#0a5b8d;color:#fff}.info-box{margin-top:28px;padding:26px 32px;border-radius:30px;background:#ffd29d}.info-title{margin:0 0 10px;font-size:.98rem;font-weight:700}.info-list{margin:0;padding-left:24px;line-height:1.65;font-size:.96rem}.modal-backdrop{position:fixed;inset:0;background:rgba(17,20,26,.44);display:none;align-items:center;justify-content:center;padding:24px;z-index:70}.modal-backdrop.is-open{display:flex}.modal-card{width:min(100%,680px);padding:28px;border-radius:30px;background:var(--panel);box-shadow:var(--shadow);border:1px solid var(--notif-border)}.modal-header{display:flex;align-items:flex-start;justify-content:space-between;gap:18px;margin-bottom:22px}.modal-title{margin:0;font-size:1.35rem;font-weight:700}.modal-subtitle{margin:8px 0 0;color:var(--muted);font-size:.95rem}.modal-close{width:46px;height:46px;border:0;border-radius:14px;background:#fff3e2;color:var(--orange);display:inline-flex;align-items:center;justify-content:center;cursor:pointer}.modal-close svg{width:22px;height:22px}.modal-form{display:grid;gap:18px}.field-grid{display:grid;grid-template-columns:1fr 1fr;gap:18px}.field{display:flex;flex-direction:column;gap:8px}.field label{font-size:.95rem;font-weight:600}.field input{height:58px;padding:0 16px;border:2px solid var(--orange);border-radius:16px;outline:none;background:#fff;font-size:.95rem}.field input::placeholder{color:#ababaf}.field.full{grid-column:1 / -1}.helper-text{margin:0;color:var(--muted);font-size:.84rem}.error-list{margin:0;padding:14px 18px 14px 34px;border-radius:18px;background:#fff1ef;border:1px solid rgba(214,102,92,.28);color:#a54a3c;font-size:.9rem}.modal-actions{display:flex;justify-content:flex-end;gap:12px;margin-top:4px}.modal-btn{min-width:150px;height:52px;padding:0 18px;border-radius:16px;border:2px solid transparent;font-size:.94rem;font-weight:700;cursor:pointer}.modal-btn.cancel{background:transparent;color:var(--text);border-color:rgba(245,124,0,.28)}.modal-btn.submit{background:linear-gradient(180deg,#ff8c0d 0%,#f57c00 100%);color:#fff}@media(max-width:980px){.tabs{flex-direction:column;align-items:flex-start}.user-card{flex-direction:column;align-items:flex-start}.add-user-btn{width:100%;min-width:0}}@media(max-width:700px){.tabs-left{flex-direction:column;align-items:flex-start;gap:16px}.settings-body{padding-left:20px;padding-right:20px}.role-badge{min-width:0;width:100%}.field-grid{grid-template-columns:1fr}.modal-actions{flex-direction:column-reverse}.modal-btn{width:100%}}
</style>
<link rel="stylesheet" href="{{ asset('css/catalog-layout.css') }}">
<link rel="stylesheet" href="{{ asset('css/settings.css') }}">
@endpush

@section('content')
@php($users = $users ?? [])
<div class="settings-intro">
    <div><span class="settings-eyebrow">RUANG KELOLA TIM</span><h2>Tim yang solid,<br>layanan lebih maksimal.</h2><p>Atur akun pegawai dan kenali peran setiap anggota tim Raab Shoes.</p></div>
    <div class="team-summary" aria-label="Ringkasan pengguna">
        <div><strong>{{ count($users) }}</strong><span>Total akun</span></div>
        <div><strong>{{ collect($users)->where('role', 'admin')->count() }}</strong><span>Admin</span></div>
        <div><strong>{{ collect($users)->where('role', 'pegawai')->count() }}</strong><span>Pegawai</span></div>
    </div>
</div>
<section class="settings-card">
    <div class="tabs">
        <div class="tabs-left">
            <a href="{{ route('settings.index') }}" class="tab active" aria-current="page"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M9 11a4 4 0 1 1 0-8 4 4 0 0 1 0 8Zm8 1a3 3 0 1 1 0-6 3 3 0 0 1 0 6ZM4 20a5 5 0 0 1 10 0H4Zm9.5 0a4.5 4.5 0 0 1 8.5 0h-8.5Z"/></svg><span>Akun Tim</span></a>
            <a href="{{ route('settings.password') }}" class="tab"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M17 9h-1V7a4 4 0 0 0-8 0v2H7a2 2 0 0 0-2 2v8a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2v-8a2 2 0 0 0-2-2Zm-6 6.7V17a1 1 0 1 0 2 0v-1.3a2 2 0 1 0-2 0ZM10 9V7a2 2 0 1 1 4 0v2h-4Z"/></svg><span>Ganti Password</span></a>
        </div>
        <button type="button" class="add-user-btn" id="open-add-user">+ Tambah Akun</button>
    </div>

    <div class="settings-body">
        @if(session('success'))
            <div class="flash-message">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="flash-message error">{{ session('error') }}</div>
        @endif

        <div class="team-list-heading"><div><h2 class="section-title">Kenali tim Anda</h2><p>Daftar akun yang terdaftar di Raab Shoes.</p></div><span>{{ count($users) }} akun</span></div>
        <div class="user-list">
            @forelse($users as $user)
                <article class="user-card {{ ($user['role'] ?? 'pegawai') === 'admin' ? 'is-admin' : 'is-staff' }}">
                    <div class="user-card-top">
                        <span class="team-avatar" aria-hidden="true">{{ mb_strtoupper(mb_substr($user['name'], 0, 1)) }}</span>
                        <span class="role-badge {{ ($user['role'] ?? 'pegawai') === 'admin' ? 'admin' : 'staff' }}">{{ ($user['role'] ?? 'pegawai') === 'admin' ? 'Admin' : 'Pegawai' }}</span>
                    </div>
                    <h3 class="user-name">{{ $user['name'] }}</h3>
                    <p class="user-email">{{ $user['email'] }}</p>
                    <dl class="user-details">
                        <div><dt>Username</dt><dd>{{ $user['username'] ?: '—' }}</dd></div>
                        <div><dt>Nomor HP</dt><dd>{{ $user['phone'] ?: '—' }}</dd></div>
                    </dl>
                    <div class="user-access"><span aria-hidden="true">{{ ($user['role'] ?? 'pegawai') === 'admin' ? '◇' : '○' }}</span>{{ ($user['role'] ?? 'pegawai') === 'admin' ? 'Akses penuh pengelolaan sistem' : 'Akun operasional pegawai' }}</div>
                    @if((int) ($authUser['user_id'] ?? session('social_auth.user_id')) !== (int) $user['id'] && session('social_auth.email') !== $user['email'])
                        <form method="post" action="{{ route('settings.users.destroy', $user['id']) }}" class="delete-account-form" data-name="{{ $user['name'] }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="delete-account-btn"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" aria-hidden="true"><path d="M3 6h18M9 6V3h6v3M5 6l1 15h12l1-15M10 10v7M14 10v7"/></svg>Hapus Akun</button>
                        </form>
                    @else
                        <div class="current-account-note">Akun yang sedang Anda gunakan</div>
                    @endif
                </article>
            @empty
                <div class="team-empty">Belum ada akun. Klik Tambah Akun untuk mulai membentuk tim Anda.</div>
            @endforelse
        </div>

        <aside class="info-box">
            <span class="access-icon" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7"><path d="M12 3 4 6v6c0 5 8 9 8 9s8-4 8-9V6l-8-3Z"/><path d="m8 12 3 3 5-6"/></svg></span>
            <div><h3 class="info-title">Akses yang terkelola, tim yang terjaga</h3><p>Admin mengelola seluruh fitur dan membuat akun pegawai. Pendaftaran umum dinonaktifkan, sehingga akses tim tetap berada dalam kendali Anda.</p></div>
        </aside>
    </div>
</section>

<div class="modal-backdrop {{ $errors->any() ? 'is-open' : '' }}" id="add-user-modal" aria-hidden="{{ $errors->any() ? 'false' : 'true' }}">
    <div class="modal-card staff-dialog" role="dialog" aria-modal="true" aria-labelledby="add-user-title">
        <div class="modal-header">
            <div>
                <span class="staff-eyebrow">RAAB SHOES / TIM</span>
                <h2 class="modal-title" id="add-user-title">Kenalkan, anggota baru.</h2>
                <p class="modal-subtitle">Buat akun pegawai dan mulai bekerja bersama tim Raab Shoes.</p>
            </div>
            <button type="button" class="modal-close" id="close-add-user" aria-label="Tutup form tambah akun">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M6 6l12 12"/><path d="M18 6 6 18"/></svg>
            </button>
        </div>

        <div class="staff-welcome">
            <span class="staff-preview-avatar" id="staff-avatar" aria-hidden="true">+</span>
            <div><strong id="staff-preview-name">Pegawai baru</strong><span>Siap jadi bagian dari tim</span></div>
            <span class="staff-role">Pegawai</span>
        </div>
        @if($errors->any())
            <ul class="error-list">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        @endif

        <form method="post" action="{{ route('settings.users.store') }}" class="modal-form">
            @csrf
            <div class="staff-section"><span>01</span><div><strong>Kenali pegawai</strong><p>Identitas dan kontak anggota tim.</p></div></div>
            <div class="field-grid">
                <div class="field">
                    <label for="staff-name">Nama Pegawai</label>
                    <input id="staff-name" name="name" type="text" value="{{ old('name') }}" placeholder="Nama lengkap pegawai" autocomplete="off">
                </div>
                <div class="field">
                    <label for="staff-username">Username</label>
                    <input id="staff-username" name="username" type="text" value="{{ old('username') }}" placeholder="contoh: dyata-lintar" autocomplete="off" autocapitalize="none" spellcheck="false">
                    <p class="helper-text">Spasi otomatis menjadi tanda hubung, misalnya dyata-lintar.</p>
                </div>
                <div class="field">
                    <label for="staff-email">Email</label>
                    <input id="staff-email" name="email" type="email" value="{{ old('email') }}" placeholder="pegawai@raabshoes.com">
                </div>
                <div class="field">
                    <label for="staff-phone">Nomor HP</label>
                    <input id="staff-phone" name="phone" type="tel" value="{{ old('phone') }}" placeholder="08xxxxxxxxxx">
                </div>
            </div>
            <div class="staff-section"><span>02</span><div><strong>Akses akun</strong><p>Siapkan password untuk login pegawai.</p></div></div>
            <div class="field-grid">
                <div class="field">
                    <label for="staff-password">Password</label>
                    <div class="staff-password-wrap"><input id="staff-password" name="password" type="password" minlength="8" maxlength="16" placeholder="8–16 karakter" autocomplete="new-password"><button type="button" class="staff-password-toggle" data-target="staff-password" aria-label="Tampilkan password" aria-pressed="false">Lihat</button></div>
                </div>
                <div class="field">
                    <label for="staff-password-confirmation">Konfirmasi Password</label>
                    <div class="staff-password-wrap"><input id="staff-password-confirmation" name="password_confirmation" type="password" minlength="8" maxlength="16" placeholder="Ulangi password" autocomplete="new-password"><button type="button" class="staff-password-toggle" data-target="staff-password-confirmation" aria-label="Tampilkan konfirmasi password" aria-pressed="false">Lihat</button></div>
                </div>
            </div>
            <p class="staff-access-note"><span aria-hidden="true">◇</span> Akun ini mendapat peran <strong>Pegawai</strong> untuk operasional toko.</p>
            <div class="modal-actions">
                <button type="button" class="modal-btn cancel" id="cancel-add-user">Batal</button>
                <button type="submit" class="modal-btn submit">+ Buat Akun Pegawai</button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    (function () {
        document.querySelectorAll('.delete-account-form').forEach((form) => {
            form.addEventListener('submit', (event) => {
                if (!window.confirm(`Hapus akun "${form.dataset.name}"? Akun ini akan dihapus permanen.`)) {
                    event.preventDefault();
                }
            });
        });

        const modal = document.getElementById('add-user-modal');
        const openBtn = document.getElementById('open-add-user');
        const closeBtn = document.getElementById('close-add-user');
        const cancelBtn = document.getElementById('cancel-add-user');

        if (!modal) {
            return;
        }

        const nameInput = document.getElementById('staff-name');
        const updatePreview = () => {
            const name = nameInput.value.trim();
            document.getElementById('staff-preview-name').textContent = name || 'Pegawai baru';
            document.getElementById('staff-avatar').textContent = name ? Array.from(name)[0].toUpperCase() : '+';
        };
        nameInput.addEventListener('input', updatePreview);
        updatePreview();
        modal.querySelectorAll('.staff-password-toggle').forEach((button) => {
            button.addEventListener('click', () => {
                const input = document.getElementById(button.dataset.target);
                const visible = input.type === 'password';
                input.type = visible ? 'text' : 'password';
                button.textContent = visible ? 'Tutup' : 'Lihat';
                button.setAttribute('aria-pressed', String(visible));
                button.setAttribute('aria-label', `${visible ? 'Sembunyikan' : 'Tampilkan'} ${button.dataset.target.includes('confirmation') ? 'konfirmasi password' : 'password'}`);
            });
        });
        const setOpen = (open) => {
            modal.classList.toggle('is-open', open);
            modal.setAttribute('aria-hidden', String(!open));
            document.body.style.overflow = open ? 'hidden' : '';
            if (open) nameInput.focus();
            else openBtn.focus();
        };

        if (openBtn) {
            openBtn.addEventListener('click', () => setOpen(true));
        }

        if (closeBtn) {
            closeBtn.addEventListener('click', () => setOpen(false));
        }

        if (cancelBtn) {
            cancelBtn.addEventListener('click', () => setOpen(false));
        }

        modal.addEventListener('click', (event) => {
            if (event.target === modal) {
                setOpen(false);
            }
        });

        if (modal.classList.contains('is-open')) setOpen(true);
        modal.addEventListener('keydown', (event) => {
            if (event.key !== 'Tab') return;
            const items = [...modal.querySelectorAll('button, input, a[href]')].filter(el => !el.disabled);
            const first = items[0], last = items[items.length - 1];
            if (event.shiftKey && document.activeElement === first) { event.preventDefault(); last.focus(); }
            else if (!event.shiftKey && document.activeElement === last) { event.preventDefault(); first.focus(); }
        });
        document.addEventListener('keydown', (event) => {
            if (event.key === 'Escape' && modal.classList.contains('is-open')) {
                setOpen(false);
            }
        });
    }());
</script>
@endpush
