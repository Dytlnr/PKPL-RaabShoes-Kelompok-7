# Business Process Reengineering (BPR) pada Proses Pelayanan Jasa Perawatan Sepatu di UMKM Raabshoes Berbasis Website

[Nama penulis 1], [Nama penulis 2]

[Program Studi], [Fakultas], [Universitas]

Email: [email penulis]

> Status naskah: draf studi analisis dan perancangan berdasarkan penelaahan kode serta dokumentasi website Raabshoes. Bagian proses lama merupakan model awal yang belum dikonfirmasi melalui observasi. Identitas, data waktu, bukti observasi, dan hasil validasi pengguna perlu dilengkapi sebelum pengumpulan. Tidak ada hasil wawancara atau angka peningkatan kinerja yang direkayasa dalam naskah ini.

## Abstrak

Pelayanan jasa perawatan sepatu memerlukan keterhubungan informasi pelanggan, kondisi barang, pilihan layanan, pembayaran, perkembangan pengerjaan, dan pengambilan barang. Penelitian ini menyusun rancangan rekayasa ulang proses bisnis pelayanan Raabshoes dengan pendekatan Business Process Reengineering (BPR) berdasarkan penelaahan website yang tersedia. Analisis dilakukan melalui identifikasi fungsi sistem, penyusunan model awal proses bisnis untuk divalidasi, serta perancangan proses usulan menggunakan teknik Eliminate, Simplify, Integrate, dan Automate (ESIA). Pemetaan aktivitas dan rancangan pengukuran efisiensi throughput disiapkan untuk mendukung evaluasi lapangan. Hasil analisis menghasilkan rancangan pelayanan yang menggunakan data order sebagai sumber informasi bersama untuk pencatatan pelanggan, dokumentasi foto barang, pembaruan status, penyusunan pesan WhatsApp, perhitungan reward member, dan pelaporan transaksi. Website mendukung empat status order, yaitu Baru, Diproses, Siap Diambil, dan Diambil. Perubahan yang diusulkan berpusat pada penggunaan kembali data dan pengurangan pencatatan berulang antartahap pelayanan. Besarnya peningkatan efisiensi belum dapat ditentukan karena pengukuran waktu proses awal dan proses usulan serta validasi pengguna belum tersedia. Rancangan ini menjadi dasar pelaksanaan observasi dan evaluasi penerapan BPR pada Raabshoes.

**Kata kunci:** Business Process Reengineering, Raabshoes, pelayanan perawatan sepatu, ESIA, sistem informasi berbasis website.

## Abstract

Shoe care services require connected information about customers, item conditions, service selection, payment, work progress, and item collection. This study develops a business process redesign for Raabshoes using a Business Process Reengineering (BPR) approach based on an examination of the available website implementation. The analysis identifies system functions, constructs a preliminary process model requiring field validation, and develops a proposed process using Eliminate, Simplify, Integrate, and Automate (ESIA). Activity mapping and a throughput efficiency measurement plan are prepared to support field evaluation. The resulting design uses order data as a shared information source for customer records, item photographs, status updates, WhatsApp message preparation, membership rewards, and transaction reporting. The website supports four order statuses: New, In Progress, Ready for Collection, and Collected. The proposed changes focus on data reuse and reducing repeated recording across service stages. Efficiency improvements cannot yet be quantified because baseline and proposed process timing data and user validation are unavailable. The design provides a basis for field observation and evaluation of BPR implementation at Raabshoes.

**Keywords:** Business Process Reengineering, Raabshoes, shoe care services, ESIA, web-based information system.

## 1. Pendahuluan

Kegiatan pelayanan perawatan sepatu melibatkan rangkaian pekerjaan sejak pelanggan menyerahkan barang hingga barang selesai dikerjakan dan diambil kembali. Informasi yang digunakan pada tahap penerimaan harus dapat diteruskan ke tahap pengerjaan, komunikasi pelanggan, dan pelaporan. Kebutuhan tersebut mencakup identitas pelanggan, kondisi barang, jenis layanan, nilai transaksi, dan status penyelesaian. Ketidakterhubungan informasi antartahap berpotensi menimbulkan pencatatan berulang dan memperpanjang pencarian informasi saat petugas melayani pelanggan.

Website Raabshoes yang ditelaah menyediakan pengelolaan order untuk barang berupa sepatu, tas, dan topi. Pilihan layanannya meliputi Fast Clean, Deep Clean, Reglue, Unyellowing, Repaint/Custom, serta layanan tas dan topi. Cakupan artikel difokuskan pada alur administrasi pelayanan perawatan sepatu, dengan pelaporan dan member sebagai proses pendukung. Variasi layanan perlu diperhatikan karena lama pengerjaan fisik tidak dapat disamakan antara pencucian, perbaikan lem, dan pengecatan.

