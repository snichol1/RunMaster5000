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
		<h1>Add Challenge</h1>
		<a href="#" data-icon="check" id="logout" class="ui-btn-right">Logout</a>

	</div><!-- /header -->

	<div data-role="content">	
		
		<?php
		
		$friendID = $_POST['friendList'];
		$routeID = $_POST['runList'];
		$time = 0; 
		$date = 0; 
		echo $friendID; 
		echo $routeID; 
		
		include("config.php"); 		
		$query = sprintf("select * from Records where Records.RouteID = '%s' and Records.UserID = '%s'", $routeID, "2"); 
		$result = mysql_query($query); 
		while($row = mysql_fetch_array($result)) {
			$time = $row['Time']; 
			$date = $row['Date']; 
		}

		echo $time; 
		echo $date; 
		$insertIntoChallenges = sprintf("INSERT INTO `c_cs147_thesam`.`Challenge` (`FromID`, `ToID`, `RouteID`, `Time`, `Date`, `Met`) VALUES ('%s', '%s', '%s', '%s', '%s', '%s');", "2", $friendID, $routeID, $time, $date, "0"); 
		echo $insertIntoChallenges; 
		mysql_query($insertIntoChallenges); 
		?>
		
		<script> 
			document.location.href = "home.php";
		</script> 
		

	</div><!-- /content -->

		
	<script type="text/javascript">
		$("#logout").click(function() {
			localStorage.removeItem('username');
			$("#form").show();
			$("#logout").hide();
		});
	</script>
</div><!-- /page -->

</body>
</html>