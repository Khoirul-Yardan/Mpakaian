<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

echo "<h2>Selamat datang, " . $_SESSION['username'] . "!</h2>";
echo "<p><a href='logout.php'>Logout</a></p>";
echo "<p><a href='lemari_pakaian.php'>Ke Lemari Pakaian</a> | <a href='lemari_skincare.php'>Ke Lemari Skincare</a> | <a href='jadwal.php'>Jadwalku</a></p>";
