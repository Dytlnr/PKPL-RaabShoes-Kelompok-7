# Technical Documentation - Website Raab Shoes

## 1. Informasi Dokumen

| Item | Keterangan |
| --- | --- |
| Nama sistem | Manajemen Raab Shoes |
| Jenis sistem | Website manajemen order, pelanggan, transaksi, dan laporan |
| Framework | Laravel 12 |
| Bahasa | PHP 8.2+, Blade, JavaScript |
| Database | MySQL/MariaDB |
| Target pembaca | Tim IT klien dan developer penerus |
| Tanggal dokumen | 14 Juli 2026 |

## 2. Tujuan

Dokumen ini menjadi panduan teknis singkat agar tim IT klien dapat memahami, meng-install, men-deploy, merawat, dan mengembangkan website Raab Shoes.

## 3. Ringkasan Sistem

Fitur utama sistem:

- Login admin dan pegawai.
- Dashboard statistik order dan pendapatan.
- Input order jasa sepatu, tas, dan topi.
- Upload foto barang order.
- Pembayaran cash, transfer bank, dan QRIS.
- Update status order: `Baru`, `Diproses`, `Siap Diambil`, `Diambil`.
- Kirim ringkasan order ke WhatsApp.
- Manajemen pelanggan dan kartu member.
- Laporan, export laporan, dan riwayat transaksi.
- Manajemen akun pegawai oleh admin.

## 4. Arsitektur Sistem

```text
Browser User
    -> Laravel Route (routes/web.php)
    -> Model Eloquent (app/Models)
    -> Database MySQL/MariaDB
    -> Blade View (resources/views)
    -> Browser User
```

Catatan implementasi:

- Logic utama saat ini banyak berada di `routes/web.php`.
- View menggunakan Blade di `resources/views`.
- Data utama dikelola lewat model `User`, `Customer`, dan `Order`.
- Foto order disimpan di `public/uploads/order-photos`.
- QRIS statis disimpan di `public/images/qris-raabshoes.jpg`.

## 5. Teknologi

| Komponen | Teknologi |
| --- | --- |
| Backend | Laravel 12 |
| Runtime | PHP 8.2+ |
| Dependency PHP | Composer |
| Frontend asset | Vite, NPM |
| Database | MySQL/MariaDB |
| Testing | PHPUnit / `composer test` |
| Social login | Laravel Socialite untuk Google |

## 6. Struktur Source Code

```text
manajement-raabshoes/
├── app/Models/                 # Model User, Customer, Order
├── config/                     # Konfigurasi Laravel
├── database/migrations/        # Struktur database
├── docs/                       # Dokumentasi proyek
├── public/images/              # Logo, QRIS, gambar auth
├── public/uploads/order-photos/ # Foto order
├── resources/views/            # Blade views
├── routes/web.php              # Route dan logic utama
├── storage/                    # Log, cache, compiled view
├── tests/                      # Automated tests
├── composer.json
├── package.json
└── .env
```

File penting:

| File | Fungsi |
| --- | --- |
| `routes/web.php` | Route, validasi, dan logic utama |
| `app/Models/User.php` | Akun admin/pegawai |
| `app/Models/Customer.php` | Data pelanggan dan logic member |
| `app/Models/Order.php` | Data order dan URL foto |
| `resources/views/layouts/admin.blade.php` | Layout admin |
| `database/migrations` | Struktur tabel database |

## 7. ERD Singkat

```text
users
  - akun admin/pegawai

customers
  id (PK)
  customer_code
  member_code
  phone
  reward_redemptions
      |
      | 1 customer punya banyak order
      v
orders
  id (PK)
  order_code
  customer_id (FK nullable -> customers.id)
  service
  service_price
  payment_method
  status
```

Relasi utama:

| Relasi | Keterangan |
| --- | --- |
| `Customer hasMany Order` | Satu pelanggan dapat memiliki banyak order |
| `Order belongsTo Customer` | Satu order dapat terhubung ke satu pelanggan |
| `orders.customer_id nullable` | Jika customer dihapus, order tetap ada |

