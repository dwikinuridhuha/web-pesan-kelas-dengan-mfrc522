<?php
require('dbConn.php');

session_start();

if (!isset($_SESSION['nim'])) {
//    echo '<script>window.location.href = "http://pkl-fk.000webhostapp.com/";</script>';
    echo '<script>window.location.href = "http://localhost/webMCU/";</script>';
}

$sqlRuangan = "select nama_ruangan from daftar_ruangan order by daftar_ruangan.nama_ruangan ASC";
$sqlWaktu = "select list_waktu from daftar_waktu";

$resultRuangan = $conn->query($sqlRuangan);
$resultWaktu = $conn->query($sqlWaktu);
$arrResultWaktu = Array();
$i = 0;

while ($rowWaktu = $resultWaktu->fetch_assoc()) {
    $arrResultWaktu[$i] = $rowWaktu['list_waktu'];
    $i++;
}

if (isset($_POST['kirim'])) {
    $nim = $_SESSION['nim'];
    $kelas = $_POST['kelas'];
    $keterangan = $_POST['keterangan'];
    $jamMulai = $_POST['jamMulai'];
    $jamSelesai = $_POST['jamSelesai'];
    $tanggal = $_POST['tanggal'];

    $sql = "INSERT INTO peminjaman_ruangan (nim_mahasiswa, nama_ruangan, tanggal_pinjam, waktu_awal, waktu_akhir, keterangan, status_pinjam)
SELECT '" . $nim . "', '" . $kelas . "', '" . $tanggal . "', '" . $jamMulai . "', '" . $jamSelesai . "', '" . $keterangan . "', 'Booked'
FROM DUAL
WHERE NOT EXISTS (SELECT nama_ruangan, tanggal_pinjam, waktu_awal, waktu_akhir, status_pinjam FROM peminjaman_ruangan
WHERE (('" . $jamMulai . "' BETWEEN waktu_awal AND waktu_akhir) OR
('" . $jamSelesai . "' BETWEEN waktu_awal AND waktu_akhir) OR
('" . $jamMulai . "' <= waktu_awal AND '" . $jamSelesai . "' >= waktu_akhir)) AND
nama_ruangan = '" . $kelas . "' AND
tanggal_pinjam = '" . $tanggal . "' AND
status_pinjam = 'Booked')";

    if ($conn->query($sql) === TRUE) {
        $sql = "select status_pinjam from peminjaman_ruangan where nim_mahasiswa='" . $nim . " ' and status_pinjam='Booked'";
        if ($conn->query($sql)->num_rows > 0) {
            echo '<script>window.location.href = "http://localhost/webMCU/history.php";</script>';
//                echo '<script>window.location.href = "http://pkl-fk.000webhostapp.com/history.php";</script>';
        } else {
            echo "<script>alert(\"input anda ada yang sama dengan jadwal yang lain\")</script>";
            echo '<script>window.location.href = "http://localhost/webMCU/booked.php";</script>';
//                echo '<script>window.location.href = "http://pkl-fk.000webhostapp.com/booked.php";</script>';
        }
    } else {
        echo "<script>alert($conn->error)</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Peminjaman</title>
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
    <h5 class="my-0 mr-md-auto font-weight-normal">Peminjaman Kelas></h5>
    <?php include 'nav.php' ?>
</div>

<div class="container-contact100">
    <div class="wrap-contact100">
        <form class="contact100-form validate-form" method="post" onsubmit="return validasiBrow()">
				<span class="contact100-form-title">
					Silahkan Pesan
				</span>

            <div class="wrap-input100 validate-input" data-validate="kelas is required">
                <span class="label-input100">Kelas</span><br>
                <select class="selectpicker" data-live-search="true" name="kelas">
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
                <span class="label-input100">Waktu Awal</span><br>
                <select class="selectpicker" data-live-search="true" name="jamMulai" id="jamMulai">
                    <?php
                    for ($i = 0; $i < count($arrResultWaktu); $i++) {
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
                    <?php
                    for ($i = 0; $i < count($arrResultWaktu); $i++) {
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
                <input class="input100" type="date" name="tanggal" id="tanggal">
                <span class="focus-input100"></span>
            </div>

            <div class="wrap-input100 validate-input" data-validate="keterangan is required">
                <span class="label-input100">Keterangan</span>
                <input class="input100" type="text" name="keterangan" placeholder="contoh: kelas penganti" maxlength="100">
                <span class="focus-input100"></span>
            </div>

            <div class="container-contact100-form-btn">
                <div class="wrap-contact100-form-btn">
                    <div class="contact100-form-bgbtn"></div>
                    <button class="contact100-form-btn" type="submit" name="kirim">
							<span>
								Submit
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
