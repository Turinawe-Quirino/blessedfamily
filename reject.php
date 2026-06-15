<?php
if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] !== true) {
    header("Location: admin_login.php");
    exit;
}

if (isset($_GET['section']) && isset($_GET['file'])) {
    $section = $_GET['section'];
    $file = $_GET['file'];
    $filePath = __DIR__ . "/uploads/pending/$section/$file";

    if (file_exists($filePath)) {
        unlink($filePath);
        header("Location: admin_approval.php?status=rejected");
        exit;
    } else {
        header("Location: admin_approval.php?status=error&msg=file_not_found");
        exit;
    }
} else {
    header("Location: admin_approval.php?status=error&msg=missing_params");
    exit;
}
?>
