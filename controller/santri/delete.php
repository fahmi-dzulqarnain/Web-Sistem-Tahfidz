<?php

if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $statement = $mysqli->prepare("DELETE FROM tbl_santri WHERE id = ?") or die($mysqli->error);
    $statement->bind_param('i', $id);
    $statement->execute();

    header("Location:atur_santri.php");
    exit;
}

?>