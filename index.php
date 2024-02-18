<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>War Kursi</title>
    <link rel="icon" type="image/png" href="https://cdn-icons-png.flaticon.com/512/9249/9249336.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container">
        <div class="row justify-content-center align-items-center min-vh-100">
            <div class="col-lg-4">
                <form action="login.php" method="POST" class="p-4 p-md-5 border rounded-3 bg-light">
                    <h2 class="mb-4 text-center">Mahasiswa</h2>
                    <?php
                    session_start();

                    if (isset($_SESSION['nim'])) {
                        header("Location: pilih-kursi.php");
                        exit;
                    }

                    if (isset($_SESSION['error'])) {
                        echo '<div class="alert alert-danger" role="alert">' . $_SESSION['error'] . '</div>';
                        unset($_SESSION['error']);
                    }
                    ?>
                    <div class="form-floating mb-3">
                        <input type="text" name="nim" class="form-control" id="nim" placeholder="Enter NIM (8 digits)" pattern="[0-9]{8}" required>
                        <label for="nim">NIM</label>
                        <div class="invalid-feedback">
                            Mohon masukan nim yang valid.
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block">Masuk</button>
                </form>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>