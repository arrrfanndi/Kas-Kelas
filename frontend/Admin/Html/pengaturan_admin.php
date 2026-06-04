<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kasqeu - Admin - Pengaturan</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap"
        rel="stylesheet">

    <link rel="stylesheet" href="../../User/Css/user_dashboard.css">
    <link rel="stylesheet" href="../Css/dashboard_admin.css">
    <link rel="stylesheet" href="../Css/pengaturan_admin.css">
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
                    <a href="tagihan_admin.php">Tagihan</a>
                    <a href="#" class="active">Pengaturan</a>
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

        <header class="content-header-split">
            <div class="header-title-box">
                <h2>Pengaturan Tagihan Mingguan</h2>
                <p>Konfigurasi master periode kas dan nominal wajib per minggu.</p>
            </div>
            <div class="header-action-box">
                <div class="metric-summary-box">
                    <p class="metric-label">Total Minggu</p>
                    <p class="metric-value">18</p>
                </div>
            </div>
        </header>

        <div class="input-grid-container">

            <section class="form-aside-layout">
                <div class="form-card-main">
                    <div class="form-card-title-box">
                        <span class="material-symbols-outlined text-blue">add_circle</span>
                        <h3>Tambah Minggu Baru</h3>
                    </div>

                    <form class="space-y-form">
                        <div class="form-row-twin">
                            <div class="form-group">
                                <label class="form-label" for="month">Bulan</label>
                                <select class="form-control form-select" id="month">
                                    <option value="Januari">Januari</option>
                                    <option value="Februari">Februari</option>
                                    <option value="Maret">Maret</option>
                                    <option value="April">April</option>
                                    <option value="Mei">Mei</option>
                                    <option value="Juni">Juni</option>
                                    <option value="Juli">Juli</option>
                                    <option value="Agustus">Agustus</option>
                                    <option value="September">September</option>
                                    <option value="Oktober">Oktober</option>
                                    <option value="November">November</option>
                                    <option value="Desember">Desember</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="year">Tahun</label>
                                <select class="form-control form-select" id="year">
                                    <option value="2024">2024</option>
                                    <option value="2025">2025</option>
                                    <option value="2026" selected>2026</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="week-of-month">Minggu Ke-</label>
                            <select class="form-control form-select" id="week-of-month">
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="start-date">Tanggal Mulai (Hari Senin)</label>
                            <input class="form-control form-date-input" id="start-date" type="date">
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="nominal-kas">Nominal Kas (Rp)</label>
                            <div class="input-icon-wrapper">
                                <span class="input-prefix">Rp</span>
                                <input class="form-control form-input-with-prefix" id="nominal-kas" type="number"
                                    value="10000">
                            </div>
                            <p class="form-helper-text">*Nominal standar Rp 10.000 per siswa.</p>
                        </div>

                        <div class="form-action-btn-box">
                            <button class="btn-submit-primary" type="submit">
                                <span class="material-symbols-outlined">save</span>
                                <span>Simpan Minggu Baru</span>
                            </button>
                        </div>
                    </form>
                </div>

                <div class="info-alert-card">
                    <span class="material-symbols-outlined text-primary-yellow">info</span>
                    <div class="info-alert-text">
                        <h5>Panduan Admin</h5>
                        <p>Pastikan penomoran minggu berurutan untuk menjaga keakuratan laporan piutang siswa di
                            dashboard utama.</p>
                    </div>
                </div>
            </section>

            <section class="table-layout-span">
                <div class="table-section">
                    <div class="table-header-panel">
                        <div class="table-title-counter">
                            <span class="material-symbols-outlined text-muted">list_alt</span>
                            <h4>Daftar Minggu Aktif</h4>
                        </div>
                        <div class="search-wrapper">
                            <span class="material-symbols-outlined search-icon">search</span>
                            <input class="search-input" type="text" placeholder="Cari minggu...">
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="data-table-admin">
                            <thead>
                                <tr>
                                    <th style="width: 60px;">No</th>
                                    <th>Minggu Ke</th>
                                    <th style="width: 180px;">Nominal</th>
                                    <th class="text-center" style="width: 150px;">Status</th>
                                    <th class="text-right-align" style="width: 140px;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="text-muted">01</td>
                                    <td class="font-semibold text-dark">Minggu 18</td>
                                    <td class="font-bold text-gold-color">Rp 5.000</td>
                                    <td class="text-center">
                                        <span class="badge-row badge-row-success">Aktif</span>
                                    </td>
                                    <td class="text-right-align">
                                        <div class="action-buttons-flex-end">
                                            <button class="btn-table-action btn-edit" title="Edit Minggu"
                                                onclick="openEditModal(18, 'September', '2026', '2', '2026-09-14', 5000)">
                                                <span class="material-symbols-outlined">edit</span>
                                            </button>
                                            <button class="btn-table-action btn-delete" title="Hapus Minggu">
                                                <span class="material-symbols-outlined">delete</span>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                <tr class="row-zebra">
                                    <td class="text-muted">02</td>
                                    <td class="font-semibold text-dark">Minggu 17</td>
                                    <td class="font-bold text-gold-color">Rp 5.000</td>
                                    <td class="text-center">
                                        <span class="badge-row badge-row-neutral">Selesai</span>
                                    </td>
                                    <td class="text-right-align">
                                        <div class="action-buttons-flex-end">
                                            <button class="btn-table-action btn-edit" title="Edit Minggu"
                                                onclick="openEditModal(17, 'September', '2026', '2', '2026-09-14', 5000)">
                                                <span class="material-symbols-outlined">edit</span>
                                            </button>
                                            <button class="btn-table-action btn-delete" title="Hapus Minggu">
                                                <span class="material-symbols-outlined">delete</span>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-muted">03</td>
                                    <td class="font-semibold text-dark">Minggu 16</td>
                                    <td class="font-bold text-gold-color">Rp 5.000</td>
                                    <td class="text-center">
                                        <span class="badge-row badge-row-neutral">Selesai</span>
                                    </td>
                                    <td class="text-right-align">
                                        <div class="action-buttons-flex-end">
                                            <button class="btn-table-action btn-edit" title="Edit Minggu"
                                                onclick="openEditModal(18, 'September', '2026', '2', '2026-09-14', 5000)">
                                                <span class="material-symbols-outlined">edit</span>
                                            </button>
                                            <button class="btn-table-action btn-delete" title="Hapus Minggu">
                                                <span class="material-symbols-outlined">delete</span>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                <tr class="row-zebra">
                                    <td class="text-muted">04</td>
                                    <td class="font-semibold text-dark">Minggu 15</td>
                                    <td class="font-bold text-gold-color">Rp 5.000</td>
                                    <td class="text-center">
                                        <span class="badge-row badge-row-neutral">Selesai</span>
                                    </td>
                                    <td class="text-right-align">
                                        <div class="action-buttons-flex-end">
                                            <button class="btn-table-action btn-edit" title="Edit Minggu"
                                                onclick="openEditModal(18, 'September', '2026', '2', '2026-09-14', 5000)">
                                                <span class="material-symbols-outlined">edit</span>
                                            </button>
                                            <button class="btn-table-action btn-delete" title="Hapus Minggu">
                                                <span class="material-symbols-outlined">delete</span>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-muted">05</td>
                                    <td class="font-semibold text-dark">Minggu 14</td>
                                    <td class="font-bold text-gold-color">Rp 5.000</td>
                                    <td class="text-center">
                                        <span class="badge-row badge-row-neutral">Selesai</span>
                                    </td>
                                    <td class="text-right-align">
                                        <div class="action-buttons-flex-end">
                                            <button class="btn-table-action btn-edit" title="Edit Minggu"
                                                onclick="openEditModal(18, 'September', '2026', '2', '2026-09-14', 5000)">
                                                <span class="material-symbols-outlined">edit</span>
                                            </button>
                                            <button class="btn-table-action btn-delete" title="Hapus Minggu">
                                                <span class="material-symbols-outlined">delete</span>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="table-footer-panel panel-zebra-bg">
                        <span class="text-counter">Menampilkan 5 dari 18 Minggu</span>
                        <div class="pagination-wrapper">
                            <button class="btn-page-nav arrow-nav disabled-nav">
                                <span class="material-symbols-outlined">chevron_left</span>
                            </button>
                            <button class="btn-page-nav page-number active-page">1</button>
                            <button class="btn-page-nav page-number">2</button>
                            <button class="btn-page-nav arrow-nav">
                                <span class="material-symbols-outlined">chevron_right</span>
                            </button>
                        </div>
                    </div>
                </div>
            </section>
        </div>

        <div class="toast-notification" id="toast">
            <span class="material-symbols-outlined">check_circle</span>
            <span class="toast-text">Data minggu berhasil disimpan.</span>
        </div>
    </main>


    <div class="modal-overlay hidden opacity-0" id="edit-tagihan-modal">
        <div class="modal-container scale-95" id="edit-modal-container">
            <div class="modal-header">
                <h3>Edit Pengaturan Minggu</h3>
                <button class="btn-close-modal" onclick="closeEditModal()">
                    <span class="material-symbols-outlined">close</span>
                </button>
            </div>
            <form class="modal-body space-y-modal-form" onsubmit="event.preventDefault(); closeEditModal();">

                <input type="hidden" id="edit-id" name="id">

                <div class="form-row-twin">
                    <div class="form-group-modal">
                        <label class="modal-label" for="edit-month">Bulan</label>
                        <select class="modal-control modal-select" id="edit-month">
                            <option value="Januari">Januari</option>
                            <option value="Februari">Februari</option>
                            <option value="Maret">Maret</option>
                            <option value="April">April</option>
                            <option value="Mei">Mei</option>
                            <option value="Juni">Juni</option>
                            <option value="Juli">Juli</option>
                            <option value="Agustus">Agustus</option>
                            <option value="September">September</option>
                            <option value="Oktober">Oktober</option>
                            <option value="November">November</option>
                            <option value="Desember">Desember</option>
                        </select>
                    </div>
                    <div class="form-group-modal">
                        <label class="modal-label" for="edit-year">Tahun</label>
                        <select class="modal-control modal-select" id="edit-year">
                            <option value="2024">2024</option>
                            <option value="2025">2025</option>
                            <option value="2026">2026</option>
                        </select>
                    </div>
                </div>

                <div class="form-group-modal">
                    <label class="modal-label" for="edit-week-of-month">Minggu Ke-</label>
                    <select class="modal-control modal-select" id="edit-week-of-month">
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                    </select>
                </div>

                <div class="form-group-modal">
                    <label class="modal-label" for="edit-start-date">Tanggal Mulai (Hari Senin)</label>
                    <input class="modal-control" id="edit-start-date" type="date">
                </div>

                <div class="form-group-modal">
                    <label class="modal-label" for="edit-nominal-kas">Nominal Kas (Rp)</label>
                    <div class="modal-input-icon-wrapper">
                        <span class="modal-input-prefix">Rp</span>
                        <input class="modal-control modal-input-with-prefix" id="edit-nominal-kas" type="number">
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
        document.querySelector('form').addEventListener('submit', (e) => {
            e.preventDefault();
            const toast = document.getElementById('toast');
            toast.classList.add('show');

            setTimeout(() => {
                toast.classList.remove('show');
            }, 3000);
        });
        const editModal = document.getElementById('edit-tagihan-modal');
        const editModalContainer = document.getElementById('edit-modal-container');

        // Fungsi Utama Membuka Modal Edit dan Mengisi Value Form secara Otomatis
        function openEditModal(id, bulan, tahun, mingguKe, tanggalMulai, nominal) {
            // 1. Suntikkan data baris tabel ke dalam form modal edit
            document.getElementById('edit-id').value = id;
            document.getElementById('edit-month').value = bulan;
            document.getElementById('edit-year').value = tahun;
            document.getElementById('edit-week-of-month').value = mingguKe;
            document.getElementById('edit-start-date').value = tanggalMulai;
            document.getElementById('edit-nominal-kas').value = nominal;

            // 2. Jalankan animasi trigger pop-up modal
            editModal.classList.remove('hidden');
            setTimeout(() => {
                editModal.classList.remove('opacity-0');
                editModalContainer.classList.remove('scale-95');
                editModalContainer.classList.add('scale-100');
            }, 10);
        }

        // Fungsi Menutup Modal Edit
        function closeEditModal() {
            editModal.classList.add('opacity-0');
            editModalContainer.classList.remove('scale-100');
            editModalContainer.classList.add('scale-95');
            setTimeout(() => {
                editModal.classList.add('hidden');
            }, 300);
        }

        // Close otomatis jika user mengklik area backdrop luar luar modal
        editModal.addEventListener('click', (e) => {
            if (e.target === editModal) closeEditModal();
        });
    </script>
</body>

</html>