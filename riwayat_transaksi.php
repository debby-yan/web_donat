<?php
session_start();
include 'config.php'; // koneksi database

// ================== CEK LOGIN ==================
if (!isset($_SESSION['id_user'])) {
    header('Location: login.php');
    exit;
}

$user_id = $_SESSION['id_user'];
 
// ================== AMBIL TRANSAKSI ==================
$query_transaksi = "
    SELECT t.id_transaksi, t.id_pelanggan, t.tanggal, t.total_harga
    FROM transaksi t
    WHERE t.id_pelanggan = '$user_id'
    ORDER BY t.tanggal DESC
";
$transaksi = mysqli_query($koneksi, $query_transaksi);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Transaksi</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-blue-50 to-blue-100 min-h-screen">
    <div class="container mx-auto px-4 py-6">

        <!-- HEADER -->
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-extrabold text-blue-700">Riwayat Transaksi</h1>
            <a href="profile.php" 
               class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg shadow-md transition">
                ← Kembali ke Profil
            </a>
        </div>

        <?php if (mysqli_num_rows($transaksi) === 0): ?>
            <p class="text-center text-gray-600">Belum ada transaksi.</p>
        <?php else: ?>
            <?php while ($trx = mysqli_fetch_assoc($transaksi)): ?>
                <div class="bg-white shadow-lg rounded-xl p-4 mb-6 border border-blue-100">
                    
                    <!-- HEADER TRANSAKSI -->
                    <div class="flex justify-between items-center border-b pb-2 mb-3">
                        <div>
                            <p class="font-semibold text-blue-700">
                                Nomor Pesanan: #<?= $trx['id_transaksi'] ?>
                            </p>
                            <p class="text-sm text-gray-500">Tanggal: <?= $trx['tanggal'] ?></p>
                        </div>
                    </div>

                    <!-- DETAIL PRODUK -->
                    <div class="overflow-x-auto">
                        <table class="w-full border-collapse border text-sm">
                            <thead>
                                <tr class="bg-blue-100 text-blue-800">
                                    <th class="py-2 px-3 border">Produk</th>
                                    <th class="py-2 px-3 border">Harga</th>
                                    <th class="py-2 px-3 border">Qty</th>
                                    <th class="py-2 px-3 border">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $id_transaksi = $trx['id_transaksi'];
                                $query_detail = "
                                    SELECT p.nama, p.foto, d.harga_satuan, d.qty
                                    FROM detail_transaksi d
                                    JOIN produk p ON d.produk_id = p.id
                                    WHERE d.transaksi_id = '$id_transaksi'
                                ";
                                $detail = mysqli_query($koneksi, $query_detail);
                                while ($item = mysqli_fetch_assoc($detail)):
                                    $subtotal = $item['harga_satuan'] * $item['qty'];
                                    $foto = "img/" . $item['foto'];
                                ?>
                                <tr class="hover:bg-blue-50 transition">
                                    <td class="py-2 px-3 border flex items-center space-x-2">
                                        <img src="<?= $foto ?>" 
                                             alt="<?= $item['nama'] ?>" 
                                             class="w-12 h-12 object-cover rounded border"
                                             onerror="this.onerror=null;this.src='https://via.placeholder.com/50?text=No+Img';">
                                        <span><?= $item['nama'] ?></span>
                                    </td>
                                    <td class="py-2 px-3 border">
                                        Rp <?= number_format($item['harga_satuan'], 0, ',', '.') ?>
                                    </td>
                                    <td class="py-2 px-3 border"><?= $item['qty'] ?></td>
                                    <td class="py-2 px-3 border">
                                        Rp <?= number_format($subtotal, 0, ',', '.') ?>
                                    </td>
                                </tr>
                                <?php endwhile; ?>
                            </tbody>
                            <tfoot>
                                <tr class="font-semibold bg-blue-50">
                                    <td colspan="3" class="py-2 px-3 border text-right">Total</td>
                                    <td class="py-2 px-3 border text-blue-700">
                                        Rp <?= number_format($trx['total_harga'], 0, ',', '.') ?>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php endif; ?>
    </div>
</body>
</html>
