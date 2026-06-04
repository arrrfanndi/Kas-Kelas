<?php
require_once '../../../Backend/User/Logic_user_tagihan.php'
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kasqeu - Siswa - Tagihan</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="../Css/user_dashboard.css">
    <link rel="stylesheet" href="../Css/user_tagihan.css">
</head>

<body>

    <header class="navbar">
        <div class="nav-container">
            <div class="nav-left">
                <span class="logo">Kasqeu</span>
                <nav class="nav-links">
                    <a href="user_dashboard.php">Dashboard</a>
                    <a href="user_riwayat.php">Riwayat</a>
                    <a href="" class="active">Tagihan</a>
                </nav>
            </div>
            <div class="nav-right">
                <div class="user-info">
                    <span class="user-name"><?= htmlspecialchars($nama) ?></span>
                    <span class="user-role">Siswa</span>
                </div>
                <div class="avatar-box"><?= $inisial ?></div>
                <button class="btn-logout" onclick="window.location.href='/config/logout.php'">
                    <span class="material-symbols-outlined">logout</span>
                    <span>Logout</span>
                </button>
            </div>
        </div>
    </header>

    <main class="main-content">
        
        <section class="welcome-section">
            <h1>Tagihan Kas Saya</h1>
            <p>Audit personal untuk melihat kewajiban kas mingguan Anda dan status pembayaran terkini.</p>
        </section>

        <div class="alert-status-container">
            <div class="alert-status-card">
                <div class="alert-status-left">
                    <?php if ($my_tagihan > 0): ?>
                        <span class="material-symbols-outlined icon-alert">warning</span>
                        <div class="alert-status-text">
                            <p class="alert-status-label">Status Pembayaran</p>
                            <h2>Menunggak <?= $minggu_tunggakan ?> Minggu (Rp <?= number_format($my_tagihan, 0, ',', '.') ?>)</h2>
                        </div>
                    <?php else: ?>
                        <span class="material-symbols-outlined icon-alert">check_circle</span>
                        <div class="alert-status-text">
                            <p class="alert-status-label">Status Pembayaran</p>
                            <h2>Seluruh Tagihan Lunas (Rp 0)</h2>
                        </div>
                    <?php endif; ?>
                </div>
                <button class="btn-alert-action" onclick="window.open('<?= $link_wa ?>', '_blank')">Hubungi Bendahara</button>
            </div>
            <p class="alert-status-note">* Kotak ini akan berubah menjadi hijau setelah seluruh tunggakan diverifikasi oleh admin.</p>
        </div>

        <section class="table-section">
            <div class="table-header">
                <div class="table-title-wrapper">
                    <span class="material-symbols-outlined text-gold">event_note</span>
                    <h2>Detail Tagihan Per Minggu</h2>
                </div>
            </div>

            <div class="table-responsive">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Minggu Ke</th>
                            <th>Batas Waktu (Jatuh Tempo)</th>
                            <th>Nominal Wajib</th>
                            <th>Status Kamu</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($list_tagihan)): ?>
                            <tr>
                                <td colspan="4" class="text-center" style="padding: 24px; color: #9ca3af;">Belum ada data tagihan iuran kas yang diatur.</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($list_tagihan as $row): 
                                $tgl_format = ($row['deadline']) ? date('d M Y', strtotime($row['deadline'])) : '-';
                                $is_lunas   = ($row['status'] === 'lunas');
                                $badge_class = $is_lunas ? 'badge-success' : 'badge-error';
                                $icon_badge  = $is_lunas ? 'check_circle' : 'error';
                                $text_badge  = $is_lunas ? 'Lunas' : 'Belum Bayar';
                            ?>
                                <tr>
                                    <td class="font-semibold">Minggu <?= $row['minggu_ke'] ?></td>
                                    <td><?= $tgl_format ?></td>
                                    <td>Rp <?= number_format($row['nominal'], 0, ',', '.') ?></td>
                                    <td>
                                        <span class="badge <?= $badge_class ?>">
                                            <span class="material-symbols-outlined icon-badge"><?= $icon_badge ?></span><?= $text_badge ?>
                                        </span>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </section>

        <section class="support-section">
            <p>Memiliki pertanyaan mengenai catatan tagihan Anda?</p>
            <div class="support-buttons">
                <button class="btn-support-primary" onclick="window.open('<?= $link_wa ?>', '_blank')">
                    <span class="material-symbols-outlined">chat_bubble</span>
                    <span>Tanya Bendahara</span>
                </button>
                <button class="btn-support-outline" onclick="window.location.href='cetak_tagihan_pdf.php'">
                    <span class="material-symbols-outlined">description</span>
                    <span>Unduh Rekap PDF</span>
                </button>
            </div>
        </section>

        <footer class="main-footer">
            <p>© 2026 Kasqeu. Kelompok 14.</p>
        </footer>
    </main>

    <nav class="mobile-nav">
        <a href="user_dashboard.php" class="mobile-nav-link">
            <span class="material-symbols-outlined">dashboard</span>
            <span>Dashboard</span>
        </a>
        <a href="user_riwayat.php" class="mobile-nav-link">
            <span class="material-symbols-outlined">history</span>
            <span>Riwayat</span>
        </a>
        <a href="#" class="mobile-nav-link active">
            <span class="material-symbols-outlined icon-fill">payments</span>
            <span>Tagihan</span>
        </a>
    </nav>

    <script>
        // Efek animasi mikro saat baris tabel diklik
        document.querySelectorAll('tbody tr').forEach(row => {
            row.addEventListener('click', () => {
                row.style.backgroundColor = 'rgba(237, 210, 0, 0.08)';
                setTimeout(() => {
                    row.style.backgroundColor = '';
                }, 300);
            });
        });
    </script>
</body>

</html>