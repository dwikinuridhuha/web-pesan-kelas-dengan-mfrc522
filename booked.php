<?php
require('dbConn.php');
    session_start();
// tabel ruangan ++
$sqlRuangan = "SELECT daftar_ruangan.nama_ruangan, peminjaman_ruangan.tanggal_pinjam, peminjaman_ruangan.waktu_awal, peminjaman_ruangan.waktu_akhir, peminjaman_ruangan.keterangan
                FROM `daftar_ruangan` INNER JOIN peminjaman_ruangan ON daftar_ruangan.nama_ruangan = peminjaman_ruangan.nama_ruangan 
                WHERE peminjaman_ruangan.status_pinjam = 'Booked' ORDER by peminjaman_ruangan.nama_ruangan ASC, peminjaman_ruangan.waktu_awal ASC";
$resultRuangan = $conn->query($sqlRuangan);

// tabel ruangan gpp
$sqlRuanganSemua = "select nama_ruangan from daftar_ruangan order by daftar_ruangan.nama_ruangan ASC";
$resultRuanganSemua = $conn->query($sqlRuanganSemua);
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
    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/css/bootstrap-select.min.css">
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
    <link rel="stylesheet" type="text/css" href="css/insert.css">
    <!--===============================================================================================-->
</head>
<body>
<div class="d-flex flex-column flex-md-row align-items-center p-3 px-md-4 bg-white border-bottom box-shadow">
    <h5 class="my-0 mr-md-auto font-weight-normal">Riwayat Piminjaman</h5>
    <?php include 'nav.php' ?>
</div>

<div class="limiter">
    <div class="container-table100">
        <div class="wrap-table100" style="background-color: white; border-radius: 30px;">
            <div class="pb-1 pt-3 px-0 text-center m-3">
                <form class="contact100-form validate-form">
                    <div style="display: flex">
                        <div class="validate-input mx-4 select-pilih" style="width: 100%;">
                            <span>Masukan Tanggal : </span>
                            <input type="date" id="list-date" class="form-control mr-5" onchange="show()">
                            <span class="focus-input100"></span>
                        </div>

                        <div class="validate-input mx-4 select-pilih" style="width: 100%;">
                            <span>Masukan Kelas : </span>
                            <select class="selectpicker form-control" data-live-search="true" id="list-kelas" name="kelas"
                                    onchange="show()">
                                <option data-tokens="None">None</option>
                                <?php
                                if ($resultRuanganSemua->num_rows > 0) {
                                    while ($rowRuanganSemua = $resultRuanganSemua->fetch_assoc()) {
                                        ?>

                                        <option data-tokens="<?php echo $rowRuanganSemua['nama_ruangan'] ?>"><?php echo $rowRuanganSemua['nama_ruangan'] ?></option>

                                        <?php
                                    }
                                }
                                ?>
                                <span class="focus-input100"></span>
                            </select>
                        </div>
                    </div>
                </form>
            </div>

            <div class="table100" id="txtHint">
                <table>
                    <thead>
                    <tr class="table100-head">
                        <th class="column1">Kelas</th>
                        <th class="column2">Waktu Awal</th>
                        <th class="column3">Waktu Akhir</th>
                        <th class="column4">keterangan</th>
                        <th class="column5">tanggal</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    if ($resultRuangan->num_rows > 0) {
                        while ($row = $resultRuangan->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td class='column1 booked'>" . $row['nama_ruangan'] . "</td>";
                            echo "<td class='column2 booked'>" . $row['waktu_awal'] . "</td>";
                            echo "<td class='column3 booked'>" . $row['waktu_akhir'] . "</td>";
                            echo "<td class='column4 booked'>" . $row['keterangan'] . "</td>";
                            echo "<td class='column5 booked'>" . $row['tanggal_pinjam'] . "</td>";
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
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/js/bootstrap-select.min.js"></script>
<!--===============================================================================================-->
<script src="vendor/select2/select2.min.js"></script>
<!--===============================================================================================-->
<script src="js/main.js"></script>
<script>
    function show() {
        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("txtHint").innerHTML = this.responseText;
            }
        };

        let date = document.getElementById("list-date").value;
        let kelas = document.getElementById("list-kelas").value;

        if (date === "") {
            xmlhttp.open("GET", "search_list.php?kelas=" + kelas, true);
            xmlhttp.send();
        } else if (kelas === "None") {
            xmlhttp.open("GET", "search_list.php?date=" + date, true);
            xmlhttp.send();
        } else if (date === "" && kelas === "None") {
            xmlhttp.open("GET", "search_list.php", true);
            xmlhttp.send();
        } else {
            xmlhttp.open("GET", "search_list.php?date=" + date + "&kelas=" + kelas, true);
            xmlhttp.send();
        }
    }
</script>
</body>
</html>