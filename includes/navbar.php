<?php

if (isset($_SESSION['codeID'])){
    require_once('includes/config.php');
    $pengampu = $mysqli->query("SELECT COUNT(*) as total FROM tbl_pengampu") or die($mysqli->error);
    $santri = $mysqli->query("SELECT COUNT(*) as total FROM tbl_santri") or die($mysqli->error);
    $halaqah = $mysqli->query("SELECT COUNT(*) as total FROM tbl_halaqah") or die($mysqli->error);
  } else {
    session_destroy();
    echo '<script type="text/javascript">';
    echo 'alert("Sesi Anda Habis, Silakan Login Kembali!");';
    echo 'window.location.href = "index.php";';
    echo '</script>';
  }

?>
<div class="navbar">
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link">
                <i class="fas fa-bars" onclick="collapseSidebar()"></i>
            </a>
        </li>
        <li class="nav-item">
            <img src="images/PPIT.png" alt="Mid Admin" class="logo">
        </li>
    </ul>
    <!-- <form class="navbar-search">
        <input type="text" name="Search" class="navbar-search-input" placeholder="Apa Yang Anda Cari...">
        <i class="fas fa-search"></i>
    </form> -->
    <ul class="navbar-nav nav-right">
        <li class="nav-item">
            <div class="nav-link" href="#" onclick="changeTheme()">
                <i class="fas fa-moon dark-icon"></i>
                <i class="fas fa-sun light-icon"></i>
            </div>
        </li>
        <li class="nav-item">
            <div class="avt dropdown">
                <img src="images/LOGO_SWTQIS.png" alt="Profile Image" class="dropdown-toggle" data-toggle="user-menu">
                <ul id="user-menu" class="dropdown-menu">
                    <li class="dropdown-menu-item">
                        <a href="#" class="dropdown-menu-link">
                            <div>
                                <i class="fas fa-user-tie"></i>
                            </div>
                            <span>
                                Profil Akun
                            </span>
                        </a>
                    </li>
                    <li class="dropdown-menu-item">
                        <a href="?logout=true" class="dropdown-menu-link">
                            <div>
                                <i class="fas fa-sign-out-alt"></i>
                            </div>
                            <span>
                                Keluar
                            </span>
                        </a>
                    </li>
                </ul>
            </div>
        </li>
    </ul>
</div>
