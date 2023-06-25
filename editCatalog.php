<?php
include "../connDB.php";
$today = date("Y-m-d");

$error1 = "";
$error2 = "";
$error3 = "";
$sukses = "";

$id_stuff = "";
$stuff_name = "";
$kategori = "";
$harga = "";
$stok = "";

$jumlah = "";

$id_stuffOLD = "";

$id_stuff2 = "";
$stuff_name2 = "";
$kategori2 = "";
$harga2 = "";
$stok2 = "";

$id_staff = "";
$pass = "";
$job = "";

$passNow = "";

if(isset($_GET['op'])){
    $op = $_GET['op'];
}else{
    $op = "";
}

// delete barang
if($op == 'delete'){
    $id_staff = $_POST['id_staff'];
    $pass = $_POST['pass'];

    // get pass from id staff
    if($id_staff != ""){
        $q1 = "select pass from karyawan where id_staff = '$id_staff'";
        $rest = mysqli_query($koneksi, $q1);
        $r2 = mysqli_fetch_assoc($rest);
        if(is_null($r2) == false){
            $passNow = strval($r2['pass']);
        } else {
            $error2 = "Terdapat kesalahan pada id_staff atau password";
        }
    } else {
        $error2 = "Silahkan masukkan id_staff";
    }

    // get to know the job
    if($passNow != ""){
        $q1 = "select job from karyawan where id_staff = '$id_staff'";
        $rest = mysqli_query($koneksi, $q1);
        $r2 = mysqli_fetch_assoc($rest);
        if(strval($r2['job']) == 'Gudang'){
            $job = "Gudang";
        } else {
            $error3 = "Kasir tidak dapat memanipulasi barang";
        }
    } 

    if($id_staff != "" and $pass != "" and $job == 'Gudang'){
        if($pass == $passNow){
            $ID = $_GET['id'];
            $sql1 = "select * from barang where id_stuff = '$ID'";
            $q1 = mysqli_query($koneksi, $sql1);
            $r1 = mysqli_fetch_array($q1);

            $id = $r1['id_stuff'];
            $name = $r1['stuff_name'];
            $category = $r1['kategori'];
            $price = $r1['harga'];


            $sql1   = "delete from barang where id_stuff = '$ID'";
            $q1     = mysqli_query($koneksi, $sql1);
            if($q2){
                $sukses = "Berhasil menghapus data";
                // insert into log_barang
                $sql1 = "insert into log_barang(id_staff, tanggal, id_stuff, stuff_name, kategori, harga, ket) values ('O01', '$today', '$id', '$name', '$category', $price, 'withdraw')";
                $q1 = mysqli_query($koneksi, $sql1);

                // get id_rak
                $q1 = "select gudang.id_rak from barang natural join gudang where id_stuff = '$id'";
                $rest = mysqli_query($koneksi, $q1);
                $r = mysqli_fetch_array($rest);
                $id_rak = $r['id_rak'];

                // get stok saat ini
                $q2 = "select stok from gudang where id_rak = '$id_rak'";
                $rest = mysqli_query($koneksi, $q2);
                $r = mysqli_fetch_array($rest);
                $stock = $r['stok'];

                // delete seluruh stok berdasarkan id_rak
                $q3 = "delete from gudang where id_rak = '$id_rak'";
                $commit = mysqli_query($koneksi, $q3);

                // insert into log_gudang
                $q4 = "insert into log_gudang(tanggal, id_staff, id_rak, jumlah, ket) values ('$today', '$id_staff', '$id_rak', $stock, 'withdraw')";
                $commit = mysqli_query($koneksi, $q4);
            }else{
                $error  = "Gagal menghapus data";
            }
        } else {
            $error2 = "Terdapat kesalahan pada id_staff atau password";
        }
    }
}