BPR menekankan penataan ulang cara kerja untuk memperoleh perbaikan kinerja, dengan teknologi sebagai pendukung perubahan proses [1]. Oleh karena itu, kajian Raabshoes diarahkan pada hubungan antaraktivitas dan penggunaan informasi yang sama sejak penerimaan hingga pelaporan. Keberadaan formulir digital saja belum cukup membuktikan terjadinya peningkatan kinerja operasional.

Penelitian Yusuf, Wahyuni, dan Sari menggunakan BPR, pemetaan ASME, teknik ESIA, dan evaluasi throughput pada pelayanan penerbitan buku [2]. Kerangka tersebut menjadi acuan metodologis artikel ini, dengan penyesuaian terhadap karakteristik pelayanan barang fisik dan fitur yang tersedia pada Raabshoes. Angka hasil penelitian penerbitan buku tidak digunakan sebagai hasil pengukuran Raabshoes.

Tujuan kajian ini adalah menyusun model proses pelayanan yang didukung website, mengidentifikasi peluang pengurangan pekerjaan berulang, dan menyiapkan evaluasi proses sebelum serta sesudah perbaikan. Pertanyaan penelitian meliputi: bagaimana alur pelayanan dapat diintegrasikan melalui data order; aktivitas apa yang dapat diperbaiki dengan ESIA; serta bagaimana perubahan waktu dan penerimaan pengguna dapat dievaluasi.

## 2. Metode Penelitian

### 2.1 Pendekatan dan sumber data

Kajian ini menggunakan pendekatan studi kasus dengan analisis dokumen dan implementasi perangkat lunak. Sumber yang telah ditelaah adalah kode rute aplikasi, model pelanggan, tampilan ekspor laporan, dokumen DAT/UAT, dan catatan pengujian internal. Kode digunakan untuk mengidentifikasi perilaku yang didukung implementasi, sedangkan dokumen UAT digunakan untuk menyusun rencana evaluasi pengguna. Penelaahan kode tidak menggantikan pengujian langsung atau observasi operasional.

**Tabel 1. Sumber data dan status ketersediaannya**

| Sumber | Kegunaan | Status |
| --- | --- | --- |
| Kode dan tampilan website | Mengidentifikasi fitur serta aturan pengolahan data | Telah ditelaah |
| Dokumen DAT/UAT | Menentukan skenario penerimaan pengguna | Tersedia; rekap hasil belum terisi |
| Catatan pengujian internal | Mengetahui ruang lingkup pemeriksaan yang pernah didokumentasikan | Tersedia; bukan bukti penerimaan klien |
| Observasi lapangan | Menetapkan proses lama, pelaku, dan hambatan nyata | [Lengkapi tanggal, lokasi, dan hasil] |
| Wawancara pemilik/pegawai | Mengonfirmasi masalah dan kelayakan proses usulan | [Lengkapi narasumber dan hasil] |
| Pengukuran durasi | Membandingkan kinerja sebelum dan sesudah perbaikan | Belum tersedia |

### 2.2 Tahapan penelitian

Tahapan penelitian yang dirancang adalah pengumpulan data, identifikasi masalah, pemetaan proses awal, pengukuran awal, analisis ESIA, penyusunan proses usulan, evaluasi waktu, dan validasi pengguna. Pada penyusunan draf ini, pekerjaan yang telah dilakukan mencakup penelaahan sistem serta penyusunan rancangan analisis. Tahapan yang memerlukan data lapangan belum dinyatakan selesai.

**Gambar 1. Alur penelitian yang direncanakan**

Penelaahan website dan dokumentasi → Observasi dan wawancara → Validasi proses awal → Pengukuran awal → Analisis ESIA → Proses usulan → Uji waktu dan UAT → Kesimpulan empiris.

### 2.3 Pemetaan aktivitas dan ESIA

Pemetaan aktivitas mengikuti pendekatan peta proses yang digunakan dalam artikel acuan [2]. Untuk kebutuhan lembar observasi, kategori ditulis sebagai O (operasi), I (pemeriksaan), T (perpindahan), D (penundaan), dan S (penyimpanan). Kategori akhir ditetapkan dari aktivitas yang benar-benar diamati. Aktivitas yang memuat dua jenis pekerjaan harus dipecah ketika diukur.

ESIA digunakan untuk menyusun alternatif perubahan: Eliminate menghapus kegiatan yang tidak diperlukan; Simplify menyederhanakan pelaksanaan kegiatan; Integrate menghubungkan kegiatan dan data; serta Automate menyerahkan pekerjaan yang sesuai kepada sistem. Penerapannya pada Raabshoes tetap mempertahankan pemeriksaan dan pengerjaan fisik barang.

