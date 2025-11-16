<?php

$koneksi = mysqli_connect("localhost","root","mysql","website musik");
if(mysqli_connect_errno()){
    echo "Koneksi database gagal : " . mysqli_connect_error();
}
?>