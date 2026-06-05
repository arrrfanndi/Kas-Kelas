<?php

require_once '../../../Backend/Admin/Logic_riwayat_admin.php';
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kasqeu - Admin - Riwayat</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet">

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

        <header class="content-header-split" style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 32px; gap: 24px;">
            <div class="header-title-box">
                <h2>Riwayat Seluruh Transaksi</h2>
                <p>Pantau pengeluaran dan pemasukan kas kita secara real time.</p>
            </div>
            <form method="GET" action="riwayat_admin.php" class="header-action-box">
                <div class="search-wrapper">
                    <span class="material-symbols-outlined search-icon">search</span>
                    <input class="search-input" type="text" name="search" value="<?= htmlspecialchars($search); ?>" placeholder="Cari transaksi..." />
                </div>
            </form>
        </header>

        <section class="table-section">
            <div class="table-header-panel">
                <div class="table-title-counter">
                    <h4>Daftar Transaksi</h4>
                    <span class="table-badge"><?= $totalRows; ?> Total</span>
                </div>
                <button class="btn-print-report" onclick="window.open('/Backend/Admin/print_riwayat.php?search=<?= urlencode($search); ?>', '_blank')">Cetak Laporan</button>
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
                        <?php if (empty($transaksi)): ?>
                            <tr>
                                <td colspan="6" class="text-center text-muted" style="padding: 32px;">Data transaksi tidak ditemukan.</td>
                            </tr>
                        <?php else: ?>
                            <?php
                            $no = $offset + 1;
                            foreach ($transaksi as $row):
                                $isZebra = ($no % 2 === 0) ? 'row-zebra' : '';
                            ?>
                                <tr class="<?= $isZebra; ?>">
                                    <td class="text-muted"><?= sprintf("%02d", $no); ?></td>
                                    <td class="text-muted"><?= formatTanggalIndo($row['tanggal']); ?></td>
                                    <td>
                                        <div class="row-title"><?= htmlspecialchars($row['nama_keterangan']); ?></div>
                                        <div class="row-subtitle"><?= htmlspecialchars($row['sub_keterangan']); ?></div>
                                    </td>
                                    <td class="text-center">
                                        <?php if ($row['jenis'] === 'masuk'): ?>
                                            <span class="badge-row badge-row-success">
                                                <span class="material-symbols-outlined">arrow_downward</span> Masuk
                                            </span>
                                        <?php else: ?>
                                            <span class="badge-row badge-row-error">
                                                <span class="material-symbols-outlined">arrow_upward</span> Keluar
                                            </span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-right-align <?= $row['jenis'] === 'masuk' ? 'text-green' : 'text-red'; ?> font-bold">
                                        Rp <?= number_format($row['nominal'], 0, ',', '.'); ?>
                                    </td>
                                    <td class="text-center">
                                        <div class="action-buttons-flex">
                                            <button class="btn-table-action btn-edit"
                                                onclick="openEditModal(<?= $row['original_id']; ?>, '<?= $row['tanggal']; ?>', '<?= htmlspecialchars($row['nama_keterangan'], ENT_QUOTES); ?>', '<?= $row['jenis']; ?>', <?= $row['nominal']; ?>)">
                                                <span class="material-symbols-outlined">edit</span>
                                            </button>
                                            <a href="riwayat_admin.php?action=delete&id=<?= $row['original_id']; ?>&type=<?= $row['jenis']; ?>"
                                                class="btn-table-action btn-delete"
                                                onclick="return confirm('Apakah Anda yakin ingin menghapus / merollback transaksi ini?')">
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

            <div class="table-footer-panel">
                <span class="text-counter">
                    Menampilkan <?= $totalRows > 0 ? $offset + 1 : 0; ?>-<?= min($offset + $limit, $totalRows); ?> dari <?= $totalRows; ?> transaksi
                </span>
                <div class="pagination-wrapper">
                    <a href="?page=<?= max(1, $page - 1); ?><?= $search !== '' ? '&search=' . urlencode($search) : ''; ?>"
                        class="btn-page-nav arrow-nav" style="display:flex; align-items:center; justify-content:center; text-decoration:none;">
                        <span class="material-symbols-outlined">chevron_left</span>
                    </a>

                    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                        <a href="?page=<?= $i; ?><?= $search !== '' ? '&search=' . urlencode($search) : ''; ?>"
                            class="btn-page-nav page-number <?= $page === $i ? 'active-page' : ''; ?>" style="display:flex; align-items:center; justify-content:center; text-decoration:none;">
                            <?= $i; ?>
                        </a>
                    <?php endfor; ?>

                    <a href="?page=<?= min($totalPages, $page + 1); ?><?= $search !== '' ? '&search=' . urlencode($search) : ''; ?>"
                        class="btn-page-nav arrow-nav" style="display:flex; align-items:center; justify-content:center; text-decoration:none;">
                        <span class="material-symbols-outlined">chevron_right</span>
                    </a>
                </div>
            </div>
        </section>
    </main>

    <div class="modal-overlay hidden opacity-0" id="edit-modal">
        <div class="modal-container scale-95" id="modal-container">
            <div class="modal-header">
                <h3>Edit Transaksi</h3>
                <button class="btn-close-modal" type="button" onclick="closeEditModal()">
                    <span class="material-symbols-outlined">close</span>
                </button>
            </div>

            <form method="POST" action="riwayat_admin.php" class="modal-body space-y-modal-form">
                <input type="hidden" name="action_update" value="1">
                <input type="hidden" name="edit_id" id="modal-id">
                <input type="hidden" name="edit_type" id="modal-type-hidden">

                <div class="form-group-modal">
                    <label class="modal-label">Tanggal Transaksi</label>
                    <input class="modal-control" id="modal-date" type="date" name="tanggal" required />
                </div>
                <div class="form-group-modal">
                    <label class="modal-label">Nama / Keterangan</label>
                    <input class="modal-control" id="modal-desc" type="text" name="keterangan" required />
                </div>
                <div class="form-group-modal">
                    <label class="modal-label">Jenis Transaksi</label>
                    <select class="modal-control modal-select" id="modal-type" disabled>
                        <option value="masuk">Uang Masuk (Iuran)</option>
                        <option value="keluar">Uang Keluar (Pengeluaran)</option>
                    </select>
                    <small class="text-muted" style="font-size: 11px; margin-top: 4px; display: block;">Jenis transaksi baku tidak dapat diubah silang.</small>
                </div>
                <div class="form-group-modal">
                    <label class="modal-label">Nominal (Rp)</label>
                    <div class="modal-input-icon-wrapper">
                        <span class="modal-input-prefix">Rp</span>
                        <input class="modal-control modal-input-with-prefix" id="modal-nominal" type="number" name="nominal" required />
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
            const tanggalBersih = date.split(' ')[0];

            document.getElementById('modal-id').value = id;
            document.getElementById('modal-type-hidden').value = type;
            document.getElementById('modal-date').value = tanggalBersih;
            document.getElementById('modal-desc').value = desc;
            document.getElementById('modal-type').value = type;
            document.getElementById('modal-nominal').value = nominal;

            const descInput = document.getElementById('modal-desc');
            const nominalInput = document.getElementById('modal-nominal');

            if (type === 'masuk') {
                descInput.readOnly = true;
                nominalInput.readOnly = true;
                descInput.style.backgroundColor = '#f3f4f6';
                nominalInput.style.backgroundColor = '#f3f4f6';
            } else {
                descInput.readOnly = false;
                nominalInput.readOnly = false;
                descInput.style.backgroundColor = '#fff';
                nominalInput.style.backgroundColor = '#fff';
            }

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