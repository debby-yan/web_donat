<?php
session_start();
include 'config.php';

// ================== CEK LOGIN ==================
if (!isset($_SESSION['id_user'])) {
    header('Location: login.php');
    exit;
}

$id_user = $_SESSION['id_user'];

// ================== AMBIL DATA USER ==================
$query = "SELECT * FROM users WHERE id = '$id_user' LIMIT 1";
$result = mysqli_query($koneksi, $query);
$user = mysqli_fetch_assoc($result);
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Informasi Akun</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-blue-50 via-blue-100 to-blue-200 min-h-screen font-sans">
  <div class="container mx-auto px-4 py-8 max-w-3xl">

    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
      <h1 class="text-3xl font-extrabold text-blue-700">Informasi Akun</h1>
      <a href="riwayat_transaksi.php" 
         class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-full shadow-md transition duration-200">
         📜 Riwayat Transaksi
      </a>
    </div>

    <!-- Card Profil -->
    <div class="bg-white shadow-xl rounded-2xl p-6 border border-blue-100">
      <div class="flex items-center space-x-4 border-b pb-4 mb-4">
        <!-- Foto Profil -->
        <img src="https://ui-avatars.com/api/?name=<?= urlencode($user['nama']) ?>&background=3b82f6&color=fff&rounded=true&size=80" 
             alt="Foto Profil" class="w-20 h-20 rounded-full shadow-md">
        <div>
          <h2 class="text-xl font-bold text-blue-800"><?= $user['nama'] ?></h2>
          <p class="text-gray-600">@<?= $user['username'] ?></p>
        </div>
      </div>

      <!-- Informasi -->
      <div class="space-y-4">
        <div class="flex justify-between">
          <span class="text-gray-600">Email</span>
          <span class="font-medium text-blue-900"><?= $user['email'] ?></span>
        </div>
        <div class="flex justify-between">
          <span class="text-gray-600">No HP</span>
          <span class="font-medium text-blue-900"><?= $user['hp'] ?></span>
        </div>
        <div class="flex justify-between">
          <span class="text-gray-600">Alamat</span>
          <span class="font-medium text-blue-900"><?= $user['alamat'] ?></span>
        </div>
      </div>
    </div>
  </div>
</body>
</html>
