<?php
require_once __DIR__ .'/../../config/auth_admin.php';

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
