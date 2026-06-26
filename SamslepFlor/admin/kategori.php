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

// Query ambil semua kategori beserta jumlah produknya
$query_kat = mysqli_query($koneksi, "
    SELECT kategori.*, COUNT(produk.id_produk) as jumlah_produk 
    FROM kategori 
    LEFT JOIN produk ON kategori.id_kategori = produk.id_kategori 
    GROUP BY kategori.id_kategori 
    ORDER BY kategori.id_kategori ASC
");
?>

<div class="row mb-4 align-items-center">
    <div class="col-md-6">
        <h2 class="display-font fw-bold m-0">Kelola Kategori</h2>
        <p class="text-secondary mb-0">Kelompokkan produk bunga Anda ke dalam kategori agar memudahkan pencarian pengunjung.</p>
    </div>
    <div class="col-md-6 text-md-end mt-3 mt-md-0">
        <a href="tambah_kategori.php" class="btn btn-primary">
            <i class="bi bi-plus-circle me-1"></i> Tambah Kategori Baru
        </a>
    </div>
</div>

<!-- Table Card -->
<div class="card border-0 shadow-sm rounded-4 overflow-hidden">
    <div class="table-responsive">
        <table class="table admin-table mb-0 align-middle">
            <thead>
                <tr>
                    <th style="width: 100px;">ID Kategori</th>
                    <th>Nama Kategori</th>
                    <th>Jumlah Produk Terkait</th>
                    <th class="text-center" style="width: 200px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (mysqli_num_rows($query_kat) > 0) {
                    while ($kat = mysqli_fetch_assoc($query_kat)) {
                        ?>
                        <tr>
                            <td class="fw-bold text-muted">#<?php echo $kat['id_kategori']; ?></td>
                            <td class="fw-bold text-dark"><?php echo htmlspecialchars($kat['nama_kategori']); ?></td>
                            <td>
                                <span class="badge bg-light text-secondary border px-3 py-1 rounded-pill">
                                    <?php echo $kat['jumlah_produk']; ?> produk
                                </span>
                            </td>
                            <td class="text-center">
                                <div class="btn-group gap-1">
                                    <a href="edit_kategori.php?id=<?php echo $kat['id_kategori']; ?>" class="btn btn-sm btn-outline-warning rounded-3">
                                        <i class="bi bi-pencil-fill"></i> Edit
                                    </a>
                                    <button onclick="confirmDelete(<?php echo $kat['id_kategori']; ?>, '<?php echo addslashes($kat['nama_kategori']); ?>')" class="btn btn-sm btn-outline-danger rounded-3">
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
                        <td colspan="4" class="text-center py-5 text-muted">
                            <i class="bi bi-tags display-4 d-block mb-3 text-secondary"></i>
                            Belum ada kategori yang ditambahkan.
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
        text: "Menghapus kategori '" + name + "' juga akan menghapus SEMUA produk di dalam kategori tersebut secara otomatis!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Ya, hapus!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = 'hapus_kategori.php?id=' + id;
        }
    });
}
</script>

<?php
include 'footer.php';
?>
