<?php
require_once '../../../Backend/Admin/Logic_tagihan_admin.php';
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kasqeu - Admin - Tagihan</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="../../User/Css/user_dashboard.css">
    <link rel="stylesheet" href="../Css/dashboard_admin.css">
    <link rel="stylesheet" href="../Css/tagihan_admin.css">
</head>

<body>
    <header class="navbar">
        <div class="nav-container">
            <div class="nav-left">
                <span class="logo">Kasqeu</span>
                <nav class="nav-links">
                    <a href="dashboard_admin.php">Dashboard</a>
                    <a href="inputTransaksi_admin.php">Input Transaksi</a>
                    <a href="riwayat_admin.php">Riwayat</a>
                    <a href="tagihan_admin.php" class="active">Tagihan</a>
                    <a href="pengaturan_admin.php">Pengaturan</a>
                    <a href="role_admin.php">Role</a>
                </nav>
            </div>
            <div class="nav-right">
                <div class="user-info">
                    <span class="user-name"><?= htmlspecialchars($nama); ?></span>
                    <span class="user-role"><?= htmlspecialchars($role); ?></span>
                </div>
                <div class="avatar-box"><?= $inisial; ?></div>
                <button class="btn-logout" onclick="window.location.href='../../../config/logout.php';">
                    <span class="material-symbols-outlined">logout</span>
                    <span>Logout</span>
                </button>
            </div>
        </div>
    </header>

    <main class="main-content" id="main-content-area">

        <header class="content-header-split">
            <div class="header-title-box">
                <h2>Laporan Kelunasan</h2>
                <p>Monitoring pembayaran kas siswa mingguan.</p>
            </div>

            <!-- C. Komponen Dropdown Filter Minggu Dinamis -->
            <div class="week-dropdown-container" id="week-dropdown-container">
                <span class="dropdown-label">Pilih Minggu</span>
                <button class="btn-dropdown-trigger" id="week-dropdown-button">
                    <span id="selected-week-label">Minggu <?= $minggu_ke_label; ?> - <?= htmlspecialchars($bulan_label); ?></span>
                    <span class="material-symbols-outlined">expand_more</span>
                </button>

                <div class="dropdown-menu-list hidden" id="week-dropdown-menu">
                    <div class="dropdown-menu-wrapper">
                        <?php foreach ($all_periods as $p): ?>
                            <a href="?periode_id=<?= $p['id']; ?>" class="dropdown-item <?= $p['id'] == $selected_id ? 'active-item' : ''; ?>" style="text-decoration: none; display: block; text-align: left;">
                                Minggu <?= $p['minggu_ke']; ?> - <?= htmlspecialchars($p['bulan']); ?>
                            </a>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </header>

        <!-- D. Komponen Kartu KPI Ringkasan Progress Pelunasan -->
        <section class="report-kpi-grid">
            <div class="kpi-card kpi-card-double border-gold">
                <div class="progress-card-top">
                    <div class="progress-title-meta">
                        <h3>Progress Pelunasan</h3>
                        <p>Minggu ke-<?= $minggu_ke_label; ?> (<?= htmlspecialchars($bulan_label); ?>)</p>
                    </div>
                    <div class="progress-percentage-box">
                        <span class="percentage-value"><?= $percentage; ?>%</span>
                        <p class="percentage-tag">Siswa Telah Bayar</p>
                    </div>
                </div>

                <div class="progress-ratio-display">
                    <span class="ratio-current"><?= $total_lunas; ?></span>
                    <span class="ratio-divider">/ <?= $total_siswa; ?></span>
                </div>

                <div class="progress-track-bar">
                    <div class="progress-fill-bar" style="width: <?= $percentage; ?>%"></div>
                </div>

                <div class="progress-card-footer">
                    <div class="legend-item-dot">
                        <div class="dot bg-gold-main"></div>
                        <span><?= $total_lunas; ?> Lunas</span>
                    </div>
                    <div class="legend-item-dot">
                        <div class="dot bg-red-main"></div>
                        <span><?= $total_belum; ?> Belum Bayar</span>
                    </div>
                </div>
            </div>

            <!-- KPI Kartu Piutang Tertunda Bulanan -->
            <div class="kpi-card border-red">
                <div class="kpi-card-header-icon">
                    <div class="icon-wrapper text-red bg-red-light">
                        <span class="material-symbols-outlined icon-fill">payments</span>
                    </div>
                    <span class="card-tag">Per Hari Ini</span>
                </div>
                <div class="kpi-card-body-debt">
                    <p class="card-label">Piutang Tertunda</p>
                    <h4 class="card-value-debt text-red">Rp <?= number_format($piutang_tertunda, 0, ',', '.'); ?></h4>
                </div>
                <div class="kpi-card-footer-alert">
                    <span class="material-symbols-outlined">schedule</span>
                    <p>Tagih <?= $total_belum; ?> siswa yang belum lunas.</p>
                </div>
            </div>
        </section>

        <!-- E & F. Struktur Utama Tabel Data Siswa Belum Bayar -->
        <section class="table-section">
            <div class="table-header-panel">
                <div class="table-title-counter">
                    <h4>Daftar Siswa Belum Bayar (Minggu <?= $minggu_ke_label; ?>)</h4>
                </div>
                <!-- F. Fitur Cetak Generator PDF Dokumen Tagihan Fisik -->
                <a href="/Backend/Admin/cetak_kelunasan.php? $selected_id; ?>" class="btn-download-pdf" style="text-decoration: none; display: inline-flex; align-items: center; gap: 8px;">
                    <span class="material-symbols-outlined">download</span>
                    <span>Unduh PDF</span>
                </a>
            </div>

            <div class="table-responsive">
                <table class="data-table-admin">
                    <thead>
                        <tr>
                            <th>Nama Siswa</th>
                            <th style="width: 180px;">Status Pembayaran</th>
                            <th style="width: 220px;">Total Tunggakan</th>
                            <th class="text-center" style="width: 180px;">Aksi Penagihan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($siswa_belum_bayar)): ?>
                            <tr>
                                <td colspan="4" class="text-center text-muted" style="padding: 32px;">Luar biasa! Seluruh siswa telah melunasi kas pada minggu ini.</td>
                            </tr>
                        <?php else: ?>
                            <?php 
                            $no = 1;
                            foreach ($siswa_belum_bayar as $row): 
                                $isZebra = ($no % 2 === 0) ? 'row-zebra' : '';
                                
                                // Tautan Integrasi Otomatis Api WhatsApp Penagihan Instan
                                $pesan_wa = "Halo " . $row['nama_siswa'] . ", menginfokan kembali untuk tagihan uang kas kelas kita pada Minggu ke-" . $minggu_ke_label . " (" . $bulan_label . ") sebesar Rp " . number_format($nominal_kas, 0, ',', '.') . " berstatus BELUM LUNAS. Mohon segera diselesaikan ke bendahara kelas ya. Terima kasih!";
                                
                                // PENYESUAIAN: Membaca indeks $row['no_whatsapp'] sesuai hasil query baru[cite: 6]
                                $link_wa  = "https://api.whatsapp.com/send?phone=" . preg_replace('/[^0-9]/', '', $row['no_whatsapp']) . "&text=" . urlencode($pesan_wa);
                            ?>
                                <tr class="<?= $isZebra; ?>">
                                    <td class="font-semibold text-dark"><?= htmlspecialchars($row['nama_siswa']); ?></td>
                                    <td>
                                        <span class="badge-row badge-row-error">
                                            <span class="material-symbols-outlined">warning</span> Belum Bayar
                                        </span>
                                    </td>
                                    <td class="font-medium text-muted">Rp <?= number_format($nominal_kas, 0, ',', '.'); ?></td>
                                    <td class="text-center">
                                        <a href="<?= $link_wa; ?>" target="_blank" class="btn-whatsapp" style="text-decoration: none; display: inline-flex; justify-content: center; align-items: center; gap: 6px;">
                                            <svg class="whatsapp-svg" viewBox="0 0 448 512" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M380.9 97.1C339 55.1 283.2 32 223.9 32c-122.4 0-222 99.6-222 222 0 39.1 10.2 77.3 29.6 111L0 480l117.7-30.9c32.4 17.7 68.9 27 106.1 27h.1c122.3 0 224.1-99.6 224.1-222 0-59.3-25.2-115-67.1-157zm-157 341.6c-33.1 0-65.6-8.9-94-25.7l-6.7-4-69.8 18.3L72 359.2l-4.4-7c-18.5-29.4-28.2-63.3-28.2-98.2 0-101.7 82.8-184.5 184.6-184.5 49.3 0 95.6 19.2 130.4 54.1 34.8 34.9 56.2 81.2 56.1 130.5 0 101.8-84.9 184.6-186.6 184.6zm101.2-138.2c-5.5-2.8-32.8-16.2-37.9-18-5.1-1.9-8.8-2.8-12.5 2.8-3.7 5.6-14.3 18-17.6 21.8-3.2 3.7-6.5 4.2-12 1.4-5.5-2.8-23.2-8.5-44.2-27.1-16.4-14.6-27.4-32.7-30.6-38.2-3.2-5.6-.3-8.6 2.4-11.3 2.5-2.4 5.5-6.5 8.3-9.7 2.8-3.3 3.7-5.6 5.5-9.3 1.8-3.7 .9-6.9-.5-9.7-1.4-2.8-12.5-30.1-17.1-41.2-4.5-10.8-9.1-9.3-12.5-9.5-3.2-.2-6.9-.2-10.6-.2-3.7 0-9.7 1.4-14.8 6.9-5.1 5.6-19.4 19-19.4 46.3 0 27.3 19.9 53.7 22.6 57.4 2.8 3.7 39.1 59.7 94.8 83.8 13.2 5.8 23.5 9.2 31.6 11.8 13.3 4.2 25.4 3.6 35 2.2 10.7-1.5 32.8-13.4 37.4-26.4 4.6-13 4.6-24.1 3.2-26.4-1.3-2.5-5-3.9-10.5-6.6z"></path>
                                            </svg>
                                            <span>WhatsApp</span>
                                        </a>
                                    </td>
                                </tr>
                            <?php 
                            $no++;
                            endforeach; 
                            ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <div class="table-footer-panel">
                <span class="text-counter">Menampilkan <?= count($siswa_belum_bayar); ?> dari <?= $total_belum; ?> siswa belum bayar</span>
            </div>
        </section>
    </main>

    <script>
        (function () {
            const btn = document.getElementById('week-dropdown-button');
            const menu = document.getElementById('week-dropdown-menu');

            btn.addEventListener('click', (e) => {
                e.stopPropagation();
                menu.classList.toggle('hidden');
            });

            document.addEventListener('click', (e) => {
                if (!btn.contains(e.target) && !menu.contains(e.target)) {
                    menu.classList.add('hidden');
                }
            });
        })();
    </script>
</body>

</html>