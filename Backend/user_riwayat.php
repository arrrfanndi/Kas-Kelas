<?php
session_start();

// =========================================================================
// GERBANG KEAMANAN: Memastikan hanya siswa aktif yang bisa mengakses
// =========================================================================
if (!isset($_SESSION['login']) || $_SESSION['role'] !== 'siswa') {
    header("Location: /Login/login_dua.php");
    exit;
}

// Koneksi ke database
require_once '../Config/koneksi.php'; 

$siswa_id = $_SESSION['user_id'];
$nama     = $_SESSION['nama'];

// Logika Pembuatan Inisial Nama untuk Avatar Box
$kata    = explode(' ', $nama);
$inisial = strtoupper(substr($kata[0], 0, 1));
if (isset($kata[1])) {
    $inisial .= strtoupper(substr($kata[1], 0, 1));
}

// =========================================================================
// KOMPONEN B & D: Menangkap Parameter GET untuk Filter, Search, & Pagination
// =========================================================================
$filter = $_GET['filter'] ?? 'semua';
$search = $_GET['search'] ?? '';
$page   = isset($_GET['page']) ? (int)$_GET['page'] : 1;
if ($page < 1) $page = 1;
$limit  = 10; // Jumlah baris data per halaman
$offset = ($page - 1) * $limit;

try {
    // =========================================================================
    // KOMPONEN A: Query SQL Agregat (SUM) untuk Kartu KPI Ringkasan
    // =========================================================================
    
    // 1. Total Saldo Kelas (Total Uang Masuk Lunas - Total Pengeluaran)
    $total_masuk = $koneksi->query("SELECT SUM(p.nominal) FROM tagihan_kas t 
                                    JOIN periode_kas p ON t.periode_kas_id = p.id 
                                    WHERE t.status = 'lunas'")->fetchColumn() ?? 0;
    $total_keluar = $koneksi->query("SELECT SUM(nominal) FROM pengeluaran_kas")->fetchColumn() ?? 0;
    $saldo_kelas = $total_masuk - $total_keluar;

    // 2. Total Setoran Kamu (Total iuran milik siswa yang login dengan status lunas)
    $stmt_setoran_kamu = $koneksi->prepare("SELECT SUM(p.nominal) FROM tagihan_kas t 
                                           JOIN periode_kas p ON t.periode_kas_id = p.id 
                                           WHERE t.siswa_id = :siswa_id AND t.status = 'lunas'");
    $stmt_setoran_kamu->execute([':siswa_id' => $siswa_id]);
    $my_total_setoran = $stmt_setoran_kamu->fetchColumn() ?? 0;

    // 3. Pengeluaran Bulan Ini
    $pengeluaran_bulan_ini = $koneksi->query("SELECT SUM(nominal) FROM pengeluaran_kas 
                                              WHERE MONTH(tanggal) = MONTH(CURRENT_DATE()) 
                                              AND YEAR(tanggal) = YEAR(CURRENT_DATE())")->fetchColumn() ?? 0;

    // =========================================================================
    // KOMPONEN C & D: Tabel Utama, Struktur Query Dinamis (UNION ALL) & Pagination
    // =========================================================================
    
    // Base query menggunakan teknik UNION ALL untuk menggabungkan pemasukan & pengeluaran
    $query_base = "
        SELECT * FROM (
            SELECT t.tanggal_bayar AS tanggal, CONCAT('Iuran Mingguan - ', s.nama) AS keterangan, 'masuk' AS jenis, p.nominal AS nominal, t.siswa_id
            FROM tagihan_kas t
            JOIN periode_kas p ON t.periode_kas_id = p.id
            JOIN siswa s ON t.siswa_id = s.id
            WHERE t.status = 'lunas'
            
            UNION ALL
            
            SELECT tanggal, keterangan, 'keluar' AS jenis, nominal, NULL AS siswa_id
            FROM pengeluaran_kas
        ) AS gabungan WHERE 1=1
    ";

    $params = [];

    // Kondisi filter berdasarkan pilihan tab user
    if ($filter === 'setoran_saya') {
        $query_base .= " AND jenis = 'masuk' AND siswa_id = :siswa_id";
        $params[':siswa_id'] = $siswa_id;
    } elseif ($filter === 'pengeluaran') {
        $query_base .= " AND jenis = 'keluar'";
    }

    // Kondisi filter pencarian search bar
    if (!empty($search)) {
        $query_base .= " AND keterangan LIKE :search";
        $params[':search'] = "%" . $search . "%";
    }

    // Hitung total record data yang sesuai filter (untuk keperluan hitung total halaman pagination)
    $count_query = "SELECT COUNT(*) FROM (" . $query_base . ") AS total_data";
    $stmt_count = $koneksi->prepare($count_query);
    $stmt_count->execute($params);
    $total_records = $stmt_count->fetchColumn();
    $total_pages = ceil($total_records / $limit);
    if ($total_pages < 1) $total_pages = 1;

    // Tambahkan pengurutan transaksi terbaru serta batasan LIMIT & OFFSET (Pagination Clause)
    $query_final = $query_base . " ORDER BY tanggal DESC LIMIT $limit OFFSET $offset";
    
    $stmt_riwayat = $koneksi->prepare($query_final);
    $stmt_riwayat->execute($params);
    $list_transaksi = $stmt_riwayat->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    die("Gagal memuat data keuangan: " . $e->getMessage());
}
?>
