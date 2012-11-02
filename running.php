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


	<?php
		$runNumber = $_GET['routeid'];
		include("config.php");
		$startLat;
		$startLng;
		$finLat;
		$finLng;
		$bcquery = sprintf("select * from BreadCrumbs where RouteID='%s' order by bcID", $runNumber);
		$bcresult = mysql_query($bcquery);
		
		while($bcrow = mysql_fetch_array($bcresult)) {
			if($bcrow['isStart'] == 1) {
				$startLat = $bcrow['lat'];
				$startLng = $bcrow['lng'];
				echo("
					<script type=\"text/javascript\">
					var startLat=".$startLat.";
					var startLng=".$startLng.";
					</script>");
			}
			if($bcrow['isFinish'] == 1) {
				$finLat = $bcrow['lat'];
				$finLng = $bcrow['lng'];
				echo("
					<script type=\"text/javascript\">
					var finLat=".$finLat.";
					var finLng=".$finLng.";
					</script>");
			}
		}
		
	?>
	
		<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCv5woZWJa4qFr4nO4Dp9dCl3LrPQBMToE&sensor=false"></script>
				
	<div id="mapcanvas" style="height:288px;width:300px"></div>
	<script type="text/javascript">
		$(document).ready(function() {
			//Build LatLng objects
			var startLatLng = new google.maps.LatLng(startLat, startLng);
			var finLatLng = new google.maps.LatLng(finLat, finLng);
			var runCoordinates = [
				new google.maps.LatLng(37.424264, -122.176215),
				new google.maps.LatLng(37.424477,-122.177266),
				new google.maps.LatLng(37.421844,-122.178157),
				new google.maps.LatLng(37.420507,-122.176488),
				new google.maps.LatLng(37.42155,-122.17379),
				new google.maps.LatLng(37.423148,-122.173999)
			];
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
			
		});
	</script>
	
	<?php
		echo "<p>Your Time: </p>";
		echo "<p>Goal Time: </p>";
	?>
 </div><!-- /content -->

</div><!-- /page -->

</body>
</html>