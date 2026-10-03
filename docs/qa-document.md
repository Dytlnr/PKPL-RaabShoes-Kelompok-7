# Dokumen QA Website Raab Shoes

## 1. Informasi Dokumen

| Item | Keterangan |
| --- | --- |
| Nama aplikasi | Manajemen Raab Shoes |
| Jenis aplikasi | Website operasional laundry/perawatan sepatu, tas, dan topi |
| Framework | Laravel |
| Lingkup QA | Login, dashboard, order, pelanggan/member, laporan, riwayat transaksi, pengaturan akun |
| Tipe pengujian | Manual functional test, UI smoke test, validasi data, regression checklist |
| Status dokumen | Draft siap pakai |

## 2. Tujuan QA

Dokumen ini digunakan untuk memastikan fitur utama website Raab Shoes berjalan sesuai kebutuhan operasional toko:

- Admin dan pegawai dapat masuk ke sistem.
- Order dapat dibuat, dicari, difilter, diedit, dan diubah statusnya.
- Data pelanggan otomatis tersimpan dan kartu member menghitung reward dengan benar.
- Dashboard, laporan, dan riwayat transaksi menampilkan data yang konsisten.
- Pengaturan akun pegawai hanya dapat dikelola admin.
- Alur pembayaran cash, transfer, dan QRIS berjalan sesuai tampilan dan validasi.

## 3. Role dan Hak Akses

| Role | Akses yang Diharapkan |
| --- | --- |
| Admin | Login, dashboard, order, pelanggan, layanan, laporan, riwayat transaksi, pengaturan akun pegawai, ganti password |
| Pegawai | Login, dashboard, order, pelanggan, layanan, riwayat transaksi, ganti password |
| Guest | Halaman login, forgot password, reset password bila session reset valid |

Catatan QA: perlu diuji khusus bahwa halaman pengaturan akun pegawai dan laporan tidak dapat diakses pegawai bila aturan bisnisnya adalah admin only.

## 4. Environment Pengujian

| Komponen | Kebutuhan |
| --- | --- |
| Browser | Chrome terbaru, Firefox terbaru, Safari/mobile browser |
| Device | Desktop 1366px, tablet, mobile 390px |
| Database | Data migration sudah berjalan |
| Storage upload | Folder `public/uploads/order-photos` bisa ditulis |
| QRIS | File `public/images/qris-raabshoes.jpg` tersedia bila QRIS ingin tampil |
| Kamera | Browser mengizinkan permission kamera untuk test ambil foto |

## 5. Data Uji

| Data | Nilai Contoh |
| --- | --- |
| Admin default | `admin@raabshoes.com` / `admin12345` |
| Pegawai | Buat dari menu Pengaturan |
| Pelanggan baru | Budi Santoso, `081234567890`, Jl. Mawar No. 10 |
| Pelanggan lama | Gunakan nomor HP yang sama dengan pelanggan yang sudah tersimpan |
| Barang | Sepatu, Tas, Topi |
| Layanan | Fast Clean - Easy, Deep Clean - Reguler, Reglue, Bag/Tas - Medium, Hat |
| Pembayaran | Cash (Tunai), Transfer Bank, QRIS |
| Status order | Baru, Diproses, Siap Diambil, Diambil |
| File foto valid | JPG/PNG ukuran di bawah 5 MB |
| File foto tidak valid | PDF/TXT atau image di atas 5 MB |

## 6. Kriteria Severity Bug

| Severity | Definisi | Contoh |
| --- | --- | --- |
| Critical | Fitur utama tidak bisa digunakan atau data rusak | Order tidak tersimpan, login selalu gagal |
| High | Alur penting terganggu, ada workaround sulit | Upload foto gagal di semua browser |
| Medium | Fitur minor/validasi/tampilan mengganggu | Filter status tidak akurat |
| Low | Kosmetik, typo, layout minor | Spasi teks tidak rapi |

## 7. Test Case Functional

### AUTH-001 Login Admin Valid

| Item | Detail |
| --- | --- |
| Prioritas | High |
| Precondition | Akun admin tersedia |
| Langkah | Buka `/login`, isi email/username admin dan password benar, klik login |
| Expected Result | User diarahkan ke dashboard dan muncul pesan berhasil login |

