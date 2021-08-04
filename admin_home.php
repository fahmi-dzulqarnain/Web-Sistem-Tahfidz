<?php

session_start();

if (isset($_GET['logout'])) {
  session_destroy();
  echo '<script type="text/javascript">';
  echo 'window.location.href = "index.php";';
  echo '</script>';
}

if (isset($_SESSION['codeID'])){
  require_once('includes/config.php');
  $pengampu = $mysqli->query("SELECT COUNT(*) as total FROM tbl_pengampu") or die($mysqli->error);
  $santri = $mysqli->query("SELECT COUNT(*) as total FROM tbl_santri") or die($mysqli->error);
  $halaqah = $mysqli->query("SELECT COUNT(*) as total FROM tbl_halaqah") or die($mysqli->error);
} else {
  session_destroy();
  echo '<script type="text/javascript">';
  echo 'alert("Sesi Anda Habis, Silakan Login Kembali!");';
  echo 'window.location.href = "index.php";';
  echo '</script>';
}

?>

<!DOCTYPE html>
<html>
    <head>
        <title>Admin</title>

        <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0, user-scalable=0, minimum-scale=0, maximum-scale=1.0">
        <link rel="icon" type="image/png" href="images/MidLogo-light.png">

        <!-- Import Library -->
        <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.css">
        <link rel="stylesheet" type="text/css" href="fontawesome-free/css/all.min.css">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Raleway:wght@300;400;500&display=swap">
        <!-- End Import Library -->

        <link rel="stylesheet" type="text/css" href="style.css" >
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
            <div class="row">
                <div class="col">
                    <div class="counter bg-primary">
                        <i class="fas fa-chalkboard-teacher"></i>
                        <h3><?php echo $pengampu->fetch_assoc()['total']; ?></h3>
                        <p>Pengampu</p>
                    </div>
                </div>
                <div class="col">
                    <div class="counter bg-warning">
                        <i class="fas fa-user-graduate"></i>
                        <h3><?php echo $santri->fetch_assoc()['total']; ?></h3>
                        <p>Santri Terdaftar</p>
                    </div>
                </div>
                <div class="col">
                    <div class="counter bg-success">
                        <i class="fas fa-users-cog"></i>
                        <h3><?php echo $halaqah->fetch_assoc()['total']; ?></h3>
                        <p>Halaqah Dibuat</p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <div class="card">
                        <div class="card-header">
                            Grafik Pencapaian Siswa
                        </div>
                        <div class="card-content">
                            <?php include('pie.php'); ?>
                        </div>
                    </div>
                </div>
            </div>
            <!-- <div class="row">
                <div class="col-bigger">
                    <div class="card">
                        <div class="card-header">
                            Riwayat Postingan
                            <i class="fas fa-ellipsis-h"></i>
                        </div>
                        <div class="card-content">
                            <table>
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Project</th>
                                        <th>Manager</th>
                                        <th>Status</th>
                                        <th>Due Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td>React</td>
                                        <td>Fahmi Dzulqarnain</td>
                                        <td>
                                            <span class="dot">
                                                <i class="bg-success"></i>
                                                Completed
                                            </span>
                                        </td>
                                        <td>26/04/2021</td>
                                    </tr>
                                    <tr>
                                        <td>2</td>
                                        <td>Vue JS</td>
                                        <td>Ahmad Fauzi</td>
                                        <td>
                                            <span class="dot">
                                                <i class="bg-warning"></i>
                                                In Progress
                                            </span>
                                        </td>
                                        <td>26/04/2021</td>
                                    </tr>
                                    <tr>
                                        <td>3</td>
                                        <td>Android</td>
                                        <td>Zaid Abdul Hamid</td>
                                        <td>
                                            <span class="dot">
                                                <i class="bg-success"></i>
                                                Completed
                                            </span>
                                        </td>
                                        <td>26/04/2021</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div> -->
        </div>
        <!-- End Main Content -->

        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js"></script>
        <script src="index.js"></script>
    </body>
</html>
