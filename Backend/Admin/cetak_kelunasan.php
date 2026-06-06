<?php
// 1. Hubungkan langsung ke file logic tagihan admin (Mundur 3 tingkat)
// File logic ini otomatis memvalidasi auth_admin dan menghitung statistik KPI berdasarkan ?periode_id
require_once 'Logic_tagihan_admin.php';

// Fungsi helper format tanggal Indonesia untuk tanggal cetak laporan
function formatTanggalCetak($dateStr) {
    $months = [1 => 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
    $time = strtotime($dateStr);
    return date('d', $time) . ' ' . $months[(int)date('m', $time)] . ' ' . date('Y', $time);
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Laporan Kelunasan Uang Kas - Minggu <?= $minggu_ke_label; ?></title>
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

        /* Grid Ringkasan KPI Statistik Minggu Terpilih */
        .meta-summary-grid {
            display: flex;
            justify-content: space-between;
            background-color: #f8f9fa;
            border: 1px solid #dee2e6;
            padding: 15px 20px;
            border-radius: 6px;
            margin-bottom: 25px;
            gap: 12px;
        }

        .meta-item {
            flex: 1;
            text-align: center;
            border-right: 1px solid #dee2e6;
        }

        .meta-item:last-child {
            border-right: none;
        }

        .meta-item h4 {
            margin: 0 0 6px 0;
            color: #6c757d;
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .meta-item p {
            margin: 0;
            font-weight: bold;
            font-size: 15px;
        }

        .text-green { color: #28a745; }
        .text-red { color: #dc3545; }
        .text-dark { color: #212529; }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        th {
            background-color: #f1f3f5;
            border: 1px solid #dee2e6;
            padding: 10px 12px;
            font-weight: bold;
            text-align: left;
            font-size: 12px;
        }

        td {
            border: 1px solid #dee2e6;
            padding: 10px 12px;
            vertical-align: middle;
        }

        .text-center { text-align: center; }
        .text-right { text-align: right; }
        
        .font-semibold { font-weight: 600; }
        
        /* Gaya styling badge print custom */
        .badge-print-error {
            display: inline-block;
            padding: 4px 8px;
            background-color: #fde8e8;
            color: #9b1c1c;
            border: 1px solid #f8b4b4;
            border-radius: 4px;
            font-size: 11px;
            font-weight: 600;
        }

        @media print {
            body { padding: 0; }
            .meta-summary-grid { background-color: #ffffff !important; }
            th { background-color: #eaeded !important; -webkit-print-color-adjust: exact; print-color-adjust: exact; }
            .badge-print-error { background-color: #fde8e8 !important; -webkit-print-color-adjust: exact; print-color-adjust: exact; }
        }
    </style>
</head>

<body>

    <div class="header-report">
        <h2>Laporan Tunggakan & Kelunasan Kas Kelas</h2>
        <p>Periode: Minggu Ke-<?= $minggu_ke_label; ?> (<?= htmlspecialchars($bulan_label); ?>)</p>
        <p style="font-size: 11px; color: #6c757d; margin-top: 4px;">Dicetak otomatis pada: <?= formatTanggalCetak(date('Y-m-d')); ?> | Oleh: <?= htmlspecialchars($nama); ?></p>
    </div>

    <div class="meta-summary-grid">
        <div class="meta-item">
            <h4>Rasio Kelunasan</h4>
            <p class="text-green"><?= $percentage; ?>%</p>
        </div>
        <div class="meta-item">
            <h4>Sudah Bayar</h4>
            <p class="text-dark"><?= $total_lunas; ?> / <?= $total_siswa; ?> Siswa</p>
        </div>
        <div class="meta-item">
            <h4>Belum Bayar</h4>
            <p class="text-red"><?= $total_belum; ?> Siswa</p>
        </div>
        <div class="meta-item">
            <h4>Piutang Tertunda</h4>
            <p class="text-red">Rp <?= number_format($piutang_tertunda, 0, ',', '.'); ?></p>
        </div>
    </div>

    <h3 style="font-size: 14px; margin-bottom: 10px; border-left: 3px solid #dc3545; padding-left: 8px;">Daftar Siswa Belum Bayar</h3>
    <table>
        <thead>
            <tr>
                <th style="width: 50px;" class="text-center">No</th>
                <th>Nama Siswa</th>
                <th style="width: 150px;" class="text-center">Status</th>
                <th style="width: 180px;" class="text-right">Nominal Tunggakan</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($siswa_belum_bayar)): ?>
                <tr>
                    <td colspan="4" class="text-center" style="padding: 32px; color: #6c757d; font-style: italic;">
                        Luar biasa! Seluruh siswa telah melunasi kas pada minggu ini. Tidak ada tunggakan tertunda.
                    </td>
                </tr>
            <?php else: ?>
                <?php $no = 1; foreach ($siswa_belum_bayar as $row): ?>
                    <tr>
                        <td class="text-center"><?= sprintf("%02d", $no++); ?></td>
                        <td class="font-semibold"><?= htmlspecialchars($row['nama_siswa']); ?></td>
                        <td class="text-center">
                            <span class="badge-print-error">Belum Bayar</span>
                        </td>
                        <td class="text-right" style="font-weight: bold; color: #dc3545;">
                            Rp <?= number_format($nominal_kas, 0, ',', '.'); ?>
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