<?php
session_start();
require_once  'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    try {
        // CEK ADMIN
        $stmt_admin = $koneksi->prepare("SELECT * FROM admin WHERE username = :username");
        $stmt_admin->execute([':username' => $username]);
        $admin = $stmt_admin->fetch(PDO::FETCH_ASSOC);

        if ($admin) {
            if ($password == $admin['password']) {
                $_SESSION['login']   = true;
                $_SESSION['user_id'] = $admin['id'];
                $_SESSION['nama']    = $admin['nama'];
                $_SESSION['role']    = 'admin';

                header("Location: /frontend/Admin/Html/dashboard_admin.php");
                exit;
            }
        }

        // CEK SISWA
        $stmt_siswa = $koneksi->prepare("SELECT * FROM siswa WHERE username = :username AND status = 'aktif'");
        $stmt_siswa->execute([':username' => $username]);
        $siswa = $stmt_siswa->fetch(PDO::FETCH_ASSOC);

        if ($siswa) {
            if ($password == $siswa['password']) {
                $_SESSION['login']   = true;
                $_SESSION['user_id'] = $siswa['id'];
                $_SESSION['nama']    = $siswa['nama'];
                $_SESSION['role']    = 'siswa';

                header("Location: /frontend/User/Html/user_dashboard.php");
                exit;
            }
        }

        // LOGIN GAGAL
        echo "<script>
                alert('Username atau Password salah, atau akun Anda sudah tidak aktif!');
                window.location.href = '/Login/halamanLogin.php';
              </script>";
    } catch (PDOException $e) {
        die("Terjadi kesalahan sistem: " . $e->getMessage());
    }
} else {
    header("Location: frontend/Login/halamanLogin.php");
    exit;
}