### AUTH-002 Login dengan Password Salah

| Item | Detail |
| --- | --- |
| Prioritas | High |
| Langkah | Buka `/login`, isi email/username valid dan password salah, submit |
| Expected Result | Tetap di halaman login, muncul pesan `Email/username atau password salah.` |

### AUTH-003 Login Menggunakan Username

| Item | Detail |
| --- | --- |
| Prioritas | Medium |
| Langkah | Isi field login dengan username admin/pegawai, isi password benar, submit |
| Expected Result | Login berhasil dan session user sesuai akun tersebut |

### AUTH-004 Forgot Password Akun Terdaftar

| Item | Detail |
| --- | --- |
| Prioritas | High |
| Langkah | Buka `/forgot-password`, isi email/username terdaftar, submit |
| Expected Result | Diarahkan ke `/reset-password` dan muncul pesan akun ditemukan |

### AUTH-005 Reset Password Valid

| Item | Detail |
| --- | --- |
| Prioritas | High |
| Precondition | Sudah melewati forgot password |
| Langkah | Isi password baru minimal 8 karakter dan konfirmasi sama, submit |
| Expected Result | Password berubah, user diarahkan ke login, login dengan password baru berhasil |

### AUTH-006 Reset Password Tanpa Session

| Item | Detail |
| --- | --- |
| Prioritas | Medium |
| Langkah | Buka langsung `/reset-password` tanpa proses forgot password |
| Expected Result | User diarahkan ke forgot password dan muncul pesan harus isi email/username dulu |

### AUTH-007 Register Admin Pertama

| Item | Detail |
| --- | --- |
| Prioritas | Critical |
| Precondition | Database pengujian terpisah, migration sudah dijalankan, belum ada Admin, setup belum selesai |
| Langkah | Buka `/register`, isi nama, username unik, email valid unik, nomor HP, password 8–16 karakter dan konfirmasi sama; submit lalu login |
| Expected Result | Satu akun ber-role admin dibuat dengan password hash; diarahkan ke login; login berhasil; registrasi berikutnya ditutup |

Skenario negatif, batas input, dan pengiriman ulang terdapat di `docs/pkpl/registrasi-admin-pertama.md`.

### AUTH-008 Logout

| Item | Detail |
| --- | --- |
| Prioritas | High |
| Langkah | Login, klik logout |
| Expected Result | Session keluar dan user diarahkan ke halaman login |

### DASH-001 Dashboard Statistik Awal

| Item | Detail |
| --- | --- |
| Prioritas | High |
| Precondition | Database kosong |
| Langkah | Login dan buka `/dashboard` |
| Expected Result | Semua angka statistik tampil 0, chart menampilkan empty state, tidak ada error |

### DASH-002 Dashboard Setelah Ada Order

| Item | Detail |
| --- | --- |
| Prioritas | High |
| Precondition | Minimal 1 order dibuat hari ini |
| Langkah | Buka dashboard |
| Expected Result | Total order hari ini bertambah, pendapatan hari ini sesuai harga layanan, layanan terlaris tampil |

### DASH-003 Perhitungan Status Dashboard

| Item | Detail |
| --- | --- |
| Prioritas | High |
| Langkah | Buat order, ubah status ke Diproses, Siap Diambil, dan Diambil secara bertahap |
| Expected Result | Order Dalam Proses, Siap Diambil, dan Order Tuntas berubah sesuai status terbaru |

### ORD-001 Tambah Order Cash Valid

| Item | Detail |
| --- | --- |
| Prioritas | Critical |
| Langkah | Buka `/orders/create`, isi data pelanggan, barang, layanan, upload foto JPG/PNG, pilih Cash, isi uang dibayar >= total layanan, simpan |
| Expected Result | Order tersimpan dengan status `Baru`, pelanggan dibuat/diupdate, harga layanan tersimpan, kembalian dihitung benar |

### ORD-002 Tambah Order Cash Kurang dari Total

