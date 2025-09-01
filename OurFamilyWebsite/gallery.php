<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Home Page</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <link rel="stylesheet" href="styles.css">
  <script src="script.js"></script>
</head>
<body>
    <header>
        <div class="container">
            <div class="logo">
                <h1>THE FAMILY OF MR.TIBANYENDERA D.</h1>
            </div>
            <nav>
                <ul>
                    <li><a href="index.html">Home</a></li>
                    <li><a href="about.html">About Us</a></li>
                    <li><a href="gallery.php" class="active">Gallery</a></li>
                    <li><a href="contact.html">Contact</a></li>
                </ul>
                <div class="mobile-menu">
                    <i class="fas fa-bars"></i>
                </div>
            </nav>
        </div>
    </header>

    <main class="first-section-gallery">
        <div class="gallery-container">

            <!-- Images Section -->
            <div class="section" id="images">
                <h2>Images</h2>
                <form class="upload-form" action="upload.php" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="section" value="images">
                    <input type="file" name="fileToUpload" accept="image/*" required>
                    <button type="submit">Upload Image</button>
                </form>
                <div class="files-grid">
                    <?php include "listfiles.php"; listFiles("images", "page_images", 6); ?>
                </div>
            </div>

            <!-- Videos Section -->
            <div class="section" id="videos">
                <h2>Videos</h2>
                <form class="upload-form" action="upload.php" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="section" value="videos">
                    <input type="file" name="fileToUpload" accept="video/*" required>
                    <button type="submit">Upload Video</button>
                </form>
                <div class="files-grid">
                    <?php listFiles("videos", "page_videos", 6); ?>
                </div>
            </div>

            <!-- Audios Section -->
            <div class="section" id="audios">
                <h2>Audios</h2>
                <form class="upload-form" action="upload.php" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="section" value="audios">
                    <input type="file" name="fileToUpload" accept="audio/*" required>
                    <button type="submit">Upload Audio</button>
                </form>
                <div class="files-grid">
                    <?php listFiles("audios", "page_audios", 6); ?>
                </div>
            </div>
        </div>
    </main>


    <footer>
        <div class="footer-section">
            <div class="left-footer-section">
                <h2>THE FAMILY OF MR.TIBANYENDERA D.</h2></h2>
                <p>In every conceivable manner, the family is link to our past, bridge to our future.</p>
            </div>
            <div class=" middle-footer-section">
                <h2>Quick Links</h2>
                <ul>
                    <li><a href="index.html">Home</a></li>
                    <li><a href="about.html">About Us</a></li>
                    <li><a href="family.html">FamilyTree</a></li>
                    <li><a href="gallery.php" class="active">Gallery</a></li>
                    <li><a href="contact.html">Contact</a></li>
                </ul>
            </div>
            <div class=right-footer-section>
                <h2>Contact Us</h2>
                <p>info@tibanyenderadfamily.com</p>
                <p>+256773 135 014</p>
                <p>+256701 418 995</p>
            </div>
        </div>
        <div class="footer-bottom">
            <div>
                <p>&#169; 2025 The Family of Mr.TD.  All rights reserved</p>
            </div>
            <div class="social-icons">
                <a href="https://www.facebook.com"><i class="fab fa-facebook"></i></a>
                <a href="https://www.twitter.com"><i class="fab fa-twitter"></i></a>
                <a href="htps://www.linkedin.com"><i class="fab fa-linkedin"></i></a>
                <a href="https://www.instagram.com"><i class="fab fa-instagram"></i></a>
            </div>
        </div>
    </footer>
</body>
</html>