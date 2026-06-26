<?php
include '../koneksi.php';
$current_page = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - SamslepFlor</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
    <!-- Custom CSS (Kembali satu tingkat ke folder css/) -->
    <link rel="stylesheet" href="../css/style.css">
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="bg-light">

<!-- Admin Navigation -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top">
    <div class="container">
        <a class="navbar-brand text-white fw-bold" href="index.php">
            Samslep<span class="text-primary">Flor</span> <small class="text-muted" style="font-size: 0.8rem; font-weight: 400;">(Admin Panel)</small>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#adminNavbar" aria-controls="adminNavbar" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="adminNavbar">
            <ul class="navbar-nav ms-auto align-items-center">
                <li class="nav-item">
                    <a class="nav-link text-white-50 <?php echo ($current_page == 'index.php' || $current_page == 'tambah_produk.php' || $current_page == 'edit_produk.php') ? 'active fw-bold text-white' : ''; ?>" href="index.php">
                        <i class="bi bi-box-seam me-1"></i> Produk
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white-50 <?php echo ($current_page == 'kategori.php' || $current_page == 'tambah_kategori.php' || $current_page == 'edit_kategori.php') ? 'active fw-bold text-white' : ''; ?>" href="kategori.php">
                        <i class="bi bi-tags me-1"></i> Kategori
                    </a>
                </li>
                <li class="nav-item ms-lg-3">
                    <a class="btn btn-outline-light btn-sm px-3" href="../index.php" target="_blank">
                        <i class="bi bi-globe2 me-1"></i> Lihat Website
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div class="container py-5">
