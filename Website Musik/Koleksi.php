<?php
session_start();
include 'koneksi.php';

if(empty($_SESSION['username'])){
    if(!empty($_COOKIE['rememberme'])){
        $_SESSION['username'] = $_COOKIE['rememberme'];
    } else {
        header('Location: login.php'); exit;
    }
}

$owner = mysqli_real_escape_string($koneksi, $_SESSION['username']);
$playlists = [];
$res = mysqli_query($koneksi, "SELECT id, name, description, created_at FROM playlists WHERE owner='$owner' ORDER BY created_at DESC");
if($res){ while($r = mysqli_fetch_assoc($res)) $playlists[] = $r; }
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Koleksi Saya</title>
  <link rel="stylesheet" href="hmstyle.css">
  <link rel="stylesheet" href="playlist.css">
  <link rel="stylesheet" href="koleksi.css">
</head>
<body class="koleksi-page">
  <div class="navbar">
    <div class="nav-left">
      <a href="home.php"><img src="logo 2.png" alt="Logo"></a>
      <div class="search-box">
        <i class="fas fa-search"></i>
        <input type="text" placeholder="Apa yang ingin kamu putar?">
      </div>
    </div>

    <div class="nav-right">
      <a href="Koleksi.php">Lihat Koleksimu</a>
      <a href="#">Premium</a>
      <a href="about us.php">About Us</a>
      <a href="#">Download</a>
      <span>|</span>
      <a href="index.php" class="login-btn">Keluar</a>
    </div>
  </div>

  <main class="koleksi-container">
    <div class="koleksi-header">
      <h2>Koleksi Saya</h2>
      <a href="create_playlist.php" class="create-btn">Buat Playlist</a>
    </div>

    <div class="koleksi-grid">
      <?php if(empty($playlists)): ?>
        <div class="koleksi-card playlist-empty">Anda belum membuat playlist. <a href="create_playlist.php">Buat sekarang</a>.</div>
      <?php else: foreach($playlists as $pl): ?>
        <div class="koleksi-card">
          <div class="koleksi-meta">
            <h4><?php echo htmlspecialchars($pl['name']); ?></h4>
            <p><?php echo htmlspecialchars($pl['description']); ?></p>
          </div>
          <div class="meta">
            <a class="play-btn" href="#">Buka</a>
            <a class="play-btn" href="edit_playlist.php?id=<?php echo $pl['id']; ?>">Edit</a>
            <form method="post" action="delete_playlist.php" style="display:inline" onsubmit="return confirm('Hapus playlist ini?');">
              <input type="hidden" name="id" value="<?php echo $pl['id']; ?>">
              <button class="play-btn" type="submit" style="background:#ff6b6b;border:none;">Hapus</button>
            </form>
          </div>
        </div>
      <?php endforeach; endif; ?>

    </div>
  </main>
</body>
</html>
