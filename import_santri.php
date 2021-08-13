<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Import Excel Santri</title>

    <!-- Import Library -->
    <link rel="stylesheet" type="text/css" href="fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Raleway:wght@300;400;500&display=swap">
    <!-- End Import Library -->

    <link rel="stylesheet" type="text/css" href="style.css">
</head>

<body>
    <?php
    session_start();
    require("includes/config.php");
    require 'iexcel/vendor/autoload.php';

    if (isset($_GET['berhasil'])) {
        echo "<p>" . $_GET['berhasil'] . " Data berhasil di import.</p>";
    }

    use PhpOffice\PhpSpreadsheet\Reader\Csv;
    use PhpOffice\PhpSpreadsheet\Reader\Xlsx;

    $file_mimes = array('application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');

    if (isset($_FILES['fileimport']['name']) && in_array($_FILES['fileimport']['type'], $file_mimes)) {

        $arr_file = explode('.', $_FILES['fileimport']['name']);
        $extension = end($arr_file);

        if ('csv' == $extension) $reader = new Csv();
        else $reader = new Xlsx();

        $spreadsheet = $reader->load($_FILES['fileimport']['tmp_name']);

        $sheetData = $spreadsheet->getActiveSheet()->toArray();
        for ($i = 1; $i < count($sheetData); $i++) {
            $nama = str_replace("'", "\'", $sheetData[$i]['1']);
            $nis = $sheetData[$i]['2'];
            $tempatLahir = $sheetData[$i]['3'];
            $tanggalLahir = $sheetData[$i]['4'];
            $gender = $sheetData[$i]['5'];
            $alamat = $sheetData[$i]['6'];
            $namaOrtu = str_replace("'", "\'", $sheetData[$i]['7']);
            $noHPortu = $sheetData[$i]['8'];
            $hafalanTerakhir = $sheetData[$i]['9'];
            $juzHafal = $sheetData[$i]['10'];

            $isAvailable = $mysqli->query("SELECT * FROM tbl_santri WHERE nis = '$nis'") or die($mysqli->error);
            if($isAvailable->num_rows){
                echo '<script type="text/javascript">';
                echo 'confirm("Ada NIS yang sama, apakah Anda ingin mengubahnya?");';
                echo '</script>';

                $mysqli->query("UPDATE tbl_santri SET nama_lengkap='$namaLengkap', nis='$nis', tempat_lahir='$tempatLahir', tanggal_lahir='$tanggalLahir', gender='$gender', 
                alamat='$alamat', nama_ortu='$namaOrtu', no_hp_ortu='$noHPortu', hafalan_terakhir='$hafalanTerakhir', juz_hafal='$juzHafal' WHERE nis='$nis'") or die($mysqli->error);
            } else {
                $mysqli->query("INSERT INTO tbl_santri (nama_lengkap, nis, tempat_lahir, tanggal_lahir, gender, alamat, nama_ortu, no_hp_ortu, hafalan_terakhir, juz_hafal) 
                                VALUES ('$nama', '$nis', '$tempatLahir', '$tanggalLahir', '$gender', '$alamat', '$namaOrtu', '$noHPortu', '$hafalanTerakhir', '$juzHafal')") or die($mysqli->error);
            }    
        }

        header( "Location:atur_santri.php");
        exit;
    }
    ?>

    <!-- Navbar -->
    <?php include('includes/navbar.php'); ?>
    <!-- End Navbar -->

    <!-- Sidebar -->
    <?php include('includes/sidebar.php'); ?>
    <!-- End Sidebar -->

    <!-- Main Content -->
    <div class="wrapper">
        <div class="row">
            <div class="col-biggest">
                <div class="card">
                    <div class="card-header">
                        Import Excel Data Santri
                    </div>
                    <div class="card-content">
                        <p class="card-title"><b>Import Excel</b></p>
                        <form enctype="multipart/form-data" method="post">
                            <div class="row">
                                <label for="default-btn" class="custom-file-upload col file-name">
                                    Pilih Berkas
                                </label>
                                <input id="default-btn" type="file" onchange="preview()" name="fileimport">
                                <button type="submit" class="custom-file-upload col-bigger" style="padding-bottom:10px;" name="btnSubmit"> <i class="fas fa-file-import"></i> Import</button>
                            </div>
                        </form>
                        <table style="margin-top: 2%;">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Nama</th>
                                    <th scope="col">NIS</th>
                                    <th scope="col">Hafalan Terakhir</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = 1;
                                $data = $mysqli->query("SELECT * FROM tbl_santri");
                                while ($d = $data->fetch_assoc()) {
                                ?>
                                    <tr>
                                        <td><?php echo $no++; ?></td>
                                        <td><?php echo $d['nama_lengkap']; ?></td>
                                        <td><?php echo $d['nis']; ?></td>
                                        <td><?php echo $d['hafalan_terakhir']; ?></td>
                                    </tr>
                                <?php
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Main Content -->

    <script src="index.js"></script>
    <script src="includes/file_upload.js"></script>
</body>

</html>