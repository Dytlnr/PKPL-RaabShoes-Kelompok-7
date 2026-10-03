@extends('layouts.admin')
@section('page-title', 'Laporan & Monitoring')
@section('page-subtitle', 'Lihat perkembangan usaha dan temukan layanan favorit pelanggan.')
@section('active-menu', 'reports')
@push('styles')
<link rel="stylesheet" href="{{ asset('css/catalog-layout.css') }}?v=1">
<link rel="stylesheet" href="{{ asset('css/reports.css') }}?v=1">
@endpush
@section('content')
@php
    $dateFrom = $dateFrom ?? '';
    $dateTo = $dateTo ?? '';
    $totalOrders = $totalOrders ?? 0;
    $totalRevenue = $totalRevenue ?? 0;
    $averageOrder = $averageOrder ?? 0;
    $topServices = $topServices ?? [];
    $dailyRevenue = $dailyRevenue ?? [];
    $peak = max(collect($dailyRevenue)->max() ?? 0, 1);
    $servicePeak = max(collect($topServices)->max() ?? 0, 1);
@endphp
<header class="listing-hero"><div><span class="listing-eyebrow">RAAB SHOES • BUSINESS INSIGHTS</span><h2>Kenali angkanya.<br>Rencanakan langkahnya.</h2><p>Ringkasan transaksi untuk membantu Anda memantau perkembangan usaha dari hari ke hari.</p></div><div class="report-hero-art" aria-hidden="true"><span>EVERY ORDER TELLS A STORY</span><div class="report-art-bars"><i></i><i></i><i></i><i></i><i></i></div><strong>Usaha terpantau, langkah terarah.</strong></div></header>
<section class="filter-card" aria-labelledby="filter-title">
    <div class="filter-heading"><h2 id="filter-title">Periode laporan</h2><span>Sesuaikan tanggal untuk melihat ringkasan</span></div>
    <form method="get" action="{{ route('reports.index') }}" class="filter-form">
        <div class="field"><label for="report-from">Dari tanggal</label><input id="report-from" type="date" name="date_from" value="{{ $dateFrom }}"></div>
        <div class="field"><label for="report-to">Sampai tanggal</label><input id="report-to" type="date" name="date_to" value="{{ $dateTo }}"></div>
        <button class="apply-btn" type="submit">Tampilkan laporan</button>
        <button class="export-btn" formaction="{{ route('reports.export') }}" formtarget="_blank" type="submit"><svg aria-hidden="true" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M12 3v12m-4-4 4 4 4-4M4 16v5h16v-5"/></svg>Export PDF</button>
    </form>
    <div class="report-shortcuts"><span>Pilih cepat:</span><a href="{{ route('reports.index', ['date_from' => now()->toDateString(), 'date_to' => now()->toDateString()]) }}">Hari ini</a><a href="{{ route('reports.index', ['date_from' => now()->subDays(6)->toDateString(), 'date_to' => now()->toDateString()]) }}">7 hari terakhir</a><a href="{{ route('reports.index', ['date_from' => now()->startOfMonth()->toDateString(), 'date_to' => now()->toDateString()]) }}">Bulan ini</a><a href="{{ route('reports.index') }}">Semua waktu</a></div>
</section>
<div class="listing-heading"><h2>Ringkasan kinerja</h2><span>{{ $dateFrom ?: 'Awal pencatatan' }} — {{ $dateTo ?: 'Tanggal terakhir' }}</span></div>
<section class="summary-grid">
    <article class="summary-card"><div class="summary-top"><span class="summary-label">Total order</span><span class="metric-icon" aria-hidden="true">▤</span></div><div class="summary-value">{{ number_format($totalOrders, 0, ',', '.') }}</div><p>Pesanan dalam periode terpilih</p></article>
    <article class="summary-card revenue-card"><div class="summary-top"><span class="summary-label">Total pendapatan</span><span class="metric-icon" aria-hidden="true">Rp</span></div><div class="summary-value">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</div><p>Akumulasi nilai layanan pesanan</p></article>
    <article class="summary-card"><div class="summary-top"><span class="summary-label">Rata-rata per order</span><span class="metric-icon purple" aria-hidden="true">≈</span></div><div class="summary-value">Rp {{ number_format($averageOrder, 0, ',', '.') }}</div><p>Total pendapatan dibagi jumlah order</p></article>
</section>
<section class="panel-grid">
    <article class="panel"><div class="panel-heading"><span class="panel-symbol" aria-hidden="true">↗</span><div><h2>Pendapatan harian</h2><p>Bandingkan nilai transaksi setiap hari</p></div></div>
        @if(count($dailyRevenue))
            <div class="daily-highlight"><span>Nilai harian tertinggi</span><strong>Rp {{ number_format(collect($dailyRevenue)->max(), 0, ',', '.') }}</strong></div>
            <div class="revenue-chart" aria-label="Grafik pendapatan per hari">
                @foreach($dailyRevenue as $date => $amount)
                    <div class="revenue-row"><div class="revenue-label"><span>{{ $date }}</span><strong>Rp {{ number_format($amount, 0, ',', '.') }}</strong></div><div class="revenue-track" aria-hidden="true"><span style="width: {{ max(0, $amount) / $peak * 100 }}%"></span></div></div>
                @endforeach
            </div>
        @else
            <div class="report-empty"><span aria-hidden="true">↗</span><strong>Belum ada pendapatan</strong><p>Coba pilih periode lain untuk melihat data transaksi.</p></div>
        @endif
    </article>
    <article class="panel"><div class="panel-heading"><span class="panel-symbol lavender" aria-hidden="true">✦</span><div><h2>Layanan terlaris</h2><p>Peringkat berdasarkan jumlah pesanan</p></div></div>
        @if(count($topServices))
            <div class="services-ranking">
                @foreach($topServices as $service => $count)
                    <div class="rank-row"><span class="rank-number">{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}</span><div class="rank-detail"><strong>{{ $service }}</strong><div class="rank-track" aria-hidden="true"><span style="width: {{ $count / $servicePeak * 100 }}%"></span></div></div><div class="rank-count">{{ $count }}<small>order</small></div></div>
                @endforeach
            </div>
        @else
            <div class="report-empty"><span aria-hidden="true">✦</span><strong>Belum ada layanan tercatat</strong><p>Layanan akan tampil setelah ada pesanan pada periode ini.</p></div>
        @endif
    </article>
</section>
@endsection
@push('scripts')
<script>
(() => {
    const from = document.getElementById('report-from');
    const to = document.getElementById('report-to');
    const validateRange = () => {
        to.setCustomValidity(from.value && to.value && to.value < from.value ? 'Tanggal akhir harus sama atau setelah tanggal awal.' : '');
    };
    from.addEventListener('input', validateRange);
    to.addEventListener('input', validateRange);
    validateRange();
})();
</script>
@endpush
