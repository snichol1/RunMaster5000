<?php
session_start();

	include("config.php");

	$routeID = $_GET['routeID'];
		$userID = $_GET['userID'];
		$lats = $_SESSION['lats'];
		$lngs = $_SESSION['lngs'];
		$name = $_POST['routeName'];
		$difficulty = $_POST['difficulty'];
		$distance = $_POST['distance'];

		//LET'S GROCK
		$query = "SELECT * FROM Routes WHERE Name = '" .$name. "'";
		$result = mysql_query($query);
		$count = mysql_num_rows($result);
		if($count > 0 || $distance == 0) {
			header('Location: endNewRoute.php');
		}else {

		}
?>
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
		for($i = 0; $i < count($lats); $i++) {
			echo "<br>Lat:" . $lats[$i] . " Lng:" . $lngs[$i];
		}

		echo "<br>" . $_POST['routeName'];
		echo "<br>Diff" . $_POST['difficulty'];
?>
</body>
</html>