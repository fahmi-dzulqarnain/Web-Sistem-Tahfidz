<?php

session_start();
require("includes/config.php");
$rowEdit = '';

if(isset($_GET['delete'])){
  $id = $_GET['delete'];
  $mysqli->query("DELETE FROM tbl_santri WHERE id = '$id'") or die($mysqli->error);

  header( "Location:atur_santri.php");
  exit;
}

if(isset($_POST['btnSubmit'])){
  $idWebsite = 1;

  $namaLengkap = $_POST['txtNamaLengkap'];
  $nis = $_POST['txtNIS']; 
  $tempatLahir = $_POST['txtTempatLahir'];
  $tanggalLahir = $_POST['txtTanggalLahir']; 
  $gender = $_POST['txtKelamin']; 
  $alamat = $_POST['txtAlamat']; 
  $namaOrtu = $_POST['txtNamaOrtu']; 
  $noHPortu = $_POST['txtHPortu']; 
  $hafalanTerakhir = $_POST['txtHafalanTerakhir']; 
  $juzHafal = $_POST['txtJumlahJuz'];

  $mysqli->query("INSERT INTO tbl_santri (nama_lengkap, nis, tempat_lahir, tanggal_lahir, gender, alamat, nama_ortu, no_hp_ortu, hafalan_terakhir, juz_hafal)
                  VALUES ('$namaLengkap', '$nis', '$tempatLahir', '$tanggalLahir', '$gender', '$alamat', '$namaOrtu', '$noHPortu', '$hafalanTerakhir', '$juzHafal')") or die($mysqli->error);

  header( "Location:atur_santri.php");
  exit;
}

if(isset($_GET['edit'])){
  $id = $_GET['edit'];
  $result = $mysqli->query("SELECT * FROM tbl_santri WHERE id = '$id'") or die($mysqli->error);
  $rowEdit = $result->fetch_assoc();
}

if(isset($_POST['btnEdit'])){
  $id = $_POST['txtID'];

  $namaLengkap = $_POST['txtNamaLengkap'];
  $nis = $_POST['txtNIS']; 
  $tempatLahir = $_POST['txtTempatLahir'];
  $tanggalLahir = $_POST['txtTanggalLahir']; 
  $gender = $_POST['txtKelamin']; 
  $alamat = $_POST['txtAlamat']; 
  $namaOrtu = $_POST['txtNamaOrtu']; 
  $noHPortu = $_POST['txtHPortu']; 
  $hafalanTerakhir = $_POST['txtHafalanTerakhir']; 
  $juzHafal = $_POST['txtJumlahJuz'];

  $mysqli->query("UPDATE tbl_santri SET nama_lengkap='$namaLengkap', nis='$nis', tempat_lahir='$tempatLahir', tanggal_lahir='$tanggalLahir', gender='$gender', 
                  alamat='$alamat', nama_ortu='$namaOrtu', no_hp_ortu='$noHPortu', hafalan_terakhir='$hafalanTerakhir', juz_hafal='$juzHafal' WHERE id='$id'") or die($mysqli->error);

  header( "Location:atur_santri.php");
  exit;
}

?>

<!DOCTYPE html>
<html>

<head>
    <title>Admin - Santri</title>

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

    <?php
        require("includes/config.php");

        $Santri = $mysqli->query("SELECT * FROM tbl_santri");
        ?>

    <!-- Navbar -->
    <?php include('includes/navbar.php'); ?>
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
                          Ubah Santri
                          <a href="atur_santri.php">Batal</a>
                        <?php else: ?>
                          Tambah Santri
                          <a href="import_santri.php">Impor Excel</a>
                        <?php endif; ?>
                    </div>
                    <div class="card-content">
                        <form enctype="multipart/form-data" action="atur_santri.php" method="post">
                            <div class="row">
                                <?php if ($rowEdit !== ''): ?>
                                  <input type="text" name="txtID" value="<?php echo $rowEdit['id']; ?>" hidden>
                                <?php endif; ?>
                                <input class="text-form col-half" type="text" name="txtNamaLengkap" placeholder="Nama Santri..." value="<?php if ($rowEdit !== '') echo $rowEdit['nama_lengkap']; ?>">
                                <input class="text-form col-half" type="text" name="txtNIS" placeholder="NIS..." value="<?php if ($rowEdit !== '') echo $rowEdit['nis']; ?>">
                                <input class="text-form col-half" type="text" name="txtTempatLahir" placeholder="Termpat Lahir..." value="<?php if ($rowEdit !== '') echo $rowEdit['tempat_lahir']; ?>">
                                <input class="text-form col-half" type="date" name="txtTanggalLahir" placeholder="Tanggal Lahir..." value="<?php if ($rowEdit !== '') echo $rowEdit['tanggal_lahir']; ?>">
                                <input class="text-form col-half" type="text" name="txtKelamin" placeholder="Jenis Kelamin..." value="<?php if ($rowEdit !== '') echo $rowEdit['gender']; ?>">
                                <input class="text-form col-half" type="text" name="txtAlamat" placeholder="Alamat..." value="<?php if ($rowEdit !== '') echo $rowEdit['alamat']; ?>">
                                <input class="text-form col-half" type="text" name="txtNamaOrtu" placeholder="Nama Orang Tua..." value="<?php if ($rowEdit !== '') echo $rowEdit['nama_ortu']; ?>">
                                <input class="text-form col-half" type="tel" name="txtHPortu" placeholder="No. HP Orang Tua..." value="<?php if ($rowEdit !== '') echo $rowEdit['no_hp_ortu']; ?>">
                                <input class="text-form col-half" type="text" name="txtHafalanTerakhir" placeholder="Hafalan Terakhir..." value="<?php if ($rowEdit !== '') echo $rowEdit['hafalan_terakhir']; ?>">
                                <input class="text-form col-half" type="tel" name="txtJumlahJuz" placeholder="Jumlah Juz Hafal..." value="<?php if ($rowEdit !== '') echo $rowEdit['juz_hafal']; ?>">

                                <button type="submit" class="custom-file-upload" style="padding-bottom:10px;" name="<?php if ($rowEdit !== ''): echo 'btnEdit'; else: echo 'btnSubmit'; endif; ?>">
                                    <?php if ($rowEdit !== ''): ?>
                                      <i class="fas fa-edit"></i> Ubah Santri</button>
                                    <?php else: ?>
                                      <i class="fas fa-save"></i> Tambah Santri</button>
                                    <?php endif; ?>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-biggest">
                <div class="card">
                    <div class="card-header">
                        Daftar Santri
                    </div>
                    <div class="card-content">
                        <table>
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Nama Lengkap</th>
                                    <th>NIS</th>
                                    <th>Tempat Lahir</th>
                                    <th>Tgl Lahir</th>
                                    <th>L/P</th>
                                    <th>Alamat</th>
                                    <th>Nama Ortu</th>
                                    <th>No HP Ortu</th>
                                    <th>Hafalan Terakhir</th>
                                    <th>Juz Hafal</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                            $i = 1;
                            while ($row = $Santri->fetch_assoc()): ?>
                                <tr>
                                    <td><?php echo $i++; ?></td>
                                    <td><?php echo $row['nama_lengkap']; ?></td>
                                    <td><?php echo $row['nis']; ?></td>
                                    <td><?php echo $row['tempat_lahir']; ?></td>
                                    <td><?php echo $row['tanggal_lahir']; ?></td>
                                    <td><?php echo $row['gender']; ?></td>
                                    <td><?php echo $row['alamat']; ?></td>
                                    <td><?php echo $row['nama_ortu']; ?></td>
                                    <td><?php echo $row['no_hp_ortu']; ?></td>
                                    <td><?php echo $row['hafalan_terakhir']; ?></td>
                                    <td><?php echo $row['juz_hafal']; ?></td>
                                    <td>
                                        <a href="atur_santri.php?edit=<?php echo $row['id']; ?>"
                                            class="btn-icon bg-primary"> <i class="fas fa-edit"></i> </a>
                                        <a href="?delete=<?php echo $row['id']; ?>"
                                            onclick="return confirm('Apakah Anda yakin ingin menghapus Santri ini?');"
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