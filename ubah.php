<?php
require('dbConn.php');

session_start();

if (!isset($_SESSION['nim'])) {
//    echo '<script>window.location.href = "http://pkl-fk.000webhostapp.com/";</script>';
    echo '<script>window.location.href = "http://localhost/webMCU/";</script>';
}


$sql = "select * from peminjaman_ruangan where status_pinjam='Booked' AND nim_mahasiswa='" . $_SESSION['nim'] . "'";
$result = $conn->query($sql);

if ($result->num_rows <= 0) {
    echo "<script>alert(\"tidak ada data\")</script>";
//    echo '<script>window.location.href = "http://pkl-fk.000webhostapp.com/history.php";</script>';
    echo '<script>window.location.href = "http://localhost/webMCU/history.php";</script>';
}

if (isset($_POST['selesai'])) {

    $sql = "update peminjaman_ruangan set status_pinjam='Done'
            where status_pinjam='Booked' AND nim_mahasiswa='" . $_SESSION['nim'] . "' AND id_peminjaman='" . $_POST['idBerow'] . "'";

    if ($conn->query($sql) === TRUE) {
//        echo '<script>window.location.href = "http://pkl-fk.000webhostapp.com/history.php";</script>';
        echo '<script>window.location.href = "http://localhost/webMCU/history.php";</script>';
    } else {
        echo "<script>alert($conn->error)</script>";
    }
}

if (isset($_POST['batal'])) {
    $sql = "delete from peminjaman_ruangan
            where status_pinjam='Booked' AND nim_mahasiswa='" . $_SESSION['nim'] . "' AND id_peminjaman='" . $_POST['idBerow'] . "'";

    if ($conn->query($sql) === TRUE) {
//        echo '<script>window.location.href = "http://pkl-fk.000webhostapp.com/history.php";</script>';
        echo '<script>window.location.href = "http://localhost/webMCU/history.php";</script>';
    } else {
        echo "<script>alert($conn->error)</script>";
    }
}

