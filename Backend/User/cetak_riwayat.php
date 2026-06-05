<?php
// 1. Ambil proteksi session siswa & koneksi database
require_once '../../config/auth_siswa.php'; // Sesuaikan arah folder auth_siswa Anda

// 2. Tangkap parameter filter saja (Abaikan search bar)
$filter = $_GET['filter'] ?? 'semua';

try {
    // Query dasar gabungan Pemasukan & Pengeluaran dari database
    $query_base = "
        SELECT * FROM (
            SELECT t.tanggal_bayar AS tanggal, s.nama AS judul, CONCAT('Iuran Wajib Minggu ', p.minggu_ke) AS sub_judul, 'masuk' AS jenis, p.nominal, t.siswa_id
            FROM tagihan_kas t
            JOIN siswa s ON t.siswa_id = s.id
            JOIN periode_kas p ON t.periode_kas_id = p.id
            WHERE t.status = 'lunas'
            UNION ALL
            SELECT tanggal AS tanggal, keterangan AS judul, kategori AS sub_judul, 'keluar' AS jenis, nominal, NULL AS siswa_id
            FROM pengeluaran_kas
        ) AS gabungan WHERE 1=1
    ";

    $params = [];

    // Filter query hanya berdasarkan 3 kondisi tab
    if ($filter === 'setoran_saya') {
        $query_base .= " AND jenis = 'masuk' AND siswa_id = :siswa_id";
        $params[':siswa_id'] = $siswa_id;
    } elseif ($filter === 'pengeluaran') {
        $query_base .= " AND jenis = 'keluar'";
    }

    // Urutkan dari yang paling baru (Tanpa LIMIT agar semua data tercetak)
    $query_final = $query_base . " ORDER BY tanggal DESC";
    $stmt = $koneksi->prepare($query_final);
    $stmt->execute($params);
    $data_laporan = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    die("Gagal memuat laporan: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Transaksi Kas - Kasqeu</title>
    <style>
        body { font-family: 'Arial', sans-serif; color: #212529; padding: 20px; }
        .header-laporan { text-align: center; margin-bottom: 30px; border-bottom: 2px solid #212529; padding-bottom: 10px; }
        .header-laporan h2 { margin: 0; text-transform: uppercase; }
        .header-laporan p { margin: 5px 0 0 0; color: #6c757d; }
        .meta-info { margin-bottom: 15px; font-size: 14px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #dee2e6; padding: 10px; text-align: left; font-size: 13px; }
        th { background-color: #f8f9fa; font-weight: bold; }
        .badge-masuk { color: #198754; font-weight: bold; }
        .badge-keluar { color: #dc3545; font-weight: bold; }
        
        /* Otomatis memicu perintah cetak bawaan browser saat halaman dimuat */
        @media print {
            .btn-kembali { display: none; } /* Sembunyikan tombol saat dicetak */
        }
    </style>
</head>
<body>

    <div class="header-laporan">
        <h2>Laporan Transaksi Kas Kelas</h2>
        <p>Aplikasi Kasqeu Management System</p>
    </div>

    <div class="meta-info">
        <strong>Kategori Laporan:</strong> Riwayat <?= ucfirst(str_replace('_', ' ', $filter)); ?><br>
        <strong>Tanggal Cetak:</strong> <?= date('d F Y / H:i'); ?>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Keterangan / Nama</th>
                <th>Kategori</th>
                <th>Jenis</th>
                <th>Nominal</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($data_laporan)): ?>
                <tr>
                    <td colspan="6" style="text-align: center; color: #6c757d;">Tidak ada data transaksi ditemukan untuk filter ini.</td>
                </tr>
            <?php else: ?>
                <?php $no = 1; foreach ($data_laporan as $row): ?>
                    <tr>
                        <td><?= $no++; ?></td>
                        <td><?= date('d-m-Y', strtotime($row['tanggal'])); ?></td>
                        <td><?= htmlspecialchars($row['judul']); ?></td>
                        <td><?= htmlspecialchars($row['sub_judul']); ?></td>
                        <td>
                            <?php if ($row['jenis'] === 'masuk'): ?>
                                <span class="badge-masuk">Uang Masuk</span>
                            <?php else: ?>
                                <span class="badge-keluar">Uang Keluar</span>
                            <?php endif; ?>
                        </td>
                        <td>Rp <?= number_format($row['nominal'], 0, ',', '.'); ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>

    <script>
        window.addEventListener('DOMContentLoaded', () => {
            window.print();
        });
    </script>
</body>
</html>