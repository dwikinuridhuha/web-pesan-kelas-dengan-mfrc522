<?php
$host = "localhost"; // Nama host atau IP server
$user = "root";      // Username MySQL
$pass = "toor";          // Password MySQL
$name = "uji";      // Nama database MySQL

$conn = new mysqli($host, $user, $pass, $name);

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}