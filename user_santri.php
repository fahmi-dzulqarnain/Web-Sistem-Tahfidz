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

    <title>Data Santri</title>
</head>

<body class="user_home">

    <!-- Headerbar -->
    <?php include('includes/headerbar.php'); ?>
    <!-- End Headerbar -->

    <!-- Bottommenu -->
    <?php include('includes/bottommenu.php'); ?>
    <!-- End Bottommenu -->

    <div class="content-container wrapper">
        <?php
        $i = 1;
        $data = $dataHalaqah['array_id_santri'];
        $santriArray = array();
        $santriArray = explode('|', $data);
        foreach ($santriArray as &$row) :
            if ($row !== '') :
                $getNamaSantri = $mysqli->query("SELECT * FROM tbl_santri WHERE id='$row'");
                $dataSantri = $getNamaSantri->fetch_assoc(); ?>
                <div class="row">
                    <div class="col">
                        <div class="card padding">
                            <h4><?php echo $dataSantri['nama_lengkap'];?></h4>
                            <p>TTL : <?php echo $dataSantri['tempat_lahir'].', '.$dataSantri['tanggal_lahir'];?></p>
                            <p>Wali : <?php echo $dataSantri['nama_ortu'].' ('.$dataSantri['no_hp_ortu'].')';?></p>
                            <p>Hafal : <?php echo $dataSantri['juz_hafal'].' Juz, Surat Terakhir '.$dataSantri['hafalan_terakhir'];?></p>
                            <p>Alamat : <?php echo $dataSantri['alamat']; ?></p>
                        </div>
                    </div>
                </div>
        <?php endif;
        endforeach; ?>
    </div>

    <script src="controller/scripts/bottomtab.js"></script>
    <script src="index.js"></script>
</body>

</html>