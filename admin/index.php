<?php
include 'header.php';

// Cek jika ada notifikasi CRUD sukses dari session/redirect
$status = isset($_GET['status']) ? $_GET['status'] : '';
$msg = isset($_GET['msg']) ? htmlspecialchars($_GET['msg']) : '';

// SweetAlert trigger based on status
if ($status == 'success') {
    echo "
    <script>
        Swal.fire({
            title: 'Berhasil!',
            text: '$msg',
            icon: 'success',
            confirmButtonColor: '#ff6f91'
        });
    </script>
    ";
} elseif ($status == 'error') {
    echo "
    <script>
        Swal.fire({
            title: 'Gagal!',
            text: '$msg',
            icon: 'error',
            confirmButtonColor: '#ff6f91'
        });
    </script>
    ";
}

// Query ambil semua produk
$query_prod = mysqli_query($koneksi, "
    SELECT produk.*, kategori.nama_kategori 
    FROM produk 
    LEFT JOIN kategori ON produk.id_kategori = kategori.id_kategori 
    ORDER BY produk.id_produk DESC
");
?>

<div class="row mb-4 align-items-center">
    <div class="col-md-6">
        <h2 class="display-font fw-bold m-0">Kelola Produk</h2>
        <p class="text-secondary mb-0">Daftar semua produk bunga yang tampil di halaman katalog pengunjung.</p>
    </div>
    <div class="col-md-6 text-md-end mt-3 mt-md-0">
        <a href="tambah_produk.php" class="btn btn-primary">
            <i class="bi bi-plus-circle me-1"></i> Tambah Produk Baru
        </a>
    </div>
</div>

<!-- Table Card -->
<div class="card border-0 shadow-sm rounded-4 overflow-hidden">
    <div class="table-responsive">
        <table class="table admin-table mb-0 align-middle">
            <thead>
                <tr>
                    <th style="width: 80px;">Gambar</th>
                    <th>Nama Produk</th>
                    <th>Kategori</th>
                    <th>Harga</th>
                    <th style="width: 100px;">Stok</th>
                    <th class="text-center" style="width: 180px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (mysqli_num_rows($query_prod) > 0) {
                    while ($prod = mysqli_fetch_assoc($query_prod)) {
                        $gambar = $prod['gambar'];
                        $gambar_path = '../uploads/' . $gambar;
                        ?>
                        <tr>
                            <td>
                                <div class="admin-thumbnail-wrapper">
                                    <?php if (!empty($gambar) && file_exists($gambar_path)): ?>
                                        <img src="<?php echo $gambar_path; ?>" alt="Thumb" class="admin-thumbnail">
                                    <?php else: ?>
                                        <div class="admin-thumbnail-placeholder">🌸</div>
                                    <?php endif; ?>
                                </div>
                            </td>
                            <td>
                                <div class="fw-bold text-dark"><?php echo htmlspecialchars($prod['nama_produk']); ?></div>
                                <small class="text-muted text-truncate d-inline-block" style="max-width: 300px;">
                                    <?php echo htmlspecialchars($prod['deskripsi']); ?>
                                </small>
                            </td>
                            <td>
                                <span class="badge bg-light text-primary border px-2 py-1 rounded-pill">
                                    <?php echo htmlspecialchars($prod['nama_kategori']); ?>
                                </span>
                            </td>
                            <td class="fw-bold text-primary-dark">
                                Rp <?php echo number_format($prod['harga'], 0, ',', '.'); ?>
                            </td>
                            <td>
                                <?php if ($prod['stok'] > 0): ?>
                                    <span class="badge bg-success-subtle text-success border border-success-subtle">
                                        <?php echo $prod['stok']; ?> pcs
                                    </span>
                                <?php else: ?>
                                    <span class="badge bg-danger-subtle text-danger border border-danger-subtle">
                                        Habis
                                    </span>
                                <?php endif; ?>
                            </td>
                            <td class="text-center">
                                <div class="btn-group gap-1">
                                    <a href="edit_produk.php?id=<?php echo $prod['id_produk']; ?>" class="btn btn-sm btn-outline-warning rounded-3" title="Edit">
                                        <i class="bi bi-pencil-fill"></i> Edit
                                    </a>
                                    <button onclick="confirmDelete(<?php echo $prod['id_produk']; ?>, '<?php echo addslashes($prod['nama_produk']); ?>')" class="btn btn-sm btn-outline-danger rounded-3" title="Hapus">
                                        <i class="bi bi-trash-fill"></i> Hapus
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <?php
                    }
                } else {
                    ?>
                    <tr>
                        <td colspan="6" class="text-center py-5 text-muted">
                            <i class="bi bi-box-seam display-4 d-block mb-3 text-secondary"></i>
                            Belum ada produk yang didaftarkan.
                        </td>
                    </tr>
                    <?php
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

<script>
function confirmDelete(id, name) {
    Swal.fire({
        title: 'Apakah Anda yakin?',
        text: "Anda akan menghapus produk '" + name + "'. Tindakan ini tidak dapat dibatalkan!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Ya, hapus!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = 'hapus_produk.php?id=' + id;
        }
    });
}
</script>

<?php
include 'footer.php';
?>
