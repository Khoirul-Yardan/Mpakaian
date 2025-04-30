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
<!-- Ganti bagian <body> sampai </html> -->
<body class="bg-gray-100 min-h-screen">
  <header class="bg-white shadow-md sticky top-0 z-10">
    <div class="max-w-6xl mx-auto px-6 py-4 flex items-center justify-between">
      <h1 class="text-2xl font-bold text-indigo-700">✨ Dashboard</h1>
      <div class="flex items-center gap-3">
        <span class="text-gray-700 font-medium">Hai, <?= $_SESSION['username'] ?>!</span>
        <img src="https://ui-avatars.com/api/?name=<?= urlencode($_SESSION['username']) ?>&background=6366F1&color=fff&rounded=true" class="w-10 h-10 rounded-full shadow" alt="User">
        <a href="logout.php" class="ml-4 text-sm text-red-500 hover:underline">Logout</a>
      </div>
    </div>
  </header>

  <main class="max-w-6xl mx-auto px-6 py-8">
    <!-- Notifikasi / Quote Harian -->
<section class="mb-10">
  <h2 class="text-2xl font-semibold text-gray-800 dark:text-black mb-4">🔔 Motivasi Hari Ini</h2>
  <div class="bg-yellow-100 dark:bg-yellow-600/20 border-l-4 border-yellow-500 text-black-800 dark:text-black-300 p-4 rounded-md">
    <p class="font-medium">"Jangan tunda pekerjaanmu hari ini, agar besok kamu bisa skincare-an tanpa beban. ✨"</p>
  </div>
</section>

    <section class="mb-10">
      <h2 class="text-2xl font-semibold text-gray-800 mb-4">📊 Ringkasan Kamu</h2>
      <div class="grid sm:grid-cols-3 gap-6">
        <!-- Card Pakaian -->
        <div class="bg-white rounded-xl p-6 shadow hover:shadow-lg transition">
          <div class="flex items-center justify-between mb-4">
            <div>
              <h3 class="text-lg font-semibold text-indigo-600">Pakaian</h3>
              <p class="text-4xl font-bold text-gray-800"><?= $pakaian['total'] ?></p>
            </div>
            <span class="text-3xl">👕</span>
          </div>
          <a href="lemari_pakaian.php" class="text-sm text-indigo-600 hover:underline">Lihat detail</a>
        </div>

        <!-- Card Skincare -->
        <div class="bg-white rounded-xl p-6 shadow hover:shadow-lg transition">
          <div class="flex items-center justify-between mb-4">
            <div>
              <h3 class="text-lg font-semibold text-pink-600">Skincare</h3>
              <p class="text-4xl font-bold text-gray-800"><?= $skincare['total'] ?></p>
            </div>
            <span class="text-3xl">💄</span>
          </div>
          <a href="lemari_skincare.php" class="text-sm text-pink-600 hover:underline">Lihat detail</a>
        </div>

        <!-- Card Jadwal -->
        <div class="bg-white rounded-xl p-6 shadow hover:shadow-lg transition">
          <h3 class="text-lg font-semibold text-green-600 mb-3">📅 Jadwal Terdekat</h3>
          <?php while ($j = $jadwal->fetch_assoc()): ?>
            <div class="mb-2">
              <p class="text-gray-700 font-medium"><?= htmlspecialchars($j['kegiatan']) ?></p>
              <p class="text-xs text-gray-500"><?= date('d M', strtotime($j['tanggal'])) ?> | <?= substr($j['jam'], 0, 5) ?> WIB</p>
            </div>
          <?php endwhile; ?>
          <a href="jadwal.php" class="text-sm text-green-600 hover:underline inline-block mt-2">Lihat semua</a>
        </div>
      </div>
    </section>

    <section>
      <h2 class="text-2xl font-semibold text-gray-800 mb-4">🗓️ Jadwal Hari Ini</h2>
      <?php if ($jadwal_hari_ini->num_rows > 0): ?>
        <div class="grid md:grid-cols-2 gap-6">
          <?php while ($row = $jadwal_hari_ini->fetch_assoc()): ?>
            <div class="bg-white p-6 rounded-xl shadow hover:shadow-xl transition">
              <div class="flex justify-between items-center mb-3">
                <div>
                  <h4 class="font-semibold text-lg text-gray-800"><?= htmlspecialchars($row['kegiatan']) ?></h4>
                  <p class="text-sm text-gray-500"><?= date('l, d M Y', strtotime($row['tanggal'])) ?> • <?= substr($row['jam'], 0, 5) ?> WIB</p>
                </div>
                <span class="bg-indigo-100 text-indigo-700 text-xs font-semibold px-3 py-1 rounded-full"><?= date('H:i', strtotime($row['jam'])) ?></span>
              </div>
              <div class="grid sm:grid-cols-2 gap-4 mt-4">
                <!-- Pakaian -->
                <div>
                  <p class="font-medium text-gray-700">👚 Pakaian:</p>
                  <?php if ($row['pakaian_id']): ?>
                    <p class="text-sm text-gray-600 mb-1"><?= htmlspecialchars($row['nama_pakaian']) ?></p>
                    <?php if ($row['gambar_pakaian']): ?>
                      <img src="uploads/<?= $row['gambar_pakaian'] ?>" class="w-24 h-24 rounded-md object-cover border">
                    <?php endif; ?>
                  <?php else: ?>
                    <p class="text-sm text-gray-400 italic">Tidak ada</p>
                  <?php endif; ?>
                </div>

                <!-- Skincare -->
                <div>
                  <p class="font-medium text-gray-700">🧴 Skincare:</p>
                  <?php if ($row['skincare_id']): ?>
                    <p class="text-sm text-gray-600 mb-1"><?= htmlspecialchars($row['nama_skincare']) ?></p>
                    <?php if ($row['gambar_skincare']): ?>
                      <img src="uploads/<?= $row['gambar_skincare'] ?>" class="w-24 h-24 rounded-md object-cover border">
                    <?php endif; ?>
                  <?php else: ?>
                    <p class="text-sm text-gray-400 italic">Tidak ada</p>
                  <?php endif; ?>
                </div>
              </div>

              <!-- Catatan -->
              <?php if (!empty($row['catatan'])): ?>
                <div class="mt-4 pt-3 border-t">
                  <p class="text-sm text-gray-600">📝 <span class="font-medium text-gray-800">Catatan:</span> <?= htmlspecialchars($row['catatan']) ?></p>
                </div>
              <?php endif; ?>
            </div>
          <?php endwhile; ?>
        </div>
      <?php else: ?>
        <p class="text-gray-500 italic">Belum ada jadwal hari ini.</p>
      <?php endif; ?>
    </section>
  </main>
</body>
</html>
