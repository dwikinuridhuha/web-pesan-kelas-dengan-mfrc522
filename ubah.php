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

if($result->num_rows <= 0) {
    echo "<script>alert(\"tidak ada data\")</script>";
    echo '<script>window.location.href = "http://localhost/webMCU/history.php";</script>';
}

if(isset($_POST['selesai'])) {
    $sql = "update sensor set status='selesai' where status='terPesan' AND nim='".$_SESSION['nim']."'";
    $sqlRuangan ="update ruangan set statusRuangan='kosong' where nama='".$arrResult[2]."'";

    if ($conn->query($sql) === TRUE && $conn->query($sqlRuangan) === TRUE) {
        echo "<script>alert(\"berhasil terUpdate\")</script>";
        echo '<script>window.location.href = "http://localhost/webMCU/history.php";</script>';
    } else {
        echo "<script>alert($conn->error)</script>";
    }
}

if(isset($_POST['batal'])) {
    $sql = "delete from sensor where status='terPesan' AND nim='".$_SESSION['nim']."'";
    $sqlRuangan ="update ruangan set statusRuangan='kosong' where nama='".$arrResult[2]."'";

    if ($conn->query($sql) === TRUE && $conn->query($sqlRuangan) === TRUE) {
        echo "<script>alert(\"berhasil dibatalkan\")</script>";
        echo '<script>window.location.href = "http://localhost/webMCU/history.php";</script>';
    } else {
        echo "<script>alert($conn->error)</script>";
    }

    unset($_SESSION["kelas"]);
}

if(isset($_POST['update'])) {
    echo '<script>window.location.href = "http://localhost/webMCU/update.php";</script>';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Table V01</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--===============================================================================================-->
    <link rel="icon" type="image/png" href="images/icons/favicon.ico"/>
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="vendor/animate/animate.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="vendor/select2/select2.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="vendor/perfect-scrollbar/perfect-scrollbar.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="css/util.css">
    <link rel="stylesheet" type="text/css" href="css/main.css">
    <link rel="stylesheet" type="text/css" href="css/history.css">
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

<div class="limiter">
    <div class="container-table100">
        <div class="wrap-table100">
            <div class="table100" style="background-color: white; border-radius: 10px;">
                <table>
                    <thead>
                    <tr class="table100-head">
                        <th class="column1">ID</th>
                        <th class="column2">UID</th>
                        <th class="column3">Kelas</th>
                        <th class="column4">Keterangan</th>
                        <th class="column5">Tanggal</th>
                        <th class="column6">Jam Mulai</th>
                        <th class="column7">Jam Selesai</th>
                        <th class="column8">Setatus</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <th class="column1"><?php echo $arrResult[0]?></th>
                        <th class="column2"><?php echo $arrResult[1]?></th>
                        <th class="column3"><?php echo $arrResult[2]?></th>
                        <th class="column4"><?php echo $arrResult[3]?></th>
                        <th class="column5"><?php echo $arrResult[4]?></th>
                        <th class="column6"><?php echo $arrResult[5]?></th>
                        <th class="column7"><?php echo $arrResult[6]?></th>
                        <th class="column8"><?php echo $arrResult[7]?></th>
                    </tr>
                    </tbody>
                </table>

                <hr>
                <div class="container">
                    <div class="row">
                        <div class="col text-center mb-2">
                            <form method="post">
                                <button type="submit" class="btn btn-success m-2" name="selesai" >Selesai</button>
                                <button type="submit" class="btn btn-primary m-2" name="update">update</button>
                                <button type="submit" class="btn btn-danger m-2" name="batal">Batal</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!--===============================================================================================-->
<script src="vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
<script src="vendor/bootstrap/js/popper.js"></script>
<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
<script src="vendor/select2/select2.min.js"></script>
<!--===============================================================================================-->
<script src="js/main.js"></script>

</body>
</html>