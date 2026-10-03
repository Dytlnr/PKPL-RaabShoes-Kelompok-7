# Registrasi Admin Pertama — RaabShoes

Peran praktikum: Administrator (Admin). Dokumen pendamping ini menjelaskan fitur Register untuk Test Plan dan sumber kebutuhan awal. Ini bukan pernyataan bahwa seluruh Modul 2–6 telah terpenuhi; ketentuannya belum tersedia.

## Kebutuhan dan aturan bisnis

- REG-01: Register hanya tersedia bila belum ada Admin dan setup belum selesai.
- REG-02: Nama, username, email, nomor HP, password, dan konfirmasi wajib diisi. Username dan email unik. Username menerima huruf ASCII, angka, minus, underscore; disimpan lowercase. Email di-trim dan disimpan lowercase.
- REG-03: Password 8–16 karakter, konfirmasi sama, disimpan sebagai hash. Nama/username/email maksimal 255 karakter; nomor HP maksimal 30 karakter.
- REG-04: Role akun hasil registrasi selalu Admin, ditetapkan server. Setelah berhasil pengguna diarahkan ke Login.
- REG-05: Registrasi ditutup setelah berhasil, termasuk permintaan POST langsung atau form lama. Klaim setup atomik berada dalam transaksi database bersama pembuatan akun.
- REG-06: Akun lama dipertahankan. Jika Admin sudah ada ketika migration dijalankan, setup langsung ditutup. Tidak ada pembuatan Admin default otomatis.
- REG-07: Akun Pegawai tetap dibuat melalui Pengaturan oleh Admin.

## Pemetaan ke Test Plan

Bagian 1.2, Register: Admin pertama membuat akun saat setup awal melalui nama, username, email, nomor HP, password dan konfirmasi. Setelah sukses, registrasi ditutup.

Bagian 1.3: Pilih Administrator secara konsisten. Register diuji sebagai calon Admin pada kondisi sebelum setup selesai; fitur operasional diuji setelah login sebagai Admin.

Bagian 1.4 dan 4.4: Siapkan database pengujian terpisah tanpa Admin dan dengan setup belum selesai untuk kasus registrasi sukses. Siapkan kondisi dengan Admin untuk pengujian penolakan registrasi berikutnya. Jangan menghapus akun/data toko untuk mengulang pengujian.

Bagian 2: Risiko yang relevan adalah Admin ganda akibat pengiriman berulang, password tidak memenuhi aturan, dan pendaftaran tetap terbuka setelah setup. Skor dampak dan kemungkinan ditentukan dalam Test Plan proyek.

Bagian 3.1/3.2 serta jadwal/luaran Modul 2–6 dan UAP tetap mengikuti placeholder template Modul 1. Skenario di bawah adalah dokumentasi verifikasi implementasi, bukan penetapan teknik praktikum yang belum diajarkan.

## Skenario verifikasi

| ID | Kondisi/input | Hasil yang diharapkan |
| --- | --- | --- |
| REG-T01 | Belum ada Admin, data lengkap valid | Admin dibuat, password hash, redirect login |
| REG-T02 | Login menggunakan akun hasil registrasi | Dashboard dapat diakses |
| REG-T03 | Field wajib kosong | Pesan validasi; akun tidak dibuat; setup tetap terbuka |
| REG-T04 | Email tidak valid, username mengandung spasi | Ditolak |
| REG-T05 | Email/username sudah digunakan akun Pegawai | Ditolak sebagai duplikat |
| REG-T06 | Password 7 atau 17 karakter | Ditolak |
| REG-T07 | Password 8 atau 16 karakter dan konfirmasi sama | Diterima pada setup baru |
| REG-T08 | Konfirmasi password berbeda | Ditolak; password tidak diisi ulang dalam form |
| REG-T09 | Admin sudah ada; GET/POST register langsung | Form ditutup; tidak ada Admin tambahan |
| REG-T10 | Kirim ulang form yang sebelumnya berhasil | Ditolak; hanya satu akun hasil setup |
| REG-T11 | Klaim setup sudah selesai, Admin dihapus pada database tes | Registrasi tetap tertutup |
| REG-T12 | Login/lupa password pada database tanpa Admin | Tidak membuat akun default |
| REG-T13 | Kirim role lain dari klien | Akun hasil registrasi tetap Admin |

