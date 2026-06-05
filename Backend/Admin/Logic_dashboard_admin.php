<?php
session_start();
require_once __DIR__ .'/../../config/auth_admin.php';

try {
    // =========================================================================
    // C. Komponen Kartu KPI Finansial Utama
    // =========================================================================
    // 1. Total Pemasukan Keseluruhan dari iuran yang berstatus lunas
    $total_masuk = $koneksi->query("SELECT SUM(p.nominal) FROM tagihan_kas t 
                                    JOIN periode_kas p ON t.periode_kas_id = p.id 
                                    WHERE t.status = 'lunas'")->fetchColumn() ?? 0;
                                    
    // 2. Total Pengeluaran Keseluruhan dari kas kelas
    $total_keluar = $koneksi->query("SELECT SUM(nominal) FROM pengeluaran_kas")->fetchColumn() ?? 0;
    
    // 3. Total Saldo Kas Bersih (Uang fisik saat ini)
    $saldo_kelas = $total_masuk - $total_keluar;

    // =========================================================================
    // D. Tabel Ringkasan Aktivitas Terakhir (UNION Limit 5)
    // =========================================================================
    $query_aktivitas = "(SELECT t.tanggal_bayar AS tanggal, s.nama AS judul, CONCAT('Iuran Wajib Minggu ', p.minggu_ke) AS sub_judul, 'masuk' AS jenis, p.nominal AS nominal 
                         FROM tagihan_kas t 
                         JOIN siswa s ON t.siswa_id = s.id 
                         JOIN periode_kas p ON t.periode_kas_id = p.id 
                         WHERE t.status = 'lunas')
                        UNION ALL
                        (SELECT tanggal AS tanggal, keterangan AS judul, kategori AS sub_judul, 'keluar' AS jenis, nominal AS nominal 
                         FROM pengeluaran_kas)
                        ORDER BY tanggal DESC 
                        LIMIT 5";
                        
    $list_aktivitas = $koneksi->query($query_aktivitas)->fetchAll(PDO::FETCH_ASSOC);

    // =========================================================================
    // E. Komponen Sisi Kiri: Diagram Progres Kelunasan Minggu Ini / Terbaru
    // =========================================================================
    // Ambil periode kas paling baru/terakhir ditambahkan
    $latest_period = $koneksi->query("SELECT id, minggu_ke FROM periode_kas ORDER BY tahun DESC, bulan DESC, minggu_ke DESC LIMIT 1")->fetch(PDO::FETCH_ASSOC);
    
    $pct_lunas = 0;
    $total_aktif = 0;
    $total_lunas_minggu_ini = 0;
    $minggu_ke_text = "-";
    
    if ($latest_period) {
        $pid = $latest_period['id'];
        $minggu_ke_text = $latest_period['minggu_ke'];
        
        // Total mahasiswa/siswa aktif
        $total_aktif = $koneksi->query("SELECT COUNT(*) FROM siswa WHERE status = 'aktif'")->fetchColumn() ?? 0;
        
        // Jumlah siswa aktif yang lunas pada periode ini
        $stmt_lunas_ini = $koneksi->prepare("SELECT COUNT(*) FROM tagihan_kas t JOIN siswa s ON t.siswa_id = s.id WHERE t.periode_kas_id = :pid AND t.status = 'lunas' AND s.status = 'aktif'");
        $stmt_lunas_ini->execute([':pid' => $pid]);
        $total_lunas_minggu_ini = $stmt_lunas_ini->fetchColumn() ?? 0;
        
        if ($total_aktif > 0) {
            $pct_lunas = round(($total_lunas_minggu_ini / $total_aktif) * 100);
        }
    }
    
    // Perhitungan stroke-dashoffset SVG (314.159 adalah keliling lingkaran dengan r=50)
    $dasharray = 314.159;
    $dashoffset = $dasharray * (1 - ($pct_lunas / 100));

    // =========================================================================
    // F. Komponen Sisi Kanan: Daftar Penunggak Kas Teratas (Top Debtors)
    // =========================================================================
    $query_debtors = "SELECT s.nama, GROUP_CONCAT(p.minggu_ke ORDER BY p.minggu_ke ASC SEPARATOR ', ') AS minggu_tunggakan, SUM(p.nominal) AS total_tunggakan
                      FROM tagihan_kas t
                      JOIN siswa s ON t.siswa_id = s.id
                      JOIN periode_kas p ON t.periode_kas_id = p.id
                      WHERE t.status = 'belum' AND s.status = 'aktif'
                      GROUP BY s.id, s.nama
                      ORDER BY total_tunggakan DESC
                      LIMIT 3";
                      
    $list_debtors = $koneksi->query($query_debtors)->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    die("Gagal memuat data dashboard admin: " . $e->getMessage());
}
?>
