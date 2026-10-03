# SPESIFIKASI KEBUTUHAN PERANGKAT LUNAK (SRS)
## Sistem Informasi Manajemen Laundry Sepatu RaabShoes Berbasis Web

Tugas Mata Kuliah PKPL

Disusun oleh: Dyata Lintar Akbar
NIM: 202310370311412
Tanggal penyusunan: 27 September 2026
Versi: 1.0 — Baseline kebutuhan untuk tugas dan praktikum pengujian

Dokumen ini disusun berdasarkan pemeriksaan kode aplikasi RaabShoes. Identitas dosen, kelas, dan institusi dapat ditambahkan pada sampul sesuai ketentuan perkuliahan. Dokumen ini tidak menyatakan bahwa seluruh kebutuhan telah diimplementasikan atau lulus pengujian.

## Ringkasan dokumen

RaabShoes merupakan aplikasi pengelolaan jasa laundry dan perawatan sepatu, bukan e-commerce penjualan sepatu. Sistem membantu admin dan pegawai mencatat pelanggan, barang, foto, layanan, pembayaran, status pekerjaan, stempel member, dan laporan. Dokumen SRS dipilih untuk memenuhi alternatif spesifikasi kebutuhan tertulis pada instruksi tugas.

Kebutuhan diberi identitas unik agar dapat ditelusuri ke aturan bisnis, kriteria penerimaan, dan kasus uji praktikum. Fitur tersedia, implementasi parsial, dan target perbaikan dibedakan secara eksplisit. Istilah “harus” menyatakan kebutuhan yang hendak dipenuhi, bukan bukti bahwa implementasi telah sempurna.

## Daftar isi

1. Pendahuluan
2. Gambaran umum sistem
3. Kebutuhan pengguna dan hak akses
4. Kebutuhan fungsional dan kriteria penerimaan
5. Aturan bisnis
6. Kebutuhan data dan antarmuka
7. Kebutuhan nonfungsional
8. Skenario operasional
9. Strategi pengujian dan ketertelusuran
10. Kesenjangan implementasi dan batas penerimaan
11. Sumber dan pengendalian perubahan

## 1. Pendahuluan

### 1.1 Tujuan

Menetapkan kebutuhan RaabShoes secara jelas, konsisten, dan dapat diuji. Dokumen menjadi acuan peninjauan aplikasi serta penyusunan unit test, feature test, dan uji penerimaan pada praktikum. Sasaran akademiknya adalah menunjukkan hubungan antara masalah pengguna, kebutuhan, aturan bisnis, dan bukti pengujian.

### 1.2 Latar belakang masalah

Pencatatan laundry perlu menjaga keterkaitan barang dengan pelanggan, layanan, pembayaran, dan status pengerjaan. Kesalahan kode atau pencatatan berpotensi menyebabkan barang tertukar dan informasi transaksi tidak konsisten. RaabShoes menggunakan nomor order pendek, foto barang, dan pencatatan terpusat untuk membantu proses tersebut. Pernyataan ini merupakan analisis kebutuhan proyek, bukan hasil wawancara atau survei yang telah dilakukan.

### 1.3 Ruang lingkup

Termasuk dalam ruang lingkup: autentikasi internal; dashboard; data pelanggan; pencatatan, perubahan, dan penghapusan order; dokumentasi foto; pemilihan layanan dan harga; pencatatan metode pembayaran dan kembalian tunai; status pekerjaan; penyusunan nota WhatsApp; stempel dan penukaran reward; pencarian, penyaringan, laporan, serta pengelolaan akun pegawai.

Tidak termasuk: penjualan stok sepatu, keranjang belanja, checkout pelanggan, verifikasi pembayaran otomatis melalui payment gateway, pengiriman WhatsApp otomatis, analisis kondisi barang dengan AI, pencetakan label otomatis, serta aplikasi seluler native. Nomor order dapat dipakai pada label fisik yang ditempel secara manual.

### 1.4 Istilah dan konvensi

| Istilah | Pengertian |
| --- | --- |
| SRS | Dokumen spesifikasi kebutuhan perangkat lunak. |
| UR | Kebutuhan pengguna. |
| FR | Kebutuhan fungsional. |
| NFR | Kebutuhan nonfungsional. |
| BR | Aturan bisnis. |
| AC | Kriteria penerimaan untuk satu kebutuhan. |
| UT / FT / AT | Unit test / feature atau integration test / acceptance test. |
| Order | Satu catatan barang dan layanan; satu pelanggan dapat memiliki beberapa order. |
| Stempel | Hak member berdasarkan tanggal masuk berbeda yang mempunyai order selesai. |
| Tersedia | Perilaku ditemukan pada kode; tidak otomatis berarti seluruh skenarionya teruji. |
| Parsial | Fitur ada, tetapi sebagian aturan atau validasinya belum konsisten. |
| Target | Kebutuhan yang diusulkan; masih perlu implementasi atau pembuktian. |

