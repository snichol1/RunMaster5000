<!DOCTYPE html> 
<html> 
<head> 
	<title>New Goal</title> 
	<meta name="viewport" content="width=device-width, initial-scale=1"> 
	<link rel="stylesheet" href="http://code.jquery.com/mobile/1.2.0/jquery.mobile-1.2.0.min.css" />
	<script src="http://code.jquery.com/jquery-1.8.2.min.js"></script>
	<script src="http://code.jquery.com/mobile/1.2.0/jquery.mobile-1.2.0.min.js"></script>
    

</head> 
<body> 

<div data-role="page">

	<div data-role="header">
		<h1>
		<?php
		$routeID = $_GET['routeID'];
			include("config.php");

			$query = sprintf("select * from Routes where RouteID='%s'", $routeID);
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
		$routeID = $_GET['routeID'];
		$userID = $_GET['userID'];
		include("config.php");
		$startLat;
		$startLng;
		$finLat;
		$finLng;
		$bcquery = sprintf("select * from BreadCrumbs where RouteID='%s' order by bcID", $routeID);
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
			//Variables for our map and current location
			var map;
			var currMarker;
			var lt;
			var ticker = 0;
			var locations = new Array();

			//Variables for our timer code:
			var startTime = new Date().getTime();
			var elapsed = '0.0';
			var is_on = 1;
			var t;
			
			function runTimer() {
				var currTime = new Date().getTime();
				var currMin = Math.floor((currTime - startTime)/60000);
				var currSec = Math.floor((currTime - startTime) / 1000) - (currMin * 60);
				currSec = ("0" + currSec).slice(-2);
				var currMilli = currTime - startTime - (currMin * 60000) - (currSec * 1000);
				currMilli = ("000" + currMilli).slice(-4);
				var elapsed = currMin + ":" + currSec + ":" + currMilli;
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

			//initialize the currMarker
			function initializeCurrLocation() {
				navigator.geolocation.getCurrentPosition(handleLocationInitialization, handleError);
			}

			//Continuously keep track of the user's current location
			function trackLocation() {
				navigator.geolocation.getCurrentPosition(handleLocationUpdate, handleError)
				lt=setTimeout("trackLocation()", 10000);
			}
			//Set the initial location of the current location marker
			function handleLocationInitialization(position) {
				var currLatLng = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
				locations[ticker] = currLatLng;
				currMarker = new google.maps.Marker({
					position: currLatLng,
					animation: google.maps.Animation.BOUNCE,
					title: "Current Location"
				});
				currMarker.setMap(map);
			}
			//Update the position of the current location marker
			function handleLocationUpdate(position) {
				var currLatLng = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
				currMarker.setPosition(currLatLng);
				console.log("Lat:" + currLatLng.lat());
				console.log("Lng:" + currLatLng.lng());
				console.log(ticker);
				ticker++;
				locations[ticker] = currLatLng;
			}
			function handleError(error) {
				switch(error.code)  {  
                case error.PERMISSION_DENIED: alert("user did not share geolocation data");  
                break;  
                case error.POSITION_UNAVAILABLE: alert("could not detect current position");  
                break;  
                case error.TIMEOUT: alert("retrieving position timed out");  
                break;  
                default: alert("unknown error");  
                break;  
            	}  
			}


			//Take an array of latlng objects and calculate the distance in miles from the first
			//object in the array to the last
			function calculateDistance(positions) {
				var totalDistance = 0;
				for(var i = 1; i < positions.length; i++) {
					var lat1 = positions[i - 1].lat();
					var lat2 = positions[i].lat();
					var lng1 = positions[i - 1].lng();
					var lng2 = positions[i].lng();
					var x = (lng2 - lng1) * Math.cos((lat1 + lat2)/2);
					var y = (lat2 - lat1);
					totalDistance += Math.sqrt(x*x + y*y);
				}
				return totalDistance;
			}
	
		$(document).ready(function() {
			initializeCurrLocation();
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
			map = new google.maps.Map(document.getElementById("mapcanvas"),
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
			
			console.log("num coords:" + runCoordinates.length);
			console.log("Lat" + runCoordinates[0].lat());
			console.log("Miles:" + calculateDistance(runCoordinates));

			
			runTimer();
			trackLocation();
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