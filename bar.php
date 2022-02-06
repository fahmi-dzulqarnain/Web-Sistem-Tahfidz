<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <script src="libraries/chart/js/Chart.js"></script>
</head>

<body>

  <div style="height:100%; width:100%">
    <canvas id="barchart"></canvas>
  </div>

</body>

</html>

<script type="text/javascript">
  var ctx = document.getElementById("barchart").getContext("2d");

  var data = {
    labels: <?php echo json_encode($labels); ?>,
    datasets: [{
        label: "Mencapai Target",
        data: <?php echo $mencapai; ?>,
        backgroundColor: '#29B0D0'
      },
      {
        label: "Tidak Mencapai Target",
        data: <?php echo $tidakMencapai; ?>,
        backgroundColor: '#2A516E'
      }
    ]
  };

  var myPieChart = new Chart(ctx, {
    type: 'bar',
    data: data,
    options: {
      responsive: true,
      legend: {
        display: true,
        position: 'bottom'
      },
      scales: {
        yAxes: [{
          display: true,
          ticks: {
            suggestedMin: 0,
            suggestedMax: 20
          }
        }]
      },
      animation: {
        duration: 0,
        onComplete: function() {
          var ctx = this.chart.ctx;
          ctx.font = Chart.helpers.fontString(Chart.defaults.global.defaultFontSize, 'normal', Chart.defaults.global.defaultFontFamily);
          ctx.fillStyle = this.chart.config.options.defaultFontColor;
          ctx.textAlign = 'center';
          ctx.textBaseline = 'bottom';
          this.data.datasets.forEach(function(dataset) {
            for (var i = 0; i < dataset.data.length; i++) {
              var model = dataset._meta[Object.keys(dataset._meta)[0]].data[i]._model;
              ctx.fillText(dataset.data[i], model.x, model.y - 5);
            }
          });
        }
      }
    }
  });
</script>