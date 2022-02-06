<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <script src="libraries/chart/js/Chart.js"></script>
</head>

<body>

  <div style="height:100%; width:100%">
    <canvas id="piechart"></canvas>
  </div>

</body>

</html>

<script type="text/javascript">
  var ctx = document.getElementById("piechart").getContext("2d");
  <?php
  $jumlah = json_encode(array($countMencapai, $countTidak));
  $pieLabel = json_encode(array('Mencapai Target', 'Tidak Mencapai Target'));
  ?>
  var data = {
    labels: <?php echo $pieLabel; ?>,
    datasets: [{
      label: "Pencapaian Tahfidz",
      data: <?php echo $jumlah; ?>,
      backgroundColor: [
        '#29B0D0',
        '#2A516E'
      ]
    }]
  };

  var myPieChart = new Chart(ctx, {
    type: 'pie',
    data: data,
    options: {
      responsive: true,
      legend: {
        display: true,
        position: 'bottom'
      }
    },
    plugins: {
      labels: {
        // render 'label', 'value', 'percentage', 'image' or custom function, default is 'percentage'
        render: 'value',
        precision: 0,
        showZero: true,
        fontSize: 12,
        fontColor: '#fff',
        fontStyle: 'normal',
        fontFamily: "'Quicksand', 'Helvetica', 'Arial', sans-serif",

        // draw label in arc, default is false
        // bar chart ignores this
        arc: true,

        // position to draw label, available value is 'default', 'border' and 'outside'
        // bar chart ignores this
        // default is 'default'
        position: 'default',

        // show the real calculated percentages from the values and don't apply the additional logic to fit the percentages to 100 in total, default is false
        showActualPercentages: true,

        // add padding when position is `outside`
        // default is 2
        outsidePadding: 4,

        // add margin of text when position is `outside` or `border`
        // default is 2
        textMargin: 4
      }
    }
  });
</script>