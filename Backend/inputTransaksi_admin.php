<?php
session_start();

// =========================================================================
// A. Sistem Autentikasi & Pengaman Session (Paling Atas File)
// =========================================================================
if (!isset($_SESSION['login']) || $_SESSION['role'] !== 'admin') {
    header("Location: /Login/login_dua.php");
    exit;
}

// Menghubungkan ke database dengan jalur mendaki relatif (../../)
require_once '../../Config/koneksi.php'; 

$admin_id = $_SESSION['user_id'];
$nama     = $_SESSION['nama'];

// B. Logika Pembuatan Inisial Nama untuk Avatar Box Admin
$kata    = explode(' ', $nama);
$inisial = strtoupper(substr($kata[0], 0, 1));
if (isset($kata[1])) {
    $inisial .= strtoupper(substr($kata[1], 0, 1));
}

try {
    // B. Menghitung otomatis nominal saldo kas dari database secara riil
    $total_masuk = $koneksi->query("SELECT SUM(p.nominal) FROM tagihan_kas t 
                                    JOIN periode_kas p ON t.periode_kas_id = p.id 
                                    WHERE t.status = 'lunas'")->fetchColumn() ?? 0;
                                    
    $total_keluar = $koneksi->query("SELECT SUM(nominal) FROM pengeluaran_kas")->fetchColumn() ?? 0;
    $saldo_kelas = $total_masuk - $total_keluar;

    // C. Mengambil data siswa aktif untuk looping pilihan dropdown
    $query_siswa = "SELECT id, nama FROM siswa WHERE status = 'aktif' ORDER BY nama ASC";
    $list_siswa = $koneksi->query($query_siswa)->fetchAll(PDO::FETCH_ASSOC);

    // C. Mengambil data periode kas untuk looping pilihan minggu
    $query_periode = "SELECT id, minggu_ke FROM periode_kas ORDER BY tahun DESC, bulan DESC, minggu_ke DESC";
    $list_periode = $koneksi->query($query_periode)->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    die("Gagal memuat data komponen dinamis: " . $e->getMessage());
}
?>
