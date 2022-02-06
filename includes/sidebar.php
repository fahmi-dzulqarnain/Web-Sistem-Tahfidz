<?php

//Get file name
$currentFile = $_SERVER["SCRIPT_NAME"];
$parts = Explode('/', $currentFile);
$currentFile = $parts[count($parts) - 1];

include('config.php');

?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
<div class="sidebar">
    <ul class="sidebar-nav">
        <li class="sidebar-nav-item">
            <a href="admin_home.php" class="sidebar-nav-link <?php if($currentFile=="admin_home.php"){?>active<?php }?>">
                <div>
                    <i class="fas fa-tachometer-alt"></i>
                </div>
                <span>
                    Dashboard
                </span>
            </a>
        </li>
        <li class="sidebar-nav-item">
            <a href="atur_pengampu.php" class="sidebar-nav-link <?php if($currentFile=="atur_pengampu.php"){?>active<?php }?>">
                <div>
                    <i class="fas fa-chalkboard-teacher"></i>
                </div>
                <span>
                    Pengampu
                </span>
            </a>
        </li>
        <li class="sidebar-nav-item">
            <a href="atur_santri.php" class="sidebar-nav-link <?php if($currentFile=="atur_santri.php" || $currentFile=="import_santri.php"){?>active<?php }?>">
                <div>
                    <i class="fas fa-user-graduate"></i>
                </div>
                <span>
                    Santri
                </span>
            </a>
        </li>
        <li class="sidebar-nav-item">
            <a href="atur_halaqah.php" class="sidebar-nav-link <?php if($currentFile=="atur_halaqah.php" or $currentFile=="tambah_halaqah.php" or $currentFile=="ubah_halaqah.php"){?>active<?php }?>">
                <div>
                    <i class="fas fa-users-cog"></i>
                </div>
                <span>
                    Halaqah
                </span>
            </a>
        </li>
        <li class="sidebar-nav-item">
            <a href="atur_record.php" class="sidebar-nav-link <?php if($currentFile=="atur_record.php"){?>active<?php }?>">
                <div>
                    <i class="fas fa-file-alt"></i>
                </div>
                <span>
                    Record
                </span>
            </a>
        </li>
        <li class="sidebar-nav-item">
            <a href="atur_kehadiran.php" class="sidebar-nav-link <?php if($currentFile=="atur_kehadiran.php"){?>active<?php }?>">
                <div>
                    <i class="fas fa-tasks"></i>
                </div>
                <span>
                    Kehadiran
                </span>
            </a>
        </li>
        <li class="sidebar-nav-item">
            <a href="atur_laporan.php" class="sidebar-nav-link <?php if($currentFile=="atur_laporan.php"){?>active<?php }?>">
                <div>
                    <i class="fas fa-chart-pie"></i>
                </div>
                <span>
                    Laporan
                </span>
            </a>
        </li>
    </ul>
</div>
</html>