## 8. Struktur Database

### 8.1 `users`

| Kolom Penting | Keterangan |
| --- | --- |
| `id` | Primary key |
| `name` | Nama user |
| `username` | Username login, unique |
| `email` | Email login, unique |
| `phone` | Nomor HP |
| `role` | `admin` atau `pegawai` |
| `password` | Password hash |

### 8.2 `customers`

| Kolom Penting | Keterangan |
| --- | --- |
| `id` | Primary key |
| `customer_code` | Kode pelanggan, unique |
| `member_code` | Kode member, unique |
| `name` | Nama pelanggan |
| `phone` | Nomor HP, unique |
| `address` | Alamat |
| `reward_redemptions` | Jumlah reward yang sudah diklaim |

Logic member:

- Order dengan status `Siap Diambil` atau `Diambil` dihitung sebagai stempel.
- Setiap 8 stempel menghasilkan 1 reward.
- Saat reward diklaim, `reward_redemptions` bertambah.

### 8.3 `orders`

| Kolom Penting | Keterangan |
| --- | --- |
| `id` | Primary key |
| `order_code` | Kode order, unique |
| `customer_id` | Foreign key ke customers, nullable |
| `customer_name`, `phone`, `address` | Snapshot data pelanggan |
| `item_type`, `color`, `condition`, `brand` | Detail barang |
| `service`, `service_price` | Layanan dan harga |
| `cash_paid`, `cash_change` | Data pembayaran cash |
| `photo_path`, `photo_name` | Foto order |
| `payment_method` | Cash, Transfer Bank, QRIS |
| `status` | Baru, Diproses, Siap Diambil, Diambil |

Tabel bawaan Laravel yang juga digunakan: `sessions`, `password_reset_tokens`, `cache`, `jobs`, dan `failed_jobs`.

## 9. Alur Bisnis Utama

| Alur | Ringkasan |
| --- | --- |
| Login | User login memakai email/username dan password, lalu session dibuat |
| Tambah order | Input data pelanggan, barang, layanan, foto, pembayaran, lalu order dibuat status `Baru` |
| Update status | Status order diubah dari daftar order |
| WhatsApp | Sistem redirect ke `wa.me` dengan pesan order |
| Member | 8 order selesai menghasilkan 1 reward gratis |
| Laporan | Sistem menghitung total order, pendapatan, rata-rata order, dan layanan terlaris |

## 10. Route / Endpoint Web

Sistem belum memakai API publik. Endpoint berikut adalah web route berbasis session dan CSRF.

| Method | URI | Fungsi |
| --- | --- | --- |
| GET/POST | `/register` | Registrasi Admin pertama, hanya selama setup awal |
| GET/POST | `/login` | Form dan proses login |
| POST | `/logout` | Logout |
| GET/POST | `/forgot-password` | Proses lupa password |
| GET/POST | `/reset-password` | Reset password |
| GET | `/dashboard` | Dashboard |
| GET/POST | `/orders` | List dan simpan order |
| GET | `/orders/create` | Form tambah order |
| POST | `/orders/{id}` | Update order |
| POST | `/orders/{id}/status` | Update status order |
| GET | `/orders/{id}/whatsapp` | Kirim pesan WhatsApp |
| GET/POST | `/customers` | List dan simpan pelanggan |
| POST | `/customers/{id}/redeem` | Klaim reward |
| GET | `/reports` | Laporan |
| GET | `/reports/export` | Export laporan |
| GET | `/transaction-history` | Riwayat transaksi |
| GET | `/settings` | Pengaturan akun |
| POST | `/settings/users` | Tambah akun pegawai |

## 11. API Docs

Saat ini tidak ada REST API JSON publik. Semua request memakai web route Laravel.

Jika nanti dibutuhkan API:

- Tambahkan route di `routes/api.php`.
- Gunakan Laravel Sanctum untuk token.
- Pisahkan controller API dari web route.
- Endpoint yang disarankan: order, customer, status order, dan report.

## 12. Konfigurasi `.env`

Contoh konfigurasi production:

