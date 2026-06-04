<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kasqeu - Admin - Input Transaksi</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">

    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap"
        rel="stylesheet">

    <link rel="stylesheet" href="../../User/Css/user_dashboard.css">
    <link rel="stylesheet" href="../Css/dashboard_admin.css">
    <link rel="stylesheet" href="../Css/inputTransaksi_admin.css">
</head>

<body>
    <header class="navbar">
        <div class="nav-container">
            <div class="nav-left">
                <span class="logo">Kasqeu</span>
                <nav class="nav-links">
                    <a href="dashboard_admin.php">Dashboard</a>
                    <a href="#" class="active">Input Transaksi</a>
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
            <h1>Input Transaksi Baru</h1>
            <p>Catat pemasukan dan pengeluaran kas kita dengan akurat.</p>
        </section>
        <div class="input-grid-container">

            <section class="form-card-main">
                <div class="form-tabs-header">
                    <button class="tab-btn active-tab" id="tab-pemasukan" onclick="switchTab('pemasukan')">
                        <span class="material-symbols-outlined">arrow_downward</span>
                        <span>Pemasukan (Kas Masuk)</span>
                    </button>
                    <button class="tab-btn" id="tab-pengeluaran" onclick="switchTab('pengeluaran')">
                        <span class="material-symbols-outlined">arrow_upward</span>
                        <span>Pengeluaran (Kas Keluar)</span>
                    </button>
                </div>

                <div class="form-wrapper-padding">

                    <div class="tab-content active" id="content-pemasukan">
                        <form class="space-y-form">
                            <div class="form-row-twin">
                                <div class="form-group">
                                    <label class="form-label">Nama Siswa</label>
                                    <select class="form-control form-select">
                                        <option value="">Pilih Siswa</option>
                                        <option value="1">Adit Pratama</option>
                                        <option value="2">Budi Santoso</option>
                                        <option value="3">Citra Lestari</option>
                                        <option value="4">Dewi Anggraini</option>
                                        <option value="5">Eko Wahyudi</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Minggu Ke</label>
                                    <select class="form-control form-select" id="minggu-pilih">
                                        <option value="1">Minggu 1</option>
                                        <option value="2">Minggu 2</option>
                                        <option value="3">Minggu 3</option>
                                        <option value="4">Minggu 4</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="form-label">Nominal (Rp)</label>
                                <div class="input-icon-wrapper">
                                    <span class="input-prefix">Rp</span>
                                    <input class="form-control form-input-with-prefix" type="number" value="5000"
                                        placeholder="5003">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="form-label">Keterangan</label>
                                <input class="form-control" id="ket-pemasukan" type="text" value="Bayar Kas Minggu 1"
                                    placeholder="Contoh: Pembayaran Lunas">
                            </div>

                            <div class="form-action-btn-box">
                                <button class="btn-submit-primary" type="button">
                                    <span class="material-symbols-outlined">save</span>
                                    <span>Simpan Pemasukan</span>
                                </button>
                            </div>
                        </form>
                    </div>

                    <div class="tab-content" id="content-pengeluaran">
                        <form class="space-y-form">
                            <div class="form-group">
                                <label class="form-label">Nama Pengeluaran</label>
                                <input class="form-control" type="text" placeholder="Contoh: Beli Sapu atau Kertas HVS">
                            </div>

                            <div class="form-group">
                                <label class="form-label">Nominal Pengeluaran (Rp)</label>
                                <div class="input-icon-wrapper">
                                    <span class="input-prefix">Rp</span>
                                    <input class="form-control form-input-with-prefix" type="number"
                                        placeholder="Masukkan jumlah dana keluar">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="form-label">Keterangan / Keperluan</label>
                                <textarea class="form-control form-textarea" rows="4"
                                    placeholder="Deskripsikan tujuan pengeluaran..."></textarea>
                            </div>

                            <div class="form-action-btn-box">
                                <button class="btn-submit-error" type="button">
                                    <span class="material-symbols-outlined">upload_file</span>
                                    <span>Simpan Pengeluaran</span>
                                </button>
                            </div>
                        </form>
                    </div>

                </div>
            </section>
            <aside class="sidebar-layout">
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
                    <div class="guidelines-card">
                        <div class="guidelines-title-box">
                            <span class="material-symbols-outlined">info</span>
                            <h3>Panduan Input</h3>
                        </div>
                        <ul class="guidelines-list">
                            <li class="guideline-item">
                                <div class="guideline-number">01</div>
                                <p>Pilih <strong class="text-dark">Nama Siswa</strong> sesuai daftar presensi kelas.</p>
                            </li>
                            <li class="guideline-item">
                                <div class="guideline-number">02</div>
                                <p>Pilih <strong class="text-dark">Minggu Ke</strong> untuk menandai periode iuran.</p>
                            </li>
                            <li class="guideline-item">
                                <div class="guideline-number">03</div>
                                <p>Klik <strong class="text-dark">Simpan</strong> dan pastikan pesan sukses muncul.</p>
                            </li>
                        </ul>
                    </div>
            </aside>
</body>
<script>
    function switchTab(type) {
        const tabPemasukan = document.getElementById('tab-pemasukan');
        const tabPengeluaran = document.getElementById('tab-pengeluaran');
        const contentPemasukan = document.getElementById('content-pemasukan');
        const contentPengeluaran = document.getElementById('content-pengeluaran');

        if (type === 'pemasukan') {
            tabPemasukan.classList.add('active-tab');
            contentPemasukan.classList.add('active');
            tabPengeluaran.classList.remove('active-tab');
            contentPengeluaran.classList.remove('active');
        } else {
            tabPengeluaran.classList.add('active-tab');
            contentPengeluaran.classList.add('active');
            tabPemasukan.classList.remove('active-tab');
            contentPemasukan.classList.remove('active');
        }
    }

    document.getElementById('minggu-pilih').addEventListener('change', function (e) {
        const val = e.target.value;
        document.getElementById('ket-pemasukan').value = "Bayar Kas Minggu " + val;
    });

    document.querySelectorAll('button[type="button"]').forEach(btn => {
        btn.addEventListener('click', () => {
            const toast = document.getElementById('toast');
            toast.classList.add('show');

            setTimeout(() => {
                toast.classList.remove('show');
            }, 3000);
        });
    });
</script>

</html>