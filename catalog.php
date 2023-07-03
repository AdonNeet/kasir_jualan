<?php
include './connDB.php';
?>

<!-- HTML section -->

<!DOCTYPE html>
<html lang="eng">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catalog</title>
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
                        <li><a href="staff.php" data-after="Karyawan">Karyawan</a></li>
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
        <!--untuk mengeluarkan data-->
        <div class="card">
            <div class="card-header text-white bg-secondary">
                Data Barang
            </div>
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">ID Barang</th>
                            <th scope="col">Nama Barang</th>
                            <th scope="col">Kategori</th>
                            <th scope="col">Harga</th>
                            <th scope="col">Stok</th>
                            <th scope="col">Aksi</th>
                        </tr>
                        <tbody>
                            <?php
                            $sql2   = "select * from barang order by id_stuff asc";
                            $q2     = mysqli_query($koneksi, $sql2);
                            $urut   = 1;
                            while($r2 = mysqli_fetch_array($q2)){
                                $id_stuff     = $r2['id_stuff'];
                                $stuff_name   = $r2['stuff_name'];
                                $kategori = $r2['kategori'];
                                $harga = $r2['harga'];

                                // get stok from gudang
                                $sql3 = "select stok from gudang where id_stuff = '$id_stuff'";
                                $q3 = mysqli_query($koneksi, $sql3);
                                $r3 = mysqli_fetch_array($q3);
                                $stok = $r3['stok'];

                                ?>
                                <tr>
                                    <td scope="row"><?php echo $urut++?></td>
                                    <td scope="row"><?php echo $id_stuff?></td>
                                    <td scope="row"><?php echo $stuff_name?></td>
                                    <td scope="row"><?php echo $kategori?></td>
                                    <td scope="row"><?php echo $harga?></td>
                                    <td scope="row"><?php echo $stok?></td>
                                    <td scope="row">
                                        <a href="editCatalog.php?op=edit&id=<?php echo $id_stuff ?>">
                                            <button type="button" class="btn btn-warning"> Edit </button>
                                        </a>
                                        <a href="delCatalog.php?op=delete&id=<?php echo $id_stuff ?>" onclick="return confirm('Yakin akan mendelete data?')">
                                            <button type="button" class="btn btn-danger"> Delete </button>
                                        </a>
                                    </td>
                                </tr>
                                <?php
                            }
                            ?>
                        </tbody>
                    </thead>
                </table>
                <a href="editCatalog.php?op=insert">
                    <button type="button" class="btn btn-warning"> Add </button>
                </a>
            </div>
        </div>
    </div>
    <script src="app.js"></script>
</body>