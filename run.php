<?php session_start() ?>
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
		$goal = $_SESSION['goal'];
		include("config.php");
		$startLat = 0;
		$startLng = 0;
		$finLat = 0;
		$finLng = 0;

		if(isset($goal)) {
			echo ("
				<script type=\"text/javascript\">
				var goalTimePretty = \"".$goal."\";
				//console.log(goalTimePretty);
				</script>
			");
		}else {
			echo ("
				<script type=\"text/javascript\">
				var goalTimePretty = 0;
				</script>
			");
		}

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
			//total length of the run in miles
			var runDistance = calculateDistance(runCoordinates);

			//Variables for our map and current location
			var map;
			var currMarker;
			var lt;
			var ticker = 0;
			var locations = new Array();

			//Variables for our timer code:
			var startTime = new Date().getTime();
			var elapsed = 0;
			var is_on = 1;
			var t;
			var goalTime = 0;
			
			function runTimer() {
				var currTime = new Date().getTime();
				elapsed += currTime - startTime;
				startTime = currTime;
				var elapsedPretty = formatTime(elapsed);
				document.getElementById('yourTime').textContent="Your Time: " + elapsedPretty;
				t=setTimeout("runTimer()",50);
			};

			function formatTime(time) {
				var min = Math.floor(time/60000);
				var sec = Math.floor(time / 1000) - (min * 60);
				sec = ("0" + sec).slice(-2);
				var milli = time - (min * 60000) - (sec * 1000);
				milli = ("000" + milli).slice(-4);
				return (min + ":" + sec + ":" + milli);

			}

			function unformatTime(time) {
				var rawTime = 0;
				var bits = time.split(":");
				//console.log(bits.toString());
				rawTime += 3600000 * bits[0];
				rawTime += 60000 * bits[1];
				rawTime += 1000 * bits[2];
				return rawTime;
			}
			
			function pauseTimer() {
				clearTimeout(t);
				is_on = 0;
				sessionStorage.time = formatTime(elapsed);
			}
			
			function resumeTimer() {
				if(!is_on) {
					is_on = 1;
					startTime = new Date().getTime();
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
				//Calculate user's current position and add it to their locations
				var currLatLng = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
				currMarker.setPosition(currLatLng);
				//console.log("Lat:" + currLatLng.lat());
				//console.log("Lng:" + currLatLng.lng());
				//console.log(ticker);
				ticker++;
				locations[ticker] = currLatLng;

				//track and display the user's pace re: their goal time, if there is one.
				if(goalTime > 0) {
					//Calculate their milage and update the page accordingly
					var currDistance = calculateDistance(locations);
					document.getElementById("mileage").textContent = currDistance + " miles run.";

					//Calculate how far on or off pace the runner is and display
					var distToGo = runDistance - currDistance;
					//var goalTime = 1000000;
					//console.log("elapsed: " + elapsed);
					//console.log("total run distance:" + runDistance);

					var lastTwoLocations = new Array(2);
					lastTwoLocations[0] = locations[locations.length - 2];
					lastTwoLocations[1] = locations[locations.length - 1];
					var lastLegVelocity = calculateDistance(lastTwoLocations) / 10000;
					//var lastLegVelocity = runDistance / goalTime;
					//console.log("llv: " + lastLegVelocity);

					if(lastLegVelocity > 0) {
						var timeNeeded = distToGo / lastLegVelocity;
						var timeLeft = goalTime - elapsed;
						//console.log("time needed:" + timeNeeded);
						//console.log("time left:" + timeLeft);
						if(timeNeeded < timeLeft) {
							//yay you're ahead by...
							var timeAhead = formatTime(timeLeft - timeNeeded);
							document.getElementById("pace").textContent = timeAhead + "ahead of pace.";

						}else {
							//sad face you're behind...
							var timeBehind = formatTime(timeNeeded - timeLeft);
							document.getElementById("pace").textContent = timeBehind + "behind pace :(";
						}
					}else {
						document.getElementById("pace").textContent = "Infinitely behind pace. Couch potato.";
					}
				}
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
				var earthRadius = 3963.1676;
				var totalDistance = 0;
				var piOverOneEighty = 3.14159265 / 180;
				for(var i = 1; i < positions.length; i++) {
					var lat1 = positions[i - 1].lat() * piOverOneEighty;
					var lat2 = positions[i].lat() * piOverOneEighty;
					var lng1 = positions[i - 1].lng() * piOverOneEighty;
					var lng2 = positions[i].lng() * piOverOneEighty;
					var x = (lng2 - lng1) * Math.cos((lat1 + lat2)/2);
					var y = (lat2 - lat1);
					totalDistance += Math.sqrt(x*x + y*y)*earthRadius;
					//console.log("Leg#" + i + ": " + Math.sqrt(x*x + y*y)*earthRadius);
				}
				return totalDistance.toFixed(2);
			}

			function calculateDistanceFancy(positions) {
				var totalDistance = 0;
				var earthRadius = 3963.1676;
				for(var i = 1; i < positions.length; i++) {
					var lat1 = positions[i - 1].lat();
					var lat2 = positions[i].lat();
					var lng1 = positions[i - 1].lng();
					var lng2 = positions[i].lng();
					var nextD = Math.acos(Math.sin(lat1)*Math.sin(lat2) + 
                  			Math.cos(lat1)*Math.cos(lat2) *
                  			Math.cos(lng2-lng1)) * earthRadius;
                  	//console.log("FancyLeg#" + i + ": " + nextD);					
					totalDistance += nextD;
				}
				return totalDistance.toFixed(2);
			}
	
		$(function() {
			goalTime = unformatTime(goalTimePretty);
			//console.log(goalTime);
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
			var runPath;
			if(runCoordinates.length > 0) {
				runPath = new google.maps.Polyline({
					path: runCoordinates,
					strokeColor: "#FF0000",
					strokeOpacity: 1.0,
					strokeWeight: 2
				});
			}
			//And add them to the map.
			startMarker.setMap(map);
			finMarker.setMap(map);
			runPath.setMap(map);
			
			////console.log("num coords:" + runCoordinates.length);
			////console.log("Lat" + runCoordinates[0].lat());
			////console.log("Miles:" + calculateDistance(runCoordinates));

			runTimer();
			trackLocation();
		});
		

		
		$(function() {
			$("#end").hide();
			$("#resume").hide();

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
		$goal = $_SESSION['goal'];
		echo "<div id=\"yourTime\">Your Time: </div>";
		//if(isset($goal)) {
			echo "<p>Goal Time: ".$goal."</p>";
		//}
		echo "<div id=\"mileage\">0 miles run.</div>";
		echo "<div id=\"pace\"></div>"
	?>
	<div class="running" id="runningBlock">
	<a href="#" id="pause" data-role="button">Pause</a>
	</div>
	<div class="paused" id="pausedBlock">
	<a href="#" id="resume" data-role="button">Resume</a>
	<a href="endRun.php" id="end" data-role="button">End</a>
	</div>
 </div><!-- /content -->

</div><!-- /page -->

</body>
</html>