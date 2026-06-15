<?php
// flash.php — Reusable flash message system
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

function setFlash($type, $message) {
    $_SESSION['flash'] = ['type' => $type, 'message' => $message];
}

function showFlash() {
    if (isset($_SESSION['flash'])) {
        $flash = $_SESSION['flash'];
        $color = match($flash['type']) {
            'success' => '#28a745',
            'error' => '#dc3545',
            'warning' => '#ffc107',
            default => '#007bff',
        };
        echo "<div style='background:$color;color:white;padding:10px;border-radius:6px;margin:10px 0;text-align:center;'>";
        echo htmlspecialchars($flash['message']);
        echo "</div>";
        unset($_SESSION['flash']);
    }
}
?>
