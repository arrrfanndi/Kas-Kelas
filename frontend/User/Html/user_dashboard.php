<?php
require_once '../../../Backend/User/Logic_user_dashboard.php';
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kasqeu - Siswa - Dashboard</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../Css/user_dashboard.css">
</head>

<body>

    <header class="navbar">
        <div class="nav-container">
            <div class="nav-left">
                <span class="logo">Kasqeu</span>
                <nav class="nav-links">
                    <a href="user_dashboard.php" class="active">Dashboard</a>
                    <a href="user_riwayat.php">Riwayat</a>
                    <a href="user_tagihan.php">Tagihan</a>
                </nav>
            </div>
            <div class="nav-right">
                <div class="user-info">
                    <span class="user-name"><?= htmlspecialchars($nama) ?></span>
                    <span class="user-role">Siswa</span>
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
            <p>Selamat datang kembali, <strong><?= $nama_panggilan ?></strong>. Berikut adalah ringkasan keuangan kas kamu.</p>
        </section>

        <?php if ($my_tagihan > 0): ?>
            <div class="alert-banner error">
                <span class="material-symbols-outlined icon-fill">warning</span>
                <p>Kamu memiliki tunggakan kas sebesar <strong>Rp <?= number_format($my_tagihan, 0, ',', '.') ?></strong>. Segera lakukan pembayaran tunai ke bendahara kelas.</p>
            </div>
        <?php endif; ?>

        <div class="kpi-grid">
            <div class="kpi-card">
                <div class="kpi-header">
                    <span class="kpi-title">Total Kas Kelas</span>
                    <div class="kpi-icon bg-blue">
                        <span class="material-symbols-outlined">account_balance_wallet</span>
                    </div>
                </div>
                <h2 class="kpi-value text-blue">Rp <?= number_format($saldo_kelas, 0, ',', '.') ?></h2>
                <div class="kpi-footer">
                    <span class="material-symbols-outlined text-green" style="color: #EDD200;">trending_up</span>
                    <span>Saldo bersih kelas saat ini</span>
                </div>
            </div>

            <div class="kpi-card">
                <div class="kpi-header">
                    <span class="kpi-title">Total Bayar Saya</span>
                    <div class="kpi-icon bg-green">
                        <span class="material-symbols-outlined">payments</span>
                    </div>
                </div>
                <h2 class="kpi-value text-green">Rp <?= number_format($my_lunas, 0, ',', '.') ?></h2>
                <div class="kpi-footer">
                    <span class="material-symbols-outlined text-green">verified</span>
                    <span>Total kontribusi yang sudah lunas</span>
                </div>
            </div>

            <div class="kpi-card <?= ($my_tagihan > 0) ? 'border-left-red' : '' ?>">
                <div class="kpi-header">
                    <span class="kpi-title">Sisa Tagihan Saya</span>
                    <div class="kpi-icon bg-red">
                        <span class="material-symbols-outlined">pending_actions</span>
                    </div>
                </div>
                <h2 class="kpi-value text-red">Rp <?= number_format($my_tagihan, 0, ',', '.') ?></h2>
                <div class="kpi-footer">
                    <span class="material-symbols-outlined text-neutral" style="color: #FF5656;">info</span>
                    <span>Tunggakan kamu hingga minggu ini</span>
                </div>
            </div>
        </div>

        <section class="table-section">
            <div class="table-header">
                <h2>Catatan Setoran Kamu</h2>
                <span class="table-badge"><?= count($list_setoran) ?> Transaksi Terakhir</span>
            </div>

            <div class="table-responsive">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th style="width: 50px;">No</th>
                            <th>Minggu Ke</th>
                            <th>Nominal</th>
                            <th>Keterangan</th>
                            <th>Tanggal Bayar</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($list_setoran)): ?>
                            <tr>
                                <td colspan="6" class="text-center" style="padding: 24px; color: #9ca3af;">Belum ada riwayat tagihan kas untuk akun Anda.</td>
                            </tr>
                        <?php else: ?>
                            <?php 
                            $no = 1;
                            foreach ($list_setoran as $row): 
                                $tgl_format = ($row['tanggal_bayar']) ? date('d M Y', strtotime($row['tanggal_bayar'])) : '-';
                                $badge_class = ($row['status'] == 'lunas') ? 'badge-success' : 'badge-error';
                            ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><strong>Minggu <?= $row['minggu_ke'] ?></strong></td>
                                    <td>Rp <?= number_format($row['nominal'], 0, ',', '.') ?></td>
                                    <td style="color: #6b7280;">Iuran Mingguan</td>
                                    <td><?= $tgl_format ?></td>
                                    <td>
                                        <span class="badge <?= $badge_class ?>">
                                            <?= ucfirst($row['status']) ?>
                                        </span>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <div class="table-footer">
                <button class="btn-load-more" onclick="window.location.href='user_riwayat.php'">
                    <span>Tampilkan Semua Riwayat</span>
                    <span class="material-symbols-outlined">expand_more</span>
                </button>
            </div>
        </section>

        <footer class="main-footer">
            <p>© 2026 Kasqeu. Kelompok 14.</p>
        </footer>
    </main>

</body>
</html>