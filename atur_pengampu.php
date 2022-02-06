<!DOCTYPE html>
<html>

<head>
    <title>Admin - Pengampu</title>

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

    <!-- Navbar -->
    <?php 
    
    session_start();
    require("includes/config.php");
    $rowEdit = '';
    
    include 'controller/pengampu/add_change.php';
    include 'controller/pengampu/delete.php';
    
    if(isset($_GET['edit'])){
      $id = $_GET['edit'];
      $result = $mysqli->query("SELECT * FROM tbl_pengampu WHERE id = '$id'") or die($mysqli->error);
      $rowEdit = $result->fetch_assoc();
    }

    include('includes/navbar.php'); 
    include('includes/sidebar.php');

    $pengampu = $mysqli->query("SELECT * FROM tbl_pengampu");
    ?>

    <!-- Main Content -->
    <div class="wrapper">
        <div class="row">
            <div class="col-biggest">
                <div class="card">
                    <div class="card-header">
                        <?php if ($rowEdit !== ''): ?>
                          Ubah Pengampu
                          <a href="atur_pengampu.php">Batal</a>
                        <?php else: ?>
                          Tambah Pengampu
                        <?php endif; ?>
                    </div>
                    <div class="card-content">
                        <form enctype="multipart/form-data" action="atur_pengampu.php" method="post">
                            <div class="row">
                                <?php if ($rowEdit !== ''): ?>
                                  <input type="text" name="txtID" value="<?php echo $rowEdit['id']; ?>" hidden>
                                <?php endif; ?>
                                <input class="text-form col-half" type="text" name="txtNamaLengkap" placeholder="Nama Pengampu..." value="<?php if ($rowEdit !== '') echo $rowEdit['nama_lengkap']; ?>">
                                <input class="text-form col-half" type="text" name="txtMapelDiampu" placeholder="Mapel Diampu..." value="<?php if ($rowEdit !== '') echo $rowEdit['mapel_diampu']; ?>">
                                <input class="text-form col-half" type="tel" name="txtHafalan" placeholder="Jumlah Hafalan..." value="<?php if ($rowEdit !== '') echo $rowEdit['hafalan']; ?>">
                                <input class="text-form col-half" type="text" name="txtLulusan" placeholder="Lulusan..." value="<?php if ($rowEdit !== '') echo $rowEdit['lulusan']; ?>">
                                <input class="text-form col-half" type="tel" name="txtNoHP" placeholder="No. HP..." value="<?php if ($rowEdit !== '') echo $rowEdit['no_hp']; ?>">
                                <div class="flex-row">
                                    <input type="radio" name="radioWalkel" class="hideopt" id="1" value="1">
                                    <label class="chip" for="1">Wali Kelas</label>
                                    <input type="radio" name="radioWalkel" class="hideopt" id="0" value="0">
                                    <label class="chip" for="0">Bukan Wali Kelas</label>
                                </div>
                                <button type="submit" class="custom-file-upload" style="padding-bottom:10px;" name="<?php if ($rowEdit !== ''): echo 'btnEdit'; else: echo 'btnSubmit'; endif; ?>">
                                    <?php if ($rowEdit !== ''): ?>
                                      <i class="fas fa-edit"></i> Ubah Pengampu</button>
                                    <?php else: ?>
                                      <i class="fas fa-save"></i> Tambah Pengampu</button>
                                    <?php endif; ?>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-biggest">
                <div class="card">
                    <div class="card-header">
                        Daftar Pengampu
                    </div>
                    <div class="card-content">
                        <table>
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Nama Lengkap</th>
                                    <th>Mapel Diampu</th>
                                    <th>Hafalan</th>
                                    <th>Lulusan</th>
                                    <th>No. HP</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = 1;
                                while ($row = $pengampu->fetch_assoc()): ?>
                                <tr>
                                    <td><?php echo $i++; ?></td>
                                    <td><?php echo $row['nama_lengkap']; ?></td>
                                    <td><?php echo $row['mapel_diampu']; ?></td>
                                    <td><?php echo $row['hafalan']; ?></td>
                                    <td><?php echo $row['lulusan']; ?></td>
                                    <td><?php echo $row['no_hp']; ?></td>
                                    <td>
                                        <a href="atur_pengampu.php?edit=<?php echo $row['id']; ?>"
                                            class="btn-icon bg-primary"> <i class="fas fa-edit"></i> </a>
                                        <a href="?delete=<?php echo $row['id']; ?>"
                                            onclick="return confirm('Apakah Anda yakin ingin menghapus Pengampu ini?');"
                                            class="btn-icon bg-danger"> <i class="fas fa-trash"></i> </a>
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