Prioritas Must berarti kebutuhan inti; Should berarti pendukung yang penting. Nilai kinerja dalam dokumen merupakan target uji yang diusulkan, belum hasil pengukuran.

## 2. Gambaran umum sistem

### 2.1 Perspektif produk

Aplikasi berbasis Laravel, menggunakan Blade untuk tampilan dan Eloquent untuk data. Browser berkomunikasi dengan aplikasi web; aplikasi menyimpan data pengguna, pelanggan, dan order. Kamera diakses melalui browser. WhatsApp digunakan melalui tautan wa.me berisi pesan yang telah disusun.

### 2.2 Alur bisnis utama

1. Admin atau pegawai masuk ke sistem.
2. Pegawai mencatat identitas pelanggan, barang, kondisi, layanan, foto, dan metode pembayaran.
3. Sistem memvalidasi data, menyimpan order, dan memberi nomor pendek.
4. Pegawai menuliskan nomor yang sama pada label barang dan mencocokkannya dengan nota.
5. Status diperbarui sesuai pengerjaan hingga barang diambil.
6. Sistem menyiapkan nota WhatsApp; pegawai memeriksa penerima dan mengirim melalui WhatsApp.
7. Stempel dihitung berdasarkan aturan member dan laporan digunakan untuk melihat aktivitas toko.

### 2.3 Asumsi dan ketergantungan

Satu order merepresentasikan satu barang/layanan dalam pencatatan saat ini. Harga diambil dari daftar layanan server. Internet dibutuhkan untuk WhatsApp dan autentikasi eksternal jika digunakan. Kamera bergantung pada perangkat, izin browser, serta konteks aman HTTPS atau localhost. Pemilihan kondisi barang dilakukan manual. Admin perlu memastikan nomor telepon pelanggan benar sebelum pesan dikirim.

## 3. Kebutuhan pengguna dan hak akses

### 3.1 Aktor

Admin mengelola operasional dan akun pegawai. Pegawai menjalankan pencatatan dan pelayanan toko. Pelanggan adalah pemilik barang dan penerima nota, bukan pengguna dashboard internal pada ruang lingkup ini. Pengunjung dapat melihat beranda publik. WhatsApp dan penyedia login eksternal merupakan sistem pendukung.

### 3.2 Kebutuhan pengguna

| ID | User story | Kebutuhan terkait |
| --- | --- | --- |
| UR-01 | Sebagai petugas, saya ingin masuk menggunakan identitas akun agar dapat mengakses pekerjaan saya. | FR-01, FR-02 |
| UR-02 | Sebagai pegawai, saya ingin mencatat pelanggan dan foto barang agar order mudah diidentifikasi. | FR-04, FR-05, FR-06, FR-07 |
| UR-03 | Sebagai pegawai, saya ingin mengetahui harga dan kembalian agar pencatatan tunai akurat. | FR-08, FR-09 |
| UR-04 | Sebagai pegawai, saya ingin memperbarui status dan menyiapkan nota agar pelanggan mendapat informasi pesanan. | FR-10, FR-11 |
| UR-05 | Sebagai petugas, saya ingin menghitung stempel dan reward agar hak pelanggan konsisten. | FR-12, FR-13 |
| UR-06 | Sebagai admin, saya ingin mencari transaksi dan melihat laporan agar aktivitas toko dapat dipantau. | FR-03, FR-14, FR-15 |
| UR-07 | Sebagai admin, saya ingin mengelola akun pegawai agar akses dapat dikendalikan. | FR-16 |

### 3.3 Matriks hak akses yang dipersyaratkan

| Fitur | Admin | Pegawai | Pengunjung/pelanggan tanpa akun internal |
| --- | --- | --- | --- |
| Beranda dan informasi layanan publik | Ya | Ya | Ya |
| Dashboard, pelanggan, order, foto, pembayaran | Ya | Ya | Tidak |
| Status, nota, stempel, penukaran reward | Ya | Ya | Tidak |
| Layanan/harga, riwayat, laporan | Ya | Ya | Tidak |
| Menambah dan menghapus akun pegawai | Ya | Tidak | Tidak |
| Menghapus akun sendiri | Tidak | Tidak | Tidak |
| Pendaftaran mandiri akun internal | Tidak; melalui pengelolaan akun | Tidak | Tidak |

