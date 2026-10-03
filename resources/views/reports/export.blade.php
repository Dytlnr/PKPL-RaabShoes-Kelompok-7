<!DOCTYPE html>
<html lang="id">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Laporan Raab Shoes</title>
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=poppins:400,500,600,700,800" rel="stylesheet" />
        <style>
            body{margin:0;padding:32px;font-family:'Poppins',sans-serif;color:#1d1d1f;background:#f6f2ea} .sheet{max-width:980px;margin:0 auto;background:#fff;padding:32px 34px;border-radius:28px;box-shadow:0 18px 38px rgba(83,61,26,.12)} .header{display:flex;justify-content:space-between;gap:20px;align-items:flex-start;margin-bottom:28px} .title{margin:0;font-size:2rem;font-weight:700} .subtitle{margin:8px 0 0;color:#7f8fc2;font-size:.98rem} .summary{display:grid;grid-template-columns:repeat(3,minmax(0,1fr));gap:16px;margin-bottom:24px} .card{padding:18px 20px;border-radius:22px;background:#fff8ef;border:1px solid #f2dec0} .label{font-size:.92rem;color:#786f63} .value{margin-top:12px;font-size:1.7rem;font-weight:700} .section{margin-top:26px} .section h2{margin:0 0 14px;font-size:1.08rem} table{width:100%;border-collapse:collapse;font-size:.92rem} th,td{padding:12px 10px;border-bottom:1px solid #eee6da;text-align:left;vertical-align:top} th{color:#786f63;font-weight:600} .footer{margin-top:28px;color:#8a867d;font-size:.88rem} @media print{body{padding:0;background:#fff}.sheet{max-width:none;box-shadow:none;border-radius:0;padding:20px}} @media (max-width:760px){body{padding:16px}.sheet{padding:22px}.summary{grid-template-columns:1fr}}
        </style>
    </head>
    <body>
        <main class="sheet">
            <header class="header">
                <div>
                    <h1 class="title">Laporan Raab Shoes</h1>
                    <p class="subtitle">
                        Periode:
                        {{ $dateFrom ? \Illuminate\Support\Carbon::parse($dateFrom)->format('d/m/Y') : '-' }}
                        s/d
                        {{ $dateTo ? \Illuminate\Support\Carbon::parse($dateTo)->format('d/m/Y') : '-' }}
                    </p>
                </div>
                <div>{{ now()->format('d/m/Y H:i') }}</div>
            </header>

            <section class="summary">
                <article class="card"><div class="label">Total Order</div><div class="value">{{ $totalOrders }}</div></article>
                <article class="card"><div class="label">Total Pendapatan</div><div class="value">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</div></article>
                <article class="card"><div class="label">Rata-Rata Order</div><div class="value">Rp {{ number_format($averageOrder, 0, ',', '.') }}</div></article>
            </section>

            <section class="section">
                <h2>Daftar Order</h2>
                <table>
                    <thead>
                        <tr>
                            <th>ID Order</th>
                            <th>Pelanggan</th>
                            <th>Barang</th>
                            <th>Layanan</th>
                            <th>Status</th>
                            <th>Waktu</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($orders as $order)
                            <tr>
                                <td>{{ $order['id'] ?? '-' }}</td>
                                <td>{{ $order['customer_name'] ?? '-' }}<br>{{ $order['phone'] ?? '-' }}</td>
                                <td>{{ $order['service_choice'] ?? '-' }}</td>
                                <td>{{ $order['service'] ?? '-' }}</td>
                                <td>{{ $order['status'] ?? '-' }}</td>
                                <td>{{ $order['created_at'] ?? '-' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6">Tidak ada data order pada periode ini.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </section>

            <div class="footer">Gunakan menu cetak browser lalu pilih "Save as PDF" untuk menyimpan file PDF.</div>
        </main>
        <script>
            window.addEventListener('load', () => {
                window.print();
            });
        </script>
    </body>
</html>
