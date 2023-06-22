<?php
$host = "localhost";
$user = "root";
$pass = "";
$database = "supermarket";
$koneksi = mysqli_connect($host, $user, $pass, $database);

$transaksi = "";
$tanggal = "";
$idbfk = "";
$idkfk = "";
$jumlah = "";
$password = "";
$error = "";
$sukses = "";

if (isset($_POST['submit'])) {
    $transaksi = $_POST['nomor'];
    $tanggal = $_POST['date'];
    $idbfk = $_POST['idbfk'];
    $idkfk = $_POST['idkfk'];
    $jumlah = $_POST['jumlah'];
    $password = $_POST['password'];

    if ($transaksi && $tanggal && $idbfk && $idkfk && $jumlah && $password) {
        $query  = "insert into transaksi(no, tanggal, id_barangFK, id_karyawanFK, jumlah, password) values ('$transaksi', '$tanggal', $idbfk, '$idkfk', $jumlah, '$password');";
        $query .= "delete from transaksi where password not in(select password from karyawan)";
        $commit = mysqli_multi_query($koneksi, $query);
        if($commit){
            $sukses = "Data berhasil masuk";
        }else{
            $error  = "Data Gagal masuk";
        }
    } else {
        $error = "Silahkan Mengisi Form";
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
                if ($error) {
                    ?>
                    <div class="alert alert-danger" role="alert">
                        <?php echo $error ?>
                    </div>
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
                        <label for="No" class="col-sm-2 col-form-label">No Transakasi</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="ID" name="nomor"
                                value="<?php echo $transaksi; ?>">
                        </div>
                    </div>

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
                            <input type="text" class="form-control" id="ID" name="idbfk" value="<?php echo $idbfk ?>">
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label for="Karyawan" class="col-sm-2 col-form-label">Id Karyawan</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="ID" name="idkfk" value="<?php echo $idkfk ?>">
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
                            <input type="text" class="form-control" id="ID" name="password"
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