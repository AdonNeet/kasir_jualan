<?php
include "../connDB.php";

$data = "";
$tanggal = "";
$stuff_name = "";
$id_stuff = "";
$id_staff = "";
$id_rak = "";
$stok = "";
$jumlah = "";
$pass = "";


$error1 = "";
$error2 = "";
$error3 = "";
$sukses = "";

$id_staffNow = "";


if (isset($_POST['submit'])) {
    $tanggal = $_POST['date'];
    $data = $_POST['data'];
    $id_staff = $_POST['id_staff'];
    $jumlah = $_POST['jumlah'];
    $pass = $_POST['pass'];

    if($data != ""){
        $q1 = "select id_stuff from barang where id_stuff = '$data' or stuff_name = '$data'";
        $rest = mysqli_query($koneksi, $q1);
        $r1 = mysqli_fetch_assoc($rest);
        if(is_null($r1) ==  false){
            $id_stuff = strval($r1['id_stuff']);
        }else {
            $error1 = "Barang tidak ditemukan";
        }
    } else {
        $error1 = "Silahkan masukkan barang";
    }

    if($pass != ""){
        $q1 = "select id_staff from karyawan where pass = '$pass'";
        $rest = mysqli_query($koneksi, $q1);
        $r2 = mysqli_fetch_assoc($rest);
        if(is_null($r2) == false){
            $id_staffNow = strval($r2['id_staff']);
        } else {
            $error2 = "terdapat kesalahan pada id_staff atau password";
        }
    } else {
        $error2 = "Silahkan masukkan password";
    }

    if($id_staff != "" and $id_staffNow != "" and is_null($r1) ==  false and is_null($r2) ==  false){
        if($id_staff == $id_staffNow){    
            if ($tanggal && $id_stuff && $id_staff && $jumlah) {
                // insert into transaksi
                $query  = "insert into transaksi(tanggal, id_stuff, id_staff, jumlah) values ('$tanggal', '$id_stuff', '$id_staff', $jumlah);";
                $commit = mysqli_query($koneksi, $query);
                if($commit){
                    $sukses = "Data berhasil masuk";
    
                    // get id_rak
                    $q1 = "select gudang.id_rak from barang natural join gudang where id_stuff = '$id_stuff'";
                    $rest = mysqli_query($koneksi, $q1);
                    $r = mysqli_fetch_array($rest);
                    $id_rak = $r['id_rak'];
    
                    // get stok saat ini
                    $q2 = "select stok from gudang where id_rak = '$id_rak'";
                    $rest = mysqli_query($koneksi, $q2);
                    $r = mysqli_fetch_array($rest);
                    $stok = $r['stok'];
    
                    // update jumlah stok dengan mengurangi berdasarkan jumlah saat ini
                    $stok = $stok - $jumlah;
                    $q3 = "update gudang set stok = $stok where id_rak = '$id_rak'";
                    $commit = mysqli_query($koneksi, $q3);
    
                    // insert into log
                    $q4 = "insert into log_gudang(tanggal, id_staff, id_rak, jumlah, ket) values ('$tanggal', '$id_staff', '$id_rak', $jumlah, 'reduce')";
                    $commit = mysqli_query($koneksi, $q4);
    
                }else{
                    $error  = "Data Gagal masuk";
                }
            }
        } else {
            $error3 = "terdapat kesalahan pada id_staff atau password";
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaski</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz"
        crossorigin="anonymous"></script>
    <style>
        .mx-auto {
            width: 800px
        }

        .card {
            margin-top: 10px
        }

        .card-header {
            background-color: black;
            color: white;
        }

        .col-12 {
            margin-bottom: 10px
        }
    </style>
</head>

<body>
    <div class="mx-auto">
        <div class="card">
            <div class="card-header">Input Transaksi</div>
            <div class="card-body">
                <?php
                if ($error1 or $error2 or $error3) {
                    ?>

                    <?php
                    if($error2){
                    ?>
                        <div class="alert alert-danger" role="alert">
                            <?php echo $error2 ?>
                        </div>
                    <?php
                    }
                    ?>

                    <?php
                    if($error1){
                    ?>
                        <div class="alert alert-danger" role="alert">
                            <?php echo $error1 ?>
                        </div>
                    <?php
                    }
                    ?>
                    
                    <?php
                    if($error3){
                    ?>
                        <div class="alert alert-danger" role="alert">
                            <?php echo $error3 ?>
                        </div>
                    <?php
                    }
                    ?>
                    <?php
                }
                ?>
                
                <?php 
                if($sukses){
                ?>
                    <div class="alert alert-success" role="alert">
                        <?php echo $sukses?>
                    </div>
                <?php
                }
                ?>

                <form action="" method="POST">
                    <div class="mb-3 row">
                        <label for="Tanggal" class="col-sm-2 col-form-label">Tanggal</label>
                        <div class="col-sm-10">
                            <input type="date" class="form-control" id="ID" name="date"
                                value="<?php echo $tanggal ?>">
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label for="Barang" class="col-sm-2 col-form-label">Id Barang</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="ID" name="data" placeholder="id_stuff atau stuff_name" value="<?php echo $data ?>">
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label for="Karyawan" class="col-sm-2 col-form-label">Id Karyawan</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="ID" name="id_staff" placeholder="id_staff" value="<?php echo $id_staff ?>">
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label for="jumlah" class="col-sm-2 col-form-label">Jumlah</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="ID" name="jumlah" value="<?php echo $jumlah ?>">
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label for="No" class="col-sm-2 col-form-label">Password</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="ID" name="pass"
                                value="<?php echo $password ?>">
                        </div>
                    </div>

                    <div class="col-12">
                        <input type="submit" name="submit" value="Simpan Data" class="btn btn-primary"></input>
                    </div>

                </form>
            </div>
        </div>
    </div>
</body>

</html>