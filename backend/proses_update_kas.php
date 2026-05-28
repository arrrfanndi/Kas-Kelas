<?php
// backend/proses_update_kas.php
session_start();
require_once '../config/koneksi.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id         = $_POST['id'];
    $siswa_id   = $_POST['siswa_id'];
    $jenis      = $_POST['jenis'];
    $jumlah     = $_POST['jumlah'];
    $keterangan = trim($_POST['keterangan']);

    if (!filter_var($id, FILTER_VALIDATE_INT) || !in_array($jenis, ['masuk', 'keluar']) || !filter_var($jumlah, FILTER_VALIDATE_INT) || $jumlah <= 0 || empty($keterangan)) {
        die("<script>alert('Validasi gagal!'); window.history.back();</script>");
    }

    try {
        // Poin 3: Prepared Statement
        $sql = "UPDATE kas_transaksi SET siswa_id = :siswa_id, jenis = :jenis, jumlah = :jumlah, keterangan = :keterangan WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            'siswa_id'   => !empty($siswa_id) ? $siswa_id : null,
            'jenis'      => $jenis,
            'jumlah'     => $jumlah,
            'keterangan' => $keterangan,
            'id'         => $id
        ]);

        header("Location: ../dashboard.php?status=sukses_ubah");
        exit;
    } catch (PDOException $e) {
        die("Gagal update: " . $e->getMessage());
    }
}
?>