### 2.4 Rancangan pengukuran

Indikator utama terdiri atas waktu total, waktu tunda, waktu bukan tunda, jumlah pencatatan ulang, dan kesalahan data. Efisiensi throughput menggunakan definisi operasional berikut, disesuaikan dengan pendekatan artikel acuan [2]:

**Efisiensi throughput (%) = (waktu bukan tunda / waktu total) × 100%.**

Untuk lembar ini, waktu bukan tunda adalah jumlah durasi aktivitas selain D; waktu total merupakan waktu berlalu pada batas proses yang sama. Klasifikasi bukan tunda tidak otomatis berarti aktivitas bernilai tambah bagi pelanggan. Jika terdapat aktivitas paralel, durasinya tidak dijumlahkan dua kali pada waktu total. Pengukuran mengikuti satu garis waktu kasus atau segmen pelayanan yang jelas.

**Pengurangan waktu (%) = ((waktu awal − waktu usulan) / waktu awal) × 100%.**

Selisih dua persentase throughput dilaporkan dalam poin persentase. Pengukuran perlu membandingkan jenis layanan, kondisi barang, jumlah barang, dan kondisi beban kerja yang sebanding. Durasi administrasi penerimaan, pemberitahuan, dan pelaporan dilaporkan terpisah dari durasi pengerjaan fisik agar pengaruh website dapat dinilai dengan tepat. Waktu pelaporan per periode juga tidak langsung ditambahkan pada durasi satu order.

## 3. Hasil Analisis dan Pembahasan

### 3.1 Identifikasi kebutuhan dan masalah yang perlu divalidasi

Hasil penelaahan menunjukkan bahwa website memusatkan informasi order, pelanggan, status pengerjaan, dan laporan. Keberadaan fungsi tersebut menjadi dasar penyusunan dugaan kebutuhan operasional. Namun, kode tidak menunjukkan bagaimana petugas bekerja sebelum website digunakan. Karena itu, masalah pada Tabel 2 merupakan hipotesis untuk dikonfirmasi, bukan temuan observasi yang telah terbukti.

**Tabel 2. Dugaan masalah dan dukungan sistem**

| Dugaan masalah yang perlu dikonfirmasi | Dampak yang perlu diperiksa | Dukungan pada website |
| --- | --- | --- |
| Identitas pelanggan ditulis ulang pada transaksi berikutnya | Waktu input dan ketidakkonsistenan data | Pilihan pelanggan tersimpan serta pengaitan berdasarkan nomor telepon |
| Kondisi barang tidak terdokumentasi bersama order | Kesulitan menelusuri kondisi saat diterima | Kolom kondisi, merek, warna, catatan, dan foto barang |
| Informasi pengerjaan tersebar dalam catatan atau komunikasi petugas | Pencarian status membutuhkan konfirmasi tambahan | Daftar order dan filter status |
| Ringkasan pesanan diketik ulang untuk pelanggan | Beban pengetikan dan risiko salah informasi | Penyusunan isi pesan WhatsApp dari data order |
| Rekap transaksi disusun kembali dari catatan individual | Waktu rekap dan risiko salah penjumlahan | Laporan berdasarkan rentang tanggal |
| Perolehan stempel pelanggan dihitung secara terpisah | Ketidaksesuaian stempel dan transaksi | Perhitungan member berdasarkan order yang memenuhi status |

### 3.2 Model awal proses bisnis yang memerlukan konfirmasi

Model awal berikut disusun sebagai bahan wawancara. Penggunaan buku, nota, WhatsApp, atau spreadsheet pada masa sebelum website belum diketahui. Nama media pencatatan harus diganti sesuai hasil observasi. Jika website sudah menjadi proses berjalan, pengukuran awal harus mengikuti kondisi saat ini atau menggunakan bukti historis yang dapat diverifikasi, bukan menganggap proses manual sebagai fakta.

**Gambar 2. Model awal untuk divalidasi**

Pelanggan menyerahkan barang → Petugas memeriksa barang dan menyepakati layanan → Petugas mencatat pelanggan serta order → Petugas mencatat pembayaran → Barang menunggu dan dikerjakan → Petugas memperoleh informasi selesai → Petugas memberi kabar kepada pelanggan → Pelanggan mengambil barang → Petugas merekap transaksi.

Peran dalam model ini adalah pelanggan, petugas penerimaan/administrasi, petugas pengerjaan, dan pemilik. Pembagian tersebut menggambarkan fungsi pekerjaan; satu orang dapat menjalankan beberapa fungsi sesuai kondisi Raabshoes.

**Tabel 3. Lembar pemetaan proses awal, belum merupakan hasil observasi**

