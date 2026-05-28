<?php
// backend/proses_update_kas.php
require_once '../config/koneksi.php';
require_once '../config/autentikasi.php';

proteksi_halaman();
cek_akses_bendahara(); // Poin 1: Pastikan hanya bendahara yang boleh mengubah data

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id         = $_POST['id']; 
    $siswa_id   = $_POST['siswa_id'];
    $jenis      = $_POST['jenis'];
    $jumlah     = $_POST['jumlah'];
    $keterangan = trim($_POST['keterangan']);

    // Validasi Input
    $errors = [];
    if (!filter_var($id, FILTER_VALIDATE_INT)) {
        $errors[] = "ID Transaksi tidak valid atau rusak.";
    }
    if (!in_array($jenis, ['masuk', 'keluar'])) {
        $errors[] = "Jenis transaksi tidak valid.";
    }
    if (!filter_var($jumlah, FILTER_VALIDATE_INT) || $jumlah <= 0) {
        $errors[] = "Jumlah nominal uang baru harus angka positif.";
    }
    if (empty($keterangan)) {
        $errors[] = "Keterangan perubahan tidak boleh kosong.";
    }

    if (empty($errors)) {
        try {
            // Poin 3: Prepared Statement proses UPDATE data kas
            $sql = "UPDATE kas_transaksi 
                    SET siswa_id = :siswa_id, jenis = :jenis, jumlah = :jumlah, keterangan = :keterangan 
                    WHERE id = :id";
            
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                'siswa_id'   => !empty($siswa_id) ? $siswa_id : null,
                'jenis'      => $jenis,
                'jumlah'     => $jumlah,
                'keterangan' => $keterangan,
                'id'         => $id
            ]);

            header("Location: ../dashboard.php?status=sukses_ubah");
            exit;
        } catch (PDOException $e) {
            die("Gagal memperbarui database: " . $e->getMessage());
        }
    } else {
        $pesan = implode("\\n", $errors);
        echo "<script>alert('$pesan'); window.history.back();</script>";
        exit;
    }
}
?>
