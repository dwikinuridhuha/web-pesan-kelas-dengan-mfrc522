<?php
require('dbConn.php');

session_start();

if (isset($_SESSION['nim'])) {
    echo "<script>alert(\"Anda sudah LogIn\")</script>";
//    echo '<script>window.location.href = "http://pkl-fk.000webhostapp.com/history.php";</script>';
    echo '<script>window.location.href = "http://localhost/webMCU/history.php";</script>';
}

if (isset($_POST["login"])) {
    // $uid = $_POST['uid'];
    $nim = $_POST['nim'];
    $paswd = $_POST['password'];

    $sql = 'select * from data_mahasiswa where nim="' . $nim . '" AND password="' . $paswd . '"';
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $_SESSION["nim"] = $nim;
        $_SESSION["password"] = $paswd;
//        echo '<script>window.location.href = "http://pkl-fk.000webhostapp.com/history.php";</script>';
            echo '<script>window.location.href = "http://localhost/webMCU/histpry.php";</script>';
    } else {
        echo '<script>alert("nim tidak diketahui");</script>';
    }
}
?>
<html>
<head>
    <title>Home</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--===============================================================================================-->
    <link rel="icon" type="image/png" href="images/icons/favicon.ico"/>
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="fonts/iconic/css/material-design-iconic-font.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="vendor/animate/animate.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="vendor/css-hamburgers/hamburgers.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="vendor/animsition/css/animsition.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="vendor/select2/select2.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="vendor/daterangepicker/daterangepicker.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="css/util.css">
    <link rel="stylesheet" type="text/css" href="css/main.css">
    <!--===============================================================================================-->
</head>
<body>
<div class="d-flex flex-column flex-md-row align-items-center p-3 px-md-4 bg-white border-bottom box-shadow">
    <h5 class="my-0 mr-md-auto font-weight-normal">Selamat Datang</h5>
    <?php include 'nav.php' ?>
</div>

<div class="limiter">
    <div class="container-login100" style="background-image: url('images/slide0.jpg');">
        <div class="wrap-login100">
            <form class="login100-form validate-form" method="post">
					<span class="login100-form-logo">
						<img src="images/logoFK.png" class="logo-img">
					</span>

                <span class="login100-form-title p-b-34 p-t-27">
						Log in
					</span>

                <div class="wrap-input100 validate-input" data-validate="Enter username">
                    <input class="input100" type="text" name="nim" placeholder="NIM">
                    <span class="focus-input100" data-placeholder="&#xf207;"></span>
                </div>

                <div class="wrap-input100 validate-input" data-validate="Enter password">
                    <input class="input100" type="password" name="password" placeholder="Password">
                    <span class="focus-input100" data-placeholder="&#xf191;"></span>
                </div>

                <div class="container-login100-form-btn">
                    <button class="login100-form-btn" type="submit" name="login">
                        Login
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!--===============================================================================================-->
<script src="vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
<script src="vendor/animsition/js/animsition.min.js"></script>
<!--===============================================================================================-->
<script src="vendor/bootstrap/js/popper.js"></script>
<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
<script src="vendor/select2/select2.min.js"></script>
<!--===============================================================================================-->
<script src="vendor/daterangepicker/moment.min.js"></script>
<script src="vendor/daterangepicker/daterangepicker.js"></script>
<!--===============================================================================================-->
<script src="vendor/countdowntime/countdowntime.js"></script>
<!--===============================================================================================-->
<script src="js/main.js"></script>
<!--===============================================================================================-->
</body>
</html>