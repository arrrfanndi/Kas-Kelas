<?php
// Hubungkan dengan guard keamanan session admin dan database (Mundur 3 tingkat)
require_once __DIR__ .'/../../config/auth_admin.php';

// Tangkap filter pencarian jika ada dari halaman riwayat sebelumnya
$search = isset($_GET['search']) ? trim($_GET['search']) : '';

$searchClause = "";
$params = [];
if ($search !== '') {
    $searchClause = " WHERE nama_keterangan LIKE :search OR sub_keterangan LIKE :search";
    $params['search'] = '%' . $search . '%';
}

// Query mengambil seluruh data riwayat gabungan TANPA LIMIT PAGINATION agar tercetak semua
$sqlData = "SELECT * FROM (
    SELECT 
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
        tanggal,
        keterangan AS nama_keterangan,
        kategori AS sub_keterangan,
        'keluar' AS jenis,
        nominal
    FROM pengeluaran_kas
) AS gabungan" . $searchClause . " ORDER BY tanggal DESC";

$stmtData = $koneksi->prepare($sqlData);
foreach ($params as $key => $val) {
    $stmtData->bindValue(':' . $key, $val);
}
$stmtData->execute();
$list_riwayat = $stmtData->fetchAll();

// Hitung Ringkasan Total Masuk, Keluar, dan Saldo untuk Header Laporan Cetak
$total_masuk = 0;
$total_keluar = 0;
foreach ($list_riwayat as $row) {
    if ($row['jenis'] === 'masuk') {
        $total_masuk += $row['nominal'];
    } else {
        $total_keluar += $row['nominal'];
    }
}
$saldo_akhir = $total_masuk - $total_keluar;

// Fungsi helper format tanggal Indonesia
function formatTanggalIndo($dateStr) {
    if (!$dateStr) return '-';
    $months = [1 => 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
    $time = strtotime($dateStr);
    return date('d', $time) . ' ' . $months[(int)date('m', $time)] . ' ' . date('Y', $time);
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Laporan Riwayat Transaksi Kas Kelas</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            color: #212529;
            padding: 20px;
            line-height: 1.5;
            font-size: 13px;
        }

        .header-report {
            text-align: center;
            margin-bottom: 25px;
            border-bottom: 2px solid #212529;
            padding-bottom: 10px;
            position: relative;
        }

        .header-report h2 {
            margin: 0;
            text-transform: uppercase;
            font-size: 18px;
            letter-spacing: 0.5px;
        }

        .header-report p {
            margin: 5px 0 0 0;
            color: #495057;
        }

        .meta-summary-grid {
            display: flex;
            justify-content: space-between;
            background-color: #f8f9fa;
            border: 1px solid #dee2e6;
            padding: 12px 20px;
            border-radius: 6px;
            margin-bottom: 20px;
        }

        .meta-item h4 {
            margin: 0 0 4px 0;
            color: #6c757d;
            font-size: 11px;
            text-transform: uppercase;
        }

        .meta-item p {
            margin: 0;
            font-weight: bold;
            font-size: 14px;
        }

        .text-green { color: #28a745; }
        .text-red { color: #dc3545; }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        th {
            background-color: #f1f3f5;
            border: 1px solid #dee2e6;
            padding: 10px;
            font-weight: bold;
            text-align: left;
        }

        td {
            border: 1px solid #dee2e6;
            padding: 10px;
            vertical-align: top;
        }

        .text-center { text-align: center; }
        .text-right { text-align: right; }
        
        .row-title { font-weight: 600; color: #212529; }
        .row-subtitle { font-size: 11px; color: #6c757d; margin-top: 2px; }

        @media print {
            body { padding: 0; }
            .meta-summary-grid { background-color: #ffffff !important; }
            th { background-color: #eaeded !important; -webkit-print-color-adjust: exact; print-color-adjust: exact; }
        }
    </style>
</head>

<body>

    <div class="header-report">
        <h2>Laporan Riwayat Transaksi Kas Kelas</h2>
        <p>Dicetak secara otomatis oleh Sistem Kasqeu pada: <?= date('d-m-Y H:i'); ?> WIB</p>
        <?php if ($search !== ''): ?>
            <p style="font-size: 11px; font-style: italic; margin-top: 4px;">* Filter kata kunci pencarian aktif: "<?= htmlspecialchars($search); ?>"</p>
        <?php endif; ?>
    </div>

    <div class="meta-summary-grid">
        <div class="meta-item">
            <h4>Total Pemasukan (Iuran)</h4>
            <p class="text-green">Rp <?= number_format($total_masuk, 0, ',', '.'); ?></p>
        </div>
        <div class="meta-item">
            <h4>Total Pengeluaran</h4>
            <p class="text-red">Rp <?= number_format($total_keluar, 0, ',', '.'); ?></p>
        </div>
        <div class="meta-item">
            <h4>Saldo Bersih Saat Ini</h4>
            <p style="color: #212529;">Rp <?= number_format($saldo_akhir, 0, ',', '.'); ?></p>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 40px;" class="text-center">No</th>
                <th style="width: 110px;">Tanggal</th>
                <th>Nama / Keterangan Transaksi</th>
                <th style="width: 100px;" class="text-center">Jenis</th>
                <th style="width: 130px;" class="text-right">Nominal</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($list_riwayat)): ?>
                <tr>
                    <td colspan="5" class="text-center" style="padding: 24px; color: #6c757d;">
                        Tidak ditemukan catatan riwayat transaksi kas yang terdaftar.
                    </td>
                </tr>
            <?php else: ?>
                <?php $no = 1; foreach ($list_riwayat as $row): ?>
                    <tr>
                        <td class="text-center"><?= sprintf("%02d", $no++); ?></td>
                        <td><?= formatTanggalIndo($row['tanggal']); ?></td>
                        <td>
                            <div class="row-title"><?= htmlspecialchars($row['nama_keterangan']); ?></div>
                            <div class="row-subtitle"><?= htmlspecialchars($row['sub_keterangan']); ?></div>
                        </td>
                        <td class="text-center">
                            <strong><?= $row['jenis'] === 'masuk' ? 'Uang Masuk' : 'Uang Keluar'; ?></strong>
                        </td>
                        <td class="text-right <?= $row['jenis'] === 'masuk' ? 'text-green' : 'text-red'; ?>" style="font-weight: bold;">
                            Rp <?= number_format($row['nominal'], 0, ',', '.'); ?>
                        </td>
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