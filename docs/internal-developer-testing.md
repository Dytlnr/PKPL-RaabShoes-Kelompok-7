# Testing Internal oleh Pengembang - Website Raab Shoes

## 1. Informasi Dokumen

| Item | Keterangan |
| --- | --- |
| Nama aplikasi | Manajemen Raab Shoes |
| Tipe dokumen | Internal Developer Testing |
| Tanggal penyusunan | 14 Juli 2026 |
| Lingkup | Pemeriksaan teknis sebelum diserahkan ke QA/user |
| Penguji | Pengembang |
| Referensi QA manual | `docs/qa-document.md` |

## 2. Tujuan

Testing internal oleh pengembang dilakukan untuk memastikan perubahan kode tidak merusak fungsi utama website sebelum masuk tahap QA manual. Fokus pengujian ini adalah:

- Memastikan aplikasi bisa berjalan tanpa error teknis dasar.
- Memastikan route, controller, model, view, dan validasi utama bekerja sesuai alur bisnis.
- Memastikan command test otomatis Laravel dapat dijalankan.
- Memastikan fitur operasional utama tidak mengalami regression.
- Mencatat area yang perlu diuji manual lebih lanjut oleh QA.

## 3. Scope Pengujian Internal

| Modul | Cakupan Internal Testing |
| --- | --- |
| Authentication | Login lokal, logout, forgot password, reset password, register disabled |
| Dashboard | Statistik order, pendapatan, status order, layanan terlaris |
| Order & Transaksi | Tambah order, upload foto, pembayaran cash/transfer/QRIS, edit order, update status, WhatsApp |
| Pelanggan & Member | Tambah pelanggan, update pelanggan berdasarkan nomor HP, stempel member, klaim reward |
| Laporan | Filter tanggal, total order, total pendapatan, rata-rata order, export laporan |
| Riwayat Transaksi | Search, filter status, filter tanggal |
| Pengaturan | Tambah akun pegawai, validasi username/email, pembatasan akses admin |
| UI dasar | Layout desktop/mobile, modal, dropdown, flash message |

## 4. Environment Internal

| Komponen | Status |
| --- | --- |
| PHP dependency (`vendor`) | Tersedia |
| Node dependency (`node_modules`) | Belum tersedia pada saat pengecekan |
| PHPUnit | Tersedia lewat `composer test` |
| Database test | SQLite in-memory dari `phpunit.xml` |
| Browser manual | Chrome/Safari direkomendasikan |
| Upload folder | `public/uploads/order-photos` |

## 5. Command Verifikasi Developer

Jalankan command berikut sebelum menyerahkan build ke QA:

| Command | Tujuan | Expected Result |
| --- | --- | --- |
| `composer test` | Menjalankan automated test Laravel | Semua test pass |
| `php artisan migrate:status` | Memastikan migration terbaca | Status migration tampil tanpa error |
| `php artisan route:list` | Memastikan route terdaftar | Route auth, dashboard, order, customer, report, settings tampil |
| `npm run build` | Build asset frontend | Build selesai tanpa error |

Catatan: `npm run build` membutuhkan `node_modules`. Jika belum ada, jalankan `npm install` lebih dulu.

## 6. Hasil Command yang Sudah Dijalankan

| Tanggal | Command | Hasil | Catatan |
| --- | --- | --- | --- |
| 14 Juli 2026 | `composer test` | Pass | 2 tests passed, 2 assertions |
| 14 Juli 2026 | Cek `vendor` | Pass | Folder `vendor` tersedia |
| 14 Juli 2026 | Cek `node_modules` | Blocked | Folder `node_modules` belum tersedia, build frontend belum dijalankan |

## 7. Test Case Internal Pengembang

### DEV-AUTH-001 Login Local Admin

| Item | Detail |
| --- | --- |
| Prioritas | High |
| Langkah | Login memakai email/username admin dan password benar |
| Expected Result | Session `social_auth` terisi, user masuk dashboard |
| Status | Not Run |

### DEV-AUTH-002 Login Gagal

| Item | Detail |
| --- | --- |
| Prioritas | High |
| Langkah | Login memakai password salah |
| Expected Result | Redirect kembali ke login dan flash error tampil |
| Status | Not Run |

### DEV-AUTH-003 Reset Password

| Item | Detail |
| --- | --- |
| Prioritas | High |
| Langkah | Jalankan forgot password, lanjut reset password dengan konfirmasi valid |
| Expected Result | Password user berubah dan session reset dibersihkan |
| Status | Not Run |

