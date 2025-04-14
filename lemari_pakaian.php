<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

include 'db.php';

$user_id = $_SESSION['user_id'];

// Proses tambah pakaian
if (isset($_POST['simpan'])) {
    $nama   = $_POST['nama'];
    $jenis  = $_POST['jenis'];
    $warna  = $_POST['warna'];
    $ukuran = $_POST['ukuran'];
    $catatan = $_POST['catatan'];
    
    // upload foto
    $foto = $_FILES['foto']['name'];
    $tmp  = $_FILES['foto']['tmp_name'];
    move_uploaded_file($tmp, "uploads/" . $foto);

    $conn->query("INSERT INTO lemari_pakaian (user_id, nama, jenis, warna, ukuran, foto, catatan) 
                  VALUES ('$user_id', '$nama', '$jenis', '$warna', '$ukuran', '$foto', '$catatan')");
    echo "<script>alert('Pakaian ditambahkan ke lemari!');</script>";
}

// Ambil semua pakaian user
$pakaian = $conn->query("SELECT * FROM lemari_pakaian WHERE user_id='$user_id'");
?>

<h2>Lemari Pakaian</h2>
<a href="dashboard.php">⬅️ Kembali ke Dashboard</a>

<form method="POST" enctype="multipart/form-data">
    <h3>Tambah Pakaian</h3>
    <input type="text" name="nama" placeholder="Nama pakaian" required><br>
    <input type="text" name="jenis" placeholder="Jenis (baju, celana, dll)" required><br>
    <input type="text" name="warna" placeholder="Warna"><br>
    <input type="text" name="ukuran" placeholder="Ukuran (S/M/L/XL)"><br>
    <input type="file" name="foto" accept="image/*"><br>
    <textarea name="catatan" placeholder="Catatan tambahan (opsional)"></textarea><br>
    <button type="submit" name="simpan">Simpan</button>
</form>

<hr>

<h3>Daftar Pakaian Kamu</h3>
<?php while ($row = $pakaian->fetch_assoc()): ?>
    <div style="border:1px solid #ccc; padding:10px; margin-bottom:10px;">
        <strong><?= htmlspecialchars($row['nama']) ?></strong><br>
        Jenis: <?= htmlspecialchars($row['jenis']) ?><br>
        Warna: <?= htmlspecialchars($row['warna']) ?> | Ukuran: <?= htmlspecialchars($row['ukuran']) ?><br>
        <?php if ($row['foto']): ?>
            <img src="uploads/<?= $row['foto'] ?>" width="100"><br>
        <?php endif; ?>
        Catatan: <?= htmlspecialchars($row['catatan']) ?>
    </div>
<?php endwhile; ?>
