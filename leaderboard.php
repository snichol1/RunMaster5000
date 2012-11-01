<!DOCTYPE html>
<html>
<head>
	<title>Search</title> 
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1"> 
	<link rel="stylesheet" href="http://code.jquery.com/mobile/1.2.0/	jquery.mobile-1.2.0.min.css" />
	
	<script src="http://code.jquery.com/jquery-1.8.2.min.js"></script>
	<script src="http://code.jquery.com/mobile/1.2.0/jquery.mobile-1.2.0.min.js"></script>
	<script type="text/javascript" src="js/.js"></script>
	
	<link rel="stylesheet" type="text/css" href="style.css">
	<link rel="stylesheet" type="text/css" href="leaderboard.css">
	
</head>


<body>

<div data-role="header">
	<h1>Leaderboard</h1>
	<a href="home.php" data-icon="back">Home</a>
</div>
	
<div data-role="content">	
	
	<div id="leaderboard">
		
		<?php
		include("config.php");
		
		$userid = 1;
		$routeid = 1;
		
		$query = "select UserID, min(Time), Date from Records where RouteID=".$routeid." group by UserID ordered by Time";
		
		
		$result = mysql_query($query);
	
	$routeName = $_POST['name'];
	
	if($routeName === "optional"){
		$routeName = "";	
	}
	
	while($row = mysql_fetch_assoc($result)){
		echo "<div class='routeresult'><span class='userID'> ".$row["UserID"]."</span>";
		echo "<span class='distanceresult'> Dist: ".$row["min(Time)"]."</span>";
		echo "<span class='difficultyresult'> Diff: ".$row["Date"]."</span></div>";
		
		$query2 = "select * from Users where UserID=".$row["UserID"];
	}
	?>
	</div>
	
	

</div>
</body>
</html>