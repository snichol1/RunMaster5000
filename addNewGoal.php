<?php
session_start();
?>


<!DOCTYPE html> 
<html>

<head>
	<title></title> 
	<meta charset="utf-8">
	<meta name="apple-mobile-web-app-capable" content="yes">
 	<meta name="apple-mobile-web-app-status-bar-style" content="black">
	<meta name="viewport" content="width=device-width, initial-scale=1"> 

	<link rel="stylesheet" href="jquery.mobile-1.2.0.css" />
	<link rel="stylesheet" href="style.css" />
	<link rel="apple-touch-icon" href="appicon.png" />
	<link rel="apple-touch-startup-image" href="startup.png">
	
	<script src="jquery-1.8.2.min.js"></script>
	<script src="jquery.mobile-1.2.0.js"></script>

</head> 
<body> 

<div data-role="page">

	<div data-role="header">
		<h1>Add To Goals</h1>
		<a href="#" data-icon="check" id="logout" class="ui-btn-right">Logout</a>
        <a href="home.php" data-icon="back" data-rel="back" data-add-back-btn="true">Back</a>
	</div><!-- /header -->

	<div data-role="content">	
		
		<?php
		$routeID = $_GET['routeID'];
		$userID = $_SESSION['userID'];
		$time =  $_GET['hours'] . ":" . $_GET['minutes'] . ":" . $_GET['seconds']; 
		$date = "2011-10-28"; 
		$met = 0; 		echo $routeID; 
		
	
		include("config.php"); 
		$addToGoals = sprintf("INSERT INTO `c_cs147_thesam`.`Goals` (`RouteID`, `UserID`, `AntagonistID`, `Time`, `DateSet`, `Met`) VALUES ('%s', '%s', '%s', '%s', '%s', '%s');", $routeID, $userID, $userID, $time, $date, $met);
		mysql_query($addToGoals); 
		echo $addToGoals; 
		
		
		?>
Goal added! 


	</div><!-- /content -->
<script> 
window.location.href = "route.php?routeID=" + <?php echo $_GET['routeID'] ?>; 
</script> 
	</div><!-- /page -->

</body>
</html>