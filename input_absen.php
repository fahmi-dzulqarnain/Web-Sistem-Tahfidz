<!DOCTYPE html>
<html lang="id" style="box-sizing: border-box;">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0, user-scalable=0, minimum-scale=0, maximum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <!-- Import Library -->
    <link rel="stylesheet" type="text/css" href="libraries/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Raleway:wght@300;400;500&display=swap">
    <!-- End Import Library -->

    <link rel="stylesheet" type="text/css" href="view/styles/style.css">
    <link rel="stylesheet" type="text/css" href="view/styles/modal.css">
    <link rel="stylesheet" type="text/css" href="view/styles/chip.css">

    <title>Akun</title>
</head>

<body class="user_home">

    <?php
    include('includes/headerbar.php');
    include('includes/bottommenu.php');
    include('controller/absen/add.php');

    if (isset($_POST['radioAbsen'])){
        $absen = $_POST['radioAbsen'];
        $idSantri = $_POST['txtIdSantri'];
        $tanggal = $_POST['txtTanggal'];

        $statement = $mysqli->prepare("UPDATE tbl_kehadiran SET status_kehadiran = ? WHERE id_santri = ? AND tanggal = ?");
        $statement->bind_param("sis", $absen, $idSantri, $tanggal);
        $statement->execute();
        $statement->close();

        $_POST['tanggal'] = $tanggal;
    }
    ?>

    <!-- List of Record -->
    <div class="content-container">
        <?php

        if (isset($_POST['tanggal'])) :
            $tanggal = $_POST['tanggal'];
            $idSantri = explode('|', $dataHalaqah['array_id_santri']);
            $arrayOfMonth = array('Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember');
            foreach ($idSantri as &$row) :
                if ($row !== '') :
                    $recordAbsen = $mysqli->query("SELECT * FROM tbl_kehadiran WHERE id_santri LIKE '%$row%' AND tanggal = '$tanggal'");
                    $result = $recordAbsen->fetch_assoc();
                    $namaSantri = $mysqli->query("SELECT nama_lengkap FROM tbl_santri WHERE id='$row'")->fetch_assoc()['nama_lengkap'];
                    $statusKehadiran = $result['status_kehadiran']; ?>

                    <form action="input_absen.php" method="POST">
                        <div class="row">
                            <div class="flex-column">
                                <input type="hidden" name="txtTanggal" value="<?php echo $tanggal; ?>">
                                <input type="hidden" name="txtIdSantri" value="<?php echo $row; ?>">
                                <p><?php echo $namaSantri; ?></p>
                                <div class="flex-row wrapped-flex" style="margin-left: -10px;">
                                    <input type="submit" name="radioAbsen" class="chip <?php if ($statusKehadiran == "Hadir Setor") { ?> active <?php } ?>" value="Hadir Setor">
                                    <input type="submit" name="radioAbsen" class="chip <?php if ($statusKehadiran == "Hadir") { ?> active <?php } ?>" value="Hadir">
                                    <input type="submit" name="radioAbsen" class="chip <?php if ($statusKehadiran == "Sakit") { ?> active <?php } ?>" value="Sakit">
                                    <input type="submit" name="radioAbsen" class="chip <?php if ($statusKehadiran == "Izin") { ?> active <?php } ?>" value="Izin">
                                    <input type="submit" name="radioAbsen" class="chip <?php if ($statusKehadiran == "Alpa") { ?> active <?php } ?>" value="Alpa">
                                </div>
                            </div>
                        </div>

                    </form>

        <?php endif;
            endforeach;
        endif; ?>
    </div>
    <!-- End of list -->

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="controller/scripts/bottomtab.js"></script>
    <script src="controller/scripts/modal.js"></script>
    <script src="index.js"></script>
</body>

</html>