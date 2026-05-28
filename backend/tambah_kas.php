<?php
// backend/tambah_kas.php
require_once '../config/koneksi.php';
require_once '../config/autentikasi.php';

proteksi_halaman(); // Jalankan satpam session
cek_akses_bendahara(); // Poin 1: Pastikan hanya bendahara yang bisa input data

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $siswa_id   = $_POST['siswa_id']; 
    $jenis      = $_POST['jenis'];       
    $jumlah     = $_POST['jumlah'];     
    $keterangan = trim($_POST['keterangan']);

    // Validasi Input Sisi Server
    $errors = [];
    if (!in_array($jenis, ['masuk', 'keluar'])) {
        $errors[] = "Jenis transaksi harus 'masuk' atau 'keluar'.";
    }
    if (!filter_var($jumlah, FILTER_VALIDATE_INT) || $jumlah <= 0) {
        $errors[] = "Jumlah uang wajib berupa angka bulat positif.";
    }
    if (empty($keterangan)) {
        $errors[] = "Keterangan transaksi tidak boleh dibiarkan kosong.";
    }

    if (empty($errors)) {
        try {
            // Poin 3: Prepared Statement proses INSERT data kas baru
            $sql = "INSERT INTO kas_transaksi (siswa_id, jenis, jumlah, keterangan, tanggal) 
                    VALUES (:siswa_id, :jenis, :jumlah, :keterangan, NOW())";
            
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                'siswa_id'   => !empty($siswa_id) ? $siswa_id : null,
                'jenis'      => $jenis,
                'jumlah'     => $jumlah,
                'keterangan' => $keterangan
            ]);

            header("Location: ../dashboard.php?status=sukses_tambah");
            exit;
        } catch (PDOException $e) {
            die("Gagal menyimpan ke database: " . $e->getMessage());
        }
    } else {
        $pesan = implode("\\n", $errors);
        echo "<script>alert('$pesan'); window.history.back();</script>";
        exit;
    }
}
?>
