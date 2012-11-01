<!DOCTYPE html>
<html>
<head>
	<title>Search Results</title> 
	<meta name="viewport" content="width=device-width, initial-scale=1"> 
	<link rel="stylesheet" href="http://code.jquery.com/mobile/1.2.0/	jquery.mobile-1.2.0.min.css" />
	
	<script src="http://code.jquery.com/jquery-1.8.2.min.js"></script>
	<script src="http://code.jquery.com/mobile/1.2.0/jquery.mobile-1.2.0.min.js"></script>
	
	<link rel="stylesheet" type="text/css" href="style.css">
	<link rel="stylesheet" type="text/css" href="searchstyle.css">
	
</head>
<body>

<!-- /header -->
<div data-role="header">
	<h1>Results</h1>
	<a href="search.html" data-icon="back">Search</a>
</div>
	
<!--- Where all the main content goes! --->
<div data-role="content">
	
<?php
	include("config.php");

	$minDist = 0;
	$maxDist = 100;
	$minDiff = 0;
	$maxDiff = 100;
	
	$short = $_POST['shortdist'];
	$med = $_POST['mediumdist'];
	$long = $_POST['longdist'];
	
	//Checks to see what elements are selected.
	if(!(empty($med) && empty($short) && empty($long))){
		if(empty($med) && empty($short)){
		    //echo("no med, short.");
		    $minDist = 5;
		}
		else if(empty($short)){
		    //echo("You didn't select short routes.");
		    $minDist = 2;
		}
	
		if(empty($med) && empty($long)){
		    //echo("no med, long.");
		    $maxDist = 2;
		}
		else if(empty($long)){
		    //echo("You didn't select long routes.");
		    $maxDist = 5;
		}
		
		$easy = $_POST['easydiff'];
		$med2 = $_POST['mediumdiff'];
		$hard = $_POST['harddiff'];
		
		if(empty($easy) && empty($med2)){
		    $minDiff = 2;
		}
		else if(empty($easy)){
		    $minDiff = 1;
		}
	
		if(empty($med2) && empty($hard)){
		    $maxDiff = 2;
		}
		else if(empty($hard)){
		    $maxDiff = 3;
		}
		else{
			//Handle situation where none are chosen. Now just defaults to
			//acting the same if everything was chosen.
		}
	}

	
	$query = "SELECT * FROM Routes WHERE Distance > ".$minDist." and Distance < ".$maxDist." and Difficulty > ".$minDiff." and Difficulty < ".$maxDiff;
	
	$result = mysql_query($query);
	
	$routeName = $_POST['name'];
	
	if($routeName === "optional"){
		$routeName = "";	
	}
	
	while($row = mysql_fetch_assoc($result)){
		if($routeName === "" || (stristr($row["Name"], $_POST['name']) !== FALSE)){
			echo "<div class='routeresult'><span class='nameresult'> ".$row["Name"]."</span>";
			echo "<span class='distanceresult'> Dist: ".$row["Distance"]."</span>";
			echo "<span class='difficultyresult'> Diff: ".$row["Difficulty"]."</span></div>";
		}
	}
	
?>

<div>

</body>
</html>
