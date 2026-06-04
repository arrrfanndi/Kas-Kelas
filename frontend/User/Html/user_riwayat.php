<?php
require_once '../../../Backend/User/Logic_user_riwayat.php'
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kasqeu - Siswa - Riwayat</title>

    <link href="https://fonts.googleapis.com/css2?family=Google+Sans+Code:ital,wght,MONO@0,300..800,1;1,300..800,1&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="../Css/user_riwayat.css">
     <link rel="stylesheet" href="../Css/user_dashboard.css">
</head>

<body>

    <header class="navbar">
        <div class="nav-container">
            <div class="nav-left">
                <span class="logo">Kasqeu</span>
                <nav class="nav-links">
                    <a href="user_dashboard.php">Dashboard</a>
                    <a href="" class="active">Riwayat</a>
                    <a href="user_tagihan.php">Tagihan</a>
                </nav>
            </div>
            <div class="nav-right">
                <div class="user-info">
                    <span class="user-name"><?= htmlspecialchars($nama) ?></span>
                    <span class="user-role">Siswa</span>
                </div>
                <div class="avatar-box"><?= $inisial ?></div>
                <button class="btn-logout" onclick="window.location.href='/Config/logout.php'">
                    <span class="material-symbols-outlined">logout</span>
                    <span>Logout</span>
                </button>
            </div>
        </div>
    </header>

    <main class="main-content">

        <header class="content-header">
            <div class="header-title">
                <h1>Riwayat Keuangan Kelas</h1>
                <p>Transparansi total untuk setiap rupiah yang dikelola. Pantau pemasukan dan pengeluaran kelas dengan detail dan akurat.</p>
            </div>
            <div class="header-action">
                <a href="/Backend/User/cetak_riwayat.php?filter=<?= urlencode($filter) ?>&search=<?= urlencode($search) ?>" class="btn-download" target="_blank" style="text-decoration: none; display: inline-flex; align-items: center; gap: 8px;">
                    <span class="material-symbols-outlined">download</span>
                    <span>Unduh PDF</span>
                </a>
            </div>
        </header>

        <div class="summary-grid">
            <div class="summary-card">
                <div class="card-inner">
                    <div class="card-icon bg-yellow">
                        <span class="material-symbols-outlined">account_balance_wallet</span>
                    </div>
                    <div>
                        <p class="card-label">Total Saldo Kelas</p>
                        <h3>Rp <?= number_format($saldo_kelas, 0, ',', '.') ?></h3>
                    </div>
                </div>
            </div>
            <div class="summary-card">
                <div class="card-inner">
                    <div class="card-icon bg-teal">
                        <span class="material-symbols-outlined">trending_up</span>
                    </div>
                    <div>
                        <p class="card-label">Total Setoran Kamu</p>
                        <h3>Rp <?= number_format($my_total_setoran, 0, ',', '.') ?></h3>
                    </div>
                </div>
            </div>
            <div class="summary-card">
                <div class="card-inner">
                    <div class="card-icon bg-red">
                        <span class="material-symbols-outlined">trending_down</span>
                    </div>
                    <div>
                        <p class="card-label">Pengeluaran Bulan Ini</p>
                        <h3>Rp <?= number_format($pengeluaran_bulan_ini, 0, ',', '.') ?></h3>
                    </div>
                </div>
            </div>
        </div>

        <div class="filter-card">
            <div class="filter-wrapper">
                <span class="filter-label">Filter Tampilan:</span>
                <div class="filter-buttons">
                    <a href="?filter=semua&search=<?= urlencode($search) ?>" class="btn-filter <?= $filter === 'semua' ? 'active' : '' ?>" style="text-decoration: none; text-align: center;">Semua Transaksi</a>
                    <a href="?filter=setoran_saya&search=<?= urlencode($search) ?>" class="btn-filter <?= $filter === 'setoran_saya' ? 'active' : '' ?>" style="text-decoration: none; text-align: center;">Setoran Saya</a>
                    <a href="?filter=pengeluaran&search=<?= urlencode($search) ?>" class="btn-filter <?= $filter === 'pengeluaran' ? 'active' : '' ?>" style="text-decoration: none; text-align: center;">Pengeluaran Kelas</a>
                </div>
                <form method="GET" action="" class="search-form">
                    <input type="hidden" name="filter" value="<?= htmlspecialchars($filter) ?>">
                    <span class="material-symbols-outlined search-icon">search</span>
                    <input class="search-input" name="search" value="<?= htmlspecialchars($search) ?>" placeholder="Cari transaksi..." type="text">
                </form>
            </div>
        </div>

        <div class="table-card">
            <div class="table-card-header">
                <h2>Data Transaksi Terbaru</h2>
                <span class="table-counter">Menampilkan <?= count($list_transaksi) ?> dari <?= $total_records ?> entri ditemukan</span>
            </div>
            <div class="table-responsive">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th style="width: 70px;">No</th>
                            <th>Tanggal</th>
                            <th>Deskripsi/Keterangan</th>
                            <th>Jenis</th>
                            <th class="text-right">Nominal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($list_transaksi)): ?>
                            <tr>
                                <td colspan="5" class="text-center" style="padding: 32px; color: #9ca3af;">Tidak ditemukan riwayat transaksi yang cocok.</td>
                            </tr>
                        <?php else: ?>
                            <?php
                            $no = $offset + 1; // Penomoran tabel menyesuaikan halaman saat ini
                            foreach ($list_transaksi as $row):
                                $tgl_format = ($row['tanggal']) ? date('d M Y', strtotime($row['tanggal'])) : '-';
                                $is_masuk = ($row['jenis'] === 'masuk');
                            ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= $tgl_format ?></td>
                                    <td class="font-medium"><?= htmlspecialchars($row['keterangan']) ?></td>
                                    <td>
                                        <?php if ($is_masuk): ?>
                                            <span class="badge-row badge-row-success">
                                                <span class="material-symbols-outlined">arrow_upward</span> Masuk
                                            </span>
                                        <?php else: ?>
                                            <span class="badge-row badge-row-error">
                                                <span class="material-symbols-outlined">arrow_downward</span> Keluar
                                            </span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-right font-semibold <?= $is_masuk ? 'text-success' : 'text-error' ?>">
                                        Rp <?= number_format($row['nominal'], 0, ',', '.') ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <div class="table-card-footer">
                <?php if ($page > 1): ?>
                    <a href="?filter=<?= urlencode($filter) ?>&search=<?= urlencode($search) ?>&page=<?= $page - 1 ?>" class="btn-nav" style="text-decoration: none; display: inline-flex; align-items: center;">
                        <span class="material-symbols-outlined">chevron_left</span>Sebelumnya
                    </a>
                <?php else: ?>
                    <button class="btn-nav" disabled>
                        <span class="material-symbols-outlined">chevron_left</span>Sebelumnya
                    </button>
                <?php endif; ?>

                <div class="pagination-numbers">
                    <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                        <a href="?filter=<?= urlencode($filter) ?>&search=<?= urlencode($search) ?>&page=<?= $i ?>" class="page-num <?= $page === $i ? 'active' : '' ?>" style="text-decoration: none; text-align: center;">
                            <?= $i ?>
                        </a>
                    <?php endfor; ?>
                </div>

                <?php if ($page < $total_pages): ?>
                    <a href="?filter=<?= urlencode($filter) ?>&search=<?= urlencode($search) ?>&page=<?= $page + 1 ?>" class="btn-nav" style="text-decoration: none; display: inline-flex; align-items: center;">
                        Selanjutnya<span class="material-symbols-outlined">chevron_right</span>
                    </a>
                <?php else: ?>
                    <button class="btn-nav" disabled>
                        Selanjutnya<span class="material-symbols-outlined">chevron_right</span>
                    </button>
                <?php endif; ?>
            </div>
        </div>

        <footer class="main-footer">
            <p>© 2026 Kasqeu. Kelompok 14.</p>
        </footer>
    </main>

</body>

</html>