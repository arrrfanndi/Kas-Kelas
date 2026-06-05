<?php
// Config/auth_admin.php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 1. Gerbang Pengaman Session Admin
if (!isset($_SESSION['login']) || $_SESSION['role'] !== 'admin') {
    header("Location: /frontend/Login/halamanLogin.php");
    exit;
}

// 2. Hubungkan Koneksi Database (Karena satu folder di Config, langsung panggil nama filenya)
require_once 'koneksi.php'; 

$admin_id = $_SESSION['user_id'];
$nama     = $_SESSION['nama'];

// 3. Logika Pembuatan Inisial Nama Global
$kata    = explode(' ', $nama);
$inisial = strtoupper(substr($kata[0], 0, 1));
if (isset($kata[1])) {
    $inisial .= strtoupper(substr($kata[1], 0, 1));
}