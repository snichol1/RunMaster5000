<!DOCTYPE html>
<html>
<head>
	<title>Search Results</title> 
	<meta name="viewport" content="width=device-width, initial-scale=1"> 
	<link rel="stylesheet" href="http://code.jquery.com/mobile/1.2.0/	jquery.mobile-1.2.0.min.css" />
	
	<script src="http://code.jquery.com/jquery-1.8.2.min.js"></script>
	<script src="http://code.jquery.com/mobile/1.2.0/jquery.mobile-1.2.0.min.js"></script>
		
</head>

<body>

<!-- /header -->
<div data-role="header">
	<h1>Stanford Runs</h1>
                <a href="home.php" data-icon="back" data-rel="back" data-add-back-btn="true">Back</a>
</div>
	
<!--- Where all the main content goes! -->
<div data-role="content">
	
<?php
	include("config.php");

	
	$query = "SELECT * FROM Routes ORDER By Name";
	
	$result = mysql_query($query);
	
	while($row = mysql_fetch_assoc($result)){
			echo "<div class='routeresult'><span class='nameresult'><a href=\"route.php?routeID=".$row["RouteID"]."&userID=" . $_GET['id'] . "\" id=\"routePage\">".$row["Name"]."</a></span>";
			echo "<span class='distanceresult'> Dist: ".$row["Distance"]."</span>";
			echo "<span class='difficultyresult'> Diff: ".$row["Difficulty"]."</span></div>";
	}
	
?>

</div>

</body>
</html>
