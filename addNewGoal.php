<?php
session_start();
?>


<!DOCTYPE html> 
<html>

<head>
	<title></title> 
	<meta name="viewport" content="width=device-width, initial-scale=1"> 
	<link rel="stylesheet" href="http://code.jquery.com/mobile/1.2.0/jquery.mobile-1.2.0.min.css" />
	<script src="http://code.jquery.com/jquery-1.8.2.min.js"></script>
	<script src="http://code.jquery.com/mobile/1.2.0/jquery.mobile-1.2.0.min.js"></script>

</head> 
<body> 

<div data-role="page">

	<div data-role="header">
		
	</div><!-- /header -->

	<div data-role="content">	
		
		<?php
		$routeID = $_GET['routeID'];
		$userID = $_GET['userID'];
		$hours = "00";
		if(isset($_POST['hours'])) $hours = $_POST['hours'];
		$minutes = "00";
		if(isset($_POST['minutes'])) $minutes = $_POST['minutes'];
		$secondss = "00";
		if(isset($_POST['seconds'])) $seconds = $_POST['seconds'];
		$goalTime =  $hours . ":" . $minutes . ":" . $seconds; 
		$date = date("Y:m:d", mktime(0,0,0,date("m"),date("d"),date("Y")));
		$met = 0;
		
	
		include("config.php");
		$addToGoals = sprintf("INSERT INTO `c_cs147_thesam`.`Goals` (`RouteID`, `UserID`, `AntagonistID`, `Time`, `DateSet`, `Met`) VALUES ('%s', '%s', '%s', '%s', '%s', '%s');", $routeID, $userID, $userID, $goalTime, $date, $met);
		//echo $addToGoals;
		mysql_query($addToGoals); 
		
		echo "<p>Time: " . $goalTime;
		echo "<p>Route: " . $routeID;
		echo ("
			<script type=\"text/javascript\">
			var goalTime=\"".$goalTime."\";
			var routeID=".$routeID.";
			</script>");
		?>


		<script type="text/javascript"> 
			console.log("GoalTime:" + goalTime);
			sessionStorage.goalTimePretty = goalTime;
			sessionStorage.goalRoute = routeID;

			window.location.href = "route.php?routeID=" + <?php echo $_GET['routeID'] ?> + "&userID=" + <?=$userID?>; 
		</script> 
	</div><!-- /content -->

	</div><!-- /page -->

</body>
</html>