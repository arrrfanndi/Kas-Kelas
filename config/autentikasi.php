<?php
// config/autentikasi.php

// Otomatis memulai session jika di server belum berjalan
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/**
 * Poin 1: Mengatur pembatasan hak akses halaman.
 * Jika belum login, user langsung ditendang kembali ke login.php.
 */
function proteksi_halaman() {
    if (!isset($_SESSION['user_id'])) {
        // Cek posisi file pengeksekusi untuk menentukan jalur kembali ke login.php
        $path = file_exists('login.php') ? 'login.php' : '../login.php';
        header("Location: " . $path);
        exit;
    }
}

/**
 * Poin 1: Pembatasan hak akses spesifik berdasarkan Role (Opsi Tambahan)
 * Menolak akses jika role pengguna tidak sesuai (misal: hanya bendahara yang boleh edit/hapus)
 */
function cek_akses_bendahara() {
    if ($_SESSION['role'] !== 'bendahara') {
        echo "<script>
                alert('Akses Ditolak! Hanya Bendahara yang memiliki akses manipulasi data.'); 
                window.location.href = file_exists('dashboard.php') ? 'dashboard.php' : '../dashboard.php';
              </script>";
        exit;
    }
}

/**
 * Fungsi Keamanan Tambahan: Proteksi Serangan XSS (Cross-Site Scripting)
 */
function aman($string) {
    return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
}
?>