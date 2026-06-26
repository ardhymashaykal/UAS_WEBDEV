<?php
include '../koneksi.php';

$id_produk = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id_produk > 0) {
    // Cari nama dan gambar produk sebelum dihapus
    $query = mysqli_query($koneksi, "SELECT nama_produk, gambar FROM produk WHERE id_produk = $id_produk");
    
    if (mysqli_num_rows($query) > 0) {
        $prod = mysqli_fetch_assoc($query);
        $nama_produk = $prod['nama_produk'];
        $gambar = $prod['gambar'];
        
        // Hapus file gambar dari server jika ada
        if (!empty($gambar) && file_exists('../uploads/' . $gambar)) {
            unlink('../uploads/' . $gambar);
        }
        
        // Hapus record dari database
        $delete_query = mysqli_query($koneksi, "DELETE FROM produk WHERE id_produk = $id_produk");
        
        if ($delete_query) {
            header("Location: index.php?status=success&msg=Produk '" . urlencode($nama_produk) . "' berhasil dihapus!");
            exit;
        } else {
            header("Location: index.php?status=error&msg=Gagal menghapus produk: " . urlencode(mysqli_error($koneksi)));
            exit;
        }
    }
}

header("Location: index.php");
exit;
?>
