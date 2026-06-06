<?php
// config/auth_admin.php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 1. Gerbang Pengaman Session Admin
if (!isset($_SESSION['login']) || $_SESSION['role'] !== 'admin') {
    header("Location: /frontend/Login/halamanLogin.php");
    exit;
}

// 2. Hubungkan Koneksi Database
require_once 'koneksi.php'; 

$admin_id = $_SESSION['user_id'] ?? null;
$nama     = $_SESSION['nama'] ?? 'Admin';
// Tambahkan baris ini agar $role terdefinisi (menggunakan ucfirst agar huruf depan Kapital)
$role     = ucfirst($_SESSION['role'] ?? 'Admin'); 

// 3. Logika Pembuatan Inisial Nama Global
$kata    = explode(' ', $nama);
$inisial = strtoupper(substr($kata[0], 0, 1));
if (isset($kata[1])) {
    $inisial .= strtoupper(substr($kata[1], 0, 1));
}