```env
APP_NAME="Raab Shoes"
APP_ENV=production
APP_DEBUG=false
APP_URL=https://domain-klien.com

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=raabshoes
DB_USERNAME=database_user
DB_PASSWORD=database_password

SESSION_DRIVER=file
CACHE_STORE=file
QUEUE_CONNECTION=sync
```

Jika Google login dipakai:

```env
GOOGLE_CLIENT_ID=
GOOGLE_CLIENT_SECRET=
GOOGLE_REDIRECT_URI=https://domain-klien.com/auth/google/callback
```

## 13. Cara Install Lokal

Prasyarat:

- PHP 8.2+
- Composer
- Node.js dan NPM
- MySQL/MariaDB

Langkah:

```bash
cd manajement-raabshoes
composer install
cp .env.example .env
php artisan key:generate
```

Atur database di `.env`, lalu buat database:

```sql
CREATE DATABASE raabshoes CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

Jalankan migration dan asset:

```bash
php artisan migrate
npm install
npm run build
php artisan serve
```

Akses lokal:

```text
http://127.0.0.1:8000
```

## 14. Cara Deploy ke Server

Ringkasan langkah deploy:

1. Upload source code ke server.
2. Arahkan document root ke folder `public`.
3. Buat file `.env` production.
4. Jalankan dependency:

```bash
composer install --no-dev --optimize-autoloader
npm install
npm run build
```

5. Jalankan migration:

```bash
php artisan migrate --force
```

6. Optimasi Laravel:

```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

7. Pastikan folder berikut writable:

```text
storage/
bootstrap/cache/
public/uploads/order-photos/
```

8. Gunakan SSL dan pastikan `APP_DEBUG=false`.

## 15. Akses Server

Bagian ini diisi oleh tim IT klien. Jangan simpan password asli di repository.

| Akses | Keterangan |
| --- | --- |
| Domain production | `https://...` |
| IP server | `...` |
| SSH user | `...` |
| Path aplikasi | `/var/www/.../manajement-raabshoes` |
| Database host | `...` |
| Database name | `raabshoes` |
| Database user | `...` |
| Panel hosting | cPanel/Plesk/VPS/Cloud |
| Lokasi backup | `...` |

Rekomendasi:

- Jangan commit `.env`.
- Simpan credential di password manager.
- Gunakan SSH key.
- Batasi akses database dari luar server.

## 16. Akun Aplikasi

Admin pertama dibuat melalui `/register` setelah migration pada instalasi baru. Isi nama, username, email, nomor HP, password 8–16 karakter, dan konfirmasi password. Setelah berhasil, login menggunakan akun tersebut.

Tidak ada lagi pembuatan Admin atau password default otomatis saat login, lupa password, maupun membuka Pengaturan. Akun yang sudah ada tetap dipertahankan.

Tabel `admin_registration` menyimpan status setup satu kali. Migration menutup setup jika sudah ada Admin. Klaim setup dan pembuatan akun berada dalam satu transaksi untuk mencegah pendaftaran ganda. Setup yang selesai tetap tertutup walaupun akun Admin kemudian dihapus. Pemulihan akun memerlukan penanganan pengelola sistem, bukan registrasi publik ulang.

Akun Pegawai tetap dibuat oleh Admin melalui Pengaturan. Untuk skenario praktikum, gunakan database pengujian terpisah; lihat `docs/pkpl/registrasi-admin-pertama.md`.

## 17. File Upload dan Asset

| Path | Fungsi |
| --- | --- |
| `public/uploads/order-photos` | Foto barang order |
| `public/images/qris-raabshoes.jpg` | Gambar QRIS |
| `public/images/raabshoes-logo.svg` | Logo |
| `public/images/login-shoe-cleaning-bg.png` | Background login |

Aturan upload:

- Format JPG, JPEG, PNG.
- Maksimal 5 MB.
- Nama file sistem memakai UUID.

## 18. Backup dan Restore

Backup database:

```bash
mysqldump -u database_user -p raabshoes > backup-raabshoes.sql
```

Backup upload:

