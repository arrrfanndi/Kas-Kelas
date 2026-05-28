<?php
// config/koneksi.php
$host     = "localhost";
$db_name  = "kas_kelas";
$username = "root";
$password = ""; 

try {
    // Menggunakan PDO untuk mendukung Prepared Statements (Poin 3: Anti-SQL Injection)
    $pdo = new PDO("mysql:host=$host;dbname=$db_name;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Koneksi ke database gagal: " . $e->getMessage());
}
?>
