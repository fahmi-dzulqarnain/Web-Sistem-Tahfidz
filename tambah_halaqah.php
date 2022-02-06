<?php

session_start();
require("includes/config.php");
$idWebsite = 1;
$id = '';

if(isset($_POST['btnSubmit'])) {
    if (isset($_GET['idHalaqah'])){

        $id = $_GET['idHalaqah'];
        $getExist = $mysqli->query("SELECT * FROM tbl_halaqah WHERE id='$id'");
        $rowEdit = $getExist->fetch_assoc();        

        $NamaHalaqah = $_POST['txtNamaHalaqah'];
        $Target = $_POST['txtTarget'];
        $Pengampu = $_POST['txtPengampu'];
        $Santri = $_POST['txtSantri'];
        
        $getPengampu = $mysqli->query("SELECT * FROM tbl_pengampu WHERE nama_lengkap='$Pengampu'");
        $idPengampu = $getPengampu->fetch_assoc()['id'];
        $getSantri = $mysqli->query("SELECT * FROM tbl_santri WHERE nama_lengkap='$Pengampu'");
        $idSantri = $getSantri->fetch_assoc()['id'];

        $arraySantri = $rowEdit['array_id_santri'].'|'.$idSantri;
    
        $mysqli->query("UPDATE tbl_halaqah SET nama_halaqah='$NamaHalaqah', id_pengampu='$idPengampu', array_id_santri='$arraySantri', target_bulanan='$Target' WHERE id='$id'") or die($mysqli->error);

        header("Location:tambah_halaqah.php?idHalaqah=".$id);
    } else {

        $NamaHalaqah = $_POST['txtNamaHalaqah'];
        $Target = $_POST['txtTarget'];
        $Pengampu = $_POST['txtPengampu'];
        $Santri = $_POST['txtSantri'];
        
        $getPengampu = $mysqli->query("SELECT id FROM tbl_pengampu WHERE nama_lengkap='$Pengampu'");
        $idPengampu = $getPengampu->fetch_assoc()['id'];
        $getSantri = $mysqli->query("SELECT id FROM tbl_santri WHERE nama_lengkap='$Santri'");
        $idSantri = $getSantri->fetch_assoc()['id'];

        $mysqli->query("INSERT INTO tbl_halaqah (nama_halaqah, id_pengampu, array_id_santri, target_bulanan)
                        VALUES ('$NamaHalaqah', '$idPengampu', '$idSantri', '$Target')") or die($mysqli->error);

        $id = $mysqli->query("SELECT MAX(id) as maxim FROM tbl_halaqah");
        header("Location:tambah_halaqah.php?idHalaqah=".$id->fetch_assoc()['maxim']);
    }

    exit;
}

if(isset($_POST['btnTambahSantri'])) {   
    if (isset($_GET['idHalaqah'])){
        $id = $_GET['idHalaqah'];        
        $getExist = $mysqli->query("SELECT * FROM tbl_halaqah WHERE id='$id'");
        $rowEdit = $getExist->fetch_assoc();

        $Santri = $_POST['txtSantri'];
        $getSantri = $mysqli->query("SELECT id FROM tbl_santri WHERE nama_lengkap='$Santri'");
        $idSantri = $getSantri->fetch_assoc()['id'];
            
        $getExist = $mysqli->query("SELECT * FROM tbl_halaqah WHERE id='$id'");
        $rowEdit = $getExist->fetch_assoc();
        $arraySantri = $rowEdit['array_id_santri'].'|'.$idSantri;
        
        $mysqli->query("UPDATE tbl_halaqah SET array_id_santri='$arraySantri' WHERE id='$id'") or die($mysqli->error);
        
        header("Location:tambah_halaqah.php?idHalaqah=".$id);
    } else {
        
        $NamaHalaqah = $_POST['txtNamaHalaqah'];
        $Target = $_POST['txtTarget'];
        $Pengampu = $_POST['txtPengampu'];
        $Santri = $_POST['txtSantri'];
        
        $getPengampu = $mysqli->query("SELECT id FROM tbl_pengampu WHERE nama_lengkap='$Pengampu'");
        $idPengampu = $getPengampu->fetch_assoc()['id'];
        $getSantri = $mysqli->query("SELECT id FROM tbl_santri WHERE nama_lengkap='$Santri'");
        $idSantri = $getSantri->fetch_assoc()['id'];

        $mysqli->query("INSERT INTO tbl_halaqah (nama_halaqah, id_pengampu, array_id_santri, target_bulanan)
                        VALUES ('$NamaHalaqah', '$idPengampu', '$idSantri', '$Target')") or die($mysqli->error);

        $id = $mysqli->query("SELECT MAX(id) as maxim FROM tbl_halaqah");
        header("Location:tambah_halaqah.php?idHalaqah=".$id->fetch_assoc()['maxim']);
    }    

    exit;
}

if (isset($_GET['delete'])){
    $namaSantri = $_GET['delete'];
    $id = $_GET['idHalaqah'];

    $getExist = $mysqli->query("SELECT * FROM tbl_halaqah WHERE id='$id'");
    $rowEdit = $getExist->fetch_assoc();  
    $arraySantri = str_replace('|'.$namaSantri.'|', '', $rowEdit['array_id_santri']);

    $mysqli->query("UPDATE tbl_halaqah SET array_id_santri='$arraySantri' WHERE id='$id'") or die($mysqli->error);
    header("Location:tambah_halaqah.php?idHalaqah=".$id);
    exit;
}

$rowEdit = array();

if (isset($_GET['idHalaqah'])){
    $id = $_GET['idHalaqah'];
    $getExist = $mysqli->query("SELECT * FROM tbl_halaqah WHERE id='$id'");
    $rowEdit = $getExist->fetch_assoc();
}

?>

<!DOCTYPE html>
<html>

<head>
    <title>Admin - Tambah Halaqah</title>

    <meta name="viewport"
        content="width=device-width, height=device-height, initial-scale=1.0, user-scalable=0, minimum-scale=0, maximum-scale=1.0">
    <link rel="icon" type="image/png" href="assets/MidLogo-light.png">

    <!-- Import Library -->
    <link rel="stylesheet" type="text/css" href="libraries/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Raleway:wght@300;400;500&display=swap">
    <!-- End Import Library -->

    <link rel="stylesheet" type="text/css" href="view/styles/style.css">
</head>

<body class="overlay-scrollbar">

    <!-- Navbar -->
    <?php include('includes/navbar.php'); ?>
    <!-- End Navbar -->

    <!-- Sidebar -->
    <?php include('includes/sidebar.php'); ?>
    <!-- End Sidebar -->

    <!-- Main Content -->
    <div class="wrapper">
        <?php
            $pengampu = $mysqli->query("SELECT * FROM tbl_pengampu");
            $santri = $mysqli->query("SELECT nama_lengkap FROM tbl_santri");
        ?>
        <div class="row">
            <div class="col-biggest">
                <div class="card">
                    <div class="card-header">
                        Tambah Halaqah
                        <a href="atur_halaqah.php">Kembali</a>
                    </div>
                    <div class="card-content">                        
                        <form id="halaqahForm" enctype="multipart/form-data" action="tambah_halaqah.php<?php if ($id !== ''): echo "?idHalaqah=$id"; endif;?>" method="post">
                            <div class="row">
                                <input class="text-form col-biggest" type="text" name="txtNamaHalaqah" placeholder="Nama Halaqah..." value="<?php if ($id !== ''): echo $rowEdit['nama_halaqah']; endif;?>">
                                <input class="text-form col-biggest" type="tel" name="txtTarget" placeholder="Target Bulanan..." value="<?php if ($id !== ''): echo $rowEdit['target_bulanan']; endif;?>">
                                <label class="text-form col-bigger" for="cmbPengampu">Nama Pengampu :-</label>
                                <select class="text-form col-biggest" name="txtPengampu" form="halaqahForm">
                                    <option value="" <?php if ($id == '') echo 'selected'?> disabled hidden>Pilih Nama Pengampu...</option>
                                    <?php while ($row = $pengampu->fetch_assoc()): ?>
                                        <option <?php if ($id !== '' && $row['id'] == $rowEdit['id_pengampu']): echo 'selected'; endif; ?>><?php 
                                                    echo $row['nama_lengkap']; ?></option>
                                    <?php endwhile; ?>
                                </select>
                            </div>                            

                            <div class="row" style="margin-top: 32px;">   
                                <label class="text-form col-bigger" for="cmbSantri">Tambah Santri :-</label>
                                <select id="cmbSantri" class="text-form col-bigger" name="txtSantri" form="halaqahForm">
                                    <option value="" selected disabled hidden>Pilih Nama Santri...</option>
                                    <?php while ($row = $santri->fetch_assoc()): ?>
                                        <option><?php echo $row['nama_lengkap'] ?></option>
                                    <?php endwhile; ?>
                                </select>
                                <button type="submit" name="btnTambahSantri" for="picture-btn" class="col-smaller custom-file-upload"> <i class="fas fa-plus"></i> Tambah </button>
                            </div>

                            <div style="margin-top:50px;" class="row">
                                <div class="card col-biggest">
                                    <div class="card-header">
                                        Daftar Santri Halaqah
                                    </div>
                                    <div class="card-content">
                                        <table>
                                            <thead>
                                                <tr>
                                                    <th>No.</th>
                                                    <th>Nama Santri</th>
                                                    <th>Hapus</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                    $i = 1;
                                                    $santriArray = array();
                                                    if ($id !== '') $santriArray = explode('|', $rowEdit['array_id_santri']);
                                                    foreach ($santriArray as &$row): 
                                                        if ($row !== ''):
                                                            $getNamaSantri = $mysqli->query("SELECT nama_lengkap FROM tbl_santri WHERE id='$row'");
                                                            $namaSantri = $getNamaSantri->fetch_assoc()['nama_lengkap']; 
                                                    ?>
                                                    <tr>
                                                        <td><?php echo $i++; ?></td>
                                                        <td><?php echo $namaSantri; ?></td>
                                                        <td>
                                                            <a href="?idHalaqah=<?php echo $id; ?>&delete=<?php echo $row; ?>"
                                                                onclick="return confirm('Apakah Anda yakin ingin menghapus Santri ini dari halaqah?');"
                                                                class="btn-icon bg-danger"> <i class="fas fa-trash"></i>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                <?php endif; endforeach; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <button type="submit" class="custom-file-upload" style="padding-bottom:10px;"
                                    name="btnSubmit"> <i class="fas fa-save"></i> Simpan Halaqah</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Main Content -->
    
    <script src="index.js"></script>
</body>

</html>