| Item | Detail |
| --- | --- |
| Prioritas | High |
| Langkah | Pilih layanan Rp 30.000, pilih Cash, isi uang dibayar Rp 20.000, simpan |
| Expected Result | Order tidak tersimpan dan muncul error nominal uang dibayar tidak boleh kurang dari total layanan |

### ORD-003 Tambah Order Cash Tanpa Nominal

| Item | Detail |
| --- | --- |
| Prioritas | High |
| Langkah | Pilih Cash tetapi kosongkan uang dibayar, simpan |
| Expected Result | Order tidak tersimpan dan muncul error nominal uang dibayar wajib diisi |

### ORD-004 Tambah Order Transfer Bank

| Item | Detail |
| --- | --- |
| Prioritas | High |
| Langkah | Isi order valid, pilih Transfer Bank, upload foto, simpan |
| Expected Result | Order tersimpan, cash paid dan cash change kosong/null, status `Baru` |

### ORD-005 Tambah Order QRIS

| Item | Detail |
| --- | --- |
| Prioritas | High |
| Langkah | Pilih QRIS saat tambah order |
| Expected Result | Panel QRIS tampil, nominal QRIS sesuai harga layanan, order tersimpan setelah form valid |

### ORD-006 Upload Foto Valid

| Item | Detail |
| --- | --- |
| Prioritas | Critical |
| Langkah | Upload file JPG/PNG di bawah 5 MB saat tambah order |
| Expected Result | Preview foto muncul dan file tersimpan di `public/uploads/order-photos` setelah submit |

### ORD-007 Upload Foto Tidak Valid

| Item | Detail |
| --- | --- |
| Prioritas | High |
| Langkah | Upload PDF/TXT atau image lebih dari 5 MB, submit |
| Expected Result | Order tidak tersimpan dan validasi file muncul |

### ORD-008 Ambil Foto dari Kamera

| Item | Detail |
| --- | --- |
| Prioritas | Medium |
| Langkah | Klik Ambil Foto Sekarang, nyalakan kamera, ambil jepretan, simpan order |
| Expected Result | Browser meminta permission, hasil jepretan tampil sebagai preview, file terkirim sebagai foto order |

### ORD-009 Pilih Pelanggan Lama

| Item | Detail |
| --- | --- |
| Prioritas | Medium |
| Precondition | Ada pelanggan tersimpan |
| Langkah | Di form order, cari pelanggan lama dari datalist |
| Expected Result | Nama, nomor HP, dan alamat pelanggan terisi sesuai data yang dipilih |

### ORD-010 Daftar Order Tampil

| Item | Detail |
| --- | --- |
| Prioritas | High |
| Precondition | Minimal 1 order tersedia |
| Langkah | Buka `/orders` |
| Expected Result | Kode order, nama, nomor HP, tanggal, barang, layanan, kondisi, merek, status, tombol WhatsApp, dan edit order tampil |

### ORD-011 Cari Order

| Item | Detail |
| --- | --- |
| Prioritas | High |
| Langkah | Cari berdasarkan order code, nama pelanggan, dan nomor HP |
| Expected Result | Daftar order hanya menampilkan data yang cocok |

### ORD-012 Filter Status Order

| Item | Detail |
| --- | --- |
| Prioritas | High |
| Langkah | Pilih filter Baru, Diproses, Siap Diambil, Diambil |
| Expected Result | Daftar order hanya menampilkan status yang dipilih |

### ORD-013 Ubah Status dari Daftar Order

| Item | Detail |
| --- | --- |
| Prioritas | Critical |
| Langkah | Di kartu order, ubah dropdown status dari Baru ke Diproses |
| Expected Result | Status tersimpan, badge status berubah, flash message berhasil muncul |

### ORD-014 Edit Order

| Item | Detail |
| --- | --- |
| Prioritas | Critical |
| Langkah | Klik Edit Order, ubah nama, layanan, metode pembayaran, status, simpan |
| Expected Result | Data order berubah, harga layanan mengikuti layanan terbaru, data pelanggan ikut terupdate |

### ORD-015 WhatsApp untuk Status Baru/Diproses

