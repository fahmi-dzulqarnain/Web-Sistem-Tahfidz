<?php

$mysqli = mysqli_connect('localhost', 'root', '', 'swtqispp_tahfidz') or die(mysqli_error($mysqli));
$akun = $mysqli->query("SELECT * FROM tbl_akun") or die(mysqli_error($mysqli));
