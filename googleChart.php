<?php
require_once("db_conn.php");
$pdo = DB_conn();
try
{
    $sql="SELECT * FROM temp_tb;";
    $stmh=$pdo->prepare($sql);
    $stmh->execute();
}
catch(PDOException $e)
{   print 'err: '. $e->getMessage();   }
?>


<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1"/>
	<title>실내 온도</title>
	<a href="index.html"><button>HOME</button></a>
	<!--라이브러리 Load-->
	<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
	<script type="text/javascript">
		google.charts.load('current', {'packages':['corechart']});
		google.charts.setOnLoadCallback(drawVisualization);
	//데이터 Setting
		function drawVisualization() { 
			var data = google.visualization.arrayToDataTable([
					['date', 'temp'],
<?php
					while($row=$stmh->fetch(PDO::FETCH_ASSOC))
                    {
?>
                    ['<?=$row['dt']?>',<?=(int)$row['temp']?>],
<?php
                    }
?>                  [NaN,NaN]
				]);
			//옵션 Setting
			var options = {
					title : '실내온도',
					vAxis: 
                    {
                        title: '온도',
                        viewWindow : {max:40, min:0}
                    },
					hAxis: {title: '시간'}, 
                    
				};
			//차트 그리기
			var chart = new google.visualization.LineChart(document.getElementById('chart_div'));
			chart.draw(data, options);
		}
	</script>
</head>
<body>
	<div id="chart_div" style="width:100%; height: 100%;"></div>
</body>
</html>