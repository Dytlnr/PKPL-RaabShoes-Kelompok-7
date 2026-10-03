@extends('layouts.admin')

@section('page-title', 'Order & Transaksi')
@section('page-subtitle', 'Catat pesanan baru, siapkan perawatan terbaik.')
@section('active-menu', 'orders')

@push('styles')
<style>
.back-link{display:inline-flex;align-items:center;gap:10px;margin:10px 0 18px 12px;font-size:.98rem;font-weight:500}.back-link svg{width:18px;height:18px}.flash-message,.error-box{margin:0 0 18px;padding:14px 18px;border-radius:18px;font-size:.94rem}.flash-message{background:#fff4e7;border:1px solid rgba(245,124,0,.28);color:#8a4d10}.flash-message strong{display:block;margin-bottom:4px}.error-box{background:#fff0ef;border:1px solid rgba(220,65,53,.22);color:#b42318}.error-box ul{margin:8px 0 0;padding-left:18px}.error-box li+li{margin-top:4px}.receipt-card{margin:0 0 20px;padding:22px 24px;border-radius:26px;background:linear-gradient(180deg,#fffaf2 0%,#fff4e2 100%);border:1px solid rgba(245,124,0,.18);box-shadow:var(--shadow)}.receipt-title{margin:0 0 14px;font-size:1.1rem;font-weight:700}.receipt-grid{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:10px 24px}.receipt-item{display:flex;flex-direction:column;gap:4px;padding:10px 0;border-bottom:1px dashed rgba(245,124,0,.2)}.receipt-label{font-size:.86rem;color:#8f7f68}.receipt-value{font-size:.95rem;font-weight:600;color:#2b2b30;word-break:break-word}.receipt-actions{display:flex;justify-content:flex-end;margin-top:18px}.wa-btn{min-width:240px;height:54px;padding:0 24px;border-radius:18px;display:inline-flex;align-items:center;justify-content:center;gap:10px;background:#1fa855;color:#fff;font-size:.96rem;font-weight:600;box-shadow:0 12px 22px rgba(31,168,85,.22)}.wa-btn svg{width:22px;height:22px}.form-panel{background:rgba(255,255,255,.98);border-radius:34px;box-shadow:var(--shadow);padding:24px 22px}.form-title{margin:0 0 10px;font-size:1.42rem;font-weight:700}.section+.section{margin-top:22px}.section-title{margin:0 0 16px;padding-bottom:8px;border-bottom:3px solid var(--orange);font-size:1rem;font-weight:700}.fields-grid{display:grid;grid-template-columns:1fr 1fr;gap:18px 28px}.field{display:flex;flex-direction:column;gap:8px}.field.full{grid-column:1/-1}.field label{font-size:.95rem;font-weight:500}.required{color:#e7461b}.input,.select,.textarea,.upload-box{width:100%;border:2px solid var(--orange);border-radius:16px;background:#fff;outline:none}.input,.select{height:52px;padding:0 14px}.textarea{min-height:102px;padding:14px;resize:vertical}.upload-box{position:relative;min-height:146px;display:flex;flex-direction:column;align-items:center;justify-content:center;padding:18px;color:#8e8e95;text-align:center;border-style:dashed}.upload-placeholder{display:flex;flex-direction:column;align-items:center;justify-content:center;gap:8px;width:100%;text-align:center}.upload-placeholder span{display:block}.upload-box svg{width:34px;height:34px;color:#b1b1b6}.upload-box strong{display:block;color:#3d3d42;font-weight:500}.upload-box.has-file{align-items:flex-start;text-align:left;padding:18px 20px 20px}.upload-input{position:absolute;inset:0;opacity:0;pointer-events:none}.upload-preview{display:none;align-items:center;gap:16px;width:100%}.upload-box.has-file .upload-placeholder{display:none}.upload-box.has-file .upload-preview{display:flex}.preview-thumb{width:82px;height:82px;border-radius:14px;object-fit:cover;border:1px solid rgba(245,124,0,.22);background:#f5f5f5}.preview-meta{display:flex;flex-direction:column;gap:6px}.preview-name{font-size:.95rem;font-weight:600;color:#2d2d32;word-break:break-word}.preview-help{font-size:.88rem;color:#8e8e95}.upload-panel{display:grid;gap:16px}.upload-actions{display:flex;flex-wrap:wrap;gap:12px}.upload-btn{min-width:190px;height:50px;padding:0 18px;border-radius:16px;border:2px solid rgba(245,124,0,.22);background:#fff8ef;color:#3d3d42;display:inline-flex;align-items:center;justify-content:center;gap:10px;font-size:.94rem;font-weight:600}.upload-btn svg{width:20px;height:20px}.upload-btn.primary{background:linear-gradient(180deg,#ff8c0d 0%,#f57c00 100%);border-color:transparent;color:#fff}.camera-panel{display:none;gap:14px;padding:18px;border:2px solid rgba(245,124,0,.18);border-radius:20px;background:linear-gradient(180deg,#fffaf2 0%,#fff 100%)}.camera-panel.is-open{display:grid}.camera-frame{position:relative;overflow:hidden;border-radius:18px;background:#171717;aspect-ratio:4/3}.camera-video{width:100%;height:100%;object-fit:cover;display:block}.camera-empty{position:absolute;inset:0;display:flex;align-items:center;justify-content:center;padding:20px;color:#fff;font-size:.92rem;line-height:1.5;background:linear-gradient(180deg,rgba(34,34,34,.92) 0%,rgba(16,16,16,.92) 100%)}.camera-empty[hidden]{display:none!important}.camera-toolbar{display:flex;flex-wrap:wrap;gap:12px}.camera-note{font-size:.88rem;color:#7d7d84}.upload-status{min-height:20px;font-size:.88rem;color:#7d7d84}.upload-status.error{color:#b42318}.qris-panel{display:none;gap:18px;padding:22px;border:2px solid rgba(245,124,0,.18);border-radius:22px;background:linear-gradient(180deg,#fffaf2 0%,#fff 100%)}.qris-panel.is-open{display:grid}.qris-summary{display:grid;gap:8px}.qris-total{font-size:1.38rem;font-weight:700;color:#202127}.qris-note{font-size:.9rem;color:#7d7d84;line-height:1.6}.qris-card{display:grid;justify-items:center;gap:12px;padding:20px;border-radius:20px;background:#fff;border:1px solid rgba(245,124,0,.16)}.qris-image{width:min(100%,340px);border-radius:18px;border:1px solid rgba(245,124,0,.14);background:#fff}.qris-placeholder{width:min(100%,340px);min-height:340px;padding:24px;border-radius:18px;border:2px dashed rgba(245,124,0,.22);display:grid;place-items:center;text-align:center;color:#8e8e95;line-height:1.6}.actions{display:flex;justify-content:flex-end;gap:16px;margin-top:20px}.btn{min-width:170px;height:50px;border-radius:16px;display:inline-flex;align-items:center;justify-content:center;border:2px solid transparent;font-size:.98rem;font-weight:600}.btn-outline{border-color:var(--orange);background:#fff;color:#444}.btn-primary{background:linear-gradient(180deg,#ff8c0d 0%,#f57c00 100%);color:#fff}@media(max-width:760px){.receipt-grid,.fields-grid{grid-template-columns:1fr}.receipt-actions,.actions,.camera-toolbar{flex-direction:column}.wa-btn,.btn,.upload-btn{width:100%;min-width:0}.upload-preview{align-items:flex-start;flex-direction:column}.preview-thumb{width:100%;max-width:120px;height:120px}}
</style>
<link rel="stylesheet" href="{{ asset('css/order-create.css') }}?v=1">
@endpush

@section('content')
@php($serviceSections=[['title'=>'Fast Clean','items'=>[['name'=>'Fast Clean - Easy','price'=>'Rp. 20.000','estimate'=>'1-2 hari','price_value'=>20000],['name'=>'Fast Clean - Hard','price'=>'Rp. 25.000','estimate'=>'1-3 hari','price_value'=>25000]]],['title'=>'Deep Clean','items'=>[['name'=>'Deep Clean - Flat Shoes','price'=>'Rp. 15.000','estimate'=>'1-2 hari','price_value'=>15000],['name'=>'Deep Clean - Reguler','price'=>'Rp. 30.000','estimate'=>'1-3 hari','price_value'=>30000],['name'=>'Deep Clean - Express','price'=>'Rp. 40.000','estimate'=>'1 hari','price_value'=>40000],['name'=>'Deep Clean - Express Half Day','price'=>'Rp. 50.000','estimate'=>'7-8 jam','price_value'=>50000]]],['title'=>'Shoes Repair','items'=>[['name'=>'Reglue','price'=>'Rp. 15.000 - Rp. 35.000','estimate'=>'1-10 hari','price_value'=>15000],['name'=>'Unyellowing','price'=>'Rp. 15.000 - Rp. 25.000','estimate'=>'1-3 hari','price_value'=>15000],['name'=>'Repaint/Custom','price'=>'Rp. 100.000','estimate'=>'3-10 hari','price_value'=>100000]]],['title'=>'Bag/Tas','items'=>[['name'=>'Bag/Tas - Small','price'=>'Rp. 20.000','estimate'=>'-','price_value'=>20000],['name'=>'Bag/Tas - Medium','price'=>'Rp. 25.000','estimate'=>'-','price_value'=>25000],['name'=>'Bag/Tas - Hard','price'=>'Rp. 35.000','estimate'=>'-','price_value'=>35000]]],['title'=>'Hat','items'=>[['name'=>'Hat','price'=>'Rp. 20.000','estimate'=>'-','price_value'=>20000]]]])
@php($serviceEstimateMap = collect($serviceSections)->flatMap(fn ($section) => collect($section['items'])->mapWithKeys(fn ($item) => [$item['name'] => $item['estimate']]))->all())
@php($servicePriceMap = collect($serviceSections)->flatMap(fn ($section) => collect($section['items'])->mapWithKeys(fn ($item) => [$item['name'] => $item['price_value'] ?? (int) preg_replace('/\D+/', '', $item['price'])]))->all())
@php($customerOptions = $customerOptions ?? [])
@php($qrisImagePath = public_path('images/qris-raabshoes.jpg'))
@php($qrisImageUrl = file_exists($qrisImagePath) ? asset('images/qris-raabshoes.jpg') : null)
@php($submittedOrder = session('submitted_order'))
@php($whatsAppNumber = null)
@php($whatsAppMessage = null)
@if($submittedOrder)
    @php($digits = preg_replace('/\D+/', '', $submittedOrder['phone'] ?? ''))
    @php($whatsAppNumber = str_starts_with($digits, '0') ? '62' . substr($digits, 1) : (str_starts_with($digits, '62') ? $digits : $digits))
    @php($estimateLabel = $serviceEstimateMap[$submittedOrder['service'] ?? ''] ?? null)
    @php($estimateLabel = $estimateLabel === '-' ? null : $estimateLabel)
    @php($servicePrice = $servicePriceMap[$submittedOrder['service'] ?? ''] ?? 0)
    @php($cashPaid = isset($submittedOrder['cash_paid']) ? (int) $submittedOrder['cash_paid'] : null)
    @php($cashChange = isset($submittedOrder['cash_change']) ? (int) $submittedOrder['cash_change'] : null)
    @php($estimatedPickupAt = $estimateLabel ? now() : null)
    @if($estimatedPickupAt && str_contains($estimateLabel, 'jam') && preg_match_all('/\d+/', $estimateLabel, $matches))
        @php($estimatedPickupAt = $estimatedPickupAt->copy()->addHours((int) end($matches[0])))
    @elseif($estimatedPickupAt && str_contains($estimateLabel, 'hari') && preg_match_all('/\d+/', $estimateLabel, $matches))
        @php($estimatedPickupAt = $estimatedPickupAt->copy()->addDays((int) end($matches[0])))
    @endif
    @php($whatsAppMessage = rawurlencode(
        "Halo {$submittedOrder['customer_name']},\n" .
        "Berikut ringkasan order Anda di Raab Shoes:\n\n" .
        "Nama: {$submittedOrder['customer_name']}\n" .
        "No HP: {$submittedOrder['phone']}\n" .
        "Barang: {$submittedOrder['service_choice']}\n" .
        "Layanan: {$submittedOrder['service']}\n" .
        "Warna: " . ($submittedOrder['color'] ?: '-') . "\n" .
        "Merek: " . ($submittedOrder['brand'] ?: '-') . "\n" .
        "Tanggal Order Masuk: " . now()->format('d/m/Y H:i') . "\n" .
        ($estimatedPickupAt ? "Estimasi Tanggal Pengambilan: {$estimatedPickupAt->translatedFormat('d M Y, H:i')} ({$estimateLabel})\n" : '') .
        "Metode Pembayaran: {$submittedOrder['payment_method']}\n" .
        (($submittedOrder['payment_method'] ?? null) === 'Cash (Tunai)' && $servicePrice > 0 && $cashPaid !== null
            ? "Total Layanan: Rp " . number_format($servicePrice, 0, ',', '.') . "\n" .
                "Uang Dibayar: Rp " . number_format($cashPaid, 0, ',', '.') . "\n" .
                ($cashChange > 0
                    ? "Kembalian: Rp " . number_format($cashChange, 0, ',', '.') . "\n"
                    : "Pembayaran: Uang pas\n")
            : '') .
        "\n" .
        "Terima kasih."
    ))
@endif
<a href="{{ route('orders.index') }}" class="back-link"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M15 18l-6-6 6-6"/><path d="M9 12h10"/></svg><span>Kembali ke Daftar Orderan</span></a>
<section class="form-panel">
    @if(session('success'))
        <div class="flash-message">
            <strong>{{ session('success') }}</strong>
            @if(session('uploaded_photo_name'))
                <span>File tersimpan: {{ session('uploaded_photo_name') }}</span>
            @endif
        </div>
    @endif

    @if($submittedOrder)
        <div class="receipt-card">
            <h3 class="receipt-title">Ringkasan Struk</h3>
            <div class="receipt-grid">
                <div class="receipt-item"><span class="receipt-label">Nama Pelanggan</span><span class="receipt-value">{{ $submittedOrder['customer_name'] }}</span></div>
                <div class="receipt-item"><span class="receipt-label">Nomor HP</span><span class="receipt-value">{{ $submittedOrder['phone'] }}</span></div>
                <div class="receipt-item"><span class="receipt-label">Barang</span><span class="receipt-value">{{ $submittedOrder['service_choice'] }}</span></div>
                <div class="receipt-item"><span class="receipt-label">Layanan</span><span class="receipt-value">{{ $submittedOrder['service'] }}</span></div>
                <div class="receipt-item"><span class="receipt-label">Warna</span><span class="receipt-value">{{ $submittedOrder['color'] ?: '-' }}</span></div>
                <div class="receipt-item"><span class="receipt-label">Merek</span><span class="receipt-value">{{ $submittedOrder['brand'] ?: '-' }}</span></div>
                <div class="receipt-item"><span class="receipt-label">Metode Pembayaran</span><span class="receipt-value">{{ $submittedOrder['payment_method'] }}</span></div>
                <div class="receipt-item"><span class="receipt-label">Catatan</span><span class="receipt-value">{{ $submittedOrder['notes'] ?: '-' }}</span></div>
            </div>
            @if($whatsAppNumber)
                <div class="receipt-actions">
                    <a class="wa-btn" href="https://wa.me/{{ $whatsAppNumber }}?text={{ $whatsAppMessage }}" target="_blank" rel="noopener">
                        <svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 2a10 10 0 0 0-8.7 14.9L2 22l5.3-1.3A10 10 0 1 0 12 2Zm0 18a8 8 0 0 1-4.1-1.1l-.3-.2-3.1.8.8-3-.2-.3A8 8 0 1 1 12 20Zm4.4-5.6c-.2-.1-1.3-.6-1.5-.7-.2-.1-.4-.1-.5.1-.2.2-.6.7-.7.8-.1.1-.3.2-.5.1a6.6 6.6 0 0 1-1.9-1.2 7.2 7.2 0 0 1-1.3-1.7c-.1-.2 0-.3.1-.5l.3-.3.2-.3c.1-.1.1-.3 0-.5l-.7-1.6c-.2-.4-.4-.4-.5-.4h-.5c-.2 0-.5.1-.7.4-.2.2-.9.9-.9 2.1s.9 2.4 1 2.5c.1.2 1.8 2.9 4.5 4 .6.3 1.1.4 1.5.5.6.2 1.2.1 1.6.1.5-.1 1.3-.5 1.5-1 .2-.5.2-1 .2-1.1 0-.1-.2-.2-.4-.3Z"/></svg>
                        <span>Kirim ke WhatsApp</span>
                    </a>
                </div>
            @endif
        </div>
    @endif

    @if($errors->any())
        <div class="error-box">
            <strong>Form belum bisa disimpan.</strong>
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <header class="order-welcome"><div><span class="order-eyebrow">LET’S MAKE THEM FRESH AGAIN</span><h2 class="form-title">Perawatan terbaik,<br>dimulai dari sini.</h2><p>Lengkapi detail pesanan. Kami bantu merapikan sisanya.</p></div><span class="order-welcome-icon" aria-hidden="true"><svg viewBox="0 0 80 80" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M12 45 21 24l14 13 16 7 13 3q7 2 7 10H11v-7Z"/><path d="M11 57v6h60v-6M30 34l-5 8m14-3-5 8m14-4-5 7M58 17v12m-6-6h12M68 8v6m-3-3h6"/></svg></span></header>
    <nav class="order-steps" aria-label="Bagian form order"><a href="#order-customer"><b>01</b> Pelanggan</a><a href="#order-item"><b>02</b> Barang</a><a href="#order-service"><b>03</b> Layanan</a><a href="#order-payment"><b>04</b> Pembayaran</a></nav>
    <p id="order-draft-status" role="status" style="font-size:12px;color:var(--muted);margin:0 0 14px">Isian disimpan otomatis selama menggunakan tab ini.</p>
    <form id="order-create-form" class="order-form-layout" action="{{ route('orders.store') }}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="order-fields">
        <div class="section" id="order-customer"><div class="order-section-heading"><span class="section-number">01</span><div><h3 class="section-title">Kenali pelanggan Anda</h3><p>Cari pelanggan lama atau isi data pelanggan baru.</p></div></div><div class="fields-grid">
            <div class="field full">
                <label for="customer-picker-search">Cari pelanggan lama <span class="optional-tag">Opsional</span></label>
                <input class="input" id="customer-picker-search" type="text" list="customer-picker-list" placeholder="Cari nama pelanggan atau nomor HP">
                <datalist id="customer-picker-list">
                    @foreach($customerOptions as $customerOption)
                        <option value="{{ $customerOption['name'] }} - {{ $customerOption['phone'] }}"></option>
                        <option value="{{ $customerOption['phone'] }} - {{ $customerOption['name'] }}"></option>
                    @endforeach
                </datalist>
            </div>
            <div class="field"><label for="customer-phone">Nomor HP <span class="required">*</span></label><input class="input" id="customer-phone" type="text" name="phone" value="{{ old('phone') }}" placeholder="081xxxxxxxxx"></div>
            <div class="field"><label for="customer-name">Nama Pelanggan <span class="required">*</span></label><input class="input" id="customer-name" type="text" name="customer_name" value="{{ old('customer_name') }}" placeholder="Masukkan nama pelanggan"></div>
            <div class="field full"><label for="customer-address">Alamat (Opsional)</label><input class="input" id="customer-address" type="text" name="address" value="{{ old('address') }}" placeholder="Masukkan alamat"></div>
        </div></div>
        <div class="section" id="order-item"><div class="order-section-heading"><span class="section-number">02</span><div><h3 class="section-title">Detail barang</h3><p>Catat ciri barang agar mudah dikenali saat pengambilan.</p></div></div><div class="fields-grid">
            <div class="field"><label for="item-color">Warna</label><input class="input" type="text" id="item-color" name="color" value="{{ old('color') }}" placeholder="Contoh: Hitam, Putih, Merah"></div>
            <div class="field"><label for="item-condition">Kondisi</label><select class="select" id="item-condition" name="condition"><option value="">-- Pilih Kondisi Barang --</option><option value="Masih cukup bersih" @selected(old('condition') === 'Masih cukup bersih')>Masih cukup bersih</option><option value="Kotor ringan" @selected(old('condition') === 'Kotor ringan')>Kotor ringan</option><option value="Kotor sedang" @selected(old('condition') === 'Kotor sedang')>Kotor sedang</option><option value="Kotor banget" @selected(old('condition') === 'Kotor banget')>Kotor banget</option><option value="Ada noda membandel" @selected(old('condition') === 'Ada noda membandel')>Ada noda membandel</option><option value="Perlu perawatan khusus" @selected(old('condition') === 'Perlu perawatan khusus')>Perlu perawatan khusus</option></select></div>
            <div class="field"><label for="item-type">Barang <span class="required">*</span></label><select class="select" id="item-type" name="service_choice"><option value="">-- Pilih Barang --</option><option value="Sepatu" @selected(old('service_choice') === 'Sepatu')>Sepatu</option><option value="Topi" @selected(old('service_choice') === 'Topi')>Topi</option><option value="Tas" @selected(old('service_choice') === 'Tas')>Tas</option></select></div>
            <div class="field"><label for="item-brand">Merek</label><input class="input" type="text" id="item-brand" name="brand" value="{{ old('brand') }}" placeholder="Contoh: Nike, Adidas, Converse"></div>
        </div></div>
        <div class="section" id="order-service"><div class="order-section-heading"><span class="section-number">03</span><div><h3 class="section-title">Pilih perawatan</h3><p>Sesuaikan layanan dengan kebutuhan barang pelanggan.</p></div></div><div class="fields-grid"><div class="field full"><select class="select" aria-label="Layanan perawatan" id="service-select" name="service"><option value="">-- Pilih Layanan --</option>@foreach($serviceSections as $serviceSection)<optgroup label="{{ $serviceSection['title'] }}">@foreach($serviceSection['items'] as $serviceItem)<option value="{{ $serviceItem['name'] }}" data-price="{{ $serviceItem['price_value'] ?? (int) preg_replace('/\D+/', '', $serviceItem['price']) }}" @selected(old('service') === $serviceItem['name'])>{{ $serviceItem['name'] }} - {{ $serviceItem['price'] }}</option>@endforeach</optgroup>@endforeach</select></div></div></div>
        <div class="section" id="order-photo"><div class="order-section-heading"><span class="section-number">04</span><div><h3 class="section-title">Dokumentasi barang</h3><p>Simpan foto kondisi awal sebelum perawatan. Opsional.</p></div></div><div class="fields-grid"><div class="field full"><div class="upload-panel"><div class="upload-actions"><button class="upload-btn primary" id="pick-photo-btn" type="button"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M12 3v12"/><path d="M8 11l4 4 4-4"/><path d="M5 21h14"/></svg><span>Pilih dari Galeri</span></button><button class="upload-btn" id="open-camera-btn" type="button"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M4 7h4l2-2h4l2 2h4v12H4z"/><circle cx="12" cy="13" r="4"/></svg><span>Ambil Foto Sekarang</span></button></div><label class="upload-box" id="upload-box"><input class="upload-input" id="item-photo" name="item_photo" type="file" accept=".png,.jpg,.jpeg,image/png,image/jpeg" capture="environment"><div class="upload-placeholder"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><path d="M7 10l5-5 5 5"/><path d="M12 5v12"/></svg><strong>Ambil foto barang atau upload file</strong><span>PNG, JPG (max. 5MB)</span></div><div class="upload-preview" id="upload-preview"><img class="preview-thumb" id="preview-thumb" alt="Preview foto barang"><div class="preview-meta"><span class="preview-name" id="preview-name">Belum ada file</span><span class="preview-help">Admin dan pegawai bisa ambil ulang foto sebelum simpan order.</span></div></div></label><div class="camera-panel" id="camera-panel"><div class="camera-frame"><video class="camera-video" id="camera-video" autoplay playsinline muted></video><div class="camera-empty" id="camera-empty">Membuka kamera… Izinkan akses kamera jika browser meminta izin.</div></div><div class="camera-toolbar"><button class="upload-btn primary" id="capture-camera-btn" type="button" disabled>Ambil Jepretan</button><button class="upload-btn" id="close-camera-btn" type="button">Tutup Kamera</button></div><div class="camera-note">Di HP biasanya kamera belakang akan diprioritaskan. Di laptop, browser akan memakai webcam yang tersedia.</div></div><div class="upload-status" id="upload-status"></div>@if(session('uploaded_photo_url'))<div class="preview-meta" style="margin-top:10px"><span class="preview-help">Foto terakhir tersimpan:</span><a href="{{ session('uploaded_photo_url') }}" target="_blank" rel="noopener" class="preview-name">Lihat file upload</a></div>@endif</div></div></div></div>
        <div class="section" id="order-notes"><div class="order-section-heading"><span class="section-number">05</span><div><h3 class="section-title">Ada perhatian khusus?</h3><p>Tambahkan detail noda, kerusakan, atau permintaan pelanggan.</p></div></div><div class="fields-grid"><div class="field full"><textarea aria-label="Catatan tambahan" class="textarea" name="notes" placeholder="Catatan tambahan (opsional)">{{ old('notes') }}</textarea></div></div></div>
        <div class="section" id="order-payment"><div class="order-section-heading"><span class="section-number">06</span><div><h3 class="section-title">Informasi pembayaran</h3><p>Barang boleh dititipkan dulu. Tandai Lunas setelah pembayaran diterima.</p></div></div><div class="fields-grid"><div class="field"><label for="payment-status">Status Pembayaran</label><select class="select" id="payment-status" name="payment_status"><option value="Belum Lunas" @selected(old('payment_status', 'Belum Lunas') === 'Belum Lunas')>Belum Lunas — bayar nanti</option><option value="Lunas" @selected(old('payment_status') === 'Lunas')>Lunas</option></select><label for="payment-method">Metode Pembayaran (opsional)</label><select class="select" id="payment-method" name="payment_method"><option value="">Belum ditentukan</option><option value="Cash (Tunai)" @selected(old('payment_method') === 'Cash (Tunai)')>Cash (Tunai)</option><option value="Transfer Bank" @selected(old('payment_method') === 'Transfer Bank')>Transfer Bank</option><option value="QRIS" @selected(old('payment_method') === 'QRIS')>QRIS</option></select></div><div class="field full" id="cash-payment-panel"><label for="service-total-display">Total Layanan</label><input class="input" id="service-total-display" type="text" value="Rp 0" readonly><label for="cash-paid-input" style="margin-top:10px">Uang Dibayar (opsional)</label><input class="input" id="cash-paid-input" type="text" name="cash_paid" value="{{ old('cash_paid') }}" placeholder="Masukkan nominal tunai">@error('cash_paid')<span class="preview-help" style="color:#b42318">{{ $message }}</span>@enderror<div class="preview-meta" style="margin-top:8px"><span class="preview-help" id="cash-payment-summary">Masukkan nominal untuk melihat apakah pembayaran pas atau ada kembalian.</span></div></div><div class="field full"><div class="qris-panel" id="qris-payment-panel"><div class="qris-summary"><label>Total Pembayaran QRIS</label><div class="qris-total" id="qris-total-display">Rp 0</div><div class="qris-note">QRIS statis bisa langsung discan pelanggan. Nominal yang harus dibayar tetap mengikuti total layanan di bawah ini.</div></div><div class="qris-card">@if($qrisImageUrl)<img class="qris-image" src="{{ $qrisImageUrl }}" alt="QRIS RaabShoes">@else<div class="qris-placeholder">Taruh file QRIS asli di <strong>`public/images/qris-raabshoes.jpg`</strong><br>agar panel pembayaran bisa menampilkan gambar QRIS toko.</div>@endif<div class="preview-help">Nominal pembayaran yang diminta: <strong id="qris-total-caption">Rp 0</strong></div></div></div></div></div></div>
        </div>
        <aside class="order-summary" aria-labelledby="order-summary-title">
            <div class="summary-top"><span class="order-eyebrow">PESANAN BARU</span><span class="draft-badge">Draft</span></div>
            <h3 id="order-summary-title">Ringkasan order</h3><p class="summary-caption">Terisi otomatis saat Anda melengkapi form.</p>
            <div class="summary-item-visual" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.4" stroke-linejoin="round"><path d="M3 12 6 5l5 5 5 2 4 1 1 4H3zM3 17v3h18v-3M10 9l-2 3m6-1-2 3"/></svg><span>Fresh care. Happy shoes.</span></div>
            <dl class="order-summary-list"><div><dt>Pelanggan</dt><dd id="summary-customer">Belum diisi</dd></div><div><dt>Barang</dt><dd id="summary-item">Belum dipilih</dd></div><div><dt>Layanan</dt><dd id="summary-service">Belum dipilih</dd></div><div><dt>Estimasi pengerjaan</dt><dd id="summary-estimate">—</dd></div><div><dt>Pembayaran</dt><dd id="summary-payment">Cash (Tunai)</dd></div></dl>
            <div class="order-summary-total"><span>Total layanan</span><strong id="summary-total" aria-live="polite">Rp 0</strong></div>
            <p class="summary-footnote">Periksa kembali detail pelanggan dan barang sebelum menyimpan order.</p>
            <div class="order-summary-tip"><span aria-hidden="true">✦</span><p><strong>Detail kecil, layanan maksimal.</strong>Foto dan catatan kondisi barang membantu tim memberikan perawatan yang tepat.</p></div>
        </aside>
        <div class="actions"><span class="required-note"><span class="required">*</span> Wajib diisi</span><a href="{{ route('orders.index') }}" class="btn btn-outline">Batal</a><button type="submit" class="btn btn-primary">Simpan Order</button></div>
    </form>
</section>
@endsection

@push('scripts')
<script src="{{ asset('js/order-draft.js') }}"></script>
<script>
    (() => {
        const input = document.getElementById('item-photo');
        const box = document.getElementById('upload-box');
        const thumb = document.getElementById('preview-thumb');
        const name = document.getElementById('preview-name');
        const pickPhotoButton = document.getElementById('pick-photo-btn');
        const openCameraButton = document.getElementById('open-camera-btn');
        const cameraPanel = document.getElementById('camera-panel');
        const cameraVideo = document.getElementById('camera-video');
        const cameraEmpty = document.getElementById('camera-empty');
        const captureCameraButton = document.getElementById('capture-camera-btn');
        const closeCameraButton = document.getElementById('close-camera-btn');
        const uploadStatus = document.getElementById('upload-status');
        const customerPickerSearch = document.getElementById('customer-picker-search');
        const customerPhone = document.getElementById('customer-phone');
        const customerName = document.getElementById('customer-name');
        const customerAddress = document.getElementById('customer-address');
        const serviceSelect = document.getElementById('service-select');
        const paymentMethod = document.getElementById('payment-method');
        const cashPaymentPanel = document.getElementById('cash-payment-panel');
        const qrisPaymentPanel = document.getElementById('qris-payment-panel');
        const serviceTotalDisplay = document.getElementById('service-total-display');
        const qrisTotalDisplay = document.getElementById('qris-total-display');
        const qrisTotalCaption = document.getElementById('qris-total-caption');
        const cashPaidInput = document.getElementById('cash-paid-input');
        const cashPaymentSummary = document.getElementById('cash-payment-summary');
        const customerOptions = @json($customerOptions);
        let cameraStream = null;
        let cameraRequest = 0;
        let objectUrl = null;

        if (!input || !box || !thumb || !name) {
            return;
        }

        const setStatus = (message, type = '') => {
            if (!uploadStatus) {
                return;
            }

            uploadStatus.textContent = message;
            uploadStatus.classList.toggle('error', type === 'error');
        };

        const resetObjectUrl = () => {
            if (objectUrl) {
                URL.revokeObjectURL(objectUrl);
                objectUrl = null;
            }
        };

        const showPreview = (file) => {
            if (!file) {
                box.classList.remove('has-file');
                resetObjectUrl();
                thumb.removeAttribute('src');
                name.textContent = 'Belum ada file';
                setStatus('');
                return;
            }

            box.classList.add('has-file');
            name.textContent = file.name;

            if (file.type.startsWith('image/')) {
                resetObjectUrl();
                objectUrl = URL.createObjectURL(file);
                thumb.src = objectUrl;
            }
        };

        const stopCamera = () => {
            cameraRequest++;
            if (openCameraButton) openCameraButton.disabled = false;
            if (cameraStream) {
                cameraStream.getTracks().forEach((track) => track.stop());
                cameraStream = null;
            }

            if (cameraPanel) {
                cameraPanel.classList.remove('is-open');
            }

            if (cameraVideo) {
                cameraVideo.srcObject = null;
            }

            if (cameraEmpty) {
                cameraEmpty.hidden = false;
            }

            if (captureCameraButton) {
                captureCameraButton.disabled = true;
            }
        };

        const assignCapturedFile = async (blob) => {
            const capturedFile = new File([blob], `order-photo-${Date.now()}.jpg`, { type: 'image/jpeg' });
            const dataTransfer = new DataTransfer();
            dataTransfer.items.add(capturedFile);
            input.files = dataTransfer.files;
            input.dispatchEvent(new Event('change', { bubbles: true }));
            setStatus('Foto berhasil diambil dari kamera.');
        };

        input.addEventListener('change', () => {
            const [file] = input.files || [];
            showPreview(file);
            if (file) {
                setStatus('File foto siap diupload.');
            }
        });

        pickPhotoButton?.addEventListener('click', () => {
            stopCamera();
            input.removeAttribute('capture');
            input.click();
        });

        openCameraButton?.addEventListener('click', async () => {
            if (!navigator.mediaDevices?.getUserMedia) {
                setStatus('Kamera langsung tidak tersedia. Gunakan browser yang mendukung kamera melalui HTTPS atau pilih foto dari galeri.', 'error');
                return;
            }

            stopCamera();
            const request = cameraRequest;
            openCameraButton.disabled = true;
            cameraPanel?.classList.add('is-open');
            cameraEmpty.hidden = false;
            setStatus('Membuka kamera…');

            try {
                const stream = await navigator.mediaDevices.getUserMedia({
                    video: { facingMode: { ideal: 'environment' } },
                    audio: false,
                });
                // A cancelled request must not reopen the camera when permission arrives.
                if (request !== cameraRequest) {
                    stream.getTracks().forEach((track) => track.stop());
                    return;
                }
                cameraStream = stream;
                cameraVideo.srcObject = stream;
                await cameraVideo.play();
                if (request !== cameraRequest) return;
                cameraEmpty.hidden = true;
                captureCameraButton.disabled = false;
                setStatus('Kamera aktif. Arahkan ke barang lalu tekan "Ambil Jepretan".');
            } catch (error) {
                if (request !== cameraRequest) return;
                stopCamera();
                setStatus('Kamera tidak dapat dibuka. Izinkan akses kamera di browser, lalu tekan "Ambil Foto Sekarang" lagi atau pilih foto dari galeri.', 'error');
            } finally {
                if (request === cameraRequest) openCameraButton.disabled = false;
            }
        });

        cameraVideo?.addEventListener('loadedmetadata', () => {
            if (cameraEmpty && cameraVideo.srcObject) {
                cameraEmpty.hidden = true;
            }

            if (captureCameraButton && cameraVideo.srcObject) {
                captureCameraButton.disabled = false;
            }
        });

        cameraVideo?.addEventListener('playing', () => {
            if (cameraEmpty) {
                cameraEmpty.hidden = true;
            }
        });

        captureCameraButton?.addEventListener('click', async () => {
            if (!cameraStream || !cameraVideo.videoWidth || !cameraVideo.videoHeight) {
                setStatus('Kamera belum siap untuk mengambil gambar.', 'error');
                return;
            }

            const canvas = document.createElement('canvas');
            canvas.width = cameraVideo.videoWidth;
            canvas.height = cameraVideo.videoHeight;

            const context = canvas.getContext('2d');
            if (!context) {
                setStatus('Preview kamera tidak bisa diproses.', 'error');
                return;
            }

            context.drawImage(cameraVideo, 0, 0, canvas.width, canvas.height);
            const blob = await new Promise((resolve) => canvas.toBlob(resolve, 'image/jpeg', 0.92));

            if (!blob) {
                setStatus('Foto gagal dibuat dari kamera.', 'error');
                return;
            }

            await assignCapturedFile(blob);
            stopCamera();
        });

        closeCameraButton?.addEventListener('click', () => {
            stopCamera();
            setStatus('Mode kamera ditutup.');
        });

        window.addEventListener('beforeunload', stopCamera);

        const formatRupiah = (value) => `Rp ${new Intl.NumberFormat('id-ID').format(value)}`;
        const getSelectedServicePrice = () => {
            const selectedOption = serviceSelect?.selectedOptions?.[0];
            return Number(selectedOption?.dataset.price || 0);
        };
        const serviceEstimates = @json($serviceEstimateMap);
        const updateOrderSummary = () => {
            const write = (id, value) => { document.getElementById(id).textContent = value; };
            write('summary-customer', customerName.value.trim() || 'Belum diisi');
            write('summary-item', document.querySelector('[name="service_choice"]').value || 'Belum dipilih');
            write('summary-service', serviceSelect.value || 'Belum dipilih');
            write('summary-estimate', serviceEstimates[serviceSelect.value] || '—');
            write('summary-payment', paymentMethod.value);
            write('summary-total', formatRupiah(getSelectedServicePrice()));
        };
        document.getElementById('order-create-form').addEventListener('input', updateOrderSummary);
        document.getElementById('order-create-form').addEventListener('change', updateOrderSummary);
        updateOrderSummary();
        const getCashPaidValue = () => Number((cashPaidInput?.value || '').replace(/\D+/g, '')) || 0;
        const updateCashPanel = () => {
            if (!paymentMethod || !cashPaymentPanel || !serviceTotalDisplay || !cashPaymentSummary) {
                return;
            }

            const unpaid = document.getElementById('payment-status').value === 'Belum Lunas';
            if (unpaid) {
                paymentMethod.value = '';
                if (cashPaidInput) cashPaidInput.value = '';
            }
            paymentMethod.disabled = unpaid;
            updateOrderSummary();

            const isCash = paymentMethod.value === 'Cash (Tunai)' && document.getElementById('payment-status').value === 'Lunas';
            const isQris = paymentMethod.value === 'QRIS';
            const servicePrice = getSelectedServicePrice();
            cashPaymentPanel.style.display = isCash ? 'flex' : 'none';
            cashPaymentPanel.style.flexDirection = 'column';
            qrisPaymentPanel?.classList.toggle('is-open', isQris);
            if (qrisTotalDisplay) {
                qrisTotalDisplay.textContent = formatRupiah(servicePrice);
            }
            if (qrisTotalCaption) {
                qrisTotalCaption.textContent = formatRupiah(servicePrice);
            }

            if (!isCash) {
                cashPaymentSummary.textContent = 'Pembayaran non-tunai tidak memerlukan hitung kembalian.';
                return;
            }

            const cashPaid = getCashPaidValue();
            serviceTotalDisplay.value = formatRupiah(servicePrice);

            if (!cashPaid) {
                cashPaymentSummary.textContent = 'Masukkan nominal untuk melihat apakah pembayaran pas atau ada kembalian.';
                return;
            }

            if (cashPaid < servicePrice) {
                cashPaymentSummary.textContent = `Uang dibayar kurang ${formatRupiah(servicePrice - cashPaid)} dari total layanan.`;
                return;
            }

            const change = cashPaid - servicePrice;
            cashPaymentSummary.textContent = change > 0
                ? `Kembalian pelanggan: ${formatRupiah(change)}.`
                : 'Pembayaran pelanggan pas.';
        };

        paymentMethod?.addEventListener('change', updateCashPanel);
        document.getElementById('payment-status')?.addEventListener('change', updateCashPanel);
        serviceSelect?.addEventListener('change', updateCashPanel);
        cashPaidInput?.addEventListener('input', updateCashPanel);
        updateCashPanel();

        const fillCustomerFields = (customer) => {
            if (!customer) {
                return;
            }

            if (customerPhone) {
                customerPhone.value = customer.phone || '';
            }

            if (customerName) {
                customerName.value = customer.name || '';
            }

            if (customerAddress) {
                customerAddress.value = customer.address || '';
            }
            updateOrderSummary();
            customerName?.dispatchEvent(new Event('input', { bubbles: true }));
        };

        const findCustomer = (keyword) => {
            const normalizedKeyword = (keyword || '').trim().toLowerCase();
            if (!normalizedKeyword) {
                return null;
            }

            return customerOptions.find((customer) => {
                const name = (customer.name || '').toLowerCase();
                const phone = (customer.phone || '').toLowerCase();
                const byName = `${name} - ${phone}`;
                const byPhone = `${phone} - ${name}`;

                return name === normalizedKeyword
                    || phone === normalizedKeyword
                    || byName === normalizedKeyword
                    || byPhone === normalizedKeyword;
            }) || customerOptions.find((customer) => {
                const name = (customer.name || '').toLowerCase();
                const phone = (customer.phone || '').toLowerCase();

                return name.includes(normalizedKeyword) || phone.includes(normalizedKeyword);
            }) || null;
        };

        customerPickerSearch?.addEventListener('change', () => {
            fillCustomerFields(findCustomer(customerPickerSearch.value));
        });

        customerPickerSearch?.addEventListener('blur', () => {
            fillCustomerFields(findCustomer(customerPickerSearch.value));
        });
        window.installOrderDraft({
            form: document.getElementById('order-create-form'),
            key: @json(hash('sha256', session()->getId() . '|' . (session('social_auth.user_id') ?? session('social_auth.email') ?? 'guest'))) + ':' + @json(session('order_draft_revision', 0)),
            hasOldInput: @json(session()->hasOldInput()),
            refresh: () => { updateCashPanel(); updateOrderSummary(); },
        });
    })();
</script>
@endpush
