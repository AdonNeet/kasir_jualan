<?php
include "./connDB.php";

$id_staff = "K01";
$name = "Azza_228";
$job = "Kasir";
$alamat = "earth";
$pass = "12345678";

$sql = "INSERT INTO karyawan(id_staff, name, job, alamat, pass) VALUES('$id_staff', '$name', '$job','$alamat', '$pass')";

$res = mysqli_query($koneksi, $sql);

$id_staff = "G01";
$name = "Bara_194";
$job = "Gudang";
$alamat = "isekai";
$pass = "qwertyui";

$sql = "INSERT INTO karyawan(id_staff, name, job, alamat, pass) VALUES('$id_staff', '$name', '$job','$alamat', '$pass')";

$res = mysqli_query($koneksi, $sql);

$id_staff = "G02";
$name = "Damara_229";
$job = "Gudang";
$alamat = "earth";
$pass = "asdfghjk";

$sql = "INSERT INTO karyawan(id_staff, name, job, alamat, pass) VALUES('$id_staff', '$name', '$job','$alamat', '$pass')";

$res = mysqli_query($koneksi, $sql);



?>