<?php
// Config/get_minggu_tagihan.php
require_once 'koneksi.php'; // Menggunakan koneksi database yang sudah ada

header('Content-Type: application/json');

if (!isset($_GET['siswa_id']) || empty($_GET['siswa_id'])) {
    echo json_encode([]);
    exit;
}

$siswa_id = $_GET['siswa_id'];

try {
    // Query untuk mengambil periode yang BELUM dibayar/lunas oleh siswa tersebut
    $query = "SELECT id, minggu_ke, bulan, tahun, nominal FROM periode_kas 
          WHERE id NOT IN (
              SELECT periode_kas_id FROM tagihan_kas 
              WHERE siswa_id = :siswa_id AND status = 'lunas'
          ) 
          ORDER BY tahun DESC, bulan DESC, minggu_ke DESC";

    $stmt = $koneksi->prepare($query);
    $stmt->execute([':siswa_id' => $siswa_id]);
    $list_periode = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($list_periode);
} catch (PDOException $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
