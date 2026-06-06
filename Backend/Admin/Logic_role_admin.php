<?php
// Backend/Admin/Logic_role_admin.php

// A. Hubungkan langsung dengan auth admin sebagai pengaman session dan database (Mundur 2 tingkat)
require_once __DIR__ . '/../../config/auth_admin.php';

// Inisialisasi toast notification status
$show_toast = false;
$toast_message = "";


// ==========================================
// D. LOGIKA FORM TAMBAH SISWA BARU (POST) - DENGAN TAGIHAN MINGGU BERJALAN
// ==========================================
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action_insert'])) {
    $nama_siswa   = trim($_POST['nama']);
    $username     = trim($_POST['username']);
    $no_whatsapp  = trim($_POST['no_whatsapp']);

    // Ambil password inputan, jika kosong beri default '12345'
    $password_raw = isset($_POST['password']) && $_POST['password'] !== '' ? $_POST['password'] : '12345';

    // UBAH DI SINI: Enkripsi password mentah menggunakan BCRYPT sebelum masuk DB
    $password_terenkripsi = password_hash($password_raw, PASSWORD_BCRYPT);

    try {
        $koneksi->beginTransaction();

        // Gunakan variabel $password_terenkripsi di dalam query
        $sqlInsert = "INSERT INTO siswa (nama, username, password, no_whatsapp, status) 
                      VALUES (:nama, :username, :password, :no_whatsapp, 'aktif')";

        $stmtInsert = $koneksi->prepare($sqlInsert);
        $stmtInsert->execute([
            'nama'        => $nama_siswa,
            'username'    => $username,
            'password'    => $password_terenkripsi, // <-- Menggunakan password hash
            'no_whatsapp' => $no_whatsapp
        ]);

        $id_siswa_baru = $koneksi->lastInsertId();

        $queryPeriode = "SELECT id FROM periode_kas WHERE CURDATE() BETWEEN tanggal_mulai AND tanggal_selesai LIMIT 1";
        $stmtPeriode  = $koneksi->query($queryPeriode);
        $periode_berjalan = $stmtPeriode->fetch();

        if ($periode_berjalan) {
            $sqlTagihan = "INSERT INTO tagihan_kas (siswa_id, periode_kas_id, status, tanggal_bayar) 
                           VALUES (:siswa_id, :periode_kas_id, 'belum', NULL)";
            $stmtTagihan = $koneksi->prepare($sqlTagihan);
            $stmtTagihan->execute([
                'siswa_id'       => $id_siswa_baru,
                'periode_kas_id' => $periode_berjalan['id']
            ]);
        }

        $koneksi->commit();

        header("Location: /frontend/Admin/Html/role_admin.php?success=1");
        exit;
    } catch (PDOException $e) {
        $koneksi->rollBack();
        die("Gagal mendaftarkan siswa baru: " . $e->getMessage());
    }
}

// ==========================================
// F. LOGIKA FORM MODAL EDIT / UPDATE (POST)
// ==========================================
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action_update'])) {
    $id          = (int)$_POST['id'];
    $nama_siswa  = trim($_POST['nama']);
    $username    = trim($_POST['username']);
    $no_whatsapp = trim($_POST['no_whatsapp']);

    // Cek apakah admin juga ingin menyetel ulang/mengganti password siswa
    if (isset($_POST['password']) && $_POST['password'] !== '') {
        $password_hash = $_POST['password'];
        $sqlUpdate = "UPDATE siswa 
                      SET nama = :nama, username = :username, no_whatsapp = :no_whatsapp, password = :password 
                      WHERE id = :id";
        $params = [
            'nama'        => $nama_siswa,
            'username'    => $username,
            'no_whatsapp' => $no_whatsapp,
            'password'    => $password_hash,
            'id'          => $id
        ];
    } else {
        $sqlUpdate = "UPDATE siswa 
                      SET nama = :nama, username = :username, no_whatsapp = :no_whatsapp 
                      WHERE id = :id";
        $params = [
            'nama'        => $nama_siswa,
            'username'    => $username,
            'no_whatsapp' => $no_whatsapp,
            'id'          => $id
        ];
    }

    $stmtUpdate = $koneksi->prepare($sqlUpdate);
    if ($stmtUpdate->execute($params)) {
        header("Location: /frontend/Admin/Html/role_admin.php?success=2");
        exit;
    }
}

// ==========================================
// F. PENERAPAN KONSEP SOFT-DELETE (GET Method)
// ==========================================
if (isset($_GET['delete_id'])) {
    $delete_id = (int)$_GET['delete_id'];

    // PROTEKSI INTEGRASI DATA KAS: Mengubah status menjadi 'pindah', dilarang keras pakai DELETE FROM
    $stmtDelete = $koneksi->prepare("UPDATE siswa SET status = 'pindah' WHERE id = :id");
    if ($stmtDelete->execute(['id' => $delete_id])) {
        header("Location: /frontend/Admin/Html/role_admin.php?success=3");
        exit;
    }
}

// Menangkap callback alert sukses untuk memicu Toast
if (isset($_GET['success'])) {
    $show_toast = true;
    if ($_GET['success'] == '1') {
        $toast_message = "Siswa baru berhasil ditambahkan ke kelas!";
    } elseif ($_GET['success'] == '2') {
        $toast_message = "Kredensial profil akun siswa berhasil diperbarui!";
    } elseif ($_GET['success'] == '3') {
        $toast_message = "Siswa berhasil dinonaktifkan dengan status (Pindah).";
    }
}

// ==========================================
// C. KOMPONEN TOTAL SISWA COUNTER (AGREGAT COUNT)
// ==========================================
$total_siswa = $koneksi->query("SELECT COUNT(*) FROM siswa WHERE status = 'aktif'")->fetchColumn();

// ==========================================
// E. KOMPONEN TABEL UTAMA & STRUKTUR QUERY SQL
// ==========================================
$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$sqlData = "SELECT * FROM siswa WHERE status = 'aktif'";
$paramsData = [];

if ($search !== '') {
    $sqlData .= " AND (nama LIKE :search OR username LIKE :search OR no_whatsapp LIKE :search)";
    $paramsData['search'] = '%' . $search . '%';
}
$sqlData .= " ORDER BY nama ASC"; // Diurutkan berdasarkan alfabet nama A-Z

$stmtData = $koneksi->prepare($sqlData);
$stmtData->execute($paramsData);
$list_siswa = $stmtData->fetchAll();
