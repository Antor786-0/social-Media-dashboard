<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Edit Profile</title>
  <link rel="stylesheet" href="../assets/CSS/privacy.css">
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
      <li><a href="../view/dashboard.html">Dashboard</a></li>
      <li><a href="../view/post.html">Create Post</a></li>
      <li class="active"><a href="profile.html">Edit Profile</a></li>
      <li><a href="../view/albums.php">Photo Albums</a></li>
      <li><a href="../view/privacy.html">Privacy Settings</a></li>
      <li><a href="../view/delete-account.html">Account Settings</a></li>
      <li><a href="../view/contact.html">Contact Us</a></li>
    </ul>
  </nav>
  
  <main class="content">
    <h2>Edit Your Profile</h2>

    <form id="profileForm" method="POST" action="../controller/edit-profile.php" enctype="multipart/form-data">
      <div class="profile-picture">
        <img src="<?= $_SESSION['profilePhoto'] ?? 'https://via.placeholder.com/150' ?>" alt="Profile" id="profileImg">
        <input type="file" id="profileUpload" name="profileUpload" accept="image/*">
      </div>

      <div class="form-group">
        <label for="displayName">Display Name</label>
        <input type="text" id="displayName" name="displayName" placeholder="Enter your name" value="<?= $_SESSION['displayName'] ?? '' ?>">
      </div>

      <div class="form-group">
        <label for="bio">Bio</label>
        <textarea id="bio" name="bio" placeholder="Tell us about yourself"><?= $_SESSION['bio'] ?? '' ?></textarea>
      </div>

      <div class="form-group">
        <label for="theme">Theme Color</label>
        <select id="theme" name="theme">
          <option value="blue" <?= (($_SESSION['theme'] ?? '') == 'blue') ? 'selected' : '' ?>>Blue</option>
          <option value="green" <?= (($_SESSION['theme'] ?? '') == 'green') ? 'selected' : '' ?>>Green</option>
          <option value="red" <?= (($_SESSION['theme'] ?? '') == 'red') ? 'selected' : '' ?>>Red</option>
          <option value="purple" <?= (($_SESSION['theme'] ?? '') == 'purple') ? 'selected' : '' ?>>Purple</option>
        </select>
      </div>

      <button type="submit">Save Changes</button>
    </form>
  </main>
  
  <!-- <script src="../assets/JAVASCRIPT/profile.js"></script> -->
</body>
</html>