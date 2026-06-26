<?php
include 'koneksi.php';
include 'header.php';

// Helper function to get image or placeholder
function get_product_image($gambar_path) {
    if (!empty($gambar_path) && file_exists('uploads/' . $gambar_path)) {
        return '<img src="uploads/' . htmlspecialchars($gambar_path) . '" alt="Produk" class="product-img">';
    } else {
        return '
        <div class="flower-placeholder">
            <div class="flower-placeholder-icon">🌸</div>
        </div>';
    }
}

// Parameter pencarian & filter
$search = isset($_GET['search']) ? mysqli_real_escape_string($koneksi, $_GET['search']) : '';
$kategori_filter = isset($_GET['kategori']) ? (int)$_GET['kategori'] : 0;

// Pagination setup
$limit = 9;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
if ($page < 1) $page = 1;
$offset = ($page - 1) * $limit;

// Bangun query filter
$where_clauses = [];
if (!empty($search)) {
    $where_clauses[] = "produk.nama_produk LIKE '%$search%'";
}
if ($kategori_filter > 0) {
    $where_clauses[] = "produk.id_kategori = $kategori_filter";
}

$where_sql = "";
if (count($where_clauses) > 0) {
    $where_sql = "WHERE " . implode(" AND ", $where_clauses);
}

// Hitung total data untuk pagination
$total_query = mysqli_query($koneksi, "SELECT COUNT(*) as total FROM produk $where_sql");
$total_data = mysqli_fetch_assoc($total_query)['total'];
$total_pages = ceil($total_data / $limit);

// Query produk
$query_sql = "
    SELECT produk.*, kategori.nama_kategori 
    FROM produk 
    LEFT JOIN kategori ON produk.id_kategori = kategori.id_kategori 
    $where_sql 
    ORDER BY produk.id_produk DESC 
    LIMIT $limit OFFSET $offset
";
$query_prod = mysqli_query($koneksi, $query_sql);
?>

