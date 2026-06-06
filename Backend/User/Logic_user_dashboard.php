<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 1. GERBANG KEAMANAN: Jika belum login atau bukan siswa, usir kembali ke login
require_once '../../../config/auth_siswa.php';

// AMBIL TANGGAL HARI INI SECARA REAL-TIME (Kunci utama pemblokir minggu mendatang)
$today = date('Y-m-d');

try {
    // ------------------------------------------------------------------
    // PERBAIKAN QUERY 1: MENGHITUNG KONTRIBUSI & SISA TAGIHAN PRIBADI SISWA
    // ------------------------------------------------------------------
    // Ditambahkan kondisi: AND :today >= p.tanggal_mulai pada CASE sisa_tagihan
    // agar minggu mendatang tidak ikut menjumlahkan nilai nominal hutang siswa.
    $query_pribadi = "SELECT 
                        SUM(CASE WHEN t.status = 'lunas' THEN p.nominal ELSE 0 END) AS total_lunas,
                        SUM(CASE WHEN t.status = 'belum' AND :today >= p.tanggal_mulai THEN p.nominal ELSE 0 END) AS sisa_tagihan
                      FROM tagihan_kas t
                      JOIN periode_kas p ON t.periode_kas_id = p.id
                      WHERE t.siswa_id = :siswa_id";

    $stmt_pribadi = $koneksi->prepare($query_pribadi);
    $stmt_pribadi->execute([
        ':siswa_id' => $siswa_id,
        ':today'    => $today // Menyuntikkan parameter tanggal hari ini
    ]);
    $data_pribadi = $stmt_pribadi->fetch(PDO::FETCH_ASSOC);

    $my_lunas   = $data_pribadi['total_lunas'] ?? 0;
    $my_tagihan = $data_pribadi['sisa_tagihan'] ?? 0;

    // ------------------------------------------------------------------
    // QUERY 2: MENGHITUNG SALDO BERSIH KAS KELAS (UANG FISIK SAAT INI)
    // ------------------------------------------------------------------
    // Bagian ini tetap aman karena hanya menghitung yang sudah 'lunas' saja.
    $total_masuk = $koneksi->query("SELECT SUM(p.nominal) FROM tagihan_kas t 
                                    JOIN periode_kas p ON t.periode_kas_id = p.id 
                                    WHERE t.status = 'lunas'")->fetchColumn() ?? 0;

    $total_keluar = $koneksi->query("SELECT SUM(nominal) FROM pengeluaran_kas")->fetchColumn() ?? 0;

    $saldo_kelas = $total_masuk - $total_keluar;

    // ------------------------------------------------------------------
    // PERBAIKAN QUERY 3: MENGAMBIL 5 CATATAN SETORAN TERAKHIR MILIK SISWA INI
    // ------------------------------------------------------------------
    // Ditambahkan klausa: AND :today >= p.tanggal_mulai 
    // agar tabel riwayat iuran milik siswa tidak memunculkan baris minggu depan yang belum mulai.
    $query_tabel = "SELECT p.minggu_ke, p.nominal, t.tanggal_bayar, t.status 
                FROM tagihan_kas t
                JOIN periode_kas p ON t.periode_kas_id = p.id
                WHERE t.siswa_id = :siswa_id
                  AND (t.status = 'lunas' OR :today >= p.tanggal_mulai)
                ORDER BY p.id DESC
                LIMIT 5";

    $stmt_tabel = $koneksi->prepare($query_tabel);
    $stmt_tabel->execute([
        ':siswa_id' => $siswa_id,
        ':today'    => $today // Menyuntikkan parameter tanggal hari ini
    ]);
    $list_setoran = $stmt_tabel->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Gagal memuat data dashboard: " . $e->getMessage());
}
