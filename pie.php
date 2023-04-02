<?php
  // 데이터베이스 연결 정보 정의
  $servername = "localhost";
  $username = "root";
  $password = "";
  $dbname = "myDB";

  // 데이터베이스 연결
  $conn = new mysqli($servername, $username, $password, $dbname);
  if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
  }

  // 데이터 가져오기
  $sql = "SELECT * FROM pizza";
  $result = $conn->query($sql);
?>

<?php
  // 데이터베이스에서 가져온 데이터를 사용하여 Google 차트에 필요한 데이터를 생성합니다.
  $chart_data = array(['Task', 'Hours per Day']);
  if ($result->num_rows > 0) {
      while($row = $result->fetch_assoc()) {
          $chart_data[] = array($row["toping"], (int)$row["amount"]);
      }
  }
?>

<?php
  // Google 차트 코드를 수정하여 위에서 생성한 데이터를 사용하도록 합니다.
  echo '<html>
  <head>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load(\'current\', {\'packages\':[\'corechart\']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {

        var data = google.visualization.arrayToDataTable(' . json_encode($chart_data) . ');

        var options = {
          title: \'My Pizza Toppings\'
        };

        var chart = new google.visualization.PieChart(document.getElementById(\'piechart\'));

        chart.draw(data, options);
      }
    </script>
  </head>
  <body>
    <div id="piechart" style="width: 900px; height: 500px;"></div>
  </body>
</html>';
?>

<?php
  // 데이터베이스 연결 종료
  $conn->close();
?>