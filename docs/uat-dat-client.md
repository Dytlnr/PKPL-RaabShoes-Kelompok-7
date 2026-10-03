# Dokumen DAT / UAT Klien - Website Raab Shoes

## 1. Informasi Dokumen

| Item | Keterangan |
| --- | --- |
| Nama aplikasi | Manajemen Raab Shoes |
| Jenis pengujian | DAT / UAT |
| DAT | Data Acceptance Test |
| UAT | User Acceptance Test |
| Penguji | Klien / user operasional Raab Shoes |
| Tujuan | Memastikan aplikasi sesuai kebutuhan bisnis yang diminta |
| Tanggal pengujian |  |
| Lokasi pengujian |  |

## 2. Tujuan UAT

UAT dilakukan untuk memastikan website Raab Shoes sudah sesuai dengan kebutuhan pengguna akhir, terutama untuk kegiatan operasional toko sehari-hari.

Pertanyaan utama UAT:

> Apakah aplikasi ini sudah sesuai dengan proses kerja dan kebutuhan Raab Shoes?

Jika seluruh fitur utama diterima, klien dapat menandatangani BA UAT sebagai tanda aplikasi disetujui.

## 3. Pihak yang Terlibat

| Peran | Nama | Tanggung Jawab |
| --- | --- | --- |
| Perwakilan Klien |  | Menjalankan pengujian dengan data asli |
| Admin Raab Shoes |  | Menguji fitur admin dan pengaturan akun |
| Pegawai/User Operasional |  | Menguji input order dan proses transaksi |
| Pengembang |  | Mendampingi, mencatat kendala, dan memperbaiki temuan |

## 4. Lingkup UAT

| Modul | Yang Diuji |
| --- | --- |
| Login | Admin/pegawai dapat masuk ke aplikasi |
| Dashboard | Statistik order dan pendapatan tampil sesuai data |
| Order | Input order, upload foto, pembayaran, edit, update status |
| WhatsApp | Ringkasan order dapat dikirim ke pelanggan |
| Pelanggan | Data pelanggan tersimpan dan bisa digunakan kembali |
| Member | Stempel dan reward pelanggan dihitung sesuai aturan |
| Laporan | Total order, pendapatan, dan export laporan sesuai kebutuhan |
| Riwayat Transaksi | Transaksi dapat dicari dan difilter |
| Pengaturan | Admin dapat membuat akun pegawai |

## 5. Data Uji

UAT sebaiknya memakai data asli atau data yang menyerupai data operasional Raab Shoes.

| Data | Contoh / Diisi Klien |
| --- | --- |
| Nama pelanggan |  |
| Nomor HP pelanggan |  |
| Jenis barang | Sepatu / Tas / Topi |
| Layanan | Fast Clean / Deep Clean / Repair / lainnya |
| Metode pembayaran | Cash / Transfer Bank / QRIS |
| Foto barang | Foto barang asli pelanggan |
| Status order | Baru / Diproses / Siap Diambil / Diambil |

## 6. Kriteria Penerimaan

Aplikasi dianggap diterima jika:

- User dapat login sesuai role.
- Order dapat dibuat menggunakan data pelanggan asli.
- Foto barang dapat di-upload.
- Pembayaran cash, transfer, dan QRIS sesuai kebutuhan operasional.
- Status order dapat diubah sesuai proses kerja toko.
- Pesan WhatsApp dapat digunakan untuk komunikasi pelanggan.
- Data pelanggan dan kartu member berjalan sesuai aturan.
- Dashboard dan laporan menampilkan data yang masuk akal.
- Tidak ada error kritis yang menghambat operasional utama.
- Klien menyatakan aplikasi sudah sesuai kebutuhan.

## 7. Skenario UAT

### UAT-001 Login Admin

| Item | Detail |
| --- | --- |
| Modul | Login |
| Skenario | Admin masuk ke aplikasi |
| Langkah | Buka halaman login, isi akun admin, klik login |
| Expected Result | Admin berhasil masuk ke dashboard |
| Status | Pass / Fail |
| Catatan Klien |  |

### UAT-002 Tambah Akun Pegawai

| Item | Detail |
| --- | --- |
| Modul | Pengaturan |
| Skenario | Admin membuat akun pegawai |
| Langkah | Buka Pengaturan, klik tambah akun, isi data pegawai, simpan |
| Expected Result | Akun pegawai berhasil dibuat dan dapat digunakan login |
| Status | Pass / Fail |
| Catatan Klien |  |

### UAT-003 Tambah Order Baru

| Item | Detail |
| --- | --- |
| Modul | Order |
| Skenario | User membuat order baru memakai data pelanggan asli |
| Langkah | Buka tambah order, isi pelanggan, barang, layanan, foto, pembayaran, simpan |
| Expected Result | Order tersimpan dengan status `Baru` |
| Status | Pass / Fail |
| Catatan Klien |  |

### UAT-004 Pembayaran Cash

| Item | Detail |
| --- | --- |
| Modul | Order |
| Skenario | User mencatat pembayaran tunai |
| Langkah | Pilih metode Cash, isi uang dibayar, simpan order |
| Expected Result | Total layanan, uang dibayar, dan kembalian sesuai |
| Status | Pass / Fail |
| Catatan Klien |  |

### UAT-005 Pembayaran QRIS / Transfer

| Item | Detail |
| --- | --- |
| Modul | Order |
| Skenario | User membuat order dengan pembayaran non-cash |
| Langkah | Pilih QRIS atau Transfer Bank saat membuat order |
| Expected Result | Order tersimpan tanpa wajib mengisi uang cash |
| Status | Pass / Fail |
| Catatan Klien |  |

