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
?>

<!-- Hero Banner -->
<section class="hero-section d-flex align-items-center">
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-lg-6">
                <span class="hero-badge">Selamat Datang di SamslepFlor</span>
                <h1 class="hero-title">Rangkai Momen Indah dengan <span>Bunga Terbaik</span></h1>
                <p class="lead mb-4 text-secondary">
                    Kami menyediakan berbagai pilihan rangkaian bunga segar premium, mulai dari buket cantik, bunga meja elegan, hingga bunga papan megah untuk segala keperluan Anda.
                </p>
                <div class="d-flex gap-3">
                    <a href="katalog.php" class="btn btn-primary btn-lg">Lihat Katalog</a>
                    <a href="contact.php" class="btn btn-outline-primary btn-lg">Hubungi Kami</a>
                </div>
            </div>
            <div class="col-lg-6 d-none d-lg-block">
                <!-- Abstract florist visual overlay using pure CSS & bootstrap -->
                <div class="position-relative mx-auto" style="width: 450px; height: 450px;">
                    <div class="position-absolute top-0 start-0 w-100 h-100 rounded-circle" style="background: linear-gradient(135deg, #ffeef2 0%, #ffd3b6 100%); z-index: 1;"></div>
                    <div class="position-absolute rounded-4 shadow" style="width: 280px; height: 350px; background: white; top: 50px; left: 30px; z-index: 2; border: 8px solid white; transform: rotate(-5deg); overflow: hidden;">
                        <div class="w-100 h-100 d-flex flex-column align-items-center justify-content-center" style="background: linear-gradient(135deg, #ffeef2 0%, #ffcbd5 100%);">
                            <span style="font-size: 5rem;">💐</span>
                            <span class="mt-2 fw-bold text-dark display-font" style="font-size: 1.2rem;">Fresh Bouquet</span>
                        </div>
                    </div>
                    <div class="position-absolute rounded-4 shadow" style="width: 220px; height: 260px; background: white; bottom: 30px; right: 20px; z-index: 3; border: 6px solid white; transform: rotate(8deg); overflow: hidden;">
                        <div class="w-100 h-100 d-flex flex-column align-items-center justify-content-center" style="background: linear-gradient(135deg, #e3f2fd 0%, #ffeef2 100%);">
                            <span style="font-size: 4rem;">🌸</span>
                            <span class="mt-2 fw-bold text-dark display-font" style="font-size: 1rem;">Table Flower</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Kategori Section -->
<section class="py-5 bg-white">
    <div class="container py-4">
        <div class="section-title">
            <h2>Kategori Pilihan</h2>
            <p class="text-muted">Temukan rangkaian bunga berdasarkan momen dan keperluan Anda</p>
        </div>
        <div class="row g-4 justify-content-center">
            <?php
            $query_kat = mysqli_query($koneksi, "SELECT * FROM kategori");
            $icons = [
                1 => '💐', // Buket Bunga
                2 => '🎀', // Bunga Papan
                3 => '🏺', // Bunga Meja
                4 => '🪴'  // Bunga Pot
            ];
            while ($kat = mysqli_fetch_assoc($query_kat)) {
                $id_kat = $kat['id_kategori'];
                $icon = isset($icons[$id_kat]) ? $icons[$id_kat] : '🌸';
                ?>
                <div class="col-lg-3 col-md-6">
                    <a href="katalog.php?kategori=<?php echo $id_kat; ?>" class="text-decoration-none">
                        <div class="category-card">
                            <span class="category-icon"><?php echo $icon; ?></span>
                            <h3 class="category-title"><?php echo htmlspecialchars($kat['nama_kategori']); ?></h3>
                        </div>
                    </a>
                </div>
                <?php
            }
            ?>
        </div>
    </div>
</section>

<!-- Produk Terbaru Section -->
<section class="py-5">
    <div class="container py-4">
        <div class="section-title">
            <h2>Rangkaian Bunga Terbaru</h2>
            <p class="text-muted">Koleksi teranyar yang baru saja dirangkai oleh florist ahli kami</p>
        </div>
        <div class="row g-4">
            <?php
            $query_prod = mysqli_query($koneksi, "
                SELECT produk.*, kategori.nama_kategori 
                FROM produk 
                LEFT JOIN kategori ON produk.id_kategori = kategori.id_kategori 
                ORDER BY produk.id_produk DESC 
                LIMIT 4
            ");
            
            if (mysqli_num_rows($query_prod) > 0) {
                while ($prod = mysqli_fetch_assoc($query_prod)) {
                    ?>
                    <div class="col-lg-3 col-md-6">
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
                echo '<div class="col-12 text-center"><p class="text-muted">Belum ada produk terdaftar.</p></div>';
            }
            ?>
        </div>
        <div class="text-center mt-5">
            <a href="katalog.php" class="btn btn-primary">Lihat Semua Produk</a>
        </div>
    </div>
</section>

<!-- Keunggulan Section -->
<section class="py-5 bg-white">
    <div class="container py-4">
        <div class="row g-4 text-center">
            <div class="col-md-4">
                <div class="p-3">
                    <span class="display-5 text-primary mb-3 d-inline-block"><i class="bi bi-patch-check-fill"></i></span>
                    <h4 class="fw-bold mb-2">Bunga Segar Pilihan</h4>
                    <p class="text-muted">Kami menggunakan bunga-bunga segar berkualitas tinggi yang dipetik setiap pagi.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="p-3">
                    <span class="display-5 text-primary mb-3 d-inline-block"><i class="bi bi-truck"></i></span>
                    <h4 class="fw-bold mb-2">Pengiriman Cepat</h4>
                    <p class="text-muted">Layanan pengiriman di hari yang sama untuk menjaga kesegaran rangkaian bunga Anda.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="p-3">
                    <span class="display-5 text-primary mb-3 d-inline-block"><i class="bi bi-palette-fill"></i></span>
                    <h4 class="fw-bold mb-2">Desain Kustom</h4>
                    <p class="text-muted">Bisa request model rangkain, kombinasi bunga, dan warna pembungkus sesuai selera Anda.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<?php
include 'footer.php';
?>
