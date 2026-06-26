<?php
include '../koneksi.php';

$id_kategori = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id_kategori > 0) {
    // Cari nama kategori
    $query_kat = mysqli_query($koneksi, "SELECT nama_kategori FROM kategori WHERE id_kategori = $id_kategori");
    
    if (mysqli_num_rows($query_kat) > 0) {
        $kat = mysqli_fetch_assoc($query_kat);
        $nama_kategori = $kat['nama_kategori'];
        
        // Temukan semua gambar produk di bawah kategori ini dan hapus file gambarnya dari disk
        $query_prod = mysqli_query($koneksi, "SELECT gambar FROM produk WHERE id_kategori = $id_kategori");
        while ($prod = mysqli_fetch_assoc($query_prod)) {
            $gambar = $prod['gambar'];
            if (!empty($gambar) && file_exists('../uploads/' . $gambar)) {
                unlink('../uploads/' . $gambar);
            }
        }
        
        // Hapus kategori dari database (jika CASCADE diatur di DB, produk juga otomatis terhapus)
        $delete_query = mysqli_query($koneksi, "DELETE FROM kategori WHERE id_kategori = $id_kategori");
        
        if ($delete_query) {
            header("Location: kategori.php?status=success&msg=Kategori '" . urlencode($nama_kategori) . "' beserta produk di dalamnya berhasil dihapus!");
            exit;
        } else {
            header("Location: kategori.php?status=error&msg=Gagal menghapus kategori: " . urlencode(mysqli_error($koneksi)));
            exit;
        }
    }
}

header("Location: kategori.php");
exit;
?>
