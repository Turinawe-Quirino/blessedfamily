<?php
require_once 'flash.php';

$_SESSION = [];
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}
session_destroy();

setFlash('success', 'Logged out successfully.');
header("Location: admin_login.php");
exit;
?>
