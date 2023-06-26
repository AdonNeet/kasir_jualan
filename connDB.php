<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "market";

/* You should enable error reporting for mysqli before attempting to make a connection */
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

$koneksi = mysqli_connect($servername, $username, $password, $dbname);

/* Set the desired charset after establishing a connection */
mysqli_set_charset($koneksi, 'utf8mb4');

// printf("Success... %s\n", mysqli_get_host_info($mysqli));
?>