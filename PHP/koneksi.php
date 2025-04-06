<?php
$host = "localhost";  // Ganti jika berbeda
$user = "root";       // Sesuaikan dengan database kamu
$pass = "";           // Isi jika ada password database
$db   = "ticket1"; // Ganti dengan nama database kamu

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
} 

?>
