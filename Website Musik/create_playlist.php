<?php
session_start();
include 'koneksi.php';


if(empty($_SESSION['username'])){

    if(!empty($_COOKIE['rememberme'])){
        $_SESSION['username'] = $_COOKIE['rememberme'];
    } else {
        header('Location: login.php');
        exit;
    }
}

$msg = '';
if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $name = isset($_POST['name']) ? trim($_POST['name']) : '';
    $desc = isset($_POST['description']) ? trim($_POST['description']) : '';
    $owner = mysqli_real_escape_string($koneksi, $_SESSION['username']);

    if($name === ''){
        $msg = 'Nama Lagu tidak boleh kosong.';
    } else {
        $createSQL = "CREATE TABLE IF NOT EXISTS playlists (
            id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(255) NOT NULL,
            description TEXT,
            owner VARCHAR(150),
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";
        mysqli_query($koneksi, $createSQL);

        $stmt = mysqli_prepare($koneksi, "INSERT INTO playlists (name, description, owner) VALUES (?, ?, ?)");
        if($stmt){
            mysqli_stmt_bind_param($stmt, 'sss', $name, $desc, $owner);
            if(mysqli_stmt_execute($stmt)){
                mysqli_stmt_close($stmt);
                header('Location: Koleksi.php');
                exit;
            } else {
                $msg = 'Gagal membuat Playlist. Coba lagi.';
            }
        } else {
            $msg = 'Query tidak bisa diproses.';
        }
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Buat Playlist</title>
    <link rel="stylesheet" href="koleksi.css">
    <style>
    .create-form{ max-width:520px; margin:40px auto; padding:20px; background:rgba(255,255,255,0.02); border-radius:10px; }
    .create-form h2{ margin:0 0 12px; color:#fff }
    .create-form label{ display:block; color:#b3b3b3; margin:10px 0 6px }
    .create-form input[type=text], .create-form textarea{ width:100%; padding:10px; border-radius:8px; border:1px solid rgba(255,255,255,0.04); background:#111; color:#fff }
    .create-form textarea{ min-height:120px }
    .create-actions{ text-align:right; margin-top:12px }
    .btn-cancel{ margin-right:8px; color:#fff; background:transparent; border:1px solid rgba(255,255,255,0.08); padding:8px 14px; border-radius:20px; text-decoration:none }
    .btn-create{ background:#1DB954; color:#000; padding:8px 16px; border-radius:20px; font-weight:700; text-decoration:none; border:none }
    .msg{ color:#ff8a97; margin-bottom:8px }
    </style>
</head>
<body class="koleksi-page">
  <div class="koleksi-container">
    <div class="create-form">
      <h2>Buat Playlist Baru</h2>
      <?php if($msg): ?><div class="msg"><?php echo htmlspecialchars($msg); ?></div><?php endif; ?>
            <form method="post" enctype="multipart/form-data">
        <label for="name">Nama Playlist</label>
        <input type="text" id="name" name="name" required>

        <label for="description">Deskripsi (opsional)</label>
        <textarea id="description" name="description"></textarea>

        <div class="create-actions">
          <a href="home.php" class="btn-cancel">Batal</a>
          <button type="submit" class="btn-create">Buat</button>
        </div>
      </form>
    </div>
  </div>
</body>
</html>
