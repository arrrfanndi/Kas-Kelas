<?php
$host = "localhost";
$user = "arfandi";
$pass = "321456lol";
$db   = "db_kasqeu";

try {
    $koneksi = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    // Mengatur error mode PDO ke Exception untuk memudahkan debugging
    $koneksi->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $koneksi->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Koneksi ke database Laragon gagal: " . $e->getMessage());
}
?>