| No. | Aktivitas calon model awal | Kategori awal | Pelaku | Waktu (menit) |
| --- | --- | --- | --- | --- |
| 1 | Memeriksa kondisi barang | I | Petugas | [ukur] |
| 2 | Menyepakati layanan dengan pelanggan | O | Petugas dan pelanggan | [ukur] |
| 3 | Mencatat identitas pelanggan | O | Petugas | [ukur] |
| 4 | Mencatat rincian barang dan order | O | Petugas | [ukur] |
| 5 | Mencatat pembayaran | O | Petugas | [ukur] |
| 6 | Memindahkan barang ke area pengerjaan | T | Petugas | [ukur] |
| 7 | Menunggu giliran pengerjaan | D | Barang/order | [ukur] |
| 8 | Melakukan perawatan sesuai layanan | O | Petugas pengerjaan | [ukur] |
| 9 | Memeriksa hasil perawatan | I | Petugas | [ukur] |
| 10 | Mencatat bahwa barang siap diambil | O | Petugas | [ukur] |
| 11 | Menyiapkan dan mengirim pemberitahuan | O | Petugas | [ukur] |
| 12 | Menunggu pengambilan pelanggan | D | Barang/order | [ukur] |
| 13 | Menyerahkan barang dan mencatat pengambilan | O | Petugas | [ukur; pecah bila perlu] |

Batas proses pada tabel adalah mulai pemeriksaan barang sampai pencatatan pengambilan selesai. Perjalanan pelanggan sebelum tiba di toko tidak termasuk. Penyimpanan fisik selama menunggu pengambilan tidak dihitung kembali sebagai interval terpisah bila durasinya sudah tercakup pada nomor 12. Pelaporan diukur dengan lembar tersendiri menggunakan batas awal pemilihan periode hingga laporan siap digunakan.

### 3.3 Analisis kemampuan website

**Tabel 4. Fitur implementasi dan perannya dalam proses bisnis**

| Modul | Perilaku yang terlihat dalam implementasi | Implikasi proses |
| --- | --- | --- |
| Order | Menyimpan pelanggan, barang, layanan, foto wajib saat pembuatan, catatan, dan metode pembayaran | Informasi penerimaan dihimpun dalam satu order |
| Pelanggan | Mengaitkan order dengan pelanggan berdasarkan nomor telepon; menyediakan pelanggan tersimpan | Identitas dapat digunakan kembali |
| Pembayaran | Menentukan harga dari pilihan layanan; memeriksa kecukupan uang tunai saat membuat order dan menghitung kembalian | Membantu pencatatan transaksi tunai |
| Status | Menyediakan Baru, Diproses, Siap Diambil, dan Diambil | Petugas menggunakan istilah perkembangan pekerjaan yang sama |
| WhatsApp | Membuka tautan WhatsApp dengan nomor serta teks dari order | Petugas tidak perlu menyusun seluruh pesan dari awal |
| Member | Menghitung order berstatus Siap Diambil atau Diambil; target delapan stempel per reward | Perhitungan loyalitas terhubung dengan status order |
| Dashboard | Menampilkan ringkasan order, status, pelanggan, dan nilai layanan | Mendukung pemantauan operasional |
| Laporan | Menyaring tanggal, menghitung order dan nilai layanan, serta membuka tampilan cetak | Rekap memakai data order yang sama |
| Riwayat transaksi | Pencarian kode order, nama, nomor telepon, serta filter tanggal dan status | Mendukung penelusuran transaksi |
| Pengaturan | Menyediakan pembuatan akun pegawai oleh admin | Mendukung pengelolaan pengguna internal |

Terdapat batas kemampuan yang harus diperhatikan dalam interpretasi. WhatsApp masih memerlukan tindakan pengiriman oleh petugas. Pilihan transfer dan QRIS merupakan pencatatan metode pembayaran; kode yang ditelaah tidak menunjukkan verifikasi pembayaran melalui bank atau payment gateway. Ekspor laporan berupa halaman cetak browser yang dapat disimpan sebagai PDF.

Nilai yang diberi label pendapatan pada dashboard dan laporan dihitung dari pemetaan harga layanan untuk order dalam periode yang dipilih. Nilai tersebut belum membuktikan uang telah diterima atau direkonsiliasi. Oleh karena itu, artikel menggunakan istilah nilai layanan/order ketika membahas hasil rekap. Perbedaan harga historis dan harga acuan juga perlu diperiksa ketika laporan divalidasi.

Aturan member menghitung seluruh order dengan dua status tersebut tanpa penyaringan jenis layanan pada model yang ditelaah. Klaim reward dicatat melalui tindakan petugas. Pemberian potongan harga atau pembuatan layanan gratis secara otomatis tidak dapat disimpulkan dari fungsi klaim yang tersedia.

