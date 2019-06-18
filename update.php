<?php
require ('dbConn.php');

session_start();

if(!isset($_SESSION['nim'])) {
    echo '<script>window.location.href = "http://localhost/webMCU";</script>';
}

$sql = "select * from sensor where status='terPesan' AND nim='".$_SESSION['nim']."'";
$result = $conn->query($sql);
$arrResult = Array();

while($row = $result->fetch_assoc()) {
    $arrResult[0] = $row['ID'];
    $arrResult[1] = $row['nim'];
    $arrResult[2] = $row['kelas'];
    $arrResult[3] = $row['keterangan'];
    $arrResult[4] = $row['jamMulai'];
    $arrResult[5] = $row['jamSelesai'];
    $arrResult[6] = $row['tanggal'];
    $arrResult[7] = $row['status'];
}

$sqlRuangan = "select nama from ruangan where statusRuangan='kosong' order by nama ASC";
$resultRuangan = $conn->query($sqlRuangan);

if(isset($_POST['update'])) {
    $kelas=$_POST['kelas'];
    $keterangan=$_POST['keterangan'];
    $jamMulai=$_POST['jamMulai'];
    $jamSelesai=$_POST['jamSelesai'];
    $tanggal=$_POST['tanggal'];

    $sql = "update sensor set kelas='".$kelas."', keterangan='".$keterangan."', jamMulai='".$jamMulai."', jamSelesai='".$jamSelesai."', tanggal='".$tanggal."' where status='terPesan' AND nim='".$_SESSION['nim']."'";

    if($conn->query($sql) === TRUE) {
        $sqlRuangan1 ="update ruangan set statusRuangan='kosong' where nama='".$arrResult[2]."'";

        if($conn->query($sqlRuangan1) === TRUE) {
            $sqlRuangan2 = "update ruangan set statusRuangan='terPesan' where nama='".$kelas."'";

            if($conn->query($sqlRuangan2) === TRUE) {
                echo "<script>alert(\"berhasil terUpdate\")</script>";
                echo '<script>window.location.href = "http://localhost/webMCU/history.php";</script>';

            } else {
                echo "<script>alert(echo \"dari ruangan2 \".$conn->error)</script>";
            }
        } else {
            echo "<script>alert(echo \"dari ruangan1 \".$conn->error)</script>";
        }

    } else {
        echo "<script>alert(echo \"dari sensor \".$conn->error)</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Contact V4</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--===============================================================================================-->
    <link rel="icon" type="image/png" href="images/icons/favicon.ico"/>
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/css/bootstrap-select.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
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
    <link rel="stylesheet" type="text/css" href="css/insert.css">
    <!--===============================================================================================-->
</head>
<body>
<div class="d-flex flex-column flex-md-row align-items-center p-3 px-md-4 bg-white border-bottom box-shadow">
    <h5 class="my-0 mr-md-auto font-weight-normal">NavBar</h5>
    <nav class="my-2 my-md-0 mr-md-3">
        <a class="p-2 text-dark" href="http://localhost/webMCU/history.php">Riwayat</a>
        <a class="p-2 text-dark" href="http://localhost/webMCU/insert.php">Pilih Kelas</a>
        <a class="p-2 text-dark" href="http://localhost/webMCU/ubah.php">Ubah</a>
    </nav>
    <a class="btn btn-outline-primary" href="http://localhost/webMCU/logout.php">LogOut</a>
</div>

<div class="container-contact100">
    <div class="wrap-contact100">
        <form class="contact100-form validate-form" method="post">
				<span class="contact100-form-title">
					Say Hello!
				</span>

            <div class="wrap-input100 validate-input" data-validate="Kelas is required">
                <span class="label-input100">Kelas</span><br>
                <select class="selectpicker" data-live-search="true" name="kelas">

                    <option data-tokens="<?php echo $arrResult[2] ?>"><?php echo $arrResult[2] ?></option>
                    <?php
                    if($resultRuangan->num_rows > 0) {
                        while($rowRuangan = $resultRuangan->fetch_assoc()) {
                            ?>

                            <option data-tokens="<?php echo $rowRuangan['nama'] ?>"><?php echo $rowRuangan['nama'] ?></option>

                            <?php
                        }
                    }
                    ?>
                </select>
            </div>

            <div class="wrap-input100 validate-input" data-validate="Jam mulai is required">
                <span class="label-input100">Jam Mulai</span>
                <input class="input100" type="time" name="jamMulai" value="<?php echo $arrResult[4] ?>">
                <span class="focus-input100"></span>
            </div>

            <div class="wrap-input100 validate-input" data-validate="jamSelesai is required">
                <span class="label-input100">Jam Berakhir</span>
                <input class="input100" type="time" name="jamSelesai" value="<?php echo $arrResult[5] ?>">
                <span class="focus-input100"></span>
            </div>

            <div class="wrap-input100 validate-input" data-validate="tanggal is required">
                <span class="label-input100">Tanggal</span>
                <input class="input100" type="date" name="tanggal" value="<?php echo $arrResult[6] ?>">
                <span class="focus-input100"></span>
            </div>

            <div class="wrap-input100 validate-input" data-validate="keterangan is required">
                <span class="label-input100">Keterangan</span>
                <input class="input100" type="text" name="keterangan" placeholder="contoh: kelas penganti" value="<?php echo $arrResult[3] ?>">
                <span class="focus-input100"></span>
            </div>

            <div class="container-contact100-form-btn">
                <div class="wrap-contact100-form-btn">
                    <div class="contact100-form-bgbtn"></div>
                    <button class="contact100-form-btn" type="submit" name="update">
							<span>
								Update
								<i class="fa fa-long-arrow-right m-l-7" aria-hidden="true"></i>
							</span>
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<!--===============================================================================================-->
<script src="vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
<script src="vendor/animsition/js/animsition.min.js"></script>
<!--===============================================================================================-->
<script src="vendor/bootstrap/js/popper.js"></script>
<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/js/bootstrap-select.min.js"></script>
<!--===============================================================================================-->
<script src="vendor/select2/select2.min.js"></script>
<!--===============================================================================================-->
<script src="vendor/daterangepicker/moment.min.js"></script>
<script src="vendor/daterangepicker/daterangepicker.js"></script>
<!--===============================================================================================-->
<script src="vendor/countdowntime/countdowntime.js"></script>
<!--===============================================================================================-->
<script src="js/main.js"></script>

<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-23581568-13"></script>
<script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', 'UA-23581568-13');
</script>

</body>
</html>
