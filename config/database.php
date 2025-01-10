<?php
$hostname = "localhost";
$username = "root"; // Sesuaikan dengan pengaturan XAMPP
$password = ""; // Kosongkan jika default XAMPP
$database = "zadmin_desa"; // Ganti dengan nama database Anda

// Membuat koneksi dengan MySQLi
$conn = mysqli_connect($hostname, $username, $password, $database);

// Cek koneksi
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
