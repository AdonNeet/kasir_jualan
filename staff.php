<?php
include "connDB.php";

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Karyawan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz"
        crossorigin="anonymous"></script>
    <link rel="stylesheet" href="navbar.css">
    <style>
        .card {
            margin-top: 80px;
        }

        .mx-auto {
            width: 86vw;
        }
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
        <div class="card">
            <div class="card-header text-white bg-secondary">
                Data Nasabah
            </div>
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">ID</th>
                            <th scope="col">Nama</th>
                            <th scope="col">Posisi</th>
                        </tr>
                    <tbody>
                        <?php
                        $sql2 = "select * from karyawan order by id_staff asc";
                        $q2 = mysqli_query($koneksi, $sql2);
                        $urut = 1;
                        while ($r2 = mysqli_fetch_array($q2)) {
                            $id = $r2['id_staff'];
                            $nama = $r2['name'];
                            $posisi = $r2['job'];

                            ?>
                            <tr>
                                <th scope="row">
                                    <?php echo $urut++ ?>
                                </th>
                                <th scope="row">
                                    <?php echo $id ?>
                                </th>
                                <th scope="row">
                                    <?php echo $nama ?>
                                </th>
                                <th scope="row">
                                    <?php echo $posisi ?>
                                </th>
                            </tr>
                            <?php
                        }
                        ?>
                    </tbody>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>
<script src="app.js"></script>
</body>
</html>