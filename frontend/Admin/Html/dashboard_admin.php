<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kasqeu - Admin - Dashboard</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">

    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap"
        rel="stylesheet">

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
                    <span class="user-name">Ruan Mei</span>
                    <span class="user-role">Admin</span>
                </div>
                <div class="avatar-box"></div>
                <button class="btn-logout">
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
                <h3 class="card-value">Rp 1.500.000</h3>

            </div>

            <div class="kpi-card border-green">
                <div class="kpi-card-header">
                    <div class="icon-wrapper text-green bg-green-light">
                        <span class="material-symbols-outlined icon-fill">payments</span>
                    </div>
                    <span class="card-tag">Akumulatif</span>
                </div>
                <p class="card-label">Total Pemasukan Keseluruhan</p>
                <h3 class="card-value">Rp 2.000.000</h3>

            </div>

            <div class="kpi-card border-red">
                <div class="kpi-card-header">
                    <div class="icon-wrapper text-red bg-red-light">
                        <span class="material-symbols-outlined icon-fill">receipt_long</span>
                    </div>
                    <span class="card-tag">Pengeluaran</span>
                </div>
                <p class="card-label">Total Pengeluaran Keseluruhan</p>
                <h3 class="card-value text-red">Rp 500.000</h3>
            </div>
        </div>

        <section class="table-section">
            <div class="table-header-panel">
                <h4>Ringkasan Aktivitas Terakhir</h4>
                <button class="btn-print-report">Cetak Laporan</button>
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
                        <tr>
                            <td class="text-muted">01</td>
                            <td class="text-muted">12 Okt 2023</td>
                            <td>
                                <div class="row-title">Andi Saputra</div>
                                <div class="row-subtitle">Iuran Wajib Minggu 2</div>
                            </td>
                            <td>
                                <span class="badge-row badge-row-success">
                                    <span class="material-symbols-outlined">arrow_downward</span> Masuk
                                </span>
                            </td>
                            <td class="text-right-align text-green font-bold">Rp 20.000</td>
                        </tr>
                        <tr>
                            <td class="text-muted">02</td>
                            <td class="text-muted">12 Okt 2023</td>
                            <td>
                                <div class="row-title">Toko Fotocopy "Jaya"</div>
                                <div class="row-subtitle">Cetak Modul Kalkulus</div>
                            </td>
                            <td>
                                <span class="badge-row badge-row-error">
                                    <span class="material-symbols-outlined">arrow_upward</span> Keluar
                                </span>
                            </td>
                            <td class="text-right-align text-red font-bold">Rp 150.000</td>
                        </tr>
                        <tr>
                            <td class="text-muted">03</td>
                            <td class="text-muted">11 Okt 2023</td>
                            <td>
                                <div class="row-title">Siti Aminah</div>
                                <div class="row-subtitle">Pelunasan Denda</div>
                            </td>
                            <td>
                                <span class="badge-row badge-row-success">
                                    <span class="material-symbols-outlined">arrow_downward</span> Masuk
                                </span>
                            </td>
                            <td class="text-right-align text-green font-bold">Rp 5.000</td>
                        </tr>
                        <tr>
                            <td class="text-muted">04</td>
                            <td class="text-muted">10 Okt 2023</td>
                            <td>
                                <div class="row-title">Donasi Sosial</div>
                                <div class="row-subtitle">Panti Asuhan</div>
                            </td>
                            <td>
                                <span class="badge-row badge-row-error">
                                    <span class="material-symbols-outlined">arrow_upward</span> Keluar
                                </span>
                            </td>
                            <td class="text-right-align text-red font-bold">Rp 200.000</td>
                        </tr>
                        <tr>
                            <td class="text-muted">05</td>
                            <td class="text-muted">10 Okt 2023</td>
                            <td>
                                <div class="row-title">Budi Darmawan</div>
                                <div class="row-subtitle">Iuran Wajib Minggu 2</div>
                            </td>
                            <td>
                                <span class="badge-row badge-row-success">
                                    <span class="material-symbols-outlined">arrow_downward</span> Masuk
                                </span>
                            </td>
                            <td class="text-right-align text-green font-bold">Rp 20.000</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="table-footer-panel">
                <span class="text-counter">Menampilkan 5 dari 124 transaksi</span>
                <div class="pagination-arrows">
                    <button class="btn-arrow-nav disabled">
                        <span class="material-symbols-outlined">chevron_left</span>
                    </button>
                    <button class="btn-arrow-nav">
                        <span class="material-symbols-outlined">chevron_right</span>
                    </button>
                </div>
            </div>
        </section>

        <div class="bottom-split-grid">
            <div class="split-card card-alignment-center">
                <h4 class="split-card-title">Status Kelunasan</h4>

                <div class="circular-progress">
                    <svg class="progress-svg">
                        <circle class="circle-track" cx="60" cy="60" r="50"></circle>
                        <circle class="circle-bar" cx="60" cy="60" r="50" stroke-dasharray="314.159"
                            stroke-dashoffset="62.831"></circle>
                    </svg>
                    <div class="progress-inner-text">
                        <span class="percentage">80%</span>
                        <span class="sub-tag">Selesai</span>
                    </div>
                </div>

                <p class="progress-desc-text">
                    <strong>32 dari 40</strong> mahasiswa telah melunasi iuran wajib minggu ini.
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
                    <button class="btn-link-viewall">
                        <span>Lihat Semua</span>
                        <span class="material-symbols-outlined">arrow_forward</span>
                    </button>
                </div>

                <div class="debtors-list-wrapper">
                    <div class="debtor-list-item">
                        <div class="debtor-profile">
                            <div class="debtor-initials">AP</div>
                            <div>
                                <h5 class="debtor-name">Aditya Pratama</h5>
                                <p class="debtor-weeks">Minggu 3, 4</p>
                            </div>
                        </div>
                        <span class="debtor-amount text-red">Rp 50.000</span>
                    </div>
                    <div class="debtor-list-item">
                        <div class="debtor-profile">
                            <div class="debtor-initials">BS</div>
                            <div>
                                <h5 class="debtor-name">Budi Santoso</h5>
                                <p class="debtor-weeks">Minggu 4</p>
                            </div>
                        </div>
                        <span class="debtor-amount text-red">Rp 50.000</span>
                    </div>
                    <div class="debtor-list-item">
                        <div class="debtor-profile">
                            <div class="debtor-initials">CL</div>
                            <div>
                                <h5 class="debtor-name">Citra Lestari</h5>
                                <p class="debtor-weeks">Minggu 2, 3, 4</p>
                            </div>
                        </div>
                        <span class="debtor-amount text-red">Rp 100.000</span>
                    </div>
                </div>
            </div>
        </div>
    </main>

</body>

</html>