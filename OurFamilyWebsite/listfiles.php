<?php
function listFiles($section, $pageParam, $perPage = 6) {
    $dir = __DIR__ . "/uploads/$section/";
    $urlPath = "uploads/$section/";

    if (is_dir($dir)) {
        // Get files
        $files = array_values(array_diff(scandir($dir), ['.', '..']));
        $total = count($files);

        // Pagination setup
        $currentPage = isset($_GET[$pageParam]) ? max(1, intval($_GET[$pageParam])) : 1;
        $start = ($currentPage - 1) * $perPage;
        $slice = array_slice($files, $start, $perPage);

        // Loop visible files
        foreach ($slice as $file) {
            $safeFile = htmlspecialchars($file, ENT_QUOTES);
            // Add cache-buster (?t=...) so browser always fetches fresh files
            $path = $urlPath . $safeFile . "?t=" . time();

            echo "<div class='file-card'>";
            if ($section == "images") {
                echo "<img src='$path' alt='Image' />";
            } elseif ($section == "videos") {
                echo "<video controls><source src='$path'></video>";
            } elseif ($section == "audios") {
                echo "<audio controls><source src='$path'></audio>";
            }

            // ✅ FIXED DELETE LINK (now uses proper PHP echo)
            echo "<div class='file-actions'>
                    <a href='$urlPath$safeFile' download>Download</a>
                    <a href='delete.php?section=" . urlencode($section) . "&file=" . urlencode($safeFile) . "' onclick='return confirmDelete();'>Delete</a>
                  </div>";
            echo "</div>";
        }

        // Pagination controls
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
