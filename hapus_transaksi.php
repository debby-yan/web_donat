<?php
session_start();
include 'config.php';

// CEK LOGIN ADMIN
if (!isset($_SESSION['id_user']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit;
}

$id_transaksi = $_GET['id'] ?? 0;

// Hapus detail transaksi dulu (biar FK tidak error)
mysqli_query($koneksi, "DELETE FROM detail_transaksi WHERE transaksi_id = '$id_transaksi'");

// Hapus transaksi utama
mysqli_query($koneksi, "DELETE FROM transaksi WHERE id_transaksi = '$id_transaksi'");

// Redirect balik ke riwayat admin
header("Location: riwayat_transaksi_admin.php");
exit;
