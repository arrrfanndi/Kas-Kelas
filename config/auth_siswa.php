<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['login']) || $_SESSION['role'] !== 'siswa') {
    header("Location: /frontend/Login/halamanLogin.php");
    exit;
}

// 2. KONEKSI DATABASE: Diubah menjadi relatif agar membaca folder Config di dalam project
require_once 'koneksi.php'; 

$siswa_id = $_SESSION['user_id'];
$nama     = $_SESSION['nama'];

// Logika Pembuatan Inisial Nama untuk Avatar Box
$kata    = explode(' ', $nama);
$inisial = strtoupper(substr($kata[0], 0, 1));
if (isset($kata[1])) {
    $inisial .= strtoupper(substr($kata[1], 0, 1));
}

// Ambil Nama Panggilan (Kata pertama dari nama lengkap)
$nama_panggilan = htmlspecialchars($kata[0]);
?>