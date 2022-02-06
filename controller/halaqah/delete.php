<?php

if(isset($_GET['delete'])){
    $id = $_GET['delete'];
    
    $statement = $mysqli->prepare("DELETE FROM tbl_halaqah WHERE id = ?");
    $statement->bind_param('i', $id);
    $statement->execute();

    header( "Location:atur_halaqah.php");
    exit;
}

?>