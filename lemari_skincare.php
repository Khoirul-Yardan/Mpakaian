<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

include 'db.php';

$user_id = $_SESSION['user_id'];

// Proses tambah skincare
if (isset($_POST['simpan'])) {
    $nama    = $_POST['nama'];
    $jenis   = $_POST['jenis']; // Toner, Serum, Moisturizer, dll
    $waktu   = $_POST['waktu']; // pagi/malam
    $catatan = $_POST['catatan'];

    // upload foto
    $foto = $_FILES['foto']['name'];
    $tmp  = $_FILES['foto']['tmp_name'];
    move_uploaded_file($tmp, "uploads/" . $foto);

    $conn->query("INSERT INTO lemari_skincare (user_id, nama, jenis, waktu_pakai, foto, catatan) 
                  VALUES ('$user_id', '$nama', '$jenis', '$waktu', '$foto', '$catatan')");
    echo "<script>alert('Skincare ditambahkan ke lemari!');</script>";
}

// Ambil semua skincare user
$skincare = $conn->query("SELECT * FROM lemari_skincare WHERE user_id='$user_id'");
?>

<h2>Lemari Skincare</h2>
<a href="dashboard.php">⬅️ Kembali ke Dashboard</a>

<form method="POST" enctype="multipart/form-data">
    <h3>Tambah Skincare</h3>
    <input type="text" name="nama" placeholder="Nama produk" required><br>
    <input type="text" name="jenis" placeholder="Jenis (Toner, Serum, dll)" required><br>
    <select name="waktu" required>
        <option value="">Pilih waktu pemakaian</option>
        <option value="Pagi">Pagi</option>
        <option value="Malam">Malam</option>
        <option value="Pagi & Malam">Pagi & Malam</option>
    </select><br>
    <input type="file" name="foto" accept="image/*"><br>
    <textarea name="catatan" placeholder="Catatan tambahan (opsional)"></textarea><br>
    <button type="submit" name="simpan">Simpan</button>
</form>

<hr>

<h3>Daftar Skincare Kamu</h3>
<?php while ($row = $skincare->fetch_assoc()): ?>
    <div style="border:1px solid #ccc; padding:10px; margin-bottom:10px;">
        <strong><?= htmlspecialchars($row['nama']) ?></strong><br>
        Jenis: <?= htmlspecialchars($row['jenis']) ?> | Waktu: <?= htmlspecialchars($row['waktu_pakai']) ?><br>
        <?php if ($row['foto']): ?>
            <img src="uploads/<?= $row['foto'] ?>" width="100"><br>
        <?php endif; ?>
        Catatan: <?= htmlspecialchars($row['catatan']) ?>
    </div>
<?php endwhile; ?>
