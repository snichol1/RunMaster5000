<?php
session_start();
?>
<!DOCTYPE html> 
<html> 
<head> 
	<title>Run Complete!</title> 
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="themes/blue.css" />
		<link rel="stylesheet" href="http://code.jquery.com/mobile/1.2.0/jquery.mobile.structure-1.2.0.min.css" /> 
		<script src="http://code.jquery.com/jquery-1.7.2.min.js"></script> 
		<script src="http://code.jquery.com/mobile/1.2.0/jquery.mobile-1.2.0.min.js"></script>    
</head>

<body> 

<div data-role="page">

	<div data-role="header">
		<h1>Run Finished</h1>
		<a href=<?php echo "home.php?userID=" . $_SESSION['userID']?> data-icon="home" id="back" class="ui-btn-left">Home</a>
	</div><!-- /header -->

	<?php
		$routeID = $_GET['routeID'];
		$userID = $_GET['userID'];

		$lats = $_POST['lats'];
		$lngs = $_POST['lngs'];
		$_SESSION['lats'] = $lats;
		$_SESSION['lngs'] = $lngs;
		for($i = 0; $i < count($lats); $i++) {
			echo "<br>Lat:" . $lats[$i] . " Lng:" . $lngs[$i];
		}

		$totalDistance = $_POST['totalDistance'];
		echo "<br>Total distance: " . $totalDistance . " mi";

		$timePretty = $_POST['timePretty'];
		echo "<br>Time: " . $timePretty;
	?>
	<div id="time"></div>
	<div id="goal"></div>

	<form method="post" action="addNewRoute.php">
		Name: <input type="text" name="routeName" required="required">
		Difficulty: <select name="difficulty">
		<option value="1">Easy</option>
		<option value="2">Medium</option>
		<option value="3">Hard</option>
		<input type="hidden" name="time" value="<?=$timePretty?>">
		<input type="hidden" name="distance" value="<?=$totalDistance?>">
		<input type="submit" value="Keep route">
	</form>

	
	<?php
		//insert the user's time, if they completed the run, into the DB
		$date = date("Y:m:d", mktime(0,0,0,date("m"),date("d"),date("Y")));
		echo "<br>" . $date;
		//$insert = "INSERT INTO RECORDS VALUES(".$routeID.", ".$userID.", \"".$timePretty."\", \"".$date."\")";

	?>

	<a href="home.php?routeID=<?=$routeID?>&userID=<?=$userID?>" data-role="button" data-icon="home" data-iconpos="right">Discard route</a>
	

</div>
<body>
</html>