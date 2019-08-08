<?php
require('dbConn.php');

session_start();

if (!isset($_SESSION['nim'])) {
//    echo '<script>window.location.href = "http://pkl-fk.000webhostapp.com/webMCU";</script>';
    echo '<script>window.location.href = "http://localhost/webMCU";</script>';
}

$arrResult = Array();
$arrResultWaktu = Array();
$i = 0;
$id = 0;

if (isset($_GET['idBerow'])) {
    $id = $_GET['idBerow'];

    $sql = "select * from peminjaman_ruangan 
            where status_pinjam='Booked' AND nim_mahasiswa='" . $_SESSION['nim'] . "' AND id_peminjaman='" . $id . "'";
    $result = $conn->query($sql);

    while ($row = $result->fetch_assoc()) {
        $arrResult[0] = $row['nim_mahasiswa'];
        $arrResult[1] = $row['nama_ruangan'];
        $arrResult[2] = $row['tanggal_pinjam'];
        $arrResult[3] = $row['waktu_awal'];
        $arrResult[4] = $row['waktu_akhir'];
        $arrResult[5] = $row['keterangan'];
        $arrResult[6] = $row['status_pinjam'];
    }
} else {
    echo "<script>alert(\"tidak ada get\")</script>";
//    echo '<script>window.location.href = "http://pkl-fk.000webhostapp.com/webMCU/history.php";</script>';
    echo '<script>window.location.href = "http://localhost/webMCU/history.php";</script>';
}

$sqlWaktu = "select list_waktu from daftar_waktu";
$resultWaktu = $conn->query($sqlWaktu);

while ($rowWaktu = $resultWaktu->fetch_assoc()) {
    $arrResultWaktu[$i] = $rowWaktu['list_waktu'];
    $i++;
}

$sqlRuangan = "select nama_ruangan from daftar_ruangan order by nama_ruangan ASC";
$resultRuangan = $conn->query($sqlRuangan);

