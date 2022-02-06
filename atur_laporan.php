<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Admin - Laporan Tahfidz</title>

    <meta name="viewport"
        content="width=device-width, height=device-height, initial-scale=1.0, user-scalable=0, minimum-scale=0, maximum-scale=1.0">
    <link rel="icon" type="image/png" href="assets/MidLogo-light.png">

    <!-- Import Library -->
    <link rel="stylesheet" type="text/css" href="libraries/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Raleway:wght@300;400;500&display=swap">
    <!-- End Import Library -->

    <link rel="stylesheet" type="text/css" href="view/styles/style.css">
</head>

<body class="overlay-scrollbar">
    <?php
    session_start();
    require("includes/config.php");

    include('includes/sidebar.php');
    include('includes/navbar.php');

    $getKelas = $mysqli->query("SELECT nama_kelas FROM tbl_kelas");
    $bulan = array('Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember');
    $tipe = array('Sabaq', 'Sabqi', 'Manzil');

    $ganjil = array('Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember');
    $genap = array('Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni');

    function getMonthNumber($nameOfTheMonth){    
        $bulan = array('Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember');
        $monthNumber = array_search($nameOfTheMonth, $bulan);
        return $monthNumber + 1;
    }
    ?>

    <!-- Main Content -->
    <div class="wrapper">
        <div class="row">
            <div class="col-half">
                <div class="card padding">
                    <div class="title"><i class="fas fa-chart-pie"></i> Laporan Wali Kelas</div>
                    <form id="laporanForm" action="atur_laporan.php" class="vertical-margin row" method="post"
                        enctype="multipart/form-data" style="margin-top: 32px;">
                        <select title="Kelas" class="text-form col-biggest" name="txtKelas" form="laporanForm">
                            <option value="" selected disabled hidden>Pilih Kelas...</option>
                            <?php while ($row = $getKelas->fetch_assoc()) : ?>
                            <option><?php echo $row['nama_kelas']; ?></option>
                            <?php endwhile; ?>
                        </select>
                        <select title="Bulan" class="text-form col-biggest" name="txtBulan" form="laporanForm">
                            <option value="" selected disabled hidden>Pilih Bulan...</option>
                            <?php foreach ($bulan as $row) : ?>
                            <option><?php echo $row; ?></option>
                            <?php endforeach; ?>
                        </select>
                        <select title="Tipe Setor" class="text-form col-biggest" name="txtTipe" form="laporanForm">
                            <option value="" selected disabled hidden>Pilih Tipe Setoran...</option>
                            <?php foreach ($tipe as $row) : ?>
                            <option><?php echo $row; ?></option>
                            <?php endforeach; ?>
                        </select>

                        <button class="button close-modal-btn col-bigger" name="btnShowReport"
                            style="margin: 24px auto 0 auto;">
                            Tampilkan Laporan
                        </button>
                    </form>
                </div>
            </div>
            <div class="col-half">
                <div class="card padding">
                    <div class="title"><i class="fas fa-chart-line"></i> Laporan Manajemen</div>
                    <form id="managementForm" action="atur_laporan.php" class="vertical-margin row" method="post"
                        enctype="multipart/form-data" style="margin-top: 32px;">
                        <select id="cmbSemester" title="Wali Kelas" class="text-form col-biggest" name="txtSemester"
                            form="managementForm">
                            <option value="" selected disabled hidden>Pilih Semester...</option>
                            <option>Ganjil</option>
                            <option>Genap</option>
                        </select>

                        <button class="button close-modal-btn col-bigger" name="btnManagementReport"
                            style="margin: auto;">
                            Tampilkan Laporan
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <?php if (isset($_POST['btnShowReport'])) : 
            $bulan = $_POST['txtBulan'];
            $kelas = $_POST['txtKelas'];
            $tipe = $_POST['txtTipe'];

            $getWalkel = $mysqli->query("SELECT wali_kelas FROM tbl_kelas WHERE nama_kelas = '$kelas'");
            $waliKelas = $getWalkel->fetch_assoc()['wali_kelas'];
            $getNamaGuru = $mysqli->query("SELECT nama_lengkap FROM tbl_pengampu WHERE id = '$waliKelas'");
            $namaGuru = $getNamaGuru->fetch_assoc()['nama_lengkap'];
            
            if (in_array($bulan, $ganjil)){
                $semester = 'Ganjil';
                $labels = $ganjil;
            } else if (in_array($bulan, $genap)){
                $semester = 'Genap';
                $labels = $genap;
            }

            $countMencapai = 0;
            $countTidak = 0;
            ?>
        <div id="section-to-print" class="row margin">
            <h2 class="col-biggest">Laporan Tahfidz Bulanan SWTQIS</h2>
            <div class="flex-column paragraph">
                <p>Kelas &nbsp;&nbsp;&nbsp;: <?php echo $kelas; ?></p>
                <p>Wali Kelas &nbsp;: <?php echo $namaGuru; ?></p>
                <p>Bulan &nbsp;&nbsp;&nbsp;: <?php echo $bulan; ?></p>
            </div>

            <h3 class="col-biggest">Tabel Pencapaian Santri</h3>
            <table class="col-biggest margin">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Santri</th>
                        <th>Pencapaian</th>
                        <th>Catatan</th>
                        <th>Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                        $santri = $mysqli->query("SELECT id, nama_lengkap FROM tbl_santri WHERE kelas = '$kelas'");
                        $numberOfMonth = '/'.str_pad(getMonthNumber($bulan), 2, '0', STR_PAD_LEFT).'/';
                        $i = 1;

                        while ($row = $santri->fetch_assoc()): 
                            $idSantri = $row['id'];
                            $record = $mysqli->query("SELECT SUM(jumlah_baris) as pencapaian FROM tbl_record WHERE id_santri = '$idSantri' AND tanggal LIKE '%$numberOfMonth%' AND tipe_setor = '$tipe'");
                            $pencapaian = $record->fetch_assoc()['pencapaian'] / 15;

                            if ($pencapaian >= 20) {
                                $keterangan = 'Mencapai Target';
                                $countMencapai +=1 ;
                            } else {
                                $keterangan = 'Tidak Mencapai Target';
                                $countTidak += 1;
                            }
                            ?>
                    <tr>
                        <td><?php echo $i++; ?></td>
                        <td><?php echo $row['nama_lengkap']; ?></td>
                        <td><?php echo $pencapaian; ?> halaman</td>
                        <td><?php echo $keterangan; ?></td>
                        <td>
                            <div contenteditable>-</div>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                    <tr>
                        <td colspan="5"><b>Jumlah Mencapai Target <?php echo $countMencapai; ?> Santri</b></td>
                    </tr>
                    <tr>
                        <td colspan="5"><b>Jumlah Tidak Mencapai Target <?php echo $countTidak; ?> Santri</b></td>
                    </tr>
                </tbody>
            </table>

            <div class="col-half">
                <h3>Grafik Pencapaian Target</h3>
                <p style="margin-bottom: 20px;">Bulan <?php echo $bulan; ?></p>
                <?php include('pie.php'); ?>
            </div>

            <?php
            
            $mencapai = array();
            $tidakMencapai = array();
            
            foreach($labels as $bulan){
                $santri = $mysqli->query("SELECT id, nama_lengkap FROM tbl_santri WHERE kelas = '$kelas'");
                $countMencapai = 0;
                $countTidak = 0;
                
                while ($row = $santri->fetch_assoc()){

                    $idSantri = $row['id'];
                    $record = $mysqli->query("SELECT SUM(jumlah_baris) as pencapaian FROM tbl_record WHERE id_santri = '$idSantri' AND tanggal LIKE '%$numberOfMonth%' AND tipe_setor = '$tipe'");
                    $pencapaian = $record->fetch_assoc()['pencapaian'] / 15;

                    if ($pencapaian >= 20) {
                        $keterangan = 'Mencapai Target';
                        $countMencapai +=1 ;
                    } else {
                        $keterangan = 'Tidak Mencapai Target';
                        $countTidak += 1;
                    }
                }

                array_push($mencapai, $countMencapai);
                array_push($tidakMencapai, $countTidak);
            }

            $mencapai = json_encode($mencapai);
            $tidakMencapai = json_encode($tidakMencapai);
            ?>

            <div class="col-half">
                <h3>Grafik Perkembangan Bulanan</h3>
                <p>Semester <?php echo $semester; ?></p>
                <?php include('bar.php'); ?>
            </div>
        </div>
        <?php endif;?>

        <?php if (isset($_POST['btnManagementReport'])): 
                $semester = $_POST['txtSemester'];
            ?>
        <div id="section-to-print" class="row margin">
            <h2 class="col-biggest">Laporan Tahfidz SWTQIS</h2>
            <div class="flex-column paragraph">
                <p>Semester &nbsp;: <?php echo $semester; ?></p>
                <p>Tahun Ajaran &nbsp;&nbsp;&nbsp;: <?php // echo $bulan; ?></p>
            </div>

            <h3 class="col-biggest">Tabel Pencapaian Santri</h3>
            <table class="col-biggest margin">
                <thead>
                    <tr>
                        <th>Kelas</th>
                        <th>Jumlah Siswa</th>
                        <th>Tercapai</th>
                        <th></th>
                        <th>Tidak Tercapai</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                        $kelas = $mysqli->query("SELECT nama_kelas FROM tbl_kelas");

                        while ($row = $kelas->fetch_assoc()): 
                            $namaKelas = $row['nama_kelas'];
                            $santri = $mysqli->query("SELECT id, nama_lengkap FROM tbl_santri WHERE kelas = '$namaKelas'");
                            $jumlahSantri = $santri->num_rows;

                            $countMencapai = 0;
                            $countTidak = 0;
                            
                            while ($namaSantri = $santri->fetch_assoc()){
                                $idSantri = $namaSantri['id'];
                                $record = $mysqli->query("SELECT SUM(jumlah_baris) as pencapaian FROM tbl_record WHERE id_santri = '$idSantri' AND tipe_setor = 'Sabaq'");
                                $pencapaian = $record->fetch_assoc()['pencapaian'] / 15;
    
                                if ($pencapaian >= 100) {
                                    $countMencapai +=1 ;
                                } else {
                                    $countTidak += 1;
                                }
                            }
                            
                            $persentaseMencapai = ($countMencapai / $jumlahSantri) * 100;
                            $persentaseTidak = ($countTidak / $jumlahSantri) * 100;
                            ?>
                    <tr>
                        <td><?php echo $namaKelas; ?></td>
                        <td><?php echo $jumlahSantri; ?></td>
                        <td><?php echo $countMencapai; ?></td>
                        <td><?php echo $persentaseMencapai; ?>%</td>
                        <td><?php echo $countTidak; ?></td>
                        <td><?php echo $persentaseTidak; ?>%</td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>

            <!-- <div class="col-half">
                <h3>Grafik Pencapaian Target</h3>
                <p style="margin-bottom: 20px;">Bulan <?php //echo $bulan; ?></p>
                <?php //include('pie.php'); ?>
            </div> -->

        </div>
        <?php endif; ?>
    </div>

    <script src="index.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js"></script>
    <script src="libraries/chart/js/chartjs-plugin-labels.min.js"></script>
</body>

</html>