<?php
session_start();
$conn = mysqli_connect("localhost", "root", "", "system");
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
<html>
  <head>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load("current", {packages:["corechart"]});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Category', 'Count'],
          <?php
          $sql = "SELECT category_name, COUNT(*) as count FROM product_categories GROUP BY category_name";
          $fire = mysqli_query($conn, $sql);
          if (!$fire) {
              echo "['No Data', 0]";
          } else {
              while ($row = mysqli_fetch_assoc($fire)) {
                  echo "['" . $row['category_name'] . "', " . $row['count'] . "],";
              }
          }
          ?>
        ]);

        var options = {
          title: 'Product Categories Distribution',
          pieHole: 0.4
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart'));
        chart.draw(data, options);
      }
    </script>
  </head>
  <body>
    <div id="piechart" style="width: 900px; height: 500px;"></div>
  </body>
</html>