if (isset($_POST['update'])) {
    $nama_ruangan = $_POST['kelas'];
    $keterangan = $_POST['keterangan'];
    $waktu_awal = $_POST['jamMulai'];
    $waktu_akhir = $_POST['jamSelesai'];
    $tanggal_pinjam = $_POST['tanggal'];
    $status_pinjam = "Booked";


    $mysql_qry = "select nama_ruangan , tanggal_pinjam ,status_pinjam, waktu_awal ,waktu_akhir from peminjaman_ruangan 
where nama_ruangan like '$nama_ruangan' and tanggal_pinjam like '$tanggal_pinjam' and status_pinjam like '$status_pinjam' 
and (('$waktu_awal' BETWEEN waktu_awal and waktu_akhir) OR ('$waktu_akhir' BETWEEN waktu_awal and waktu_akhir) 
OR ('$waktu_awal' <= waktu_awal and '$waktu_akhir' >= waktu_akhir))";

    $mysql_qry1 = "select nama_ruangan, tanggal_pinjam ,status_pinjam, waktu_awal ,waktu_akhir,nim_mahasiswa,id_peminjaman from peminjaman_ruangan 
where nama_ruangan like '$nama_ruangan' and tanggal_pinjam like '$tanggal_pinjam' and status_pinjam like '$status_pinjam' and nim_mahasiswa like '" . $_SESSION['nim'] . "' 
and (('$waktu_awal' BETWEEN waktu_awal and waktu_akhir) OR ('$waktu_akhir' BETWEEN waktu_awal and waktu_akhir) 
OR ('$waktu_awal' <= waktu_awal and '$waktu_akhir' >= waktu_akhir))";

    $result = mysqli_query($conn, $mysql_qry);
    $result1 = mysqli_query($conn, $mysql_qry1);

    if ((mysqli_num_rows($result) == 1 && mysqli_num_rows($result1) == 1) || (mysqli_num_rows($result) != 1 && mysqli_num_rows($result1) != 1)) {
        $sqlUpdate = "update peminjaman_ruangan set nama_ruangan='" . $nama_ruangan . "', keterangan='" . $keterangan . "', 
        waktu_awal='" . $waktu_awal . "', waktu_akhir='" . $waktu_akhir . "', tanggal_pinjam='" . $tanggal_pinjam . "' 
        where status_pinjam='Booked' AND nim_mahasiswa='" . $_SESSION['nim'] . "' AND id_peminjaman='" . $id . "'";

        if ($conn->query($sqlUpdate) === TRUE) {
            echo "<script>alert(\"berhasil terUpdate\")</script>";
//            echo '<script>window.location.href = "http://pkl-fk.000webhostapp.com/history.php";</script>';
            echo '<script>window.location.href = "http://localhost/webMCU/history.php";</script>';
        } else {
            echo "<script>alert(echo \"error: \".$conn->error)</script>";
        }
    } else {
        echo "<script>jadwal ada yang sama</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Update</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--===============================================================================================-->
    <link rel="icon" type="image/png" href="images/icons/favicon.ico"/>
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/css/bootstrap-select.min.css">
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
    <h5 class="my-0 mr-md-auto font-weight-normal">Ubah Peminjaman Anda</h5>
    <?php include 'nav.php' ?>
</div>

<div class="container-contact100">
    <div class="wrap-contact100">
        <form class="contact100-form validate-form" method="post" onsubmit="return validasiBrow()">
				<span class="contact100-form-title">
					Silakan Update
				</span>

            <div class="wrap-input100 validate-input" data-validate="Kelas is required">
                <span class="label-input100">Kelas</span><br>
                <select class="selectpicker" data-live-search="true" name="kelas">

                    <option data-tokens="<?php echo $arrResult[1] ?>"><?php echo $arrResult[1] ?></option>
                    <?php
                    if ($resultRuangan->num_rows > 0) {
                        while ($rowRuangan = $resultRuangan->fetch_assoc()) {
                            ?>

                            <option data-tokens="<?php echo $rowRuangan['nama_ruangan'] ?>"><?php echo $rowRuangan['nama_ruangan'] ?></option>

                            <?php
                        }
                    }
                    ?>
                </select>
            </div>

            <div class="wrap-input100 validate-input" data-validate="JamMulai is required">
                <span class="label-input100">waktu Awal</span><br>
                <select class="selectpicker" data-live-search="true" name="jamMulai" id="jamMulai">
                    <option data-tokens="<?php echo $arrResult[3] ?>"><?php echo $arrResult[3] ?></option>
                    <?php
                    for ($i = 0;
                         $i < count($arrResultWaktu);
                         $i++) {
//                        if ($i % 2 == 0) {
                            ?>
                            <option data-tokens="<?php echo $arrResultWaktu[$i] ?>"><?php echo $arrResultWaktu[$i] ?></option>
                            <?php
//                        }
                    }
                    ?>
                </select>
            </div>

            <div class="wrap-input100 validate-input" data-validate="jamSelesai is required">
                <span class="label-input100">Waktu Akhir</span><br>
                <select class="selectpicker" data-live-search="true" name="jamSelesai" id="jamSelesai">
                    <option data-tokens="<?php echo $arrResult[4] ?>"><?php echo $arrResult[4] ?></option>
                    <?php
                    for ($i = 0;
                         $i < count($arrResultWaktu);
                         $i++) {
//                        if ($i % 2 != 0) {
                            ?>
                            <option data-tokens="<?php echo $arrResultWaktu[$i] ?>"><?php echo $arrResultWaktu[$i] ?></option>
                            <?php
//                        }
                    }
                    ?>
                </select>
            </div>

            <div class="wrap-input100 validate-input" data-validate="tanggal is required">
                <span class="label-input100">Tanggal</span>
                <input class="input100" type="date" name="tanggal" id="tanggal" value="<?php echo $arrResult[2] ?>">
                <span class="focus-input100"></span>
            </div>

            <div class="wrap-input100 validate-input" data-validate="keterangan is required">
                <span class="label-input100">Keterangan</span>
                <input class="input100" type="text" name="keterangan" placeholder="contoh: kelas penganti"
                       value="<?php echo $arrResult[5] ?>">
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

    function gtag() {
        dataLayer.push(arguments);
    }

    gtag('js', new Date());

    gtag('config', 'UA-23581568-13');
</script>

</body>
</html>
