<?php

session_start();
require('includes/config.php');

if (isset($_GET['login'])){
    $username = $_POST['txtUsername'];
    $password = md5($_POST['txtPassWord']);

    $result = $mysqli->query("SELECT * FROM tbl_akun WHERE pengguna = '$username' AND sandi = '$password'") or die($mysqli->error);

    if($result->num_rows){
        $row = $result->fetch_array();

        $_SESSION['codeID'] = $row['id'];
        $_SESSION['id_user'] = $row['id_user'];

        if ($row['tipe_akun'] == "superadmin"){
            header("Location: admin_home.php");
        } else {
            header("Location: user_home.php");
        }        
    }
    else {
        echo '<script type="text/javascript">';
        echo 'alert("Akun Tidak Ditemukan, atau Kata Sandi Salah");';
        echo 'window.location.href = "index.php";';
        echo '</script>';
    }
}

?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0, user-scalable=0, minimum-scale=0, maximum-scale=1.0">
    <title>Masuk Web Tahfidz</title>
    <link rel="stylesheet" type="text/css" href="style.css" >
  </head>
  <body class="center-content">
    <div>
      <div class="form-container">
        <div class="form-wrapper">
          <img style="width: 35%; margin-bottom: 50px;" src="images/LOGO_SWTQIS.png" alt="">
          <form action="?login=true" method="post">
            <input style="width: 100%" class="text-form-shadow" type="text" name="txtUsername" placeholder="Nama Pengguna..."> <br>
            <input style="width: 100%" class="text-form-shadow" type="password" name="txtPassWord" placeholder="Kata Sandi...">
            <button style="padding-bottom: 10px;" class="custom-file-upload" type="submit" name="btnSubmit">Masuk</button>
          </form>
        </div>    
        <!-- <div style="margin-top: 50px; display: inline-block;">
          <img style="width: 4%;" src="assets/MidLogo-Light.png" alt=""> 
          <span style="font-size: 13px;">Mid Perangkat Lunak</span>
        </div>     -->
      </div>
    </div>
    <script src="index.js"></script>
  </body>
</html>
