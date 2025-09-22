<?php
session_start();
include 'config.php';

// ======================= CEK USER LOGIN =======================
$user = null;
$username = '';
$profile_picture = 'img/default-profile.jpg';

if (isset($_SESSION['id_user'])) {
    $id = $_SESSION['id_user'];
    $res = mysqli_query($koneksi, "SELECT * FROM users WHERE id='$id'");
    $user = mysqli_fetch_assoc($res);
}

if (isset($_SESSION['user_id'])) { 
    $user_id = $_SESSION['user_id']; 
    $stmt = $koneksi->prepare("SELECT username, profile_picture FROM users WHERE id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $res = $stmt->get_result();
    if ($row = $res->fetch_assoc()) {
        $username = $row['username'];
        $profile_picture = !empty($row['profile_picture']) ? $row['profile_picture'] : 'img/default-profile.jpg';
        $user = $row;
    }
    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Kontak - Donuts</title>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />

    <style>
        .contact-card { transition: all 0.3s ease; }
        .contact-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 20px rgba(0, 0, 0, 0.06);
        }
    </style>
</head>
<body class="bg-[#F0F8FF] text-gray-800 font-sans">

<!-- ======================= NAVBAR ======================= -->
<nav class="bg-white shadow-md sticky top-0 z-50">
    <div class="container mx-auto px-4 py-3 flex justify-between items-center">
        <!-- Logo -->
        <div class="flex items-center space-x-2">
            <img src="https://i.pinimg.com/736x/7d/a5/e8/7da5e8d2640d92b429cbcfee78355263.jpg" alt="Logo" class="h-10">
            <span class="text-xl font-bold text-blue-600">Donuts</span>
        </div>

        <!-- Menu Links -->
        <div class="hidden md:flex space-x-6">
            <a href="index.php" class="text-gray-700 hover:text-blue-600 font-medium">Beranda</a>
            <a href="produk.php" class="text-gray-700 hover:text-blue-600 font-medium">Produk</a>
            <a href="kategori.php" class="text-gray-700 hover:text-blue-600 font-medium">Kategori</a>
            <a href="tentang.php" class="text-gray-700 hover:text-blue-600 font-medium">Tentang Kami</a>
            <a href="kontak.php" class="text-gray-700 hover:text-blue-600 font-medium">Kontak</a>
        </div>

        <!-- Right Side -->
        <div class="flex items-center space-x-3">
            <!-- Keranjang -->
            <a href="keranjang.php" class="relative inline-block">
                <i class="fa-solid fa-cart-shopping text-2xl text-gray-700"></i>
                <?php if (!empty($_SESSION['cart'])): ?>
                    <?php $cart_count = array_sum($_SESSION['cart']); ?>
                    <span class="absolute -top-2 -right-2 bg-red-600 text-white text-xs font-bold rounded-full px-2 py-0.5">
                        <?= $cart_count ?>
                    </span>
                <?php endif; ?>
            </a>

            <!-- Profil atau Login -->
            <?php if (!empty($user)): ?>
                <a href="profile.php" class="flex items-center space-x-2 hover:text-blue-600">
                    <img src="img/<?= htmlspecialchars($user['profile_picture'] ?? 'default.jpg') ?>" alt="Profile" class="h-8 w-8 rounded-full object-cover">
                    <span><?= htmlspecialchars($user['username']) ?></span>
                </a>
            <?php else: ?>
                <a href="login.php" class="hover:text-blue-600">
                    <i class="fas fa-user"></i> Login  
                </a>
            <?php endif; ?>
        </div>
    </div>
</nav>

<!-- ======================= HERO ======================= -->
<section class="bg-gradient-to-r from-blue-100 to-blue-200 py-12 text-center">
    <h1 class="text-4xl font-extrabold text-blue-700 mb-2">🍩 Hubungi Kami</h1>
    <p class="text-gray-700 opacity-80 text-lg">Kami siap mendengar pertanyaan dan masukan Anda</p>
</section>

<!-- ======================= KONTEN ======================= -->
<div class="container mx-auto px-4 py-12">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

        <!-- Info Kontak -->
        <div class="contact-card bg-white rounded-3xl p-6">
            <h3 class="text-2xl font-bold mb-4 text-blue-600">📍 Informasi Kontak</h3>
            <p class="flex items-center mb-3"><i class="fas fa-map-marker-alt w-6 text-blue-500"></i>Jl. Jendral Sudirman No 49, Cirebon</p>
            <p class="flex items-center mb-3"><i class="fas fa-phone w-6 text-blue-500"></i>+62 823-1759-20647</p>
            <p class="flex items-center"><i class="fas fa-envelope w-6 text-blue-500"></i>donuts@gmail.com</p>
            <div class="mt-6 flex space-x-4">
                <a href="#" class="bg-blue-100 p-3 rounded-full hover:bg-blue-600 hover:text-white transition"><i class="fab fa-facebook"></i></a>
                <a href="#" class="bg-blue-100 p-3 rounded-full hover:bg-blue-600 hover:text-white transition"><i class="fab fa-instagram"></i></a>
                <a href="#" class="bg-blue-100 p-3 rounded-full hover:bg-blue-600 hover:text-white transition"><i class="fab fa-whatsapp"></i></a>
            </div>
        </div>

        <!-- Formulir Kontak -->
        <div class="contact-card bg-white rounded-3xl p-6">
            <h3 class="text-2xl font-bold mb-4 text-blue-600">📝 Kirim Pesan</h3>

            <!-- Alert -->
            <?php if (!empty($success)): ?>
                <div class="p-3 mb-4 text-green-700 bg-green-100 rounded-lg"><?= htmlspecialchars($success) ?></div>
            <?php elseif (!empty($error)): ?>
                <div class="p-3 mb-4 text-red-700 bg-red-100 rounded-lg"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>

            <form action="" method="POST" class="space-y-4">
                <input type="text" name="name" placeholder="Nama Lengkap" required 
                       class="w-full border border-gray-300 rounded-full p-3 focus:border-blue-600 focus:ring-2 focus:ring-blue-400 outline-none">
                <input type="email" name="email" placeholder="Alamat Email" required 
                       class="w-full border border-gray-300 rounded-full p-3 focus:border-blue-600 focus:ring-2 focus:ring-blue-400 outline-none">
                <textarea name="message" rows="4" placeholder="Tulis pesanmu di sini..." required 
                          class="w-full border border-gray-300 rounded-2xl p-3 focus:border-blue-600 focus:ring-2 focus:ring-blue-400 outline-none"></textarea>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-full shadow-md transition font-medium">
                    <i class="fas fa-paper-plane mr-2"></i>Kirim Pesan
                </button>
            </form>
        </div>

    </div>
</div>

<!-- ======================= FOOTER ======================= -->
<footer class="bg-blue-50 text-gray-700 py-6 mt-12">
    <div class="container mx-auto text-center text-sm">
        <p>© <?= date("Y") ?> Donuts. All rights reserved.</p>
    </div>
</footer>

</body>
</html>
