<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['fileToUpload'])) {

    $section = $_POST['section']; // images, videos, audios

    // ===============================
    // 1. Build target folder path
    // ===============================
    $targetDir = __DIR__ . DIRECTORY_SEPARATOR . "uploads" . DIRECTORY_SEPARATOR . $section . DIRECTORY_SEPARATOR;

    // Check folder exists
    if (!is_dir($targetDir)) {
        // Redirect back with error if folder missing
        header("Location: gallery.php?upload=error&msg=folder_missing");
        exit;
    }

    // ===============================
    // 2. Prepare file
    // ===============================
    $fileName = basename($_FILES["fileToUpload"]["name"]);
    $targetFile = $targetDir . $fileName;

    // Detect file type (case-insensitive)
    $fileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

    // Allowed file types
    $allowed = [
        "images" => ["jpg","jpeg","png","gif"],
        "videos" => ["mp4","webm","ogg"],
        "audios" => ["mp3","wav","ogg"]
    ];

    // ===============================
    // 3. Validate and upload
    // ===============================
    if (isset($allowed[$section]) && in_array($fileType, $allowed[$section])) {
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $targetFile)) {
            // Success → redirect to gallery.php
            header("Location: gallery.php?upload=success");
            exit;
        } else {
            // Upload failed
            header("Location: gallery.php?upload=error&msg=move_failed");
            exit;
        }
    } else {
        // Invalid file type
        header("Location: gallery.php?upload=error&msg=invalid_type");
        exit;
    }

} else {
    // No file uploaded
    header("Location: gallery.php?upload=error&msg=no_file");
    exit;
}
?>
