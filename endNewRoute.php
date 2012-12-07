<?php
session_start();
?>
<!DOCTYPE html> 
<html> 
<head> 
	<title>New Route Complete!</title> 
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
		$totalDistance = $_POST['totalDistance'];
		$timePretty = $_POST['timePretty'];
		$_SESSION['lats'] = $lats;
		$_SESSION['lngs'] = $lngs;
		$_SESSION['newDistance'] = $totalDistance;
		$_SESSION['newTime'] = $timePretty;

		if($_GET['bad'] == 1) echo "<div style=\"color: red;\"> That name's already taken. </div>"; 
		if($_GET['bad'] == 2) echo "<div style=\"color: red;\"> Your run's too short, sorry :\ </div>"; 

		for($i = 0; $i < count($lats); $i++) {
			//echo "<br>Lat:" . $lats[$i] . " Lng:" . $lngs[$i];
		}

		//echo "<br>Total distance: " . $totalDistance . " mi";

		//echo "<br>Time: " . $timePretty;
	?>
	<h3>Time: <?=$_SESSION['newTime']?></h3>
	<h3>Distance: <?=$_SESSION['newDistance']?>mi.</h3>

	<br>
	<form method="post" action="addNewRoute.php?userID=<?=$userID?>">
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
		//echo "<br>" . $date;
		//$insert = "INSERT INTO RECORDS VALUES(".$routeID.", ".$userID.", \"".$timePretty."\", \"".$date."\")";

	?>
	<br>
	<br>
	<a href="home.php?routeID=<?=$routeID?>&userID=<?=$userID?>" data-role="button" data-icon="home" data-iconpos="right">Discard route</a>
	

</div>
<body>
</html>