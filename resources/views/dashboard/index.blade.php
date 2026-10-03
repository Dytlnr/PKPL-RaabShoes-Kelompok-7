@extends('layouts.admin')

@section('page-title', 'Dashboard')
@section('page-subtitle', 'Ringkasan bisnis Raab Shoes, dalam satu tempat.')
@section('active-menu', 'dashboard')

@push('styles')
<style>
.stats-grid{display:grid;grid-template-columns:repeat(3,minmax(0,1fr));gap:22px 24px}.stat-card,.panel{background:rgba(255,255,255,.98);box-shadow:var(--shadow)}.stat-card{min-height:194px;padding:22px;border-radius:28px;display:flex;flex-direction:column;justify-content:space-between}.card-note{text-align:right;font-size:.92rem}.value{font-size:2.4rem;font-weight:600;letter-spacing:-.04em}.label{font-size:.96rem}.panels{display:grid;grid-template-columns:1.15fr .95fr;gap:22px 36px;margin-top:84px}.panel{min-height:462px;padding:30px;border-radius:32px}.panel-title{display:flex;align-items:center;gap:14px;margin:0 0 26px;font-size:1.05rem;font-weight:700}.panel-title svg{width:26px;height:26px;color:var(--orange)}.chart-card{margin:30px auto 0;width:min(100%,580px);padding:22px;border-radius:28px;background:#fff;box-shadow:0 12px 24px rgba(48,55,76,.12);border:1px solid rgba(232,236,245,.9)}.chart-header{display:flex;justify-content:space-between;align-items:flex-start;gap:18px;margin-bottom:18px;color:#1f2440}.chart-period{font-size:1.3rem;font-weight:700;letter-spacing:-.02em}.chart-sub{font-size:.92rem;color:#9097b0;font-weight:500}.chart-peak{flex:0 0 auto;margin-top:4px;padding:8px 12px;border-radius:14px;background:#f6f8fc;color:#737d9a;font-size:.86rem;font-weight:700}.chart-area{position:relative;height:300px;border-radius:24px;background:#fbfcff;overflow:hidden;padding:24px 86px 56px 24px}.chart-plot-bg{position:absolute;inset:24px 86px 56px 24px;background:repeating-linear-gradient(180deg,rgba(152,160,188,.14) 0 2px,transparent 2px 58px);border-bottom:2px solid rgba(152,160,188,.16);pointer-events:none}.chart-grid-labels{position:absolute;top:17px;right:24px;bottom:52px;width:58px;display:flex;flex-direction:column;justify-content:space-between;pointer-events:none}.chart-grid-label{font-size:.76rem;color:#9aa3b8;text-align:right;white-space:nowrap}.chart-axis{position:absolute;left:24px;right:86px;bottom:18px;display:grid;grid-template-columns:repeat(7,1fr);gap:8px;text-align:center;font-size:.78rem;font-weight:700;color:#8b92ab}.chart-svg{position:absolute;inset:24px 86px 56px 24px;width:calc(100% - 110px);height:calc(100% - 80px);overflow:visible}.chart-line.current{stroke:#4569dc;stroke-width:4;fill:none;stroke-linecap:round;stroke-linejoin:round}.chart-line.previous{stroke:#ff5b87;stroke-width:3;fill:none;stroke-linecap:round;stroke-linejoin:round;stroke-dasharray:9 9}.chart-area-fill{fill:url(#lineArea);opacity:.16}.chart-point{fill:#4569dc;stroke:#fff;stroke-width:4}.chart-tip{position:absolute;top:24px;left:50%;transform:translateX(-50%);background:#1e2240;color:#fff;padding:7px 12px;border-radius:13px;font-size:.82rem;font-weight:700;box-shadow:0 12px 24px rgba(30,34,64,.18);white-space:nowrap}.chart-tip::after{content:'';position:absolute;left:50%;bottom:-7px;transform:translateX(-50%);border:7px solid transparent;border-top-color:#1e2240}.chart-empty{position:absolute;left:24px;right:86px;top:50%;transform:translateY(-50%);text-align:center;color:#8f98b2;font-size:.9rem;font-weight:600;pointer-events:none}.chart-legend{display:flex;justify-content:center;gap:22px;margin-top:18px;color:#59607c;font-size:.92rem}.legend-item{display:flex;align-items:center;gap:8px}.legend-dot{width:11px;height:11px;border-radius:50%;display:inline-block}.services-list{display:flex;flex-direction:column;gap:16px;margin-top:12px}.service-item{padding:18px 20px;border-radius:20px;background:linear-gradient(180deg,#fff9ef 0%,#fff4de 100%);border:1px solid #f8e3bc;display:flex;justify-content:space-between;align-items:center;gap:18px}.service-name{font-size:1rem;font-weight:600}.service-meta{color:var(--muted);font-size:.9rem}.service-count{min-width:68px;text-align:center;padding:10px 12px;border-radius:14px;background:#fff;color:var(--orange);font-weight:700;box-shadow:0 8px 22px rgba(87,66,36,.1)}@media (max-width:1280px){.stats-grid,.panels{grid-template-columns:repeat(2,minmax(0,1fr))}.panels .panel:last-child{grid-column:span 2}}@media (max-width:980px){.stats-grid,.panels{grid-template-columns:1fr}.panels .panel:last-child{grid-column:auto}.chart-card{width:100%}}@media (max-width:640px){.panel,.stat-card{padding-left:20px;padding-right:20px}.chart-card{padding:16px}.chart-header{display:block}.chart-peak{display:inline-flex;margin-top:12px}.chart-area{height:260px;padding-right:72px}.chart-plot-bg,.chart-svg{right:72px;width:calc(100% - 96px)}.chart-grid-labels{right:16px;width:50px}.chart-axis{right:72px;font-size:.72rem}}
</style>
<link rel="stylesheet" href="{{ asset('css/dashboard.css') }}?v=1">
@endpush

@section('content')
@php
    $todayRevenue = $todayRevenue ?? 0;
    $chartLabels = $chartLabels ?? ['Jan','Feb','Mar','Apr','Mei','Jun','Jul'];
    $chartThisYear = $chartThisYear ?? [0,0,0,0,0,0,0];
    $chartPrevYear = $chartPrevYear ?? [0,0,0,0,0,0,0];
    $maxChartValue = max(array_merge($chartThisYear, $chartPrevYear, [1]));
    $chartMax = (int) ceil($maxChartValue * 1.2 / 10000) * 10000 ?: 10000;
    $chartGridLabels = [$chartMax, (int) round($chartMax * 0.75), (int) round($chartMax * 0.5), (int) round($chartMax * 0.25), 0];
    $peakValue = collect($chartThisYear)->max() ?: 0;
    $lastChartLabel = $chartLabels[array_key_last($chartLabels)];
    $formatChartValue = function ($value) { if ($value >= 1000000) { return 'Rp ' . number_format($value / 1000000, 1, ',', '.') . ' jt'; } if ($value >= 1000) { return 'Rp ' . number_format($value / 1000, 0, ',', '.') . ' rb'; } return 'Rp ' . number_format($value, 0, ',', '.'); };
    $topServices = $topServices ?? [];
@endphp

<div class="dashboard-intro">
    <div class="intro-copy">
        <span class="eyebrow">RAAB SHOES • BUSINESS OVERVIEW</span>
        <h2>Sepatu bersih.<br>Bisnis makin rapi.</h2>
        <p>Halo, {{ session('social_auth.name', 'Admin') }}! Yuk, pantau pesanan dan berikan pelayanan terbaik hari ini.</p>
        <a class="dashboard-action" href="{{ route('orders.create') }}"><span aria-hidden="true">＋</span> Tambah order baru <span aria-hidden="true">↗</span></a>
    </div>
    <div class="intro-summary">
        <span class="today-date">{{ now()->locale('id')->translatedFormat('l, d F Y') }}</span>
        <div class="pickup-icon" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M5 8h14l2 12H3L5 8Z"/><path d="M8 9V6a4 4 0 0 1 8 0v3"/><path d="m9 14 2 2 4-4"/></svg></div>
        <strong>{{ $readyPickup ?? 0 }} order siap diambil</strong>
        <span>Sudah bersih, siap kembali ke pelanggan.</span>
        <a href="{{ route('orders.index') }}">Kelola pesanan <span aria-hidden="true">→</span></a>
    </div>
</div>
<div class="section-heading"><div><span class="eyebrow">SEKILAS USAHA ANDA</span><h2>Ringkasan operasional</h2></div><span class="live-label"><i></i> Data transaksi terkini</span></div>
@php
    $stats = [
        ['Total order hari ini', $todayOrders ?? 0, 'Pesanan masuk hari ini', 'orange', 'M8 3H5v18h14V3h-3 M9 2h6v4H9z M8 11h8 M8 15h5'],
        ['Pendapatan hari ini', 'Rp ' . number_format($todayRevenue, 0, ',', '.'), 'Nilai layanan order hari ini', 'green', 'M3 6h18v14H3z M3 10h18 M15 15h3 M6 3h12'],
        ['Order dalam proses', $inProgress ?? 0, 'Sedang ditangani tim', 'blue', 'M20 7a9 9 0 1 0 1 8 M20 3v5h-5 M12 7v5l3 2'],
        ['Order tuntas', $completed ?? 0, 'Siap diambil & sudah diambil', 'purple', 'm8 12 3 3 5-6 M21 12a9 9 0 1 1-9-9 9 9 0 0 1 9 9'],
        ['Siap diambil', $readyPickup ?? 0, 'Menunggu pengambilan', 'orange', 'M5 8h14l2 12H3L5 8Z M8 9V6a4 4 0 0 1 8 0v3'],
        ['Total pelanggan', $totalCustomers ?? 0, 'Pelanggan terdaftar', 'blue', 'M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2 M13 7a4 4 0 1 1-8 0 4 4 0 0 1 8 0 M17 4a4 4 0 0 1 0 8 M22 21v-2a4 4 0 0 0-3-4'],
    ];
@endphp
<div class="stats-grid">
    @foreach($stats as [$label, $value, $note, $color, $icon])
        <article class="stat-card accent-{{ $color }}">
            <div class="stat-top"><span class="stat-icon" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"><path d="{{ $icon }}"/></svg></span><span class="stat-period">{{ $loop->index < 2 ? 'Hari ini' : 'Keseluruhan' }}</span></div>
            <div class="value">{{ $value }}</div><div class="label">{{ $label }}</div><div class="stat-note">{{ $note }}</div>
        </article>
    @endforeach
</div>

<div class="panels">
    <section class="panel">
        <h2 class="panel-title"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round"><path d="M3 17l5-6 4 4 7-9"/><path d="M17 6h4v4"/></svg><span>Pendapatan Bulanan</span></h2>
        <div class="chart-card">
            <div class="chart-header">
                <div>
                    <div class="chart-period">{{ $chartLabels[0] }} - {{ $lastChartLabel }} {{ now()->format('Y') }}</div>
                    <div class="chart-sub">7 bulan terakhir dibanding periode tahun sebelumnya</div>
                </div>
                <div class="chart-peak">Puncak: {{ $formatChartValue($peakValue) }}</div>
            </div>
            <div class="revenue-summary">
                <div><span>Total periode ini</span><strong>Rp {{ number_format(array_sum($chartThisYear), 0, ',', '.') }}</strong></div>
                <div><span>Rata-rata / bulan</span><strong>{{ $formatChartValue(array_sum($chartThisYear) / max(count($chartLabels), 1)) }}</strong></div>
            </div>
            <div class="revenue-scroll" tabindex="0" aria-label="Grafik pendapatan, geser untuk melihat seluruh bulan pada layar kecil">
                <div class="revenue-chart">
                    <div class="revenue-grid" aria-hidden="true">
                        @foreach($chartGridLabels as $gridValue)
                            <div><span>{{ $formatChartValue($gridValue) }}</span></div>
                        @endforeach
                    </div>
                    <div class="revenue-columns" style="--months: {{ count($chartLabels) }}">
                        @foreach($chartLabels as $index => $label)
                            @php
                                $current = $chartThisYear[$index] ?? 0;
                                $previous = $chartPrevYear[$index] ?? 0;
                            @endphp
                            <div class="revenue-month {{ $current > 0 && $current == $peakValue ? 'is-peak' : '' }}" tabindex="0" aria-label="{{ $label }}: periode ini Rp {{ number_format($current, 0, ',', '.') }}, setahun sebelumnya Rp {{ number_format($previous, 0, ',', '.') }}">
                                <div class="revenue-tooltip" aria-hidden="true"><strong>{{ $label }}</strong><span>Periode ini <b>Rp {{ number_format($current, 0, ',', '.') }}</b></span><span>Tahun lalu <b>Rp {{ number_format($previous, 0, ',', '.') }}</b></span></div>
                                <div class="revenue-bars" aria-hidden="true">
                                    <span class="revenue-bar current" style="height: {{ $current / $chartMax * 100 }}%">@if($current > 0)<span class="revenue-value">{{ $formatChartValue($current) }}</span>@endif</span>
                                    <span class="revenue-bar previous" style="height: {{ $previous / $chartMax * 100 }}%"></span>
                                </div>
                                <span class="revenue-month-label">{{ $label }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="chart-legend">
                <span class="legend-item"><span class="legend-dot" style="background:#ed842b"></span>Periode ini</span>
                <span class="legend-item"><span class="legend-dot" style="background:#9cabe0"></span>Setahun sebelumnya</span>
            </div>
            <p class="revenue-help">{{ array_sum($chartThisYear) + array_sum($chartPrevYear) > 0 ? 'Arahkan kursor atau ketuk bulan untuk melihat detail pendapatan.' : 'Belum ada pendapatan pada kedua periode ini.' }}</p>
        </div>
    </section>
    <section class="panel">
        <h2 class="panel-title"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round"><path d="M14 4l6 6"/><path d="M17 7l-3 3"/><path d="M4 20l6-6"/><path d="M7 17l3 3"/><path d="M14 14l6 6"/><path d="M17 17l3-3"/><path d="M4 4l6 6"/><path d="M7 7L4 10"/></svg><span>Layanan Terlaris</span></h2>
        <p class="services-description">Layanan favorit berdasarkan seluruh pesanan.</p>
        <div class="services-list">
            @forelse($topServices as $serviceName => $serviceCount)
                <article class="service-item"><span class="service-rank">{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}</span><div class="service-detail"><div class="service-name">{{ $serviceName }}</div><div class="service-track" aria-hidden="true"><span style="width: {{ $serviceCount / max(collect($topServices)->max(), 1) * 100 }}%"></span></div></div><div class="service-count">{{ $serviceCount }}<small>order</small></div></article>
            @empty
                <article class="service-item"><div><div class="service-name">Belum ada data layanan</div><div class="service-meta">Tambahkan order untuk melihat statistik layanan.</div></div><div class="service-count">0x</div></article>
            @endforelse
        </div>
        <a class="services-link" href="{{ route('services.index') }}">Lihat semua layanan <span aria-hidden="true">→</span></a>
    </section>
</div>

@endsection
