<?php
session_start();
?>

<!DOCTYPE html> 
<html>

<head>
	<title>VoteCaster | Submit</title> 
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
		<h1>My Title</h1>
		<a href="#" data-icon="check" id="logout" class="ui-btn-right">Logout</a>
                <a href="home.php" data-icon="back" data-rel="back" data-add-back-btn="true">Back</a>
	</div><!-- /header -->

	<div data-role="content">	
		
		<?php
		$userID = $_SESSION['userID']; 
		$routeID = $_GET['routeID'];
		$action = $_GET['action'];  

		include("config.php"); 
		if ($action == "remove") {
			$sql = sprintf("DELETE FROM `c_cs147_thesam`.`Favorites` WHERE `Favorites`.`UserID` = '%s' AND `Favorites`.`RouteID` = '%s' LIMIT 1", $userID, $routeID);  
			mysql_query($sql);
		}
		if ($action == "add") {
			$sql = sprintf("INSERT INTO `c_cs147_thesam`.`Favorites` (`UserID`, `RouteID`) VALUES ('%s', '%s');", $userID, $routeID); 
			mysql_query($sql); 
		}
		?>
		
		<script> 
		window.location.href = "favorites.php?userID=" + <?php echo $userID ?>; 
		</script> 

	</div><!-- /content -->

		

</div><!-- /page -->

</body>
</html>