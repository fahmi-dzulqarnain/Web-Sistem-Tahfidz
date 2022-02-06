<?php

if(isset($_POST['btnSubmit'])){

    $namaLengkap = str_replace("'", "\'", $_POST['txtNamaLengkap']);
    $mapelDiampu = $_POST['txtMapelDiampu'];
    $hafalan = $_POST['txtHafalan'];
    $lulusan = $_POST['txtLulusan'];
    $noHP = $_POST['txtNoHP'];
    $isWalkel = $_POST['radioWalkel'];
  
    $statement = $mysqli->prepare('INSERT INTO tbl_pengampu (nama_lengkap, mapel_diampu, hafalan, lulusan, no_hp, is_wali_kelas) VALUES (?, ?, ?, ?, ?, ?)');
    $statement->bind_param('sssssi', $namaLengkap, $mapelDiampu, $hafalan, $lulusan, $noHP, $isWalkel);
    $statement->execute();
    
    $idUser = $mysqli->query("SELECT id FROM tbl_pengampu WHERE nama_lengkap = '$namaLengkap'")->fetch_assoc()['id'];
    $pengguna = str_replace("'", "", str_replace(' ', '_', strtolower($namaLengkap)));
    $password = md5($noHP.$hafalan);
    $tipeAkun = 'user';
    $mysqli->query("INSERT INTO tbl_akun (pengguna, sandi, tipe_akun, id_user)
                      VALUES ('$pengguna', '$password', '$tipeAkun', '$idUser')") or die($mysqli->error);
  
    header( "Location:atur_pengampu.php");
    exit;
}

if(isset($_POST['btnEdit'])){
    $id = $_POST['txtID'];
  
    $namaLengkap = $_POST['txtNamaLengkap'];
    $mapelDiampu = $_POST['txtMapelDiampu'];
    $hafalan = $_POST['txtHafalan'];
    $lulusan = $_POST['txtLulusan'];
    $noHP = $_POST['txtNoHP'];
    $isWalkel = $_POST['radioWalkel'];
  
    $mysqli->query("UPDATE tbl_pengampu SET nama_lengkap='$namaLengkap', mapel_diampu='$mapelDiampu', hafalan='$hafalan',
                    lulusan='$lulusan', no_hp='$noHP', is_wali_kelas='$isWalkel' WHERE id='$id'") or die($mysqli->error);
  
    header( "Location:atur_pengampu.php");
    exit;
  }
  
?>