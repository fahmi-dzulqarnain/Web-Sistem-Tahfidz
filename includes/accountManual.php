<?php

require('config.php');

$pengguna = 'admin';
$password = md5('admin');
$tipeAkun = 'superadmin';
$mysqli->query("INSERT INTO tbl_akun (pengguna, sandi, tipe_akun)
                VALUES ('$pengguna', '$password', '$tipeAkun')") or die($mysqli->error);

?>