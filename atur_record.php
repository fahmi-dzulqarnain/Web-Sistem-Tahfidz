<?php

session_start();
require("includes/config.php");

?>

<!DOCTYPE html>
<html>

<head>
    <title>Admin - Record Tahfidz</title>

    <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0, user-scalable=0, minimum-scale=0, maximum-scale=1.0">
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

    $record = $mysqli->query("SELECT * FROM tbl_record");
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
                        Record Tahfidz
                    </div>
                    <div class="card-content">
                        <table>
                            <thead>
                                <tr>
                                    <th>Tgl</th>
                                    <th>Nama Santri</th>
                                    <th>Pengampu</th>
                                    <th>Setoran</th>
                                    <th>Jlh. Baris</th>
                                    <th>Tipe</th>
                                    <th>Juz</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                while ($row = $record->fetch_assoc()) : ?>
                                    <?php
                                    $idSantri = $row['id_santri'];
                                    $idPengampu = $row['id_pengampu'];
                                    $pengampu = $mysqli->query("SELECT nama_lengkap FROM tbl_pengampu WHERE id = '$idPengampu'");
                                    $santri = $mysqli->query("SELECT nama_lengkap FROM tbl_santri WHERE id = '$idSantri'");

                                    $result = '';
                                    if ($row['surat_awal'] == $row['surat_akhir']) $result = $row['surat_awal'] . ' : ' . $row['ayat_awal'] . ' - ' . $row['ayat_akhir'];
                                    else $result = $row['surat_awal'] . ' : ' . $row['ayat_awal'] . ' - ' . $row['surat_akhir'] . ' : ' . $row['ayat_akhir'];
                                    ?>
                                    <tr>
                                        <td><?php echo $row['tanggal']; ?></td>
                                        <td><?php echo $santri->fetch_assoc()['nama_lengkap']; ?></td>
                                        <td><?php echo $pengampu->fetch_assoc()['nama_lengkap']; ?></td>
                                        <td><?php echo $result; ?></td>
                                        <td><?php echo $row['jumlah_baris']; ?></td>
                                        <td><?php echo $row['tipe_setor']; ?></td>
                                        <td><?php echo $row['juz']; ?></td>                                        
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