<?php
$host = "localhost";
$user = "root";
$pass = ""; // default di XAMPP
$db   = "mpakaian";

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}
?>
