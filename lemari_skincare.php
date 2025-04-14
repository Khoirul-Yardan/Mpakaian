<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

include 'db.php';

$user_id = $_SESSION['user_id'];

if (isset($_POST['simpan'])) {
    $nama      = $_POST['nama'];
    $jenis     = $_POST['jenis'];
    $fungsi    = $_POST['fungsi'];
    $kadaluarsa = $_POST['kadaluarsa'];
    $catatan   = $_POST['catatan'];

    $foto = $_FILES['foto']['name'];
    $tmp  = $_FILES['foto']['tmp_name'];
    if ($foto) {
        move_uploaded_file($tmp, "uploads/" . $foto);
    }

    $conn->query("INSERT INTO lemari_skincare (user_id, nama, jenis, fungsi, kadaluarsa, foto, catatan) 
                  VALUES ('$user_id', '$nama', '$jenis', '$fungsi', '$kadaluarsa', '$foto', '$catatan')");

    echo "<script>alert('Skincare ditambahkan ke lemari!');</script>";
}

$skincare = $conn->query("SELECT * FROM lemari_skincare WHERE user_id='$user_id'");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Lemari Skincare</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
    </style>
</head>
<body class="bg-gradient-to-br from-pink-100 to-white min-h-screen p-6">

    <div class="max-w-6xl mx-auto bg-white p-8 rounded-3xl shadow-xl">
        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center mb-8 gap-4">
            <h2 class="text-3xl font-bold text-pink-700">Lemari Skincare Kamu</h2>
            <a href="dashboard.php" class="bg-pink-600 hover:bg-pink-700 text-white px-4 py-2 rounded-xl text-sm transition">
                ⬅️ Kembali ke Dashboard
            </a>
        </div>

        <!-- Form Tambah Skincare -->
        <form method="POST" enctype="multipart/form-data" class="bg-pink-50 p-6 rounded-xl shadow mb-10">
            <h3 class="text-xl font-semibold text-pink-800 mb-4">Tambah Produk Skincare</h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <input type="text" name="nama" placeholder="Nama produk" required class="p-2 border rounded">
                <input type="text" name="jenis" placeholder="Jenis (Toner, Serum, dll)" required class="p-2 border rounded">
                <input type="text" name="fungsi" placeholder="Fungsi (mencerahkan, melembapkan, dll)" class="p-2 border rounded">
                <input type="date" name="kadaluarsa" required class="p-2 border rounded">

                <div class="col-span-2">
                    <label class="block mb-1 text-sm font-medium text-gray-700">Upload Foto Produk:</label>
                    <input type="file" name="foto" accept="image/*" class="p-2 border rounded w-full">
                </div>

                <textarea name="catatan" placeholder="Catatan tambahan (opsional)" class="p-2 border rounded col-span-2"></textarea>
            </div>
            <button type="submit" name="simpan" class="mt-4 bg-pink-600 hover:bg-pink-700 text-white px-6 py-2 rounded-xl">
                Simpan
            </button>
        </form>

        <!-- Daftar Skincare -->
        <h3 class="text-2xl font-semibold text-gray-800 mb-4">Daftar Skincare</h3>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
            <?php while ($row = $skincare->fetch_assoc()): ?>
                <div class="bg-white rounded-xl shadow hover:shadow-lg p-4 transition">
                    <?php if ($row['foto']): ?>
                        <img src="uploads/<?= $row['foto'] ?>" class="w-full h-48 object-cover rounded mb-3" alt="<?= htmlspecialchars($row['nama']) ?>">
                    <?php else: ?>
                        <div class="w-full h-48 bg-gray-200 flex items-center justify-center rounded mb-3 text-gray-500">Tidak Ada Foto</div>
                    <?php endif; ?>
                    <h4 class="text-lg font-bold text-pink-700"><?= htmlspecialchars($row['nama']) ?></h4>
                    <p class="text-sm text-gray-700">🧴 Jenis: <?= htmlspecialchars($row['jenis']) ?></p>
                    <p class="text-sm text-gray-700">✨ Fungsi: <?= htmlspecialchars($row['fungsi']) ?></p>
                    <p class="text-sm text-gray-700">📅 Kadaluarsa: <?= htmlspecialchars($row['kadaluarsa']) ?></p>
                    <?php if ($row['catatan']): ?>
                        <p class="text-sm text-gray-500 italic mt-2">"<?= htmlspecialchars($row['catatan']) ?>"</p>
                    <?php endif; ?>
                </div>
            <?php endwhile; ?>
        </div>
    </div>

</body>
</html>
