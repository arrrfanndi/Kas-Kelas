<?php
// backend/proses_login.php
require_once '../config/koneksi.php';
require_once '../config/autentikasi.php'; // Menyertakan sistem session global

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if (empty($username) || empty($password)) {
        die("Username dan Password wajib diisi! <a href='../login.php'>Kembali</a>");
    }

    try {
        // Poin 3: Prepared Statement mencegah SQL Injection via Form Login
        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username");
        $stmt->execute(['username' => $username]);
        $user = $stmt->fetch();

        // Poin 3: Password Hashing Verifier untuk mencocokkan password terenkripsi
        if ($user && password_verify($password, $user['password'])) {
            
            // Poin 1: Menetapkan Session Identitas Pengguna
            $_SESSION['user_id']  = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role']     = $user['role']; // Hak akses (misal: 'bendahara' atau 'siswa')

            header("Location: ../dashboard.php");
            exit;
        } else {
            echo "<script>alert('Username atau Password salah!'); window.location.href = '../login.php';</script>";
            exit;
        }
    } catch (PDOException $e) {
        die("Terjadi kesalahan sistem: " . $e->getMessage());
    }
} else {
    header("Location: ../login.php");
    exit;
}
?>
