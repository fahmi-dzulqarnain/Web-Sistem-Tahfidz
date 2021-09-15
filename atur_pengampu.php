<?php

session_start();
require("includes/config.php");
$rowEdit = '';

if(isset($_GET['delete'])){
  $id = $_GET['delete'];
  $mysqli->query("DELETE FROM tbl_pengampu WHERE id = '$id'") or die($mysqli->error);

  header( "Location:atur_pengampu.php");
  exit;
}

if(isset($_POST['btnSubmit'])){
  $idWebsite = 1;

  $namaLengkap = str_replace("'", "\'", $_POST['txtNamaLengkap']);
  $mapelDiampu = $_POST['txtMapelDiampu'];
  $hafalan = $_POST['txtHafalan'];
  $lulusan = $_POST['txtLulusan'];
  $noHP = $_POST['txtNoHP'];

  $mysqli->query("INSERT INTO tbl_pengampu (nama_lengkap, mapel_diampu, hafalan, lulusan, no_hp)
                  VALUES ('$namaLengkap', '$mapelDiampu', '$hafalan', '$lulusan', '$noHP')") or die($mysqli->error);


    $idUser = $mysqli->query("SELECT id FROM tbl_pengampu WHERE nama_lengkap = '$namaLengkap'")->fetch_assoc()['id'];
    $pengguna = str_replace("'", "", str_replace(' ', '_', strtolower($namaLengkap)));
    $password = md5($noHP.$hafalan);
    $tipeAkun = 'user';
    $mysqli->query("INSERT INTO tbl_akun (pengguna, sandi, tipe_akun, id_user)
                    VALUES ('$pengguna', '$password', '$tipeAkun', '$idUser')") or die($mysqli->error);

  header( "Location:atur_pengampu.php");
  exit;
}

if(isset($_GET['edit'])){
  $id = $_GET['edit'];
  $result = $mysqli->query("SELECT * FROM tbl_pengampu WHERE id = '$id'") or die($mysqli->error);
  $rowEdit = $result->fetch_assoc();
}

if(isset($_POST['btnEdit'])){
  $id = $_POST['txtID'];

  $namaLengkap = $_POST['txtNamaLengkap'];
  $mapelDiampu = $_POST['txtMapelDiampu'];
  $hafalan = $_POST['txtHafalan'];
  $lulusan = $_POST['txtLulusan'];
  $noHP = $_POST['txtNoHP'];

  $mysqli->query("UPDATE tbl_pengampu SET nama_lengkap='$namaLengkap', mapel_diampu='$mapelDiampu', hafalan='$hafalan',
                  lulusan='$lulusan', no_hp='$noHP' WHERE id='$id'") or die($mysqli->error);

  header( "Location:atur_pengampu.php");
  exit;
}

?>

<!DOCTYPE html>
<html>

<head>
    <title>Admin - Pengampu</title>

    <meta name="viewport"
        content="width=device-width, height=device-height, initial-scale=1.0, user-scalable=0, minimum-scale=0, maximum-scale=1.0">
    <link rel="icon" type="image/png" href="assets/MidLogo-light.png">

    <!-- Import Library -->
    <link rel="stylesheet" type="text/css" href="fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Raleway:wght@300;400;500&display=swap">
    <!-- End Import Library -->

    <link rel="stylesheet" type="text/css" href="style.css">
</head>

<body class="overlay-scrollbar">

    <!-- Navbar -->
    <?php include('includes/navbar.php'); 
    $pengampu = $mysqli->query("SELECT * FROM tbl_pengampu");?>
    <!-- End Navbar -->

    <!-- Sidebar -->
    <?php include('includes/sidebar.php'); ?>
    <!-- End Sidebar -->

    <!-- Main Content -->
    <div class="wrapper">
        <div class="row">
            <div class="col-biggest">
                <div class="card">
                    <div class="card-header">
                        <?php if ($rowEdit !== ''): ?>
                          Ubah Pengampu
                          <a href="atur_pengampu.php">Batal</a>
                        <?php else: ?>
                          Tambah Pengampu
                        <?php endif; ?>
                    </div>
                    <div class="card-content">
                        <form enctype="multipart/form-data" action="atur_pengampu.php" method="post">
                            <div class="row">
                                <?php if ($rowEdit !== ''): ?>
                                  <input type="text" name="txtID" value="<?php echo $rowEdit['id']; ?>" hidden>
                                <?php endif; ?>
                                <input class="text-form col-half" type="text" name="txtNamaLengkap" placeholder="Nama Pengampu..." value="<?php if ($rowEdit !== '') echo $rowEdit['nama_lengkap']; ?>">
                                <input class="text-form col-half" type="text" name="txtMapelDiampu" placeholder="Mapel Diampu..." value="<?php if ($rowEdit !== '') echo $rowEdit['mapel_diampu']; ?>">
                                <input class="text-form col-half" type="tel" name="txtHafalan" placeholder="Jumlah Hafalan..." value="<?php if ($rowEdit !== '') echo $rowEdit['hafalan']; ?>">
                                <input class="text-form col-half" type="text" name="txtLulusan" placeholder="Lulusan..." value="<?php if ($rowEdit !== '') echo $rowEdit['lulusan']; ?>">
                                <input class="text-form col-half" type="tel" name="txtNoHP" placeholder="No. HP..." value="<?php if ($rowEdit !== '') echo $rowEdit['no_hp']; ?>">
                                <button type="submit" class="custom-file-upload" style="padding-bottom:10px;" name="<?php if ($rowEdit !== ''): echo 'btnEdit'; else: echo 'btnSubmit'; endif; ?>">
                                    <?php if ($rowEdit !== ''): ?>
                                      <i class="fas fa-edit"></i> Ubah Pengampu</button>
                                    <?php else: ?>
                                      <i class="fas fa-save"></i> Tambah Pengampu</button>
                                    <?php endif; ?>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-biggest">
                <div class="card">
                    <div class="card-header">
                        Daftar Pengampu
                    </div>
                    <div class="card-content">
                        <table>
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Nama Lengkap</th>
                                    <th>Mapel Diampu</th>
                                    <th>Hafalan</th>
                                    <th>Lulusan</th>
                                    <th>No. HP</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = 1;
                                while ($row = $pengampu->fetch_assoc()): ?>
                                <tr>
                                    <td><?php echo $i++; ?></td>
                                    <td><?php echo $row['nama_lengkap']; ?></td>
                                    <td><?php echo $row['mapel_diampu']; ?></td>
                                    <td><?php echo $row['hafalan']; ?></td>
                                    <td><?php echo $row['lulusan']; ?></td>
                                    <td><?php echo $row['no_hp']; ?></td>
                                    <td>
                                        <a href="atur_pengampu.php?edit=<?php echo $row['id']; ?>"
                                            class="btn-icon bg-primary"> <i class="fas fa-edit"></i> </a>
                                        <a href="?delete=<?php echo $row['id']; ?>"
                                            onclick="return confirm('Apakah Anda yakin ingin menghapus Pengampu ini?');"
                                            class="btn-icon bg-danger"> <i class="fas fa-trash"></i> </a>
                                    </td>
                                </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Main Content -->

    <script src="index.js"></script>
</body>

</html>