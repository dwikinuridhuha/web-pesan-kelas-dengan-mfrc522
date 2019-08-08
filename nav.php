<?php 
    // online
    echo '
    <nav class="my-2 my-md-0 mr-md-3 topnav" id="myTopNav">
        <a class="p-2 text-dark" href="http://localhost/webMCU/booked.php">Daftar Kelas Terpinjam</a>
        <a class="p-2 text-dark" href="http://localhost/webMCU/history.php">Riwayat</a>
        <a class="p-2 text-dark" href="http://localhost/webMCU/insert.php">Pilih Kelas</a>
        <a class="p-2 text-dark" href="http://localhost/webMCU/ubah.php">Ubah</a>
        
        <a href="javascript:void(0);" class="icon" onclick="myFunction()">
            <i class="fa fa-bars"></i>
        </a>
    </nav>';

if(!isset($_SESSION['nim'])) {
    echo '<a class="" href=""></a>';
} else {
    echo '<a class="btn btn-outline-primary" href="http://localhost/webMCU/logout.php">LogOut</a>';
}
    // offline
//     echo '
//     <nav class="my-2 my-md-0 mr-md-3">
//         <a class="p-2 text-dark" href="http://localhost/webMCU/booked.php">Daftar Kelas Terpinjam</a>
//         <a class="p-2 text-dark" href="http://localhost/webMCU/history.php">Riwayat</a>
//         <a class="p-2 text-dark" href="http://localhost/webMCU/insert.php">Pilih Kelas</a>
//         <a class="p-2 text-dark" href="http://localhost/webMCU/ubah.php">Ubah</a>
//     </nav>';

// if(!isset($_SESSION['nim'])) {
//     echo '<a class="" href=""></a>';
// } else {
//     echo '<a class="btn btn-outline-primary" href="http://localhost/webMCU/logout.php">LogOut</a>';
// }

?>