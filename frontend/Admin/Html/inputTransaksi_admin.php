<?php
require_once '../../../Backend/Admin/Logic_inputTransaksi_admin.php';
?>

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
                    <span class="user-name"><?= htmlspecialchars($nama) ?></span>
                    <span class="user-role">Admin</span>
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

        <section class="welcome-section">
            <h1>Input Transaksi Baru</h1>
            <p>Catat pemasukan dan pengeluaran kas kita dengan akurat.</p>
        </section>

        <?php if (isset($_GET['status']) && $_GET['status'] == 'success'): ?>
            <div style="background-color: rgba(16, 185, 129, 0.15); color: #10b981; padding: 12px 20px; border-radius: 8px; margin-bottom: 20px; font-weight: 500;">
                Transaksi berhasil disimpan ke dalam database!
            </div>
        <?php elseif (isset($_GET['status']) && $_GET['status'] == 'error'): ?>
            <div style="background-color: rgba(239, 68, 68, 0.15); color: #ef4444; padding: 12px 20px; border-radius: 8px; margin-bottom: 20px; font-weight: 500;">
                Gagal memproses transaksi. Silakan periksa kembali inputan Anda.
            </div>
        <?php endif; ?>

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
                        <form action="/config/proses_transaksi.php" method="POST" class="space-y-form">
                            <div class="form-row-twin">
                                <div class="form-group">
                                    <label class="form-label">Nama Siswa</label>
                                    <select class="form-control form-select" name="siswa_id" required>
                                        <option value="">Pilih Siswa</option>
                                        <?php foreach ($list_siswa as $siswa): ?>
                                            <option value="<?= $siswa['id'] ?>"><?= htmlspecialchars($siswa['nama']) ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Minggu Ke</label>
                                    <select class="form-control form-select" id="minggu-pilih" name="periode_kas_id" required disabled>
                                        <option value="">Pilih Siswa Terlebih Dahulu</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="form-label">Nominal (Rp)</label>
                                <div class="input-icon-wrapper">
                                    <span class="input-prefix">Rp</span>
                                    <input class="form-control form-input-with-prefix" type="number" name="nominal" id="nominal-pemasukan" value="0" readonly required>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="form-label">Keterangan</label>
                                <input class="form-control" id="ket-pemasukan" type="text" name="keterangan" value="Bayar Kas" placeholder="Contoh: Pembayaran Lunas">
                            </div>

                            <div class="form-action-btn-box">
                                <button class="btn-submit-primary" type="submit" name="submit_pemasukan">
                                    <span class="material-symbols-outlined">save</span>
                                    <span>Simpan Pemasukan</span>
                                </button>
                            </div>
                        </form>
                    </div>

                    <div class="tab-content" id="content-pengeluaran">
                        <form action="/config/proses_transaksi.php" method="POST" class="space-y-form">
                            <div class="form-group">
                                <label class="form-label">Nama Pengeluaran / Kategori</label>
                                <input class="form-control" type="text" name="kategori" placeholder="Contoh: Beli Sapu atau Kertas HVS" required>
                            </div>

                            <div class="form-group">
                                <label class="form-label">Nominal Pengeluaran (Rp)</label>
                                <div class="input-icon-wrapper">
                                    <span class="input-prefix">Rp</span>
                                    <input class="form-control form-input-with-prefix" type="number" name="nominal" placeholder="Masukkan jumlah dana keluar" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="form-label">Keterangan / Keperluan</label>
                                <textarea class="form-control form-textarea" rows="4" name="keterangan" placeholder="Deskripsikan tujuan pengeluaran..." required></textarea>
                            </div>

                            <div class="form-action-btn-box">
                                <button class="btn-submit-error" type="submit" name="submit_pengeluaran">
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
                        <h3 class="card-value">Rp <?= number_format($saldo_kelas, 0, ',', '.') ?></h3>

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
        </div>
    </main>
</body>
<script>
    // 1. Fungsi bawaan untuk memindahkan tab Pemasukan / Pengeluaran
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

    // 2. Deklarasi elemen HTML yang dibutuhkan
    const selectSiswa = document.querySelector('select[name="siswa_id"]');
    const selectMinggu = document.getElementById('minggu-pilih');
    const inputKeterangan = document.getElementById('ket-pemasukan');
    const inputNominal = document.getElementById('nominal-pemasukan'); // Elemen input nominal readonly

    // Variabel global untuk menyimpan data periode (termasuk nominalnya) sementara di browser
    let dataPeriodeGlobal = [];

    // 3. Event handler ketika admin memilih/mengubah Nama Siswa
    selectSiswa.addEventListener('change', function() {
        const siswaId = this.value;

        // Reset dropdown minggu, keterangan, dan nominal ke kondisi awal (0)
        selectMinggu.innerHTML = '<option value="">Pilih Minggu</option>';
        inputKeterangan.value = "Bayar Kas";
        inputNominal.value = 0;

        // Jika admin memilih opsi kosong "-- Pilih Siswa --"
        if (siswaId === "") {
            selectMinggu.disabled = true;
            selectMinggu.innerHTML = '<option value="">Pilih Siswa Terlebih Dahulu</option>';
            return;
        }

        // Jalankan Fetch API (AJAX) ke backend untuk mengambil data minggu & nominal
        fetch(`/config/get_minggu_tagihan.php?siswa_id=${siswaId}`)
            .then(response => response.json())
            .then(data => {
                if (data.error) {
                    alert('Sesi habis atau terjadi kesalahan.');
                    return;
                }

                if (data.length === 0) {
                    selectMinggu.disabled = true;
                    selectMinggu.innerHTML = '<option value="">Siswa ini sudah melunasi semua minggu</option>';
                } else {
                    selectMinggu.disabled = false; // Aktifkan dropdown minggu jika ada tagihan
                    selectMinggu.innerHTML = '<option value="">Pilih Minggu</option>';

                    // SIMPAN DATA DARI DATABASE KE VARIABEL GLOBAL AGAR BISA DIBACA ELEMENT LAIN
                    dataPeriodeGlobal = data;

                    // Looping untuk memasukkan daftar minggu ke dalam dropdown
                    data.forEach(periode => {
                        const option = document.createElement('option');
                        option.value = periode.id;
                        option.textContent = `Minggu ${periode.minggu_ke} (${periode.bulan} ${periode.tahun})`;
                        selectMinggu.appendChild(option);
                    });
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Gagal memuat data periode kas.');
            });
    });

    // 4. Event handler ketika admin memilih Minggu Ke
    selectMinggu.addEventListener('change', function(e) {
        const periodeId = e.target.value;
        const selectedText = e.target.options[e.target.selectedIndex].text;

        if (periodeId !== "") {
            // Otomatis isi kotak keterangan
            inputKeterangan.value = "Bayar Kas " + selectedText;

            // CARI DATA NOMINAL BERDASARKAN MINGGU YANG DIPILIH DARI VARIABEL GLOBAL
            const kriteriaPeriode = dataPeriodeGlobal.find(p => p.id == periodeId);
            if (kriteriaPeriode) {
                // Otomatis ubah angka 0 menjadi nominal asli dari database (misal: 10000 atau 5000)
                inputNominal.value = kriteriaPeriode.nominal;
            }
        } else {
            // Kembalikan ke default jika opsi kosong dipilih kembali
            inputKeterangan.value = "Bayar Kas";
            inputNominal.value = 0;
        }
    });
</script>

</html>