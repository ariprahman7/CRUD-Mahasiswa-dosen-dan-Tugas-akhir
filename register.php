<?php
session_start();

// Atur koneksi ke database
$koneksi = require 'koneksi/config.php';

// Atur variabel
$err = "";
$username = "";
$password = "";
$confirmPassword = "";

if (isset($_POST['register'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirm_password'];

    // Validasi input
    if (empty($username) || empty($password) || empty($confirmPassword)) {
        $err .= "<li>Silakan isi semua field.</li>";
    } elseif ($password !== $confirmPassword) {
        $err .= "<li>Konfirmasi password tidak sesuai.</li>";
    } else {
        // Periksa apakah username sudah terdaftar
        $sql = "SELECT * FROM login WHERE username = '$username'";
        $result = $koneksi->query($sql);

        if ($result->num_rows > 0) {
            $err .= "<li>Username sudah digunakan. Silakan pilih username lain.</li>";
        } else {
            // Hash password sebelum disimpan ke database
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            // Simpan data ke database
            $sql = "INSERT INTO login (username, password) VALUES ('$username', '$hashedPassword')";
            if ($koneksi->query($sql) === true) {
                // Redirect ke halaman login setelah registrasi berhasil
                header("Location: index.php");
                exit;
            } else {
                $err .= "<li>Gagal melakukan registrasi. Silakan coba lagi.</li>";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
</head>

<body>
    <div class="container my-4">
        <div id="registerbox" style="margin-top:50px;" class="mainbox col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <div class="panel-title">Registrasi Akun Baru</div>
                </div>
                <div style="padding-top:30px" class="panel-body">
                    <?php if ($err) { ?>
                        <div id="register-alert" class="alert alert-danger col-sm-12">
                            <ul><?php echo $err ?></ul>
                        </div>
                    <?php } ?>
                    <form id="registerform" class="form-horizontal" action="" method="post" role="form">
                        <div style="margin-bottom: 25px" class="input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                            <input id="register-username" type="text" class="form-control" name="username" value="<?php echo $username ?>" placeholder="Username">
                        </div>
                        <div style="margin-bottom: 25px" class="input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                            <input id="register-password" type="password" class="form-control" name="password" placeholder="Password">
                        </div>
                        <div style="margin-bottom: 25px" class="input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                            <input id="register-confirm-password" type="password" class="form-control" name="confirm_password" placeholder="Konfirmasi Password">
                        </div>
                        <div style="margin-top:10px" class="form-group">
                            <div class="col-sm-12 controls">
                                <input type="submit" name="register" class="btn btn-primary" value="Register">
                                <a href="login.php">Log In</a>
                            </div>
                        </div>
                    </form>
                    
                </div>
            </div>
        </div>
    </div>
</body>

</html>
