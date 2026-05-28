<?php
// backend/proses_login.php
session_start();
require_once '../config/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if (empty($username) || empty($password)) {
        die("Semua form wajib diisi! <a href='../login.php'>Kembali</a>");
    }

    try {
        // Poin 3: Prepared Statement untuk mencegah SQL Injection
        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username");
        $stmt->execute(['username' => $username]);
        $user = $stmt->fetch();

        // Poin 3: Password Hashing Verifier (menerjemahkan password_hash)
        if ($user && password_verify($password, $user['password'])) {
            
            // Poin 1: Mengatur Session PHP
            $_SESSION['user_id']  = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role']     = $user['role']; // Hak akses (misal: 'bendahara')

            header("Location: ../dashboard.php");
            exit;
        } else {
            echo "<script>alert('Username/Password salah!'); window.location.href='../login.php';</script>";
            exit;
        }
    } catch (PDOException $e) {
        die("Error: " . $e->getMessage());
    }
}
?>