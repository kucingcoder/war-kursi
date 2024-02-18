<?php
session_start();

require_once 'koneksi.php';

$nim = $_SESSION['nim'];

mysqli_query($conn, "DELETE FROM duduk WHERE mahasiswa_nim = $nim");

$_SESSION['meninggalkan'] = "Kursi telah dikosongkan dan dapat ditempati orang lain";

header("location: pilih-kursi.php");
