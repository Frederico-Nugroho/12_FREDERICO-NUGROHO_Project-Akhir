<?php
session_start();
include 'koneksi.php';

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = isset($_POST['username']) ? mysqli_real_escape_string($koneksi, $_POST['username']) : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';

    if ($username === '' || $password === '') {
        $error = 'Masukkan username dan password.';
    } else {
        // table name used in register.php is `user`
        $query = "SELECT * FROM user WHERE username='$username' LIMIT 1";
        $result = mysqli_query($koneksi, $query);

        if ($result && mysqli_num_rows($result) > 0) {
            $user = mysqli_fetch_assoc($result);
            $stored = isset($user['password']) ? $user['password'] : '';

            // support both hashed and plain passwords
            $ok = false;
            if ($stored !== '') {
                if (password_verify($password, $stored)) {
                    $ok = true;
                } elseif ($password === $stored) {
                    $ok = true;
                }
            }

            if ($ok) {
                $_SESSION['username'] = $user['username'];
                // remember me cookie for 30 days
                if (!empty($_POST['rememberme'])) {
                    setcookie('rememberme', $user['username'], time() + 60*60*24*30, '/');
                }
                header('Location: home.php');
                exit;
            } else {
                $error = 'Username atau password salah.';
            }
        } else {
            $error = 'Username atau password salah.';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link rel ="stylesheet" href="style.css">
    <link rel ="stylesheet" href="hmstyle.css">
    <link rel ="stylesheet" href="login.css">
</head>
<body style ="background-color: #000000ff;">
    <div class="loginbox">
    <h1>Selamat<br>
        Datang
        Kembali !
    </h1>
    <?php if(!empty(
$error)): ?>
        <p style="color:#ff8a97; text-align:center; font-weight:700"><?php echo $error; ?></p>
    <?php endif; ?>
    <form method="POST">

        <table style="text-align: center;"> 
            <tr>
                <td><label for ="username">Username :</label></td>
                <td><input type="text" name="username" placeholder="Username" required></td>
            </tr>
            <tr>
                <td>Password :</td>
                <td><input type="password" name="password" placeholder="Masukan Password"required></td>
            </tr>
            <tr> 
                <td colspan="2" align="center"><input type="checkbox" name="rememberme" value="1"> Remember Me</td>
            </tr>
            <tr>
                <td colspan="2" align="center"><input type="submit" value="Login"></td>
            </tr>
        </table>
    </form>
        
        <p> Tidak Punya Akun?</p>
        <p><a href="register.php">Daftar</a></p>
    </div>
</body>
</html>