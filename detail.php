<?php
include 'koneksi.php';
include 'header.php';

// Validasi parameter ID
$id_produk = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($id_produk <= 0) {
    header("Location: katalog.php");
    exit;
}

// Query ambil data produk & kategori
$query = mysqli_query($koneksi, "
    SELECT produk.*, kategori.nama_kategori 
    FROM produk 
    LEFT JOIN kategori ON produk.id_kategori = kategori.id_kategori 
    WHERE produk.id_produk = $id_produk
");

if (mysqli_num_rows($query) == 0) {
    echo '<div class="container py-5 text-center"><h3 class="fw-bold">Produk tidak ditemukan!</h3><a href="katalog.php" class="btn btn-primary mt-3">Kembali ke Katalog</a></div>';
    include 'footer.php';
    exit;
}

$prod = mysqli_fetch_assoc($query);

// Helper function to get image or placeholder
function get_detail_image($gambar_path) {
    if (!empty($gambar_path) && file_exists('uploads/' . $gambar_path)) {
        return '<img src="uploads/' . htmlspecialchars($gambar_path) . '" alt="Detail Produk" class="img-fluid rounded-4 shadow-sm w-100" style="object-fit: cover; aspect-ratio: 1/1;">';
    } else {
        return '
        <div class="flower-placeholder rounded-4">
            <div class="flower-placeholder-icon" style="font-size: 6rem;">💐</div>
            <p class="mt-2 text-muted fw-bold">Premium Florist Bouquet</p>
        </div>';
    }
}

// Prefilled message WhatsApp
$wa_number = "6281234567890"; // Ganti dengan nomor WhatsApp pemilik
$wa_message = "Halo SamslepFlor, saya tertarik untuk memesan:\n\n";
$wa_message .= "Produk: " . $prod['nama_produk'] . "\n";
$wa_message .= "Kategori: " . $prod['nama_kategori'] . "\n";
$wa_message .= "Harga: Rp " . number_format($prod['harga'], 0, ',', '.') . "\n\n";
$wa_message .= "Apakah produk ini tersedia untuk dipesan sekarang?";
$wa_url = "https://wa.me/" . $wa_number . "?text=" . urlencode($wa_message);
?>

<div class="container py-5">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.php" class="text-decoration-none text-muted">Home</a></li>
            <li class="breadcrumb-item"><a href="katalog.php" class="text-decoration-none text-muted">Katalog</a></li>
            <li class="breadcrumb-item"><a href="katalog.php?kategori=<?php echo $prod['id_kategori']; ?>" class="text-decoration-none text-muted"><?php echo htmlspecialchars($prod['nama_kategori']); ?></a></li>
            <li class="breadcrumb-item active text-primary" aria-current="page"><?php echo htmlspecialchars($prod['nama_produk']); ?></li>
        </ol>
    </nav>

    <!-- Detail Content -->
    <div class="row g-5">
        <!-- Kolom Gambar -->
        <div class="col-lg-6">
            <div class="detail-img-wrapper">
                <?php echo get_detail_image($prod['gambar']); ?>
            </div>
        </div>

        <!-- Kolom Informasi -->
        <div class="col-lg-6">
            <div class="d-flex flex-column h-100 justify-content-center">
                <span class="badge bg-light text-primary border align-self-start mb-2 px-3 py-2 rounded-pill fw-bold text-uppercase" style="font-size: 0.8rem; letter-spacing: 1px;">
                    <?php echo htmlspecialchars($prod['nama_kategori']); ?>
                </span>
                <h1 class="display-5 fw-bold mb-3 display-font"><?php echo htmlspecialchars($prod['nama_produk']); ?></h1>
                
                <div class="d-flex align-items-center mb-4">
                    <span class="detail-price me-4">Rp <?php echo number_format($prod['harga'], 0, ',', '.'); ?></span>
                    
                    <?php if ($prod['stok'] > 0): ?>
                        <span class="badge bg-success-subtle text-success border border-success-subtle px-3 py-2 rounded-pill fw-bold">
                            <i class="bi bi-check-circle-fill me-1"></i> Stok Tersedia (<?php echo $prod['stok']; ?>)
                        </span>
                    <?php else: ?>
                        <span class="badge bg-danger-subtle text-danger border border-danger-subtle px-3 py-2 rounded-pill fw-bold">
                            <i class="bi bi-x-circle-fill me-1"></i> Stok Habis
                        </span>
                    <?php endif; ?>
                </div>

                <hr class="mb-4">

                <h5 class="fw-bold mb-2">Deskripsi Produk</h5>
                <p class="text-secondary mb-4" style="line-height: 1.8;">
                    <?php echo nl2br(htmlspecialchars($prod['deskripsi'])); ?>
                </p>

                <div class="row g-3">
                    <div class="col-md-6">
                        <a href="<?php echo $wa_url; ?>" target="_blank" class="btn btn-primary btn-lg w-100 d-flex align-items-center justify-content-center <?php echo $prod['stok'] == 0 ? 'disabled' : ''; ?>">
                            <i class="bi bi-whatsapp me-2" style="font-size: 1.3rem;"></i> Pesan via WhatsApp
                        </a>
                    </div>
                    <div class="col-md-6">
                        <a href="katalog.php" class="btn btn-outline-secondary btn-lg w-100">
                            Kembali ke Katalog
                        </a>
                    </div>
                </div>

                <!-- Info Box -->
                <div class="card border-0 bg-light rounded-4 p-3 mt-4">
                    <div class="d-flex align-items-center">
                        <span class="fs-3 text-primary me-3"><i class="bi bi-info-circle-fill"></i></span>
                        <p class="mb-0 text-muted" style="font-size: 0.85rem;">
                            <strong>Catatan:</strong> Foto produk di atas merupakan ilustrasi desain premium. Anda dapat melakukan kustomisasi kartu ucapan dan detail tambahan saat memesan via WhatsApp.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
include 'footer.php';
?>
