<?php
include '../koneksi.php';

$error_msg = "";

if (isset($_POST['submit'])) {
    $nama_produk = mysqli_real_escape_string($koneksi, $_POST['nama_produk']);
    $id_kategori = (int)$_POST['id_kategori'];
    $harga       = (int)$_POST['harga'];
    $stok        = (int)$_POST['stok'];
    $deskripsi   = mysqli_real_escape_string($koneksi, $_POST['deskripsi']);
    $gambar      = "";

    // Upload Gambar
    if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] == 0) {
        $target_dir = "../uploads/";
        // Buat folder uploads jika belum ada
        if (!file_exists($target_dir)) {
            mkdir($target_dir, 0777, true);
        }

        $file_name = time() . '_' . basename($_FILES['gambar']['name']);
        $target_file = $target_dir . $file_name;
        $image_file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        
        // Validasi tipe berkas
        $allowed_types = ['jpg', 'jpeg', 'png', 'webp', 'gif'];
        if (in_array($image_file_type, $allowed_types)) {
            if (move_uploaded_file($_FILES['gambar']['tmp_name'], $target_file)) {
                $gambar = $file_name;
            } else {
                $error_msg = "Gagal mengunggah berkas gambar.";
            }
        } else {
            $error_msg = "Format file tidak didukung. Harap gunakan JPG, JPEG, PNG, WEBP, atau GIF.";
        }
    }

    // Jika tidak ada error upload, lakukan query insert
    if (empty($error_msg)) {
        $query = "INSERT INTO produk (id_kategori, nama_produk, deskripsi, harga, stok, gambar) 
                  VALUES ($id_kategori, '$nama_produk', '$deskripsi', $harga, $stok, '$gambar')";
        
        if (mysqli_query($koneksi, $query)) {
            header("Location: index.php?status=success&msg=Produk '" . urlencode($nama_produk) . "' berhasil ditambahkan!");
            exit;
        } else {
            $error_msg = "Gagal menyimpan produk ke database: " . mysqli_error($koneksi);
        }
    }
}

include 'header.php';
?>

<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="mb-4">
            <a href="index.php" class="btn btn-outline-secondary btn-sm">
                <i class="bi bi-arrow-left"></i> Kembali ke Daftar Produk
            </a>
        </div>

        <div class="form-card">
            <h2 class="display-font fw-bold mb-4">Tambah Produk Baru</h2>
            
            <?php if (!empty($error_msg)): ?>
                <div class="alert alert-danger" role="alert">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i> <?php echo $error_msg; ?>
                </div>
            <?php endif; ?>

            <form action="tambah_produk.php" method="POST" enctype="multipart/form-data">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label" for="nama_produk">Nama Produk <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="nama_produk" name="nama_produk" placeholder="Contoh: Buket Mawar Merah" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label" for="id_kategori">Kategori <span class="text-danger">*</span></label>
                        <select class="form-select" id="id_kategori" name="id_kategori" required>
                            <option value="">-- Pilih Kategori --</option>
                            <?php
                            $query_kat = mysqli_query($koneksi, "SELECT * FROM kategori");
                            while ($kat = mysqli_fetch_assoc($query_kat)) {
                                echo '<option value="' . $kat['id_kategori'] . '">' . htmlspecialchars($kat['nama_kategori']) . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                    
                    <div class="col-md-6">
                        <label class="form-label" for="harga">Harga (Rp) <span class="text-danger">*</span></label>
                        <input type="number" class="form-control" id="harga" name="harga" placeholder="Contoh: 150000" min="0" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label" for="stok">Stok Awal <span class="text-danger">*</span></label>
                        <input type="number" class="form-control" id="stok" name="stok" placeholder="Contoh: 10" min="0" required>
                    </div>

                    <div class="col-12">
                        <label class="form-label" for="gambar">Foto Produk</label>
                        <input type="file" class="form-control" id="gambar" name="gambar" accept="image/*">
                        <div class="form-text text-muted">Format yang didukung: JPG, PNG, WEBP. Maksimal 2MB. (Kosongkan jika tidak memakai foto)</div>
                    </div>

                    <div class="col-12">
                        <label class="form-label" for="deskripsi">Deskripsi Produk <span class="text-danger">*</span></label>
                        <textarea class="form-control" id="deskripsi" name="deskripsi" rows="5" placeholder="Tuliskan spesifikasi, warna bunga, ukuran buket, dll..." required></textarea>
                    </div>

                    <div class="col-12 mt-4">
                        <button type="submit" name="submit" class="btn btn-primary btn-lg w-100">
                            <i class="bi bi-check-circle me-1"></i> Simpan Produk
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<?php
include 'footer.php';
?>