if (isset($_POST['update'])) {
//    echo '<script>window.location.href = "http://pkl-fk.000webhostapp.com/update.php?idBerow=' . $_POST['idBerow'] . '";</script>';
    echo '<script>window.location.href = "http://localhost/webMCU/update.php?idBerow='.$_POST['idBerow'].'";</script>';
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
    <h5 class="my-0 mr-md-auto font-weight-normal">Peminjaman Anda </h5>
    <?php include 'nav.php' ?>
</div>

<div class="limiter">
    <div class="container-table100">
        <div class="wrap-table100">
            <div class="table100" style="background-color: white; border-radius: 10px;">
                <table>
                    <thead>
                    <tr class="table100-head">
                        <th class="column1">No</th>
                        <th class="column2">NIM</th>
                        <th class="column3">Kelas</th>
                        <th class="column4">Keterangan</th>
                        <th class="column5">Jam Mulai</th>
                        <th class="column6">Jam Selesai</th>
                        <th class="column7">Tanggal</th>
                        <th class="column8">Setatus</th>
                        <th class="column9">Edit</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    if ($result->num_rows > 0) {
                        $no = 1;
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td class='column1 ubah'>" . $no . "</td>";
                            echo "<td class='column2 ubah'>" . $row['nim_mahasiswa'] . "</td>";
                            echo "<td class='column3 ubah'>" . $row['nama_ruangan'] . "</td>";
                            echo "<td class='column4 ubah'>" . $row['keterangan'] . "</td>";
                            echo "<td class='column5 ubah' id='jamMulai'>" . $row['waktu_awal'] . "</td>";
                            echo "<td class='column6 ubah' id='jamSelesai'>" . $row['waktu_akhir'] . "</td>";
                            echo "<td class='column7 ubah' id='tanggal'>" . $row['tanggal_pinjam'] . "</td>";
                            echo "<td class='column8 ubah'>" . $row['status_pinjam'] . "</td>";
                            echo "<td class='column9 ubah'>
                                    <form method=\"post\">
                                    <input type='hidden' value='" . $row["id_peminjaman"] . "' name='idBerow'>
                                        <button type=\"submit\" 
                                                id='selesai_" . $row["id_peminjaman"] . "'
                                                class='btn btn-success m-2 selesai_" . $row["id_peminjaman"] . "'
                                                name='selesai'
                                                data-toggle=\"tooltip\" 
                                                data-placement=\"bottom\" 
                                                title=\"Selesai\"
                                                onclick=\"return selesaiBerow('" . $row["waktu_awal"] . "', '" . $row["waktu_akhir"] . "', '" . $row['tanggal_pinjam'] . "')\"
                                                >
                                                
                                                <div class='icon'>
                                                    <i class=\"fa fa-check\"></i>
                                                </div>
                                        </button>
                                        <button type=\"submit\" 
                                                id='update_" . $row["id_peminjaman"] . "'
                                                class='btn btn-primary m-2 update_" . $row["id_peminjaman"] . "'
                                                name='update'
                                                data-toggle=\"tooltip\" 
                                                data-placement=\"bottom\" 
                                                title=\"Update\"
                                                onclick=\"return deleteLanUpdateBerow('" . $row["waktu_awal"] . "', '" . $row["waktu_akhir"] . "', '" . $row['tanggal_pinjam'] . "')\"
                                                >
                                                
                                                <div class='icon'>
                                                    <i class=\"fa fa-refresh\"></i>
                                                </div>
                                        </button>
                                        <button type=\"submit\" 
                                                id='batal_" . $row["id_peminjaman"] . "' 
                                                class='btn btn-danger m-2 batal_" . $row["id_peminjaman"] . "' 
                                                name='batal'
                                                data-toggle=\"tooltip\" 
                                                data-placement=\"bottom\" 
                                                title=\"Batal\"
                                                onclick=\"return deleteLanUpdateBerow('" . $row["waktu_awal"] . "', '" . $row["waktu_akhir"] . "', '" . $row['tanggal_pinjam'] . "')\"
                                                >
                                                
                                                <div class='icon'>
                                                    <i class=\"fa fa-trash\"></i>
                                                </div>
                                        </button>
                                    </form>
                                  </td>";
                            echo "</tr>";
                            $no++;
                        }
                    } else {
                        echo "<script>window.location.href = \"http://pkl-fk.000webhostapp.com/insert.php\";</script>";
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
<!--===============================================================================================-->
<script>
    var hariIni = new Date();

    var dd = String(hariIni.getDate()).padStart(2, '0');
    var mm = String(hariIni.getMonth() + 1).padStart(2, '0');
    var yyyy = hariIni.getFullYear();
    var tanggalSekarang = yyyy + '-' + mm + '-' + dd;

    var jam = String(hariIni.getHours()).padStart(2, '0');
    var menit = String(hariIni.getMinutes()).padStart(2, '0');
    var detik = String(hariIni.getSeconds());
    var jamSekarang = jam + ":" + menit + ":" + detik;

    function selesaiBerow(waktuAwal, waktuAkhir, tanggal) {
        if (tanggalSekarang > tanggal || tanggalSekarang == tanggal) {
            if(tanggalSekarang === tanggal) {
                if (jamSekarang > waktuAwal) {
                    alert('bisa');
                    return true;
                } else {
                    alert('tidak');
                    return false;
                }
            } else {
                alert('bisa');
                return true;
            }
        } else {
            alert('tidak');
            return false;
        }
    }

    function deleteLanUpdateBerow(waktuAwal, waktuAkhir, tanggal) {
        if (tanggalSekarang < tanggal || tanggalSekarang === tanggal) {
            if (tanggalSekarang === tanggal) {
                if (jamSekarang < waktuAwal) {
                    alert('bisa');
                    return true;
                } else {
                    alert('tidak');
                    return false;
                }
            } else {
                alert('bisa');
                return true;
            }
        } else {
            alert('tidak');
            return false;
        }
    }

</script>
</body>
</html>