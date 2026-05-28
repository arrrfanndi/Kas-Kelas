<?php
// backend/tambah_kas.php
session_start();
require_once '../config/koneksi.php';

// Poin 1: Pembatasan hak akses (wajib login)
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $siswa_id   = $_POST['siswa_id']; 
    $jenis      = $_POST['jenis']; // 'masuk' atau 'keluar'
    $jumlah     = $_POST['jumlah']; 
    $keterangan = trim($_POST['keterangan']);

    // Validasi backend
    if (!in_array($jenis, ['masuk', 'keluar']) || !filter_var($jumlah, FILTER_VALIDATE_INT) || $jumlah <= 0 || empty($keterangan)) {
        die("<script>alert('Input tidak valid!'); window.history.back();</script>");
    }

    try {
        // Poin 3: Prepared Statement
        $sql = "INSERT INTO kas_transaksi (siswa_id, jenis, jumlah, keterangan, tanggal) 
                VALUES (:siswa_id, :jenis, :jumlah, :keterangan, NOW())";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            'siswa_id'   => !empty($siswa_id) ? $siswa_id : null,
            'jenis'      => $jenis,
            'jumlah'     => $jumlah,
            'keterangan' => $keterangan
        ]);

        header("Location: ../dashboard.php?status=sukses_tambah");
        exit;
    } catch (PDOException $e) {
        die("Gagal menyimpan: " . $e->getMessage());
    }
}
?>