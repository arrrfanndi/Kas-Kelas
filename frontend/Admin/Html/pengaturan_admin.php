<?php
require_once '../../../Backend/Admin/Logic_pengaturan_admin.php';
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kasqeu - Admin - Pengaturan</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet">

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
                    <a href="pengaturan_admin.php" class="active">Pengaturan</a>
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
    <main class="main-content">

        <header class="content-header-split">
            <div class="header-title-box">
                <h2>Pengaturan Tagihan Mingguan</h2>
                <p>Konfigurasi master periode kas dan nominal wajib per minggu.</p>
            </div>
            <div class="header-action-box">
                <div class="metric-summary-box">
                    <p class="metric-label">Total Minggu</p>
                    <p class="metric-value"><?= $total_minggu; ?></p>
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

                    <form method="POST" action="pengaturan_admin.php" class="space-y-form">
                        <input type="hidden" name="action_insert" value="1">
                        <input type="hidden" name="minggu_ke" value="<?= $next_minggu; ?>">

                        <div class="form-row-twin">
                            <div class="form-group">
                                <label class="form-label" for="month">Bulan</label>
                                <select class="form-control form-select" id="month" name="bulan" required>
                                    <?php foreach ($bulan_indo as $bi): ?>
                                        <option value="<?= $bi; ?>" <?= $bi === $next_bulan ? 'selected' : ''; ?>><?= $bi; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="year">Tahun</label>
                                <select class="form-control form-select" id="year" name="tahun" required>
                                    <option value="2025" <?= $next_tahun === '2025' ? 'selected' : ''; ?>>2025</option>
                                    <option value="2026" <?= $next_tahun === '2026' ? 'selected' : ''; ?>>2026</option>
                                    <option value="2027" <?= $next_tahun === '2027' ? 'selected' : ''; ?>>2027</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Minggu Ke- (Otomatis Naik)</label>
                            <input type="text" class="form-control" value="Minggu <?= $next_minggu; ?>" readonly style="background-color: #f3f4f6; cursor: not-allowed; font-weight: 600; color: #1f2937;">
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="start-date">Tanggal Mulai (Hari Senin)</label>
                            <input class="form-control form-date-input" id="start-date" type="date" name="tanggal_mulai" value="<?= $next_tanggal_mulai; ?>" required>
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="nominal-kas">Nominal Kas (Rp)</label>
                            <div class="input-icon-wrapper">
                                <span class="input-prefix">Rp</span>
                                <input class="form-control form-input-with-prefix" id="nominal-kas" type="number" name="nominal" value="10000" required>
                            </div>
                        </div>

                        <div class="form-action-btn-box">
                            <button class="btn-submit-primary" type="submit">
                                <span class="material-symbols-outlined">save</span>
                                <span>Simpan Minggu Baru</span>
                            </button>
                        </div>
                    </form>
                </div>
            </section>

            <section class="table-layout-span">
                <div class="table-section">
                    <div class="table-header-panel">
                        <div class="table-title-counter">
                            <span class="material-symbols-outlined text-muted">list_alt</span>
                            <h4>Daftar Minggu Master</h4>
                        </div>
                        <form method="GET" action="pengaturan_admin.php" class="search-wrapper">
                            <span class="material-symbols-outlined search-icon">search</span>
                            <input class="search-input" type="text" name="search" value="<?= htmlspecialchars($search); ?>" placeholder="Cari minggu...">
                        </form>
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
                                <?php if (empty($periode_kas)): ?>
                                    <tr>
                                        <td colspan="5" class="text-center text-muted" style="padding: 24px;">Data master periode kas tidak ditemukan.</td>
                                    </tr>
                                <?php else: ?>
                                    <?php
                                    $no = 1;
                                    foreach ($periode_kas as $row):
                                        $isZebra = ($no % 2 === 0) ? 'row-zebra' : '';

                                        // Membaca kalender server komputer hari ini (Format asli: YYYY-MM-DD)
                                        $today = date('Y-m-d');

                                        // ==========================================
                                        // LOGIKA UTAMA PENENTUAN 3 STATUS REAL-TIME
                                        // ==========================================
                                        if ($today < $row['tanggal_mulai']) {
                                            // Kondisi 1: Hari ini belum menyentuh tanggal mulai (Mendatang)
                                            $status_badge = '<span class="badge-row" style="background-color: #fef3c7; color: #d97706; border: 1px solid #fde68a;">Mendatang</span>';
                                        } elseif ($today >= $row['tanggal_mulai'] && $today <= $row['tanggal_selesai']) {
                                            // Kondisi 2: Hari ini sedang berada di dalam rentang waktu minggu tersebut (Berjalan)
                                            $status_badge = '<span class="badge-row badge-row-success">Berjalan</span>';
                                        } else {
                                            // Kondisi 3: Rentang tanggal minggu sudah terlewati oleh hari ini (Selesai)
                                            $status_badge = '<span class="badge-row badge-row-neutral">Selesai</span>';
                                        }
                                    ?>
                                        <tr class="<?= $isZebra; ?>">
                                            <td class="text-muted"><?= sprintf("%02d", $no); ?></td>
                                            <td class="font-semibold text-dark">Minggu <?= $row['minggu_ke']; ?> (<?= htmlspecialchars($row['bulan']); ?> <?= $row['tahun']; ?>)</td>
                                            <td class="font-bold text-gold-color">Rp <?= number_format($row['nominal'], 0, ',', '.'); ?></td>
                                            <td class="text-center">
                                                <?= $status_badge; ?>
                                            </td>
                                            <td class="text-right-align">
                                                <div class="action-buttons-flex-end">
                                                    <button class="btn-table-action btn-edit" title="Edit Minggu"
                                                        onclick="openEditModal(<?= $row['id']; ?>, '<?= $row['bulan']; ?>', '<?= $row['tahun']; ?>', '<?= $row['minggu_ke']; ?>', '<?= $row['tanggal_mulai']; ?>', <?= $row['nominal']; ?>)">
                                                        <span class="material-symbols-outlined">edit</span>
                                                    </button>
                                                    <a href="pengaturan_admin.php?action=delete&id=<?= $row['id']; ?>" class="btn-table-action btn-delete" title="Hapus Minggu" onclick="return confirm('Peringatan! Menghapus minggu ini akan ikut menghapus seluruh data tagihan kas siswa (lunas/belum) pada minggu ini secara permanen. Lanjutkan?')">
                                                        <span class="material-symbols-outlined">delete</span>
                                                    </a>
                                                </div>
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

                    <div class="table-footer-panel panel-zebra-bg">
                        <span class="text-counter">Menampilkan <?= count($periode_kas); ?> dari <?= $total_minggu; ?> Minggu</span>
                    </div>
                </div>
            </section>
        </div>

        <div class="toast-notification <?= $show_toast ? 'show' : ''; ?>" id="toast">
            <span class="material-symbols-outlined">check_circle</span>
            <span class="toast-text">Data pengaturan minggu berhasil diperbarui.</span>
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
            <form method="POST" action="pengaturan_admin.php" class="modal-body space-y-modal-form">
                <input type="hidden" name="action_update" value="1">
                <input type="hidden" id="edit-id" name="id">

                <div class="form-row-twin">
                    <div class="form-group-modal">
                        <label class="modal-label" for="edit-month">Bulan</label>
                        <select class="modal-control modal-select" id="edit-month" name="bulan" required>
                            <?php foreach ($bulan_indo as $bi): ?>
                                <option value="<?= $bi; ?>"><?= $bi; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group-modal">
                        <label class="modal-label" for="edit-year">Tahun</label>
                        <select class="modal-control modal-select" id="edit-year" name="tahun" required>
                            <option value="2025">2025</option>
                            <option value="2026">2026</option>
                            <option value="2027">2027</option>
                        </select>
                    </div>
                </div>

                <div class="form-group-modal">
                    <label class="modal-label">Minggu Ke- (Terkunci)</label>
                    <input type="text" class="modal-control" id="edit-week-of-month" readonly style="background-color: #f3f4f6; cursor: not-allowed; font-weight: 600; color: #1f2937;">
                </div>

                <div class="form-group-modal">
                    <label class="modal-label" for="edit-start-date">Tanggal Mulai (Hari Senin)</label>
                    <input class="modal-control" id="edit-start-date" type="date" name="tanggal_mulai" required>
                </div>

                <div class="form-group-modal">
                    <label class="modal-label" for="edit-nominal-kas">Nominal Kas (Rp)</label>
                    <div class="modal-input-icon-wrapper">
                        <span class="modal-input-prefix">Rp</span>
                        <input class="modal-control modal-input-with-prefix" id="edit-nominal-kas" type="number" name="nominal" required>
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
        const editModal = document.getElementById('edit-tagihan-modal');
        const editModalContainer = document.getElementById('edit-modal-container');
        const toast = document.getElementById('toast');

        if (toast.classList.contains('show')) {
            setTimeout(() => {
                toast.classList.remove('show');
            }, 3000);
        }

        function openEditModal(id, bulan, tahun, mingguKe, tanggalMulai, nominal) {
            document.getElementById('edit-id').value = id;
            document.getElementById('edit-month').value = bulan;
            document.getElementById('edit-year').value = tahun;
            document.getElementById('edit-week-of-month').value = 'Minggu ' + mingguKe;
            document.getElementById('edit-start-date').value = tanggalMulai;
            document.getElementById('edit-nominal-kas').value = nominal;

            editModal.classList.remove('hidden');
            setTimeout(() => {
                editModal.classList.remove('opacity-0');
                editModalContainer.classList.remove('scale-95');
                editModalContainer.classList.add('scale-100');
            }, 10);
        }

        function closeEditModal() {
            editModal.classList.add('opacity-0');
            editModalContainer.classList.remove('scale-100');
            editModalContainer.classList.add('scale-95');
            setTimeout(() => {
                editModal.classList.add('hidden');
            }, 300);
        }

        editModal.addEventListener('click', (e) => {
            if (e.target === editModal) closeEditModal();
        });
    </script>
</body>

</html>