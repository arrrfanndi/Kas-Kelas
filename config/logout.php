<?php
session_start();

// 1. Hapus semua variabel session
session_unset();

// 2. Hapus cookie session dari browser
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// 3. Hancurkan session di server
session_destroy();

// 4. Redirect ke halaman login
header("Location: /frontend/Login/halamanLogin.php");
exit;
?>