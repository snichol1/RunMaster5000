<!DOCTYPE html> 
<html>

<head>
	<title>Goal Added</title> 
	<meta charset="utf-8">
	<meta name="apple-mobile-web-app-capable" content="yes">
 	<meta name="apple-mobile-web-app-status-bar-style" content="black">
	<meta name="viewport" content="width=device-width, initial-scale=1"> 

	<link rel="stylesheet" href="jquery.mobile-1.2.0.css" />
	<link rel="stylesheet" href="style.css" />
		
	<script src="jquery-1.8.2.min.js"></script>
	<script src="jquery.mobile-1.2.0.js"></script>

</head> 
<body> 

<div data-role="page">

	<div data-role="header">
		<h1>New Goal</h1>

	</div><!-- /header -->

	<div data-role="content">	
		
		<?php
		
		$friendID = $_POST['friendList'];
		$routeID = $_POST['runList'];
		$time = 0; 
		$date = 0; 
		
		include("config.php"); 		
		$query = sprintf("select * from Records where Records.RouteID = '%s' and Records.UserID = '%s'", $routeID, "2"); 
		$result = mysql_query($query); 
		while($row = mysql_fetch_array($result)) {
			$time = $row['Time']; 
			$date = $row['Date']; 
		}

		$insertIntoChallenges = sprintf("INSERT INTO `c_cs147_thesam`.`Challenge` (`FromID`, `ToID`, `RouteID`, `Time`, `Date`, `Met`) VALUES ('%s', '%s', '%s', '%s', '%s', '%s');", "2", $friendID, $routeID, $time, $date, "0"); 
		mysql_query($insertIntoChallenges); 
		?>
		
		<h1>Goal added!</h1>
		<a href="goals.php" data-role="button" data-icon="" data-iconpos="right">Goals</a>
		<a href="home.php" data-role="button" data-icon="home" data-iconpos="right">Home</a>
				

	</div><!-- /content -->

		
	
	</script>
</div><!-- /page -->

</body>
</html>