<?php session_start(); ?>
<!DOCTYPE html> 
<html> 
<head> 
	<title>Run! Run! Run!</title> 
	<meta name="viewport" content="width=device-width, initial-scale=1"> 
	<link rel="stylesheet" href="http://code.jquery.com/mobile/1.2.0/jquery.mobile-1.2.0.min.css" />
	<script src="http://code.jquery.com/jquery-1.8.2.min.js"></script>
	<script src="http://code.jquery.com/mobile/1.2.0/jquery.mobile-1.2.0.min.js"></script>
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCv5woZWJa4qFr4nO4Dp9dCl3LrPQBMToE&sensor=false"></script>
    <script src="js/runutilities.js"></script>

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
				var goalTimePretty = \"00:00:00\";
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
	
		
				
	<div id="mapcanvas2" style="height:288px;width:300px"></div>
	<script type="text/javascript">
		//total length of the run in miles
		var runDistance = calculateDistance(runCoordinates);

		//Variables for our map and current location
		var map;
		var currMarker;
		var lt;
		var ticker = 0;
		var locations = new Array();

		$(function() {
			goalTime = unformatTime(goalTimePretty);
			//console.log(goalTime);
			initializeCurrLocation();
			//Build LatLng objects
			var startLatLng = new google.maps.LatLng(startLat, startLng);
			finLatLng = new google.maps.LatLng(finLat, finLng);

			//Set our map options.
			var mapOptions = {
				center: startLatLng,
				zoom: 15,
				mapTypeId: google.maps.MapTypeId.ROADMAP
			};
			//Create Markers and Path for the start end ending points.
			map = new google.maps.Map(document.getElementById("mapcanvas2"),
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
			
			//Dislay goal time if one has been set.
			if(sessionStorage.goalTimePretty && sessionStorage.goalRoute == <?=$routeID?>) {
				goalTimePretty = sessionStorage.goalTimePretty;
				goalTime = unformatTime(goalTimePretty);
				console.log("Goal time:" + goalTimePretty);
				console.log("Raw time:" + goalTime);
				document.getElementById("goalDisplay").textContent = "Goal Time: " + goalTimePretty;
			}

			//Get the timer and location tracker running
			runTimer();
			trackLocation();
			google.maps.event.trigger(map, 'resize');
			map.setCenter(startLatLng);
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
			$("#end").click(function() {
				method = "post";
				path = "endRun.php?routeID=<?=$routeID?>&userID=<?=$userID?>&complete=" + runComplete;
				var form = document.createElement("form");
    			form.setAttribute("method", method);
    			form.setAttribute("action", path);

    			//stick the user's time in:
    			var hiddenField = document.createElement("input");
            	hiddenField.setAttribute("type", "hidden");
            	hiddenField.setAttribute("name", "timePretty");
            	hiddenField.setAttribute("value", sessionStorage.timePretty);

            	form.appendChild(hiddenField);

    			//pack it, ship it
    			document.body.appendChild(form);
    			form.submit();
			});
		});
	</script>
	
	<?php
		echo "<div id=\"yourTime\">Your Time: </div>";
		echo "<div id=\"goalDisplay\"></div>";
		echo "<div id=\"mileage\">0 miles run.</div>";
		echo "<div id=\"pace\"></div>"
	?>
	<div class="running" id="runningBlock">
	<a href="#" id="pause" data-role="button">Pause</a>
	</div>
	<div class="paused" id="pausedBlock">
	<a href="#" id="resume" data-role="button">Resume</a>
	<a href="#" id="end" data-role="button">End</a>
	</div>
 </div><!-- /content -->

</div><!-- /page -->

</body>
</html>