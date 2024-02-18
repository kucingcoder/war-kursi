<?php
session_start();

require_once 'koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nim = $_POST['nim'];

    $query = "SELECT * FROM mahasiswa WHERE nim = $nim";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);

        $_SESSION['nim'] = $row['nim'];
        $_SESSION['nama'] = $row['nama'];
        $_SESSION['bus'] = $row['bus'];

        header("location: pilih-kursi.php");
    } else {
        $_SESSION['error'] = "NIM tidak ditemukan";
        header("location: index.php");
    }
}
