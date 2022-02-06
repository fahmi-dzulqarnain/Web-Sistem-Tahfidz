<?php

if (isset($_POST['btnAddAbsen'])) {
    $tanggal = date_format(date_create($_POST['txtDate']), 'Y/m/d');

    $data = $dataHalaqah['array_id_santri'];
    $santriArray = array();
    $santriArray = explode('|', $data);

    foreach ($santriArray as &$idSantri) :
        if ($idSantri !== '') {
            $statusKehadiran = 'Hadir';
            $statement = $mysqli->prepare("INSERT INTO tbl_kehadiran (id_santri, tanggal, status_kehadiran) VALUES (?, ?, ?)");
            $statement->bind_param('iss', $idSantri, $tanggal, $statusKehadiran);
            $statement->execute();
            $statement->close();
        }
    endforeach;

    header('Location:user_absen.php');
    exit;
}

?>