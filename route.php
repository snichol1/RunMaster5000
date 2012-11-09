<?php
session_start();
?>

<!DOCTYPE html>
<html>
    <head>
		<title>RunMaster 5000</title> 
		<meta name="viewport" content="width=device-width, initial-scale=1"> 
		<link rel="stylesheet" href="http://code.jquery.com/mobile/1.2.0/jquery.mobile-1.2.0.min.css" />
		<script src="http://code.jquery.com/jquery-1.8.2.min.js"></script>
		<script src="http://code.jquery.com/mobile/1.2.0/jquery.mobile-1.2.0.min.js"></script>
	</head>
    <body>
        <!-- Home -->
        <div data-role="page">
			<div data-role="header">
			<h1>
			<?php
				$routeID = $_GET['routeID'];
				$userID = $_GET['userID'];
				$goal = $_SESSION['Time']; 
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

	<?php
		$routeID = $_GET['routeID'];
		$userID = $_GET['userID'];
		$goal = $_SESSION['goal'];
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
				var currMarker = new google.maps.Marker({
					position: currLatLng,
					title: "Current Location"
				});
				currMarker.setMap(map);
				console.log("Lat:" + currLatLng.lat());
				console.log("Lng:" + currLatLng.lng());
			}
			function handle_error(error) {
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

			//Set our map options.
			var mapOptions = {
				center: startLatLng,
				zoom: 15,
				mapTypeId: google.maps.MapTypeId.ROADMAP
			};
			//Create Markers and Path for the start end ending points.
			map = new google.maps.Map(document.getElementById("mapcanvas1"),
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
		  			echo $row['Difficulty']; 
		  			echo " out of 5 </h3>"; 

		  			if(isset($goal)) {
		  				echo "<h3> Goal time: " . $goal . "</h3>";
		  			}
		  		}
				
		  		echo "<a href=\"leaderboard.php?routeID=".$routeID. "&userID=" . $_GET['userID'] ."\" data-role=\"button\" data-icon=\"\" data-iconpos=\"right\">Leaderboard</a>";
		  		
		  		$goalText = "Add Goal";
		  		if(isset($goal)) $goalText = "Change Goal";
				echo "<a href=\"newGoal.php?routeID=". $routeID . "&userID=" . $_GET['userID'] . "\" data-role=\"button\" data-icon=\"plus\" data-iconpos=\"right\">".$goalText."</a>";
				
				
			?>
            
            </h3> 
            <?php
				$routeID = $_GET['routeID'];
				include("config.php");

				$query = sprintf("select * from Favorites where RouteID='%s' and UserID = '%s'", $routeID, $_SESSION['userID']);
				$result = mysql_query($query);
				$isFavorite = 0; 
				while($row = mysql_fetch_array($result))
		  		{
		  			$isFavorite = 1; 
		  		}
		  		$message = "Add To Favorites"; 
		  		$action = "addToFavorites.php"; 
		  		if ($isFavorite == 1) {
		  			$message = "Remove from Favorites"; 
		  			$action = "removeFromFavorites.php"; 
		  		}
				 echo "<a href=\"" .$action . "?routeID=" . $routeID . "\" data-role=\"button\" data-icon=\"none\"  data-iconpos=\"right\">" . $message . "</a>";

				 
				 echo "<a class = \"run\" href=\"run.php?routeID=".$routeID. "&userID=".$_GET['userID']."\" data-role=\"button\" data-icon=\"none\"  data-iconpos=\"right\">Run!</a>";
            ?> 

                                    
			</div> <!-- /content -->

        </div> <!--- /page -->
    </body>
</html>