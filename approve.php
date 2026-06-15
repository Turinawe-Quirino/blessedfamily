<?php
require_once "flash.php";
session_start();

if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] !== true) {
    setFlash('error', 'Unauthorized access.');
    header("Location: admin_login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['section'], $_POST['file'])) {
    $section = $_POST['section'];
    $file = $_POST['file'];
    $pendingPath = __DIR__ . "/uploads/pending/$section/$file";

    if (!file_exists($pendingPath)) {
        setFlash('error', 'File not found.');
        header("Location: admin_approval.php");
        exit;
    }

    if (isset($_POST['approve'])) {
        $targetDir = __DIR__ . "/uploads/$section/";
        if (!is_dir($targetDir)) mkdir($targetDir, 0777, true);
        rename($pendingPath, $targetDir . $file);
        setFlash('success', "$file approved successfully.");
    } elseif (isset($_POST['reject'])) {
        unlink($pendingPath);
        setFlash('warning', "$file rejected and deleted.");
    }
}

header("Location: admin_approval.php");
exit;
?>
