<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Import Excel Quran</title>

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
            $id = $sheetData[$i]['0'];
            $namaSurat = $sheetData[$i]['1'];
            $ayatKe = $sheetData[$i]['2'];
            $jumlahAyat = $sheetData[$i]['3'];
            $juz = $sheetData[$i]['4'];
            $mysqli->query("INSERT INTO tbl_quran (nama_surat, ayat, jumlah_baris, juz) 
                            VALUES ('$namaSurat', '$ayatKe', '$jumlahAyat', $juz)") or die($mysqli->error);
        }
        header("Location: import_atribut.php");
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