<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 1. GERBANG KEAMANAN: Jika belum login atau bukan siswa, usir kembali ke login
require_once '../../../config/auth_siswa.php';

// AMBIL TANGGAL HARI INI SECARA REAL-TIME (Dinding pembatas minggu mendatang)
$today = date('Y-m-d');

try {
    // Ambil informasi nomor WhatsApp Bendahara dari tabel admin
    $stmt_admin = $koneksi->query("SELECT no_whatsapp, nama FROM admin LIMIT 1");
    $admin_data = $stmt_admin->fetch(PDO::FETCH_ASSOC);
    $wa_bendahara   = $admin_data['no_whatsapp'] ?? '';
    $nama_bendahara = $admin_data['nama'] ?? 'Bendahara';

    // ------------------------------------------------------------------
    // PERBAIKAN C: Hitung Jumlah Tunggakan & Minggu Menunggak secara Dinamis
    // ------------------------------------------------------------------
    // Ditambahkan kondisi: AND :today >= p.tanggal_mulai pada CASE tagihan & minggu tunggakan
    // agar nominal minggu mendatang tidak dikira sebagai tunggakan oleh sistem.
    $query_pribadi = "SELECT 
                        SUM(CASE WHEN t.status = 'belum' AND :today >= p.tanggal_mulai THEN p.nominal ELSE 0 END) AS sisa_tagihan,
                        COUNT(CASE WHEN t.status = 'belum' AND :today >= p.tanggal_mulai THEN 1 END) AS minggu_tunggakan
                      FROM tagihan_kas t
                      JOIN periode_kas p ON t.periode_kas_id = p.id
                      WHERE t.siswa_id = :siswa_id";

    $stmt_pribadi = $koneksi->prepare($query_pribadi);
    $stmt_pribadi->execute([
        ':siswa_id' => $siswa_id,
        ':today'    => $today // Menyuntikkan parameter tanggal hari ini
    ]);
    $data_pribadi = $stmt_pribadi->fetch(PDO::FETCH_ASSOC);

    $my_tagihan       = $data_pribadi['sisa_tagihan'] ?? 0;
    $minggu_tunggakan = $data_pribadi['minggu_tunggakan'] ?? 0;

    // ------------------------------------------------------------------
    // PERBAIKAN D: Ambil Semua Catatan Tagihan Mingguan Milik Siswa Ini (Untuk Looping)
    // ------------------------------------------------------------------
    // Ditambahkan klausa: AND :today >= p.tanggal_mulai
    // agar baris tabel HTML siswa tidak mencetak atau membocorkan daftar minggu mendatang.
    $query_tagihan = "SELECT p.minggu_ke, p.deadline, p.nominal, t.status 
                  FROM tagihan_kas t
                  JOIN periode_kas p ON t.periode_kas_id = p.id
                  WHERE t.siswa_id = :siswa_id
                    AND (t.status = 'lunas' OR :today >= p.tanggal_mulai)
                  ORDER BY p.tahun ASC, p.bulan ASC, p.minggu_ke ASC";

    $stmt_tagihan = $koneksi->prepare($query_tagihan);
    $stmt_tagihan->execute([
        ':siswa_id' => $siswa_id,
        ':today'    => $today // Menyuntikkan parameter tanggal hari ini
    ]);
    $list_tagihan = $stmt_tagihan->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Gagal memuat data tagihan kas: " . $e->getMessage());
}

// ------------------------------------------------------------------
// OPSI PENYEMPURNAAN UX: Otomatisasi Format Nomor WhatsApp Bendahara
// ------------------------------------------------------------------
// Menghapus karakter non-angka dan mengubah angka '0' di depan menjadi '62' internasional
$clean_wa = preg_replace('/[^0-9]/', '', $wa_bendahara);
if (strpos($clean_wa, '0') === 0) {
    $clean_wa = '62' . substr($clean_wa, 1);
}

// Format Pesan API WhatsApp menggunakan link universal api.whatsapp.com yang responsif di HP/Laptop
$pesan_wa = "Halo " . $nama_bendahara . ", saya " . $nama . " ingin bertanya mengenai detail catatan tagihan kas mingguan saya.";
$link_wa  = "https://api.whatsapp.com/send?phone=" . $clean_wa . "&text=" . urlencode($pesan_wa);
