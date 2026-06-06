<?php
// Backend/Admin/Logic_tagihan_admin.php

// 1. Hubungkan langsung dengan auth admin sebagai pelindung pertama (Mundur 2 tingkat)
require_once __DIR__ .'/../../config/auth_admin.php';

// ==========================================
// C. Komponen Dropdown Filter Minggu (GET)
// ==========================================
// Ambil semua daftar periode kas untuk ditampilkan di komponen dropdown menu
$stmtPeriode = $koneksi->query("SELECT * FROM periode_kas ORDER BY id ASC");
$all_periods = $stmtPeriode->fetchAll();

// Tangkap id periode terpilih, jika kosong, ambil default periode pertama yang ada
$selected_id = isset($_GET['periode_id']) && is_numeric($_GET['periode_id']) ? (int)$_GET['periode_id'] : null;
if (!$selected_id && !empty($all_periods)) {
    $selected_id = $all_periods[0]['id'];
}

// Ambil data spesifik dari periode kas yang sedang aktif difilter
$current_period = null;
foreach ($all_periods as $p) {
    if ($p['id'] == $selected_id) {
        $current_period = $p;
        break;
    }
}

$minggu_ke_label = $current_period['minggu_ke'] ?? '-';
$bulan_label     = $current_period['bulan'] ?? '-';
$nominal_kas     = $current_period['nominal'] ?? 0;

// ==========================================
// D. Komponen Perhitungan Agregasi KPI (Statistik)
// ==========================================
// 1. Hitung total siswa keseluruhan yang diplot dalam tagihan periode ini
$stmtTotal = $koneksi->prepare("SELECT COUNT(*) FROM tagihan_kas WHERE periode_kas_id = :pid");
$stmtTotal->execute(['pid' => $selected_id]);
$total_siswa = $stmtTotal->fetchColumn();

// 2. Hitung jumlah siswa yang sudah berstatus 'lunas'
$stmtLunas = $koneksi->prepare("SELECT COUNT(*) FROM tagihan_kas WHERE periode_kas_id = :pid AND status = 'lunas'");
$stmtLunas->execute(['pid' => $selected_id]);
$total_lunas = $stmtLunas->fetchColumn();

// 3. Cari jumlah siswa yang masih belum bayar
$total_belum = $total_siswa - $total_lunas;

// 4. Hitung persentase rasio kelunasan
$percentage = $total_siswa > 0 ? round(($total_lunas / $total_siswa) * 100) : 0;

// 5. Hitung total nilai piutang tertunda (Siswa belum lunas * nominal iuran periode tersebut)
$piutang_tertunda = $total_belum * $nominal_kas;


// ==========================================
// E. Komponen Tabel Utama (Siswa Belum Bayar)
// ==========================================
$stmtBelumBayar = $koneksi->prepare("
    SELECT t.id AS tagihan_id, s.nama AS nama_siswa, s.no_whatsapp
    FROM tagihan_kas t
    JOIN siswa s ON t.siswa_id = s.id
    WHERE t.periode_kas_id = :pid AND t.status = 'belum'
    ORDER BY s.nama ASC
");
$stmtBelumBayar->execute(['pid' => $selected_id]);
$siswa_belum_bayar = $stmtBelumBayar->fetchAll();