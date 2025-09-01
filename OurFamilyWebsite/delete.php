<?php
if (isset($_GET['section']) && isset($_GET['file'])) {
    $section = $_GET['section'];
    $file = $_GET['file'];

    // Build full path
    $filePath = __DIR__ . "/uploads/$section/$file";

    if (file_exists($filePath)) {
        unlink($filePath); // Delete the file
        header("Location: gallery.php?delete=success");
        exit;
    } else {
        header("Location: gallery.php?delete=error&msg=file_not_found");
        exit;
    }
} else {
    header("Location: gallery.php?delete=error&msg=missing_params");
    exit;
}
?>
