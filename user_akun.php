<!DOCTYPE html>
<html style="box-sizing: border-box;">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0, user-scalable=0, minimum-scale=0, maximum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <!-- Import Library -->
    <link rel="stylesheet" type="text/css" href="fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Raleway:wght@300;400;500&display=swap">
    <!-- End Import Library -->

    <link rel="stylesheet" type="text/css" href="style.css">

    <title>Akun</title>
</head>

<body class="user_home">

    <!-- Headerbar -->
    <?php include('includes/headerbar.php'); ?>
    <!-- End Headerbar -->

    <!-- Bottommenu -->
    <?php include('includes/bottommenu.php'); ?>
    <!-- End Bottommenu -->

    <?php
    $id = $_SESSION['codeID'];
    $akun = $mysqli->query("SELECT * FROM tbl_akun WHERE id = '$id'");
    $data = $pengampu->fetch_assoc();
    ?>
    <div class="content-container">
        <div class="row">
            <div class="col">
                <div class="card-santri">
                    <h4>Data Akun</h4>
                    <p>Username : <?php echo $akun->fetch_assoc()['pengguna'] ?></p>
                    <p>Nama Lengkap : <?php echo $data['nama_lengkap']; ?></p>
                    <p>Mapel Diampu : <?php echo $data['mapel_diampu']; ?></p>
                    <p>Hafalan : <?php echo $data['hafalan'] . ' Juz'; ?></p>
                    <p>No. HP : <?php echo $data['no_hp']; ?></p>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <a href="?logout=true" class="dropdown-menu-link" style="background: #fff;">
            <div>
                <i class="fas fa-sign-out-alt"></i>
            </div>
            <span>
                Keluar
            </span>
        </a>
    </div>

    <script>
        const tabs = document.querySelectorAll('.tab')
        const fab = document.querySelector('.fab')

        tabs.forEach(clickedTab => {
            clickedTab.addEventListener('click', () => {
                tabs.forEach(tab => {
                    tab.classList.remove('active')
                })
                clickedTab.classList.add('active')
            })
        })

        function fabClick() {
            if (fab.classList.contains('active')) {
                fab.classList.remove('active')
            } else {
                fab.classList.add('active')
            }
        }
    </script>
    <script src="index.js"></script>
</body>

</html>