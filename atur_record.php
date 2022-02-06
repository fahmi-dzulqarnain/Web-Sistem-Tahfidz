<!DOCTYPE html>
<html>

<head>
    <title>Admin - Record Tahfidz</title>

    <meta name="viewport"
        content="width=device-width, height=device-height, initial-scale=1.0, user-scalable=0, minimum-scale=0, maximum-scale=1.0">
    <link rel="icon" type="image/png" href="assets/MidLogo-light.png">

    <!-- Import Library -->
    <link rel="stylesheet" type="text/css" href="libraries/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Raleway:wght@300;400;500&display=swap">
    <!-- End Import Library -->

    <link rel="stylesheet" type="text/css" href="view/styles/style.css">
    <link rel="stylesheet" type="text/css" href="view/styles/chip.css">
</head>

<body class="overlay-scrollbar">

    <?php
    session_start();
    require("includes/config.php");

    include('includes/sidebar.php');
    include('includes/navbar.php');

    include('controller/record/filter.php');
    
    ?>

    <!-- Main Content -->
    <div class="wrapper">
        <div class="row">
            <div class="col-biggest">
                <div class="card">
                    <div class="card-header">
                        <div class="title">Record Tahfidz</div>
                    </div>
                    <div class="card-content">
                        <form action="atur_record.php" enctype="multipart/form-data" method="post"
                            class="flex-row wrapped-flex padding">
                            <h4 class="horizontal-margin">Filter Tanggal</h4>
                            <div class="flex-row wrapped-flex">
                                <input type="date" name="startDate" class="text-form-no-margin">
                                <h4 class="horizontal-margin">Sampai</h4>
                                <input type="date" name="endDate" class="text-form-no-margin">
                            </div>
                            <button type="submit" class="button horizontal-margin" name="btnFilter">Filter</button>
                        </form>

                        <div class="flex-row wrapped-flex">
                            <div class="chip active" onclick="filter('semua', 0, 2)">Semua</div>
                            <?php 
                            $index = 1;
                            foreach($halaqah as $row):?>
                            <div class="chip" onclick="filter('<?php echo $row; ?>', <?php echo $index++; ?>, 2)">
                                <?php echo $row;?></div>
                            <?php endforeach;?>
                        </div>

                        <table id="searchableTable">
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
                                if ($record != ''):
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
                                <?php endwhile; endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Main Content -->

    <script src="index.js"></script>
    <script src="controller/scripts/chip.js"></script>
</body>

</html>