Matriks ini adalah kebutuhan akses yang dituju. Pemeriksaan kode menunjukkan perlindungan belum diterapkan merata pada seluruh route internal; pemenuhannya harus diuji melalui request langsung, bukan hanya keberadaan menu.

## 4. Kebutuhan fungsional dan kriteria penerimaan

### FR-01 — Login internal

Prioritas: Must. Status: Tersedia, penguatan keamanan terkait NFR-01 masih diperlukan.

Sistem harus menerima email atau username dan password, memeriksa hash password, lalu menyimpan sesi identitas pengguna bila benar. AC-01: akun valid diarahkan ke dashboard; kredensial salah menampilkan pesan kesalahan dan tidak membuat sesi login baru; isian kosong ditolak. Uji: FT-01.

### FR-02 — Logout

Prioritas: Must. Status: Tersedia untuk penghapusan sesi aplikasi.

Sistem harus menghapus identitas sesi ketika pengguna logout dan mengarahkan ke login. AC-02: setelah logout, sesi social_auth tidak ada; akses ulang route internal harus ditolak sesuai NFR-01. Bagian penolakan akses ulang masih memerlukan penguatan middleware. Uji: FT-02.

### FR-03 — Dashboard

Prioritas: Should. Status: Tersedia.

Sistem harus menampilkan ringkasan aktivitas berdasarkan data order dan member. AC-03: setiap jumlah status pada dashboard sesuai hasil hitung data uji; data kosong menghasilkan nilai nol tanpa error. Uji: FT-03.

### FR-04 — Data pelanggan

Prioritas: Must. Status: Tersedia.

Sistem harus mencatat nama, nomor telepon, dan alamat opsional. Nomor telepon yang sama secara persis digunakan untuk mencari pelanggan saat order dicatat. AC-04: dua order dengan nomor identik terhubung ke pelanggan yang sama; nomor berbeda menghasilkan pelanggan berbeda. Normalisasi 08 menjadi +62 untuk deduplikasi belum termasuk perilaku yang terbukti. Uji: FT-04.

### FR-05 — Pencatatan dan perubahan order

Prioritas: Must. Status: Parsial.

Sistem harus menyimpan identitas pelanggan, jenis barang, layanan, metode pembayaran, foto awal, dan status. Kondisi, merek, warna, alamat, dan catatan bersifat opsional sesuai validasi saat ini. AC-05: data wajib kosong ditolak; order valid tersimpan dengan status Baru; pembaruan hanya menerima status yang diizinkan; layanan di luar daftar server harus ditolak. Validasi daftar layanan dan konsistensi validasi perubahan pembayaran masih menjadi target. Uji: FT-05.

### FR-06 — Nomor order pendek

Prioritas: Must. Status: Tersedia.

Sistem harus menghasilkan kode order baru dengan awalan RS dan ID database berformat minimal empat digit, misalnya RS0001 dan RS2168. AC-06: ID 1 menjadi RS0001; ID 9999 menjadi RS9999; ID 10000 menjadi RS10000 tanpa pemotongan; dua order berbeda tidak memiliki kode sama. Kode tidak menjamin urutan tanpa celah. Nomor lama tetap berlaku. Uji: UT-01 setelah ekstraksi fungsi, FT-06 untuk penyimpanan.

### FR-07 — Foto barang

Prioritas: Must. Status: Tersedia.

Sistem harus menerima foto dari kamera atau file JPG/JPEG/PNG maksimal 5120 KB. Tombol Ambil Foto Sekarang langsung meminta akses kamera, tanpa tombol aktivasi tambahan. AC-07: foto berhasil tampil pada pratinjau; foto tangkapan menjadi file order; kamera berhenti setelah pengambilan; penolakan izin tidak menghalangi pemilihan file; file bukan gambar atau melebihi batas ditolak server. Uji: FT-07 dan AT-01.

### FR-08 — Pemilihan layanan dan harga

Prioritas: Must. Status: Parsial.

