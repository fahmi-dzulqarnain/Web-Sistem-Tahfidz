<?php

session_start();
require("includes/config.php");

if(isset($_GET['delete'])){
  $id = $_GET['delete'];
  $mysqli->query("DELETE FROM tbl_halaqah WHERE id = '$id'") or die($mysqli->error);

  header( "Location:atur_halaqah.php");
  exit;
}

?>

<!DOCTYPE html> 
<html>
    <head>
        <title>Admin - Halaqah</title>

        <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0, user-scalable=0, minimum-scale=0, maximum-scale=1.0">
        <link rel="icon" type="image/png" href="assets/MidLogo-light.png">

        <!-- Import Library -->
        <link rel="stylesheet" type="text/css" href="fontawesome-free/css/all.min.css">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Raleway:wght@300;400;500&display=swap">
        <!-- End Import Library -->

        <link rel="stylesheet" type="text/css" href="style.css" >
    </head>
    <body class="overlay-scrollbar">

        <?php
        require("includes/config.php");

        $posts = $mysqli->query("SELECT * FROM tbl_halaqah");
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
                      Atur Halaqah
                      <a href="tambah_halaqah.php">Tambah</a>
                  </div>
                  <div class="card-content">
                      <table>
                          <thead>
                              <tr>
                                  <th>No.</th>
                                  <th>Nama Halaqah</th>
                                  <th>Pengampu</th>
                                  <th>Target Bulanan</th>
                                  <th></th>
                              </tr>
                          </thead>
                          <tbody>
                            <?php
                            $i = 1;
                            while ($row = $posts->fetch_assoc()): ?>
                              <?php
                                $id = $row['id_pengampu'];
                                $pengampu = $mysqli->query("SELECT * FROM tbl_pengampu WHERE id = '$id'");
                              ?>
                              <tr>
                                  <td><?php echo $i++; ?></td>
                                  <td><?php echo $row['nama_halaqah']; ?></td>
                                  <td><?php echo $pengampu->fetch_assoc()['nama_lengkap']; ?></td>     
                                  <td><?php echo $row['target_bulanan']; ?></td>                             
                                  <td>
                                    <a href="tambah_halaqah.php?idHalaqah=<?php echo $row['id']; ?>" class="btn-icon bg-primary"> <i class="fas fa-edit"></i> </a>
                                    <a href="?delete=<?php echo $row['id']; ?>" onclick="return confirm('Apakah Anda yakin ingin menghapus Halaqah ini? Data hafalan, dan lainnya tidak akan ikut terhapus');" class="btn-icon bg-danger"> <i class="fas fa-trash"></i> </a>
                                  </td>
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
