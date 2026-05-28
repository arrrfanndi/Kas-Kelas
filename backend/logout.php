<?php
// backend/hapus_kas.php
require_once '../config/koneksi.php';
require_once '../config/autentikasi.php';

proteksi_halaman();
cek_akses_bendahara(); // Poin 1: Hanya bendahara yang diizinkan menghapus record data

if (isset($_GET['id']) && filter_var($_GET['id'], FILTER_VALIDATE_INT)) {
    $id = $_GET['id'];

    try {
        // Poin 3: Prepared Statement mengunci manipulasi parameter query string di URL (?id=...)
        $stmt = $pdo->prepare("DELETE FROM kas_transaksi WHERE id = :id");
        $stmt->execute(['id' => $id]);

        header("Location: ../dashboard.php?status=sukses_hapus");
        exit;
    } catch (PDOException $e) {
        die("Gagal menghapus data transaksi: " . $e->getMessage());
    }
} else {
    echo "<script>alert('ID Transaksi tidak dikenali.'); window.location.href = '../dashboard.php';</script>";
    exit;
}
?>