Sistem harus menyediakan daftar layanan dan mengambil harga dari daftar server, bukan dari nominal harga yang dikirim browser. AC-08: Deep Clean - Reguler menghasilkan Rp30.000; layanan tidak dikenal ditolak, bukan dihargai nol. Penolakan nama layanan tidak dikenal merupakan target perbaikan. Pengubahan daftar harga melalui CRUD admin tidak termasuk fitur saat ini. Uji: UT-02 setelah ekstraksi, FT-08.

### FR-09 — Pembayaran tunai dan pencatatan metode

Prioritas: Must. Status: Parsial.

Sistem harus mencatat metode pembayaran; khusus tunai, nominal wajib tersedia dan minimal sebesar harga. Kembalian = dibayar − harga. AC-09: harga Rp30.000 dan dibayar Rp50.000 menghasilkan Rp20.000; dibayar Rp30.000 menghasilkan nol; dibayar Rp29.999 atau kosong ditolak pada pembuatan maupun perubahan order. Metode non-tunai tidak dianggap bukti pelunasan otomatis. Validasi perubahan order belum konsisten dengan pembuatan. Uji: UT-03 setelah ekstraksi, FT-09.

### FR-10 — Status pekerjaan

Prioritas: Must. Status: Tersedia untuk validasi nilai status.

Sistem harus menerima Baru, Diproses, Siap Diambil, atau Diambil. AC-10: nilai lain ditolak; nilai valid tersimpan. Urutan operasional yang disarankan adalah Baru → Diproses → Siap Diambil → Diambil. Saat ini server belum memaksa transisi berurutan; larangan melompati status tidak dijadikan klaim fitur aktif. Uji: FT-10.

### FR-11 — Nota WhatsApp

Prioritas: Must. Status: Tersedia.

Sistem harus menyusun pesan berisi identitas RaabShoes, nama pelanggan, nomor nota, tanggal, layanan, harga, barang, metode pembayaran, status, estimasi jika tersedia, dan informasi member jika terhubung. AC-11: nota tunai menampilkan dibayar dan kembalian yang tercatat; QRIS tidak otomatis menampilkan lunas atau nominal dibayar; pesan pengambilan sesuai status; nomor lokal berawalan 0 diubah menjadi 62 untuk tautan. Sistem membuka WhatsApp dengan pesan, bukan mengirim otomatis. Uji: UT-04 dan FT-11.

### FR-12 — Perhitungan stempel member

Prioritas: Must. Status: Tersedia.

Sistem harus menghitung satu stempel per pelanggan per tanggal masuk berbeda yang memiliki minimal satu order berstatus Siap Diambil atau Diambil. AC-12: tiga order selesai dengan tanggal masuk sama menghasilkan satu stempel; dua tanggal berbeda menghasilkan dua; order Baru/Diproses tidak dihitung; menyelesaikan barang kedua pada kunjungan yang sama tidak menambah stempel baru. Uji: UT-05 setelah ekstraksi, FT-12.

### FR-13 — Penukaran reward

Prioritas: Must. Status: Tersedia untuk alur biasa; pengamanan klaim bersamaan masih perlu diuji.

Sistem harus menyediakan satu reward per delapan stempel yang belum digunakan. AC-13: tujuh stempel menghasilkan nol reward; delapan menghasilkan satu; sembilan setelah sekali klaim menyisakan satu stempel; permintaan klaim tanpa reward tidak mengubah jumlah klaim. Klaim bersamaan tidak boleh membuat jumlah penukaran melebihi hak. Uji: UT-06 setelah ekstraksi, FT-13.

### FR-14 — Pencarian, filter, dan penghapusan order

Prioritas: Must. Status: Tersedia.

Sistem harus menyediakan pencarian pada daftar order, filter status, dan penyaringan tanggal pada riwayat. Penghapusan order harus menghapus catatan yang dipilih tanpa menghapus pelanggan atau order lainnya. AC-14: kode atau nama yang cocok ditampilkan; status berbeda tidak muncul pada filter; kode tidak ditemukan ditangani; penghapusan satu dari dua order pada tanggal sama mempertahankan satu stempel; penghapusan order terakhir tanggal tersebut mengurangi stempel. Uji: FT-14.

### FR-15 — Laporan

Prioritas: Should. Status: Parsial.