### 3.4 Alternatif rancangan ulang menggunakan ESIA

**Tabel 5. Usulan penyempurnaan proses Raabshoes**

| Aktivitas yang ditinjau | ESIA | Rancangan perubahan | Ketentuan operasional |
| --- | --- | --- | --- |
| Penulisan identitas pada order pelanggan lama | Eliminate, Integrate | Gunakan data pelanggan yang telah tersimpan | Tetap konfirmasi nomor telepon dan perubahan identitas |
| Pencatatan kondisi barang terpisah | Integrate | Satukan kondisi dan foto dengan order | Foto dan kondisi harus sesuai barang yang diterima |
| Penghitungan kembalian tunai | Automate | Gunakan perhitungan berdasarkan harga layanan dan nominal dibayar | Petugas memastikan uang fisik yang diterima |
| Penyampaian perkembangan pekerjaan antartahap | Simplify, Integrate | Gunakan status order sebagai informasi bersama | Tentukan siapa yang memperbarui status dan kapan |
| Pengetikan ulang ringkasan order | Eliminate, Automate | Gunakan teks WhatsApp yang disiapkan dari order | Petugas meninjau isi dan menekan kirim |
| Penyusunan rekap transaksi | Integrate, Automate | Ambil ringkasan dari data order sesuai periode | Pemilik mengecek makna nilai laporan |
| Penghitungan stempel secara terpisah | Integrate, Automate | Gunakan status order untuk menentukan perolehan stempel | Aturan jenis layanan dan klaim perlu disetujui pemilik |
| Pencarian transaksi lama | Simplify | Gunakan pencarian dan filter riwayat | Data awal harus dicatat secara konsisten |

Tabel tersebut merupakan analisis penulis terhadap peluang perubahan, bukan pernyataan persetujuan klien. Manfaat eliminasi pencatatan ganda hanya berlaku apabila observasi membuktikan bahwa pencatatan ganda memang terjadi dan pemilik menyetujui penggunaan data sistem sebagai sumber kerja bersama.

Inti rancangan adalah menghubungkan penerimaan, pemantauan, komunikasi, dan rekap melalui satu order. Usulan aturan kerja meliputi pencatatan lengkap saat barang diterima, pembaruan status segera setelah tahap pekerjaan selesai, serta penggunaan laporan dari data yang sama. Dengan demikian, perubahan mencakup tanggung jawab pengelolaan informasi. Besarnya perubahan dan kelayakannya sebagai BPR harus dinilai setelah proses awal dikonfirmasi.

### 3.5 Rekomendasi proses bisnis

**Gambar 3. Alur pelayanan usulan berdasarkan kemampuan website**

Pelanggan menyerahkan barang → Petugas memeriksa kondisi dan menyepakati layanan → Petugas memilih/mengisi pelanggan, detail barang, foto, layanan, dan pembayaran → Sistem menyimpan order berstatus Baru → Petugas mengirim ringkasan melalui WhatsApp → Petugas memulai pengerjaan dan mengubah status menjadi Diproses → Barang dikerjakan dan hasil diperiksa → Petugas menetapkan Siap Diambil → Petugas mengirim pemberitahuan WhatsApp → Pelanggan mengambil barang → Petugas menetapkan Diambil.

Alur tersebut adalah prosedur operasional yang diusulkan. Pilihan status pada aplikasi tidak membuktikan bahwa urutan transisi dipaksakan oleh sistem. Pemeriksaan hasil dan serah terima barang tetap merupakan aktivitas lapangan yang perlu dijalankan petugas.

**Tabel 6. Pemetaan proses usulan untuk uji waktu**

| No. | Aktivitas | Kategori awal | Pelaku | Waktu (menit) |
| --- | --- | --- | --- | --- |
| 1 | Memeriksa kondisi barang | I | Petugas | [ukur] |
| 2 | Menyepakati layanan | O | Petugas dan pelanggan | [ukur] |
| 3 | Memilih/mengisi pelanggan, barang, foto, dan layanan | O | Petugas | [ukur] |
| 4 | Memasukkan informasi pembayaran | O | Petugas | [ukur] |
| 5 | Memvalidasi dan menyimpan order | O | Sistem | [ukur tanpa tumpang tindih] |
| 6 | Meninjau dan mengirim ringkasan WhatsApp | O | Petugas | [ukur] |
| 7 | Memindahkan barang ke area pengerjaan | T | Petugas | [ukur] |
| 8 | Menunggu giliran pengerjaan | D | Barang/order | [ukur] |
| 9 | Mengubah status menjadi Diproses | O | Petugas | [ukur] |
| 10 | Melakukan perawatan sesuai layanan | O | Petugas pengerjaan | [ukur] |
| 11 | Memeriksa hasil perawatan | I | Petugas | [ukur] |
| 12 | Mengubah status menjadi Siap Diambil | O | Petugas | [ukur] |
| 13 | Meninjau dan mengirim pemberitahuan WhatsApp | O | Petugas | [ukur] |
| 14 | Menunggu pengambilan pelanggan | D | Barang/order | [ukur] |
| 15 | Menyerahkan barang | O | Petugas | [ukur] |
| 16 | Mengubah status menjadi Diambil | O | Petugas | [ukur] |

