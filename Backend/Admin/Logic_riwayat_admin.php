<?php
require_once __DIR__ .'/../../config/auth_admin.php';

// Aksi : edit
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action_update'])) {
    $edit_id   = (int)$_POST['edit_id'];
    $edit_type = $_POST['edit_type'];
    $tanggal   = $_POST['tanggal'];
    $nominal   = (int)$_POST['nominal'];
    $keterangan= $_POST['keterangan'];

    if ($edit_type === 'masuk') {
        $stmt = $koneksi->prepare("UPDATE tagihan_kas SET tanggal_bayar = :tanggal WHERE id = :id");
        $stmt->execute([
            'tanggal' => $tanggal . ' ' . date('H:i:s'),
            'id'      => $edit_id
        ]);
    } elseif ($edit_type === 'keluar') {
        $stmt = $koneksi->prepare("UPDATE pengeluaran_kas SET tanggal = :tanggal, keterangan = :keterangan, nominal = :nominal WHERE id = :id");
        $stmt->execute([
            'tanggal'    => $tanggal,
            'keterangan' => $keterangan,
            'nominal'    => $nominal,
            'id'         => $edit_id
        ]);
    }

    header("Location: riwayat_admin.php");
    exit;
}

// Aksi : Hapus dan Rollback
if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id']) && isset($_GET['type'])) {
    $id = (int)$_GET['id'];
    $type = $_GET['type'];

    if ($type === 'masuk') {
        $stmt = $koneksi->prepare("UPDATE tagihan_kas SET status = 'belum', tanggal_bayar = NULL WHERE id = :id");
        $stmt->execute(['id' => $id]);
    } elseif ($type === 'keluar') {
        $stmt = $koneksi->prepare("DELETE FROM pengeluaran_kas WHERE id = :id");
        $stmt->execute(['id' => $id]);
    }
    
    header("Location: riwayat_admin.php");
    exit;
}

//Pencarian dan Pagination
$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$page   = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
if ($page < 1) $page = 1;

$limit  = 10;
$offset = ($page - 1) * $limit;

$searchClause = "";
$params = [];
if ($search !== '') {
    $searchClause = " WHERE nama_keterangan LIKE :search OR sub_keterangan LIKE :search";
    $params['search'] = '%' . $search . '%';
}

$sqlCount = "SELECT COUNT(*) FROM (
    SELECT s.nama AS nama_keterangan, CONCAT('Iuran Kas Minggu ke-', p.minggu_ke) AS sub_keterangan 
    FROM tagihan_kas t 
    JOIN siswa s ON t.siswa_id = s.id 
    JOIN periode_kas p ON t.periode_kas_id = p.id 
    WHERE t.status = 'lunas'
    UNION ALL
    SELECT keterangan AS nama_keterangan, kategori AS sub_keterangan FROM pengeluaran_kas
) AS gabungan" . $searchClause;

$stmtCount = $koneksi->prepare($sqlCount);
$stmtCount->execute($params);
$totalRows = $stmtCount->fetchColumn(); 

$totalPages = ceil($totalRows / $limit);

$sqlData = "SELECT * FROM (
    SELECT 
        t.id AS original_id,
        DATE(t.tanggal_bayar) AS tanggal,
        s.nama AS nama_keterangan,
        CONCAT('Iuran Kas Minggu ke-', p.minggu_ke) AS sub_keterangan,
        'masuk' AS jenis,
        p.nominal AS nominal
    FROM tagihan_kas t
    JOIN siswa s ON t.siswa_id = s.id
    JOIN periode_kas p ON t.periode_kas_id = p.id
    WHERE t.status = 'lunas'
    
    UNION ALL
    
    SELECT 
        id AS original_id,
        tanggal,
        keterangan AS nama_keterangan,
        kategori AS sub_keterangan,
        'keluar' AS jenis,
        nominal
    FROM pengeluaran_kas
) AS gabungan" . $searchClause . " ORDER BY tanggal DESC LIMIT :limit OFFSET :offset";

$stmtData = $koneksi->prepare($sqlData);
$stmtData->bindValue(':limit', $limit, PDO::PARAM_INT);
$stmtData->bindValue(':offset', $offset, PDO::PARAM_INT);
foreach ($params as $key => $val) {
    $stmtData->bindValue(':' . $key, $val);
}
$stmtData->execute();
$transaksi = $stmtData->fetchAll();

function formatTanggalIndo($dateStr) {
    if (!$dateStr) return '-';
    $months = [1 => 'Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agt', 'Sep', 'Okt', 'Nov', 'Des'];
    $time = strtotime($dateStr);
    return date('d', $time) . ' ' . $months[(int)date('m', $time)] . ' ' . date('Y', $time);
}