Sistem harus menampilkan jumlah order, total nilai layanan, rata-rata, layanan teratas, rekap harian, dan halaman ekspor sesuai rentang tanggal. AC-15: dua order dengan harga tersimpan Rp20.000 dan Rp30.000 menghasilkan total Rp50.000 dan rata-rata Rp25.000; data kosong menghasilkan nol; perubahan harga katalog tidak mengubah total historis. Target perhitungan memakai service_price tersimpan. Kode saat ini menghitung dari daftar harga berdasarkan nama layanan, sehingga konsistensi historis belum terpenuhi. Nilai layanan tidak sama dengan penerimaan kas terverifikasi. Ekspor saat ini berupa halaman HTML, bukan klaim file Excel/PDF. Uji: UT-07 setelah ekstraksi, FT-15.

### FR-16 — Pengelolaan akun pegawai

Prioritas: Must. Status: Tersedia, perlu peninjauan akses konsisten.

Admin harus dapat membuat akun pegawai dengan identitas unik dan password terkonfirmasi minimal delapan karakter. Admin dapat menghapus akun lain tetapi tidak akun sendiri. Pendaftaran mandiri dinonaktifkan. AC-16: pegawai tidak dapat menghapus akun meskipun sesi memuat role admin yang sudah tidak benar; pengguna tanpa sesi ditolak; akun sendiri tetap ada setelah percobaan hapus; registrasi publik tidak membuat pengguna. Uji: FT-16.

## 5. Aturan bisnis

| ID | Aturan | Kebutuhan terkait |
| --- | --- | --- |
| BR-01 | Satu order memiliki satu kode; pasangan kiri-kanan dari order yang sama memakai label kode sama. Label ditempel manual. | FR-05, FR-06 |
| BR-02 | Kode RS menggunakan ID unik, minimal empat digit, tidak dipotong setelah 9999; tidak dijanjikan tanpa celah. | FR-06 |
| BR-03 | Harga berasal dari layanan yang diizinkan; layanan asing harus ditolak. | FR-08 |
| BR-04 | Tunai wajib cukup; kembalian tidak negatif; aturan sama saat tambah dan ubah. | FR-09 |
| BR-05 | Status valid terbatas pada empat nilai yang ditentukan. | FR-10 |
| BR-06 | Stempel memakai tanggal masuk order, bukan tanggal selesai; maksimal satu per pelanggan per tanggal. | FR-12 |
| BR-07 | Sisa stempel = max(stempel diperoleh − 8 × jumlah penukaran, 0). Reward = floor(sisa/8). | FR-13 |
| BR-08 | Indikator progres menampilkan 8/8 bila ada reward; jika tidak, menampilkan sisa modulo 8. Karena itu 9 stempel sebelum klaim dapat tampil 8/8 dengan satu reward. | FR-12, FR-13 |
| BR-09 | Perubahan/penghapusan order dapat mengubah stempel; hasil negatif dibatasi nol. | FR-12, FR-14 |
| BR-10 | Metode QRIS/transfer saja tidak membuktikan pembayaran diterima. | FR-09, FR-11 |
| BR-11 | Pelanggan tidak mendaftarkan akun operasional sendiri; akun pegawai dibuat admin. | FR-16 |
| BR-12 | Total nilai layanan historis harus memakai harga tersimpan per order. | FR-15 |

## 6. Kebutuhan data dan antarmuka

### 6.1 Data inti

| Entitas | Atribut utama | Aturan |
| --- | --- | --- |
| User | id, nama, username, email, role, hash password | Role admin/pegawai; password tidak disimpan sebagai teks biasa. |
| Customer | id, customer_code, member_code, nama, telepon, alamat, reward_redemptions | Memiliki banyak order; jumlah penukaran dipakai dalam hitungan reward. |
| Order | id, order_code, customer_id, nama, telepon, barang, kondisi, merek, layanan, harga, foto, metode bayar, dibayar, kembalian, status, waktu | Terhubung dengan pelanggan; harga dan nominal dalam rupiah integer. |

Relasi: satu Customer memiliki nol atau banyak Order; satu Order terhubung dengan satu Customer pada alur pembuatan normal. Data identitas juga disalin pada order sebagai informasi transaksi. Tidak ada tabel stok atau keranjang dalam ruang lingkup.

### 6.2 Antarmuka pengguna dan eksternal

Form order harus menampilkan label, kesalahan validasi, pratinjau foto, serta pilihan kondisi manual. Daftar transaksi harus menampilkan kode yang dapat dicocokkan dengan barang. WhatsApp menerima nomor tujuan dan teks yang di-URL-encode. Kamera menerima stream video tanpa audio. Gangguan kamera tidak boleh menghapus isian form yang telah dimasukkan. Integrasi Google yang tersedia bergantung pada konfigurasi; pengujian OAuth tidak menjadi prioritas praktikum unit test.

