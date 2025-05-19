<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Photo Albums</title>
  <link rel="stylesheet" href="../assets/CSS/albums.css">
</head>
<body>
  <header>
    <h1>SocialApp</h1>
    <div class="user-info">
      <span id="username"><?php echo isset($_SESSION['username']) ? htmlspecialchars($_SESSION['username']) : 'User'; ?></span>
      <a href="../index.php" class="logout">Logout</a>
    </div>
  </header>
  
  <nav class="sidebar">
    <ul>
      <li><a href="dashboard.html">Dashboard</a></li>
      <li><a href="post.html">Create Post</a></li>
      <li><a href="profile.php">Edit Profile</a></li>
      <li class="active"><a href="albums.php">Photo Albums</a></li>
      <li><a href="privacy.html">Privacy Settings</a></li>
      <li><a href="delete-account.html">Account Settings</a></li>
      <li><a href="contact.html">Contact Us</a></li>
    </ul>
  </nav>
  
  <main class="content">
    <h2>Photo Albums</h2>
    <div class="album-controls">
      <input type="text" id="albumName" placeholder="New album name">
      <button id="createAlbum">Create Album</button>
    </div>
    <div class="upload-area" ondragover="event.preventDefault();" ondrop="handleDrop(event)">
      <p>Drag & Drop photos here or click to upload</p>
      <input type="file" id="photoUpload" accept="image/*" multiple hidden>
    </div>
    <label>
      <input type="checkbox" id="collaborative"> Collaborative Album
    </label>
    <div class="album-list" id="albumList"></div>
    <a href="dashboard.html" class="back-btn">Back to Dashboard</a>
  </main>

  <script src="../assets/JAVASCRIPT/albums.js"></script>
</body>
</html>