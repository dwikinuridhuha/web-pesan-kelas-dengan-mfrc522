<?php
// online
//$host = "localhost"; // Nama host atau IP server
//$user = "id10137472_root";      // Username MySQL
//$pass = "12345";          // Password MySQL
//$name = "id10137472_project_pkl";      // Nama database MySQL

//offline
 $host = "localhost"; // Nama host atau IP server
 $user = "root";      // Username MySQL
 $pass = "toor";          // Password MySQL
 $name = "db_pinjam";      // Nama database MySQL

$conn = new mysqli($host, $user, $pass, $name);

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}