| Item | Detail |
| --- | --- |
| Prioritas | Medium |
| Langkah | Klik Kirim WhatsApp pada order status Baru atau Diproses |
| Expected Result | Browser membuka `wa.me` dengan nomor pelanggan format internasional dan pesan ringkasan order |

### ORD-016 WhatsApp untuk Status Siap Diambil

| Item | Detail |
| --- | --- |
| Prioritas | Medium |
| Langkah | Ubah status ke Siap Diambil, klik Kirim WhatsApp |
| Expected Result | Pesan WhatsApp berisi informasi pesanan siap diambil dan estimasi pengambilan bila tersedia |

### CUS-001 Tambah Pelanggan Baru

| Item | Detail |
| --- | --- |
| Prioritas | High |
| Langkah | Buka `/customers`, klik Tambah Pelanggan, isi nama dan nomor HP, simpan |
| Expected Result | Pelanggan tersimpan dengan customer code dan member code, tampil di daftar pelanggan |

### CUS-002 Tambah Pelanggan Nomor Sama

| Item | Detail |
| --- | --- |
| Prioritas | Medium |
| Langkah | Tambah pelanggan dengan nomor HP yang sudah ada tetapi nama/alamat berbeda |
| Expected Result | Data pelanggan lama terupdate, tidak membuat duplikasi berdasarkan nomor HP |

### CUS-003 Validasi Pelanggan Wajib

| Item | Detail |
| --- | --- |
| Prioritas | High |
| Langkah | Submit tambah pelanggan tanpa nama atau nomor HP |
| Expected Result | Data tidak tersimpan dan pesan validasi tampil |

### CUS-004 Perhitungan Stempel Member

| Item | Detail |
| --- | --- |
| Prioritas | Critical |
| Langkah | Buat 8 order untuk pelanggan sama, ubah status masing-masing ke Siap Diambil atau Diambil |
| Expected Result | Stempel aktif menjadi 8/8 dan available reward menjadi 1 |

### CUS-005 Order Status Belum Selesai Tidak Menambah Stempel

| Item | Detail |
| --- | --- |
| Prioritas | High |
| Langkah | Buat order status Baru/Diproses untuk pelanggan |
| Expected Result | Stempel member tidak bertambah |

### CUS-006 Klaim Reward

| Item | Detail |
| --- | --- |
| Prioritas | Critical |
| Precondition | Pelanggan punya available reward minimal 1 |
| Langkah | Klik Klaim 1 Free Service |
| Expected Result | Reward redemptions bertambah 1, available reward berkurang, progress stempel dihitung ulang |

### CUS-007 Riwayat Stempel

| Item | Detail |
| --- | --- |
| Prioritas | Medium |
| Langkah | Klik angka stempel pelanggan |
| Expected Result | Modal menampilkan order yang statusnya Siap Diambil/Diambil beserta layanan, status, dan waktu |

### REP-001 Laporan Tanpa Filter

| Item | Detail |
| --- | --- |
| Prioritas | High |
| Langkah | Buka `/reports` |
| Expected Result | Total order, total pendapatan, rata-rata order, pendapatan harian, dan layanan terlaris tampil berdasarkan semua order |

### REP-002 Filter Laporan per Tanggal

| Item | Detail |
| --- | --- |
| Prioritas | High |
| Langkah | Isi Dari Tanggal dan Sampai Tanggal, submit/export |
| Expected Result | Data laporan hanya menghitung order dalam rentang tanggal tersebut |

### REP-003 Export PDF/HTML Laporan

| Item | Detail |
| --- | --- |
| Prioritas | Medium |
| Langkah | Klik Export PDF dari halaman laporan |
| Expected Result | Tab baru membuka halaman export berisi daftar order, total order, total pendapatan, dan rata-rata order sesuai filter |

### HIST-001 Riwayat Transaksi Tanpa Filter

| Item | Detail |
| --- | --- |
| Prioritas | High |
| Langkah | Buka `/transaction-history` |
| Expected Result | Semua transaksi tampil dari terbaru, berisi kode order, pelanggan, pembayaran, dan status |

### HIST-002 Filter Riwayat Berdasarkan Status