Jumlah baris kedua tabel tidak digunakan untuk menyimpulkan efisiensi karena tingkat perincian dan aktivitasnya belum divalidasi. Penggunaan website dapat menambah aktivitas dokumentasi foto atau pembaruan status sekaligus mengurangi pekerjaan lain. Evaluasi perlu menilai waktu dan kualitas informasi secara bersama-sama.

Proses pelaporan usulan adalah memilih periode, meninjau ringkasan serta daftar order, lalu mencetak atau menyimpan hasil sebagai PDF. Proses member berjalan sebagai fungsi pendukung: status order yang memenuhi aturan menjadi dasar perhitungan stempel, sedangkan petugas memeriksa ketersediaan reward sebelum mencatat klaim. Perhitungan tersebut tidak perlu dimasukkan sebagai waktu kerja manual tambahan pada setiap order jika berjalan bersamaan dengan pemuatan data.

### 3.6 Evaluasi efisiensi dan indikator hasil

Belum tersedia data waktu lapangan untuk mengisi perhitungan throughput. Oleh sebab itu, hasil kuantitatif belum dinyatakan dalam artikel ini. Tabel berikut disediakan sebagai format pengolahan setelah pengamatan dilakukan.

**Tabel 7. Rekap perbandingan yang harus dilengkapi**

| Indikator | Proses awal | Proses usulan | Dasar penilaian |
| --- | --- | --- | --- |
| Jumlah kasus yang diamati | [isi] | [isi] | Layanan dan kondisi pembanding |
| Rata-rata durasi administrasi penerimaan | [isi] | [isi] | Batas awal/akhir sama |
| Rata-rata durasi pemberitahuan selesai | [isi] | [isi] | Mulai mencari data sampai pesan terkirim |
| Durasi penyusunan laporan per periode | [isi] | [isi] | Jumlah order dan periode sebanding |
| Waktu total pelayanan | [isi] | [isi] | Garis waktu per order |
| Waktu tunda | [isi] | [isi] | Interval D yang tidak tumpang tindih |
| Waktu bukan tunda | [isi] | [isi] | Waktu total dikurangi waktu tunda |
| Efisiensi throughput | [hitung] | [hitung] | Rumus pada metode |
| Jumlah pencatatan ulang per kasus | [isi] | [isi] | Observasi aktual |
| Jumlah kasus kesalahan data | [isi] | [isi] | Catat jumlah kasus dan total sampel |

Pengamatan sebaiknya mencakup beberapa transaksi sejenis dan mencatat jumlah sampelnya secara terbuka. Durasi yang berasal dari simulasi harus dilabeli sebagai simulasi. Estimasi layanan yang tampil pada aplikasi tidak digunakan sebagai pengganti waktu aktual. Waktu menunggu pelanggan mengambil barang dipengaruhi faktor di luar aplikasi sehingga perlu dilaporkan terpisah dari perubahan administrasi.

### 3.7 Validasi pengguna

Dokumen DAT/UAT Raabshoes memuat 12 skenario, mencakup login, akun pegawai, order, pembayaran, perubahan status, WhatsApp, pelanggan, member, dashboard, laporan, dan riwayat transaksi. Rekap hasil serta tanda tangan pada dokumen yang ditelaah belum terisi. Dengan demikian, keberadaan dokumen ini menunjukkan kesiapan instrumen pengujian, bukan bukti aplikasi telah diterima pengguna.

**Tabel 8. Rencana validasi proses usulan**

| Aspek | Pertanyaan/aktivitas validasi | Hasil |
| --- | --- | --- |
| Penerimaan order | Apakah data dan foto cukup untuk mengenali barang serta kebutuhan layanan? | Belum divalidasi |
| Pelanggan | Apakah data lama dapat dipakai tanpa menimbulkan salah pengaitan pelanggan? | Belum divalidasi |
| Pembayaran | Apakah pencatatan tunai dan non-tunai sesuai cara kerja toko? | Belum divalidasi |
| Status | Siapa yang bertanggung jawab memperbarui setiap status? | Belum divalidasi |
| WhatsApp | Apakah nomor, isi pesan, dan estimasi sesuai sebelum dikirim? | Belum divalidasi |
| Member | Apakah delapan order dengan status yang dihitung sesuai kebijakan reward? | Belum divalidasi |
| Laporan | Apakah angka laporan cocok dengan order dan kebutuhan pemilik? | Belum divalidasi |
| Penerimaan proses | Apakah pemilik menyetujui alur dan pembagian tanggung jawab? | Belum divalidasi |

