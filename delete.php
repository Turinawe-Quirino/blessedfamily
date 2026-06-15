<?php
session_start();

// Only allow admin to delete
if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] !== true) {
    header("Location: gallery.php?delete=error&msg=unauthorized");
    exit;
}

// Ensure both 'section' and 'file' parameters exist
if (isset($_GET['section']) && isset($_GET['file'])) {
    $section = basename($_GET['section']); // prevents directory traversal
    $file = basename($_GET['file']);       // prevents directory traversal

    // ✅ Correct path based on your folder structure
    $filePath = __DIR__ . "/uploads/$section/$file";

    if (file_exists($filePath)) {
        // Attempt to delete
        if (unlink($filePath)) {
            header("Location: gallery.php?delete=success");
            exit;
        } else {
            header("Location: gallery.php?delete=error&msg=delete_failed");
            exit;
        }
    } else {
        header("Location: gallery.php?delete=error&msg=file_not_found");
        exit;
    }
} else {
    header("Location: gallery.php?delete=error&msg=missing_params");
    exit;
}
?>