| Item | Detail |
| --- | --- |
| Prioritas | High |
| Langkah | Pilih status Diproses atau Diambil |
| Expected Result | Riwayat hanya menampilkan order dengan status tersebut |

### HIST-003 Search dan Date Range Riwayat

| Item | Detail |
| --- | --- |
| Prioritas | High |
| Langkah | Cari nama/order code/nomor HP lalu isi date range |
| Expected Result | Riwayat menampilkan hasil gabungan search dan rentang tanggal |

### SET-001 Admin Melihat Daftar Akun

| Item | Detail |
| --- | --- |
| Prioritas | High |
| Langkah | Login sebagai admin, buka `/settings` |
| Expected Result | Daftar user tampil, admin berada di urutan atas, role badge tampil benar |

### SET-002 Tambah Akun Pegawai Valid

| Item | Detail |
| --- | --- |
| Prioritas | Critical |
| Langkah | Klik Tambah Akun, isi nama, username, email, nomor HP, password dan konfirmasi, simpan |
| Expected Result | Akun pegawai dibuat dengan role `pegawai` dan dapat login |

### SET-003 Normalisasi Username Pegawai

| Item | Detail |
| --- | --- |
| Prioritas | Medium |
| Langkah | Isi username `Pegawai Baru 01`, simpan |
| Expected Result | Username tersimpan menjadi format alpha dash lowercase, misalnya `pegawai-baru-01` |

### SET-004 Validasi Unik Username dan Email

| Item | Detail |
| --- | --- |
| Prioritas | High |
| Langkah | Tambah pegawai dengan username/email yang sudah ada |
| Expected Result | Akun tidak dibuat dan pesan validasi unique muncul |

### SET-005 Pegawai Tidak Bisa Kelola Akun

| Item | Detail |
| --- | --- |
| Prioritas | High |
| Langkah | Login sebagai pegawai, akses `/settings` dan submit `/settings/users` |
| Expected Result | Pegawai diarahkan kembali ke dashboard dengan pesan hanya admin yang bisa mengelola akun pegawai |

### UI-001 Responsive Desktop

| Item | Detail |
| --- | --- |
| Prioritas | Medium |
| Langkah | Buka dashboard, orders, customers, reports di viewport 1366px |
| Expected Result | Card, chart, form, modal, dan list tidak overlap serta mudah dibaca |

### UI-002 Responsive Mobile

| Item | Detail |
| --- | --- |
| Prioritas | High |
| Langkah | Buka halaman utama di viewport 390px |
| Expected Result | Layout menjadi satu kolom, tombol penuh sesuai container, teks tidak keluar elemen |

### UI-003 Modal dan Dropdown

| Item | Detail |
| --- | --- |
| Prioritas | Medium |
| Langkah | Buka modal tambah pelanggan, edit order, tambah akun, dropdown filter status |
| Expected Result | Modal/dropdown bisa dibuka dan ditutup, tidak menutupi konten secara permanen, form tetap bisa digunakan |

## 8. Regression Checklist

Jalankan checklist ini sebelum release:

- Login admin berhasil.
- Login pegawai berhasil.
- Login salah menampilkan error.
- Forgot password dan reset password berhasil.
- Tambah order cash berhasil.
- Tambah order cash kurang dari total ditolak.
- Tambah order transfer berhasil.
- Tambah order QRIS berhasil.
- Upload foto JPG/PNG berhasil.
- Upload file non-image ditolak.
- Search order berdasarkan nama, HP, dan order code berhasil.
- Filter order berdasarkan status berhasil.
- Edit order berhasil.
- Ubah status order berhasil.
- Link WhatsApp membuka URL `wa.me`.
- Pelanggan baru tersimpan.
- Pelanggan dari order otomatis tersimpan/terupdate.
- Stempel member bertambah hanya untuk status Siap Diambil/Diambil.
- Klaim reward mengurangi reward tersedia.
- Dashboard menghitung statistik sesuai data.
- Laporan menghitung total pendapatan sesuai harga layanan.
- Export laporan membuka halaman export.
- Riwayat transaksi bisa difilter berdasarkan status, tanggal, dan search.
- Admin bisa tambah akun pegawai.
- Pegawai tidak bisa tambah akun pegawai.
- Tampilan mobile tidak overlap.

