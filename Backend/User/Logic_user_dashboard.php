<?php
session_start();

// 1. GERBANG KEAMANAN: Jika belum login atau bukan siswa, usir kembali ke login
// (Perbaikan: Jalur diubah menjadi relatif menggunakan ../)
require_once '../../../config/auth_siswa.php';

try {
    // ------------------------------------------------------------------
    // QUERY 1: MENGHITUNG KONTRIBUSI & SISA TAGIHAN PRIBADI SISWA
    // ------------------------------------------------------------------
    $query_pribadi = "SELECT 
                        SUM(CASE WHEN t.status = 'lunas' THEN p.nominal ELSE 0 END) AS total_lunas,
                        SUM(CASE WHEN t.status = 'belum' THEN p.nominal ELSE 0 END) AS sisa_tagihan
                      FROM tagihan_kas t
                      JOIN periode_kas p ON t.periode_kas_id = p.id
                      WHERE t.siswa_id = :siswa_id";
    
    $stmt_pribadi = $koneksi->prepare($query_pribadi);
    $stmt_pribadi->execute([':siswa_id' => $siswa_id]);
    $data_pribadi = $stmt_pribadi->fetch(PDO::FETCH_ASSOC);

    $my_lunas   = $data_pribadi['total_lunas'] ?? 0;
    $my_tagihan = $data_pribadi['sisa_tagihan'] ?? 0;

    // ------------------------------------------------------------------
    // QUERY 2: MENGHITUNG SALDO BERSIH KAS KELAS (UANG FISIK SAAT INI)
    // ------------------------------------------------------------------
    $total_masuk = $koneksi->query("SELECT SUM(p.nominal) FROM tagihan_kas t 
                                    JOIN periode_kas p ON t.periode_kas_id = p.id 
                                    WHERE t.status = 'lunas'")->fetchColumn() ?? 0;
                                    
    $total_keluar = $koneksi->query("SELECT SUM(nominal) FROM pengeluaran_kas")->fetchColumn() ?? 0;
    
    $saldo_kelas = $total_masuk - $total_keluar;

    // ------------------------------------------------------------------
    // QUERY 3: MENGAMBIL 5 CATATAN SETORAN TERAKHIR MILIK SISWA INI
    // ------------------------------------------------------------------
    $query_tabel = "SELECT p.minggu_ke, p.nominal, t.tanggal_bayar, t.status 
                    FROM tagihan_kas t
                    JOIN periode_kas p ON t.periode_kas_id = p.id
                    WHERE t.siswa_id = :siswa_id
                    ORDER BY p.tahun DESC, p.bulan DESC, p.minggu_ke DESC
                    LIMIT 5";
    
    $stmt_tabel = $koneksi->prepare($query_tabel);
    $stmt_tabel->execute([':siswa_id' => $siswa_id]);
    $list_setoran = $stmt_tabel->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    die("Gagal memuat data dashboard: " . $e->getMessage());
}
?>
