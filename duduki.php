<?php
session_start();

require_once 'koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nim = $_SESSION['nim'];
    $bus = $_SESSION['bus'];
    $kursi = $_POST['kursi'];

    if ($kursi < 10) {
        $kursi = "0" . $kursi;
    }

    $CekTerinput = "SELECT 1 FROM duduk WHERE mahasiswa_nim = $nim";
    $HasilKeberadaan = mysqli_query($conn, $CekTerinput);

    $FinalQuery = "";

    if (mysqli_num_rows($HasilKeberadaan) == 1) {
        $FinalQuery = "UPDATE duduk SET kode_tempat_duduk = '0$bus$kursi' WHERE mahasiswa_nim = $nim";
    } else {
        $FinalQuery = "INSERT INTO duduk VALUES ($nim, '0$bus$kursi')";
    }

    try {
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
        mysqli_query($conn, $FinalQuery);
        $_SESSION['sukses'] = "Berhasil mengambil tempat duduk";
    } catch (mysqli_sql_exception $e) {
        $_SESSION['gagal'] = "Maaf, kursi telah diduduki orang lain lebih dulu";
    }

    header("location: pilih-kursi.php");
}