## Menjalankan verifikasi otomatis

`php artisan test --filter=InitialAdminRegistrationTest`

Tes menggunakan SQLite in-memory dan RefreshDatabase sesuai phpunit.xml. Data toko tidak diperlukan. Pengujian paralel HTTP sesungguhnya dan tampilan browser belum dicakup oleh suite ini.

Untuk demo manual, gunakan instalasi dan database khusus praktikum, jalankan migration tanpa memasukkan akun Admin terlebih dahulu, kemudian buka `/register`. Pada database toko yang sudah mempunyai Admin, tampilan registrasi tertutup adalah hasil yang benar.

## Batas pekerjaan ini

Perubahan ini menyelesaikan alur Register Admin pertama. Forgot Password yang sudah ada masih berbasis identitas dan session tanpa verifikasi kepemilikan akun; proteksi akses seluruh route operasional juga masih perlu ditinjau. Keduanya tidak boleh dinyatakan selesai hanya berdasarkan tes registrasi.

## Hasil verifikasi implementasi — 1 Oktober 2026

- `php artisan test`: 34 tes lolos, 234 assertions, menggunakan database tes SQLite in-memory.
- Migration database lokal belum berhasil: MySQL `127.0.0.1:8889` menolak koneksi.
- Setelah MySQL aktif, jalankan dari folder proyek: `php artisan migrate --path=database/migrations/2026_10_01_000001_create_admin_registration_table.php`.
- Browser manual dan konkurensi HTTP belum diuji. Tes otomatis memverifikasi bahwa klaim setup tidak dapat dipakai ulang.

## Demo berulang lewat browser

Profil lokal khusus praktikum sekarang tersedia dan memakai SQLite `storage/praktikum/database.sqlite`, kunci aplikasi tersendiri, serta cookie sesi `raabshoes_praktikum_session`. File `.env` utama tidak diubah. Tidak perlu MySQL. Jangan gunakan profil database toko untuk demo reset.

Dari folder `manajement-raabshoes`, siapkan sekali:

```bash
php praktikum.php prepare
```

Perintah prepare hanya menjalankan migration yang belum diterapkan; tidak menghapus data atau mereset akun. Jalankan kembali setelah ada migration baru.

Jalankan server:

```bash
php praktikum.php serve
```

Buka `http://127.0.0.1:8010/register`. Halaman menampilkan penanda Mode Praktikum. Daftarkan Admin, login, lalu buka Register lagi untuk membuktikan pendaftaran berikutnya ditutup.

Untuk mengulang demo:

1. Simpan screenshot/bukti hasil uji.
2. Hentikan server praktikum dengan Ctrl+C agar tidak ada request aktif ketika reset.
3. Jalankan `php praktikum.php reset`.
4. Jalankan `php praktikum.php serve` kembali.
5. Buka ulang `/register` atau refresh halaman. Jangan submit form lama karena token CSRF sesi sebelumnya sudah tidak berlaku.

Reset menghapus SEMUA akun Admin/Pegawai demo, sesi login demo, dan token reset password demo, lalu membuka setup Admin pertama. Order dan pelanggan demo tetap tersimpan. Reset bukan penghapusan seluruh database. Perintah dapat diulang dan tidak tersedia sebagai endpoint/tombol web.

Pengaman memeriksa environment praktikum, driver SQLite, lokasi file yang ditentukan, koneksi database aktif, konfigurasi sesi terpisah, serta menolak file symlink/hardlink. Menjalankan `php artisan praktikum:reset-registration` pada profil utama akan ditolak. Jangan mengarahkan aplikasi utama ke file SQLite praktikum.

Profil ini ditujukan untuk demo registrasi lokal pada port 8010. Kode aplikasi dan aset masih sama dengan web utama; ini bukan salinan terisolasi penuh untuk pengujian upload atau integrasi. Google login dinonaktifkan pada profil ini; email menggunakan log.

Validasi terbaru: 37 tes lolos (249 assertions), termasuk reset berulang, penghapusan akun/sesi demo, pemeliharaan pelanggan, dan penolakan reset pada profil utama atau database/cookie yang berbeda. Halaman `/register` server praktikum merespons HTTP 200. Tampilan visual belum diperiksa secara manual di browser.
