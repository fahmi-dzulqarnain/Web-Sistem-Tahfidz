<?php

//Get file name
$currentFile = $_SERVER["SCRIPT_NAME"];
$parts = Explode('/', $currentFile);
$currentFile = $parts[count($parts) - 1];

?>
<div class="bottom-container">
    <div class="tab-container">
        <a href="user_home.php" style="text-decoration:none;">
            <div class="tab <?php if ($currentFile == 'user_home.php' || $currentFile == 'tambah_record.php') echo 'active'; ?>">
                <i class="fas fa-home"></i>
                <p>Beranda</p>
            </div>
        </a>
        <a href="user_absen.php" style="text-decoration:none;">
            <div class="tab <?php if ($currentFile == 'user_absen.php' || $currentFile == 'input_absen.php') echo 'active'; ?>">
                <i class="fas fa-tasks"></i>
                <p>Absen</p>
            </div>
        </a>
        <a href="user_santri.php" style="text-decoration:none;">
            <div class="tab <?php if ($currentFile == 'user_santri.php') echo 'active'; ?>">
                <i class="fas fa-user-graduate"></i>
                <p>Santri</p>
            </div>
        </a>
        <a href="user_akun.php" style="text-decoration:none;">
            <div class="tab <?php if ($currentFile == 'user_akun.php') echo 'active'; ?>">
                <i class="fas fa-user"></i>
                <p>Akun</p>
            </div>
        </a>
    </div>
</div>