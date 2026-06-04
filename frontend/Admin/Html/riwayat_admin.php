<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kasqeu - Admin - Riwayat</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap"
        rel="stylesheet">

    <link rel="stylesheet" href="../../User/Css/user_dashboard.css">
    <link rel="stylesheet" href="../Css/dashboard_admin.css">
    <link rel="stylesheet" href="../Css/riwayat_admin.css">
</head>

<body>

    <header class="navbar">
        <div class="nav-container">
            <div class="nav-left">
                <span class="logo">Kasqeu</span>
                <nav class="nav-links">
                    <a href="dashboard_admin.php">Dashboard</a>
                    <a href="inputTransaksi_admin.php">Input Transaksi</a>
                    <a href="riwayat_admin.php" class="active">Riwayat</a>
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

        <header class="content-header-split"
            style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 32px; gap: 24px;">
            <div class="header-title-box">
                <h2>Riwayat Seluruh Transaksi</h2>
                <p>Pantau pengeluaran dan pemasukan kas kita secara real time.</p>
            </div>
            <div class="header-action-box">
                <div class="search-wrapper">
                    <span class="material-symbols-outlined search-icon">search</span>
                    <input class="search-input" type="text" placeholder="Cari transaksi..." />
                </div>
            </div>
        </header>

        <section class="table-section">
            <div class="table-header-panel">
                <div class="table-title-counter">
                    <h4>Daftar Transaksi</h4>
                    <span class="table-badge">150 Total</span>
                </div>
                <button class="btn-print-report">Cetak Laporan</button>
            </div>

            <div class="table-responsive">
                <table class="data-table-admin">
                    <thead>
                        <tr>
                            <th style="width: 50px;">No</th>
                            <th style="width: 120px;">Tanggal</th>
                            <th>Nama/Keterangan</th>
                            <th class="text-center" style="width: 120px;">Jenis</th>
                            <th class="text-right-align" style="width: 140px;">Nominal</th>
                            <th class="text-center" style="width: 120px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="text-muted">01</td>
                            <td class="text-muted">12 Okt 2023</td>
                            <td>
                                <div class="row-title">Budi Santoso</div>
                                <div class="row-subtitle">Iuran Kas Minggu ke-2</div>
                            </td>
                            <td class="text-center">
                                <span class="badge-row badge-row-success">
                                    <span class="material-symbols-outlined">arrow_downward</span> Masuk
                                </span>
                            </td>
                            <td class="text-right-align text-green font-bold">Rp 20.000</td>
                            <td class="text-center">
                                <div class="action-buttons-flex">
                                    <button class="btn-table-action btn-edit"
                                        onclick="openEditModal(1, '12 Okt 2023', 'Budi Santoso', 'masuk', 20000)">
                                        <span class="material-symbols-outlined">edit</span>
                                    </button>
                                    <button class="btn-table-action btn-delete">
                                        <span class="material-symbols-outlined">delete</span>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <tr class="row-zebra">
                            <td class="text-muted">02</td>
                            <td class="text-muted">13 Okt 2023</td>
                            <td>
                                <div class="row-title">Fotokopi Materi PAI</div>
                                <div class="row-subtitle">Pengeluaran Kelas</div>
                            </td>
                            <td class="text-center">
                                <span class="badge-row badge-row-error">
                                    <span class="material-symbols-outlined">arrow_upward</span> Keluar
                                </span>
                            </td>
                            <td class="text-right-align text-red font-bold">Rp 15.000</td>
                            <td class="text-center">
                                <div class="action-buttons-flex">
                                    <button class="btn-table-action btn-edit"
                                        onclick="openEditModal(2, '13 Okt 2023', 'Fotokopi Materi PAI', 'keluar', 15000)">
                                        <span class="material-symbols-outlined">edit</span>
                                    </button>
                                    <button class="btn-table-action btn-delete">
                                        <span class="material-symbols-outlined">delete</span>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-muted">03</td>
                            <td class="text-muted">14 Okt 2023</td>
                            <td>
                                <div class="row-title">Siti Aminah</div>
                                <div class="row-subtitle">Iuran Kas Minggu ke-2</div>
                            </td>
                            <td class="text-center">
                                <span class="badge-row badge-row-success">
                                    <span class="material-symbols-outlined">arrow_downward</span> Masuk
                                </span>
                            </td>
                            <td class="text-right-align text-green font-bold">Rp 20.000</td>
                            <td class="text-center">
                                <div class="action-buttons-flex">
                                    <button class="btn-table-action btn-edit">
                                        <span class="material-symbols-outlined">edit</span>
                                    </button>
                                    <button class="btn-table-action btn-delete">
                                        <span class="material-symbols-outlined">delete</span>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <tr class="row-zebra">
                            <td class="text-muted">04</td>
                            <td class="text-muted">15 Okt 2023</td>
                            <td>
                                <div class="row-title">Agus Pratama</div>
                                <div class="row-subtitle">Iuran Kas Minggu ke-1 & 2</div>
                            </td>
                            <td class="text-center">
                                <span class="badge-row badge-row-success">
                                    <span class="material-symbols-outlined">arrow_downward</span> Masuk
                                </span>
                            </td>
                            <td class="text-right-align text-green font-bold">Rp 40.000</td>
                            <td class="text-center">
                                <div class="action-buttons-flex">
                                    <button class="btn-table-action btn-edit">
                                        <span class="material-symbols-outlined">edit</span>
                                    </button>
                                    <button class="btn-table-action btn-delete">
                                        <span class="material-symbols-outlined">delete</span>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-muted">05</td>
                            <td class="text-muted">16 Okt 2023</td>
                            <td>
                                <div class="row-title">Beli Spidol & Penghapus</div>
                                <div class="row-subtitle">Kebutuhan Kelas</div>
                            </td>
                            <td class="text-center">
                                <span class="badge-row badge-row-error">
                                    <span class="material-symbols-outlined">arrow_upward</span> Keluar
                                </span>
                            </td>
                            <td class="text-right-align text-red font-bold">Rp 25.000</td>
                            <td class="text-center">
                                <div class="action-buttons-flex">
                                    <button class="btn-table-action btn-edit">
                                        <span class="material-symbols-outlined">edit</span>
                                    </button>
                                    <button class="btn-table-action btn-delete">
                                        <span class="material-symbols-outlined">delete</span>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="table-footer-panel">
                <span class="text-counter">Menampilkan 1-10 dari 150 transaksi</span>
                <div class="pagination-wrapper">
                    <button class="btn-page-nav arrow-nav">
                        <span class="material-symbols-outlined">chevron_left</span>
                    </button>
                    <button class="btn-page-nav page-number active-page">1</button>
                    <button class="btn-page-nav page-number">2</button>
                    <button class="btn-page-nav page-number">3</button>
                    <button class="btn-page-nav arrow-nav">
                        <span class="material-symbols-outlined">chevron_right</span>
                    </button>
                </div>
            </div>
        </section>
    </main>

    <div class="modal-overlay hidden opacity-0" id="edit-modal">
        <div class="modal-container scale-95" id="modal-container">
            <div class="modal-header">
                <h3>Edit Transaksi</h3>
                <button class="btn-close-modal" onclick="closeEditModal()">
                    <span class="material-symbols-outlined">close</span>
                </button>
            </div>
            <form class="modal-body space-y-modal-form" onsubmit="event.preventDefault(); closeEditModal();">
                <div class="form-group-modal">
                    <label class="modal-label">Tanggal Transaksi</label>
                    <input class="modal-control" id="modal-date" type="text" />
                </div>
                <div class="form-group-modal">
                    <label class="modal-label">Nama / Keterangan</label>
                    <input class="modal-control" id="modal-desc" type="text" />
                </div>
                <div class="form-group-modal">
                    <label class="modal-label">Jenis Transaksi</label>
                    <select class="modal-control modal-select" id="modal-type">
                        <option value="masuk">Uang Masuk (Iuran)</option>
                        <option value="keluar">Uang Keluar (Pengeluaran)</option>
                    </select>
                </div>
                <div class="form-group-modal">
                    <label class="modal-label">Nominal (Rp)</label>
                    <div class="modal-input-icon-wrapper">
                        <span class="modal-input-prefix">Rp</span>
                        <input class="modal-control modal-input-with-prefix" id="modal-nominal" type="number" />
                    </div>
                </div>
                <div class="modal-action-box">
                    <button class="btn-modal-cancel" type="button" onclick="closeEditModal()">Batal</button>
                    <button class="btn-modal-submit" type="submit">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        const modal = document.getElementById('edit-modal');
        const modalContainer = document.getElementById('modal-container');

        function openEditModal(id, date, desc, type, nominal) {
            document.getElementById('modal-date').value = date;
            document.getElementById('modal-desc').value = desc;
            document.getElementById('modal-type').value = type;
            document.getElementById('modal-nominal').value = nominal;

            modal.classList.remove('hidden');
            setTimeout(() => {
                modal.classList.remove('opacity-0');
                modalContainer.classList.remove('scale-95');
                modalContainer.classList.add('scale-100');
            }, 10);
        }

        function closeEditModal() {
            modal.classList.add('opacity-0');
            modalContainer.classList.remove('scale-100');
            modalContainer.classList.add('scale-95');
            setTimeout(() => {
                modal.classList.add('hidden');
            }, 300);
        }

        modal.addEventListener('click', (e) => {
            if (e.target === modal) closeEditModal();
        });
    </script>
</body>

</html>