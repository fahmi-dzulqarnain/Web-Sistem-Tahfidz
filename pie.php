<?php
require_once('includes/config.php');
$siswa = $mysqli->query("SELECT id, nama_lengkap FROM tbl_santri");
?>

<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <title>Chartjs, PHP dan MySQL Demo Grafik Lingkaran</title>
  <script src="chart/js/Chart.js"></script>
  <style type="text/css">
    .container {
      width: 40%;
      margin: 15px auto;
    }
  </style>
</head>

<body>

  <div style="position: relative; height:25vh; width:25vw">
    <canvas id="piechart"></canvas>
  </div>

</body>

</html>

<script type="text/javascript">
  var ctx = document.getElementById("piechart").getContext("2d");
  <?php
  $jumlah = array();
  $santri = array();
  //$month = array("01", "02", "03", "04", "05", "06");
  while ($p = mysqli_fetch_array($siswa)) {
    $idSiswa = $p['id'];
    array_push($santri, $p['nama_lengkap']);
    //$bulan = $month[$i];
    $data = $mysqli->query("SELECT SUM(jumlah_baris) as jumlah FROM tbl_record WHERE id_santri = '$idSiswa'"); // AND tanggal LIKE '%/$bulan/%'");
    $total = $data->fetch_assoc()['jumlah'];
    array_push($jumlah, $total);
    // for ($i = 0; $i < count($month); $i++){
    //   $bulan = $month[$i];
    //   $data = $mysqli->query("SELECT SUM(jumlah_baris) as jumlah FROM tbl_record WHERE id_santri = '$idSiswa' AND tanggal LIKE '%/$bulan/%'");
    //   $total = $data->fetch_assoc()['jumlah'];
    //   array_push($jumlah, $total);
    // }
  }
  ?>
  var data = {
    labels: [<?php foreach ($santri as $p) {
                echo '"' . $p . '",';
              } ?>],
    datasets: [{
      label: "Pencapaian Tahfidz",
      data: [<?php foreach ($jumlah as $p) {
                echo '"' . $p . '",';
              } ?>],
      backgroundColor: [
        '#29B0D0',
        '#2A516E',
        '#F07124',
        '#CBE0E3',
        '#979193'
      ]
    }]
  };

  var myPieChart = new Chart(ctx, {
    type: 'pie',
    data: data,
    options: {
      // responsive: true,
      legend: {
        display: true,
        position: 'left'
      }
    }
  });
</script>