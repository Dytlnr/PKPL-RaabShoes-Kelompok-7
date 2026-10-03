@extends('layouts.admin')
@section('page-title', 'Nota WhatsApp')
@section('page-subtitle', 'Periksa pesan terbaru sebelum membuka WhatsApp.')
@section('content')
<div style="max-width:720px;margin:auto;background:var(--panel);padding:24px;border:1px solid var(--border-soft);border-radius:18px">
    <a href="{{ route('orders.index') }}" style="font-size:12px">← Kembali ke order</a>
    <h2 style="font-size:18px;margin:18px 0 8px">Nota {{ $order->order_code }}</h2>
    <p style="font-size:12px;color:var(--muted)">Status pengerjaan: <strong>{{ $order->status }}</strong> · Pembayaran: <strong>{{ $order->payment_status ?? 'Belum dikonfirmasi' }}</strong></p>
    <p style="font-size:12px;color:var(--muted)">Jika WhatsApp masih menampilkan draf lama, salin pesan ini dan gantikan teks di kolom pesan WhatsApp.</p>
    <textarea id="receipt-message" readonly aria-label="Pesan nota terbaru" style="width:100%;min-height:470px;padding:16px;border:1px solid var(--border-soft);border-radius:12px;background:var(--panel);color:var(--text);font-size:13px;line-height:1.7">{{ $message }}</textarea>
    <div style="display:flex;flex-wrap:wrap;gap:10px;margin-top:16px;align-items:center">
        <button type="button" id="copy-receipt" style="padding:11px 16px;border:1px solid #d9ded9;border-radius:9px;cursor:pointer;font-size:12px">Salin pesan terbaru</button>
        <a href="{{ $whatsappUrl }}" target="_blank" rel="noopener" style="padding:11px 16px;border-radius:9px;background:#238e60;color:white;font-size:12px">Buka WhatsApp</a>
        <a href="{{ route('orders.whatsapp', ['id' => $order->order_code, 'preview' => 1, '_fresh' => now()->timestamp]) }}" style="font-size:12px">Muat ulang nota</a>
    </div>
    <p id="copy-status" role="status" style="font-size:12px"></p>
</div>
@endsection
@push('scripts')
<script>
document.getElementById('copy-receipt').addEventListener('click', async () => {
    const field = document.getElementById('receipt-message');
    const status = document.getElementById('copy-status');
    try {
        await navigator.clipboard.writeText(field.value);
        status.textContent = 'Pesan terbaru disalin. Tempelkan ke WhatsApp.';
    } catch {
        field.focus(); field.select();
        status.textContent = 'Teks sudah dipilih. Gunakan Salin dari perangkat, lalu tempel ke WhatsApp.';
    }
});
</script>
@endpush
