<?php
require('dbConn.php');

if (isset($_GET['date']) && isset($_GET['kelas'])) {
    $date = $_GET['date'];
    $kelas = $_GET['kelas'];

    // tabel ruangan
    $sqlRuangan = "SELECT daftar_ruangan.nama_ruangan, peminjaman_ruangan.tanggal_pinjam, peminjaman_ruangan.waktu_awal, peminjaman_ruangan.waktu_akhir, peminjaman_ruangan.keterangan
                FROM `daftar_ruangan` INNER JOIN peminjaman_ruangan ON daftar_ruangan.nama_ruangan = peminjaman_ruangan.nama_ruangan 
                WHERE peminjaman_ruangan.status_pinjam = 'Booked' AND peminjaman_ruangan.tanggal_pinjam = '" . $date . "' AND daftar_ruangan.nama_ruangan = '" . $kelas . "' ORDER by peminjaman_ruangan.nama_ruangan ASC, peminjaman_ruangan.waktu_awal ASC";
    $resultRuangan = $conn->query($sqlRuangan);
} else if (isset($_GET['date'])) {
    $date = $_GET['date'];

    // tabel ruangan
    $sqlRuangan = "SELECT daftar_ruangan.nama_ruangan, peminjaman_ruangan.tanggal_pinjam, peminjaman_ruangan.waktu_awal, peminjaman_ruangan.waktu_akhir, peminjaman_ruangan.keterangan
                FROM `daftar_ruangan` INNER JOIN peminjaman_ruangan ON daftar_ruangan.nama_ruangan = peminjaman_ruangan.nama_ruangan 
                WHERE peminjaman_ruangan.status_pinjam = 'Booked' AND peminjaman_ruangan.tanggal_pinjam = '" . $date . "' ORDER by peminjaman_ruangan.nama_ruangan ASC, peminjaman_ruangan.waktu_awal ASC";
    $resultRuangan = $conn->query($sqlRuangan);
} else if (isset($_GET['kelas'])) {
    $kelas = $_GET['kelas'];

    // tabel ruangan
    $sqlRuangan = "SELECT daftar_ruangan.nama_ruangan, peminjaman_ruangan.tanggal_pinjam, peminjaman_ruangan.waktu_awal, peminjaman_ruangan.waktu_akhir, peminjaman_ruangan.keterangan
                FROM `daftar_ruangan` INNER JOIN peminjaman_ruangan ON daftar_ruangan.nama_ruangan = peminjaman_ruangan.nama_ruangan 
                WHERE peminjaman_ruangan.status_pinjam = 'Booked' AND daftar_ruangan.nama_ruangan = '" . $kelas . "' ORDER by peminjaman_ruangan.nama_ruangan ASC, peminjaman_ruangan.waktu_awal ASC";
    $resultRuangan = $conn->query($sqlRuangan);
} else {
    // tabel ruangan
    $sqlRuangan = "SELECT daftar_ruangan.nama_ruangan, peminjaman_ruangan.tanggal_pinjam, peminjaman_ruangan.waktu_awal, peminjaman_ruangan.waktu_akhir, peminjaman_ruangan.keterangan
                FROM `daftar_ruangan` INNER JOIN peminjaman_ruangan ON daftar_ruangan.nama_ruangan = peminjaman_ruangan.nama_ruangan 
                WHERE peminjaman_ruangan.status_pinjam = 'Booked' ORDER by peminjaman_ruangan.nama_ruangan ASC, peminjaman_ruangan.waktu_awal ASC";
    $resultRuangan = $conn->query($sqlRuangan);
}
?>

<div class="table100">
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
        } else {
            echo "<tr>";
            echo "<td class='column1'>" . 'tidak ada' . "</td>";
            echo "</tr>";
        }
        ?>
        </tbody>
    </table>
</div>