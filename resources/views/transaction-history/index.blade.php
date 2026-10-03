@extends('layouts.admin')

@section('page-title', 'Riwayat Transaksi')
@section('page-subtitle', 'Lihat dan telusuri riwayat transaksi Anda dengan mudah')
@section('active-menu', 'transaction-history')

@push('styles')
<style>
.filter-card,.empty-card,.history-list{background:rgba(255,255,255,.98);box-shadow:var(--shadow)}.filter-card{border-radius:34px;padding:26px 30px}.filter-form{display:grid;gap:14px}.filter-row{display:grid;grid-template-columns:1.2fr 1.1fr 1fr 1fr auto;gap:12px}.control{height:62px;border:2px solid var(--orange);border-radius:18px;background:#fff;display:flex;align-items:center;gap:12px;padding:0 16px;color:#2a2a2d;font-size:.96rem;font-weight:500}.control svg{width:28px;height:28px;color:#9d9da3;flex-shrink:0}.control input{width:100%;border:0;outline:none;background:transparent;color:#2a2a2d;font:inherit}.control input::placeholder{color:#ababaf}.filter-dropdown{position:relative}.filter-dropdown[open]{z-index:12}.filter-trigger{list-style:none;width:100%;height:62px;border:2px solid var(--orange);border-radius:18px;background:#fff;display:flex;align-items:center;gap:12px;padding:0 16px;color:#2a2a2d;font-size:.96rem;font-weight:500;cursor:pointer}.filter-trigger svg{width:24px;height:24px;color:#9d9da3;flex-shrink:0}.filter-trigger::-webkit-details-marker{display:none}.filter-menu{position:absolute;top:calc(100% + 10px);left:0;right:0;padding:10px;background:#fff;border:2px solid rgba(245,124,0,.18);border-radius:18px;box-shadow:var(--shadow);display:grid;gap:6px}.filter-option{min-height:42px;padding:0 12px;border-radius:12px;display:flex;align-items:center;font-size:.92rem;font-weight:500;color:#3a3a40}.filter-option.active,.filter-option:hover{background:#fff3e2;color:var(--orange)}.filter-actions{display:flex;justify-content:flex-end;gap:10px}.filter-btn{height:48px;padding:0 18px;border-radius:14px;border:2px solid transparent;display:inline-flex;align-items:center;justify-content:center;font-size:.92rem;font-weight:600}.filter-btn.submit{background:linear-gradient(180deg,#ff8c0d 0%,#f57c00 100%);color:#fff}.filter-btn.reset{border-color:var(--orange);background:#fff;color:#4a4a4f}.history-list{margin-top:28px;padding:22px;border-radius:34px;display:grid;gap:16px}.history-card{padding:22px;border:2px solid rgba(245,124,0,.2);border-radius:24px;background:#fff;display:grid;grid-template-columns:minmax(0,1fr) minmax(520px,.9fr);gap:18px;align-items:start}.history-code{font-size:1rem;font-weight:700}.history-meta{margin-top:8px;color:#6d6d75;font-size:.92rem;line-height:1.6}.history-detail{display:grid;gap:12px;width:100%;font-size:.92rem;color:#55565c;justify-self:end}.history-detail-row{display:grid;grid-template-columns:220px minmax(0,1fr);align-items:flex-start;gap:12px;width:100%}.history-detail-label{font-weight:700;color:#202127}.history-detail-value{min-width:0;overflow-wrap:anywhere}.status-badge{min-width:112px;height:40px;padding:0 16px;border-radius:999px;background:#fff3e2;color:var(--orange);display:inline-flex;align-items:center;justify-content:center;font-size:.9rem;font-weight:700}.empty-card{margin-top:28px;min-height:328px;border-radius:34px;display:flex;flex-direction:column;align-items:center;justify-content:center;text-align:center}.empty-card svg{width:100px;height:100px;color:#adadb3}.empty-text{margin-top:16px;color:#a2a2a8;font-size:1rem;font-weight:500}@media(max-width:1180px){.filter-row{grid-template-columns:1fr 1fr}.history-card{grid-template-columns:minmax(0,1fr) minmax(460px,.95fr)}.history-detail-row{grid-template-columns:200px minmax(0,1fr)}}@media(max-width:860px){.history-card{grid-template-columns:1fr}.history-detail{justify-self:stretch}}@media(max-width:700px){.filter-card{padding:20px;border-radius:24px}.filter-row{grid-template-columns:1fr}.control,.filter-trigger{height:56px}.filter-actions{flex-direction:column}.filter-btn{width:100%}.history-list{padding:16px;border-radius:24px}.history-card{padding:18px}.history-detail-row{grid-template-columns:1fr;gap:4px}}
</style>
<link rel="stylesheet" href="{{ asset('css/catalog-layout.css') }}?v=1">
<link rel="stylesheet" href="{{ asset('css/transaction-history.css') }}?v=1">
@endpush

@section('content')
@php($orders = $orders ?? [])
@php($activeStatus = $activeStatus ?? 'Semua Status')
@php($statusOptions = $statusOptions ?? ['Semua Status'])
@php($search = $search ?? '')
@php($dateFrom = $dateFrom ?? '')
@php($dateTo = $dateTo ?? '')
<header class="listing-hero"><div><span class="listing-eyebrow">RAAB SHOES • TRANSACTION JOURNAL</span><h2>Setiap transaksi,<br>punya ceritanya.</h2><p>Telusuri pesanan, cek pembayaran, dan temukan kembali detail perawatan pelanggan.</p></div><div class="history-hero-ticket"><span>RAAB / TRANSACTION JOURNAL</span><svg aria-hidden="true" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.3"><path d="M6 3h12v18l-3-2-3 2-3-2-3 2V3Z M9 7h6m-6 4h6m-6 4h3"/></svg><strong>Rapi tercatat.<br>Mudah ditelusuri.</strong><div class="ticket-dashes" aria-hidden="true"></div></div></header>
<section class="history-summary" aria-label="Ringkasan hasil pencarian"><div><span>Transaksi ditemukan</span><strong>{{ count($orders) }} <small>order</small></strong></div><div><span>Sudah diambil</span><strong>{{ collect($orders)->where('status', 'Diambil')->count() }} <small>order</small></strong></div><div><span>Siap diambil</span><strong>{{ collect($orders)->where('status', 'Siap Diambil')->count() }} <small>order</small></strong></div></section>
<section class="filter-card"><div class="history-filter-heading"><h2>Temukan transaksi</h2><span>Cari berdasarkan pelanggan, status, atau tanggal</span></div>
    <form method="get" action="{{ route('transaction-history.index') }}" class="filter-form">
        <div class="filter-row">
            <div class="control"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="7"></circle><path d="M20 20l-3.5-3.5"></path></svg><input type="text" name="search" value="{{ $search }}" aria-label="Cari ID order atau nama pelanggan" placeholder="Cari ID order atau nama…"></div>
            <details class="filter-dropdown">
                <summary class="filter-trigger"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M3 5h18l-7 8v5l-4 2v-7L3 5Z"></path></svg><span>{{ $activeStatus }}</span></summary>
                <div class="filter-menu">
                    @foreach($statusOptions as $status)
                        <a href="{{ route('transaction-history.index', array_filter(['search' => $search, 'status' => $status, 'date_from' => $dateFrom, 'date_to' => $dateTo])) }}" class="filter-option {{ $activeStatus === $status ? 'active' : '' }}">{{ $status }}</a>
                    @endforeach
                </div>
            </details>
            <label class="history-date"><span>Dari tanggal</span><span class="control"><input type="date" name="date_from" value="{{ $dateFrom }}"></span></label>
            <label class="history-date"><span>Sampai tanggal</span><span class="control"><input type="date" name="date_to" value="{{ $dateTo }}"></span></label>
            <div class="filter-actions">
                <button type="submit" class="filter-btn submit">Terapkan</button>
                <a href="{{ route('transaction-history.index') }}" class="filter-btn reset">Reset</a>
            </div>
        </div>
        <input type="hidden" name="status" value="{{ $activeStatus }}">
    </form>
</section>
<div class="listing-heading"><h2>Jejak transaksi</h2><span>Menampilkan {{ count($orders) }} transaksi sesuai filter</span></div>
@if(count($orders))
    <section class="history-list">
        @foreach($orders as $order)
            <article class="history-card" data-status="{{ $order['status'] }}">
                <div class="history-identity">
                    <div class="history-avatar" aria-hidden="true">{{ mb_strtoupper(mb_substr($order['customer_name'], 0, 1)) }}</div><span class="history-order-caption">DETAIL TRANSAKSI</span>
                    <div class="history-code">{{ $order['id'] }}</div>
                    <div class="history-meta">
                        <strong class="history-customer">{{ $order['customer_name'] }}</strong><br>
                        {{ $order['phone'] }}<br>
                        {{ $order['created_at'] }}
                    </div>
                </div>
                <div class="history-detail">
                    <div class="history-detail-row"><span class="history-detail-label">Barang:</span><span class="history-detail-value">{{ $order['service_choice'] }}</span></div>
                    <div class="history-detail-row"><span class="history-detail-label">Layanan:</span><span class="history-detail-value">{{ $order['service'] }}</span></div>
                    <div class="history-detail-row"><span class="history-detail-label">Pembayaran:</span><span class="history-detail-value"><span class="history-payment">{{ $order['payment_method'] ?: '-' }}</span></span></div>
                    <div class="history-card-footer"><span class="status-badge"><i aria-hidden="true"></i>{{ $order['status'] }}</span><a class="history-order-link" href="{{ route('orders.index', ['search' => $order['id']]) }}">Lihat pesanan <span aria-hidden="true">↗</span></a></div>
                </div>
            </article>
        @endforeach
    </section>
@else
    <section class="empty-card"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="8.5"></circle><path d="M12 7v5l3 2"></path><path d="M8 3l-2 2"></path></svg><p class="empty-text">Belum ada transaksi yang cocok</p><p class="history-empty-help">Coba kata kunci lain atau perluas rentang tanggal.</p><a href="{{ route('transaction-history.index') }}" class="filter-btn reset">Tampilkan semua transaksi</a></section>
@endif
@endsection

@push('scripts')
<script>
(() => {
    const from = document.querySelector('[name="date_from"]');
    const to = document.querySelector('[name="date_to"]');
    const validate = () => to.setCustomValidity(from.value && to.value && to.value < from.value ? 'Tanggal akhir harus sama atau setelah tanggal awal.' : '');
    from.addEventListener('input', validate);
    to.addEventListener('input', validate);
    validate();
})();
</script>
@endpush
