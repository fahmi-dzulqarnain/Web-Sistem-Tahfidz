<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Admin - Kehadiran</title>

    <!-- Import Library -->
    <link rel="stylesheet" type="text/css" href="libraries/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Raleway:wght@300;400;500&display=swap">
    <!-- End Import Library -->

    <link rel="stylesheet" type="text/css" href="view/styles/style.css">
    <link rel="stylesheet" type="text/css" href="view/styles/chip.css">
</head>

<body>
    <?php
    session_start();
    require("includes/config.php");

    include('includes/navbar.php');
    include('includes/sidebar.php');

    $santri = $mysqli->query("SELECT id, nama_lengkap, kelas FROM tbl_santri");
    ?>

    <!-- Main Content -->
    <div class="wrapper">
        <div class="row">
            <div class="col-biggest">
                <div class="card">
                    <div class="card-header flex-row">
                        <div class="title">Kehadiran</div>
                        <form class="navbar-search">
                            <input id="searchInput" type="text" name="Search" class="navbar-search-input" placeholder="Cari Santri..." onkeyup="searchTable(1)">
                            <i class="fas fa-search"></i>
                        </form>
                    </div>
                    <div class="card-content">
                        <div class="flex-row">
                            <div class="chip active" onclick="filter('semua', 0, 2)">Semua</div>
                            <?php
                            $getKelas = $mysqli->query("SELECT nama_kelas FROM tbl_kelas");
                            $index = 1;
                            foreach ($getKelas->fetch_assoc() as $row) : ?>
                                <div class="chip" onclick="filter('<?php echo $row; ?>', <?php echo $index++; ?>, 2)">
                                    <?php echo $row; ?></div>
                            <?php endforeach; ?>
                        </div>
                        <table id="searchableTable">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Santri</th>
                                    <th>Kelas</th>
                                    <th>Hadir Setor</th>
                                    <th>Hadir</th>
                                    <th>Sakit</th>
                                    <th>Izin</th>
                                    <th>Alpa</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = 1;
                                while ($row = $santri->fetch_assoc()) :
                                    $idSantri = $row['id'];
                                    $namaSantri = $row['nama_lengkap'];
                                    $kelas = $row['kelas'];
                                    $hadirSetor = $mysqli->query("SELECT COUNT(id) as hadir_setor FROM tbl_kehadiran WHERE id_santri = '$idSantri' AND status_kehadiran = 'Hadir Setor'");
                                    $hadir = $mysqli->query("SELECT COUNT(id) as hadir FROM tbl_kehadiran WHERE id_santri = '$idSantri' AND status_kehadiran = 'Hadir'");
                                    $izin = $mysqli->query("SELECT COUNT(id) as izin FROM tbl_kehadiran WHERE id_santri = '$idSantri' AND status_kehadiran = 'Izin'");
                                    $sakit = $mysqli->query("SELECT COUNT(id) as sakit FROM tbl_kehadiran WHERE id_santri = '$idSantri' AND status_kehadiran = 'Sakit'");
                                    $alpa = $mysqli->query("SELECT COUNT(id) as alpa FROM tbl_kehadiran WHERE id_santri = '$idSantri' AND status_kehadiran = 'Alpa'"); ?>
                                    <tr>

                                        <td><?php echo $i++; ?></td>
                                        <td><?php echo $namaSantri; ?></td>
                                        <td><?php echo $kelas; ?></td>
                                        <td><?php echo $hadirSetor->fetch_assoc()['hadir_setor']; ?></td>
                                        <td><?php echo $hadir->fetch_assoc()['hadir']; ?></td>
                                        <td><?php echo $sakit->fetch_assoc()['sakit']; ?></td>
                                        <td><?php echo $izin->fetch_assoc()['izin']; ?></td>
                                        <td><?php echo $alpa->fetch_assoc()['alpa']; ?></td>

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
    <script src="includes/file_upload.js"></script>
    <script src="controller/scripts/search.js"></script>
    <script src="controller/scripts/chip.js"></script>
</body>

</html>