## 7. Kebutuhan nonfungsional

Semua ukuran berikut merupakan target penerimaan yang diusulkan. Pemenuhan memerlukan pengujian terpisah dan bukan disimpulkan dari tampilan atau keberhasilan satu test.

| ID | Kebutuhan terukur | Metode verifikasi | Status |
| --- | --- | --- | --- |
| NFR-01 | Semua route baca/tulis internal menolak pengguna tanpa sesi; fungsi admin menolak role pegawai; logout mengakhiri akses internal. | Feature test request langsung pada setiap route internal dan role. | Target; perlindungan belum merata. |
| NFR-02 | Foto harus JPG/JPEG/PNG valid dan ≤5120 KB; akses foto pelanggan dibatasi pengguna berhak. | Uji batas file dan akses URL foto tanpa sesi. | Parsial; file sekarang disimpan pada folder publik. |
| NFR-03 | Pada viewport 360×800 dan 1366×768, field serta tombol utama dapat digunakan tanpa tertutup; validasi dapat dibaca. | Uji browser manual, catat perangkat dan screenshot. | Belum diukur. |
| NFR-04 | Pada lingkungan uji yang spesifikasinya dicatat, 95% dari 30 request daftar order dengan 1.000 data selesai ≤2 detik; tidak termasuk kamera/WhatsApp/OAuth. | Pengukuran waktu respons setelah pemanasan, catat dataset dan lingkungan. | Target yang perlu disepakati. |
| NFR-05 | Penyimpanan relasi pelanggan-order gagal secara atomik jika terjadi kegagalan database; tidak ada kode order duplikat. | Uji rollback dan pembuatan bersamaan. | Transaksi tersedia; skenario kegagalan belum dibuktikan. |
| NFR-06 | Logika hitung yang dipilih untuk praktikum dapat diuji tanpa database, jaringan, atau kamera; semua kasus batas yang disepakati harus lulus. | Unit test kelas fungsi murni dan laporan hasil. | Target refactoring. |
| NFR-07 | Penolakan izin kamera, kegagalan jaringan eksternal, dan data kosong memberi pesan yang dapat ditindaklanjuti tanpa kehilangan isian yang sudah dimasukkan. | Uji browser dan feature test kondisi gagal. | Parsial/belum diuji menyeluruh. |
| NFR-08 | Seluruh pengujian otomatis menggunakan data sintetis dan database terpisah; tidak mengubah transaksi pelanggan sebenarnya. | Periksa phpunit.xml dan lingkungan sebelum test. | Konfigurasi SQLite in-memory tersedia. |

## 8. Skenario operasional

### SC-01 — Mencatat order tunai

Aktor: Admin/Pegawai. Prasyarat yang dipersyaratkan: pengguna terautentikasi, layanan tersedia. Pemicu: memilih tambah order.

Alur utama: isi pelanggan dan barang; pilih Deep Clean - Reguler; ambil/unggah foto; pilih tunai; masukkan Rp50.000; sistem menghitung Rp20.000 kembalian; simpan; sistem membuat order Baru dengan kode RS; petugas mencocokkan kode pada label fisik.

Alternatif: foto kosong/tidak valid ditolak; pembayaran Rp29.999 ditolak; izin kamera ditolak sehingga petugas memilih file. Pascakondisi sukses: satu order valid dan relasi pelanggan tersimpan; tidak ada klaim AI terhadap kondisi barang.

### SC-02 — Menyelesaikan pekerjaan dan menyiapkan nota

Aktor: Admin/Pegawai. Prasyarat: order tersedia. Petugas memperbarui status menjadi Siap Diambil; sistem menghitung ulang stempel sesuai tanggal masuk; petugas membuka nota WhatsApp; memeriksa nomor dan isi; mengirim melalui WhatsApp. Bila nomor kosong, sistem memberi pemberitahuan. Pascakondisi: status tersimpan, pesan siap digunakan. Terbukanya WhatsApp bukan bukti pesan terkirim.

### SC-03 — Menukar reward

Aktor: Admin/Pegawai. Prasyarat: pelanggan memiliki minimal delapan stempel tersisa. Petugas memilih klaim; sistem memeriksa hak dan menambah jumlah penukaran satu; progres diperbarui. Bila belum cukup, tidak ada perubahan. Pencatatan klaim saat ini tidak otomatis membuat order gratis baru; pemberian layanan mengikuti proses toko.

## 9. Strategi pengujian dan ketertelusuran