```bash
tar -czf uploads-order-photos.tar.gz public/uploads/order-photos
```

Restore database:

```bash
mysql -u database_user -p raabshoes < backup-raabshoes.sql
```

Rekomendasi:

- Backup database harian.
- Backup upload minimal mingguan.
- Simpan backup di lokasi berbeda dari server utama.

## 19. Maintenance

| Frekuensi | Aktivitas |
| --- | --- |
| Harian | Cek error log dan kapasitas storage |
| Mingguan | Backup database/upload dan cek akun pegawai |
| Bulanan | Cek SSL, update dependency jika aman |
| Setiap deploy | Jalankan test, migration, build asset, smoke test |

Command umum:

```bash
php artisan optimize:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache
composer test
```

## 20. Testing

Dokumen testing:

| Dokumen | Fungsi |
| --- | --- |
| `docs/qa-document.md` | QA manual |
| `docs/internal-developer-testing.md` | Rencana testing developer |
| `docs/hasil-eksekusi-testing-internal.md` | Hasil eksekusi testing internal |

Catatan hasil terakhir:

- `composer test` berhasil: 2 tests passed.
- `php artisan route:list` berhasil: 32 route terbaca.
- `php artisan migrate:status` gagal karena MySQL lokal tidak aktif.
- `npm run build` gagal karena `node_modules` belum tersedia.

## 21. Troubleshooting Singkat

| Masalah | Penyebab Umum | Solusi |
| --- | --- | --- |
| `SQLSTATE[HY000] [2002] Connection refused` | MySQL belum aktif atau port salah | Cek `.env`, nyalakan database, jalankan `php artisan config:clear` |
| `vite: command not found` | `node_modules` belum ada | Jalankan `npm install` lalu `npm run build` |
| Upload foto gagal | Format/ukuran salah atau permission folder | Cek JPG/PNG max 5 MB dan permission `public/uploads` |
| Halaman 500 | `.env`, APP_KEY, database, atau permission salah | Cek `storage/logs/laravel.log` dan jalankan `php artisan optimize:clear` |

## 22. Rekomendasi Pengembangan Lanjutan

| Area | Rekomendasi |
| --- | --- |
| Struktur kode | Pindahkan logic dari `routes/web.php` ke controller/service |
| Authorization | Tambahkan middleware auth dan role |
| API | Buat API JSON jika ada aplikasi mobile/integrasi |
| Testing | Tambahkan feature test untuk order, pelanggan, laporan |
| Security | Gunakan reset password token/email Laravel untuk production |
| Report | Tambahkan export PDF/Excel asli |
| Harga layanan | Pindahkan daftar layanan dan harga ke database |

## 23. Lampiran: Layanan dan Harga

| Kategori | Layanan | Harga |
| --- | --- | ---: |
| Fast Clean | Easy / Hard | Rp 20.000 - Rp 25.000 |
| Deep Clean | Flat Shoes / Reguler / Express / Express Half Day | Rp 15.000 - Rp 50.000 |
| Shoes Repair | Reglue / Unyellowing / Repaint-Custom | Rp 15.000 - Rp 100.000 |
| Bag/Tas | Small / Medium / Hard | Rp 20.000 - Rp 35.000 |
| Hat | Hat | Rp 20.000 |

Harga saat ini didefinisikan di `routes/web.php`. Jika harga sering berubah, sebaiknya dipindahkan ke tabel database agar bisa dikelola dari halaman admin.


## Lingkungan demo registrasi praktikum

Gunakan `php praktikum.php prepare`, kemudian `php praktikum.php serve` untuk mengakses `http://127.0.0.1:8010/register`. Untuk mengulang, hentikan server (Ctrl+C), jalankan `php praktikum.php reset`, lalu jalankan server kembali dan buka ulang halaman. Reset menghapus seluruh akun dan sesi demo saja; order/pelanggan dipertahankan. Database SQLite praktikum dan cookie sesi terpisah dari profil utama. Detail pengaman dan skenario terdapat di [panduan registrasi](pkpl/registrasi-admin-pertama.md).