Validasi dilakukan dengan mendemonstrasikan proses, meminta pengguna menjalankan skenario, mencatat hasil aktual, dan mendokumentasikan keputusan. Persetujuan proses bisnis perlu dibedakan dari kelulusan fungsi aplikasi. Fitur dapat berjalan sesuai kode tetapi masih memerlukan penyesuaian terhadap kebijakan toko.

### 3.8 Implementasi antarmuka sebagai pendukung rancangan

Website yang tersedia dapat digunakan sebagai artefak implementasi dalam pembahasan. Bagian ini menguraikan hubungan halaman dengan alur usulan; tangkapan layar aktual perlu dilampirkan setelah halaman dibuka dan diperiksa.

**Tabel 9. Rencana gambar implementasi**

| Gambar | Halaman | Penjelasan yang menyertai gambar |
| --- | --- | --- |
| 4 | Dashboard | Ringkasan kondisi order dan nilai layanan untuk pemantauan |
| 5 | Tambah order | Pengumpulan data pelanggan, kondisi, foto, layanan, dan pembayaran |
| 6 | Daftar order | Penelusuran order dan pembaruan status oleh petugas |
| 7 | WhatsApp dari order | Pesan yang telah disiapkan dan masih perlu dikirim petugas |
| 8 | Pelanggan/member | Riwayat hubungan pelanggan, stempel, dan ketersediaan reward |
| 9 | Laporan | Pemilihan periode, ringkasan order, dan cetak laporan |
| 10 | Riwayat transaksi | Pencarian transaksi berdasarkan identitas atau periode |

Gunakan data contoh atau samarkan data pelanggan pada gambar yang dibagikan. Keterangan gambar harus menjelaskan perubahan proses yang didukung halaman, bukan hanya menyebutkan nama menu. Artikel tidak menyatakan bahwa seluruh halaman telah diuji melalui browser pada saat penyusunan draf ini.

### 3.9 Pembahasan dan keterbatasan

Kontribusi rancangan terletak pada penggunaan data order lintas kegiatan. Informasi penerimaan menjadi bahan komunikasi, pemantauan status, perhitungan member, dan rekap. Dengan penerapan prosedur yang disepakati, rancangan ini berpotensi mengurangi pemindahan informasi secara manual. Potensi tersebut masih memerlukan pembuktian melalui perbandingan proses aktual.

Dukungan aplikasi tidak menghilangkan kebutuhan pemeriksaan barang, perawatan fisik, pengiriman pesan oleh petugas, atau konfirmasi pembayaran non-tunai. Website juga tidak membuktikan bahwa antrean pengerjaan menjadi lebih pendek. Dampak pada antrean bergantung pada kapasitas petugas, jenis layanan, dan disiplin pembaruan status.

Keterbatasan utama kajian adalah belum tersedianya observasi proses lama, pengukuran durasi yang sebanding, dan validasi pemilik. Penelaahan kode hanya memberi bukti tentang rancangan perilaku perangkat lunak. Oleh karena itu, kesimpulan dibatasi pada rancangan integrasi proses dan kesiapan instrumen evaluasi. Klaim peningkatan biaya, kecepatan, maupun kepuasan pelanggan belum dapat dibuat.

## 4. Kesimpulan

Analisis website Raabshoes menghasilkan rancangan rekayasa ulang proses pelayanan yang menghubungkan penerimaan order, dokumentasi kondisi barang, pencatatan pembayaran, pemantauan pengerjaan, komunikasi WhatsApp, member, dan laporan melalui data order yang sama. Teknik ESIA digunakan untuk mengusulkan penggunaan kembali identitas pelanggan, penyederhanaan pencarian status, integrasi pelaporan, serta otomatisasi perhitungan dan penyusunan pesan yang didukung sistem.

Hasil yang dapat disimpulkan pada tahap ini adalah tersusunnya rancangan proses usulan dan instrumen evaluasi sesuai kemampuan website. Peningkatan efisiensi throughput dan penerimaan pengguna belum dapat disimpulkan. Penyelesaian penelitian memerlukan konfirmasi proses awal, observasi dengan batas pengukuran yang konsisten, serta validasi proses dan UAT bersama pihak Raabshoes. Hasil pengumpulan data tersebut menjadi dasar pembaruan abstrak, pembahasan, dan kesimpulan akhir.

## Referensi

