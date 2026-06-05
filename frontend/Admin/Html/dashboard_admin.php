<?php
require_once '../../../Backend/Admin/Logic_dashboard_admin.php';
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kasqeu - Admin - Dashboard</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="../../User/Css/user_dashboard.css">
    <link rel="stylesheet" href="../Css/dashboard_admin.css">
</head>

<body>

    <header class="navbar">
        <div class="nav-container">
            <div class="nav-left">
                <span class="logo">Kasqeu</span>
                <nav class="nav-links">
                    <a href="#" class="active">Dashboard</a>
                    <a href="inputTransaksi_admin.php">Input Transaksi</a>
                    <a href="riwayat_admin.php">Riwayat</a>
                    <a href="tagihan_admin.php">Tagihan</a>
                    <a href="pengaturan_admin.php">Pengaturan</a>
                    <a href="role_admin.php">Role</a>
                </nav>
            </div>
            <div class="nav-right">
                <div class="user-info">
                    <span class="user-name"><?= htmlspecialchars($nama) ?></span>
                    <span class="user-role">Admin</span>
                </div>
                <div class="avatar-box"><?= $inisial ?></div>
                <button class="btn-logout" onclick="window.location.href='/config/logout.php'">
                    <span class="material-symbols-outlined">logout</span>
                    <span>Logout</span>
                </button>
            </div>
        </div>
    </header>

    <main class="main-content">

        <section class="welcome-section">
            <h1>Dashboard Utama</h1>
            <p>Selamat datang kembali, Admin. Berikut adalah ringkasan keuangan kas kita.</p>
        </section>

        <div class="kpi-grid">
            <div class="kpi-card border-blue">
                <div class="kpi-card-header">
                    <div class="icon-wrapper text-blue bg-blue-light">
                        <span class="material-symbols-outlined icon-fill">account_balance_wallet</span>
                    </div>
                    <span class="card-tag">Per Hari Ini</span>
                </div>
                <p class="card-label">Total Saldo Kas</p>
                <h3 class="card-value">Rp <?= number_format($saldo_kelas, 0, ',', '.') ?></h3>
            </div>

            <div class="kpi-card border-green">
                <div class="kpi-card-header">
                    <div class="icon-wrapper text-green bg-green-light">
                        <span class="material-symbols-outlined icon-fill">payments</span>
                    </div>
                    <span class="card-tag">Akumulatif</span>
                </div>
                <p class="card-label">Total Pemasukan Keseluruhan</p>
                <h3 class="card-value">Rp <?= number_format($total_masuk, 0, ',', '.') ?></h3>
            </div>

            <div class="kpi-card border-red">
                <div class="kpi-card-header">
                    <div class="icon-wrapper text-red bg-red-light">
                        <span class="material-symbols-outlined icon-fill">receipt_long</span>
                    </div>
                    <span class="card-tag">Pengeluaran</span>
                </div>
                <p class="card-label">Total Pengeluaran Keseluruhan</p>
                <h3 class="card-value text-red">Rp <?= number_format($total_keluar, 0, ',', '.') ?></h3>
            </div>
        </div>

        <section class="table-section">
            <div class="table-header-panel">
                <h4>Ringkasan Aktivitas Terakhir</h4>
                <button class="btn-print-report" onclick="window.location.href='/Backend/Admin/print_aktivitas.php'">Cetak Laporan</button>
            </div>

            <div class="table-responsive">
                <table class="data-table-admin">
                    <thead>
                        <tr>
                            <th style="width: 50px;">No</th>
                            <th style="width: 130px;">Tanggal</th>
                            <th>Nama/Keterangan</th>
                            <th class="text-center" style="width: 120px;">Jenis</th>
                            <th class="text-right-align" style="width: 140px;">Nominal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($list_aktivitas)): ?>
                            <tr>
                                <td colspan="5" class="text-center" style="padding: 24px; color: #9ca3af;">Belum ada riwayat transaksi keuangan masuk atau keluar.</td>
                            </tr>
                        <?php else: ?>
                            <?php 
                            $no = 1;
                            foreach ($list_aktivitas as $row): 
                                $tgl_format = ($row['tanggal']) ? date('d M Y', strtotime($row['tanggal'])) : '-';
                                $is_masuk   = ($row['jenis'] === 'masuk');
                                
                                // Menyesuaikan kelas badge & font warna sesuai bawaan template iuran/pengeluaran
                                $badge_class = $is_masuk ? 'badge-row badge-row-success' : 'badge-row badge-row-error';
                                $icon_badge  = $is_masuk ? 'arrow_downward' : 'arrow_upward';
                                $text_badge  = $is_masuk ? 'Masuk' : 'Keluar';
                                $color_class = $is_masuk ? 'text-green' : 'text-red';
                            ?>
                                <tr>
                                    <td class="text-muted"><?= str_pad($no++, 2, '0', STR_PAD_LEFT) ?></td>
                                    <td class="text-muted"><?= $tgl_format ?></td>
                                    <td>
                                        <div class="row-title"><?= htmlspecialchars($row['judul']) ?></div>
                                        <div class="row-subtitle"><?= htmlspecialchars($row['sub_judul']) ?></div>
                                    </td>
                                    <td>
                                        <span class="<?= $badge_class ?>">
                                            <span class="material-symbols-outlined"><?= $icon_badge ?></span> <?= $text_badge ?>
                                        </span>
                                    </td>
                                    <td class="text-right-align <?= $color_class ?> font-bold">
                                        Rp <?= number_format($row['nominal'], 0, ',', '.') ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <div class="table-footer-panel">
                <span class="text-counter">Menampilkan <?= count($list_aktivitas) ?> dari 5 transaksi terbaru</span>
                <div class="pagination-arrows">
                    <button class="btn-arrow-nav disabled">
                        <span class="material-symbols-outlined">chevron_left</span>
                    </button>
                    <button class="btn-arrow-nav" onclick="window.location.href='riwayat_admin.php'">
                        <span class="material-symbols-outlined">chevron_right</span>
                    </button>
                </div>
            </div>
        </section>

        <div class="bottom-split-grid">
            <div class="split-card card-alignment-center">
                <h4 class="split-card-title">Status Kelunasan (Minggu <?= $minggu_ke_text ?>)</h4>

                <div class="circular-progress">
                    <svg class="progress-svg">
                        <circle class="circle-track" cx="60" cy="60" r="50"></circle>
                        <circle class="circle-bar" cx="60" cy="60" r="50" stroke-dasharray="314.159"
                            stroke-dashoffset="<?= $dashoffset ?>"></circle>
                    </svg>
                    <div class="progress-inner-text">
                        <span class="percentage"><?= $pct_lunas ?>%</span>
                        <span class="sub-tag">Selesai</span>
                    </div>
                </div>

                <p class="progress-desc-text">
                    <strong><?= $total_lunas_minggu_ini ?> dari <?= $total_aktif ?></strong> mahasiswa telah melunasi iuran wajib minggu ini.
                </p>

                <div class="legend-container">
                    <div class="legend-item">
                        <div class="dot-indicator bg-gold-main"></div><span>Lunas</span>
                    </div>
                    <div class="legend-item">
                        <div class="dot-indicator bg-gray-light"></div><span>Belum</span>
                    </div>
                </div>
            </div>

            <div class="split-card">
                <div class="split-card-header">
                    <h4 class="split-card-title">Daftar Penunggak Teratas</h4>
                    <button class="btn-link-viewall" onclick="window.location.href='tagihan_admin.php'">
                        <span>Lihat Semua</span>
                        <span class="material-symbols-outlined">arrow_forward</span>
                    </button>
                </div>

                <div class="debtors-list-wrapper">
                    <?php if (empty($list_debtors)): ?>
                        <p class="text-muted text-center" style="padding-top: 40px;">Hebat! Seluruh mahasiswa telah melunasi kas kelas.</p>
                    <?php else: ?>
                        <?php foreach ($list_debtors as $debtor): 
                            // Membuat inisial profil mahasiswa penunggak secara dinamis
                            $d_kata = explode(' ', $debtor['nama']);
                            $d_init = strtoupper(substr($d_kata[0], 0, 1));
                            if (isset($d_kata[1])) {
                                $d_init .= strtoupper(substr($d_kata[1], 0, 1));
                            }
                        ?>
                            <div class="debtor-list-item">
                                <div class="debtor-profile">
                                    <div class="debtor-initials"><?= $d_init ?></div>
                                    <div>
                                        <h5 class="debtor-name"><?= htmlspecialchars($debtor['nama']) ?></h5>
                                        <p class="debtor-weeks">Minggu <?= htmlspecialchars($debtor['minggu_tunggakan']) ?></p>
                                    </div>
                                </div>
                                <span class="debtor-amount text-red">Rp <?= number_format($debtor['total_tunggakan'], 0, ',', '.') ?></span>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </main>

</body>

</html>