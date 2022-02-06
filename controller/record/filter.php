<?php

$record = '';
$halaqah = array();

if (isset($_POST['btnFilter'])){
    $startDate = $_POST['startDate'];
    $endDate = $_POST['endDate'];

    if ($startDate != '' && $endDate != ''){
        $startDate = date_format(date_create($startDate), 'Y/m/d');
        $endDate = date_format(date_create($endDate), 'Y/m/d');
        $statement = $mysqli->prepare("SELECT * FROM tbl_record WHERE tanggal BETWEEN ? AND ? ORDER BY tanggal DESC");   
        $statement->bind_param('ss', $startDate, $endDate);
        $statement->execute();
        $record = $statement->get_result();
    } else {
        $record = $mysqli->query("SELECT * FROM tbl_record ORDER BY tanggal DESC LIMIT 100");
    }

    $getHalaqah = $mysqli->query("SELECT id_pengampu FROM tbl_halaqah");

    while ($row = $getHalaqah->fetch_assoc()) {
        $id = $row['id_pengampu'];
        $pengampu = $mysqli->query("SELECT nama_lengkap FROM tbl_pengampu WHERE id = '$id'");
        $halaqah[] = $pengampu->fetch_assoc()['nama_lengkap'];
    }
}

?>