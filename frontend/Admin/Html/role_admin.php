<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kasqeu - Admin - Role</title>
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
                    <a href="" class="active">Role</a>
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
                    <span class="table-badge">35 Siswa</span>
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
                        <tr>
                            <td class="text-muted">01</td>
                            <td class="font-semibold text-dark">Aditya Pratama</td>
                            <td class="text-muted">aditya_pratama</td>
                            <td class="text-muted">+62 812-3456-7890</td>
                            <td class="text-center">
                                <div class="action-buttons-flex">
                                    <button class="btn-table-action btn-edit" title="Edit Data Siswa"
                                        onclick="openEditModal(1, 'Aditya Pratama', 'aditya_pratama', '81234567890')">
                                        <span class="material-symbols-outlined">edit</span>
                                    </button>
                                    <button class="btn-table-action btn-delete"
                                        onclick="openDeleteConfirmation('Aditya Pratama')" title="Nonaktifkan Siswa">
                                        <span class="material-symbols-outlined">person_off</span>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <tr class="row-zebra">
                            <td class="text-muted">02</td>
                            <td class="font-semibold text-dark">Budi Santoso</td>
                            <td class="text-muted">budi_santoso</td>
                            <td class="text-muted">+62 857-1122-3344</td>
                            <td class="text-center">
                                <div class="action-buttons-flex">
                                    <button class="btn-table-action btn-edit" title="Edit Data Siswa"
                                        onclick="openEditModal(1, 'Budi Santoso', 'budi_santoso', '85711223344')">
                                        <span class="material-symbols-outlined">edit</span>
                                    </button>
                                    <button class="btn-table-action btn-delete"
                                        onclick="openDeleteConfirmation('Budi Santoso')" title="Nonaktifkan Siswa">
                                        <span class="material-symbols-outlined">person_off</span>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-muted">03</td>
                            <td class="font-semibold text-dark">Citra Lestari</td>
                            <td class="text-muted">citra_lestari</td>
                            <td class="text-muted">+62 819-8877-6655</td>
                            <td class="text-center">
                                <div class="action-buttons-flex">
                                    <button class="btn-table-action btn-edit" title="Edit Data Siswa"
                                        onclick="openEditModal(1, 'Citra Lestari', 'citra_lestari', '81988776655')">
                                        <span class="material-symbols-outlined">edit</span>
                                    </button>
                                    <button class="btn-table-action btn-delete"
                                        onclick="openDeleteConfirmation('Citra Lestari')" title="Nonaktifkan Siswa">
                                        <span class="material-symbols-outlined">person_off</span>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </section>
    </main>

    <div class="modal-overlay hidden opacity-0" id="add-student-modal">
        <div class="modal-container scale-95" id="modal-container">
            <div class="modal-header">
                <h3>Tambah Siswa Baru</h3>
                <button class="btn-close-modal" onclick="closeAddModal()">
                    <span class="material-symbols-outlined">close</span>
                </button>
            </div>
            <form class="modal-body space-y-modal-form" onsubmit="event.preventDefault(); closeAddModal();">
                <div class="form-group-modal">
                    <label class="modal-label">Nama Lengkap</label>
                    <input class="modal-control" type="text" placeholder="Masukkan nama lengkap siswa" required />
                </div>
                <div class="form-group-modal">
                    <label class="modal-label">Username</label>
                    <input class="modal-control" type="text" placeholder="Contoh: aditya_pratama" required />
                </div>
                <div class="form-group-modal">
                    <label class="modal-label">Password Bawaan</label>
                    <input class="modal-control" type="password" placeholder="Masukkan password awal akun siswa"
                        required />
                </div>
                <div class="form-group-modal">
                    <label class="modal-label">No. WhatsApp</label>
                    <div class="modal-input-icon-wrapper">
                        <span class="modal-input-prefix">+62</span>
                        <input class="modal-control modal-input-with-prefix" type="tel" placeholder="81234567890"
                            required />
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
                <button class="btn-close-modal" onclick="closeEditModal()">
                    <span class="material-symbols-outlined">close</span>
                </button>
            </div>
            <form class="modal-body space-y-modal-form" onsubmit="event.preventDefault(); closeEditModal();">

                <input type="hidden" id="edit-id" name="id">

                <div class="form-group-modal">
                    <label class="modal-label">Nama Lengkap</label>
                    <input class="modal-control" id="edit-nama" type="text" required />
                </div>
                <div class="form-group-modal">
                    <label class="modal-label">Username</label>
                    <input class="modal-control" id="edit-username" type="text" required />
                </div>
                <div class="form-group-modal">
                    <label class="modal-label">No. WhatsApp</label>
                    <div class="modal-input-icon-wrapper">
                        <span class="modal-input-prefix">+62</span>
                        <input class="modal-control modal-input-with-prefix" id="edit-whatsapp" type="tel" required />
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
        const modal = document.getElementById('add-student-modal');
        const modalContainer = document.getElementById('modal-container');

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

        function openDeleteConfirmation(studentName) {
            alert(`Konsep Soft-Delete:\nAkun "${studentName}" akan diubah status menjadi nonaktif (pindah) agar riwayat pembayaran kas sebelumnya di database tidak hilang.`);
        }

        modal.addEventListener('click', (e) => {
            if (e.target === modal) closeAddModal();
        });
        const editModal = document.getElementById('edit-student-modal');
        const editModalContainer = document.getElementById('edit-modal-container');

        // Fungsi Utama untuk Membuka Modal Edit dan Mengisi Data Langsung
        function openEditModal(id, nama, username, whatsapp) {
            // 1. Masukkan data dari tabel ke dalam field input modal
            document.getElementById('edit-id').value = id;
            document.getElementById('edit-nama').value = nama;
            document.getElementById('edit-username').value = username;
            document.getElementById('edit-whatsapp').value = whatsapp;

            // 2. Jalankan animasi pop-up modal
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

        // Menutup modal jika area luar diklik
        editModal.addEventListener('click', (e) => {
            if (e.target === editModal) closeEditModal();
        });
    </script>
</body>

</html>