<?php
require_once "flash.php";

// Redirect if not admin
if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] !== true) {
    setFlash('error', 'You must be logged in as admin.');
    header('Location: admin_login.php');
    exit;
}
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Pending Uploads - Admin Panel</title>
  <link rel="stylesheet" href="styles.css">
  <style>
    /* RESET + BASE */
    * { box-sizing: border-box; margin: 0; padding: 0; }

    body {
      font-family: 'Segoe UI', Arial, sans-serif;
      background-color: #f4f6f8;
      color: #222;
    }

    /* HEADER */
    header {
      position: fixed;
      top: 0;
      left: 0;
      right: 0;
      background-color: #000;
      color: #1e90ff;
      text-align: center;
      padding: 20px 0 10px 0;
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.3);
      z-index: 1000;
    }

    header h1 { font-size: 28px; letter-spacing: 1px; margin-bottom: 8px; }

    header nav a {
      color: #1e90ff;
      margin: 0 10px;
      text-decoration: none;
      font-size: 15px;
      transition: color 0.3s;
    }

    header nav a:hover { color: #ffffff; }

    /* MAIN CONTENT */
    main {
      padding-top: 130px;
      max-width: 1200px;
      margin: 0 auto;
      padding-left: 20px;
      padding-right: 20px;
    }

    section {
      margin-bottom: 40px;
    }

    h2 {
      color: #0033cc;
      border-bottom: 2px solid #0033cc;
      display: inline-block;
      padding-bottom: 4px;
      margin-bottom: 12px;
      font-size: 22px;
    }

    .no-pending {
      color: #666;
      font-style: italic;
      margin-top: 10px;
    }

    /* GRID LAYOUT */
    .uploads-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
      gap: 20px;
      margin-top: 15px;
    }

    /* INDIVIDUAL UPLOAD CARD */
    .upload-item {
      width:100%;
      max-width:250px;
      background: #fff;
      border-radius: 10px;
      box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
      padding: 10px;
      display: flex;
      flex-direction: column;
      justify-content: space-between;
      transition: transform 0.2s ease, box-shadow 0.3s ease;
    }

    .upload-item:hover {
      transform: translateY(-5px);
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
    }

    .upload-item img,
    .upload-item video,
    .upload-item audio {
      width: 100%;
      max-width:250px;
      height: auto;
      border-radius: 6px;
      margin-top: 5px;
    }

    .buttons {
      margin-top: 8px;
      display: flex;
      justify-content: space-between;
    }

    /* BUTTONS */
    .btn {
      display: inline-block;
      flex: 1;
      padding: 8px 0;
      border-radius: 5px;
      text-decoration: none;
      margin: 0 5px;
      transition: 0.3s;
      border: none;
      cursor: pointer;
      font-weight: 500;
      text-align: center;
    }

    .btn-approve {
      background-color: #28a745;
      color: #fff;
    }

    .btn-approve:hover { background-color: #218838; }

    .btn-reject {
      background-color: #dc3545;
      color: #fff;
    }

    .btn-reject:hover { background-color: #b02a37; }

    /* FLASH MESSAGE */
    #flash {
      position: fixed;
      top: 90px;
      left: 50%;
      transform: translateX(-50%);
      z-index: 2000;
      display: none;
      padding: 12px 20px;
      border-radius: 6px;
      font-weight: 500;
      text-align: center;
    }

    #flash.success { background-color: #28a745; color: #fff; }
    #flash.error { background-color: #dc3545; color: #fff; }
    #flash.warning { background-color: #ffc107; color: #000; }

    @media (max-width: 600px) {
      h2 { font-size: 18px; }
    }
  </style>
</head>
<body>

  <header>
    <h1>Pending Uploads</h1>
    <nav>
      <a href="gallery.php">← Back to Site</a>
      <a href="admin_logout.php">Logout</a>
    </nav>
  </header>

  <div id="flash"></div>

  <main>
    <!-- IMAGES -->
    <section id="images">
      <h2>Images</h2>
      <?php
      $pendingDir = __DIR__ . "/uploads/pending/images/";
      if (is_dir($pendingDir)) {
          $files = array_values(array_diff(scandir($pendingDir), ['.', '..']));
          if (empty($files)) {
              echo '<p class="no-pending">No pending images.</p>';
          } else {
              echo "<div class='uploads-grid'>";
              foreach ($files as $file) {
                  $safeFile = htmlspecialchars($file, ENT_QUOTES);
                  $path = "uploads/pending/images/" . $safeFile;
                  echo "<div class='upload-item' data-section='images' data-file='$safeFile'>
                          <img src='$path' alt='Pending Image'>
                          <div class='buttons'>
                            <button class='btn btn-approve'>Approve</button>
                            <button class='btn btn-reject'>Reject</button>
                          </div>
                        </div>";
              }
              echo "</div>";
          }
      } else {
          echo '<p class="no-pending">No pending images.</p>';
      }
      ?>
    </section>

    <!-- VIDEOS -->
    <section id="videos">
      <h2>Videos</h2>
      <?php
      $pendingDir = __DIR__ . "/uploads/pending/videos/";
      if (is_dir($pendingDir)) {
          $files = array_values(array_diff(scandir($pendingDir), ['.', '..']));
          if (empty($files)) {
              echo '<p class="no-pending">No pending videos.</p>';
          } else {
              echo "<div class='uploads-grid'>";
              foreach ($files as $file) {
                  $safeFile = htmlspecialchars($file, ENT_QUOTES);
                  $path = "uploads/pending/videos/" . $safeFile;
                  echo "<div class='upload-item' data-section='videos' data-file='$safeFile'>
                          <video controls><source src='$path'></video>
                          <div class='buttons'>
                            <button class='btn btn-approve'>Approve</button>
                            <button class='btn btn-reject'>Reject</button>
                          </div>
                        </div>";
              }
              echo "</div>";
          }
      } else {
          echo '<p class="no-pending">No pending videos.</p>';
      }
      ?>
    </section>

    <!-- AUDIOS -->
    <section id="audios">
      <h2>Audios</h2>
      <?php
      $pendingDir = __DIR__ . "/uploads/pending/audios/";
      if (is_dir($pendingDir)) {
          $files = array_values(array_diff(scandir($pendingDir), ['.', '..']));
          if (empty($files)) {
              echo '<p class="no-pending">No pending audios.</p>';
          } else {
              echo "<div class='uploads-grid'>";
              foreach ($files as $file) {
                  $safeFile = htmlspecialchars($file, ENT_QUOTES);
                  $path = "uploads/pending/audios/" . $safeFile;
                  echo "<div class='upload-item' data-section='audios' data-file='$safeFile'>
                          <audio controls><source src='$path'></audio>
                          <div class='buttons'>
                            <button class='btn btn-approve'>Approve</button>
                            <button class='btn btn-reject'>Reject</button>
                          </div>
                        </div>";
              }
              echo "</div>";
          }
      } else {
          echo '<p class="no-pending">No pending audios.</p>';
      }
      ?>
    </section>
  </main>

  <script src="script.js"></script>
</body>
</html>
