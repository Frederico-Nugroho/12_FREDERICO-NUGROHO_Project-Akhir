<?php
session_start();
include 'koneksi.php';

if($_SERVER['REQUEST_METHOD'] !== 'POST'){
    header('Location: Koleksi.php'); exit;
}

if(empty($_SESSION['username'])){ header('Location: login.php'); exit; }
$owner = mysqli_real_escape_string($koneksi, $_SESSION['username']);
$id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
if($id <= 0){ header('Location: Koleksi.php'); exit; }

$res = mysqli_query($koneksi, "SELECT id FROM playlists WHERE id=$id AND owner='$owner' LIMIT 1");
if(!$res || mysqli_num_rows($res) == 0){ header('Location: Koleksi.php'); exit; }

mysqli_query($koneksi, "DELETE FROM playlists WHERE id=$id AND owner='$owner'");

header('Location: Koleksi.php'); exit;
