<?php
// migrasi_password.php
require_once 'koneksi.php';

try {
    echo "<h3>Memulai Migrasi Password ke Format Hash...</h3>";

    // 1. MIGRASI TABEL ADMIN
    $stmtAdmin = $koneksi->query("SELECT id, password FROM admin");
    $list_admin = $stmtAdmin->fetchAll(PDO::FETCH_ASSOC);
    $countAdmin = 0;

    foreach ($list_admin as $admin) {
        // Cek apakah password SUDAH dalam bentuk hash bcrypt (selalu diawali dengan $2y$)
        if (substr($admin['password'], 0, 4) !== '$2y$') {
            $password_baru = password_hash($admin['password'], PASSWORD_BCRYPT);
            
            $update = $koneksi->prepare("UPDATE admin SET password = ? WHERE id = ?");
            $update->execute([$password_baru, $admin['id']]);
            $countAdmin++;
        }
    }
    echo "✔ Selesai! $countAdmin password Admin berhasil diubah menjadi hash.<br>";

    // 2. MIGRASI TABEL SISWA
    $stmtSiswa = $koneksi->query("SELECT id, password FROM siswa");
    $list_siswa = $stmtSiswa->fetchAll(PDO::FETCH_ASSOC);
    $countSiswa = 0;

    foreach ($list_siswa as $siswa) {
        // Cek apakah password SUDAH dalam bentuk hash bcrypt
        if (substr($siswa['password'], 0, 4) !== '$2y$') {
            $password_baru = password_hash($siswa['password'], PASSWORD_BCRYPT);
            
            $update = $koneksi->prepare("UPDATE siswa SET password = ? WHERE id = ?");
            $update->execute([$password_baru, $siswa['id']]);
            $countSiswa++;
        }
    }
    echo "✔ Selesai! $countSiswa password Siswa berhasil diubah menjadi hash.<br>";
    echo "<p style='color:green;'><b>Migrasi Sukses Total! Silakan hapus file ini demi keamanan.</b></p>";

} catch (PDOException $e) {
    die("Terjadi kesalahan saat migrasi: " . $e->getMessage());
}
?>