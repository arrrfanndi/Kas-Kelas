<?php
// 1. Ambil proteksi session siswa & koneksi database
require_once '../../config/auth_siswa.php'; // Sesuaikan arah folder auth_siswa Anda

try {
    // 2. Ambil Ringkasan Tunggakan Pribadi Siswa
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

    // 3. Ambil Semua Catatan Rincian Tagihan Mingguan dari Awal - Akhir
    $query_tagihan = "SELECT p.minggu_ke, p.deadline, p.nominal, t.status 
                      FROM tagihan_kas t
                      JOIN periode_kas p ON t.periode_kas_id = p.id
                      WHERE t.siswa_id = :siswa_id
                      ORDER BY p.tahun ASC, p.bulan ASC, p.minggu_ke ASC";
    
    $stmt_tagihan = $koneksi->prepare($query_tagihan);
    $stmt_tagihan->execute([':siswa_id' => $siswa_id]);
    $list_tagihan = $stmt_tagihan->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    die("Gagal memuat laporan tagihan: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Tagihan Kas - <?= htmlspecialchars($nama); ?></title>
    <style>
        body { font-family: 'Arial', sans-serif; color: #212529; padding: 20px; }
        .header-laporan { text-align: center; margin-bottom: 25px; border-bottom: 2px solid #212529; padding-bottom: 10px; }
        .header-laporan h2 { margin: 0; text-transform: uppercase; }
        .header-laporan p { margin: 5px 0 0 0; color: #6c757d; }
        
        .box-ringkasan { display: flex; gap: 20px; margin-bottom: 25px; }
        .card-mini { flex: 1; border: 1px solid #dee2e6; padding: 15px; border-radius: 6px; background-color: #f8f9fa; }
        .card-mini span { display: block; font-size: 12px; color: #6c757d; text-transform: uppercase; font-weight: bold; }
        .card-mini h3 { margin: 5px 0 0 0; font-size: 20px; color: #212529; }
        .text-danger { color: #dc3545 !important; }

        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #dee2e6; padding: 10px; text-align: left; font-size: 13px; }
        th { background-color: #f8f9fa; font-weight: bold; }
        
        .badge-lunas { color: #198754; font-weight: bold; background-color: #e6f4ea; padding: 3px 8px; border-radius: 4px; display: inline-block; }
        .badge-belum { color: #dc3545; font-weight: bold; background-color: #fff5f5; padding: 3px 8px; border-radius: 4px; display: inline-block; }

        @media print {
            thead { display: table-header-group; }
            tr { page-break-inside: avoid; }
            body { padding: 0; }
        }
        @page { size: auto; margin: 15mm; }
    </style>
</head>
<body>

    <div class="header-laporan">
        <h2>Laporan Tagihan Kas Siswa</h2>
        <p>Sistem Informasi Kasqeu</p>
    </div>

    <div style="margin-bottom: 20px; font-size: 14px; line-height: 1.6;">
        <strong>Nama Siswa:</strong> <?= htmlspecialchars($nama); ?><br>
        <strong>Tanggal Cetak:</strong> <?= date('d F Y / H:i'); ?>
    </div>

    <div class="box-ringkasan">
        <div class="card-mini">
            <span>Total Tunggakan</span>
            <h3 class="<?= $my_tagihan > 0 ? 'text-danger' : ''; ?>">
                Rp <?= number_format($my_tagihan, 0, ',', '.'); ?>
            </h3>
        </div>
        <div class="card-mini">
            <span>Minggu Menunggak</span>
            <h3 class="<?= $minggu_tunggakan > 0 ? 'text-danger' : ''; ?>">
                <?= $minggu_tunggakan; ?> Minggu
            </h3>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 5%;">No</th>
                <th>Periode / Minggu</th>
                <th>Batas Pembayaran (Deadline)</th>
                <th>Nominal Iuran</th>
                <th style="text-align: center; width: 20%;">Status</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($list_tagihan)): ?>
                <tr>
                    <td colspan="5" style="text-align: center; color: #6c757d;">Belum ada data tagihan yang diterbitkan.</td>
                </tr>
            <?php else: ?>
                <?php $no = 1; foreach ($list_tagihan as $row): ?>
                    <tr>
                        <td><?= $no++; ?></td>
                        <td>Minggu Ke-<?= htmlspecialchars($row['minggu_ke']); ?></td>
                        <td><?= date('d-m-Y', strtotime($row['deadline'])); ?></td>
                        <td>Rp <?= number_format($row['nominal'], 0, ',', '.'); ?></td>
                        <td style="text-align: center;">
                            <?php if ($row['status'] === 'lunas'): ?>
                                <span class="badge-lunas">Lunas</span>
                            <?php else: ?>
                                <span class="badge-belum">Belum Bayar</span>
                            <?php endif; ?>
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