<?php
include 'db.php';

if (isset($_POST['register'])) {
    $username = $_POST['username'];
    $email    = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $cek = $conn->query("SELECT * FROM users WHERE email='$email'");
    if ($cek->num_rows > 0) {
        echo "<script>
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Email sudah terdaftar!',
                showConfirmButton: true,
            });
        </script>";
    } else {
        $conn->query("INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$password')");
        echo "<script>
            Swal.fire({
                title: 'Registrasi Berhasil!',
                text: 'Silakan login sekarang.',
                icon: 'success',
                confirmButtonText: 'Login',
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location='login.php';
                }
            });
        </script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Daftar Akun</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="bg-gradient-to-br from-blue-600 via-indigo-600 to-purple-600 min-h-screen flex items-center justify-center px-4">

  <div class="bg-white p-8 rounded-3xl shadow-xl max-w-md w-full transform transition-all hover:scale-105 duration-300">
    <h2 class="text-3xl font-extrabold text-center text-indigo-700 mb-6">Buat Akun Baru</h2>
    <form method="POST" class="space-y-6">
      
      <input type="text" name="username" placeholder="Username" required
        class="w-full px-5 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-indigo-500 focus:outline-none text-lg transition-all duration-300 ease-in-out">

      <input type="email" name="email" placeholder="Email" required
        class="w-full px-5 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-indigo-500 focus:outline-none text-lg transition-all duration-300 ease-in-out">

      <input type="password" name="password" placeholder="Password" required
        class="w-full px-5 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-indigo-500 focus:outline-none text-lg transition-all duration-300 ease-in-out">

      <button type="submit" name="register"
        class="w-full py-3 bg-gradient-to-r from-indigo-500 to-purple-600 text-white font-semibold rounded-lg shadow-lg hover:bg-gradient-to-l focus:outline-none transition-all duration-300 ease-in-out transform hover:scale-105">
        Daftar Sekarang
      </button>

      <p class="text-center text-sm text-gray-600">Sudah punya akun? 
        <a href="login.php" class="text-indigo-600 font-semibold hover:underline">Login di sini</a>
      </p>
    </form>
  </div>
  
</body>
</html>
