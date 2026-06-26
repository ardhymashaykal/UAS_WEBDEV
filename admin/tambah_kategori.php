<?php
include '../koneksi.php';

$error_msg = "";

if (isset($_POST['submit'])) {
    $nama_kategori = mysqli_real_escape_string($koneksi, $_POST['nama_kategori']);

    if (!empty($nama_kategori)) {
        // Cek apakah kategori sudah ada
        $check_query = mysqli_query($koneksi, "SELECT * FROM kategori WHERE nama_kategori = '$nama_kategori'");
        
        if (mysqli_num_rows($check_query) > 0) {
            $error_msg = "Kategori dengan nama '$nama_kategori' sudah terdaftar.";
        } else {
            $query = "INSERT INTO kategori (nama_kategori) VALUES ('$nama_kategori')";
            if (mysqli_query($koneksi, $query)) {
                header("Location: kategori.php?status=success&msg=Kategori '" . urlencode($nama_kategori) . "' berhasil ditambahkan!");
                exit;
            } else {
                $error_msg = "Gagal menyimpan kategori ke database: " . mysqli_error($koneksi);
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
            <h2 class="display-font fw-bold mb-4">Tambah Kategori Baru</h2>
            
            <?php if (!empty($error_msg)): ?>
                <div class="alert alert-danger" role="alert">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i> <?php echo $error_msg; ?>
                </div>
            <?php endif; ?>

            <form action="tambah_kategori.php" method="POST">
                <div class="row g-3">
                    <div class="col-12">
                        <label class="form-label" for="nama_kategori">Nama Kategori <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="nama_kategori" name="nama_kategori" placeholder="Contoh: Bunga Kering" required>
                    </div>

                    <div class="col-12 mt-4">
                        <button type="submit" name="submit" class="btn btn-primary btn-lg w-100">
                            <i class="bi bi-check-circle me-1"></i> Simpan Kategori
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
