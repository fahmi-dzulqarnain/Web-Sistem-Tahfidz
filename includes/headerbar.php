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
  $idUser = $_SESSION['id_user'];
  $pengampu = $mysqli->query("SELECT * FROM tbl_pengampu WHERE id='$idUser'");
  $dataHalaqah = $mysqli->query("SELECT * FROM tbl_halaqah WHERE id_pengampu='$idUser'");
} else {
  session_destroy();
  echo '<script type="text/javascript">';
  echo 'alert("Sesi Anda Habis, Silakan Login Kembali!");';
  echo 'window.location.href = "index.php";';
  echo '</script>';
}

?>

<div class="top-container">
    <div class="nav-container">
        <img class="img-logo" style="height: 65px;" src="images/LOGO_SWTQIS.png" alt="">
        <h3>Tahfidz SWTQIS</h3>
        <img style="height: 55px; margin-top: 10px;" class="img-logo" src="images/PPIT.png" alt="">
    </div>
</div>