<div class="container py-5">
    <div class="row g-4">
        <!-- Sidebar Filter (Kiri) -->
        <div class="col-lg-3">
            <div class="card border-0 shadow-sm rounded-4 p-4 mb-4" style="background-color: var(--white);">
                <h4 class="mb-4 display-font" style="font-size: 1.5rem; font-weight: 700;">Cari & Filter</h4>
                
                <!-- Form Pencarian -->
                <form action="katalog.php" method="GET" class="mb-4">
                    <?php if ($kategori_filter > 0): ?>
                        <input type="hidden" name="kategori" value="<?php echo $kategori_filter; ?>">
                    <?php endif; ?>
                    <label class="form-label">Nama Produk</label>
                    <div class="input-group">
                        <input type="text" class="form-control" name="search" placeholder="Cari mawar, papan, dll..." value="<?php echo htmlspecialchars($search); ?>">
                        <button class="btn btn-primary" type="submit">
                            <i class="bi bi-search"></i>
                        </button>
                    </div>
                    <?php if (!empty($search)): ?>
                        <div class="form-text">
                            <a href="katalog.php?kategori=<?php echo $kategori_filter; ?>" class="text-decoration-none text-muted">Hapus pencarian</a>
                        </div>
                    <?php endif; ?>
                </form>

                <!-- Kategori Filter List -->
                <div>
                    <label class="form-label mb-3">Pilih Kategori</label>
                    <div class="list-group list-group-flush">
                        <a href="katalog.php?search=<?php echo urlencode($search); ?>" class="list-group-item list-group-item-action border-0 px-0 d-flex justify-content-between align-items-center <?php echo $kategori_filter == 0 ? 'fw-bold text-primary' : 'text-secondary'; ?>">
                            <span>Semua Kategori</span>
                            <i class="bi bi-chevron-right"></i>
                        </a>
                        <?php
                        $query_kat = mysqli_query($koneksi, "SELECT * FROM kategori");
                        while ($kat = mysqli_fetch_assoc($query_kat)) {
                            $id_kat = $kat['id_kategori'];
                            $active_class = ($kategori_filter == $id_kat) ? 'fw-bold text-primary' : 'text-secondary';
                            
                            // Hitung jumlah produk per kategori
                            $count_query = mysqli_query($koneksi, "SELECT COUNT(*) as count FROM produk WHERE id_kategori = $id_kat");
                            $count_data = mysqli_fetch_assoc($count_query)['count'];
                            ?>
                            <a href="katalog.php?kategori=<?php echo $id_kat; ?>&search=<?php echo urlencode($search); ?>" class="list-group-item list-group-item-action border-0 px-0 d-flex justify-content-between align-items-center <?php echo $active_class; ?>">
                                <span><?php echo htmlspecialchars($kat['nama_kategori']); ?></span>
                                <span class="badge rounded-pill bg-light text-dark border"><?php echo $count_data; ?></span>
                            </a>
                            <?php
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Grid Produk (Kanan) -->
        <div class="col-lg-9">
            <!-- Header Filter & Info Hasil -->
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4">
                <div>
                    <h2 class="display-font mb-1" style="font-size: 2rem; font-weight: 700;">Katalog Produk</h2>
                    <p class="text-muted mb-0">
                        <?php if ($total_data > 0): ?>
                            Menampilkan <?php echo ($offset + 1); ?>–<?php echo min($offset + $limit, $total_data); ?> dari <?php echo $total_data; ?> hasil rangkaian bunga.
                        <?php else: ?>
                            Tidak ada produk ditemukan.
                        <?php endif; ?>
                    </p>
                </div>
            </div>

            <!-- Grid -->
            <div class="row g-4">
                <?php
                if (mysqli_num_rows($query_prod) > 0) {
                    while ($prod = mysqli_fetch_assoc($query_prod)) {
                        ?>
                        <div class="col-md-6 col-lg-4">
                            <div class="product-card">
                                <div class="product-img-wrapper">
                                    <span class="product-badge"><?php echo htmlspecialchars($prod['nama_kategori']); ?></span>
                                    <?php echo get_product_image($prod['gambar']); ?>
                                </div>
                                <div class="product-body">
                                    <div class="product-category"><?php echo htmlspecialchars($prod['nama_kategori']); ?></div>
                                    <h3 class="product-name">
                                        <a href="detail.php?id=<?php echo $prod['id_produk']; ?>">
                                            <?php echo htmlspecialchars($prod['nama_produk']); ?>
                                        </a>
                                    </h3>
                                    <div class="d-flex justify-content-between align-items-center mt-3">
                                        <span class="product-price">Rp <?php echo number_format($prod['harga'], 0, ',', '.'); ?></span>
                                        <span class="product-stock text-muted">Stok: <?php echo $prod['stok']; ?></span>
                                    </div>
                                    <div class="mt-3">
                                        <a href="detail.php?id=<?php echo $prod['id_produk']; ?>" class="btn btn-outline-primary w-100 btn-sm">Lihat Detail</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                } else {
                    ?>
                    <div class="col-12 py-5 text-center">
                        <div class="display-1 text-muted"><i class="bi bi-search"></i></div>
                        <h4 class="mt-3 fw-bold">Ups! Produk Tidak Ditemukan</h4>
                        <p class="text-secondary">Silakan cari dengan kata kunci lain atau pilih kategori yang berbeda.</p>
                        <a href="katalog.php" class="btn btn-primary mt-3">Kembali ke Katalog</a>
                    </div>
                    <?php
                }
                ?>
            </div>

            <!-- Pagination -->
            <?php if ($total_pages > 1): ?>
                <nav class="mt-5" aria-label="Navigasi Halaman">
                    <ul class="pagination justify-content-center">
                        <li class="page-item <?php echo $page <= 1 ? 'disabled' : ''; ?>">
                            <a class="page-link" href="katalog.php?page=<?php echo $page - 1; ?>&kategori=<?php echo $kategori_filter; ?>&search=<?php echo urlencode($search); ?>" aria-label="Previous">
                                <span aria-hidden="true">&laquo;</span>
                            </a>
                        </li>
                        
                        <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                            <li class="page-item <?php echo $page == $i ? 'active' : ''; ?>">
                                <a class="page-link" href="katalog.php?page=<?php echo $i; ?>&kategori=<?php echo $kategori_filter; ?>&search=<?php echo urlencode($search); ?>">
                                    <?php echo $i; ?>
                                </a>
                            </li>
                        <?php endfor; ?>

                        <li class="page-item <?php echo $page >= $total_pages ? 'disabled' : ''; ?>">
                            <a class="page-link" href="katalog.php?page=<?php echo $page + 1; ?>&kategori=<?php echo $kategori_filter; ?>&search=<?php echo urlencode($search); ?>" aria-label="Next">
                                <span aria-hidden="true">&raquo;</span>
                            </a>
                        </li>
                    </ul>
                </nav>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php
include 'footer.php';
?>
