<?php
include '../koneksi.php';

$id_produk = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($id_produk <= 0) {
    header("Location: index.php");
    exit;
}

// Ambil data produk saat ini
$query_prod = mysqli_query($koneksi, "SELECT * FROM produk WHERE id_produk = $id_produk");
if (mysqli_num_rows($query_prod) == 0) {
    header("Location: index.php");
    exit;
}
$prod = mysqli_fetch_assoc($query_prod);

$error_msg = "";

if (isset($_POST['submit'])) {
    $nama_produk = mysqli_real_escape_string($koneksi, $_POST['nama_produk']);
    $id_kategori = (int)$_POST['id_kategori'];
    $harga       = (int)$_POST['harga'];
    $stok        = (int)$_POST['stok'];
    $deskripsi   = mysqli_real_escape_string($koneksi, $_POST['deskripsi']);
    $gambar      = $prod['gambar']; // Default retain old image

    // Cek jika ada unggahan gambar baru
    if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] == 0) {
        $target_dir = "../uploads/";
        if (!file_exists($target_dir)) {
            mkdir($target_dir, 0777, true);
        }

        $file_name = time() . '_' . basename($_FILES['gambar']['name']);
        $target_file = $target_dir . $file_name;
        $image_file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        
        $allowed_types = ['jpg', 'jpeg', 'png', 'webp', 'gif'];
        if (in_array($image_file_type, $allowed_types)) {
            if (move_uploaded_file($_FILES['gambar']['tmp_name'], $target_file)) {
                // Hapus gambar lama jika ada dan file-nya memang ada di server
                if (!empty($prod['gambar']) && file_exists($target_dir . $prod['gambar'])) {
                    unlink($target_dir . $prod['gambar']);
                }
                $gambar = $file_name; // Set gambar baru
            } else {
                $error_msg = "Gagal mengunggah berkas gambar baru.";
            }
        } else {
            $error_msg = "Format file tidak didukung. Harap gunakan JPG, JPEG, PNG, WEBP, atau GIF.";
        }
    }

    // Update data jika tidak ada error upload
    if (empty($error_msg)) {
        $query_update = "
            UPDATE produk SET 
                id_kategori = $id_kategori, 
                nama_produk = '$nama_produk', 
                deskripsi = '$deskripsi', 
                harga = $harga, 
                stok = $stok, 
                gambar = '$gambar' 
            WHERE id_produk = $id_produk
        ";
        
        if (mysqli_query($koneksi, $query_update)) {
            header("Location: index.php?status=success&msg=Produk '" . urlencode($nama_produk) . "' berhasil diperbarui!");
            exit;
        } else {
            $error_msg = "Gagal memperbarui produk: " . mysqli_error($koneksi);
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
            <h2 class="display-font fw-bold mb-4">Edit Produk</h2>
            
            <?php if (!empty($error_msg)): ?>
                <div class="alert alert-danger" role="alert">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i> <?php echo $error_msg; ?>
                </div>
            <?php endif; ?>

            <form action="edit_produk.php?id=<?php echo $id_produk; ?>" method="POST" enctype="multipart/form-data">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label" for="nama_produk">Nama Produk <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="nama_produk" name="nama_produk" value="<?php echo htmlspecialchars($prod['nama_produk']); ?>" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label" for="id_kategori">Kategori <span class="text-danger">*</span></label>
                        <select class="form-select" id="id_kategori" name="id_kategori" required>
                            <option value="">-- Pilih Kategori --</option>
                            <?php
                            $query_kat = mysqli_query($koneksi, "SELECT * FROM kategori");
                            while ($kat = mysqli_fetch_assoc($query_kat)) {
                                $selected = ($kat['id_kategori'] == $prod['id_kategori']) ? 'selected' : '';
                                echo '<option value="' . $kat['id_kategori'] . '" ' . $selected . '>' . htmlspecialchars($kat['nama_kategori']) . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                    
                    <div class="col-md-6">
                        <label class="form-label" for="harga">Harga (Rp) <span class="text-danger">*</span></label>
                        <input type="number" class="form-control" id="harga" name="harga" value="<?php echo $prod['harga']; ?>" min="0" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label" for="stok">Stok <span class="text-danger">*</span></label>
                        <input type="number" class="form-control" id="stok" name="stok" value="<?php echo $prod['stok']; ?>" min="0" required>
                    </div>

                    <!-- Kolom Gambar Saat Ini -->
                    <div class="col-12">
                        <label class="form-label d-block">Foto Saat Ini</label>
                        <div class="mb-3">
                            <?php if (!empty($prod['gambar']) && file_exists('../uploads/' . $prod['gambar'])): ?>
                                <div class="admin-thumbnail-wrapper" style="width: 120px; height: 120px;">
                                    <img src="../uploads/<?php echo htmlspecialchars($prod['gambar']); ?>" alt="Foto Produk" class="admin-thumbnail">
                                </div>
                            <?php else: ?>
                                <span class="text-muted italic"><i class="bi bi-image"></i> Tidak ada foto</span>
                            <?php endif; ?>
                        </div>
                        
                        <label class="form-label" for="gambar">Ganti Foto Produk</label>
                        <input type="file" class="form-control" id="gambar" name="gambar" accept="image/*">
                        <div class="form-text text-muted">Format yang didukung: JPG, PNG, WEBP. Biarkan kosong jika tidak ingin mengubah foto.</div>
                    </div>

                    <div class="col-12">
                        <label class="form-label" for="deskripsi">Deskripsi Produk <span class="text-danger">*</span></label>
                        <textarea class="form-control" id="deskripsi" name="deskripsi" rows="5" required><?php echo htmlspecialchars($prod['deskripsi']); ?></textarea>
                    </div>

                    <div class="col-12 mt-4">
                        <button type="submit" name="submit" class="btn btn-primary btn-lg w-100">
                            <i class="bi bi-save me-1"></i> Perbarui Produk
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
