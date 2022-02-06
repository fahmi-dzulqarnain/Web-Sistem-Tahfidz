<!DOCTYPE html>
<html style="box-sizing: border-box;">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0, user-scalable=0, minimum-scale=0, maximum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <!-- Import Library -->
    <link rel="stylesheet" type="text/css" href="libraries/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Raleway:wght@300;400;500&display=swap">
    <!-- End Import Library -->

    <link rel="stylesheet" type="text/css" href="view/styles/style.css">

    <title>Beranda</title>
</head>

<body class="user_home">

    <!-- Headerbar -->
    <?php include('includes/headerbar.php'); ?>
    <!-- End Headerbar -->

    <?php

    $tipe = '';
    $idPengampu = $_SESSION['id_user'];

    if (isset($_GET['tipe'])) $tipe = $_GET['tipe'];

    if (isset($_GET['logout'])) {
        session_destroy();
        echo '<script type="text/javascript">';
        echo 'window.location.href = "index.php";';
        echo '</script>';
    }

    if (isset($_SESSION['codeID'])) {
        require_once('includes/config.php');
    } else {
        session_destroy();
        echo '<script type="text/javascript">';
        echo 'alert("Sesi Anda Habis, Silakan Login Kembali!");';
        echo 'window.location.href = "index.php";';
        echo '</script>';
    }

    if (isset($_POST['btnSubmit'])) {
        $namaSantri = $_POST['txtSantri'];
        $suratAwal = $_POST['txtSuratAwal'];
        $suratAkhir = $_POST['txtSuratAkhir'];
        $ayatAwal = $_POST['txtAyatAwal'];
        $ayatAkhir = $_POST['txtAyatAkhir'];
        $tanggal = date("Y/m/d");

        $getSantri = $mysqli->query("SELECT id FROM tbl_santri WHERE nama_lengkap='$namaSantri'");
        $idSantri = $getSantri->fetch_assoc()['id'];

        $jumlahBaris = 0;
        $getAwal = $mysqli->query("SELECT id, juz FROM tbl_quran WHERE nama_surat='$suratAwal' AND ayat='$ayatAwal'")->fetch_assoc();
        $getAkhir = $mysqli->query("SELECT id, juz FROM tbl_quran WHERE nama_surat='$suratAkhir' AND ayat='$ayatAkhir'")->fetch_assoc();
        $batasAwal = $getAwal['id'];
        $batasAkhir = $getAkhir['id'];
        $juz1 = $getAwal['juz'];
        $juz2 = $getAkhir['juz'];
        $getAll = $mysqli->query("SELECT SUM(jumlah_baris) as result FROM tbl_quran WHERE id BETWEEN '$batasAwal' AND '$batasAkhir'");
        $jumlahBaris = (float)$getAll->fetch_assoc()['result'];

        if ($juz1 == $juz2)
            $juz = $juz1;
        else 
            $juz = $juz1.', '.$juz2;

        $mysqli->query("INSERT INTO tbl_record (id_santri, id_pengampu, tanggal, surat_awal, ayat_awal, surat_akhir, ayat_akhir, jumlah_baris, tipe_setor, juz)
                        VALUES ('$idSantri', '$idPengampu', '$tanggal', '$suratAwal', '$ayatAwal', '$suratAkhir', '$ayatAkhir', '$jumlahBaris', '$tipe', '$juz')") or die($mysqli->error);

        header("Location:user_home.php");
        exit;
    }

    $rowEdit = array();
    $getExist = $mysqli->query("SELECT * FROM tbl_halaqah WHERE id_pengampu='$idPengampu'");
    if ($getExist->num_rows != 0) $rowEdit = $getExist->fetch_assoc();

    ?>

    <!-- Bottommenu -->
    <?php include('includes/bottommenu.php'); ?>
    <!-- End Bottommenu -->

    <!-- Main Content -->
    <div class="content-container">
        <?php
        $surat = $mysqli->query("SELECT * FROM tbl_surat");
        $suratAkhir = $mysqli->query("SELECT * FROM tbl_surat");
        ?>
        <div class="row">
            <div class="col-biggest">
                <div class="card">
                    <div class="card-header">
                        Tambah <?php echo $tipe; ?>
                        <a href="user_home.php">Kembali</a>
                    </div>
                    <div class="card-content">
                        <form id="halaqahForm" enctype="multipart/form-data" method="post">
                            <div class="row">
                                <select id="cmbSantri" class="text-form col-biggest" name="txtSantri" form="halaqahForm">
                                    <?php
                                    $i = 1;
                                    $santriArray = explode('|', $rowEdit['array_id_santri']);
                                    ?>
                                    <option value="" selected disabled hidden>Pilih Nama Santri...</option>
                                    <?php foreach ($santriArray as &$row) :
                                        if ($row !== '') : ?>
                                            <option><?php
                                                    $getNamaSantri = $mysqli->query("SELECT nama_lengkap FROM tbl_santri WHERE id='$row'");
                                                    echo $getNamaSantri->fetch_assoc()['nama_lengkap']; ?>
                                            </option>
                                    <?php
                                        endif;
                                    endforeach; ?>
                                </select>

                                <label class="text-form col-bigger" for="cmbPengampu">Rekam Tahfidz :-</label>
                                <select id="cmbSurat" class="text-form col-biggest" name="txtSuratAwal" form="halaqahForm">
                                    <option value="" selected disabled hidden>Pilih Surat Awal...</option>
                                    <?php while ($row = $surat->fetch_assoc()) : ?>
                                        <option><?php echo $row['nama_surat']; ?></option>
                                    <?php endwhile; ?>
                                </select>
                                <input class="text-form col-biggest" type="tel" name="txtAyatAwal" placeholder="Ayat Awal...">

                                <select id="cmbSurat" class="text-form col-biggest" name="txtSuratAkhir" form="halaqahForm">
                                    <option value="" selected disabled hidden>Pilih Surat Akhir...</option>
                                    <?php while ($row = $suratAkhir->fetch_assoc()) : ?>
                                        <option><?php echo $row['nama_surat']; ?></option>
                                    <?php endwhile; ?>
                                </select>
                                <input class="text-form col-biggest" type="tel" name="txtAyatAkhir" placeholder="Ayat Akhir...">
                            </div>

                            <div class="row" style="margin-top: 20px;">
                                <button type="submit" name="btnSubmit" for="picture-btn" class="col-smaller custom-file-upload"> <i class="fas fa-plus"></i> Tambah </button>
                            </div>
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