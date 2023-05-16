<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
  </head>
  <body>
  <?php

$host       = "localhost";
$user       = "root";
$pass       = "";
$db         = "uas_ibrahim_hasan";

$koneksi    = mysqli_connect($host, $user, $pass, $db);
if (!$koneksi) { 
    die("Tidak bisa terkoneksi ke database");
}
$jenis          = "";
$harga          = "";
$jumlah         = "";
$gambar         = "";
$sukses         = "";
$error          = "";


if (isset($_GET['op'])) {
    $op = $_GET['op'];
} else {
    $op = "";
}
if($op == 'delete'){
    $idbaju         = $_GET['idbaju'];
    $sql1       = "delete from baju_ibrahim_hasan where idbaju = '$idbaju'";
    $q1         = mysqli_query($koneksi,$sql1);
    if($q1){
        $sukses = "Berhasil hapus data";
    }else{
        $error  = "Gagal melakukan delete data";
    }
}
if ($op == 'edit') {
    $idbaju         = $_GET['idbaju'];
    $sql1       = "select * from baju_ibrahim_hasan where idbaju = '$idbaju'";
    $q1         = mysqli_query($koneksi, $sql1);
    $r1         = mysqli_fetch_array($q1);
    $idbaju        = $r1['idbaju'];
    $jenis       = $r1['jenis'];
    $harga     = $r1['harga'];
    $jumlah   = $r1['jumlah'];
    $gambar   = $r1['gambar'];

    if ($idbaju == '') {
        $error = "Data tidak ditemukan";
    }
}
if (isset($_POST['simpan'])) { 
    $jenis       = $_POST['jenis'];
    $harga     = $_POST['harga'];
    $jumlah   = $_POST['jumlah'];
    $gambar   = $_POST['gambar'];

    
    if ($gambar && $jenis && $harga && $jumlah) {
        if ($op == 'edit') {
            $sql1       = "update baju_ibrahim_hasan set jenis='$jenis',harga = '$harga',jumlah='$jumlah',gambar='$gambar' where idbaju = '$idbaju'";
            $q1         = mysqli_query($koneksi, $sql1);
            if ($q1) {
                $sukses = "Data berhasil diupdate";
            } else {
                $error  = "Data gagal diupdate";
            }
        } else { 

            move_uploaded_file($_FILES[$gambar],"img/$gambar");
            $sql1   = "insert into baju_ibrahim_hasan (gambar,jenis,harga,jumlah) values ('$gambar','$jenis','$harga','$jumlah')";
            $q1     = mysqli_query($koneksi, $sql1);
            if ($q1) {
                $sukses     = "Berhasil memasukkan data baru";
            } else {
                $error      = "Gagal memasukkan data";
            }
        }
    } else {
        $error = "Silakan masukkan semua data";
    }

}

