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
$sql = "SELECT jadwal.*, 
       lemari_pakaian.nama AS nama_pakaian, 
       lemari_pakaian.foto AS gambar_pakaian, 
       lemari_skincare.nama AS nama_skincare,
       lemari_skincare.foto AS gambar_skincare
FROM jadwal
LEFT JOIN lemari_pakaian ON jadwal.pakaian_id = lemari_pakaian.id
LEFT JOIN lemari_skincare ON jadwal.skincare_id = lemari_skincare.id
WHERE jadwal.user_id = " . $_SESSION['user_id'] . " AND jadwal.tanggal = '$tanggal_hari_ini'
";


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
  <h3 class="text-xl font-semibold text-green-800 mb-3">📅 Jadwal Terdekat</h3>
  
  <?php while ($j = $jadwal->fetch_assoc()): ?>
    <div class="flex items-start justify-between bg-white/60 px-4 py-2 rounded-md mb-2 shadow-sm hover:bg-white/80 transition">
      <div>
        <div class="text-sm font-medium text-gray-800"><?= htmlspecialchars($j['kegiatan']) ?></div>
        <div class="text-xs text-gray-500"><?= date('d M Y', strtotime($j['tanggal'])) ?> | <?= substr($j['jam'], 0, 5) ?> WIB</div>
      </div>
    </div>
  <?php endwhile; ?>

  <a href="jadwal.php" class="inline-block mt-3 text-sm font-medium text-green-700 hover:underline">Lihat semua</a>
</div>

    </div>

    <div class="text-center mt-6">
      <a href="logout.php" class="text-sm text-gray-500 hover:text-red-600 transition">🔒 Logout</a>
    </div>

    <div class="mt-10">
  <h3 class="text-2xl font-bold text-gray-800 mb-6">🗓️ Jadwal Kamu Hari Ini</h3>
  <?php if ($jadwal_hari_ini->num_rows > 0): ?>
    <?php while ($row = $jadwal_hari_ini->fetch_assoc()): ?>
      <div class="border border-gray-300 p-6 rounded-xl shadow-md mb-6 bg-white transition hover:shadow-lg">
        
        <!-- Tanggal dan Waktu -->
        <div class="flex items-center justify-between mb-4">
          <div>
            <h4 class="text-xl font-semibold text-gray-800"><?= date('d M Y', strtotime($row['tanggal'])) ?></h4>
            <span class="text-sm text-gray-500"><?= date('l', strtotime($row['tanggal'])) ?> - <?= substr($row['jam'], 0, 5) ?></span>
          </div>
          <span class="bg-blue-100 text-blue-700 text-sm font-medium px-3 py-1 rounded-full">
            <?= date('H:i', strtotime($row['jam'])) ?>
          </span>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

          <!-- Pakaian -->
          <div>
            <h5 class="font-medium text-gray-700 mb-1">👚 Pakaian:</h5>
            <?php if (!empty($row['pakaian_id'])): ?>
              <p class="text-gray-600 mb-2"><?= htmlspecialchars($row['nama_pakaian']) ?></p>
              <?php if (!empty($row['gambar_pakaian'])): ?>
                <img src="uploads/<?= $row['gambar_pakaian'] ?>" alt="Gambar Pakaian" class="w-32 h-32 object-cover rounded-lg border">
              <?php endif; ?>
            <?php else: ?>
              <p class="text-gray-400 italic">Tidak ada pakaian yang terjadwal.</p>
            <?php endif; ?>
          </div>

          <!-- Skincare -->
          <div>
            <h5 class="font-medium text-gray-700 mb-1">🧴 Skincare:</h5>
            <?php if (!empty($row['skincare_id'])): ?>
              <p class="text-gray-600 mb-2"><?= htmlspecialchars($row['nama_skincare']) ?></p>
              <?php if (!empty($row['gambar_skincare'])): ?>
                <img src="uploads/<?= $row['gambar_skincare'] ?>" alt="Gambar Skincare" class="w-32 h-32 object-cover rounded-lg border">
              <?php endif; ?>
            <?php else: ?>
              <p class="text-gray-400 italic">Tidak ada skincare yang terjadwal.</p>
            <?php endif; ?>
          </div>
        </div>

        <!-- Catatan -->
        <?php if (!empty($row['catatan'])): ?>
          <div class="mt-4 border-t pt-3">
            <p class="text-sm text-gray-600">📝 <span class="font-medium text-gray-800">Catatan:</span> <?= htmlspecialchars($row['catatan']) ?></p>
          </div>
        <?php endif; ?>

      </div>
    <?php endwhile; ?>
  <?php else: ?>
    <p class="text-gray-500 italic">Tidak ada jadwal untuk hari ini.</p>
  <?php endif; ?>
</div>



  </div>
</body>
</html>