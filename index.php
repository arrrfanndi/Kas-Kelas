<?php
// index.php
session_start();
require_once 'config/koneksi.php';

$sudah_login = isset($_SESSION['user_id']);
$saldo_akhir = 0;

if ($sudah_login) {
    try {
        $stmt = $pdo->query("SELECT jenis, jumlah FROM kas_transaksi");
        $transaksi = $stmt->fetchAll();
        
        $total_masuk = 0;
        $total_keluar = 0;
        foreach ($transaksi as $row) {
            if ($row['jenis'] === 'masuk') {
                $total_masuk += $row['jumlah'];
            } else {
                $total_keluar += $row['jumlah'];
            }
        }
        $saldo_akhir = $total_masuk - $total_keluar;
    } catch (PDOException $e) {
        $saldo_akhir = 0;
    }
}

function aman($string) {
    return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Sistem Kas Kelas</title>
</head>
<body>

    <h1>Sistem Kas Kelas</h1>
    <hr>

    <?php if (!$sudah_login): ?>
        <div>
            <p>Anda belum masuk ke dalam sistem. Silakan login terlebih dahulu untuk mengelola data kas.</p>
            <a href="login.php"><b>Masuk ke Aplikasi (Login)</b></a>
        </div>
    <?php else: ?>
        <div>
            <p>Halo, <b><?= aman($_SESSION['username']); ?></b>! Login sebagai: <i><?= aman($_SESSION['role']); ?></i>.</p>
            <h3>Ringkasan Keuangan Saat Ini:</h3>
            <ul>
                <li>Sisa Saldo Kas Kelas: <b>Rp <?= number_format($saldo_akhir, 0, ',', '.'); ?></b></li>
            </ul>
            <br>
            <h3>Navigasi Operasi Sistem:</h3>
            <ul>
                <li><a href="dashboard.php">Lihat Riwayat & Laporan Transaksi Kas (Read)</a></li>
                <li><a href="dashboard.php#form-tambah">Catat Transaksi Kas Baru (Create)</a></li>
            </ul>
            <br><hr>
            <a href="backend/logout.php" onclick="return confirm('Apakah Anda yakin ingin keluar?');" style="color: red;">Keluar dari Aplikasi (Logout)</a>
        </div>
    <?php endif; ?>

</body>
</html>
