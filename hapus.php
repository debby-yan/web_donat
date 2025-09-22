<?php
session_start();
include 'config.php';

// Cek apakah ada ID yang diterima
if(isset($_GET['id'])) {
    $id = $_GET['id'];

    // Query untuk menghapus produk
    $query = mysqli_query($koneksi, "DELETE FROM produk WHERE id='$id'");

    // Cek apakah penghapusan berhasil
    if($query) {
        $_SESSION['pesan'] = "Produk berhasil dihapus!";
    } else {
        $_SESSION['pesan'] = "Gagal menghapus produk: " . mysqli_error($koneksi);
    }
}

// Redirect kembali ke dashboard
header("Location: dashboard_admin.php");
exit;
?>