### UAT-006 Update Status Order

| Item | Detail |
| --- | --- |
| Modul | Order |
| Skenario | User mengubah status order sesuai proses toko |
| Langkah | Buka daftar order, ubah status ke Diproses, Siap Diambil, atau Diambil |
| Expected Result | Status order berhasil berubah |
| Status | Pass / Fail |
| Catatan Klien |  |

### UAT-007 Kirim WhatsApp Pelanggan

| Item | Detail |
| --- | --- |
| Modul | WhatsApp |
| Skenario | User mengirim ringkasan order ke pelanggan |
| Langkah | Klik tombol Kirim WhatsApp pada order |
| Expected Result | WhatsApp terbuka dengan nomor dan pesan order yang sesuai |
| Status | Pass / Fail |
| Catatan Klien |  |

### UAT-008 Data Pelanggan

| Item | Detail |
| --- | --- |
| Modul | Pelanggan |
| Skenario | Data pelanggan tersimpan dari order |
| Langkah | Buat order baru, lalu buka halaman pelanggan |
| Expected Result | Data pelanggan tampil di daftar pelanggan |
| Status | Pass / Fail |
| Catatan Klien |  |

### UAT-009 Kartu Member dan Reward

| Item | Detail |
| --- | --- |
| Modul | Member |
| Skenario | Klien mengecek aturan stempel dan reward |
| Langkah | Cek pelanggan dengan order selesai, lihat progress stempel dan reward |
| Expected Result | Setiap 8 order selesai menghasilkan 1 reward |
| Status | Pass / Fail |
| Catatan Klien |  |

### UAT-010 Dashboard

| Item | Detail |
| --- | --- |
| Modul | Dashboard |
| Skenario | Klien mengecek ringkasan operasional |
| Langkah | Buka dashboard setelah ada order |
| Expected Result | Total order, pendapatan, status order, dan layanan terlaris tampil sesuai data |
| Status | Pass / Fail |
| Catatan Klien |  |

### UAT-011 Laporan

| Item | Detail |
| --- | --- |
| Modul | Laporan |
| Skenario | Klien mengecek laporan transaksi |
| Langkah | Buka laporan, pilih rentang tanggal, export laporan |
| Expected Result | Laporan tampil sesuai periode dan bisa diexport |
| Status | Pass / Fail |
| Catatan Klien |  |

### UAT-012 Riwayat Transaksi

| Item | Detail |
| --- | --- |
| Modul | Riwayat Transaksi |
| Skenario | Klien mencari transaksi |
| Langkah | Buka riwayat transaksi, cari nama/order, filter status/tanggal |
| Expected Result | Data transaksi yang tampil sesuai pencarian/filter |
| Status | Pass / Fail |
| Catatan Klien |  |

## 8. Rekap Hasil UAT

| No | Test Case | Modul | Status | Catatan |
| --- | --- | --- | --- | --- |
| 1 | UAT-001 | Login |  |  |
| 2 | UAT-002 | Pengaturan |  |  |
| 3 | UAT-003 | Order |  |  |
| 4 | UAT-004 | Pembayaran Cash |  |  |
| 5 | UAT-005 | QRIS/Transfer |  |  |
| 6 | UAT-006 | Status Order |  |  |
| 7 | UAT-007 | WhatsApp |  |  |
| 8 | UAT-008 | Pelanggan |  |  |
| 9 | UAT-009 | Member/Reward |  |  |
| 10 | UAT-010 | Dashboard |  |  |
| 11 | UAT-011 | Laporan |  |  |
| 12 | UAT-012 | Riwayat Transaksi |  |  |

Keterangan status:

| Status | Arti |
| --- | --- |
| Pass | Fitur diterima klien |
| Fail | Fitur belum sesuai dan perlu diperbaiki |
| Pending | Belum diuji atau menunggu data/konfirmasi |

## 9. Daftar Temuan UAT

| No | Modul | Temuan | Prioritas | Tindak Lanjut | Status |
| --- | --- | --- | --- | --- | --- |
| 1 |  |  | High / Medium / Low |  | Open / Closed |
| 2 |  |  | High / Medium / Low |  | Open / Closed |
| 3 |  |  | High / Medium / Low |  | Open / Closed |

## 10. Keputusan UAT

Pilih salah satu:

| Keputusan | Keterangan | Tanda |
| --- | --- | --- |
| Diterima tanpa revisi | Aplikasi sudah sesuai dan dapat digunakan |  |
| Diterima dengan catatan minor | Aplikasi dapat digunakan, catatan minor diperbaiki setelah UAT |  |
| Belum diterima | Ada fitur utama yang belum sesuai dan harus diperbaiki dulu |  |

## 11. Berita Acara UAT

Pada hari ini, tanggal ____________, telah dilakukan User Acceptance Test (UAT) / Data Acceptance Test (DAT) untuk aplikasi Manajemen Raab Shoes.

Berdasarkan hasil pengujian oleh pihak klien/user, aplikasi dinyatakan:

```text
[  ] DITERIMA
[  ] DITERIMA DENGAN CATATAN
[  ] BELUM DITERIMA
```

Catatan:

```text



```

## 12. Tanda Tangan

| Pihak | Nama | Jabatan | Tanda Tangan | Tanggal |
| --- | --- | --- | --- | --- |
| Klien / User |  |  |  |  |
| Pengembang |  |  |  |  |

