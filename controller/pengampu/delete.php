<?php

if(isset($_GET['delete'])){
    $id = $_GET['delete'];
    $mysqli->query("DELETE FROM tbl_pengampu WHERE id = '$id'") or die($mysqli->error);
  
    header( "Location:atur_pengampu.php");
    exit;
}

?>