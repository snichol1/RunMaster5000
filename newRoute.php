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
	    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCv5woZWJa4qFr4nO4Dp9dCl3LrPQBMToE&sensor=false"></script>

    <script src="js/runutilities.js"></script>
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
			//total length of the run in miles
			//var runDistance = calculateDistance(runCoordinates);

			//Variables for our map and current location
			var map;
			var currMarker;
			var lt;
			var ticker = 0;
			var locations = new Array();
			var currLatLng;

			$(function() {
				//Get the user's current location
				//var currLatLng;
				navigator.geolocation.getCurrentPosition(handle_location, handle_error);

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
					var currMarker = new google.maps.Marker({
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
				
				//Get the timer and location tracker running
				runTimer();
				//trackLocationNR();
				$(document).bind('pageshow', function() {
					google.maps.event.trigger(map, 'resize');
					map.setCenter(currLatLng);
				});
			});



			$(function() {
				//$("#end").hide();
				$("#resume").hide();

				$("#pause").click(function() {
					$(this).hide();
					$("#resume").show();
					pauseTimer();
					console.log("paused");
				});
				$("#resume").click(function() {
					$("#pause").show();
					$("#resume").hide();
					resumeTimer();
					console.log("resmued");
				});
			});
		</script>

	<?php
		echo "<div id=\"yourTime\">Your Time: </div>";
		echo "<div id=\"mileage\">0 miles run.</div>";
	?>

	<a href="#" id="pause" class="" data-role="button">Pause</a>
	<a href="#" id="resume" class="" data-role="button">Resume</a>
	</div> <!-- /content -->
</div> <!-- /page -->
</body>
</html>