<?php
session_start();
include 'db.php';

if (isset($_POST['login'])) {
    $email    = $_POST['email'];
    $password = $_POST['password'];

    $query = $conn->query("SELECT * FROM users WHERE email='$email'");
    if ($query->num_rows == 1) {
        $user = $query->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            header("Location: dashboard.php");
        } else {
            echo "<script>
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Password salah!',
                    showConfirmButton: true,
                });
            </script>";
        }
    } else {
        echo "<script>
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Email tidak ditemukan!',
                showConfirmButton: true,
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
  <title>Login Akun</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  <style>
    body {
      font-family: 'Poppins', sans-serif;
    }
  </style>
</head>
<body class="bg-gradient-to-br from-blue-600 via-indigo-600 to-purple-600 min-h-screen flex items-center justify-center px-4">

  <div class="bg-white p-8 rounded-3xl shadow-xl max-w-md w-full transform transition-all hover:scale-105 duration-300">
    <h2 class="text-3xl font-extrabold text-center text-indigo-700 mb-6">Login ke Akun</h2>
    <form method="POST" class="space-y-6">
      
      <input type="email" name="email" placeholder="Email" required
        class="w-full px-5 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-indigo-500 focus:outline-none text-lg transition-all duration-300 ease-in-out">

      <input type="password" name="password" placeholder="Password" required
        class="w-full px-5 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-indigo-500 focus:outline-none text-lg transition-all duration-300 ease-in-out">

      <button type="submit" name="login"
        class="w-full py-3 bg-gradient-to-r from-indigo-500 to-purple-600 text-white font-semibold rounded-lg shadow-lg hover:bg-gradient-to-l focus:outline-none transition-all duration-300 ease-in-out transform hover:scale-105">
        Login
      </button>

      <p class="text-center text-sm text-gray-600">Belum punya akun? 
        <a href="register.php" class="text-indigo-600 font-semibold hover:underline">Daftar di sini</a>
      </p>
    </form>
  </div>
  
</body>
</html>
