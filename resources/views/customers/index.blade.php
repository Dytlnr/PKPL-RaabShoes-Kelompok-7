@extends('layouts.admin')

@section('page-title', 'Manajemen Pelanggan')
@section('page-subtitle', 'Kelola, pantau, dan perbarui data pelanggan di sini')
@section('active-menu', 'customers')

@push('styles')
<style>
.top-actions{display:flex;justify-content:flex-end;margin-bottom:32px}.primary-btn{min-width:292px;height:72px;padding:0 28px;border-radius:28px;background:linear-gradient(180deg,#ff8c0d 0%,#f57c00 100%);color:#fff;font-size:.96rem;font-weight:600;display:inline-flex;align-items:center;justify-content:center;box-shadow:0 12px 22px rgba(245,124,0,.2)}.flash-message,.error-box{margin:0 0 18px;padding:14px 18px;border-radius:18px;font-size:.94rem}.flash-message{background:#fff4e7;border:1px solid rgba(245,124,0,.28);color:#8a4d10}.error-box{background:#fff0ef;border:1px solid rgba(220,65,53,.22);color:#b42318}.error-box ul{margin:8px 0 0;padding-left:18px}.error-box li+li{margin-top:4px}.search-panel,.empty-state,.customers-list{background:rgba(255,255,255,.98);box-shadow:var(--shadow)}.search-panel{padding:36px 30px;border-radius:40px}.search-box{height:70px;border:2px solid var(--orange);border-radius:22px;background:#fff;display:flex;align-items:center;gap:14px;padding:0 24px}.search-box svg{width:34px;height:34px;color:#9d9da3}.search-box input{width:100%;border:0;outline:none;font:inherit;font-size:.96rem;background:transparent}.customers-list{margin-top:30px;padding:24px;border-radius:34px;display:grid;gap:18px}.customer-card{padding:24px;border:2px solid rgba(245,124,0,.2);border-radius:28px;background:#fff;display:grid;grid-template-columns:minmax(0,1.2fr) minmax(280px,.95fr);gap:20px;align-items:stretch}.customer-name{font-size:1.05rem;font-weight:700}.customer-meta{margin-top:8px;color:#6d6d75;font-size:.92rem;line-height:1.65}.member-code{display:inline-flex;align-items:center;gap:8px;margin-top:14px;padding:10px 14px;border-radius:999px;background:#fff7ed;color:#9a5300;font-size:.84rem;font-weight:700;letter-spacing:.04em}.member-card{padding:18px;border-radius:24px;background:linear-gradient(145deg,#fff7ea 0%,#fff1d6 100%);border:1px solid rgba(245,124,0,.18);display:grid;gap:14px}.member-header{display:flex;justify-content:space-between;gap:12px;align-items:flex-start}.member-title{margin:0;font-size:1rem;font-weight:700}.member-subtitle{margin:6px 0 0;color:#8b7355;font-size:.86rem;line-height:1.5}.reward-badge{min-width:110px;height:42px;padding:0 16px;border-radius:999px;background:#fff;color:#f57c00;display:inline-flex;align-items:center;justify-content:center;font-size:.84rem;font-weight:800;box-shadow:0 8px 20px rgba(245,124,0,.12)}.stamp-grid{display:grid;grid-template-columns:repeat(8,minmax(0,1fr));gap:8px}.stamp-dot{aspect-ratio:1/1;border-radius:16px;border:2px dashed rgba(245,124,0,.28);background:#fff;display:flex;align-items:center;justify-content:center;font-size:.78rem;font-weight:800;color:#f1b375;text-decoration:none;transition:transform .16s ease,box-shadow .16s ease,border-color .16s ease}.stamp-dot:hover{transform:translateY(-2px);box-shadow:0 10px 18px rgba(245,124,0,.12);border-color:#f0af79}.stamp-dot.filled{border-style:solid;border-color:#f57c00;background:linear-gradient(180deg,#ff9a24 0%,#f57c00 100%);color:#fff;box-shadow:0 10px 18px rgba(245,124,0,.18)}.stamp-hint{font-size:.82rem;color:#8b7355}.member-stats{display:grid;grid-template-columns:repeat(3,minmax(0,1fr));gap:10px}.member-stat{padding:12px 14px;border-radius:18px;background:#fff}.member-stat-label{font-size:.8rem;color:#8d775a}.member-stat-value{margin-top:6px;font-size:1rem;font-weight:800;color:#2e2e33}.redeem-form{display:flex;justify-content:flex-end}.redeem-btn{min-width:190px;height:46px;padding:0 18px;border-radius:16px;border:0;background:linear-gradient(180deg,#ff8c0d 0%,#f57c00 100%);color:#fff;font-size:.9rem;font-weight:700;box-shadow:0 10px 20px rgba(245,124,0,.18)}.redeem-note{font-size:.84rem;color:#8b7355;line-height:1.5}.history-list{display:grid;gap:10px}.history-row{padding:12px 14px;border-radius:18px;background:#fff8ef;border:1px solid #f4dec0}.history-code{font-size:.86rem;font-weight:800;color:#2f2f35}.history-meta{margin-top:4px;font-size:.86rem;color:#786a59;line-height:1.55}.empty-state{margin-top:44px;min-height:406px;padding:40px 34px;border-radius:40px;display:flex;flex-direction:column;align-items:center;justify-content:center;text-align:center}.empty-state svg{width:78px;height:78px;color:#a8a8ad}.empty-text{margin:18px 0 0;color:#99999f;font-size:1rem;font-weight:500}.modal-overlay{position:fixed;inset:0;display:none;align-items:center;justify-content:center;padding:28px;background:rgba(16,16,18,.46);z-index:50}.modal-overlay:target,.modal-overlay.force-open{display:flex}.modal-backdrop{position:absolute;inset:0}.modal-card{position:relative;width:min(100%,620px);max-height:calc(100vh - 56px);overflow:auto;background:#fff;border-radius:28px;box-shadow:0 24px 60px rgba(19,16,10,.28);z-index:1}.modal-header{padding:16px 22px 14px;border-bottom:2px solid var(--orange)}.modal-title{margin:0;font-size:clamp(1.45rem,3.4vw,2rem);font-weight:700;letter-spacing:-.05em}.modal-body{padding:16px 22px 20px}.modal-form{display:flex;flex-direction:column;gap:16px}.modal-field{display:flex;flex-direction:column;gap:7px}.modal-label{font-size:.9rem;font-weight:500}.required{color:#e7461b}.modal-input,.modal-textarea{width:100%;border:2px solid var(--orange);border-radius:14px;background:#fff;outline:none;padding:0 14px}.modal-input{height:48px}.modal-textarea{min-height:120px;padding-top:12px;padding-bottom:12px;resize:vertical}.modal-actions{display:flex;justify-content:flex-end;gap:12px;padding-top:2px}.modal-btn{min-width:118px;height:44px;border-radius:14px;display:inline-flex;align-items:center;justify-content:center;border:2px solid transparent;font-size:.9rem;font-weight:600}.modal-btn.cancel{border-color:var(--orange);background:#fff;color:#4a4a4f}.modal-btn.save{background:linear-gradient(180deg,#ff8c0d 0%,#f57c00 100%);color:#fff}@media(max-width:980px){.customer-card{grid-template-columns:1fr}.member-stats{grid-template-columns:1fr 1fr 1fr}}@media(max-width:640px){.primary-btn{height:66px;border-radius:24px;min-width:0;width:100%}.stamp-grid,.member-stats{grid-template-columns:repeat(4,minmax(0,1fr))}.modal-overlay{padding:14px}.modal-card{border-radius:24px}.modal-header,.modal-body{padding-left:18px;padding-right:18px}.modal-actions{flex-direction:column}.modal-btn,.redeem-btn{width:100%}.redeem-form{justify-content:stretch}}
</style>
<link rel="stylesheet" href="{{ asset('css/customers.css') }}?v=2">
@endpush

@section('content')
@php($customers = $customers ?? [])
<header class="customer-hero"><div><span class="customer-eyebrow">RAAB SHOES • CUSTOMER CLUB</span><h2>Pelanggan kembali.<br>Cerita baik berlanjut.</h2><p>Kenali pelanggan, pantau stempel, dan berikan apresiasi di setiap perawatan.</p><a href="#add-customer" class="primary-btn">＋ Tambah pelanggan</a></div><div class="club-preview"><span>RAAB / MEMBER CLUB</span><strong>Little stamps.<br>Big appreciation.</strong><div aria-hidden="true">✦ ✦ ✦ ✦ ✦ ✦ ✦ ♡</div><small>8 stempel = 1 layanan gratis</small></div></header>
<div class="customer-overview"><div><span>Total pelanggan</span><strong>{{ count($customers) }} <small>pelanggan</small></strong></div><div><span>Reward tersedia</span><strong>{{ collect($customers)->sum('available_rewards') }} <small>layanan gratis</small></strong></div><div><span>Reward sudah diklaim</span><strong>{{ collect($customers)->sum('reward_redemptions') }} <small>layanan gratis</small></strong></div></div>
@if(session('success'))
    <div class="flash-message">{{ session('success') }}</div>
@endif
<section class="search-panel"><div class="directory-heading"><h2>Direktori pelanggan</h2><span id="customer-result-count" aria-live="polite">{{ count($customers) }} pelanggan</span></div><div class="search-box"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="7"></circle><path d="M20 20l-3.5-3.5"></path></svg><input id="customer-search" type="search" aria-label="Cari nama atau nomor HP pelanggan" placeholder="Cari nama atau nomor HP pelanggan…"></div></section>
@if(count($customers))
    <section class="customers-list">
        @foreach($customers as $customer)
            <article class="customer-card" data-customer-name="{{ $customer['name'] }}" data-customer-phone="{{ $customer['phone'] }}">
                <div class="customer-profile">
                    <div class="customer-avatar" aria-hidden="true">{{ mb_strtoupper(mb_substr($customer['name'], 0, 1)) }}</div><span class="customer-eyebrow">RAAB FAMILY</span>
                    <div class="customer-name">{{ $customer['name'] }}</div>
                    <div class="customer-meta">
                        {{ $customer['phone'] }}<br>
                        {{ $customer['address'] ?: 'Alamat belum diisi' }}<br>
                        Ditambahkan: {{ $customer['created_at'] }}
                    </div>
                    <div class="member-code">ID Member {{ $customer['member_code'] }}</div>
                </div>
                <div class="member-card">
                    <div class="member-header">
                        <div>
                            <h3 class="member-title">Stempel kebaikan Anda</h3>
                            <p class="member-subtitle">1 pelanggan, 1 stempel per tanggal order masuk. Banyak sepatu tetap 1 stempel. Kumpulkan 8 stempel untuk 1 layanan gratis.</p>
                        </div>
                        <span class="reward-badge">{{ $customer['available_rewards'] }} Reward</span>
                    </div>
                    <div class="stamp-grid">
                        @for($stamp = 1; $stamp <= $customer['stamp_target']; $stamp++)
                            <a href="#member-history-{{ $customer['id'] }}" class="stamp-dot {{ $stamp <= $customer['current_stamp_progress'] ? 'filled' : '' }}" aria-label="Stempel {{ $stamp }} {{ $stamp <= $customer['current_stamp_progress'] ? 'terisi' : 'belum terisi' }}, lihat riwayat" title="Lihat riwayat stempel pelanggan">{{ $stamp }}</a>
                        @endfor
                    </div>
                    <div class="stamp-hint">Stempel diberikan setelah ada order selesai. Klik stempel untuk melihat riwayat per tanggal.</div>
                    <div class="member-stats">
                        <div class="member-stat"><div class="member-stat-label">Stempel Aktif</div><div class="member-stat-value">{{ $customer['current_stamp_progress'] }}/{{ $customer['stamp_target'] }}</div></div>
                        <div class="member-stat"><div class="member-stat-label">Total Stempel</div><div class="member-stat-value">{{ $customer['earned_stamps_count'] }}x</div></div>
                        <div class="member-stat"><div class="member-stat-label">Sudah Klaim</div><div class="member-stat-value">{{ $customer['reward_redemptions'] }}x</div></div>
                    </div>
                    @if($customer['available_rewards'] > 0)
                        <form action="{{ route('customers.redeem', $customer['id']) }}" method="post" class="redeem-form">
                            @csrf
                            <button type="submit" class="redeem-btn">Klaim 1 Free Service</button>
                        </form>
                    @else
                        <div class="redeem-note">Kumpulkan {{ $customer['stamp_target'] - $customer['current_stamp_progress'] }} stempel lagi untuk mendapatkan 1 layanan gratis.</div>
                    @endif
                </div>
            </article>
            <section id="member-history-{{ $customer['id'] }}" class="modal-overlay" aria-label="Riwayat Stempel Member"><a href="#" class="modal-backdrop" aria-label="Tutup"></a><div class="modal-card"><div class="modal-header"><h2 class="modal-title">Riwayat Stempel {{ $customer['name'] }}</h2></div><div class="modal-body"><div class="member-code">ID Member {{ $customer['member_code'] }}</div><p class="redeem-note" style="margin:14px 0 16px">Setiap tanggal order masuk di bawah menghasilkan 1 stempel. Order berstatus Siap Diambil atau Diambil pada tanggal yang sama digabung, meskipun jumlah barangnya lebih dari satu.</p>@if(count($customer['stamp_orders']))<div class="history-list">@foreach($customer['stamp_orders'] as $index => $stampOrder)<div class="history-row"><div class="history-code">Stempel {{ $index + 1 }} • {{ $stampOrder['date'] }}</div><div class="history-meta">1 stempel · {{ $stampOrder['order_count'] }} order selesai pada tanggal masuk ini</div>@foreach($stampOrder['orders'] as $visitOrder)<div class="history-meta">{{ $visitOrder['id'] }} · {{ $visitOrder['service'] }}<br>Status: {{ $visitOrder['status'] }}</div>@endforeach</div>@endforeach</div>@else<div class="redeem-note">Belum ada order jasa selesai yang masuk ke kartu member ini.</div>@endif<div class="modal-actions" style="margin-top:18px"><a href="#" class="modal-btn cancel">Tutup</a></div></div></div></section>
        @endforeach
    </section>
@else
    <section class="empty-state"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M9 11a4 4 0 1 1 0-8 4 4 0 0 1 0 8Zm8 1a3 3 0 1 1 0-6 3 3 0 0 1 0 6ZM4 20a5 5 0 0 1 10 0H4Zm9.5 0a4.5 4.5 0 0 1 8.5 0h-8.5Z"/></svg><p class="empty-text">Belum ada pelanggan</p></section>
@endif
<p id="customer-search-empty" class="search-empty" hidden>Tidak ada pelanggan yang cocok. Coba nama atau nomor HP lain.</p>
<section id="add-customer" class="modal-overlay {{ $errors->any() ? 'force-open' : '' }}" role="dialog" aria-modal="true" aria-labelledby="add-customer-title">
    <a href="#" class="modal-backdrop" data-dismiss-customer aria-label="Tutup"></a>
    <div class="modal-card customer-create-card">
        <header class="customer-create-header">
            <div class="customer-create-icon" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"><circle cx="9" cy="7" r="4"/><path d="M2 21v-2a7 7 0 0 1 14 0v2M19 7v6m-3-3h6"/></svg></div>
            <div><span class="customer-eyebrow">WELCOME TO THE RAAB FAMILY</span><h2 id="add-customer-title">Kenalan dulu, yuk.</h2><p>Tambahkan pelanggan dan mulai cerita perawatan terbaiknya.</p></div>
            <a href="#" data-dismiss-customer class="customer-create-close" aria-label="Tutup tambah pelanggan">×</a>
        </header>
        <div class="customer-create-body">
            @if($errors->any())<div class="error-box" role="alert"><strong>Data pelanggan belum bisa disimpan.</strong><ul>@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif
            <form class="modal-form" action="{{ route('customers.store') }}" method="post">
                @csrf
                <div class="customer-member-preview"><span class="preview-member-avatar" id="new-member-avatar" aria-hidden="true">R</span><div><span>RAAB / MEMBER CLUB · PRATINJAU</span><strong id="new-member-name">Pelanggan baru</strong><small>8 stempel untuk 1 layanan gratis</small></div><span class="preview-member-sparkle" aria-hidden="true">✦</span></div>
                <div class="customer-create-fields">
                    <div class="modal-field"><label for="new-customer-name" class="modal-label">Nama pelanggan <span class="required">*</span></label><div class="customer-input-wrap"><svg aria-hidden="true" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><circle cx="12" cy="8" r="4"/><path d="M4 21v-2a8 8 0 0 1 16 0v2"/></svg><input class="modal-input" id="new-customer-name" type="text" name="name" value="{{ old('name') }}" placeholder="Nama lengkap pelanggan" autocomplete="name" maxlength="255" required></div></div>
                    <div class="modal-field"><label for="new-customer-phone" class="modal-label">Nomor HP <span class="required">*</span></label><div class="customer-input-wrap"><svg aria-hidden="true" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><path d="m5 3 4 1 1 5-3 2a15 15 0 0 0 6 6l2-3 5 1 1 4c-1 5-9 1-13-3S0 4 5 3Z"/></svg><input class="modal-input" id="new-customer-phone" type="tel" name="phone" value="{{ old('phone') }}" placeholder="Contoh: 081234567890" autocomplete="tel" maxlength="30" required></div><small class="customer-field-help">Gunakan nomor yang aktif agar pelanggan mudah dihubungi.</small></div>
                    <div class="modal-field customer-address-field"><label for="new-customer-address" class="modal-label">Alamat <span class="customer-optional">Opsional</span></label><textarea class="modal-textarea" id="new-customer-address" name="address" placeholder="Nama jalan, nomor rumah, dan area tempat tinggal" autocomplete="street-address" maxlength="255">{{ old('address') }}</textarea></div>
                </div>
                <div class="customer-create-footer"><span><span class="required">*</span> Wajib diisi</span><div class="modal-actions"><a href="#" data-dismiss-customer class="modal-btn cancel">Batal</a><button type="submit" class="modal-btn save">＋ Simpan pelanggan</button></div></div>
            </form>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
(() => {
    const modal = document.getElementById('add-customer');
    const nameInput = document.getElementById('new-customer-name');
    const updatePreview = () => {
        const name = nameInput.value.trim();
        document.getElementById('new-member-name').textContent = name || 'Pelanggan baru';
        document.getElementById('new-member-avatar').textContent = Array.from(name)[0]?.toLocaleUpperCase('id') || 'R';
    };
    nameInput.addEventListener('input', updatePreview);
    updatePreview();
    let returnFocus = null;
    let previousOverflow = '';
    let wasOpen = false;
    const isOpen = () => location.hash === '#add-customer' || modal.classList.contains('force-open');
    const syncModal = () => {
        const open = isOpen();
        // Explicit visibility also clears a stale CSS :target after replaceState.
        modal.style.display = open ? 'flex' : 'none';
        if (open && !wasOpen) {
            returnFocus = document.activeElement;
            previousOverflow = document.body.style.overflow;
            document.body.style.overflow = 'hidden';
            nameInput.focus();
        } else if (!open && wasOpen) {
            document.body.style.overflow = previousOverflow;
            returnFocus?.focus();
        }
        wasOpen = open;
    };
    const closeModal = () => {
        modal.classList.remove('force-open');
        if (location.hash === '#add-customer') history.replaceState(null, '', location.pathname + location.search);
        syncModal();
    };
    modal.querySelectorAll('[data-dismiss-customer]').forEach(link => link.addEventListener('click', event => {
        event.preventDefault();
        closeModal();
    }));
    window.addEventListener('hashchange', syncModal);
    document.addEventListener('keydown', event => {
        if (!isOpen()) return;
        if (event.key === 'Escape') { event.preventDefault(); closeModal(); }
        if (event.key === 'Tab') {
            const controls = [...modal.querySelectorAll('.modal-card a[href], input:not([type="hidden"]), textarea, button')];
            const first = controls[0], last = controls[controls.length - 1];
            if (event.shiftKey && document.activeElement === first) { event.preventDefault(); last.focus(); }
            else if (!event.shiftKey && document.activeElement === last) { event.preventDefault(); first.focus(); }
        }
    });
    syncModal();
    const search = document.getElementById('customer-search');
    const cards = [...document.querySelectorAll('.customer-card')];
    search.addEventListener('input', () => {
        const query = search.value.trim().toLocaleLowerCase('id');
        let count = 0;
        cards.forEach(card => {
            const matches = `${card.dataset.customerName} ${card.dataset.customerPhone}`.toLocaleLowerCase('id').includes(query);
            card.hidden = !matches;
            if (matches) count++;
        });
        document.getElementById('customer-result-count').textContent = `${count} pelanggan`;
        document.getElementById('customer-search-empty').hidden = count > 0 || !query;
    });
})();
</script>
@endpush
