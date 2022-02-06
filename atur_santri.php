<?php

session_start();
require("includes/config.php");
$rowEdit = '';

$surat = $mysqli->query("SELECT nama_surat FROM tbl_surat");
$getKelas = $mysqli->query("SELECT nama_kelas FROM tbl_kelas");
$kelas = array();

while ($row = $getKelas->fetch_assoc()) {
    $kelas[] = $row['nama_kelas'];
}

include("controller/santri/add_change.php");
include("controller/santri/delete.php");

if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $result = $mysqli->query("SELECT * FROM tbl_santri WHERE id = '$id'") or die($mysqli->error);
    $rowEdit = $result->fetch_assoc();
}

if (isset($_POST['btnAddKelas'])) {
    $namaKelas = $_POST['txtNamaKelas'];
    $waliKelas = $_POST['txtWaliKelas'];

    $idPengampu = $mysqli->prepare("SELECT id FROM tbl_pengampu WHERE nama_lengkap = ?");
    $idPengampu->bind_param("s", $waliKelas);
    $idPengampu->execute();
    $idPengampu = $idPengampu->get_result()->fetch_assoc()['id'];

    $statement = $mysqli->prepare("INSERT INTO tbl_kelas (nama_kelas, wali_kelas) VALUES (?, ?)");
    $statement->bind_param('si', $namaKelas, $idPengampu);
    $statement->execute();

    $statement->close();

    header( "Location: atur_santri.php");
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
    <link rel="stylesheet" type="text/css" href="libraries/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Raleway:wght@300;400;500&display=swap">
    <!-- End Import Library -->

    <link rel="stylesheet" type="text/css" href="view/styles/style.css">
    <link rel="stylesheet" type="text/css" href="view/styles/collapsible.css">
    <link rel="stylesheet" type="text/css" href="view/styles/modal.css">
    <link rel="stylesheet" type="text/css" href="view/styles/chip.css">
</head>

<body class="overlay-scrollbar">

    <?php 
    
    // Navigation Bar
    include('includes/navbar.php'); 
    
    // Sidebar
    include('includes/sidebar.php');

    $Santri = $mysqli->query("SELECT * FROM tbl_santri");

    ?>

    <!-- Main Content -->
    <div class="wrapper">
        <div class="row">
            <div class="col-biggest">
                <div class="card">

                    <div class="collapsible card-header">
                        <div class="card-header">
                            <?php if ($rowEdit !== '') : ?>
                            <div class="title">Ubah Santri</div>
                            <a href="atur_santri.php">Batal</a>
                            <?php else : ?>
                            <div class="title">Tambah Santri</div>
                            <a href="import_santri.php">Impor Excel</a>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="card-content collapsible-content">
                        <form id="santriForm" enctype="multipart/form-data" action="atur_santri.php" method="post">
                            <div class="row padding">
                                <?php if ($rowEdit !== '') : ?>
                                <input type="text" name="txtID" value="<?php echo $rowEdit['id']; ?>" hidden>
                                <?php endif; ?>
                                <input class="text-form col-half" type="text" name="txtNamaLengkap"
                                    placeholder="Nama Santri..."
                                    value="<?php if ($rowEdit !== '') echo $rowEdit['nama_lengkap']; ?>">
                                <input class="text-form col-half" type="text" name="txtNIS" placeholder="NIS..."
                                    value="<?php if ($rowEdit !== '') echo $rowEdit['nis']; ?>">
                                <input class="text-form col-half" type="text" name="txtTempatLahir"
                                    placeholder="Termpat Lahir..."
                                    value="<?php if ($rowEdit !== '') echo $rowEdit['tempat_lahir']; ?>">
                                <input class="text-form col-half" type="date" name="txtTanggalLahir"
                                    placeholder="Tanggal Lahir..."
                                    value="<?php if ($rowEdit !== '') echo $rowEdit['tanggal_lahir']; ?>">
                                <div class="flex-row half-width" style="padding-left: 10px;">
                                    <select id="cmbKelas" class="text-form" name="txtKelas" form="santriForm"
                                        style="width: 85%;">
                                        <?php if ($rowEdit !== ''): ?>
                                        <option selected><?php echo $rowEdit['kelas']; ?></option>
                                        <?php else: ?>
                                        <option value="" selected disabled hidden>Kelas...</option>
                                        <?php endif; ?>
                                        <?php foreach ($kelas as $row) : ?>
                                        <option><?php echo $row; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <a onclick="openModal()" class="rounded-button"
                                        style="margin-left: 10px; width: 10%;"><i class="fas fa-plus"></i></a>
                                </div>

                                <input class="text-form col-half" type="text" name="txtKelamin"
                                    placeholder="Jenis Kelamin..."
                                    value="<?php if ($rowEdit !== '') echo $rowEdit['gender']; ?>">
                                <input class="text-form col-half" type="text" name="txtAlamat" placeholder="Alamat..."
                                    value="<?php if ($rowEdit !== '') echo $rowEdit['alamat']; ?>">
                                <input class="text-form col-half" type="text" name="txtNamaOrtu"
                                    placeholder="Nama Orang Tua..."
                                    value="<?php if ($rowEdit !== '') echo $rowEdit['nama_ortu']; ?>">
                                <input class="text-form col-half" type="tel" name="txtHPortu"
                                    placeholder="No. HP Orang Tua..."
                                    value="<?php if ($rowEdit !== '') echo $rowEdit['no_hp_ortu']; ?>">
                                <select id="cmbSurat" class="text-form col-half" name="txtHafalanTerakhir"
                                    form="santriForm">
                                    <?php if ($rowEdit !== ''): ?>
                                    <option selected><?php echo $rowEdit['hafalan_terakhir']; ?></option>
                                    <?php else: ?>
                                    <option value="" selected disabled hidden>Hafalan Terakhir...</option>
                                    <?php endif; ?>
                                    <?php while ($rows = $surat->fetch_assoc()) : ?>
                                    <option><?php echo $rows['nama_surat']; ?></option>
                                    <?php endwhile; ?>
                                </select>
                                <input class="text-form col-half" type="tel" name="txtJumlahJuz"
                                    placeholder="Jumlah Juz Hafal..."
                                    value="<?php if ($rowEdit !== '') echo $rowEdit['juz_hafal']; ?>">

                                <button type="submit" class="custom-file-upload" style="padding-bottom:10px;"
                                    name="<?php if ($rowEdit !== '') : echo 'btnEdit';
                                                                                                                    else : echo 'btnSubmit';
                                                                                                                    endif; ?>">
                                    <?php if ($rowEdit !== '') : ?>
                                    <i class="fas fa-edit"></i> Ubah Santri</button>
                                <?php else : ?>
                                <i class="fas fa-save"></i> Tambah Santri</button>
                                <?php endif; ?>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-biggest">
                <div class="card">
                    <div class="card-header flex-row">
                        <div class="title">Daftar Santri</div>
                        <form class="navbar-search">
                            <input id="searchInput" type="text" name="Search" class="navbar-search-input"
                                placeholder="Cari Santri..." onkeyup="searchTable(4)">
                            <i class="fas fa-search"></i>
                        </form>
                    </div>
                    <div class="card-content">
                        <div class="flex-row">
                            <div class="chip active" onclick="filter('semua', 0, 4)">Semua</div>
                            <?php 
                            $index = 1;
                            foreach($kelas as $row):?>
                            <div class="chip" onclick="filter('<?php echo $row; ?>', <?php echo $index++; ?>, 4)">
                                <?php echo $row;?></div>
                            <?php endforeach;?>
                        </div>
                        <table id="searchableTable">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>No.</th>
                                    <th>Nama Lengkap</th>
                                    <th>NIS</th>
                                    <th>Kelas</th>
                                    <th>Tempat Lahir</th>
                                    <th>Tgl Lahir</th>
                                    <th>L/P</th>
                                    <th>Alamat</th>
                                    <th>Nama Ortu</th>
                                    <th>No HP Ortu</th>
                                    <th>Hafalan Terakhir</th>
                                    <th>Juz Hafal</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = 1;
                                while ($row = $Santri->fetch_assoc()) : ?>
                                <tr>
                                    <td class="flex-row">
                                        <a href="atur_santri.php?edit=<?php echo $row['id']; ?>"
                                            class="btn-icon bg-primary" onclick="toggleCollapsible()"> <i class="fas fa-edit"></i> </a>
                                        <a href="?delete=<?php echo $row['id']; ?>"
                                            onclick="return confirm('Apakah Anda yakin ingin menghapus Santri ini?');"
                                            class="btn-icon bg-danger"> <i class="fas fa-trash"></i> </a>
                                    </td>
                                    <td><?php echo $i++; ?></td>
                                    <td><?php echo $row['nama_lengkap']; ?></td>
                                    <td><?php echo $row['nis']; ?></td>
                                    <td><?php echo $row['kelas']; ?></td>
                                    <td><?php echo $row['tempat_lahir']; ?></td>
                                    <td><?php echo $row['tanggal_lahir']; ?></td>
                                    <td><?php echo $row['gender']; ?></td>
                                    <td><?php echo $row['alamat']; ?></td>
                                    <td><?php echo $row['nama_ortu']; ?></td>
                                    <td><?php echo $row['no_hp_ortu']; ?></td>
                                    <td><?php echo $row['hafalan_terakhir']; ?></td>
                                    <td><?php echo $row['juz_hafal']; ?></td>
                                </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <?php include 'view/modals/add_kelas.php'; ?>
        </div>

    </div>
    <!-- End Main Content -->

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="index.js"></script>
    <script src="controller/scripts/collapsible.js"></script>
    <script src="controller/scripts/search.js"></script>
    <script src="controller/scripts/modal.js"></script>
    <script src="controller/scripts/chip.js"></script>
</body>

</html>