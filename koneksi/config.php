<?php
$host = "localhost";
$user = "root";
$pass = "";
$db = "uasweb2";

$koneksi = mysqli_connect($host, $user, $pass, $db);
if (!$koneksi) {
    die("Tidak bisa terkoneksi ke database");
}

return $koneksi;
?>

