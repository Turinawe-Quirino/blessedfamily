<?php
function listFiles($section, $pageParam, $perPage = 6) {
    $dir = __DIR__ . "/uploads/$section/";
    $urlPath = "uploads/$section/";

    if (is_dir($dir)) {
        $files = array_values(array_diff(scandir($dir), ['.', '..']));
        $total = count($files);

        $currentPage = isset($_GET[$pageParam]) ? max(1, intval($_GET[$pageParam])) : 1;
        $start = ($currentPage - 1) * $perPage;
        $slice = array_slice($files, $start, $perPage);

        foreach ($slice as $file) {
            $safeFile = htmlspecialchars($file, ENT_QUOTES);
            $path = $urlPath . $safeFile . "?t=" . time();

            echo "<div class='file-card'>";
            if ($section == "images") {
                echo "<img src='$path' alt='Image' />";
            } elseif ($section == "videos") {
                echo "<video controls><source src='$path'></video>";
            } elseif ($section == "audios") {
                echo "<audio controls><source src='$path'></audio>";
            }

            echo "<div class='file-actions'>
                    <a href='$urlPath$safeFile' download>Download</a>";

            // Only Admin can delete
            if (isset($_SESSION['is_admin']) && $_SESSION['is_admin'] === true) {
                echo " <a href='delete.php?section=" . urlencode($section) . "&file=" . urlencode($safeFile) . "' onclick='return confirm(\"Delete this file?\");'>Delete</a>";
            }

            echo "</div></div>";
        }

        // Pagination
        $totalPages = ceil($total / $perPage);
        echo "<div class='pagination'>";
        if ($currentPage > 1) {
            echo "<a href='?{$pageParam}=" . ($currentPage - 1) . "#$section' class='btn'>Prev</a> ";
        }
        if ($currentPage < $totalPages) {
            echo "<a href='?{$pageParam}=" . ($currentPage + 1) . "#$section' class='btn'>Next</a>";
        }
        echo "</div>";
    } else {
        echo "<p>No files uploaded yet.</p>";
    }
}
?>




