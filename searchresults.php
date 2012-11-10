<?php
session_start();
?>

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
<div data-role="page">

<!-- /header -->
<div data-role="header">
	<h1>Results</h1>
	
	<a href="search.php" data-icon="back" data-rel="back" data-add-back-btn="true">Search</a>
</div>

<!--- Where all the main content goes! --->
<div data-role="content">
	
<?php
	include("config.php");

	$minDist = 0;
	$maxDist = 100;
	$minDiff = 0;
	$maxDiff = 100;
	
	$short = $_GET['shortdist'];
	$med = $_GET['mediumdist'];
	$long = $_GET['longdist'];
	
	$query = "";
	$feedback = "";
	
	
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
	}
			
		
	$easy = $_GET['easydiff'];
	$med2 = $_GET['mediumdiff'];
	$hard = $_GET['harddiff'];
	
	if(!(empty($med2) && empty($easy) && empty($hard))){
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
	}
	
	$query = "SELECT * FROM Routes WHERE Distance > ".$minDist." and Distance < ".$maxDist." and Difficulty > ".$minDiff." and Difficulty < ".$maxDiff;


if((empty($med) && !empty($short) && !empty($long)) && (empty($med2) && !empty($easy) && !empty($hard))){
			$query = "SELECT * FROM Routes WHERE (Distance < 2 or Distance > 5) and Difficulty != 2";
			$feedback = "Results for easy and hard routes that are <2 or >5 miles";
		}
		else if(empty($med) && !empty($short) && !empty($long)){
			$query = "SELECT * FROM Routes WHERE (Distance < 2 or Distance > 5) and Difficulty > ".$minDiff." and Difficulty < ".$maxDiff;
			$feedback .= " that are less than 2 miles or great than 5 miles";
		} 
		else if((empty($med2) && !empty($easy) && !empty($hard))){
			$query = "SELECT * FROM Routes WHERE Distance > ".$minDist." and Distance < ".$maxDist." and Difficulty != 2";
		}

	
	$result = mysql_query($query);
	
	$routeName = $_GET['name'];
	
	if($routeName === "optional"){
		$routeName = "";	
	}
	
	$oneResult = false;
	
	echo "<ul data-role=\"listview\" data-filter=\"true\" data-theme=\"b\">";

	while($row = mysql_fetch_assoc($result)){
		$oneResult = true;
		if($routeName === "" || (stristr($row["Name"], $_GET['name']) !== FALSE)){
			$diffLabel = "Easy";
			if($row["Difficulty"] === "2")
				$diffLabel = "Medium";
			else if($row["Difficulty"] === "3")
				$diffLabel = "Hard";
			
			echo "<li data-corners=\"false\" data-icon=\"arrow-r\" data-iconpos=\"right\" data-theme=\"c\">";
			echo "<a href=\"route.php?routeID=".$row["RouteID"]."&userID=".$_GET["userID"]."\">";
			echo "<p class=\"ui-li-aside ui-li-desc\"><strong>".$row["Distance"]."</strong> mi<br>".$diffLabel."</p>";
			echo "<h3>".$row["Name"]."</h3>";
			echo "</a>";		
			echo "</li>";
			
			/*echo "<div class='routeresult'><span class='nameresult'><a href=\"route.php?routeID=".$row["RouteID"]."&userID=".$_GET["userID"]."\">".$row["Name"]."</a></span>";
			echo "<span class='distanceresult'> Dist: ".$row["Distance"]."</span>";
			echo "<span class='difficultyresult'> Diff: ".$row["Difficulty"]."</span></div>"; */
		}
	}
	echo "</ul>";

	
	if(!$oneResult){
		echo "<div>Sorry there are no matching results.</div>";
	}
	
?>

</div>
</div>

</body>
</html>
