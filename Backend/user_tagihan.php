<?php
session_start();

// =========================================================================
// A. Sistem Autentikasi & Inisial Avatar (Paling Atas File)
// =========================================================================
if (!isset($_SESSION['login']) || $_SESSION['role'] !== 'siswa') {
    header("Location: /Login/login_dua.php");
    exit;
}

// Menghubungkan ke konfigurasi database
require_once '../Config/koneksi.php'; 

$siswa_id = $_SESSION['user_id'];
$nama     = $_SESSION['nama'];

// B. Logika Pembuatan Inisial Nama untuk Avatar Box
$kata    = explode(' ', $nama);
$inisial = strtoupper(substr($kata[0], 0, 1));
if (isset($kata[1])) {
    $inisial .= strtoupper(substr($kata[1], 0, 1));
}

try {
    // Ambil informasi nomor WhatsApp Bendahara dari tabel admin
    $stmt_admin = $koneksi->query("SELECT no_whatsapp, nama FROM admin LIMIT 1");
    $admin_data = $stmt_admin->fetch(PDO::FETCH_ASSOC);
    $wa_bendahara   = $admin_data['no_whatsapp'] ?? '';
    $nama_bendahara = $admin_data['nama'] ?? 'Bendahara';

    // C. Logika Hitung Jumlah Tunggakan & Minggu Menunggak secara Dinamis
    $query_pribadi = "SELECT 
                        SUM(CASE WHEN t.status = 'belum' THEN p.nominal ELSE 0 END) AS sisa_tagihan,
                        COUNT(CASE WHEN t.status = 'belum' THEN 1 END) AS minggu_tunggakan
                      FROM tagihan_kas t
                      JOIN periode_kas p ON t.periode_kas_id = p.id
                      WHERE t.siswa_id = :siswa_id";
    
    $stmt_pribadi = $koneksi->prepare($query_pribadi);
    $stmt_pribadi->execute([':siswa_id' => $siswa_id]);
    $data_pribadi = $stmt_pribadi->fetch(PDO::FETCH_ASSOC);

    $my_tagihan       = $data_pribadi['sisa_tagihan'] ?? 0;
    $minggu_tunggakan = $data_pribadi['minggu_tunggakan'] ?? 0;

    // D. Ambil Semua Catatan Tagihan Mingguan Milik Siswa Ini (Untuk Looping)
    $query_tagihan = "SELECT p.minggu_ke, p.deadline, p.nominal, t.status 
                      FROM tagihan_kas t
                      JOIN periode_kas p ON t.periode_kas_id = p.id
                      WHERE t.siswa_id = :siswa_id
                      ORDER BY p.tahun ASC, p.bulan ASC, p.minggu_ke ASC";
    
    $stmt_tagihan = $koneksi->prepare($query_tagihan);
    $stmt_tagihan->execute([':siswa_id' => $siswa_id]);
    $list_tagihan = $stmt_tagihan->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    die("Gagal memuat data tagihan kas: " . $e->getMessage());
}

// Format Pesan API WhatsApp
$pesan_wa = "Halo " . $nama_bendahara . ", saya " . $nama . " ingin bertanya mengenai detail catatan tagihan kas mingguan saya.";
$link_wa  = "https://wa.me/62" . $wa_bendahara . "?text=" . urlencode($pesan_wa);
?>