### DEV-ORDER-001 Store Order Cash

| Item | Detail |
| --- | --- |
| Prioritas | Critical |
| Langkah | Submit `/orders` dengan pelanggan, layanan, foto valid, payment `Cash (Tunai)`, dan `cash_paid` cukup |
| Expected Result | Order tersimpan, customer tersimpan, status `Baru`, `service_price`, `cash_paid`, dan `cash_change` benar |
| Status | Not Run |

### DEV-ORDER-002 Store Order Cash Kurang

| Item | Detail |
| --- | --- |
| Prioritas | High |
| Langkah | Submit order cash dengan `cash_paid` lebih kecil dari harga layanan |
| Expected Result | Request ditolak dan error validasi `cash_paid` muncul |
| Status | Not Run |

### DEV-ORDER-003 Store Order Transfer/QRIS

| Item | Detail |
| --- | --- |
| Prioritas | High |
| Langkah | Submit order dengan payment `Transfer Bank` dan `QRIS` |
| Expected Result | Order tersimpan tanpa wajib `cash_paid` |
| Status | Not Run |

### DEV-ORDER-004 Upload Foto

| Item | Detail |
| --- | --- |
| Prioritas | Critical |
| Langkah | Submit order dengan JPG/PNG di bawah 5 MB |
| Expected Result | File pindah ke `public/uploads/order-photos`, `photo_path`, `photo_name`, dan `photo_url` valid |
| Status | Not Run |

### DEV-ORDER-005 Update Status Order

| Item | Detail |
| --- | --- |
| Prioritas | Critical |
| Langkah | POST `/orders/{id}/status` dengan status `Diproses`, `Siap Diambil`, `Diambil` |
| Expected Result | Status order berubah dan redirect kembali ke daftar order |
| Status | Not Run |

### DEV-ORDER-006 Edit Order

| Item | Detail |
| --- | --- |
| Prioritas | Critical |
| Langkah | POST `/orders/{id}` dengan perubahan pelanggan, layanan, pembayaran, dan status |
| Expected Result | Order terupdate, customer terkait ikut disinkronkan, harga layanan mengikuti layanan terbaru |
| Status | Not Run |

### DEV-ORDER-007 WhatsApp Redirect

| Item | Detail |
| --- | --- |
| Prioritas | Medium |
| Langkah | GET `/orders/{id}/whatsapp` untuk order dengan nomor `08...` |
| Expected Result | Redirect ke `https://wa.me/62...` dengan pesan yang sudah di-encode |
| Status | Not Run |

### DEV-CUS-001 Store Customer

| Item | Detail |
| --- | --- |
| Prioritas | High |
| Langkah | POST `/customers` dengan nama dan nomor HP |
| Expected Result | Customer tersimpan dengan `customer_code` dan `member_code` |
| Status | Not Run |

### DEV-CUS-002 Update Customer Nomor Sama

| Item | Detail |
| --- | --- |
| Prioritas | Medium |
| Langkah | POST `/customers` memakai nomor HP yang sudah ada dengan nama/alamat baru |
| Expected Result | Data customer lama terupdate, bukan membuat duplikasi |
| Status | Not Run |

### DEV-CUS-003 Hitung Stempel Member

| Item | Detail |
| --- | --- |
| Prioritas | Critical |
| Langkah | Buat 8 order untuk customer sama, set status ke `Siap Diambil` atau `Diambil` |
| Expected Result | `completed_wash_orders_count` = 8, `available_rewards` = 1, `current_stamp_progress` = 8 |
| Status | Not Run |

### DEV-CUS-004 Redeem Reward

| Item | Detail |
| --- | --- |
| Prioritas | Critical |
| Langkah | POST `/customers/{id}/redeem` saat reward tersedia |
| Expected Result | `reward_redemptions` bertambah 1 dan reward tersedia berkurang |
| Status | Not Run |

### DEV-DASH-001 Dashboard Metrics

| Item | Detail |
| --- | --- |
| Prioritas | High |
| Langkah | Buat beberapa order dengan status berbeda, buka `/dashboard` |
| Expected Result | Total order hari ini, pendapatan, order diproses, siap diambil, tuntas, total pelanggan, dan top services akurat |
| Status | Not Run |

### DEV-REP-001 Report Date Range