// for update and insert new stuff
if(isset($_POST['submit'])){
    $id_staff = $_POST['id_staff'];
    $pass = $_POST['pass'];

    // get pass from id staff
    if($id_staff != ""){
        $q1 = "select pass from karyawan where id_staff = '$id_staff'";
        $rest = mysqli_query($koneksi, $q1);
        $r2 = mysqli_fetch_assoc($rest);
        if(is_null($r2) == false){
            $passNow = strval($r2['pass']);
        } else {
            $error2 = "Terdapat kesalahan pada id_staff atau password";
        }
    } else {
        $error2 = "Silahkan masukkan id_staff";
    }

    if($passNow != ""){
        $q1 = "select job from karyawan where id_staff = '$id_staff'";
        $rest = mysqli_query($koneksi, $q1);
        $r2 = mysqli_fetch_assoc($rest);
        if(strval($r2['job']) == 'Gudang'){
            $job = "Gudang";
        } else {
            $error3 = "Kasir tidak dapat memanipulasi gudang";
        }
    } 

    if($id_staff != "" and $pass != "" and $job == 'Gudang'){
        if($pass == $passNow){
            //Untuk Update
            if($op == 'edit'){
                $id_stuffOLD = $_GET['id'];
                $id_stuff2 = $_POST['id_stuff2'];
                $stuff_name2 = $_POST['stuff_name2'];
                $kategori2 = $_POST['kategori2'];
                $harga2 = $_POST['harga2'];
                $stok2 = $_POST['stok2'];

                $sql1       = "update barang set id_stuff = '$id_stuff2', stuff_name = '$stuff_name2', kategori = '$kategori2', harga = $harga2 where id_stuff = '$id_stuffOLD'";
                $q1         = mysqli_query($koneksi, $sql1);
                if($q1){
                    $sukses = "Data berhasil diupdate";

                    // insert into log_barang
                    $sql1 = "insert into log_barang(id_staff, tanggal, id_stuff, stuff_name, kategori, harga, ket) values ('$id_staff', '$today', '$id_stuff2', '$stuff_name2', '$kategori2', $harga2, 'edited')";
                    $q1 = mysqli_query($koneksi, $sql1);

                    // jika id_stuff diganti, ganti juga digudang
                    if($id_stuff2 != $id_stuffOLD){
                        $sql = "update gudang set id_stuff = '$id_stuff2' where id_stuff = '$id_stuffOLD'";
                        $id_staffNow = $id_stuff2;
                        $q1 = mysqli_query($koneksi, $sql);
                    }                    

                    // get id_rak
                    $q1 = "select gudang.id_rak from barang natural join gudang where id_stuff = '$id_stuff2'";
                    $rest = mysqli_query($koneksi, $q1);
                    $r = mysqli_fetch_array($rest);
                    $id_rak = $r['id_rak'];

                    // get stok saat ini
                    $q2 = "select stok from gudang where id_rak = '$id_rak'";
                    $rest = mysqli_query($koneksi, $q2);
                    $r = mysqli_fetch_array($rest);
                    $stock = $r['stok'];
                    $stock = (int)$stock;

                    // update stok berdasarkan id_rak
                    $q3 = "update gudang set stok = $stok2 where id_rak = '$id_rak'";
                    $commit = mysqli_query($koneksi, $q3);

                    // check stok with stok 2, then insert in log_gudang
                    if($stock > $stok2){
                        $jumlah = $stock - $stok2;
                        $q4 = "insert into log_gudang(tanggal, id_staff, id_rak, jumlah, ket) values ('$today', '$id_staff', '$id_rak', $jumlah, 'reduce')";
                    $commit = mysqli_query($koneksi, $q4);
                    }else if($stock < $stok2){
                        $jumlah = $stok2 - $stock;
                        $q4 = "insert into log_gudang(tanggal, id_staff, id_rak, jumlah, ket) values ('$today', '$id_staff', '$id_rak', $jumlah, 'add')";
                    $commit = mysqli_query($koneksi, $q4);
                    }
                }else{
                    $error3  = "Data gagal diupdate";
                }
            //Untuk Insert barang baru (main problem)
            }else if($op == "insert"){
                $id_stuff = $_POST['id_stuff2'];
                $stuff_name = $_POST['stuff_name2'];
                $kategori = $_POST['kategori2'];
                $harga = $_POST['harga2'];
                $stok = $_POST['stok2']; 

                if($id_stuff != "" and $stuff_name != "" and $kategori != "" and $harga != "" and $stok != ""){
                    $sql1   = "insert into barang(id_stuff, stuff_name, kategori, harga) values ('$id_stuff', '$stuff_name', '$kategori', $harga)";
                    $q1     = mysqli_query($koneksi, $sql1);
                    if($q1){
                        $sukses     = "Berhasil memasukkan data";

                        // insert into log_barang
                        $sql1 = "insert into log_barang(id_staff, tanggal, id_stuff, stuff_name, kategori, harga, ket) values ('O01', '$today', '$id', '$name', '$category', $price, 'withdraw')";
                        $q1 = mysqli_query($koneksi, $sql1);

                        // insert into a new rak in gudang, use substr

                        // old code below
                        // get id_rak
                        $q1 = "select gudang.id_rak from barang natural join gudang where id_stuff = '$id'";
                        $rest = mysqli_query($koneksi, $q1);
                        $r = mysqli_fetch_array($rest);
                        $id_rak = $r['id_rak'];

                        // get stok saat ini
                        $q2 = "select stok from gudang where id_rak = '$id_rak'";
                        $rest = mysqli_query($koneksi, $q2);
                        $r = mysqli_fetch_array($rest);
                        $stock = $r['stok'];

                        // insert stok berdasarkan id_rak, make new id rak
                        $q3 = "update from gudang where id_rak = '$id_rak'";
                        $commit = mysqli_query($koneksi, $q3);

                        // insert into log_gudang
                        $q4 = "insert into log_gudang(tanggal, id_staff, id_rak, jumlah, ket) values ('$today', '$id_staff', '$id_rak', $stok, 'add')";
                        $commit = mysqli_query($koneksi, $q4);
                    }else{
                        $error      = "Gagal memasukkan data";
                    }
                }else{
                    $error3  = "Silahkan memasukkan data";
                }
            }
        } else {
            $error3 = "Terdapat kesalahan pada id_staff atau password";
        }
    } else {
        $error2 = "Silahkan masukkan password";
    }

    
}

