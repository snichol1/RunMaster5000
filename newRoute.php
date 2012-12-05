<?php session_start(); ?>
<!DOCTYPE html> 
<html> 
<head> 
	<title>Run! Run! Run!</title> 
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="themes/blue.css" />
	<link rel="stylesheet" href="http://code.jquery.com/mobile/1.2.0/jquery.mobile.structure-1.2.0.min.css" /> 
	<script src="http://code.jquery.com/jquery-1.7.2.min.js"></script> 
	<script src="http://code.jquery.com/mobile/1.2.0/jquery.mobile-1.2.0.min.js"></script>    

</head> 
<body> 

	<div data-role="page"> <!-- page -->

		<div data-role="header">
			<h1>
				New Route
			</h1>
			<a href="home.php?userID=<?=$_GET['userID']?>" data-icon="back" data-rel="back">Home</a>

		</div><!-- /header -->

		<div data-role="content">	
			<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCv5woZWJa4qFr4nO4Dp9dCl3LrPQBMToE&sensor=false"></script>

			<?php
			include("config.php");
			$userID = $_GET['userID'];
			?>

			<div id="mapcanvas3" style="height:288px;width:300px"></div>

			<script type="text/javascript">
			var map;
			var currMarker;
			var lt;
			var ticker = 0;
			var locations = new Array();
			var currLatLng;

			var DELAY = 1000;
			var finLatLng;
			var startTime = new Date().getTime();
			var elapsed = 0;
			var is_on = 1;
			var t;
			var goalTime = 0;
			var goalTimePretty;
			var runComplete = 0;
			var currLatLng;

			function formatTime(time) {
				var hr = Math.floor(time/3600000);
				var min = Math.floor(time/60000) - (hr * 60);
				var sec = Math.floor(time / 1000) - (min * 60) - (hr * 3600);
				min = ("0" + min).slice(-2);
				sec = ("0" + sec).slice(-2);
				return (hr + ":" + min + ":" + sec);
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

			function runTimer() {
				var currTime = new Date().getTime();
				elapsed += currTime - startTime;
				startTime = currTime;
				var elapsedPretty = formatTime(elapsed);
				document.getElementById('yourTime').textContent="Your Time: " + elapsedPretty;
				t=setTimeout("runTimer()",50);
			};



			function pauseTimer() {
				clearTimeout(t);
				is_on = 0;
				sessionStorage.timePretty = formatTime(elapsed);
				//sessionStorage.goalTimePretty = goalTimePretty;
				sessionStorage.time = elapsed;
				sessionStorage.goalTime = goalTime;
				console.log("paused");
			}

			function resumeTimer() {
				if(!is_on) {
					is_on = 1;
					startTime = new Date().getTime();
					runTimer();
					console.log("resumed");				
				}
			}

			//our new route variant
			function trackLocationNR() {
				navigator.geolocation.getCurrentPosition(handleLocationUpdateNR, handle_error)
				lt=setTimeout("trackLocationNR()", DELAY);
			}

			function handleLocationUpdateNR(position) {
				if(is_on == 1) {
					currLatLng = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
					currMarker.setPosition(currLatLng);
					//console.log("Lat:" + currLatLng.lat());
					//console.log("Lng:" + currLatLng.lng());
					//console.log(ticker);

					locations[ticker] = currLatLng;
					ticker++;

					//Calculate their milage and update the page accordingly
					var currDistance = calculateDistance(locations);
					document.getElementById("mileage").textContent = currDistance + " miles run.";

					var lastTwoLocations = new Array(2);
					lastTwoLocations[0] = locations[locations.length - 2];
					lastTwoLocations[1] = locations[locations.length - 1];
					lastLegDistance = calculateDistance(lastTwoLocations);

					//if the distance run over the last 10 seconds is greater than...something,
					//draw the bit that they've run on the map.
					//console.log(lastLegDistance + "mi run in the last 10 seconds");
					if(lastLegDistance > 0.01) {
						var nextLeg = new google.maps.Polyline({
							path: lastTwoLocations,
							strokeColor: "00F224",
							strokeOpacity: 1.0,
							strokeWeight: 2
						});
						nextLeg.setMap(map);
					}
				}
			}

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

		function handle_location(position) {
			currLatLng = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);

			var mapOptions = {
				center: currLatLng,
				zoom: 15,
				mapTypeId: google.maps.MapTypeId.ROADMAP
			};
			//Create Markers and Path for the start end ending points.
			map = new google.maps.Map(document.getElementById("mapcanvas3"), mapOptions);

			var pinColor = "251BE0";
			var pinImage = new google.maps.MarkerImage("http://chart.apis.google.com/chart?chst=d_map_pin_letter&chld=%E2%80%A2|" + pinColor);
			currMarker = new google.maps.Marker({
				position: currLatLng,
				animation: google.maps.Animation.BOUNCE,
				title: "Current Location",
				icon: pinImage
			});
			currMarker.setMap(map);
		}
		function handle_error(error) {
			if(!(sessionStorage.locationOff == 1)) {
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
				sessionStorage.locationOff = 1;
			}  
		}

		$(function() {
				//Get the user's current location
				//var currLatLng;
				navigator.geolocation.getCurrentPosition(handle_location, handle_error);


				
				//Get the timer and location tracker running
				//trackLocationNR();
				$(document).bind('pageshow', function() {
					google.maps.event.trigger(map, 'resize');
					map.setCenter(currLatLng);
				});

				runTimer();
				trackLocationNR();
			});



		$(function() {
				//$("#end").hide();
				$("#resume").hide();

				$("#pause").click(function() {
					$(this).hide();
					$("#resume").show();
					pauseTimer();
				});
				$("#resume").click(function() {
					$("#pause").show();
					$("#resume").hide();
					resumeTimer();
				});
				$("#end").click(function() {
					var lats = new Array();
					var lngs = new Array();
					for(var i = 0; i < locations.length; i++) {
						lats[i] = locations[i].lat();
						lngs[i] = locations[i].lng();
					}

					var method = "post";
					var path = "endNewRoute.php?routeID=<?=$routeID?>&userID=<?=$userID?>";
					var form = document.createElement("form");
					form.setAttribute("method", method);
					form.setAttribute("action", path);

					var totalDistance = calculateDistance(locations);
					var hiddenDist = document.createElement("input");
					hiddenDist.setAttribute("type", "hidden");
					hiddenDist.setAttribute("name", "totalDistance");
					hiddenDist.setAttribute("value", totalDistance);
					form.appendChild(hiddenDist);

					var hiddenTime = document.createElement("input");
					hiddenTime.setAttribute("type", "hidden");
					hiddenTime.setAttribute("name", "timePretty");
					hiddenTime.setAttribute("value", formatTime(elapsed));
					form.appendChild(hiddenTime);


					for(var i = 0; i < locations.length; i++) {
						var hiddenField = document.createElement("input");
						hiddenField.setAttribute("type", "hidden");
						hiddenField.setAttribute("name", "lats[]");
						hiddenField.setAttribute("value", lats[i]);
						
						var hiddenField2 = document.createElement("input");
						hiddenField2.setAttribute("type", "hidden");
						hiddenField2.setAttribute("name", "lngs[]");
						hiddenField2.setAttribute("value", lngs[i]);

						form.appendChild(hiddenField);
						form.appendChild(hiddenField2);
					}

    				//pack it, ship it
    				document.body.appendChild(form);
    				form.submit();
    			});
});
</script>

<?php
echo "<div id=\"yourTime\">Your Time: </div>";
echo "<div id=\"mileage\">0 miles run.</div>";
?>
<style type="text/css">
.ui-grid-b .ui-block-a{ width: 65% }
.ui-grid-b .ui-block-b{ width: 35%; } 
</style>
<div class="ui-grid-b">
	<div class="ui-block-a">
		<a href="#" id="pause" class="" data-role="button">Pause</a>
		<a href="#" id="resume" class="" data-role="button">Resume</a>
	</div>
	<div class="ui-block-b">
		<a href="#" id="end" class="" data-role="button">End</a>
	</div>
</div>
</div> <!-- /content -->
</div> <!-- /page -->
</body>
</html>