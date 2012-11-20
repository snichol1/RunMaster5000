<?php
session_start();
?>
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
		<h1>Run Finished</h1>
		<a href="home.php" data-icon="home">Back</a>
	</div><!-- /header -->

	<?php
		$routeID = $_GET['routeID'];
		$userID = $_GET['userID'];
		$goal = $_SESSION['goal'];
		include("config.php");
	?>
	<h2 id="message">Congrats on meeting your goal! Keep up the good work.</h2>
	<div id="time"></div>
	<div id="goal"></div>
	<a href="newChallenge.php?routeID=<?=$routeID?>&userID=<?=$userID?>" data-role="button" data-icon="" data-iconpos="right">Challenge a Friend</a>
	
	<?php
		$query = sprintf("select * from Favorites where RouteID='%s' and UserID = '%s'", $routeID, $_SESSION['userID']);
		$result = mysql_query($query);
		$isFavorite = 0; 
		$return = "endRun";
		while($row = mysql_fetch_array($result))
		  	{
		  	$isFavorite = 1; 
		  	}
		$message = "Add To Favorites"; 
		$action = "addToFavorites.php"; 
		if ($isFavorite == 0) {
			echo "<a href=\"" .$action . "?routeID=" . $routeID . "\"&return=\"".$return."\" data-role=\"button\" data-icon=\"none\"  data-iconpos=\"right\">" . $message . "</a>";
		}
	?>

	<a href="home.php?routeID=<?=$routeID?>&userID=<?=$userID?>" data-role="button" data-icon="home" data-iconpos="right">Home</a>
	
	<script type="text/javascript">
		var goalTimePretty;
		var goalTime;
		var timePretty;
		var time;

		if(sessionStorage.goalTimePretty) goalTimePretty = sessionStorage.goalTimePretty;
		if(sessionStorage.goalTime) goalTime = sessionStorage.goalTime;
		if(sessionStorage.timePretty) timePretty = sessionStorage.timePretty;
		if(sessionStorage.time) time = sessionStorage.time;
		
		if(goalTime < time) {
			document.getElementById("message").textContent = "Good work, you'll reach your goal in no time!";
		}

		if(goalTimePretty != null) document.getElementById("time").textContent = "Your time was: " + timePretty;
		if(timePretty != null) document.getElementById("goal").textContent = "Your goal was: " + goalTimePretty;
	</script>
</div>
<body>
</html>