[1] M. Hammer, “Reengineering Work: Don’t Automate, Obliterate,” Harvard Business Review, July–August 1990. [Laman penerbit](https://hbr.org/1990/07/reengineering-work-dont-automate-obliterate).

[2] R. Yusuf, E. D. Wahyuni, dan Z. Sari, “Business Process Reengineering (BPR) Pada Penerbitan Buku di UPT. Universitas Mataram Press,” Jurnal Repositor, vol. 5, no. 4, hlm. 865–884, 2023. DOI: [10.22219/repositor.v5i4.32087](https://doi.org/10.22219/repositor.v5i4.32087). Tahun mengikuti identitas terbitan pada naskah contoh; laman jurnal mencantumkan tanggal publikasi daring 29 Januari 2024.

[3] Pengembang Raabshoes, “Dokumen DAT/UAT Klien — Website Raab Shoes,” dokumen internal proyek, tanpa tanggal pengujian terisi, `docs/uat-dat-client.md`.

[4] Pengembang Raabshoes, “Implementasi Website Manajemen Raab Shoes,” kode sumber internal, `routes/web.php`, `app/Models/Customer.php`, dan `resources/views/reports/export.blade.php`, ditelaah untuk penyusunan draf pada 20 September 2026.

## Lampiran A. Identitas dan bukti observasi

| Informasi | Isian |
| --- | --- |
| Nama mahasiswa 1 / NIM | [isi] |
| Nama mahasiswa 2 / NIM, jika berkelompok | [isi; maksimal dua mahasiswa] |
| Nama usaha | Raabshoes |
| Alamat observasi | [isi alamat sebenarnya] |
| Tanggal dan durasi observasi | [isi] |
| Nama dan jabatan narasumber | [isi] |
| Kondisi penggunaan website saat observasi | [belum digunakan / uji coba / digunakan; jelaskan] |
| Bukti observasi | [foto kegiatan, tanda tangan, surat izin, atau bukti magang sesuai ketentuan tugas] |
| Batas pengumpulan pada slide tugas | 23 September 2026 |

## Lampiran B. Pedoman wawancara

1. Bagaimana urutan penerimaan sampai pengambilan barang sebelum website digunakan?
2. Media apa yang dipakai untuk mencatat pelanggan, order, pembayaran, dan laporan?
3. Aktivitas mana yang paling lama atau paling sering perlu dikerjakan ulang? Mintalah contoh nyata.
4. Siapa yang menerima barang, mengerjakan, memeriksa hasil, dan memberi kabar kepada pelanggan?
5. Kapan pembayaran dilakukan, dan bagaimana transfer atau QRIS dikonfirmasi?
6. Apakah data pelanggan lama digunakan kembali? Bagaimana menangani perubahan nomor telepon?
7. Bagaimana aturan stempel dan reward: jenis layanan, status yang dihitung, serta cara penukaran?
8. Angka apa yang dibutuhkan pemilik dalam laporan: nilai order, uang diterima, atau keduanya?
9. Apakah alur usulan sesuai kondisi toko? Bagian mana yang perlu direvisi?
10. Apakah tersedia bukti transaksi atau catatan lama untuk mendukung pengukuran pembanding?

## Lampiran C. Lembar pengamatan waktu

| Kode kasus anonim | Jenis layanan | Kondisi awal/usulan | Aktivitas | Pelaku | Mulai | Selesai | Durasi | Kategori | Catatan |
| --- | --- | --- | --- | --- | --- | --- | --- | --- | --- |
| [isi] | [isi] | [isi] | [isi] | [isi] | [isi] | [isi] | [isi] | [isi] | [isi] |

Catat jam kerja atau waktu kalender yang dipakai secara konsisten. Tandai aktivitas paralel, pengulangan akibat kesalahan, waktu tunggu, serta gangguan di luar proses normal. Pengamatan tidak perlu mengungkap identitas pelanggan dalam artikel.

## Lampiran D. Daftar penyelesaian naskah

- Lengkapi identitas penulis dan profil usaha berdasarkan informasi nyata.
- Konfirmasi dan revisi model proses awal serta Tabel 2–3 melalui observasi/wawancara.
- Lengkapi waktu pada Tabel 3, 6, dan 7; bedakan pengukuran lapangan dari simulasi.
- Isi hasil validasi pada Tabel 8 dan dokumen UAT berdasarkan pelaksanaan aktual.
- Tambahkan tangkapan layar asli sesuai Tabel 9 dan bukti observasi sesuai tugas.
- Perbarui abstrak serta kesimpulan setelah hasil empiris tersedia.
- Sesuaikan format halaman dengan template dosen; jangan mencantumkan ISSN atau identitas jurnal seolah artikel telah diterbitkan.
