<?php
require ('dbConn.php');

session_start();

if(!isset($_SESSION['nim'])) {
    echo '<script>window.location.href = "http://localhost/webMCU";</script>';
}

$sql = "select * from sensor where nim='".$_SESSION['nim']."'";
$result = $conn->query($sql);
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
            <div class="table100">
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
                    <?php
                    if($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            echo "<tr>";
                                echo "<td class='column1'>".$row['ID']."</td>";
                                echo "<td class='column2'>".$row['nim']."</td>";
                                echo "<td class='column3'>".$row['kelas']."</td>";
                                echo "<td class='column4'>".$row['keterangan']."</td>";
                                echo "<td class='column5'>".$row['tanggal']."</td>";
                                echo "<td class='column6'>".$row['jamMulai']."</td>";
                                echo "<td class='column7'>".$row['jamSelesai']."</td>";
                                echo "<td class='column8'>".$row['status']."</td>";
                            echo "</tr>";
                        }
                    }
                    ?>
                    </tbody>
                </table>
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