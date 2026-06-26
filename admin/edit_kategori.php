<?php
include '../koneksi.php';

$id_kategori = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($id_kategori <= 0) {
    header("Location: kategori.php");
    exit;
}

// Ambil data kategori saat ini
$query_kat = mysqli_query($koneksi, "SELECT * FROM kategori WHERE id_kategori = $id_kategori");
if (mysqli_num_rows($query_kat) == 0) {
    header("Location: kategori.php");
    exit;
}
$kat = mysqli_fetch_assoc($query_kat);

$error_msg = "";

if (isset($_POST['submit'])) {
    $nama_kategori = mysqli_real_escape_string($koneksi, $_POST['nama_kategori']);

    if (!empty($nama_kategori)) {
        // Cek apakah ada nama kategori yang sama (kecuali kategori yang sedang diedit ini)
        $check_query = mysqli_query($koneksi, "SELECT * FROM kategori WHERE nama_kategori = '$nama_kategori' AND id_kategori != $id_kategori");
        
        if (mysqli_num_rows($check_query) > 0) {
            $error_msg = "Kategori dengan nama '$nama_kategori' sudah terdaftar.";
        } else {
            $query_update = "UPDATE kategori SET nama_kategori = '$nama_kategori' WHERE id_kategori = $id_kategori";
            if (mysqli_query($koneksi, $query_update)) {
                header("Location: kategori.php?status=success&msg=Kategori '" . urlencode($nama_kategori) . "' berhasil diperbarui!");
                exit;
            } else {
                $error_msg = "Gagal memperbarui kategori: " . mysqli_error($koneksi);
            }
        }
    } else {
        $error_msg = "Nama kategori tidak boleh kosong.";
    }
}

include 'header.php';
?>

<div class="row justify-content-center">
    <div class="col-lg-6">
        <div class="mb-4">
            <a href="kategori.php" class="btn btn-outline-secondary btn-sm">
                <i class="bi bi-arrow-left"></i> Kembali ke Daftar Kategori
            </a>
        </div>

        <div class="form-card">
            <h2 class="display-font fw-bold mb-4">Edit Kategori</h2>
            
            <?php if (!empty($error_msg)): ?>
                <div class="alert alert-danger" role="alert">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i> <?php echo $error_msg; ?>
                </div>
            <?php endif; ?>

            <form action="edit_kategori.php?id=<?php echo $id_kategori; ?>" method="POST">
                <div class="row g-3">
                    <div class="col-12">
                        <label class="form-label" for="nama_kategori">Nama Kategori <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="nama_kategori" name="nama_kategori" value="<?php echo htmlspecialchars($kat['nama_kategori']); ?>" required>
                    </div>

                    <div class="col-12 mt-4">
                        <button type="submit" name="submit" class="btn btn-primary btn-lg w-100">
                            <i class="bi bi-save me-1"></i> Perbarui Kategori
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
