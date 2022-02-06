<!DOCTYPE html>
<html lang="id" style="box-sizing: border-box;">

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
        content="width=device-width, height=device-height, initial-scale=1.0, user-scalable=0, minimum-scale=0, maximum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <!-- Import Library -->
    <link rel="stylesheet" type="text/css" href="libraries/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Raleway:wght@300;400;500&display=swap">
    <!-- End Import Library -->

    <link rel="stylesheet" type="text/css" href="view/styles/style.css">
    <link rel="stylesheet" type="text/css" href="view/styles/modal.css">

    <title>Akun</title>
</head>

<body class="user_home">

    <?php 
    include('includes/headerbar.php'); 
    include('includes/bottommenu.php');
    include('controller/absen/add.php');
    ?>

    <!-- List of Record -->
    <div class="content-container">
        <?php
        $idSantri = explode('|', $dataHalaqah['array_id_santri']);
        foreach ($idSantri as &$row) :
            if ($row !== '') {
                $idSantri = $row;
                break;
            }
        endforeach;
        $recordAbsen = $mysqli->query("SELECT DISTINCT tanggal FROM tbl_kehadiran WHERE id_santri LIKE '%$idSantri%' ORDER BY id DESC");
        
        $arrayOfMonth = array('Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember');
        
        function getLongDate($date) {
            $numberOfMonth = (int) substr($date, 5, 2);
            $numberOfYear = (int) substr($date, 0, 4);
            $numberOfDay = (int) substr($date, 8, 2);

            global $arrayOfMonth;
            return $numberOfDay . ' ' . $arrayOfMonth[$numberOfMonth - 1] . ' ' . $numberOfYear;
        }
        
        ?>
        <div class="row">
            <!-- <form class="navbar-search">
                <input type="text" name="Search" class="navbar-search-input" placeholder="Cari...">
                <i class="fas fa-search"></i>
            </form> -->
            <table class="searchableTable">
                <tbody>
                    <form action="input_absen.php" method="POST">
                        <?php while ($row = $recordAbsen->fetch_assoc()) : 
                            $tanggal = $row['tanggal'];?>
                        <tr>
                            <td>
                                <input type="hidden" name="tanggal" value="<?php echo $tanggal; ?>">
                                <input type="submit" class="btn-no-style" value="<?php echo getLongDate($tanggal); ?>">
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </form>
                </tbody>
            </table>
        </div>
    </div>
    <!-- End of list -->

    <?php include('view/modals/add_absen.php'); ?>

    <div class="fab-container">
        <div class="fab fab-icon-holder" onclick="openModal()">
            <i class="fas fa-plus"></i>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="controller/scripts/bottomtab.js"></script>
    <script src="controller/scripts/modal.js"></script>
    <script src="index.js"></script>
</body>

</html>