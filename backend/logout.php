<?php
// backend/logout.php
require_once '../config/autentikasi.php';

// Poin 1: Menghancurkan seluruh data session yang tersimpan di server
$_SESSION = array();

if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"], $params["secure"], $params["httponly"]
    );
}

session_destroy();

// Redirect kembali ke gerbang login luar
header("Location: ../login.php");
exit;
?>
