<?php
require ('dbConn.php');

session_start();

if(!isset($_SESSION['nim'])) {
//    echo '<script>window.location.href = "http://pkl-fk.000webhostapp.com/";</script>';
    echo '<script>window.location.href = "http://localhost/webMCU/";</script>';
}

$sql = "select * from peminjaman_ruangan where nim_mahasiswa='".$_SESSION['nim']."'";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Riwayat</title>
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
    <h5 class="my-0 mr-md-auto font-weight-normal">Riwayat Piminjaman</h5>
    <?php include 'nav.php' ?>
</div>

<div class="limiter">
    <div class="container-table100">
        <div class="wrap-table100">
            <div class="table100">
                <table>
                    <thead>
                    <tr class="table100-head">
                        <th class="column1">No</th>
                        <th class="column2">Kelas</th>
                        <th class="column3">Tanggal Pesan</th>
                        <th class="column4">Waktu Awal</th>
                        <th class="column5">Waktu Akhir</th>
                        <th class="column6">keterangan</th>
                        <th class="column7">status</th>
                        <th class="column8">tanggal isi form</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    if($result->num_rows > 0) {
                        $no = 1;
                        while($row = $result->fetch_assoc()) {
                            echo "<tr>";
                                echo "<td class='column1 list'>".$no."</td>";
                                echo "<td class='column2 list'>".$row['nama_ruangan']."</td>";
                                echo "<td class='column3 list'>".$row['tanggal_pinjam']."</td>";
                                echo "<td class='column4 list'>".$row['waktu_awal']."</td>";
                                echo "<td class='column5 list'>".$row['waktu_akhir']."</td>";
                                echo "<td class='column6 list'>".$row['keterangan']."</td>";
                                echo "<td class='column7 list'>".$row['status_pinjam']."</td>";
                                echo "<td class='column8 list'>".$row['tanggal_isi_form']."</td>";
                            echo "</tr>";
                            $no++;
                        }
                    } else {
//                        echo "<script>window.location.href = \"http://pkl-fk.000webhostapp.com/insert.php\";</script>";
                        echo "<script>window.location.href = \"http://localhost/webMCU/insert.php\";</script>";
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