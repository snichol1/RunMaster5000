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
<?php
	include("config.php");

	echo "tits";

	$routeID = $_GET['routeID'];
		$userID = $_GET['userID'];

		$lats = $_POST['lats'];
		$lngs = $_POST['lngs'];
		for($i = 0; $i < count($lats); $i++) {
			echo "<br>Lat:" . $lats[$i] . " Lng:" . $lngs[$i];
		}

		$totalDistance = $_POST['totalDistance'];
		echo "<br>Total distance: " . $totalDistance . " mi";

		$timePretty = $_POST['timePretty'];
		echo "<br>Time: " . $timePretty;
		echo "<br>" . $_POST['routeName'];
		echo "<br>Diff" . $_POST['difficulty'];
?>
</body>
</html>