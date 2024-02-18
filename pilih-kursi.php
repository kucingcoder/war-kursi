<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>War Kursi</title>
    <link rel="icon" type="image/png" href="https://cdn-icons-png.flaticon.com/512/9249/9249336.png">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .container {
            margin-top: 50px;
        }

        .logout-btn {
            position: absolute;
            top: 10px;
            right: 10px;
        }
    </style>
</head>

<?php
session_start();

require_once 'koneksi.php';

if (!isset($_SESSION['nim'])) {
    header('Location: index.php');
    exit;
}

$nim = $_SESSION['nim'];

$CekDuduk = "SELECT RIGHT(kode_tempat_duduk, 2) as tempat_duduk FROM duduk WHERE mahasiswa_nim = $nim";
$TempatSaya = mysqli_query($conn, $CekDuduk);

if (mysqli_num_rows($TempatSaya) == 1) {
    $row = mysqli_fetch_assoc($TempatSaya);
    $Kursi = $row['tempat_duduk'];
}

$Bus = $_SESSION['bus'];

$Diduduki = "SELECT m.nama, RIGHT(d.kode_tempat_duduk, 2) as tempat_duduk
             FROM mahasiswa m
             JOIN duduk d ON m.nim = d.mahasiswa_nim
             WHERE m.bus = $Bus";
$Terduduki = mysqli_query($conn, $Diduduki);

if ($Terduduki) {
    $Sudah_Diduduki = array();
    $Nama_Menduduki = array();

    while ($row = mysqli_fetch_assoc($Terduduki)) {
        $Sudah_Diduduki[] = $row['tempat_duduk'];
        $Nama_Menduduki[$row['tempat_duduk']] = $row['nama'];
    }
}

?>

<body>
    <div class="container">
        <div class="row">
            <div class="col-md-4 mb-4">
                <div class="card">
                    <div class="card-header">Informasi Mahasiswa</div>
                    <div class="card-body">
                        <p>NIM : <?= $_SESSION['nim'] ?></p>
                        <p>Nama : <?= str_replace(' ', ' ', ucwords(str_replace('_', ' ', $_SESSION['nama']))); ?></p>
                        <p>No. Bus : <?= "0" . $_SESSION['bus'] ?></p>
                        <h4>No. Kursi : <?= isset($Kursi) ? $Kursi : "Belum Memilih"; ?></h4>
                        <div class="d-flex" style="gap: 20px;">
                            <a href="tinggalkan.php" class="btn btn-primary mt-4">Tinggalkan Kursi</a>
                            <a href="logout.php" class="btn btn-danger mt-4">Keluar</a>
                        </div>
                    </div>
                    <div class="card-footer">
                        <?php
                        if (isset($_SESSION['meninggalkan'])) {
                            echo '<div class="alert alert-warning" role="alert">' . $_SESSION['meninggalkan'] . '</div>';
                            unset($_SESSION['meninggalkan']);
                        }
                        ?>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card mb-4">
                    <div class="card-header">Pemilihan Tempat Duduk</div>
                    <div class="card-body">
                        <form action="duduki.php" method="POST">
                            <div class="form-group">
                                <label>Pilih Tempat Duduk:</label>
                                <select class="form-control" id="kursi" name="kursi" required>
                                    <option value="" disabled selected>Pilih no kursi</option>
                                    <?php
                                    for ($i = 5; $i <= 46; $i++) {
                                        if (in_array($i, $Sudah_Diduduki)) {
                                            if ($i < 10) {
                                                $index = "0" . $i;
                                            } else {
                                                $index = $i;
                                            }
                                            $Namanya = str_replace(' ', ' ', ucwords(str_replace('_', ' ', $Nama_Menduduki[$index])));
                                            echo "<option value='$i' disabled class='text-white bg-danger'>$i ($Namanya)</option>";
                                        } else {
                                            echo "<option value='$i'>$i</option>";
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                            <button type=" submit" class="btn btn-primary">Duduki</button>
                        </form>
                    </div>
                    <div class="card-footer">
                        <?php
                        if (isset($_SESSION['gagal'])) {
                            echo '<div class="alert alert-danger" role="alert">' . $_SESSION['gagal'] . '</div>';
                            unset($_SESSION['gagal']);
                        }

                        if (isset($_SESSION['sukses'])) {
                            echo '<div class="alert alert-success" role="alert">' . $_SESSION['sukses'] . '</div>';
                            unset($_SESSION['sukses']);
                        }
                        ?>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card mb-5">
                    <div class="card-header">Denah Bus</div>
                    <div class="card-body">
                        <img src="denah.jpeg" alt="Denah Bis" class="img-fluid">
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>