<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Ambil data ringkasan
$pakaian = $conn->query("SELECT COUNT(*) AS total FROM lemari_pakaian WHERE user_id=" . $_SESSION['user_id'])->fetch_assoc();
$skincare = $conn->query("SELECT COUNT(*) AS total FROM lemari_skincare WHERE user_id=" . $_SESSION['user_id'])->fetch_assoc();
$jadwal = $conn->query("SELECT * FROM jadwal WHERE user_id=" . $_SESSION['user_id'] . " ORDER BY hari LIMIT 3");

// Ambil jadwal untuk hari ini
$tanggal_hari_ini = date('Y-m-d');
$sql = "SELECT * FROM jadwal WHERE user_id=" . $_SESSION['user_id'] . " AND tanggal = '$tanggal_hari_ini'";
$jadwal_hari_ini = $conn->query($sql);


?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Dashboard</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  <style>
    body {
      font-family: 'Poppins', sans-serif;
    }
  </style>
</head>
<body class="bg-gradient-to-br from-indigo-600 via-purple-600 to-pink-500 min-h-screen p-6">

  <div class="max-w-5xl mx-auto bg-white rounded-3xl shadow-2xl p-10">
    <h2 class="text-3xl font-bold text-gray-800 mb-2">
      Selamat datang, <span class="text-indigo-600"><?= $_SESSION['username'] ?>!</span>
    </h2>
    <p class="text-gray-600 mb-6">Ini ringkasan aktivitasmu hari ini.</p>

    <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 mb-10">
      <div class="bg-indigo-100 p-5 rounded-xl shadow hover:shadow-xl transition">
        <h3 class="text-xl font-semibold text-indigo-800 mb-2">👕 Pakaian</h3>
        <p class="text-3xl font-bold"><?= $pakaian['total'] ?></p>
        <a href="lemari_pakaian.php" class="text-sm text-indigo-600 hover:underline">Lihat detail</a>
      </div>
      <div class="bg-pink-100 p-5 rounded-xl shadow hover:shadow-xl transition">
        <h3 class="text-xl font-semibold text-pink-800 mb-2">💄 Skincare</h3>
        <p class="text-3xl font-bold"><?= $skincare['total'] ?></p>
        <a href="lemari_skincare.php" class="text-sm text-pink-600 hover:underline">Lihat detail</a>
      </div>
      <div class="bg-green-100 p-5 rounded-xl shadow hover:shadow-xl transition">
        <h3 class="text-xl font-semibold text-green-800 mb-2">📅 Jadwal Terdekat</h3>
        <?php while ($j = $jadwal->fetch_assoc()): ?>
          <div class="text-sm text-gray-700 mb-1">
            <?= date('d M Y', strtotime($j['tanggal'])) ?> - <span class="font-medium"><?= htmlspecialchars($j['kegiatan']) ?></span>
          </div>
        <?php
        endwhile; ?>
        <a href="jadwal.php" class="text-sm text-green-600 hover:underline">Lihat semua</a>
      </div>
    </div>

    <div class="text-center mt-6">
      <a href="logout.php" class="text-sm text-gray-500 hover:text-red-600 transition">🔒 Logout</a>
    </div>

    <div class="mt-10">
  <h3 class="text-xl font-semibold text-gray-800 mb-4">🗓️ Jadwal Kamu Hari Ini</h3>
  <?php if ($jadwal_hari_ini->num_rows > 0): ?>
    <?php while ($row = $jadwal_hari_ini->fetch_assoc()): ?>
      <div class="border border-gray-200 p-5 rounded-lg shadow-sm mb-4 bg-white">
        <!-- Tanggal dan Waktu -->
        <h4 class="text-xl font-semibold"><?= date('d M Y', strtotime($row['tanggal'])) ?> - <?= date('l', strtotime($row['tanggal'])) ?> - <?= substr($row['jam'], 0, 5) ?></h4>
        
        <!-- Pakaian -->
        <?php if (!empty($row['pakaian_id'])): ?>
          <p class="text-sm text-gray-600">👚 Pakaian: <?= htmlspecialchars($row['nama_pakaian']) ?></p>
        <?php else: ?>
          <p class="text-sm text-gray-600">👚 Pakaian: Tidak ada pakaian yang terjadwal.</p>
        <?php endif; ?>

        <!-- Skincare -->
        <?php if (!empty($row['skincare_id'])): ?>
          <p class="text-sm text-gray-600">🧴 Skincare: <?= htmlspecialchars($row['nama_skincare']) ?></p>
        <?php else: ?>
          <p class="text-sm text-gray-600">🧴 Skincare: Tidak ada skincare yang terjadwal.</p>
        <?php endif; ?>

        <!-- Catatan -->
        <p class="text-sm text-gray-600">📝 Catatan: <?= htmlspecialchars($row['catatan']) ?></p>

        <!-- Tombol Edit dan Hapus -->
        <div class="flex space-x-4 mt-4">
          <a href="jadwal.php?edit=<?= $row['id'] ?>" class="text-indigo-600 hover:underline">Edit</a>
          <a href="jadwal.php?hapus=<?= $row['id'] ?>" class="text-red-600 hover:underline">Hapus</a>
        </div>
      </div>
    <?php endwhile; ?>
  <?php else: ?>
    <p class="text-gray-500">Tidak ada jadwal untuk hari ini.</p>
  <?php endif; ?>
</div>


  </div>
</body>
</html>