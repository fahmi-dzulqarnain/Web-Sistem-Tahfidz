<!DOCTYPE html>
<html style="box-sizing: border-box;">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0, user-scalable=0, minimum-scale=0, maximum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <!-- Import Library -->
    <link rel="stylesheet" type="text/css" href="fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Raleway:wght@300;400;500&display=swap">
    <!-- End Import Library -->

    <link rel="stylesheet" type="text/css" href="style.css">

    <title>Beranda</title>
</head>

<body class="user_home">

    <!-- Headerbar -->
    <?php include('includes/headerbar.php'); ?>
    <!-- End Headerbar -->

    <?php
    if (isset($_GET['delete'])) {
        $idRecord = $_GET['delete'];
        $mysqli->query("DELETE FROM tbl_record WHERE id = '$idRecord'") or die($mysqli->error);

        header("Location:user_home.php");
        exit;
    }
    ?>

    <!-- FAB Button -->
    <div class="fab-container">
        <div class="fab fab-icon-holder" onclick="fabClick()">
            <i class="fas fa-plus"></i>
        </div>

        <ul class="fab-options">
            <li>
                <span class="fab-label">Sabaq</span>
                <a href="tambah_record.php?tipe=sabaq">
                    <div class="fab-icon-holder">
                        <i class="fas fa-quran"></i>
                    </div>
                </a>
            </li>
            <li>
                <span class="fab-label">Sabqi</span>
                <a href="tambah_record.php?tipe=sabqi">
                    <div class="fab-icon-holder">
                        <i class="fas fa-quran"></i>
                    </div>
                </a>
            </li>
            <li>
                <span class="fab-label">Manzil</span>
                <a href="tambah_record.php?tipe=manzil">
                    <div class="fab-icon-holder">
                        <i class="fas fa-quran"></i>
                    </div>
                </a>
            </li>
        </ul>
    </div>
    <!-- End FAB Button -->

    <!-- List of Record -->
    <div class="content-container">
        <?php
        $idPengampu = $_SESSION['id_user'];
        $record = $mysqli->query("SELECT * FROM tbl_record WHERE id_pengampu='$idPengampu' ORDER BY id DESC");
        ?>
        <div class="row">
            <!-- <form class="navbar-search">
                <input type="text" name="Search" class="navbar-search-input" placeholder="Cari...">
                <i class="fas fa-search"></i>
            </form> -->
            <?php while ($row = $record->fetch_assoc()) : ?>
                <div class="col card" style="background: #fff;">
                    <div class="card-content">
                        <span class="top-right"><?php echo $row['tanggal']; ?></span>
                        <h3>
                            <?php
                            $idSantri = $row['id_santri'];
                            $namaSantri = $mysqli->query("SELECT * FROM tbl_santri WHERE id='$idSantri'");
                            echo $namaSantri->fetch_assoc()['nama_lengkap']; ?>
                        </h3>
                        <span class="top-right"><?php echo ucfirst($row['tipe_setor']); ?></span>
                        <a href="?delete=<?php echo $row['id']; ?>" onclick="return confirm('Apakah Anda yakin ingin menghapus Record Tahfidz ini?');" class="btn-icon bg-danger top-right" style="margin: 25px 0 0 0;"> <i class="fas fa-trash"></i> </a>
                        <p style="margin: 10px 0 10px 0;">
                            <?php
                            $result = '';
                            if ($row['surat_awal'] == $row['surat_akhir']) $result = $row['surat_awal'] . ' : ' . $row['ayat_awal'] . ' - ' . $row['ayat_akhir'];
                            else $result = $row['surat_awal'] . ' : ' . $row['ayat_awal'] . ' - ' . $row['surat_akhir'] . ' : ' . $row['ayat_akhir'];
                            echo $result;
                            ?>
                        </p>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    </div>
    <!-- End of list -->

    <!-- Bottommenu -->
    <?php include('includes/bottommenu.php'); ?>
    <!-- End Bottommenu -->

    <script>
        const tabs = document.querySelectorAll('.tab')
        const fab = document.querySelector('.fab')

        tabs.forEach(clickedTab => {
            clickedTab.addEventListener('click', () => {
                tabs.forEach(tab => {
                    tab.classList.remove('active')
                })
                clickedTab.classList.add('active')
            })
        })

        function fabClick() {
            if (fab.classList.contains('active')) {
                fab.classList.remove('active')
            } else {
                fab.classList.add('active')
            }
        }
    </script>
    <script src="index.js"></script>
</body>

</html>