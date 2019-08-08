<?php
require('dbConn.php');

    echo date('Y-m-d');
    if(date('Y-m-d') > '2019-06-12') {
        echo "<br>hore<br>";
    }

if ('09:00:00' >= '08:00:00') {
    echo "siappp<br>";
}

if ('09:00:00' >= '08:00:00' && date('Y-m-d') > '2019-06-12') {
    echo "dua<br>";
} else {
    echo "tidak dua<br>";
}
?>