### 9.1 Perbedaan tingkat pengujian

Unit test memeriksa satu fungsi logika dengan input-output terkontrol tanpa database, browser, jaringan, atau kamera. Feature/integration test memeriksa request Laravel, validasi, sesi, serta penyimpanan database. Acceptance test memeriksa alur pengguna melalui antarmuka, termasuk izin kamera. Ketiganya saling melengkapi dan tidak boleh diberi label unit test secara sembarang.

### 9.2 Kandidat unit test praktikum

| ID | Unit yang diusulkan | Contoh input | Hasil yang diharapkan |
| --- | --- | --- | --- |
| UT-01 | OrderCodeFormatter::format(id) | 1; 9999; 10000 | RS0001; RS9999; RS10000 |
| UT-02 | ServicePriceResolver::resolve(service) | Deep Clean - Reguler; layanan asing | 30000; exception validasi |
| UT-03 | CashPaymentCalculator::calculate(total, paid) | (30000,50000); (30000,30000); (30000,29999) | 20000; 0; exception validasi |
| UT-04 | ReceiptFormatter::format(data) | Nota tunai; QRIS; Siap Diambil | Nominal benar; tidak mengarang pembayaran; pesan pengambilan sesuai |
| UT-05 | StampCalculator::earned(visits) | Dua order selesai tanggal sama; satu order Baru tanggal lain | 1 stempel |
| UT-06 | RewardCalculator::calculate(earned, redeemed) | (7,0); (8,0); (9,1); (1,2) | Reward 0; reward 1; sisa 1; sisa 0 |
| UT-07 | ReportCalculator::summarize(prices) | [20000,30000]; [] | Total 50000 rata-rata 25000; total/rata-rata 0 |

Nama kelas pada tabel adalah usulan rancangan, bukan klaim kelas-kelas tersebut sudah dibuat. WhatsAppReceipt sudah tersedia tetapi menerima Eloquent Order dan dapat membaca relasi pelanggan; untuk unit test murni gunakan data transfer/array sebagai batas input atau pisahkan pengambilan data dari pemformatan.

### 9.3 Matriks ketertelusuran

| Kebutuhan | Aturan terkait | Unit test rencana | Feature/acceptance test rencana |
| --- | --- | --- | --- |
| FR-01, FR-02 | BR-11 | — | FT-01, FT-02; NFR-01 |
| FR-03 | — | — | FT-03: hitung status dan data kosong |
| FR-04 | — | — | FT-04: pelanggan dengan nomor identik |
| FR-05 | BR-01, BR-03, BR-05 | UT-02 | FT-05: data wajib dan update |
| FR-06 | BR-02 | UT-01 | FT-06: unik dan transaksi bersamaan |
| FR-07 | — | — | FT-07: file; AT-01: kamera dan galeri |
| FR-08 | BR-03 | UT-02 | FT-08: harga server dan layanan asing |
| FR-09 | BR-04, BR-10 | UT-03 | FT-09: tambah/ubah dengan uang kurang |
| FR-10 | BR-05 | — | FT-10: status valid/tidak valid |
| FR-11 | BR-10 | UT-04 | FT-11: route redirect dan nomor tujuan |
| FR-12 | BR-06, BR-08, BR-09 | UT-05 | FT-12: relasi dan tanggal masuk |
| FR-13 | BR-07, BR-08 | UT-06 | FT-13: klaim sah/tidak sah/bersamaan |
| FR-14 | BR-09 | — | FT-14: pencarian, filter, dan hapus |
| FR-15 | BR-12 | UT-07 | FT-15: harga historis dan ekspor |
| FR-16 | BR-11 | — | FT-16: otorisasi dan akun sendiri |

### 9.4 Bukti pengujian yang sudah dijalankan

Pada 27 September 2026, perintah php artisan test --filter='CustomerStampsTest|DeleteAccountTest|WhatsAppReceiptTest' menghasilkan 11 test lulus dengan 53 assertions. Rinciannya: CustomerStampsTest 5 test; DeleteAccountTest 4 test; WhatsAppReceiptTest 2 test. Hasil tersebut bukan laporan seluruh suite atau bukti seluruh SRS terpenuhi.

CustomerStampsTest dan DeleteAccountTest menggunakan database/request sehingga dikategorikan feature/integration. WhatsAppReceiptTest saat ini ditempatkan pada tests/Feature, memakai Laravel TestCase dan model dengan relasi pelanggan null; ia menguji formatter untuk dua skenario tanpa membuktikan seluruh endpoint WhatsApp.

