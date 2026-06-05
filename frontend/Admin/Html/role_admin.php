<?php
require_once '../../../Backend/Admin/Logic_role_admin.php';
?><!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kasqeu - Admin - Role</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap"
        rel="stylesheet">

    <link rel="stylesheet" href="../../User/Css/user_dashboard.css">
    <link rel="stylesheet" href="../Css/dashboard_admin.css">
    <link rel="stylesheet" href="../Css/role_admin.css">
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
                    <a href="pengaturan_admin.php">Pengaturan</a>
                    <a href="role_admin.php" class="active">Role</a>
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
                <h2>Manajemen Data Siswa</h2>
                <p>Kelola data anggota kelas, kredensial akun login, dan informasi kontak.</p>
            </div>
            <div class="header-action-box">
                <button class="btn-add-student-primary" onclick="openAddModal()">
                    <span class="material-symbols-outlined">person_add</span>
                    <span>Tambah Siswa Baru</span>
                </button>
            </div>
        </header>

        <section class="table-section">
            <div class="table-header-panel">
                <div class="table-title-counter">
                    <h4>Daftar Siswa Kelas</h4>
                    <span class="table-badge"><?= $total_siswa; ?> Siswa</span>
                </div>
            </div>

            <div class="table-responsive">
                <table class="data-table-admin">
                    <thead>
                        <tr>
                            <th style="width: 60px;">No</th>
                            <th>Nama Lengkap</th>
                            <th style="width: 200px;">Username</th>
                            <th style="width: 180px;">No. WhatsApp</th>
                            <th class="text-center" style="width: 150px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($list_siswa)): ?>
                            <tr>
                                <td colspan="5" class="text-center text-muted" style="padding: 32px;">Tidak ada data siswa aktif yang ditemukan.</td>
                            </tr>
                        <?php else: ?>
                            <?php
                            $no = 1;
                            foreach ($list_siswa as $row):
                                $isZebra = ($no % 2 === 0) ? 'row-zebra' : '';
                            ?>
                                <tr class="<?= $isZebra; ?>">
                                    <td class="text-muted"><?= sprintf("%02d", $no++); ?></td>
                                    <td class="font-semibold text-dark"><?= htmlspecialchars($row['nama']); ?></td>
                                    <td class="text-muted"><?= htmlspecialchars($row['username']); ?></td>
                                    <td class="text-muted"><?= htmlspecialchars($row['no_whatsapp']); ?></td>
                                    <td class="text-center">
                                        <div class="action-buttons-flex">
                                            <button class="btn-table-action btn-edit" title="Edit Data Siswa"
                                                onclick="openEditModal(<?= $row['id']; ?>, '<?= htmlspecialchars($row['nama'], ENT_QUOTES); ?>', '<?= htmlspecialchars($row['username'], ENT_QUOTES); ?>', '<?= htmlspecialchars($row['no_whatsapp'], ENT_QUOTES); ?>')">
                                                <span class="material-symbols-outlined">edit</span>
                                            </button>
                                            <a href="role_admin.php?delete_id=<?= $row['id']; ?>"
                                               class="btn-table-action btn-delete" title="Nonaktifkan Siswa"
                                               onclick="return confirm('Akun <?= htmlspecialchars($row['nama'], ENT_QUOTES); ?> akan diubah status menjadi nonaktif (pindah). Lanjutkan?')">
                                                <span class="material-symbols-outlined">person_off</span>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </section>

        <div class="toast-notification <?= $show_toast ? 'show' : ''; ?>" id="toast">
            <span class="material-symbols-outlined">check_circle</span>
            <span class="toast-text"><?= $toast_message; ?></span>
        </div>
    </main>

    <div class="modal-overlay hidden opacity-0" id="add-student-modal">
        <div class="modal-container scale-95" id="modal-container">
            <div class="modal-header">
                <h3>Tambah Siswa Baru</h3>
                <button class="btn-close-modal" type="button" onclick="closeAddModal()">
                    <span class="material-symbols-outlined">close</span>
                </button>
            </div>
            <form method="POST" action="role_admin.php" class="modal-body space-y-modal-form">
                <input type="hidden" name="action_insert" value="1">

                <div class="form-group-modal">
                    <label class="modal-label">Nama Lengkap</label>
                    <input class="modal-control" type="text" name="nama" placeholder="Masukkan nama lengkap siswa" required />
                </div>
                <div class="form-group-modal">
                    <label class="modal-label">Username</label>
                    <input class="modal-control" type="text" name="username" placeholder="Contoh: aditya_pratama" required />
                </div>
                <div class="form-group-modal">
                    <label class="modal-label">Password Bawaan</label>
                    <input class="modal-control" type="password" name="password" placeholder="Kosongkan jika ingin default memakai: 12345" />
                </div>
                <div class="form-group-modal">
                    <label class="modal-label">No. WhatsApp</label>
                    <div class="modal-input-icon-wrapper">
                        <span class="modal-input-prefix">+62</span>
                        <input class="modal-control modal-input-with-prefix" type="tel" name="no_whatsapp" placeholder="81234567890" required />
                    </div>
                </div>
                <div class="modal-action-box">
                    <button class="btn-modal-cancel" type="button" onclick="closeAddModal()">Batal</button>
                    <button class="btn-modal-submit" type="submit">Daftarkan Siswa</button>
                </div>
            </form>
        </div>
    </div>

    <div class="modal-overlay hidden opacity-0" id="edit-student-modal">
        <div class="modal-container scale-95" id="edit-modal-container">
            <div class="modal-header">
                <h3>Edit Data Siswa</h3>
                <button class="btn-close-modal" type="button" onclick="closeEditModal()">
                    <span class="material-symbols-outlined">close</span>
                </button>
            </div>
            <form method="POST" action="role_admin.php" class="modal-body space-y-modal-form">
                <input type="hidden" name="action_update" value="1">
                <input type="hidden" name="id" id="edit-id">

                <div class="form-group-modal">
                    <label class="modal-label">Nama Lengkap</label>
                    <input class="modal-control" type="text" name="nama" id="edit-nama" required />
                </div>
                <div class="form-group-modal">
                    <label class="modal-label">Username</label>
                    <input class="modal-control" type="text" name="username" id="edit-username" required />
                </div>
                <div class="form-group-modal">
                    <label class="modal-label">No. WhatsApp</label>
                    <div class="modal-input-icon-wrapper">
                        <span class="modal-input-prefix">+62</span>
                        <input class="modal-control modal-input-with-prefix" type="tel" name="no_whatsapp" id="edit-whatsapp" required />
                    </div>
                </div>
                <div class="form-group-modal">
                    <label class="modal-label">Ganti Password (Opsional)</label>
                    <input class="modal-control" type="password" name="password" placeholder="Kosongkan jika tidak ingin merubah password..." />
                </div>

                <div class="modal-action-box">
                    <button class="btn-modal-cancel" type="button" onclick="closeEditModal()">Batal</button>
                    <button class="btn-modal-submit" type="submit">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        const modal = document.getElementById('add-student-modal');
        const modalContainer = document.getElementById('modal-container');
        const editModal = document.getElementById('edit-student-modal');
        const editModalContainer = document.getElementById('edit-modal-container');
        const toast = document.getElementById('toast');

        if (toast.classList.contains('show')) {
            setTimeout(() => {
                toast.classList.remove('show');
            }, 3000);
        }

        function openAddModal() {
            modal.classList.remove('hidden');
            setTimeout(() => {
                modal.classList.remove('opacity-0');
                modalContainer.classList.remove('scale-95');
                modalContainer.classList.add('scale-100');
            }, 10);
        }

        function closeAddModal() {
            modal.classList.add('opacity-0');
            modalContainer.classList.remove('scale-100');
            modalContainer.classList.add('scale-95');
            setTimeout(() => {
                modal.classList.add('hidden');
            }, 300);
        }

        function openEditModal(id, nama, username, whatsapp) {
            document.getElementById('edit-id').value = id;
            document.getElementById('edit-nama').value = nama;
            document.getElementById('edit-username').value = username;
            document.getElementById('edit-whatsapp').value = whatsapp;

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

        modal.addEventListener('click', (e) => {
            if (e.target === modal) closeAddModal();
        });

        editModal.addEventListener('click', (e) => {
            if (e.target === editModal) closeEditModal();
        });
    </script>
</body>

</html>