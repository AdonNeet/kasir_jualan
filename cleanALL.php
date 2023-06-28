<?php

include "./connDB.php";

/*
    this program is for purge all data and reset the database :D

*/

// delete all log and data
$q1 = 'delete from log_gudang where no_logG in (select no_logG from log_gudang)';
$rest = mysqli_query($koneksi, $q1);

$q1 = 'delete from log_barang where no_logB in (select no_logB from log_barang)';
$rest = mysqli_query($koneksi, $q1);

$q1 = 'delete from transaksi where no_transaksi in (select no_transaksi from transaksi)';
$rest = mysqli_query($koneksi, $q1);

$q1 = 'delete from gudang where id_rak in (select id_rak from gudang)';
$rest = mysqli_query($koneksi, $q1);

$q1 = 'delete from barang where id_stuff in (select id_stuff from barang)';
$rest = mysqli_query($koneksi, $q1);

// reset all serial num 
$q1 = 'alter table log_barang AUTO_INCREMENT = 1';
$rest = mysqli_query($koneksi, $q1);

$q1 = 'alter table log_gudang AUTO_INCREMENT = 1';
$rest = mysqli_query($koneksi, $q1);

$q1 = 'alter table gudang AUTO_INCREMENT = 1';
$rest = mysqli_query($koneksi, $q1);

?>