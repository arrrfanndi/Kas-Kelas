<?php
// backend/hapus_kas.php
session_start();
require_once '../config/koneksi.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit;
}

if (isset($_GET['id']) && filter_var($_GET['id'], FILTER_VALIDATE_INT)) {
    $id = $_GET['id'];

    try {
        // Poin 3: Prepared Statement (mengunci manipulasi SQL lewat URL)
        $stmt = $pdo->prepare("DELETE FROM kas_transaksi WHERE id = :id");
        $stmt->execute(['id' => $id]);

        header("Location: ../dashboard.php?status=sukses_hapus");
        exit;
    } catch (PDOException $e) {
        die("Gagal hapus: " . $e->getMessage());
    }
} else {
    die("ID tidak valid.");
}
?>