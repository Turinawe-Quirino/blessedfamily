<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['fileToUpload'])) {

    $section = $_POST['section']; // images, videos, audios

    // Target directory → pending
    $targetDir = __DIR__ . "/uploads/pending/$section/";

    if (!is_dir($targetDir)) {
        header("Location: gallery.php?upload=error&msg=folder_missing");
        exit;
    }

    $fileName = basename($_FILES["fileToUpload"]["name"]);
    $fileType = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

    // Allowed extensions
    $allowed = [
        "images" => ["jpg","jpeg","png","gif"],
        "videos" => ["mp4","webm","ogg"],
        "audios" => ["mp3","wav","ogg"]
    ];

    // Validate file type
    if (!isset($allowed[$section]) || !in_array($fileType, $allowed[$section])) {
        header("Location: gallery.php?upload=error&msg=invalid_type");
        exit;
    }

    // Rename file to prevent collisions
    $newName = uniqid("file_", true) . "." . $fileType;
    $targetFile = $targetDir . $newName;

    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $targetFile)) {
        header("Location: gallery.php?upload=pending");
        exit;
    } else {
        header("Location: gallery.php?upload=error&msg=move_failed");
        exit;
    }
} else {
    header("Location: gallery.php?upload=error&msg=no_file");
    exit;
}
?>