// menampilkan value pada form
if($op == 'edit' & isset($_GET['id'])){
    $id_stuffOLD = $_GET['id'];
    if(isset($_POST['submit']) and $id_stuffOLD != $_POST['id_stuff2']){
        $id_stuffOLD = $_POST['id_stuff2'];
        $sql1 = "select * from barang where id_stuff = '$id_stuffOLD'";
        $q1 = mysqli_query($koneksi, $sql1);
        $r1 = mysqli_fetch_array($q1);

        $id_stuff2 = $r1['id_stuff'];
        $stuff_name2 = $r1['stuff_name'];
        $kategori2 = $r1['kategori'];
        $harga2 = $r1['harga'];

        $sql1 = "select stok from gudang where id_stuff = '$id_stuff2'";
        $q1 = mysqli_query($koneksi, $sql1);
        $r1 = mysqli_fetch_array($q1);

        $stok2 = $r1['stok'];

        if($id_stuff2 == ''){
            $error = "Data tidak ditemukan";
        }
    }else {
        $sql1 = "select * from barang where id_stuff = '$id_stuffOLD'";
        $q1 = mysqli_query($koneksi, $sql1);
        $r1 = mysqli_fetch_array($q1);

        $id_stuff2 = $r1['id_stuff'];
        $stuff_name2 = $r1['stuff_name'];
        $kategori2 = $r1['kategori'];
        $harga2 = $r1['harga'];

        $sql1 = "select stok from gudang where id_stuff = '$id_stuff2'";
        $q1 = mysqli_query($koneksi, $sql1);
        $r1 = mysqli_fetch_array($q1);

        $stok2 = $r1['stok'];

        if($id_stuff2 == ''){
            $error = "Data tidak ditemukan";
        }
    }
    
}

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
        <style>
            .mx-auto {width:800px}
            .card {margin-top: 10px}
            .col-12 {margin-bottom : 10px}
        </style>
</head>

<body>
    <div class="mx-auto">
        <!--untuk memasukkan data-->
        <div class="card">
            <div class="card-header">
                <?php   // header dinamis berdasarkan op saat itu :D
                if($op == 'insert'){
                    echo 'Tambahkan data';
                }else {
                    echo 'Edit data';
                }
                ?>
            </div>
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
                        <label for="id_stuff2" class="col-sm-2 col-form-label">ID Barang</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="ID" name="id_stuff2" value="<?php echo $id_stuff2 ?>"></input>
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label for="stuff_name2" class="col-sm-2 col-form-label">Nama Barang</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="ID" name="stuff_name2" value="<?php echo $stuff_name2 ?>"></input>
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label for="kategori2" class="col-sm-2 col-form-label">Kategori</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="ID" name="kategori2" value="<?php echo $kategori2 ?>"></input>
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label for="harga2" class="col-sm-2 col-form-label">Harga</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="ID" name="harga2" value="<?php echo $harga2 ?>"></input>
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label for="harga2" class="col-sm-2 col-form-label">Stok</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="ID" name="stok2" value="<?php echo $stok2 ?>"></input>
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label for="Karyawan" class="col-sm-2 col-form-label">Id Karyawan</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="ID" name="id_staff" placeholder="id_staff" value="<?php echo $id_staff ?>">
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label for="No" class="col-sm-2 col-form-label">Password</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="ID" name="pass"
                                value="<?php echo $pass ?>">
                        </div>
                    </div>

                    
                    <div class="col-12">
                        <a href="editCatalog.php?op=edit&id=<?php  
                            if(isset($_POST[$id_stuff2]) == false){
                                echo $id_stuff2;
                            }else {
                                echo $_POST[$id_stuff2];
                            }         
                        ?>">
                            <button type="submit" name="submit" value="Simpan Data" class="btn btn-primary"> Simpan Data </button>
                        </a> 
                    </div>
                    
                    <div class="col-1">
                        
                    </div>
            </div>
            
        </div>

        <div class="mb-3 row">
            <label><br><br>
                    Note: <br>
                        - Setelah mengubah id barang dan atau menghapus barang, kilk edit/delete pada barang yang ingin diubah <br>
                        - Jika ingin menambah data barang yang baru klik add <br>
            </label>
        </div>

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
                <div class="mb-3">
                    <a href="editCatalog.php?op=insert">
                        <button type="button" class="btn btn-warning"> Add </button>
                    </a>
                    <a href="catalog.php">
                        <button type="button" class="btn btn-warning"> Kembali ke katalog </button>
                    </a>
                </div>
            </div>
        </div>
    </div>
</body>