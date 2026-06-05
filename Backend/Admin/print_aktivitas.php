<?php
// Ambil file logic bawaan admin untuk menarik ringkasan saldo & penunggak
require_once 'Logic_dashboard_admin.php';
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Laporan Aktivitas Terakhir Kas Kelas</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            color: #212529;
            padding: 20px;
            line-height: 1.5;
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
        }

        .header-report p {
            margin: 5px 0 0 0;
            color: #6c757d;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        th,
        td {
            border: 1px solid #dee2e6;
            padding: 12px 10px;
            text-align: left;
            font-size: 13px;
        }

        th {
            background-color: #f8f9fa;
            font-weight: bold;
        }

        .text-right {
            text-align: right;
        }

        @media print {
            body {
                padding: 0;
            }

            thead {
                display: table-header-group;
            }

            tr {
                page-break-inside: avoid;
            }
        }

        @page {
            size: auto;
            margin: 20mm;
        }
    </style>
</head>

<body>

    <div class="header-report">
        <h2>Laporan Aktivitas Terakhir Kas Kelas</h2>
        <p>Aplikasi Manajemen Keuangan Kasqeu</p>
    </div>

    <div style="margin-bottom: 25px; font-size: 14px; line-height: 1.6;">
        <strong>Dicetak Oleh:</strong> Admin (<?= htmlspecialchars($_SESSION['nama'] ?? 'Admin'); ?>)<br>
        <strong>Kategori Dokumen:</strong> 5 Transaksi Terbaru (Pemasukan & Pengeluaran)<br>
        <strong>Tanggal Cetak:</strong> <?= date('d F Y / H:i'); ?> Wib
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 5%;">No</th>
                <th style="width: 20%;">Tanggal / Waktu</th>
                <th>Keterangan / Nama</th>
                <th>Kategori / Detail</th>
                <th style="width: 15%;">Jenis</th>
                <th style="width: 18%; text-align: right;">Nominal</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($list_aktivitas)): ?>
                <tr>
                    <td colspan="6" style="text-align: center; color: #6c757d; padding: 20px;">
                        Belum ada riwayat aktivitas transaksi terbaru yang tercatat.
                    </td>
                </tr>
            <?php else: ?>
                <?php $no = 1;
                foreach ($list_aktivitas as $row): ?>
                    <tr>
                        <td><?= $no++; ?></td>
                        <td>
                            <?= $row['tanggal'] ? date('d-m-Y H:i', strtotime($row['tanggal'])) : '-'; ?>
                        </td>
                        <td><?= htmlspecialchars($row['judul']); ?></td>
                        <td><?= htmlspecialchars($row['sub_judul']); ?></td>
                        <td>
                            <?php if ($row['jenis'] === 'masuk'): ?>
                                <span class="text-green">Uang Masuk</span>
                            <?php else: ?>
                                <span class="text-red">Uang Keluar</span>
                            <?php endif; ?>
                        </td>
                        <td class="text-right <?= $row['jenis'] === 'masuk' ? 'text-green' : 'text-red'; ?>">
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