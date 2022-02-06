<?php

if (isset($_POST['btnSubmit'])) {

    $namaLengkap = $_POST['txtNamaLengkap'];
    $nis = $_POST['txtNIS'];
    $kelas = $_POST['txtKelas'];
    $tempatLahir = $_POST['txtTempatLahir'];
    $tanggalLahir = $_POST['txtTanggalLahir'];
    $gender = $_POST['txtKelamin'];
    $alamat = $_POST['txtAlamat'];
    $namaOrtu = $_POST['txtNamaOrtu'];
    $noHPortu = $_POST['txtHPortu'];
    $hafalanTerakhir = $_POST['txtHafalanTerakhir'];
    $juzHafal = $_POST['txtJumlahJuz'];

    $isAvailable = $mysqli->query("SELECT * FROM tbl_santri WHERE nis = '$nis'") or die($mysqli->error);
    if ($isAvailable->num_rows) {
        echo '<script type="text/javascript">';
        echo 'confirm("Ada NIS yang sama, apakah Anda ingin mengubahnya?");';
        echo '</script>';

        $statement = $mysqli->prepare("UPDATE tbl_santri SET nama_lengkap=?, nis=?, kelas=?, tempat_lahir=?, tanggal_lahir=?, gender=?, 
                alamat=?, nama_ortu=?, no_hp_ortu=?, hafalan_terakhir=?, juz_hafal=? WHERE nis=?");
        $statement->bind_param('ssssssssssis', $namaLengkap, $nis, $kelas, $tempatLahir, $tanggalLahir, $gender, $alamat, $namaOrtu, $noHPortu, $hafalanTerakhir, $juzHafal, $nis);
        $statement->execute();        
    } else {
        $statement = $mysqli->prepare("INSERT INTO tbl_santri (nama_lengkap, nis, kelas, tempat_lahir, tanggal_lahir, gender, alamat, nama_ortu, no_hp_ortu, hafalan_terakhir, juz_hafal) 
                                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $statement->bind_param('sssssssssis', $namaLengkap, $nis, $kelas, $tempatLahir, $tanggalLahir, $gender, $alamat, $namaOrtu, $noHPortu, $hafalanTerakhir, $juzHafal);
        $statement->execute();   
    }

    header("Location:atur_santri.php");
    exit;
}

if (isset($_POST['btnEdit'])) {
    $id = $_POST['txtID'];

    $namaLengkap = $_POST['txtNamaLengkap'];
    $nis = $_POST['txtNIS'];
    $kelas = $_POST['txtKelas'];
    $tempatLahir = $_POST['txtTempatLahir'];
    $tanggalLahir = $_POST['txtTanggalLahir'];
    $gender = $_POST['txtKelamin'];
    $alamat = $_POST['txtAlamat'];
    $namaOrtu = $_POST['txtNamaOrtu'];
    $noHPortu = $_POST['txtHPortu'];
    $hafalanTerakhir = $_POST['txtHafalanTerakhir'];
    $juzHafal = $_POST['txtJumlahJuz'];
    
    $statement = $mysqli->prepare("UPDATE tbl_santri SET nama_lengkap=?, nis=?, kelas=?, tempat_lahir=?, tanggal_lahir=?, gender=?, 
                alamat=?, nama_ortu=?, no_hp_ortu=?, hafalan_terakhir=?, juz_hafal=? WHERE nis=?");
    $statement->bind_param('ssssssssssis', $namaLengkap, $nis, $kelas, $tempatLahir, $tanggalLahir, $gender, $alamat, $namaOrtu, $noHPortu, $hafalanTerakhir, $juzHafal, $nis);
    $statement->execute(); 

    header("Location:atur_santri.php");
    exit;
}

?>