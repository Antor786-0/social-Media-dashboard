<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Photo Albums</title>
  <link rel="stylesheet" href="../assets/CSS/albums.css" />
</head>
<body>
  <header>
    <h1>SocialApp</h1>
    <div class="user-info">
      <span id="username">User</span>
      <a href="../index.php" class="logout">Logout</a>
    </div>
  </header>

  <nav class="sidebar">
    <ul>
      <li><a href="dashboard.php">Dashboard</a></li>
      <li><a href="post.php">Create Post</a></li>
      <li><a href="profile.php">Edit Profile</a></li>
      <li class="active"><a href="albums.php">Photo Albums</a></li>
      <li><a href="privacy.php">Privacy Settings</a></li>
      <li><a href="delete-account.php">Account Settings</a></li>
      <li><a href="contact.php">Contact Us</a></li>
    </ul>
  </nav>

  <main class="content">
    <h2>Photo Albums</h2>
    <div class="album-controls">
      <input type="text" id="albumName" placeholder="New album name" />
      <button id="createAlbum">Create Album</button>
    </div>
    <div class="upload-area" ondragover="event.preventDefault();" ondrop="handleDrop(event)">
      <p>Drag & Drop photos here or click to upload</p>
      <input type="file" id="photoUpload" accept="image/*" multiple hidden />
    </div>
    <div class="album-list" id="albumList">
      <?php
      if (empty($albums)) {
          echo "<p>No albums to display.</p>";
      } else {
          foreach ($albums as $album) {
              echo "<div class='album' id='album-".htmlspecialchars($album['name'], ENT_QUOTES)."'>";
              echo "<h3>".htmlspecialchars($album['name'])."</h3>";
              foreach ($album['photos'] as $photo) {
                  echo "<img src='../".htmlspecialchars($photo, ENT_QUOTES)."' style='max-width:150px; margin:5px;' alt='Album photo'>";
              }
              echo "</div>";
          }
      }
      ?>
    </div>
    <a href="dashboard.php" class="back-btn">Back to Dashboard</a>
  </main>

  <script src="../assets/JAVASCRIPT/albums.js"></script>
</body>
</html>
