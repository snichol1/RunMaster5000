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
		if($count > 0) {
			header("Location: endNewRoute.php?userID=".$userID."&bad=1");
		}elseif($distance == 0) {
			echo "time: " . $_SESSION['newTime'];
			header("Location: endNewRoute.php?userID=".$userID."&bad=2");
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

		echo "<br>" . $name;
		echo "<br>Diff" . $difficulty;
		echo "<br>Dist" . $distance;
		//first, create the new route entry
		$insert = "INSERT INTO `c_cs147_thesam`.`Routes`(`Name`, `Distance`, `Difficulty`) VALUES('".$name."', ".$distance.", ".$difficulty.")";
		//mysql_query($insert);
		echo "<br>" . $insert;
		//get the routeID for that / check that the insert worked
		$query = "SELECT RouteID FROM Routes WHERE Name = '".$name."'";
		$result = mysql_query($query);
		$count = mysql_num_rows($result);
		$routeID = 0;
		if($count > 0) {
			$row = mysql_fetch_array($result);
			$routeID = $row['RouteID'];
			echo "<br>ID:" . $routeID;
		}

		//now stuff errythang else in BreadCrumbs...
		if($routeID != 0) {
			for($i = 0; $i < count($lats); $i++) {
				$isStart = 0;
				$isFinish = 0;
				if($i == 0) $isStart = 1;
				if($i == (count($lats) - 1)) $isFinish = 1;
				$insert = "INSERT INTO BreadCrumbs(RouteID, lat, lng, isStart, isFinish) VALUES(".$routeID.", ".$lats[$i].", ".$lngs[$i].", ".$isStart.", ".$isFinish.")";
				echo "<br>" . $insert;
				//mysql_query($insert);
			}
			//finally, send 'em home

		}
?>

<script type="text/javascript">
	window.location.href="home.php?userID=<?=$userID?>&routeCreated=1";
</script>
</body>
</html>