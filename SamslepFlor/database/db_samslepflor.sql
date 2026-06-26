-- Create Database
CREATE DATABASE IF NOT EXISTS db_samslepflor;
USE db_samslepflor;

-- Create Table Kategori
CREATE TABLE IF NOT EXISTS kategori (
    id_kategori INT AUTO_INCREMENT PRIMARY KEY,
    nama_kategori VARCHAR(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Create Table Produk
CREATE TABLE IF NOT EXISTS produk (
    id_produk INT AUTO_INCREMENT PRIMARY KEY,
    id_kategori INT,
    nama_produk VARCHAR(150) NOT NULL,
    deskripsi TEXT NOT NULL,
    harga INT NOT NULL,
    stok INT NOT NULL,
    gambar VARCHAR(255) NOT NULL,
    FOREIGN KEY (id_kategori) REFERENCES kategori(id_kategori) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Insert Data Kategori
INSERT INTO kategori (id_kategori, nama_kategori) VALUES
(1, 'Buket Bunga'),
(2, 'Bunga Papan'),
(3, 'Bunga Meja'),
(4, 'Bunga Pot');

-- Insert Data Produk (Minimal 20 Data Dummy Bunga)
INSERT INTO produk (id_produk, id_kategori, nama_produk, deskripsi, harga, stok, gambar) VALUES
(1, 1, 'Buket Mawar Merah Premium', 'Buket bunga mawar merah segar pilihan sebanyak 20 tangkai, dibungkus dengan kertas wrapping premium bernuansa pink lembut dan putih. Sangat cocok untuk hari ulang tahun, anniversary, atau ungkapan kasih sayang.', 350000, 10, ''),
(2, 1, 'Buket Mawar Putih Graceful', 'Kombinasi mawar putih melambangkan ketulusan dan keanggunan. Dihiasi dengan baby\'s breath segar dan dibungkus cantik dengan pita satin satin putih.', 320000, 8, ''),
(3, 1, 'Buket Bunga Tulip Pink', 'Buket bunga tulip import berwarna pink lembut yang segar dan menawan. Pilihan sempurna untuk merayakan momen spesial atau hadiah kelulusan.', 450000, 5, ''),
(4, 1, 'Buket Bunga Matahari Sunburst', 'Tiga tangkai bunga matahari besar yang cerah dikombinasikan dengan daun eucalyptus dan kemasan rustik. Membawa keceriaan dan energi positif.', 180000, 12, ''),
(5, 1, 'Buket Baby\'s Breath Sweet', 'Buket penuh bunga baby\'s breath segar yang dikeringkan dengan indah. Memiliki daya tahan sangat lama dan tampilan minimalis yang manis.', 220000, 15, ''),
(6, 1, 'Buket Mawar Pink Pastel', 'Buket bunga mawar pink pastel romantis dengan selingan daun perak dolan. Pilihan favorit untuk menyatakan perasaan cinta.', 340000, 7, ''),
(7, 2, 'Bunga Papan Congratulation', 'Bunga papan ukuran 2x1.25 meter untuk ucapan selamat atas peresmian toko, pelantikan, atau kesuksesan bisnis. Didekorasi dengan bunga segar di sekelilingnya.', 850000, 4, ''),
(8, 2, 'Bunga Papan Duka Cita Elegance', 'Bunga papan duka cita dengan warna-warna tenang (putih, biru, hijau) sebagai bentuk penghormatan terakhir yang mendalam bagi kerabat atau rekan kerja.', 750000, 6, ''),
(9, 2, 'Bunga Papan Happy Wedding Luxury', 'Bunga papan pernikahan megah dengan kombinasi warna pink, merah, dan emas. Menggunakan mahkota bunga ganda di bagian atas dan bawah.', 1200000, 3, ''),
(10, 2, 'Bunga Papan Anniversary Kantor', 'Bunga papan ucapan selamat ulang tahun perusahaan atau anniversary instansi. Menggunakan bahan berkualitas tinggi dan dekorasi bunga melimpah.', 900000, 5, ''),
(11, 3, 'Bunga Meja Anggrek Bulan Putih', 'Rangkaian anggrek bulan putih premium 2 tangkai dalam pot keramik eksklusif. Menambah kemewahan dan keindahan ruang tamu atau ruang kerja Anda.', 650000, 4, ''),
(12, 3, 'Bunga Meja Mawar dan Hydrangea', 'Kombinasi bunga hydrangea biru dan mawar pink segar di dalam vas kaca bening. Sangat cocok diletakkan di meja makan atau meja sudut.', 400000, 6, ''),
(13, 3, 'Bunga Meja Lily & Carnation', 'Rangkaian bunga lily putih wangi dikombinasikan dengan carnation peach yang manis di dalam vas keramik putih minimalis.', 380000, 9, ''),
(14, 3, 'Bunga Meja Rustik Kering', 'Rangkaian bunga kering eksotis seperti cantel, lagurus, kaspia, dan pinus di dalam vas anyaman rotan. Tahan bertahun-tahun tanpa perawatan air.', 250000, 14, ''),
(15, 3, 'Bunga Meja Daisy & Gerberas', 'Rangkaian bunga daisy warna-warni dan gerbera orange yang ceria dalam mangkuk vas keramik. Cocok untuk penyemangat di meja kerja.', 280000, 11, ''),
(16, 4, 'Bunga Pot Kaktus Mini Sukulen', 'Satu set 3 pot kecil tanaman sukulen dan kaktus mini hias. Dilengkapi dengan pot tanah liat estetik, sangat mudah dirawat di dalam ruangan.', 120000, 20, ''),
(17, 4, 'Bunga Pot Lavender Harum', 'Tanaman bunga lavender asli dalam pot yang mengeluarkan aroma menenangkan alami untuk membantu mengusir nyamuk dan merelaksasi ruangan.', 850000, 15, ''),
(18, 4, 'Bunga Pot Anthurium Merah', 'Tanaman hias pot anthurium merah menyala dengan daun hijau mengkilap yang segar. Tahan di dalam ruangan semi-outdoor.', 175000, 8, ''),
(19, 4, 'Bunga Pot Krisan Kuning', 'Tanaman bunga krisan (chrysanthemum) berwarna kuning cerah yang sedang mekar penuh di dalam pot plastik putih bersih.', 95000, 12, ''),
(20, 4, 'Bunga Pot Begonia Rex', 'Tanaman hias begonia berdaun indah bernuansa pink kemerahan dalam pot minimalis. Sangat cocok diletakkan di teras rumah.', 130000, 10, '');
