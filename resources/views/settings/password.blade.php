@extends('layouts.admin')

@section('page-title', 'Pengaturan Sistem')
@section('page-subtitle', 'Kelola keamanan password akun Anda.')
@section('active-menu', 'settings')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/catalog-layout.css') }}">
<link rel="stylesheet" href="{{ asset('css/settings.css') }}">
<link rel="stylesheet" href="{{ asset('css/settings-password.css') }}">
@endpush

@section('content')
<section class="settings-card password-page">
    <div class="tabs"><div class="tabs-left">@if(\App\Models\User::accountManager())<a href="{{ route('settings.index') }}" class="tab"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M9 11a4 4 0 1 1 0-8 4 4 0 0 1 0 8Zm8 1a3 3 0 1 1 0-6 3 3 0 0 1 0 6ZM4 20a5 5 0 0 1 10 0H4Zm9.5 0a4.5 4.5 0 0 1 8.5 0h-8.5Z"/></svg><span>Akun Tim</span></a>@endif<a href="{{ route('settings.password') }}" class="tab active" aria-current="page"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M17 9h-1V7a4 4 0 0 0-8 0v2H7a2 2 0 0 0-2 2v8a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2v-8a2 2 0 0 0-2-2Zm-6 6.7V17a1 1 0 1 0 2 0v-1.3a2 2 0 1 0-2 0ZM10 9V7a2 2 0 1 1 4 0v2h-4Z"/></svg><span>Ganti Password</span></a></div><span class="password-section-label">PENGATURAN AKUN</span></div>
    <div class="password-layout">
        <aside class="password-story">
            <span class="settings-eyebrow">KEAMANAN AKUN</span>
            <div class="password-art" aria-hidden="true">
                <div class="shield-orbit"></div>
                <div class="shield-tile"><svg viewBox="0 0 100 110" fill="none"><path d="M50 8 17 20v29c0 25 33 47 33 47s33-22 33-47V20L50 8Z" fill="currentColor" fill-opacity=".12" stroke="currentColor" stroke-width="3"/><rect x="34" y="44" width="32" height="28" rx="7" fill="currentColor"/><path d="M40 44v-8a10 10 0 0 1 20 0v8" stroke="currentColor" stroke-width="4"/><circle cx="50" cy="56" r="3" fill="#fff7ed"/><path d="M50 58v5" stroke="#fff7ed" stroke-width="3" stroke-linecap="round"/></svg></div>
                <span class="password-art-tag">● ● ● ● ● ● ● ●</span>
            </div>
            <h2>Akun Anda.<br>Kendali Anda.</h2>
            <p>Jaga akses ke ruang kerja Raab Shoes dengan password yang hanya Anda ketahui.</p>
            <div class="password-tip"><span aria-hidden="true">✦</span><div><strong>Buat yang sulit ditebak</strong><p>Gunakan 8–16 karakter. Tidak wajib memakai huruf kapital, angka, atau simbol.</p></div></div>
        </aside>
        <div class="password-form-panel">
            <span class="password-section-label">PERBARUI AKSES</span>
            <h2>Ganti password</h2>
            <p class="password-description">Masukkan password saat ini, lalu tentukan password baru untuk akun Anda.</p>
            @if(session('success'))<div class="flash-message">{{ session('success') }}</div>@endif
            @if($errors->any())<div class="flash-message error">{{ $errors->first() }}</div>@endif
            <form class="password-fields" method="post" action="{{ route('settings.password.update') }}">
                @csrf
                @foreach([
                    ['id' => 'current-password', 'name' => 'current_password', 'label' => 'Password saat ini', 'placeholder' => 'Masukkan password lama', 'autocomplete' => 'current-password'],
                    ['id' => 'new-password', 'name' => 'password', 'label' => 'Password baru', 'placeholder' => 'Buat password baru', 'autocomplete' => 'new-password'],
                    ['id' => 'confirm-password', 'name' => 'password_confirmation', 'label' => 'Konfirmasi password baru', 'placeholder' => 'Ulangi password baru', 'autocomplete' => 'new-password'],
                ] as $field)
                    <div class="password-field">
                        <label for="{{ $field['id'] }}">{{ $field['label'] }}</label>
                        <div class="password-input-wrap">
                            <svg class="field-lock" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" aria-hidden="true"><rect x="5" y="10" width="14" height="11" rx="3"/><path d="M8 10V7a4 4 0 0 1 8 0v3M12 14v3"/></svg>
                            <input id="{{ $field['id'] }}" name="{{ $field['name'] }}" required type="password" @if($field['name'] !== 'current_password') minlength="8" maxlength="16" @endif autocomplete="{{ $field['autocomplete'] }}" placeholder="{{ $field['placeholder'] }}">
                            <button type="button" class="password-reveal" aria-controls="{{ $field['id'] }}" aria-label="Tampilkan {{ strtolower($field['label']) }}" aria-pressed="false" data-label="{{ strtolower($field['label']) }}"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" aria-hidden="true"><path d="M2 12s4-7 10-7 10 7 10 7-4 7-10 7S2 12 2 12Z"/><circle cx="12" cy="12" r="3"/></svg></button>
                        </div>
                    </div>
                @endforeach
                <button type="submit" class="password-save"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" aria-hidden="true"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2Z"/><path d="M17 21v-8H7v8M7 3v5h8"/></svg>Simpan Password Baru<span aria-hidden="true">→</span></button>
            </form>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
    document.querySelectorAll('.password-reveal').forEach((button) => {
        button.addEventListener('click', () => {
            const input = document.getElementById(button.getAttribute('aria-controls'));
            const visible = input.type === 'password';
            input.type = visible ? 'text' : 'password';
            button.setAttribute('aria-pressed', String(visible));
            button.setAttribute('aria-label', `${visible ? 'Sembunyikan' : 'Tampilkan'} ${button.dataset.label}`);
        });
    });
</script>
@endpush