### 9.5 Tahapan praktikum yang disarankan

1. Mulai UT-03 perhitungan kembalian: input sederhana dan mudah menunjukkan kasus normal, batas, dan gagal.
2. Ekstrak logika ke kelas kecil, gunakan PHPUnit TestCase untuk unit test tanpa boot Laravel.
3. Tambahkan UT-06 reward dan UT-01 kode order setelah modul pertama dipahami.
4. Hubungkan kelas ke route/service aplikasi; jalankan FT-09 untuk memastikan jalur tambah dan ubah memakai aturan sama.
5. Lanjutkan aturan tanggal stempel, formatter nota, dan total laporan.
6. Simpan bukti command, hasil aktual, expected result, serta commit/versi kode. Jika gagal, laporkan penyebab dan ulangi setelah perbaikan.

Pengujian memakai equivalence partitioning (valid/tidak valid), boundary value analysis (uang tepat/kurang satu, 7/8/9 stempel, 9999/10000), dan regression testing. Unit test tidak perlu mengakses kamera atau mengirim pesan nyata.

## 10. Kesenjangan implementasi dan batas penerimaan

| ID | Temuan pemeriksaan | Dampak | Tindak lanjut sebelum dinyatakan memenuhi |
| --- | --- | --- | --- |
| GAP-01 | Tidak ada middleware autentikasi menyeluruh pada route internal yang diperiksa. | Matriks akses belum terjamin. | Pasang kontrol akses konsisten dan uji guest/admin/pegawai. |
| GAP-02 | Layanan tidak dikenal dapat menghasilkan harga fallback nol. | Harga tidak valid mungkin tersimpan. | Validasi daftar layanan server; uji request di luar UI. |
| GAP-03 | Pembaruan order tidak menolak uang tunai kurang secara sama dengan pembuatan. | Transaksi dapat menjadi tidak konsisten. | Pakai kalkulator/validator bersama; uji tambah dan ubah. |
| GAP-04 | Laporan mengambil harga dari katalog berdasarkan nama layanan. | Perubahan katalog dapat mengubah nilai historis. | Gunakan service_price tersimpan dan uji regresi. |
| GAP-05 | Foto disimpan di public/uploads/order-photos. | Pembatasan akses foto belum terpenuhi. | Sajikan foto melalui akses terotorisasi bila kebutuhan privasi ini diterapkan. |
| GAP-06 | Perhitungan tersebar pada route/model; beberapa fungsi bergantung database. | Unit testing murni lebih sulit. | Ekstraksi fungsi kecil tanpa mengubah hasil bisnis. |
| GAP-07 | Pemeriksaan reward dan increment klaim belum berupa operasi terkunci yang terbukti aman terhadap konkurensi. | Klaim bersamaan berpotensi melebihi hak. | Transaksi/locking sesuai database dan integration test khusus. |

Penerimaan akhir mensyaratkan semua kebutuhan Must terkait skenario yang disepakati lulus, kesenjangan terkait ditutup, dan target nonfungsional terukur diverifikasi. Dokumen ini dapat digunakan sebagai baseline tugas tanpa menyatakan semua perbaikan sudah selesai. Penyusunan SRS tidak sekaligus mengubah kode bisnis aplikasi.

## 11. Sumber dan pengendalian perubahan

Sumber primer: slide instruksi tugas yang diberikan mahasiswa; routes/web.php; bootstrap/app.php; app/Models/Customer.php; app/Models/Order.php; app/Support/WhatsAppReceipt.php; resources/views/orders/create.blade.php; phpunit.xml; tests/Feature/CustomerStampsTest.php; tests/Feature/DeleteAccountTest.php; tests/Feature/WhatsAppReceiptTest.php. Pemeriksaan dilakukan pada salinan proyek lokal tanggal 27 September 2026.

Tidak ada klaim wawancara pengguna, pengukuran performa, persetujuan dosen, atau sertifikasi kesesuaian standar yang belum dilakukan. Bila pedoman dosen menentukan format lain, struktur dokumen dapat disesuaikan dengan mempertahankan ID kebutuhan dan keterlacakan pengujian.

Setiap perubahan kebutuhan dicatat dengan tanggal, ID kebutuhan, alasan, dampak kode, dan kasus uji yang berubah. Versi 1.0 memuat baseline hasil inspeksi dan target perbaikan yang dibedakan dari fitur tersedia.
