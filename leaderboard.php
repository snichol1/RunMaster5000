<!DOCTYPE html>
<html>
<head>
	<title>Search</title> 
  		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="themes/blue.css" />
		<link rel="stylesheet" href="http://code.jquery.com/mobile/1.2.0/jquery.mobile.structure-1.2.0.min.css" /> 
		<script src="http://code.jquery.com/jquery-1.7.2.min.js"></script> 
		<script src="http://code.jquery.com/mobile/1.2.0/jquery.mobile-1.2.0.min.js"></script>    
    
	
	<link rel="stylesheet" type="text/css" href="style.css">
	
</head>


<body>

<div data-role="page" class="leaderboardpage">
	<div data-role="header">
		<h1>Leaderboard</h1>
		<a href=<?php echo "home.php?userID=" . $_GET['userID'];?> data-icon="home" id="back" class="ui-btn-left">Home</a>
	</div>
		
	<div data-role="content">	
		
		<div id="leaderboard">
			<style>
			.lheader{
			font-size: 10px;
			margin-top: 5px;
			}
			
			.ui-grid-b{
			margin-top: -0px;
			}
			
			.headtitle{
			font-size: 25px;
			font-family: "Arial";
			margin-bottom: 0px;
			margin-left: auto;
			margin-right: auto;
			}
			
			.headtitlebottom{
			font-size: 25px;
			font-family: "Arial";
			margin-bottom: 10px;
			margin-top: 5px;
			margin-left: auto;
			margin-right: auto;	
			}
			
			.routeresult{
			font-size: 18px;
			}
			
			</style>
			<?php
			include("config.php");
			
			$userid = 1;
			$routeid = $_GET['routeID'];
			
			$query = "select UserID, min(Time), Date from Records where RouteID=".$routeid." GROUP BY UserID ORDER BY Time";
			
			$result = mysql_query($query);
				
			$count = 1;
			
			$userID = $_GET['userID']; //$_SESSION['userID'];
			$output = "It looks like no one has run this route. The leaderboard is empty.";
			
			
			
			

			while($row = mysql_fetch_assoc($result)){
							//echo "<div class='routeresult'><span class='userID'> ".$row["UserID"]."</span>";
				$userquery = "SELECT * from Users where UserID=".$row["UserID"];
				$result2 = mysql_query($userquery);
				while($row2 = mysql_fetch_assoc($result2)){
					if($output === "It looks like no one has run this route. The leaderboard is empty."){
						$output = "<div class='headtitlebottom'>All<div>";
						$output = $output." <div class=\"ui-grid-b\">";
					$output = $output." <div class='ui-block-a lheader'><b>RANK/NAME</b></div> <div class='ui-block-b lheader'><b>TIME</b></div> <div class='ui-block-c lheader'><b>DATE SET</b></div>";
					}
					$userName = $row2["Name"];
					$output = $output." <div class='routeresult username ui-block-a'><b>".$count.". </b> ".$userName."</div> ";
					if($userID == $row["UserID"]){
						if($count == 2)
							echo "<div class='yourResult firstplace'>";
						else
							echo "<div class='yourResult'>";
						echo "<div class='headtitle'>You</div>";
						echo "<div class=\"ui-grid-b\">";
						echo "<div class='ui-block-a lheader'><b>RANK/NAME</b></div> <div class='ui-block-b lheader'><b>TIME</b></div> <div class='ui-block-c lheader'><b>DATE SET</b></div>";
						
						echo " <div class='routeresult username ui-block-a'><b>".$count.". </b>".$userName."</div> ";	
						echo " <div class='routeresult distanceresult ui-block-b'> <b></b> ".$row["min(Time)"]."</div> ";
						echo " <div class='routeresult difficultyresult ui-block-c'> <b></b> ".$row["Date"]."</div> <br>";
						echo "</div><br>";
					}	
				}
				$output = $output." <div class='routeresult distanceresult ui-block-b'> <b></b> ".$row["min(Time)"]."</div> ";
				$output = $output." <div class='routeresult difficultyresult ui-block-c'> <b></b> ".$row["Date"]."</div>";
	
				$count++;
			}
			echo $output;
			echo "</div>";
		?>
		</div>
		
	
	</div>
</div>
</body>
</html>