<?php
$host = "";
$user = "";
$password = "";
$database = "";

$conn = mysqli_connect($host, $user, $password, $database);

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