| Item | Detail |
| --- | --- |
| Prioritas | High |
| Langkah | GET `/reports?date_from=YYYY-MM-DD&date_to=YYYY-MM-DD` |
| Expected Result | Total order, total pendapatan, rata-rata order, dan daily revenue hanya menghitung order dalam rentang tanggal |
| Status | Not Run |

### DEV-HIST-001 Transaction History Filter

| Item | Detail |
| --- | --- |
| Prioritas | High |
| Langkah | GET `/transaction-history` dengan parameter `search`, `status`, `date_from`, `date_to` |
| Expected Result | Hasil riwayat sesuai gabungan filter |
| Status | Not Run |

### DEV-SET-001 Admin Store Pegawai

| Item | Detail |
| --- | --- |
| Prioritas | Critical |
| Langkah | Login admin, POST `/settings/users` dengan data pegawai valid |
| Expected Result | User dibuat dengan role `pegawai`, password ter-hash, username dinormalisasi |
| Status | Not Run |

### DEV-SET-002 Pegawai Dibatasi dari Settings

| Item | Detail |
| --- | --- |
| Prioritas | High |
| Langkah | Login sebagai pegawai, akses `/settings` |
| Expected Result | Redirect ke dashboard dengan flash error |
| Status | Not Run |

## 8. Checklist Code Review Internal

| Area | Checklist | Status |
| --- | --- | --- |
| Route | Semua route utama tersedia dan tidak bentrok | Not Run |
| Validasi | Field wajib, tipe file, status enum, dan payment tervalidasi | Not Run |
| Database | Create/update order dan customer memakai transaksi saat perlu | Not Run |
| Upload | File hanya image JPG/PNG dan ukuran maksimal 5 MB | Not Run |
| Security | Password di-hash oleh model/cast/mutator Laravel | Not Run |
| Authorization | Route admin-only benar-benar dibatasi | Not Run |
| Session | Login, logout, dan reset password membersihkan session yang tepat | Not Run |
| Error Handling | Invalid input memberi pesan error yang bisa dipahami | Not Run |
| UI | Modal, dropdown, dan form responsive | Not Run |
| Regression | Fitur lama tetap berjalan setelah perubahan | Not Run |

## 9. Area Temuan Teknis yang Perlu Diverifikasi

| Area | Risiko | Rekomendasi |
| --- | --- | --- |
| Proteksi route internal | Route dashboard/order/customer/report/settings perlu dipastikan tidak bisa diakses guest | Tambahkan middleware auth/session check bila belum ada |
| Admin-only report | Halaman laporan tertulis admin only, perlu dipastikan logic aksesnya sesuai | Uji login pegawai terhadap `/reports` |
| Reset password | Reset berbasis session tanpa token email | Pakai token reset Laravel bila masuk production |
| Edit order cash | Nominal cash saat edit tidak menolak nilai kurang dari harga layanan | Samakan validasi edit dengan create bila aturan bisnis mewajibkan |
| Search pelanggan | Input search pelanggan terlihat belum memfilter data | Tambahkan filter client-side/server-side bila memang dibutuhkan |
| Frontend build | `node_modules` belum tersedia | Jalankan `npm install` lalu `npm run build` |

## 10. Template Rekap Internal Testing

| Tanggal | Modul | Test Case | Penguji | Status | Bukti | Catatan |
| --- | --- | --- | --- | --- | --- | --- |
| 14 Juli 2026 | Automated Test | `composer test` | Pengembang | Pass | 2 tests passed | Test bawaan Laravel berjalan |
|  | Auth | DEV-AUTH-001 |  | Not Run |  |  |
|  | Order | DEV-ORDER-001 |  | Not Run |  |  |
|  | Customer | DEV-CUS-003 |  | Not Run |  |  |
|  | Report | DEV-REP-001 |  | Not Run |  |  |
|  | Settings | DEV-SET-001 |  | Not Run |  |  |

## 11. Kriteria Siap Diserahkan ke QA

Aplikasi dianggap siap masuk QA manual jika:

- `composer test` pass.
- Migration berjalan tanpa error.
- Minimal smoke test login, tambah order, update status, tambah pelanggan, laporan, dan settings pass.
- Tidak ada error 500 pada route utama.
- Upload foto valid berhasil.
- Validasi input penting menolak data invalid.
- Build frontend berhasil atau asset frontend yang dipakai sudah tersedia.
- Temuan Critical dan High dari internal testing sudah diperbaiki atau dicatat dengan alasan jelas.

