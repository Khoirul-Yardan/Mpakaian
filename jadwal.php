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
    $tanggal    = $_POST['tanggal'];  // Tambahkan tanggal

    $conn->query("INSERT INTO jadwal (user_id, hari, jam, pakaian_id, skincare_id, catatan, tanggal)
                  VALUES ('$user_id', '$hari', '$jam', '$pakaian_id', '$skincare_id', '$catatan', '$tanggal')");
    
    // Ganti dengan SweetAlert
    echo "<script>
            Swal.fire({
                title: 'Berhasil!',
                text: 'Jadwal berhasil ditambahkan!',
                icon: 'success',
                confirmButtonText: 'Ok'
            }).then(() => {
                window.location = 'jadwal.php';
            });
          </script>";
}

// Proses hapus jadwal
if (isset($_GET['hapus'])) {
    $id_jadwal = $_GET['hapus'];
    $conn->query("DELETE FROM jadwal WHERE id = '$id_jadwal'");
    
    // Ganti dengan SweetAlert
    echo "<script>
            Swal.fire({
                title: 'Berhasil!',
                text: 'Jadwal berhasil dihapus!',
                icon: 'success',
                confirmButtonText: 'Ok'
            }).then(() => {
                window.location = 'jadwal.php';
            });
          </script>";
}

// Proses edit jadwal
if (isset($_GET['edit'])) {
    $id_jadwal = $_GET['edit'];
    $result = $conn->query("SELECT * FROM jadwal WHERE id = '$id_jadwal'");
    $edit_jadwal = $result->fetch_assoc();
    
    // Tampilkan form dengan SweetAlert
    echo "<script>
            Swal.fire({
                title: 'Edit Jadwal',
                html: `
                    <form action='jadwal.php' method='POST'>
                        <input type='hidden' name='id' value='" . $edit_jadwal['id'] . "'>
                        <input type='date' name='tanggal' value='" . $edit_jadwal['tanggal'] . "' class='swal2-input' required>
                        <input type='text' name='hari' value='" . $edit_jadwal['hari'] . "' class='swal2-input' readonly>
                        <input type='time' name='jam' value='" . $edit_jadwal['jam'] . "' class='swal2-input' required>
                        <textarea name='catatan' class='swal2-textarea' placeholder='Catatan'>" . $edit_jadwal['catatan'] . "</textarea>
                        <button type='submit' name='update' class='swal2-confirm swal2-styled'>Update</button>
                    </form>
                `,
                showCancelButton: true,
                cancelButtonText: 'Batal',
                confirmButtonText: 'Simpan',
                showLoaderOnConfirm: true,
                preConfirm: () => {
                    return new Promise((resolve) => {
                        document.querySelector('form').submit();
                    });
                }
            });
          </script>";
}

// Proses update jadwal
if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $tanggal = $_POST['tanggal'];
    $hari = $_POST['hari'];
    $jam = $_POST['jam'];
    $catatan = $_POST['catatan'];

    $conn->query("UPDATE jadwal SET tanggal = '$tanggal', hari = '$hari', jam = '$jam', catatan = '$catatan' WHERE id = '$id'");

    echo "<script>
            Swal.fire({
                title: 'Berhasil!',
                text: 'Jadwal berhasil diperbarui!',
                icon: 'success',
                confirmButtonText: 'Ok'
            }).then(() => {
                window.location = 'jadwal.php';
            });
          </script>";
}



// Ambil semua jadwal user
$jadwal = $conn->query("SELECT j.*, p.nama AS nama_pakaian, s.nama AS nama_skincare 
                        FROM jadwal j 
                        LEFT JOIN lemari_pakaian p ON j.pakaian_id = p.id
                        LEFT JOIN lemari_skincare s ON j.skincare_id = s.id
                        WHERE j.user_id = '$user_id'
                        ORDER BY FIELD(j.hari, 'Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu'), j.jam ASC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Jadwal Aktivitas</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <style>
    body {
      font-family: 'Poppins', sans-serif;
    }
  </style>
</head>
<body class="bg-gradient-to-br from-indigo-600 via-purple-600 to-pink-500 min-h-screen p-6">

  <div class="max-w-3xl mx-auto bg-white rounded-3xl shadow-2xl p-10">
    <h2 class="text-3xl font-bold text-gray-800 mb-4">📅 Jadwal Aktivitas</h2>
    <a href="dashboard.php" class="text-sm text-indigo-600 hover:underline mb-6 inline-block">⬅️ Kembali ke Dashboard</a>

    <form method="POST" class="space-y-4">
    <h3 class="text-xl font-semibold text-gray-800">Tambah Jadwal</h3>

    <input type="date" name="tanggal" class="w-full p-3 bg-gray-100 border rounded-lg" required onchange="updateHari()" id="tanggal">

    <!-- Menambahkan input untuk hari -->
    <input type="text" name="hari" id="hari" class="w-full p-3 bg-gray-100 border rounded-lg" readonly>

    <input type="time" name="jam" class="w-full p-3 bg-gray-100 border rounded-lg" required>

    <select name="pakaian_id" class="w-full p-3 bg-gray-100 border rounded-lg" required>
        <option value="">Pilih Pakaian</option>
        <?php while ($p = $pakaian->fetch_assoc()): ?>
            <option value="<?= $p['id'] ?>"><?= htmlspecialchars($p['nama']) ?></option>
        <?php endwhile; ?>
    </select>

    <select name="skincare_id" class="w-full p-3 bg-gray-100 border rounded-lg" required>
        <option value="">Pilih Skincare</option>
        <?php while ($s = $skincare->fetch_assoc()): ?>
            <option value="<?= $s['id'] ?>"><?= htmlspecialchars($s['nama']) ?></option>
        <?php endwhile; ?>
    </select>

    <textarea name="catatan" placeholder="Catatan tambahan (opsional)" class="w-full p-3 bg-gray-100 border rounded-lg"></textarea>

    <button type="submit" name="simpan" class="w-full p-3 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">Simpan Jadwal</button>
</form>


<script>
    // Fungsi untuk mengupdate hari berdasarkan tanggal yang dipilih
function updateHari() {
    const tanggal = document.getElementById('tanggal').value;
    const hari = new Date(tanggal);
    const hariNama = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
    document.getElementById('hari').value = hariNama[hari.getDay()]; // Menampilkan nama hari
}

</script>

    <hr class="my-6">

    <h3 class="text-xl font-semibold text-gray-800 mb-4">Jadwal Kamu</h3>

    <?php while ($row = $jadwal->fetch_assoc()): ?>
    <div class="border border-gray-200 p-5 rounded-lg shadow-sm mb-4">
        <h4 class="text-xl font-semibold"><?= $row['tanggal'] ?> - <?= date('l', strtotime($row['tanggal'])) ?> - <?= substr($row['jam'], 0, 5) ?></h4>
        <p class="text-sm text-gray-600">👚 Pakaian: <?= htmlspecialchars($row['nama_pakaian']) ?></p>
        <p class="text-sm text-gray-600">🧴 Skincare: <?= htmlspecialchars($row['nama_skincare']) ?></p>
        <p class="text-sm text-gray-600">📝 Catatan: <?= htmlspecialchars($row['catatan']) ?></p>
        <div class="flex space-x-4 mt-4">
            <a href="jadwal.php?edit=<?= $row['id'] ?>" class="text-indigo-600 hover:underline">Edit</a>
            <a href="jadwal.php?hapus=<?= $row['id'] ?>" class="text-red-600 hover:underline">Hapus</a>
        </div>
    </div>
<?php endwhile; ?>


  </div>

</body>
</html>
