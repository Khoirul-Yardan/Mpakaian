<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

include 'db.php';

$user_id = $_SESSION['user_id'];

// Ambil data pakaian dan skincare user
$pakaian = $conn->query("SELECT * FROM lemari_pakaian WHERE user_id='$user_id'");
$skincare = $conn->query("SELECT * FROM lemari_skincare WHERE user_id='$user_id'");

// Proses tambah jadwal
if (isset($_POST['simpan'])) {
    $hari       = $_POST['hari'];
    $jam        = $_POST['jam'];
    $pakaian_id = $_POST['pakaian_id'];
    $skincare_id = $_POST['skincare_id'];
    $catatan    = $_POST['catatan'];

    $conn->query("INSERT INTO jadwal (user_id, hari, jam, pakaian_id, skincare_id, catatan)
                  VALUES ('$user_id', '$hari', '$jam', '$pakaian_id', '$skincare_id', '$catatan')");
    echo "<script>alert('Jadwal berhasil ditambahkan!');</script>";
}

// Ambil semua jadwal user
$jadwal = $conn->query("SELECT j.*, p.nama AS nama_pakaian, s.nama AS nama_skincare 
                        FROM jadwal j 
                        LEFT JOIN lemari_pakaian p ON j.pakaian_id = p.id
                        LEFT JOIN lemari_skincare s ON j.skincare_id = s.id
                        WHERE j.user_id = '$user_id'
                        ORDER BY FIELD(j.hari, 'Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu'), j.jam ASC");
?>

<h2>📅 Jadwalku</h2>
<a href="dashboard.php">⬅️ Kembali ke Dashboard</a>

<form method="POST">
    <h3>Tambah Jadwal</h3>
    <select name="hari" required>
        <option value="">Pilih Hari</option>
        <?php foreach (['Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu'] as $h): ?>
            <option value="<?= $h ?>"><?= $h ?></option>
        <?php endforeach; ?>
    </select><br>

    <input type="time" name="jam" required><br>

    <select name="pakaian_id" required>
        <option value="">Pilih Pakaian</option>
        <?php while ($p = $pakaian->fetch_assoc()): ?>
            <option value="<?= $p['id'] ?>"><?= htmlspecialchars($p['nama']) ?></option>
        <?php endwhile; ?>
    </select><br>

    <select name="skincare_id" required>
        <option value="">Pilih Skincare</option>
        <?php while ($s = $skincare->fetch_assoc()): ?>
            <option value="<?= $s['id'] ?>"><?= htmlspecialchars($s['nama']) ?></option>
        <?php endwhile; ?>
    </select><br>

    <textarea name="catatan" placeholder="Catatan tambahan (opsional)"></textarea><br>

    <button type="submit" name="simpan">Simpan Jadwal</button>
</form>

<hr>

<h3>Jadwal Kamu</h3>
<?php while ($row = $jadwal->fetch_assoc()): ?>
    <div style="border:1px solid #ccc; padding:10px; margin-bottom:10px;">
        <strong><?= $row['hari'] ?> - <?= substr($row['jam'], 0, 5) ?></strong><br>
        👚 Pakaian: <?= htmlspecialchars($row['nama_pakaian']) ?><br>
        🧴 Skincare: <?= htmlspecialchars($row['nama_skincare']) ?><br>
        📝 Catatan: <?= htmlspecialchars($row['catatan']) ?>
    </div>
<?php endwhile; ?>
