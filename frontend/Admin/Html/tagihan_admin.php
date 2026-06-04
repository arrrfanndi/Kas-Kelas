<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kasqeu - Admin - Tagihan</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap"
        rel="stylesheet">

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
                    <a href="" class="active">Tagihan</a>
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
    <main class="main-content" id="main-content-area">

        <header class="content-header-split">
            <div class="header-title-box">
                <h2>Laporan Kelunasan</h2>
                <p>Monitoring pembayaran kas siswa mingguan.</p>
            </div>

            <div class="week-dropdown-container" id="week-dropdown-container">
                <span class="dropdown-label">Pilih Minggu</span>
                <button class="btn-dropdown-trigger" id="week-dropdown-button">
                    <span id="selected-week-label">Minggu 3 - September</span>
                    <span class="material-symbols-outlined">expand_more</span>
                </button>

                <div class="dropdown-menu-list hidden" id="week-dropdown-menu">
                    <div class="dropdown-menu-wrapper">
                        <button class="dropdown-item" type="button">Minggu 1 - September</button>
                        <button class="dropdown-item" type="button">Minggu 2 - September</button>
                        <button class="dropdown-item active-item" type="button">Minggu 3 - September</button>
                        <button class="dropdown-item" type="button">Minggu 4 - September</button>
                        <button class="dropdown-item" type="button">Semua Minggu</button>
                    </div>
                </div>
            </div>
        </header>

        <section class="report-kpi-grid">

            <div class="kpi-card kpi-card-double border-gold">
                <div class="progress-card-top">
                    <div class="progress-title-meta">
                        <h3>Progress Pelunasan</h3>
                        <p>Minggu ke-3 (September 2023)</p>
                    </div>
                    <div class="progress-percentage-box">
                        <span class="percentage-value">68%</span>
                        <p class="percentage-tag">Siswa Telah Bayar</p>
                    </div>
                </div>

                <div class="progress-ratio-display">
                    <span class="ratio-current">24</span>
                    <span class="ratio-divider">/ 35</span>
                </div>

                <div class="progress-track-bar">
                    <div class="progress-fill-bar" style="width: 68%"></div>
                </div>

                <div class="progress-card-footer">
                    <div class="legend-item-dot">
                        <div class="dot bg-gold-main"></div>
                        <span>24 Lunas</span>
                    </div>
                    <div class="legend-item-dot">
                        <div class="dot bg-red-main"></div>
                        <span>11 Belum Bayar</span>
                    </div>
                </div>
            </div>

            <div class="kpi-card border-red">
                <div class="kpi-card-header-icon">
                    <div class="icon-wrapper text-red bg-red-light">
                        <span class="material-symbols-outlined icon-fill">payments</span>
                    </div>
                    <span class="card-tag">Per Hari Ini</span>
                </div>
                <div class="kpi-card-body-debt">
                    <p class="card-label">Piutang Tertunda</p>
                    <h4 class="card-value-debt text-red">Rp 550.000</h4>
                </div>
                <div class="kpi-card-footer-alert">
                    <span class="material-symbols-outlined">schedule</span>
                    <p>Tagih 11 siswa yang belum lunas.</p>
                </div>
            </div>
        </section>

        <section class="table-section">
            <div class="table-header-panel">
                <div class="table-title-counter">
                    <h4>Daftar Siswa Belum Bayar (Minggu 3)</h4>
                </div>
                <button class="btn-download-pdf">
                    <span class="material-symbols-outlined">download</span>
                    <span>Unduh PDF</span>
                </button>
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
                        <tr>
                            <td class="font-semibold text-dark">Aditya Pratama</td>
                            <td>
                                <span class="badge-row badge-row-error">
                                    <span class="material-symbols-outlined">warning</span> Belum Bayar
                                </span>
                            </td>
                            <td class="font-medium text-muted">Rp 5.000</td>
                            <td class="text-center">
                                <button class="btn-whatsapp">
                                    <svg class="whatsapp-svg" viewBox="0 0 448 512" xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M380.9 97.1C339 55.1 283.2 32 223.9 32c-122.4 0-222 99.6-222 222 0 39.1 10.2 77.3 29.6 111L0 480l117.7-30.9c32.4 17.7 68.9 27 106.1 27h.1c122.3 0 224.1-99.6 224.1-222 0-59.3-25.2-115-67.1-157zm-157 341.6c-33.1 0-65.6-8.9-94-25.7l-6.7-4-69.8 18.3L72 359.2l-4.4-7c-18.5-29.4-28.2-63.3-28.2-98.2 0-101.7 82.8-184.5 184.6-184.5 49.3 0 95.6 19.2 130.4 54.1 34.8 34.9 56.2 81.2 56.1 130.5 0 101.8-84.9 184.6-186.6 184.6zm101.2-138.2c-5.5-2.8-32.8-16.2-37.9-18-5.1-1.9-8.8-2.8-12.5 2.8-3.7 5.6-14.3 18-17.6 21.8-3.2 3.7-6.5 4.2-12 1.4-5.5-2.8-23.2-8.5-44.2-27.1-16.4-14.6-27.4-32.7-30.6-38.2-3.2-5.6-.3-8.6 2.4-11.3 2.5-2.4 5.5-6.5 8.3-9.7 2.8-3.3 3.7-5.6 5.5-9.3 1.8-3.7 .9-6.9-.5-9.7-1.4-2.8-12.5-30.1-17.1-41.2-4.5-10.8-9.1-9.3-12.5-9.5-3.2-.2-6.9-.2-10.6-.2-3.7 0-9.7 1.4-14.8 6.9-5.1 5.6-19.4 19-19.4 46.3 0 27.3 19.9 53.7 22.6 57.4 2.8 3.7 39.1 59.7 94.8 83.8 13.2 5.8 23.5 9.2 31.6 11.8 13.3 4.2 25.4 3.6 35 2.2 10.7-1.5 32.8-13.4 37.4-26.4 4.6-13 4.6-24.1 3.2-26.4-1.3-2.5-5-3.9-10.5-6.6z">
                                        </path>
                                    </svg>
                                    <span>WhatsApp</span>
                                </button>
                            </td>
                        </tr>
                        <tr class="row-zebra">
                            <td class="font-semibold text-dark">Budi Santoso</td>
                            <td>
                                <span class="badge-row badge-row-error">
                                    <span class="material-symbols-outlined">warning</span> Belum Bayar
                                </span>
                            </td>
                            <td class="font-medium text-muted">Rp 5.000</td>
                            <td class="text-center">
                                <button class="btn-whatsapp">
                                    <svg class="whatsapp-svg" viewBox="0 0 448 512" xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M380.9 97.1C339 55.1 283.2 32 223.9 32c-122.4 0-222 99.6-222 222 0 39.1 10.2 77.3 29.6 111L0 480l117.7-30.9c32.4 17.7 68.9 27 106.1 27h.1c122.3 0 224.1-99.6 224.1-222 0-59.3-25.2-115-67.1-157zm-157 341.6c-33.1 0-65.6-8.9-94-25.7l-6.7-4-69.8 18.3L72 359.2l-4.4-7c-18.5-29.4-28.2-63.3-28.2-98.2 0-101.7 82.8-184.5 184.6-184.5 49.3 0 95.6 19.2 130.4 54.1 34.8 34.9 56.2 81.2 56.1 130.5 0 101.8-84.9 184.6-186.6 184.6zm101.2-138.2c-5.5-2.8-32.8-16.2-37.9-18-5.1-1.9-8.8-2.8-12.5 2.8-3.7 5.6-14.3 18-17.6 21.8-3.2 3.7-6.5 4.2-12 1.4-5.5-2.8-23.2-8.5-44.2-27.1-16.4-14.6-27.4-32.7-30.6-38.2-3.2-5.6-.3-8.6 2.4-11.3 2.5-2.4 5.5-6.5 8.3-9.7 2.8-3.3 3.7-5.6 5.5-9.3 1.8-3.7 .9-6.9-.5-9.7-1.4-2.8-12.5-30.1-17.1-41.2-4.5-10.8-9.1-9.3-12.5-9.5-3.2-.2-6.9-.2-10.6-.2-3.7 0-9.7 1.4-14.8 6.9-5.1 5.6-19.4 19-19.4 46.3 0 27.3 19.9 53.7 22.6 57.4 2.8 3.7 39.1 59.7 94.8 83.8 13.2 5.8 23.5 9.2 31.6 11.8 13.3 4.2 25.4 3.6 35 2.2 10.7-1.5 32.8-13.4 37.4-26.4 4.6-13 4.6-24.1 3.2-26.4-1.3-2.5-5-3.9-10.5-6.6z">
                                        </path>
                                    </svg>
                                    <span>WhatsApp</span>
                                </button>
                            </td>
                        </tr>
                        <tr>
                            <td class="font-semibold text-dark">Citra Lestari</td>
                            <td>
                                <span class="badge-row badge-row-error">
                                    <span class="material-symbols-outlined">warning</span> Belum Bayar
                                </span>
                            </td>
                            <td class="font-medium text-muted">Rp 5.000 </td>
                            <td class="text-center">
                                <button class="btn-whatsapp">
                                    <svg class="whatsapp-svg" viewBox="0 0 448 512" xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M380.9 97.1C339 55.1 283.2 32 223.9 32c-122.4 0-222 99.6-222 222 0 39.1 10.2 77.3 29.6 111L0 480l117.7-30.9c32.4 17.7 68.9 27 106.1 27h.1c122.3 0 224.1-99.6 224.1-222 0-59.3-25.2-115-67.1-157zm-157 341.6c-33.1 0-65.6-8.9-94-25.7l-6.7-4-69.8 18.3L72 359.2l-4.4-7c-18.5-29.4-28.2-63.3-28.2-98.2 0-101.7 82.8-184.5 184.6-184.5 49.3 0 95.6 19.2 130.4 54.1 34.8 34.9 56.2 81.2 56.1 130.5 0 101.8-84.9 184.6-186.6 184.6zm101.2-138.2c-5.5-2.8-32.8-16.2-37.9-18-5.1-1.9-8.8-2.8-12.5 2.8-3.7 5.6-14.3 18-17.6 21.8-3.2 3.7-6.5 4.2-12 1.4-5.5-2.8-23.2-8.5-44.2-27.1-16.4-14.6-27.4-32.7-30.6-38.2-3.2-5.6-.3-8.6 2.4-11.3 2.5-2.4 5.5-6.5 8.3-9.7 2.8-3.3 3.7-5.6 5.5-9.3 1.8-3.7 .9-6.9-.5-9.7-1.4-2.8-12.5-30.1-17.1-41.2-4.5-10.8-9.1-9.3-12.5-9.5-3.2-.2-6.9-.2-10.6-.2-3.7 0-9.7 1.4-14.8 6.9-5.1 5.6-19.4 19-19.4 46.3 0 27.3 19.9 53.7 22.6 57.4 2.8 3.7 39.1 59.7 94.8 83.8 13.2 5.8 23.5 9.2 31.6 11.8 13.3 4.2 25.4 3.6 35 2.2 10.7-1.5 32.8-13.4 37.4-26.4 4.6-13 4.6-24.1 3.2-26.4-1.3-2.5-5-3.9-10.5-6.6z">
                                        </path>
                                    </svg>
                                    <span>WhatsApp</span>
                                </button>
                            </td>
                        </tr>
                        <tr class="row-zebra">
                            <td class="font-semibold text-dark">Dian Wijaya</td>
                            <td>
                                <span class="badge-row badge-row-error">
                                    <span class="material-symbols-outlined">warning</span> Belum Bayar
                                </span>
                            </td>
                            <td class="font-medium text-muted">Rp 5.000</td>
                            <td class="text-center">
                                <button class="btn-whatsapp">
                                    <svg class="whatsapp-svg" viewBox="0 0 448 512" xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M380.9 97.1C339 55.1 283.2 32 223.9 32c-122.4 0-222 99.6-222 222 0 39.1 10.2 77.3 29.6 111L0 480l117.7-30.9c32.4 17.7 68.9 27 106.1 27h.1c122.3 0 224.1-99.6 224.1-222 0-59.3-25.2-115-67.1-157zm-157 341.6c-33.1 0-65.6-8.9-94-25.7l-6.7-4-69.8 18.3L72 359.2l-4.4-7c-18.5-29.4-28.2-63.3-28.2-98.2 0-101.7 82.8-184.5 184.6-184.5 49.3 0 95.6 19.2 130.4 54.1 34.8 34.9 56.2 81.2 56.1 130.5 0 101.8-84.9 184.6-186.6 184.6zm101.2-138.2c-5.5-2.8-32.8-16.2-37.9-18-5.1-1.9-8.8-2.8-12.5 2.8-3.7 5.6-14.3 18-17.6 21.8-3.2 3.7-6.5 4.2-12 1.4-5.5-2.8-23.2-8.5-44.2-27.1-16.4-14.6-27.4-32.7-30.6-38.2-3.2-5.6-.3-8.6 2.4-11.3 2.5-2.4 5.5-6.5 8.3-9.7 2.8-3.3 3.7-5.6 5.5-9.3 1.8-3.7 .9-6.9-.5-9.7-1.4-2.8-12.5-30.1-17.1-41.2-4.5-10.8-9.1-9.3-12.5-9.5-3.2-.2-6.9-.2-10.6-.2-3.7 0-9.7 1.4-14.8 6.9-5.1 5.6-19.4 19-19.4 46.3 0 27.3 19.9 53.7 22.6 57.4 2.8 3.7 39.1 59.7 94.8 83.8 13.2 5.8 23.5 9.2 31.6 11.8 13.3 4.2 25.4 3.6 35 2.2 10.7-1.5 32.8-13.4 37.4-26.4 4.6-13 4.6-24.1 3.2-26.4-1.3-2.5-5-3.9-10.5-6.6z">
                                        </path>
                                    </svg>
                                    <span>WhatsApp</span>
                                </button>
                            </td>
                        </tr>
                        <tr>
                            <td class="font-semibold text-dark">Eko Prasetyo</td>
                            <td>
                                <span class="badge-row badge-row-error">
                                    <span class="material-symbols-outlined">warning</span> Belum Bayar
                                </span>
                            </td>
                            <td class="font-medium text-muted">Rp 5.000</td>
                            <td class="text-center">
                                <button class="btn-whatsapp">
                                    <svg class="whatsapp-svg" viewBox="0 0 448 512" xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M380.9 97.1C339 55.1 283.2 32 223.9 32c-122.4 0-222 99.6-222 222 0 39.1 10.2 77.3 29.6 111L0 480l117.7-30.9c32.4 17.7 68.9 27 106.1 27h.1c122.3 0 224.1-99.6 224.1-222 0-59.3-25.2-115-67.1-157zm-157 341.6c-33.1 0-65.6-8.9-94-25.7l-6.7-4-69.8 18.3L72 359.2l-4.4-7c-18.5-29.4-28.2-63.3-28.2-98.2 0-101.7 82.8-184.5 184.6-184.5 49.3 0 95.6 19.2 130.4 54.1 34.8 34.9 56.2 81.2 56.1 130.5 0 101.8-84.9 184.6-186.6 184.6zm101.2-138.2c-5.5-2.8-32.8-16.2-37.9-18-5.1-1.9-8.8-2.8-12.5 2.8-3.7 5.6-14.3 18-17.6 21.8-3.2 3.7-6.5 4.2-12 1.4-5.5-2.8-23.2-8.5-44.2-27.1-16.4-14.6-27.4-32.7-30.6-38.2-3.2-5.6-.3-8.6 2.4-11.3 2.5-2.4 5.5-6.5 8.3-9.7 2.8-3.3 3.7-5.6 5.5-9.3 1.8-3.7 .9-6.9-.5-9.7-1.4-2.8-12.5-30.1-17.1-41.2-4.5-10.8-9.1-9.3-12.5-9.5-3.2-.2-6.9-.2-10.6-.2-3.7 0-9.7 1.4-14.8 6.9-5.1 5.6-19.4 19-19.4 46.3 0 27.3 19.9 53.7 22.6 57.4 2.8 3.7 39.1 59.7 94.8 83.8 13.2 5.8 23.5 9.2 31.6 11.8 13.3 4.2 25.4 3.6 35 2.2 10.7-1.5 32.8-13.4 37.4-26.4 4.6-13 4.6-24.1 3.2-26.4-1.3-2.5-5-3.9-10.5-6.6z">
                                        </path>
                                    </svg>
                                    <span>WhatsApp</span>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="table-footer-panel">
                <span class="text-counter">Menampilkan 5 dari 11 siswa belum bayar</span>
                <div class="pagination-wrapper">
                    <button class="btn-page-nav page-number">1</button>
                    <button class="btn-page-nav page-number active-page">2</button>
                    <button class="btn-page-nav page-number">3</button>
                </div>
            </div>
        </section>
    </main>

    <script>
        (function () {
            const btn = document.getElementById('week-dropdown-button');
            const menu = document.getElementById('week-dropdown-menu');
            const label = document.getElementById('selected-week-label');
            const items = menu.querySelectorAll('.dropdown-item');
            const mainArea = document.getElementById('main-content-area');

            btn.addEventListener('click', (e) => {
                e.stopPropagation();
                menu.classList.toggle('hidden');
            });

            items.forEach(item => {
                item.addEventListener('click', () => {
                    label.textContent = item.textContent;
                    menu.classList.add('hidden');

                    items.forEach(i => i.classList.remove('active-item'));
                    item.classList.add('active-item');

                    // Efek fake-loading saat ganti minggu
                    mainArea.style.opacity = '0.5';
                    setTimeout(() => {
                        mainArea.style.opacity = '1';
                        mainArea.style.transition = 'opacity 0.3s ease-in-out';
                    }, 300);
                });
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