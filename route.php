<?php
session_start();
?>

<!DOCTYPE html>
<html>
    <head>
		<title>RunMaster 5000</title> 
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
        <!-- Home -->
        <div data-role="page">
        <style>
			@font-face {
				font-family: PTSans;
				src: url('PTSans.ttf');
			}
			
			.text{
				font-family: PTSans;
			}
		</style>
			<div data-role="header">
			<h1 class="text">
			<?php
				$routeID = $_GET['routeID'];
				$userID = $_GET['userID'];
				include("config.php");

				$query = sprintf("select * from Routes where RouteID='%s'", $routeID);
				$result = mysql_query($query);
				while($row = mysql_fetch_array($result))
		  		{
		  			echo $row['Name']; 
		  		}

			?>
			</h1>
		<a href=<?php echo "home.php?userID=" . $_SESSION['userID']?> data-icon="home" id="back" class="ui-btn-left">Home</a>

	</div><!-- /header -->
	
    <div data-role="content">

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
	
		
				
	<div id="mapcanvas1" style="height:288px;width:300px"></div>
	<script type="text/javascript">
		var map;
		$(function() {
			//Build LatLng objects
			var startLatLng = new google.maps.LatLng(startLat, startLng);
			var finLatLng = new google.maps.LatLng(finLat, finLng);

			//Get the user's current location
			var currLatLng;
			navigator.geolocation.getCurrentPosition(handle_location, handle_error);

			function handle_location(position) {
				currLatLng = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
				
				var pinColor = "251BE0";
    			var pinImage = new google.maps.MarkerImage("http://chart.apis.google.com/chart?chst=d_map_pin_letter&chld=%E2%80%A2|" + pinColor);
				var currMarker = new google.maps.Marker({
					position: currLatLng,
					title: "Current Location",
					icon: pinImage
				});
				currMarker.setMap(map);
				console.log("Lat:" + currLatLng.lat());
				console.log("Lng:" + currLatLng.lng());
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

			//Set our map options.
			console.log("sLat:" + startLatLng.lat());
			console.log("sLng:" + startLatLng.lng());
			var mapOptions = {
				center: startLatLng,
				zoom: 15,
				mapTypeId: google.maps.MapTypeId.ROADMAP
			};
			//Create Markers and Path for the start end ending points.
			map = new google.maps.Map(document.getElementById("mapcanvas1"),
				mapOptions);
			pinColor = "00F224";
			pinImage = new google.maps.MarkerImage("http://chart.apis.google.com/chart?chst=d_map_pin_letter&chld=%E2%80%A2|" + pinColor);
			var startMarker = new google.maps.Marker({
				position: startLatLng,
				title: "Start",
				icon: pinImage
			});
			pinColor = "F2003D";
			pinImage = new google.maps.MarkerImage("http://chart.apis.google.com/chart?chst=d_map_pin_letter&chld=%E2%80%A2|" + pinColor);
			var finMarker = new google.maps.Marker({
				position: finLatLng,
				title: "Finish",
				icon: pinImage
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
			$(document).bind('pageshow', function() {
				google.maps.event.trigger(map, 'resize');
							map.setCenter(startLatLng);

			});

			//Display the goal time, if there is one.
			var goalTimePretty;
			var goalRoute = 0;
			if(sessionStorage.goalTimePretty) goalTimePretty = sessionStorage.goalTimePretty;
			if(sessionStorage.goalRoute) goalRoute = sessionStorage.goalRoute;
			console.log("Set Goaltime: " + goalTimePretty);
			console.log("Set route: " + goalRoute);


			if(goalRoute == <?=$routeID?> && goalTimePretty != null) {
				//console.log("Good Goaltime: " + goalTime);
				document.getElementById("addGoal").textContent = "Change Goal";
				document.getElementById("goalDisplay").textContent = "Goal time: " + goalTimePretty;
			}

		});
	</script>

            
            <h3 id = "distance">
            	<?php

				$query = sprintf("select * from Routes where RouteID='%s'", $routeID);
				$result = mysql_query($query);
				while($row = mysql_fetch_array($result))
		  		{
		  			echo "<h3> Distance:  "; 
		  			echo $row['Distance']; 
		  			echo " miles </h3>"; 
		  			
		  			echo "<h3> Difficulty: "; 
		  			$diff = $row['Difficulty']; 
		  			if ($diff == 1) echo "Easy";
		  			if ($diff == 2) echo "Medium"; 
		  			if ($diff == 3) echo "Hard"; 
		  			
		  			echo "<h3 id=\"goalDisplay\"></h3>";
		  			
		  		}
				
		  		echo "<a href=\"leaderboard.php?routeID=".$routeID. "&userID=" . $_GET['userID'] ."\" data-role=\"button\" data-icon=\"\" data-iconpos=\"right\">Leaderboard</a>";
		  		
				echo "<a href=\"newGoal2.php?routeID=". $routeID . "&userID=" . $_GET['userID'] . "\" id=\"addGoal\" data-role=\"button\" data-icon=\"plus\" data-iconpos=\"right\">Add Goal</a>";
				
				
			?>
            
            </h3> 
            <?php
				$routeID = $_GET['routeID'];
				include("config.php");

				$query = sprintf("select * from Favorites where RouteID='%s' and UserID = '%s'", $routeID, $_SESSION['userID']);
				$result = mysql_query($query);
				$isFavorite = 0; 
				$return = "route";
				while($row = mysql_fetch_array($result))
		  		{
		  			$isFavorite = 1; 
		  		}
		  		$message = "Add To Favorites"; 
		  		$action = "addToFavorites.php"; 
		  		$icon = "plus";
		  		if ($isFavorite == 1) {
		  			$message = "Remove from Favorites"; 
		  			$action = "removeFromFavorites.php"; 
		  			$icon = "minus"; 
		  		}
				 echo "<a href=\"" .$action . "?routeID=" . $routeID . "&return=".$return."\" data-role=\"button\" data-icon=". $icon ."  data-iconpos=\"right\">" . $message . "</a>";

				 
				 echo "<a id = \"run\" href=\"run.php?routeID=".$routeID. "&userID=".$_GET['userID']."\" data-role=\"button\" data-icon=\"none\"  data-iconpos=\"right\" rel=\"external\">Run!</a>";
            ?> 

                                    
			</div> <!-- /content -->

        </div> <!--- /page -->
    </body>
</html>