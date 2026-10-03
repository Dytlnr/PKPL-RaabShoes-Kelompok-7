# PANDUAN PRAKTIKUM PENGUJIAN RAABSHOES

Nama: Dyata Lintar Akbar
NIM: 202310370311412
Pendamping SRS versi 1.0, 27 September 2026

## 1. Cara menggunakan paket tugas

SRS merupakan dokumen utama untuk pilihan tugas spesifikasi tertulis. Panduan ini adalah bahan persiapan praktikum, bukan bukti bahwa semua test sudah dibuat. Bacalah aturan stempel, transaksi tunai, dan hak akses sebelum mempresentasikan. Lengkapi identitas kelas/dosen jika diwajibkan, lalu cocokkan format pengumpulan dengan arahan dosen.

## 2. Modul pertama: perhitungan kembalian

Keterkaitan: UR-03 → FR-09 → BR-04 → AC-09 → UT-03 → FT-09.

Kontrak fungsi: menerima total dan nominal dibayar dalam integer rupiah; mengembalikan integer kembalian. Total negatif atau nominal kurang dari tagihan harus melempar InvalidArgumentException. Nilai null/kosong dari form ditolak validator sebelum fungsi dipanggil. Pemisahan ini membuat pengujian angka tidak bercampur dengan format teks Rupiah.

Contoh rancangan berikut belum dipasang ke aplikasi:

```php
<?php
namespace App\Support;

use InvalidArgumentException;

final class CashPaymentCalculator
{
    public static function change(int $total, int $paid): int
    {
        if ($total < 0 || $paid < $total) {
            throw new InvalidArgumentException('Pembayaran tidak valid.');
        }

        return $paid - $total;
    }
}
```

Contoh unit test murni untuk tests/Unit/CashPaymentCalculatorTest.php setelah kelas dibuat:

```php
<?php
namespace Tests\Unit;

use App\Support\CashPaymentCalculator;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

final class CashPaymentCalculatorTest extends TestCase
{
    public function test_returns_correct_change(): void
    {
        // Arrange: harga dan uang diterima ditentukan secara eksplisit.
        $total = 30000;
        $paid = 50000;
        // Act: panggil satu unit logika.
        $actual = CashPaymentCalculator::change($total, $paid);
        // Assert: bandingkan dengan hasil yang dihitung independen.
        $this->assertSame(20000, $actual);
    }

    public function test_exact_payment_has_zero_change(): void
    {
        $this->assertSame(0, CashPaymentCalculator::change(30000, 30000));
    }

    public function test_rejects_underpayment(): void
    {
        $this->expectException(InvalidArgumentException::class);
        CashPaymentCalculator::change(30000, 29999);
    }

    public function test_rejects_negative_total(): void
    {
        $this->expectException(InvalidArgumentException::class);
        CashPaymentCalculator::change(-1, 30000);
    }
}
```

Jalankan setelah file kelas dan test benar-benar dibuat: php artisan test --filter=CashPaymentCalculatorTest. Jangan menyalin hasil “PASS” ke laporan sebelum mengeksekusi. Controller/route perlu menangkap hasil validasi dan mengubahnya menjadi pesan form; exception tidak boleh ditampilkan mentah ke pengguna.

## 3. Daftar kasus uji praktikum

| ID kasus | Requirement / jenis | Input atau kondisi | Expected result | Status |
| --- | --- | --- | --- | --- |
| TC-01 | FR-09 / unit | Total 30000, dibayar 50000 | Kembalian 20000 | Rencana |
| TC-02 | FR-09 / unit | Total 30000, dibayar 30000 | Kembalian 0 | Rencana |
| TC-03 | FR-09 / unit | Total 30000, dibayar 29999 | Exception pembayaran tidak valid | Rencana |
| TC-04 | FR-09 / feature | Tambah order tunai tanpa nominal | Ditolak; database tidak bertambah | Rencana |
| TC-05 | FR-09 / feature | Ubah order tunai menjadi uang kurang | Ditolak; nominal lama tetap | Rencana; gap implementasi |
| TC-06 | FR-06 / unit | ID 1, 9999, 10000 | RS0001, RS9999, RS10000 | Rencana ekstraksi |
| TC-07 | FR-06 / integration | Buat dua order, termasuk bersamaan | Kode berbeda; tidak ada duplikat | Rencana |
| TC-08 | FR-12 / unit | Dua order selesai pada satu tanggal masuk | Satu stempel | Rencana ekstraksi |
| TC-09 | FR-12 / unit | Tanggal berbeda, satu Baru dan satu Diambil | Satu stempel | Rencana ekstraksi |
| TC-10 | FR-13 / unit | Stempel 7/8/9, klaim 0 | Reward 0/1/1; progres 7/8/8 | Rencana ekstraksi |
| TC-11 | FR-13 / unit | Stempel 9, klaim 1 | Sisa 1, reward 0, progres 1 | Rencana ekstraksi |
| TC-12 | FR-13 / unit | Stempel 1, klaim 2 | Sisa 0 dan reward 0 | Rencana ekstraksi |
| TC-13 | FR-11 / formatter | Tunai 25000, dibayar 30000, kembali 5000 | Nota memuat nominal yang benar | Tercakup test yang lulus |
| TC-14 | FR-11 / formatter | QRIS, cash_paid 0 | Tidak ada baris Dibayar/Kembali | Tercakup test yang lulus |
| TC-15 | FR-08 / feature | Nama layanan tidak tersedia | Ditolak, bukan harga 0 | Rencana; gap implementasi |
| TC-16 | FR-07 / feature | PNG valid 5120 KB; 5121 KB; teks .jpg | Batas diterima; lebih batas dan bukan gambar ditolak | Rencana |
| TC-17 | FR-07 / acceptance | Klik ambil foto dan izinkan kamera | Preview aktif tanpa tombol nyalakan kedua | Rencana uji perangkat |
| TC-18 | FR-07 / acceptance | Tutup kamera saat izin masih tertunda | Stream yang terlambat berhenti, panel tidak terbuka lagi | Rencana uji perangkat |
| TC-19 | FR-15 / unit | Harga [20000,30000] dan data kosong | Total 50000/rata-rata 25000; nol/nol | Rencana ekstraksi |
| TC-20 | NFR-01 / feature | Guest mengakses setiap endpoint internal | Redirect login atau penolakan sesuai jenis endpoint | Rencana; gap implementasi |
| TC-21 | FR-16 / feature | Pegawai menghapus akun dengan role sesi admin palsu | HTTP 403, akun tetap ada | Tercakup test yang lulus |
| TC-22 | FR-13 / integration | Dua klaim bersamaan, hanya satu reward | Tepat satu klaim berhasil | Rencana; perlu concurrency test |