?>



   <div class="container">
    <div class="row">
      <div class="col-lg-12">
        <div class="card text-bg-dark">
          <h4>Adis Fashion Store</h4>
          <p>Toko online menjual berbagai pakaian seperti penjamas, daster, gamis, dll. Cek kami di Shopee:
            <a href="">Hijab</a>
          </p>
        </div>
      </div>
    </div>
   </div>
   <div class="container">
    <div class="row">
      <div class="col-lg-12">
        <table>
      <form action="" method="POST">
                    <div class="mb-3 row atasan_dikit">
                        <label for="jenis" class="col-sm-2 col-form-label">Jenis Barang</label>
                        <div class="col-sm-10">
                            <select class="form-control" name="jenis" idbaju="jenis" required="required">
                                <option value="">- Pilih Jenis -</option>
                                <option value="Daster" <?php if ($jenis == "Daster") echo "selected" ?>>Daster</option>
                                <option value="Kaos" <?php if ($jenis == "Kaos") echo "selected" ?>>Kaos</option>
                                <option value="Jeans" <?php if ($jenis == "Jeans") echo "selected" ?>>Jeans</option>
                                <option value="Kemeja" <?php if ($jenis == "Kemeja") echo "selected" ?>>Kemeja</option>
                                <option value="Kerudung" <?php if ($jenis == "Kerudung") echo "selected" ?>>Kerudung</option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-3 row">  
                        <label for="harga" class="col-sm-2 col-form-label">Harga Barang</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" required="required" id="harga" name="harga" value="<?php echo $harga ?>">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="jumlah" class="col-sm-2 col-form-label">Jumlah Barang</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="jumlah" required="required" name="jumlah" value="<?php echo $jumlah ?>">
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label for="jumlah" class="col-sm-2 col-form-label">Foto Barang</label>
                        <div class="col-sm-10">
                            <input type="file" accept="image/*" class="form-control" id="gambar" required="required" name="gambar" value="<?php echo $gambar ?>">
                        </div>
                    </div>
                    <div class="col-12">
                        <input type="submit" name="simpan" value="Simpan Data" class="btn btn-primary" />
                    </div>
                    </table>
                </form>

            </div>
        </div>
        </div>
      </div>
    </div>
   </div>



   <div class="card">
            <div class="card-header text-bg-dark">
                Data Barang
            </div>
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">ID Barang</th>
                            <th scope="col">Jenis Barang</th>
                            <th scope="col">Harga</th>
                            <th scope="col">Jumlah</th>
                            <th scope="col">Gambar</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql2   = "select * from baju_ibrahim_hasan order by idbaju desc";
                        $q2     = mysqli_query($koneksi, $sql2);
                        $urut   = 1;
                        while ($r2 = mysqli_fetch_array($q2)) {
                            $idbaju         = $r2['idbaju'];
                            $idbaju        = $r2['idbaju'];
                            $jenis       = $r2['jenis'];
                            $harga     = $r2['harga'];
                            $jumlah   = $r2['jumlah'];
                            $gambar    = $r2['gambar'];

                        ?>
                            <tr>
                                <th scope="row"><?php echo $urut++ ?></th>
                                <td scope="row"><?php echo $idbaju ?></td>
                                <td scope="row"><?php echo $jenis ?></td>
                                <td scope="row"><?php echo $harga ?></td>
                                <td scope="row"><?php echo $jumlah ?></td>
                                <td scope="row"><?php echo "<img src='img/$gambar' width='70' height='90' />" ?></td>
                                <td scope="row">
                                    <a href="index.php?op=edit&idbaju=<?php echo $idbaju ?>"><button type="button" class="btn btn-warning">Edit</button></a>
                                    <a href="index.php?op=delete&idbaju=<?php echo $idbaju?>" onclick="return confirm('Yakin mau delete data?')"><button type="button" class="btn btn-danger">Delete</button></a>            
                                </td>
                            </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                    
                </table>
            </div>
        </div>
    </div>

</body>

</html><?php

$host       = "localhost";
$user       = "root";
$pass       = "";
$db         = "uas_ibrahim_hasan";

$koneksi    = mysqli_connect($host, $user, $pass, $db);
if (!$koneksi) { 
    die("Tidak bisa terkoneksi ke database");
}
$jenis          = "";
$harga          = "";
$jumlah         = "";
$gambar         = "";
$sukses         = "";
$error          = "";


if (isset($_GET['op'])) {
    $op = $_GET['op'];
} else {
    $op = "";
}
if($op == 'delete'){
    $idbaju         = $_GET['idbaju'];
    $sql1       = "delete from baju_ibrahim_hasan where idbaju = '$idbaju'";
    $q1         = mysqli_query($koneksi,$sql1);
    if($q1){
        $sukses = "Berhasil hapus data";
    }else{
        $error  = "Gagal melakukan delete data";
    }
}
if ($op == 'edit') {
    $idbaju         = $_GET['idbaju'];
    $sql1       = "select * from baju_ibrahim_hasan where idbaju = '$idbaju'";
    $q1         = mysqli_query($koneksi, $sql1);
    $r1         = mysqli_fetch_array($q1);
    $idbaju        = $r1['idbaju'];
    $jenis       = $r1['jenis'];
    $harga     = $r1['harga'];
    $jumlah   = $r1['jumlah'];
    $gambar   = $r1['gambar'];

    if ($idbaju == '') {
        $error = "Data tidak ditemukan";
    }
}
if (isset($_POST['simpan'])) { 
    $jenis       = $_POST['jenis'];
    $harga     = $_POST['harga'];
    $jumlah   = $_POST['jumlah'];
    $gambar   = $_POST['gambar'];

    
    if ($gambar && $jenis && $harga && $jumlah) {
        if ($op == 'edit') {
            $sql1       = "update baju_ibrahim_hasan set jenis='$jenis',harga = '$harga',jumlah='$jumlah',gambar='$gambar' where idbaju = '$idbaju'";
            $q1         = mysqli_query($koneksi, $sql1);
            if ($q1) {
                $sukses = "Data berhasil diupdate";
            } else {
                $error  = "Data gagal diupdate";
            }
        } else { 

            move_uploaded_file($_FILES[$gambar],"img/$gambar");
            $sql1   = "insert into baju_ibrahim_hasan (gambar,jenis,harga,jumlah) values ('$gambar','$jenis','$harga','$jumlah')";
            $q1     = mysqli_query($koneksi, $sql1);
            if ($q1) {
                $sukses     = "Berhasil memasukkan data baru";
            } else {
                $error      = "Gagal memasukkan data";
            }
        }
    } else {
        $error = "Silakan masukkan semua data";
    }

}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Humaira Fashion Store by RYGUN</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
    <style>
        .mx-auto {
            width: 800px
        }

        .card {
            margin-top: 10px;
        }
    </style>
</head>

<body>
    <div class="mx-auto">
        <img src="img/1.png" width="300" height="150" />
        <div class="card">
            <div class="card-header">
                Create / Edit Data Barang
            </div>
            <div class="card-body">
                <?php
                if ($error) {
                ?>
                    <div class="alert alert-danger" role="alert">
                        <?php echo $error ?>
                    </div>
                <?php
                    header("refresh:5;url=index.php");
                }
                ?>
                <?php
                if ($sukses) {
                ?>
                    <div class="alert alert-success" role="alert">
                        <?php echo $sukses ?>
                    </div>
                <?php
                    header("refresh:5;url=index.php");
                }
                ?>
                <form action="" method="POST">
                    <div class="mb-3 row">
                        <label for="jenis" class="col-sm-2 col-form-label">Jenis Barang</label>
                        <div class="col-sm-10">
                            <select class="form-control" name="jenis" idbaju="jenis" required="required">
                                <option value="">- Pilih Jenis -</option>
                                <option value="Daster" <?php if ($jenis == "Daster") echo "selected" ?>>Daster</option>
                                <option value="Kaos" <?php if ($jenis == "Kaos") echo "selected" ?>>Kaos</option>
                                <option value="Jeans" <?php if ($jenis == "Jeans") echo "selected" ?>>Jeans</option>
                                <option value="Kemeja" <?php if ($jenis == "Kemeja") echo "selected" ?>>Kemeja</option>
                                <option value="Kerudung" <?php if ($jenis == "Kerudung") echo "selected" ?>>Kerudung</option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-3 row">  
                        <label for="harga" class="col-sm-2 col-form-label">Harga Barang</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" required="required" id="harga" name="harga" value="<?php echo $harga ?>">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="jumlah" class="col-sm-2 col-form-label">Jumlah Barang</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="jumlah" required="required" name="jumlah" value="<?php echo $jumlah ?>">
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label for="jumlah" class="col-sm-2 col-form-label">Foto Barang</label>
                        <div class="col-sm-10">
                            <input type="file" accept="image/*" class="form-control" id="gambar" required="required" name="gambar" value="<?php echo $gambar ?>">
                        </div>
                    </div>
                    <div class="col-12">
                        <input type="submit" name="simpan" value="Simpan Data" class="btn btn-primary" />
                    </div>

                </form>
            </div>
        </div>


        <div class="card">
            <div class="card-header text-white bg-secondary">
                Data Barang
            </div>
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">ID Barang</th>
                            <th scope="col">Jenis Barang</th>
                            <th scope="col">Harga</th>
                            <th scope="col">Jumlah</th>
                            <th scope="col">Gambar</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql2   = "select * from baju_ibrahim_hasan order by idbaju desc";
                        $q2     = mysqli_query($koneksi, $sql2);
                        $urut   = 1;
                        while ($r2 = mysqli_fetch_array($q2)) {
                            $idbaju         = $r2['idbaju'];
                            $idbaju        = $r2['idbaju'];
                            $jenis       = $r2['jenis'];
                            $harga     = $r2['harga'];
                            $jumlah   = $r2['jumlah'];
                            $gambar    = $r2['gambar'];

                        ?>
                            <tr>
                                <th scope="row"><?php echo $urut++ ?></th>
                                <td scope="row"><?php echo $idbaju ?></td>
                                <td scope="row"><?php echo $jenis ?></td>
                                <td scope="row"><?php echo $harga ?></td>
                                <td scope="row"><?php echo $jumlah ?></td>
                                <td scope="row"><?php echo "<img src='img/$gambar' width='70' height='90' />" ?></td>
                                <td scope="row">
                                    <a href="index.php?op=edit&idbaju=<?php echo $idbaju ?>"><button type="button" class="btn btn-warning">Edit</button></a>
                                    <a href="index.php?op=delete&idbaju=<?php echo $idbaju?>" onclick="return confirm('Yakin mau delete data?')"><button type="button" class="btn btn-danger">Delete</button></a>            
                                </td>
                            </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                    
                </table>
            </div>
        </div>
    </div>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
  </body>
</html>