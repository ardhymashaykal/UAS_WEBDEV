========================================================================
                      SamslepFlor - Premium Florist Website
========================================================================

Website florist premium yang dibuat menggunakan PHP Native, MySQL,
Bootstrap 5, dan SweetAlert2.

------------------------------------------------------------------------
STRUKTUR FOLDER
------------------------------------------------------------------------
SamslepFlor/
│
├── admin/
│   ├── index.php         <- Daftar produk admin
│   ├── tambah_produk.php  <- Form tambah produk & upload gambar
│   ├── edit_produk.php    <- Form edit produk
│   ├── hapus_produk.php   <- Proses hapus produk & gambar
│   ├── kategori.php       <- Daftar kategori admin
│   ├── tambah_kategori.php <- Form tambah kategori
│   ├── edit_kategori.php  <- Form edit kategori
│   └── hapus_kategori.php <- Proses hapus kategori & produk terkait
│
├── css/
│   └── style.css          <- Custom styling tema florist (pink & putih)
│
├── uploads/               <- Folder penyimpanan gambar yang diunggah
│
├── database/
│   └── db_samslepflor.sql <- Skema database + 20 data dummy produk bunga
│
├── koneksi.php            <- Berkas konfigurasi koneksi MySQL
├── index.php              <- Halaman Utama pengunjung
├── katalog.php            <- Katalog dengan filter kategori & search
├── detail.php             <- Detail spesifikasi produk & tombol beli WA
├── about.php              <- Profil / Tentang Toko
├── contact.php            <- Kontak Hubungi Kami dengan SweetAlert
└── README.txt             <- Petunjuk instalasi ini

------------------------------------------------------------------------
CARA INSTALASI & MENJALANKAN DI XAMPP
------------------------------------------------------------------------
1. Ekstrak atau salin seluruh folder `SamslepFlor` ke dalam direktori
   `htdocs` milik XAMPP Anda (biasanya di `C:\xampp\htdocs\SamslepFlor`).

2. Nyalakan module Apache dan MySQL pada XAMPP Control Panel.

3. Buka browser dan akses phpMyAdmin di alamat:
   `http://localhost/phpmyadmin/`

4. Buat database baru bernama:
   `db_samslepflor`

5. Klik menu "Import" (Impor) di phpMyAdmin, lalu pilih file SQL:
   `SamslepFlor/database/db_samslepflor.sql`
   Lalu klik tombol "Import" (atau "Go" / "Kirim") di bagian bawah.

6. Buka file `koneksi.php` menggunakan text editor jika kredensial
   database MySQL XAMPP Anda berbeda dari default:
   - Host: localhost
   - User: root
   - Password: (kosong)
   - Database: db_samslepflor

7. Akses website melalui browser Anda:
   - Halaman Pengunjung : http://localhost/SamslepFlor/
   - Halaman Admin CRUD : http://localhost/SamslepFlor/admin/

------------------------------------------------------------------------
FITUR UTAMA
------------------------------------------------------------------------
- Frontend modern & elegan dengan palet warna pink dan putih (Bootstrap 5).
- Search produk & Filter kategori secara real-time dari database.
- Integrasi SweetAlert2 untuk respon notifikasi tambah, edit, & hapus data.
- Tombol Pemesanan langsung terhubung ke WhatsApp otomatis terisi teks pesanan.
- Responsif di berbagai resolusi layar (Mobile, Tablet, Desktop).
- Keamanan penanganan file gambar produk yang diunggah (terhapus otomatis dari
  server saat produk atau kategori produk tersebut dihapus).
- Tanpa sistem login/registrasi untuk mempermudah pengelolaan backoffice lokal.
========================================================================