Untuk TC-16 gunakan konten gambar yang benar, bukan hanya nama atau ukuran file palsu, agar aturan image diuji. Unit test kode order hanya membuktikan format; keunikan dan konkurensi harus diuji pada database.

## 4. Langkah praktikum

1. Pilih FR-09 sebagai modul pertama; tulis kontrak input-output dan tabel TC-01 sampai TC-05.
2. Implementasikan kelas kecil serta unit test di atas pada cabang/salinan kerja pengembangan.
3. Jalankan test; simpan hasil aktual, termasuk kegagalan jika ada.
4. Hubungkan kelas yang sama pada jalur tambah dan ubah order.
5. Tambahkan feature test validasi uang kurang pada kedua endpoint untuk memastikan integrasi.
6. Jalankan regression test member, akun, dan nota yang sudah ada.
7. Lanjutkan reward dan kode order. Hindari membuat seluruh fitur sekaligus saat baru mempelajari unit testing.

## 5. Lingkungan dan keamanan data uji

phpunit.xml sudah mengarah ke SQLite :memory:, session array, serta cache array. Periksa tidak ada konfigurasi cache yang mengalihkan test ke database nyata. Gunakan data fiktif dan fake upload; jangan mengirim WhatsApp nyata atau mengakses kamera pada unit test. Uji kamera dilakukan terpisah pada browser dengan perangkat yang dicatat.

Perintah dari direktori manajement-raabshoes:

```sh
php artisan test --testsuite=Unit
php artisan test --filter=CashPaymentCalculatorTest
php artisan test --filter='CustomerStampsTest|DeleteAccountTest|WhatsAppReceiptTest'
```

Dua perintah pertama dipakai setelah unit test yang direncanakan dibuat. Keberadaan nama test dalam dokumen tidak berarti filenya sudah ada. Jangan memakai migrate:fresh pada database operasional untuk kebutuhan praktikum.

## 6. Bukti eksekusi yang sudah tersedia

Eksekusi terpilih tanggal 27 September 2026: CustomerStampsTest (5 test), DeleteAccountTest (4 test), WhatsAppReceiptTest (2 test). Hasil: 11 passed, 53 assertions. Log ada di hasil-test-terpilih.txt. Tidak ada pengukuran coverage, benchmark kinerja, atau pengujian kamera yang diklaim selesai dalam paket ini.

## 7. Template laporan hasil pengujian

| Kolom | Isi yang harus dicatat |
| --- | --- |
| ID test dan requirement | Contoh TC-01 / FR-09 / BR-04 |
| Versi kode | Commit atau salinan versi yang diuji |
| Lingkungan | OS, PHP, framework, database pengujian |
| Prasyarat dan input | Total 30000, dibayar 50000 |
| Expected result | 20000 |
| Actual result | Diisi setelah eksekusi |
| Status | Pass/Fail setelah membandingkan hasil |
| Bukti | Log command atau screenshot hasil |
| Tindak lanjut | Penyebab gagal, perbaikan, hasil retest |

## 8. Penjelasan singkat untuk presentasi

“Saya memakai RaabShoes, aplikasi manajemen laundry sepatu. Saya menyusun SRS dengan kebutuhan yang dapat diuji. Contohnya FR-09 menentukan uang tunai minimal sebesar tagihan. Aturan ini diuji pada nominal lebih, tepat, dan kurang satu rupiah. Unit test memeriksa kalkulator, feature test memeriksa form dan database, sedangkan kamera diuji melalui browser. Jadi kebutuhan dan bukti pengujiannya dapat ditelusuri.”

Pahami penjelasan tersebut dan sesuaikan dengan pekerjaan yang benar-benar sudah kamu lakukan. Jangan menyebut rencana test atau contoh kode sebagai implementasi yang telah lulus. Kualitas tugas bergantung pada ketepatan isi, pemahaman, pelaksanaan, dan rubrik dosen; dokumen tidak menjamin nilai tertentu.
