<!DOCTYPE html> 
<html> 
<head> 
	<title>New Goal</title> 
	<meta name="viewport" content="width=device-width, initial-scale=1"> 
	<link rel="stylesheet" href="http://code.jquery.com/mobile/1.2.0/jquery.mobile-1.2.0.min.css" />
	<script src="http://code.jquery.com/jquery-1.8.2.min.js"></script>
	<script src="http://code.jquery.com/mobile/1.2.0/jquery.mobile-1.2.0.min.js"></script>
  <link rel="stylesheet" href="jquery.ui.datepicker.mobile.css" /> 
    

</head> 
<body> 

<div data-role="page">

	<div data-role="header">
		<h1>
		<?php
		$runNumber = $_GET['routeid'];
			include("config.php");

			$query = sprintf("select * from Routes where RouteID='%s'", $runNumber);
			$result = mysql_query($query);
			while($row = mysql_fetch_array($result))
	  		{
				echo $row['Name']; 
		  	}

		?>
		</h1>
		<a href="home.php" data-icon="back" data-rel="back">Home</a>

	</div><!-- /header -->

	<div data-role="content">	
	<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCv5woZWJa4qFr4nO4Dp9dCl3LrPQBMToE&sensor=false"></script>

	<?php
		$runNumber = $_GET['routeid'];
		include("config.php");
		$startLat;
		$startLng;
		$finLat;
		$finLng;
		$bcquery = sprintf("select * from BreadCrumbs where RouteID='%s' order by bcID", $runNumber);
		$bcresult = mysql_query($bcquery);
		echo ("
			<script type=\"text/javascript\">
			var runCoordinates = [
		");
		while($bcrow = mysql_fetch_array($bcresult)) {
			if($bcrow['isStart'] == 1) {
				$startLat = $bcrow['lat'];
				$startLng = $bcrow['lng'];
			}
			if($bcrow['isFinish'] == 1) {
				$finLat = $bcrow['lat'];
				$finLng = $bcrow['lng'];
				echo "new google.maps.LatLng(".$finLat.", ".$finLng.")\n";
			} else {
			$currLat = $bcrow['lat'];
			$currLng = $bcrow['lng'];
			echo "new google.maps.LatLng(".$currLat.", ".$currLng."),\n";
			}
		}
		echo("
			];
			var startLat=".$startLat.";
			var startLng=".$startLng.";
			var finLat=".$finLat.";
			var finLng=".$finLng.";
			</script>");
		
	?>
	
		
				
	<div id="mapcanvas" style="height:288px;width:300px"></div>
	<script type="text/javascript">
			//And our timer code:
			var start = new Date().getTime();
			var elapsed = '0.0';
			var is_on = 1;
			var t;
			
			function runTimer() {
			var currTime = new Date().getTime() - start;
			elapsed = Math.floor(currTime / 100) / 10; 
			if(Math.round(elapsed) == elapsed) { elapsed += '.0'; } 
			document.getElementById('yourTime').value=elapsed;
			t=setTimeout("runTimer()",50);
			};
			
			function pauseTimer() {
				clearTimeout(t);
				is_on = 0;
			}
			
			function resumeTimer() {
				if(!is_on) {
					is_on = 1;
					runTimer();
				}
			}
	
		$(document).ready(function() {
			//Build LatLng objects
			var startLatLng = new google.maps.LatLng(startLat, startLng);
			var finLatLng = new google.maps.LatLng(finLat, finLng);

			//Set our map options.
			var mapOptions = {
				center: startLatLng,
				zoom: 15,
				mapTypeId: google.maps.MapTypeId.ROADMAP
			};
			//Create Markers and Path for the start end ending points.
			var map = new google.maps.Map(document.getElementById("mapcanvas"),
				mapOptions);
			var startMarker = new google.maps.Marker({
				position: startLatLng,
				title: "Start"
			});
			var finMarker = new google.maps.Marker({
				position: finLatLng,
				title: "Finish"
			});
			var runPath = new google.maps.Polyline({
				path: runCoordinates,
				strokeColor: "#FF0000",
				strokeOpacity: 1.0,
				strokeWeight: 2
			});
			//And add them to the map.
			startMarker.setMap(map);
			finMarker.setMap(map);
			runPath.setMap(map);
			

			
			runTimer();
		});
		

		
		$(function() {
			$("#pause").click(function() {
				$(this).hide();
				$("#resume").show();
				$("#end").show();
				pauseTimer();
			});
			$("#resume").click(function() {
				$("#pause").show();
				$("#resume").hide();
				$("#end").hide();
				resumeTimer();
			});
		});
	</script>
	
	<?php
		echo "<p>Your Time: <input type=\"text\" id=\"yourTime\" /></p>";
		echo "<p>Goal Time: </p>";
	?>
	<div class="running" id="runningBlock">
	<a href="#" id="pause" data-role="button">Pause</a>
	</div>
	<div class="paused" id="pausedBlock">
	<a href="#" id="resume" data-role="button">Resume</a>
	<a href="home.php" id="end" data-role="button">End</a>
	</div>
 </div><!-- /content -->

</div><!-- /page -->

</body>
</html>