<?php
// Config/proses_transaksi.php
session_start();

// Proteksi keamanan: pastikan hanya admin log-in yang bisa memproses data
if (!isset($_SESSION['login']) || $_SESSION['role'] !== 'admin') {
    header("Location: /frontend/Login/halamanLogin.php");
    exit;
}

require_once 'koneksi.php';

// ==========================================
// PROSES PEMASUKAN (KAS MASUK)
// ==========================================
if (isset($_POST['submit_pemasukan'])) {
    $siswa_id = $_POST['siswa_id'] ?? '';
    $periode_kas_id = $_POST['periode_kas_id'] ?? '';
    // Note: Nominal kas otomatis mengikuti nominal settingan periode_kas sesuai logic sistem Anda

    // Validasi akhir di sisi server (Back-end Validation) jika user lolos dari required HTML
    if (empty($siswa_id) || empty($periode_kas_id)) {
        header("Location: ../frontend/Admin/Html/inputTransaksi_admin.php?status=error");
        exit;
    }

    try {
        // Cek apakah data tagihan sudah ada di tabel tagihan_kas
        $check_query = "SELECT id FROM tagihan_kas WHERE siswa_id = :siswa_id AND periode_kas_id = :periode_kas_id";
        $stmt_check = $koneksi->prepare($check_query);
        $stmt_check->execute([
            ':siswa_id' => $siswa_id,
            ':periode_kas_id' => $periode_kas_id
        ]);

        if ($stmt_check->fetch()) {
            // Jika record sudah ada, ubah statusnya menjadi lunas
            $query = "UPDATE tagihan_kas SET status = 'lunas', tanggal_bayar = NOW() 
                      WHERE siswa_id = :siswa_id AND periode_kas_id = :periode_kas_id";
        } else {
            // Jika record belum ada (untuk minggu baru), masukkan data baru dengan status lunas
            $query = "INSERT INTO tagihan_kas (siswa_id, periode_kas_id, status, tanggal_bayar) 
                      VALUES (:siswa_id, :periode_kas_id, 'lunas', NOW())";
        }

        $stmt = $koneksi->prepare($query);
        $result = $stmt->execute([
            ':siswa_id' => $siswa_id,
            ':periode_kas_id' => $periode_kas_id
        ]);

        if ($result) {
            header("Location: ../frontend/Admin/Html/inputTransaksi_admin.php?status=success");
        } else {
            header("Location: ../frontend/Admin/Html/inputTransaksi_admin.php?status=error");
        }
        exit;
    } catch (PDOException $e) {
        // Jika gagal karena error database
        header("Location: ../frontend/Admin/Html/inputTransaksi_admin.php?status=error");
        exit;
    }
}

// ==========================================
// PROSES PENGELUARAN (KAS KELUAR)
// ==========================================
if (isset($_POST['submit_pengeluaran'])) {
    $kategori = trim($_POST['kategori'] ?? '');
    $nominal = intval($_POST['nominal'] ?? 0);
    $keterangan = trim($_POST['keterangan'] ?? '');

    if (empty($kategori) || $nominal <= 0 || empty($keterangan)) {
        header("Location: ../frontend/Admin/Html/inputTransaksi_admin.php?status=error");
        exit;
    }

    try {
        $query = "INSERT INTO pengeluaran_kas (tanggal, kategori, nominal, keterangan) 
          VALUES (NOW(), :kategori, :nominal, :keterangan)";

        $stmt = $koneksi->prepare($query);
        $result = $stmt->execute([
            ':kategori' => $kategori,
            ':nominal' => $nominal,
            ':keterangan' => $keterangan
        ]);

        if ($result) {
            header("Location: ../frontend/Admin/Html/inputTransaksi_admin.php?status=success");
        } else {
            header("Location: ../frontend/Admin/Html/inputTransaksi_admin.php?status=error");
        }
        exit;
    } catch (PDOException $e) {
        header("Location: ../frontend/Admin/Html/inputTransaksi_admin.php?status=error");
        exit;
    }
}

// Jika file diakses langsung tanpa submit form
header("Location: ../frontend/Admin/Html/inputTransaksi_admin.php");
exit;
