<?php
include "./connDB.php";        // if in same folder just use /connDB.php

// deklarasi variable
$id_stuff = "";
$stuff_name = "";
$kategori = "";
$stok = "";
$harga = "";

$data = "";
$error  = "";
$sukses = "";

if(isset($_GET['op'])){
    $op = $_GET['op'];
}else{
    $op = "";
}

// function statement
?>



<!-- HTML section -->
<!DOCTYPE html>
<html lang="eng">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz"
        crossorigin="anonymous"></script>
    <link rel="stylesheet" href="navbar.css">
    <style>
            .mx-auto {width:800px}
            .card {margin-top: 80px}
            .col-12 {margin-bottom : 10px}
    </style>
</head>

<body>
    <section id="header">
        <div class="header container">
            <div class="nav-bar">
                <div class="brand">
                    <a href="#hero" data-text="sistem basis data" class="lampu">sistem basis data</a>
                </div>
                <div class="nav-list">
                    <div class="hamburger"><div class="bar"></div></div>
                    <ul>
                        <li><a href="index.html" data-after="Home">Home</a></li>
                        <li><a href="karyawan.php" data-after="Karyawan">Karyawan</a></li>
                        <li><a href="inTransaksi.php" data-after="Transaksi">Transaksi</a></li>
                        <li><a href="searchStuff.php" data-after="Cari Barang">Cari Barang</a></li>
                        <li><a href="catalog.php" data-after="Katalog">Katalog</a></li>
                        <!-- <li><a href="#" data-after="Home">Home</a></li> -->
                    </ul>
                </div>
            </div>
        </div>
    </section>


    <div class="mx-auto">
        <!--untuk memasukkan data-->
        <div class="card">
            <div class="card-header">
                Cari Informasi Barang
            </div>
            <div class="card-body">
                
                <?php 
                if($error){
                ?>
                    <div class="alert alert-danger" role="alert">
                        <?php echo $error?>
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
                
                <div class="mb-3 row">
                    <label>Mencari informasi barang berdasarkan id barang, nama barang dan atau kategori barang</label>
                </div>

                <form action="" method="post">
                    <div class="mb-3 row">
                        <label for="data" class="col-sm-2 col-form-label">Data</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="ID" name="data" value="<?php echo $data ?>"></input>
                        </div>
                    </div>

                    <div class="col-12">
                        <input type="submit" name="submit" value="Cari" class="btn btn-primary"></input>
                    </div>

                    <div class="col-1">
                        
                    </div>
            </div>
        </div>


        <!--untuk mengeluarkan data-->
        <div class="card">
            <div class="card-header text-white bg-secondary">
                Informasi Barang
            </div>
            <div class="card-body">
                <table class="table">
                <thead>
                        <tr>
                            <th scope="col">id_stuff</th>
                            <th scope="col">Nama Barang</th>
                            <th scope="col">kategori</th>
                            <th scope="col">Stok</th>
                            <th scope="col">Harga</th>
                        </tr>
                            <tbody>
                            <?php
                                if(isset($_POST['submit'])){
                                    $data = $_POST['data'];
                                    $sql1   = "select barang.id_stuff, barang.stuff_name, barang.kategori, gudang.stok, barang.harga from barang natural join gudang where barang.id_stuff='$data' or barang.stuff_name='$data' or barang.kategori='$data'";
                                    $result = mysqli_query($koneksi, $sql1);
                                    while($q1 = mysqli_fetch_assoc($result)){
                                        $id_stuff = $q1['id_stuff'];
                                        $stuff_name = $q1['stuff_name'];
                                        $kategori = $q1['kategori'];
                                        $stok = $q1['stok'];
                                        $harga = $q1['harga'];
                                        ?>
                                        <tr>
                                            <th scope="id"><?php echo $id_stuff ?></th>
                                            <th scope="nama"><?php echo $stuff_name ?></th>
                                            <th scope="nama"><?php echo $kategori ?></th>
                                            <th scope="posisi"><?php echo $stok ?></th>
                                            <th scope="posisi"><?php echo $harga ?></th>
                                        </tr>
                                        <?php
                                    }
                                } 
                            ?>
                            </tbody>
                        </thead>
                </table>
                <div class="mb-3">
                    <a href="inTransaksi.php">
                        <button type="button" class="btn btn-warning"> Kembali ke Transaksi </button>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <script src="app.js"></script>
</body>