## 9. Area Risiko yang Perlu Diperhatikan

- Proteksi route: pastikan halaman internal tidak bisa diakses guest tanpa login bila aplikasi dipakai production.
- Hak akses laporan: subtitle menyebut admin only, tetapi perlu dipastikan ada guard/logic yang benar-benar membatasi pegawai.
- Reset password: alur saat ini berbasis pencarian akun dan session, perlu ditinjau bila digunakan di production karena tidak memakai token email.
- Upload file: pastikan folder upload tidak menerima file berbahaya dan ukuran file sesuai batas.
- WhatsApp: nomor tanpa awalan `0` atau `62` perlu diuji karena format nomor sangat bergantung input pelanggan.
- Perhitungan revenue: revenue memakai harga berdasarkan nama layanan; bila nama layanan berubah atau harga dinamis dibutuhkan, hasil laporan bisa tidak sesuai.
- Edit order cash: saat edit, nominal cash yang lebih kecil dari harga layanan tidak ditolak, hanya kembalian dibuat 0. Perlu dikonfirmasi apakah ini sesuai aturan bisnis.
- Search pelanggan di halaman pelanggan saat ini hanya input tampilan; perlu diuji apakah memang belum ada filter client/server.

## 10. Template Bug Report

Gunakan tabel ini saat menemukan bug ketika menjalankan test case.

| Field | Isi |
| --- | --- |
| Bug ID | BUG-001 |
| Judul | Contoh: Order cash tetap tersimpan saat uang dibayar kurang dari total |
| Severity | Critical / High / Medium / Low |
| Priority | P1 / P2 / P3 |
| Environment | Local / Staging / Production |
| Browser/Device | Contoh: Chrome 126, MacBook / Safari iPhone |
| Precondition | Kondisi awal sebelum bug muncul |
| Steps to Reproduce | 1. Buka halaman ... 2. Isi ... 3. Klik ... |
| Actual Result | Hasil aktual yang terjadi |
| Expected Result | Hasil yang seharusnya terjadi |
| Evidence/Screenshot | Link/nama file screenshot atau screen recording |
| Data Uji | Data pelanggan/order/payment yang dipakai |
| Catatan | Informasi tambahan, dugaan penyebab, atau workaround |

## 11. Template Hasil Eksekusi Test

Status yang digunakan:

| Status | Arti |
| --- | --- |
| Pass | Test berhasil sesuai expected result |
| Fail | Test gagal dan perlu dibuat bug report |
| Blocked | Test belum bisa dijalankan karena ada blocker |
| Not Run | Test belum dijalankan |

Tabel eksekusi:

| Test Case ID | Modul | Tanggal | Tester | Status | Evidence | Catatan |
| --- | --- | --- | --- | --- | --- | --- |
| AUTH-001 | Login |  |  | Not Run |  |  |
| AUTH-002 | Login |  |  | Not Run |  |  |
| ORD-001 | Order |  |  | Not Run |  |  |
| ORD-013 | Order |  |  | Not Run |  |  |
| CUS-004 | Pelanggan/Member |  |  | Not Run |  |  |
| CUS-006 | Pelanggan/Member |  |  | Not Run |  |  |
| REP-002 | Laporan |  |  | Not Run |  |  |
| HIST-003 | Riwayat Transaksi |  |  | Not Run |  |  |
| SET-002 | Pengaturan |  |  | Not Run |  |  |
| UI-002 | Responsive UI |  |  | Not Run |  |  |

## Lingkungan demo registrasi praktikum

Gunakan `php praktikum.php prepare`, kemudian `php praktikum.php serve` untuk mengakses `http://127.0.0.1:8010/register`. Untuk mengulang, hentikan server (Ctrl+C), jalankan `php praktikum.php reset`, lalu jalankan server kembali dan buka ulang halaman. Reset menghapus seluruh akun dan sesi demo saja; order/pelanggan dipertahankan. Database SQLite praktikum dan cookie sesi terpisah dari profil utama. Detail pengaman dan skenario terdapat di [panduan registrasi](pkpl/registrasi-admin-pertama.md).
