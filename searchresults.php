<!DOCTYPE html>
<html>
<head>
	<title>Search Results</title> 
	<meta name="viewport" content="width=device-width, initial-scale=1"> 
	<link rel="stylesheet" href="http://code.jquery.com/mobile/1.2.0/	jquery.mobile-1.2.0.min.css" />
	
	<script src="http://code.jquery.com/jquery-1.8.2.min.js"></script>
	<script src="http://code.jquery.com/mobile/1.2.0/jquery.mobile-1.2.0.min.js"></script>
	<script type="text/javascript" src="js/rangeslider.js"></script>
	
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
	
	
	function IsChecked($chkname,$value) {
        if(!empty($_POST[$chkname])) {
            foreach($_POST[$chkname] as $chkval){
                if($chkval == $value)
                {
                    return true;
                }
            }
        }
        return false;
    }

	
	$minDist = 0;
	$maxDist = 100;
	$minDiff = 0;
	$maxDiff = 100;
	
	$short = $_POST['shortdist'];
	$med = $_POST['mediumdist'];
	$long = $_POST['longdist'];
	
	
	if(!(empty($med) && empty($short) && empty($long))){
		if(empty($med) && empty($short)){
		    echo("no med, short.");
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
		$hard = $_POST['longdiff'];
		
		if(empty($easy) && empty($med2)){
			echo("1!");
		    $minDiff = 2;
		}
		else if(empty($easy)){
			echo("2!");
		    $minDiff = 1;
		}
	
		if(empty($med2) && empty($hard)){
			echo("3!");
		    $maxDiff = 2;
		}
		else if(empty($hard)){
			echo("4!");
		    $maxDiff = 3;
		}
	else{
		//Throw Error
	}
	}

	

	
	if($_POST['shortdist'] == 'Yes'){
   		$minDist = 2;
   		
   		//echo "<p>min: ".$minimumDistance."</p>";

   	}

	echo "<p>minDiff: ".$minDiff."</p>";
	echo "<p>maxDiff: ".$maxDiff."</p>";


	//$minimumDisatnce = $_POST[""]
	
	$query = "SELECT * FROM Routes WHERE Distance > ".$minDist." and Distance < ".$maxDist." and Difficulty > ".$minDiff." and Difficulty < ".$maxDiff;
	
	$result = mysql_query($query);
	
	while($row = mysql_fetch_assoc($result)){
		echo "<div class='routeresult'><span id='name'> ".$row["Name"]."</span>";
		echo "<span id='distance'> ".$row["Distance"]."</span>";
		echo "<span id='difficulty'> ".$row["Difficulty"]."</span></div>";
	}
	
?>

<div>

</body>
</html>
