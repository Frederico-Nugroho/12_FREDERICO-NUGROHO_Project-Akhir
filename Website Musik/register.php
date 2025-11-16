<?php


include 'koneksi.php';
if(isset($_POST['register'])){

    $username = $_POST['username'];
    $nama = $_POST['nama'];
    $email = $_POST['email'];
    $alamat = $_POST['alamat'];
    $nomor = $_POST['nomor'];
    $password = $_POST['password'];

    $query = "INSERT INTO user (username, nama, email, alamat, nomor, password) VALUES ('$username','$nama', '$email', '$alamat','$nomor','$password')";
    $result = mysqli_query($koneksi, $query);

    if($result){
        echo "<script>alert('Registrasi Berhasil! Silahkan login.'); 
        window.location='login.php'</script>";
    } else {
        echo "Gagal mendaftar!";}
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Page</title>
    <link rel ="stylesheet" href="style.css">
    <link rel ="stylesheet" href="register.css">
</head>
<body style="background-color: #6f6f6fff;">
    <div class="registerbox">
    <h2>Daftar untuk 
        mulai Mendengar</h2>
    <form method="POST">
        <table> 
            <tr>
                <td><label for="nama">Nama Lengkap :</label></td>
                <td><input type="text" name="nama" placeholder="Nama Lengkap" required></td>
            </tr>
            <tr>
                <td><label for="username">Username :</label></td>
                <td><input type="text" name="username" placeholder="Username" required></td>
            </tr>
            <tr>
                <td><label for="email">Email :</label></td>
                <td><input type="email" name="email" placeholder="email@example.com" required></td>
            </tr>
            <tr>
                <td><label for="alamat">Alamat :</label></td>
                <td><input type="text" name="alamat" placeholder="Alamat" required></td>
            </tr>
            <tr>
                <td><label for="nomor">Nomor Telpon :</label></td>
                <td><input type="text" name="nomor" placeholder="Nomor Telpon" required></td>
            </tr>
            <tr>
            <tr>
                <td><label for="password">Password :</label></td>
                <td><input type="password" name="password" placeholder="Password" required></td>
            </tr>
            <tr>
                <td colspan="2" align="center"><input type="checkbox" name="agree" value="1" required> I agree to the Terms and Conditions</td>
            </tr>
            <tr>
                <td colspan="2" align="center"><input type="submit" value="Register" name="register"></td>
            </tr>
        </table>
    </form>
        <p> Sudah Punya Akun?</p>
        <p><a href="login.php">Masuk</a></p>
    </div>
</body>
</html>