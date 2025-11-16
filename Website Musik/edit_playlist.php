<?php
session_start();
include 'koneksi.php';

if(empty($_SESSION['username'])){ header('Location: login.php'); exit; }

$owner = mysqli_real_escape_string($koneksi, $_SESSION['username']);
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if($id <= 0) { header('Location: Koleksi.php'); exit; }

$res = mysqli_query($koneksi, "SELECT * FROM playlists WHERE id=$id AND owner='$owner' LIMIT 1");
if(!$res || mysqli_num_rows($res) == 0){ header('Location: Koleksi.php'); exit; }
$pl = mysqli_fetch_assoc($res);

$msg = '';
if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $name = isset($_POST['name']) ? trim($_POST['name']) : '';
    $desc = isset($_POST['description']) ? trim($_POST['description']) : '';

    $stmt = mysqli_prepare($koneksi, "UPDATE playlists SET name=?, description=? WHERE id=? AND owner=?");
    if($stmt){
        mysqli_stmt_bind_param($stmt, 'ssis', $name, $desc, $id, $owner);
        if(mysqli_stmt_execute($stmt)){
            mysqli_stmt_close($stmt);
            header('Location: Koleksi.php'); exit;
        } else { $msg = 'Gagal menyimpan perubahan.'; }
    } else { $msg = 'Query gagal.'; }
}

?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Edit Playlist</title>
  <link rel="stylesheet" href="koleksi.css">
  <style>.edit-form{max-width:700px;margin:40px auto;padding:18px;background:rgba(255,255,255,0.02);border-radius:10px}.edit-form label{color:#b3b3b3}</style>
</head>
<body class="koleksi-page">
  <div class="koleksi-container">
    <div class="edit-form">
      <h2>Edit Playlist</h2>
      <?php if($msg): ?><div class="msg"><?php echo htmlspecialchars($msg); ?></div><?php endif; ?>
      <form method="post">
        <label>Nama</label>
        <input type="text" name="name" value="<?php echo htmlspecialchars($pl['name']); ?>" required>
        <label>Deskripsi</label>
        <textarea name="description"><?php echo htmlspecialchars($pl['description']); ?></textarea>
        <div style="margin-top:12px;text-align:right">
          <a href="Koleksi.php" class="btn-cancel">Batal</a>
          <button class="btn-create" type="submit">Simpan</button>
        </div>
      </form>
    </div>
  </div>
</body>
</html>
