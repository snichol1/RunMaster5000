<?php
session_start();
?>


<!DOCTYPE html> 
<html>

<head>
	<title>Challenge Added</title> 
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

		<h1>Challenge sent</h1>
		<a href="#" data-icon="check" id="logout" class="ui-btn-right">Logout</a>
		<a href="home.php" data-icon="check" id="back" class="ui-btn-right">Home</a>

	</div><!-- /header -->

	<div data-role="content">	
		
		<?php
		$userID = $_SESSION['userID']; 
		$friendID = $_POST['friendList'];
		$routeID = $_POST['runList'];
		$time = 0; 
		$date = 0; 
		
		include("config.php"); 		
		$query = sprintf("select * from Records where Records.RouteID = '%s' and Records.UserID = '%s'", $routeID, $userID); 
		$result = mysql_query($query); 
		while($row = mysql_fetch_array($result)) {
			$time = $row['Time']; 
			$date = $row['Date']; 
		}

		$insertIntoChallenges = sprintf("INSERT INTO `c_cs147_thesam`.`Challenge` (`FromID`, `ToID`, `RouteID`, `Time`, `Date`, `Met`) VALUES ('%s', '%s', '%s', '%s', '%s', '%s');", $userID, $friendID, $routeID, $time, $date, "0"); 
		mysql_query($insertIntoChallenges); 
		?>
		

		<h1>Challenge Sent! </h1>
				
<script> 
window.location.href = "goals.php"; 
</script> 
	</div><!-- /content -->

		
	
	</script>
</div><!-- /page -->

</body>
</html>