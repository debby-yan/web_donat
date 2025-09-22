<?php
session_start();
include 'config.php';

// ====================
// VALIDASI LOGIN
// ====================
if (!isset($_SESSION['id_user'])) {
    header('Location: login.php');
    exit;
}

// ====================
// AMBIL ID TRANSAKSI
// ====================
if (!isset($_GET['id'])) {
    echo "ID Transaksi tidak ditemukan.";
    exit;
}
$id_transaksi = intval($_GET['id']);

// ====================
// AMBIL DATA TRANSAKSI + USER
// ====================
$stmt = $koneksi->prepare("
    SELECT 
        t.id_transaksi, 
        t.tanggal, 
        t.total_harga, 
        u.nama, 
        u.email, 
        u.alamat, 
        u.hp
    FROM transaksi t
    JOIN users u ON t.id_pelanggan = u.id
    WHERE t.id_transaksi = ?
");
$stmt->bind_param("i", $id_transaksi);
$stmt->execute();
$res = $stmt->get_result();
$transaksi = $res->fetch_assoc();
$stmt->close();

if (!$transaksi) {
    echo "Transaksi tidak ditemukan.";
    exit;
}

// ====================
// AMBIL DETAIL TRANSAKSI
// ====================
$stmtDetail = $koneksi->prepare("
    SELECT d.qty, d.harga_satuan, p.nama 
    FROM detail_transaksi d
    JOIN produk p ON d.produk_id = p.id
    WHERE d.transaksi_id = ?
");
$stmtDetail->bind_param("i", $id_transaksi);
$stmtDetail->execute();
$resDetail = $stmtDetail->get_result();
$pesanan = $resDetail->fetch_all(MYSQLI_ASSOC);
$stmtDetail->close();

// Hitung subtotal
$subtotal = 0;
foreach ($pesanan as $item) {
    $subtotal += $item['harga_satuan'] * $item['qty'];
}
$ongkir = 10000;
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Invoice #<?= $transaksi['id_transaksi'] ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @media print {
            .no-print {
                display: none !important;
            }
            body {
                background: white !important;
            }
            .shadow-lg, .border {
                box-shadow: none !important;
                border: 1px solid #ccc !important;
            }
        }
    </style>
</head>
<body class="bg-blue-50 font-sans">
<div class="container mx-auto p-6">

    <!-- Logo -->
    <div class="flex flex-col items-center mb-6">
        <div class="w-24 h-24 rounded-full overflow-hidden shadow-lg border-4 border-blue-200 bg-white flex items-center justify-center">
            <img src="https://i.pinimg.com/736x/7d/a5/e8/7da5e8d2640d92b429cbcfee78355263.jpg" 
                 alt="Logo Donuts" 
                 class="w-full h-full object-cover">
        </div>
        <h2 class="mt-3 text-2xl font-bold text-blue-700">Donuts</h2>
    </div>

    <div class="bg-white shadow-lg rounded-2xl p-8 max-w-2xl mx-auto border border-blue-200">
        
        <!-- Judul -->
        <h1 class="text-3xl font-bold text-blue-700 mb-2">Invoice</h1>
        <p class="text-gray-600 mb-6">Detail pesanan kamu dari 
            <span class="font-semibold text-blue-600">Donuts</span>
        </p>

        <!-- Info Transaksi -->
        <div class="bg-blue-50 rounded-lg p-4 mb-6 text-left border border-blue-100">
            <p class="mb-2">Nomor Transaksi: <b class="text-blue-700">#<?= $transaksi['id_transaksi'] ?></b></p>
            <p class="mb-2">Tanggal: <?= $transaksi['tanggal'] ?></p>
            <p class="mb-2">Nama: <b><?= htmlspecialchars($transaksi['nama']) ?></b></p>
            <p class="mb-2">Email: <b><?= htmlspecialchars($transaksi['email']) ?></b></p>
            <p class="mb-2">Alamat: <b><?= htmlspecialchars($transaksi['alamat']) ?></b></p>
            <p class="mb-2">No. HP: <b><?= htmlspecialchars($transaksi['hp']) ?></b></p>
        </div>

        <!-- Ringkasan Pesanan -->
        <h2 class="text-xl font-semibold text-blue-700 mb-3">Ringkasan Pesanan</h2>
        <table class="w-full mb-6 border border-blue-200 rounded-lg overflow-hidden">
            <thead class="bg-blue-600 text-white">
                <tr>
                    <th class="py-2 px-4 text-left">Produk</th>
                    <th class="py-2 px-4 text-center">Qty</th>
                    <th class="py-2 px-4 text-right">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($pesanan as $item): ?>
                <tr class="border-b">
                    <td class="py-2 px-4"><?= htmlspecialchars($item['nama']) ?></td>
                    <td class="py-2 px-4 text-center">x<?= $item['qty'] ?></td>
                    <td class="py-2 px-4 text-right">
                        Rp <?= number_format($item['harga_satuan'] * $item['qty'], 0, ',', '.') ?>
                    </td>
                </tr>
                <?php endforeach; ?>
                <tr>
                    <td class="py-2 px-4" colspan="2">Subtotal</td>
                    <td class="py-2 px-4 text-right">
                        Rp <?= number_format($subtotal, 0, ',', '.') ?>
                    </td>
                </tr>
                <tr>
                    <td class="py-2 px-4" colspan="2">Ongkir</td>
                    <td class="py-2 px-4 text-right">
                        Rp <?= number_format($ongkir, 0, ',', '.') ?>
                    </td>
                </tr>
                <tr class="font-bold bg-blue-50">
                    <td class="py-2 px-4" colspan="2">Total Bayar</td>
                    <td class="py-2 px-4 text-right text-blue-700">
                        Rp <?= number_format($transaksi['total_harga'], 0, ',', '.') ?>
                    </td>
                </tr>
            </tbody>
        </table>

        <!-- Tombol -->
        <div class="flex gap-4 justify-center mb-6 no-print">
            <a href="index.php" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 shadow">
                Belanja Lagi
            </a>
            <button onclick="window.print()" 
               class="bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700 shadow">
                Cetak / Print
            </button>
        </div>
    </div>
</div>
</body>
</html>
