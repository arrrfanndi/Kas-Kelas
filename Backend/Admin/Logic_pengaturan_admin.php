<?php
// Backend/Admin/Logic_pengaturan_admin.php

// Hubungkan langsung dengan auth admin sebagai pelindung pertama
require_once __DIR__ .'/../../config/auth_admin.php';

$show_toast = false;

// ====================================================================
// LOGIKA OTOMATISASI MINGGU BERKELANJUTAN (Urutan Naik Tanpa Batas)
// ====================================================================
$stmtLast = $koneksi->query("SELECT * FROM periode_kas ORDER BY id DESC LIMIT 1");
$last_periode = $stmtLast->fetch();

$bulan_indo = [
    1 => 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
    'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
];

if ($last_periode) {
    $next_minggu = (int)$last_periode['minggu_ke'] + 1;
    $next_tanggal_mulai = date('Y-m-d', strtotime($last_periode['tanggal_mulai'] . ' +7 days'));
    $m = (int)date('m', strtotime($next_tanggal_mulai));
    $next_bulan = $bulan_indo[$m];
    $next_tahun = date('Y', strtotime($next_tanggal_mulai));
} else {
    $next_minggu = 1;
    $next_tanggal_mulai = date('Y-m-d', strtotime('next Monday'));
    $m = (int)date('m', strtotime($next_tanggal_mulai));
    $next_bulan = $bulan_indo[$m];
    $next_tahun = date('Y', strtotime($next_tanggal_mulai));
}

// ==========================================
// D & F. Logika Form Tambah Minggu Baru (INSERT + OTOMATISASI TAGIHAN SISWA)
// ==========================================
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action_insert'])) {
    $bulan         = $_POST['bulan'];
    $tahun         = $_POST['tahun'];
    $minggu_ke     = (int)$_POST['minggu_ke'];
    $tanggal_mulai = $_POST['tanggal_mulai'];
    $nominal       = (int)$_POST['nominal'];

    try {
        $koneksi->beginTransaction();

        $sqlInsert = "INSERT INTO periode_kas (minggu_ke, bulan, tahun, tanggal_mulai, tanggal_selesai, deadline, nominal) 
                      VALUES (:minggu_ke, :bulan, :tahun, :tanggal_mulai, DATE_ADD(:tanggal_mulai, INTERVAL 6 DAY), DATE_ADD(:tanggal_mulai, INTERVAL 4 DAY), :nominal)";
        
        $stmtInsert = $koneksi->prepare($sqlInsert);
        $stmtInsert->execute([
            'minggu_ke'     => $minggu_ke,
            'bulan'         => $bulan,
            'tahun'         => $tahun,
            'tanggal_mulai' => $tanggal_mulai,
            'nominal'       => $nominal
        ]);

        $periode_id = $koneksi->lastInsertId();

        $stmtSiswa = $koneksi->query("SELECT id FROM siswa");
        $all_siswa = $stmtSiswa->fetchAll();

        $sqlTagihan = "INSERT INTO tagihan_kas (siswa_id, periode_kas_id, status, tanggal_bayar) 
                       VALUES (:siswa_id, :periode_id, 'belum', NULL)";
        $stmtTagihan = $koneksi->prepare($sqlTagihan);

        foreach ($all_siswa as $siswa) {
            $stmtTagihan->execute([
                'siswa_id'   => $siswa['id'],
                'periode_id' => $periode_id
            ]);
        }

        $koneksi->commit();
        header("Location: /frontend/Admin/Html/pengaturan_admin.php?success=1");
        exit;

    } catch (Exception $e) {
        $koneksi->rollBack();
        die("Gagal menambahkan minggu dan tagihan otomatis: " . $e->getMessage());
    }
}

if (isset($_GET['success'])) {
    $show_toast = true;
}

// ==========================================
// F. Logika Form Modal Edit (UPDATE)
// ==========================================
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action_update'])) {
    $id            = (int)$_POST['id'];
    $bulan         = $_POST['bulan'];
    $tahun         = $_POST['tahun'];
    $tanggal_mulai = $_POST['tanggal_mulai'];
    $nominal       = (int)$_POST['nominal'];

    $sqlUpdate = "UPDATE periode_kas 
                  SET bulan = :bulan, tahun = :tahun, tanggal_mulai = :tanggal_mulai, 
                      tanggal_selesai = DATE_ADD(:tanggal_mulai, INTERVAL 6 DAY), deadline = DATE_ADD(:tanggal_mulai, INTERVAL 4 DAY), nominal = :nominal 
                  WHERE id = :id";
    
    $stmtUpdate = $koneksi->prepare($sqlUpdate);
    if ($stmtUpdate->execute([
        'bulan'         => $bulan,
        'tahun'         => $tahun,
        'tanggal_mulai' => $tanggal_mulai,
        'nominal'       => $nominal,
        'id'            => $id
    ])) {
        header("Location: /frontend/Admin/Html/pengaturan_admin.php?success=1");
        exit;
    }
}

// Logika Aksi Hapus data periode kas
if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
    $del_id = (int)$_GET['id'];
    $stmtDelete = $koneksi->prepare("DELETE FROM periode_kas WHERE id = :id");
    $stmtDelete->execute(['id' => $del_id]);
    header("Location: /frontend/Admin/Html/pengaturan_admin.php");
    exit;
}

// C. Perhitungan Total Minggu Counter
$total_minggu = $koneksi->query("SELECT COUNT(*) FROM periode_kas")->fetchColumn();

// E. Komponen Tabel Utama & Pencarian (GET)
$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$sqlData = "SELECT * FROM periode_kas";
$params = [];

if ($search !== '') {
    $sqlData .= " WHERE bulan LIKE :search OR tahun LIKE :search OR minggu_ke LIKE :search";
    $params['search'] = '%' . $search . '%';
}
$sqlData .= " ORDER BY id DESC";

$stmtData = $koneksi->prepare($sqlData);
$stmtData->execute($params);
$periode_kas = $stmtData->fetchAll();