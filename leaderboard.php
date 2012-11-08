<!DOCTYPE html>
<html>
<head>
	<title>Search</title> 
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1"> 
	<link rel="stylesheet" href="http://code.jquery.com/mobile/1.2.0/	jquery.mobile-1.2.0.min.css" />
	
	<script src="http://code.jquery.com/jquery-1.8.2.min.js"></script>
	<script src="http://code.jquery.com/mobile/1.2.0/jquery.mobile-1.2.0.min.js"></script>
	
	<link rel="stylesheet" type="text/css" href="style.css">
	
</head>


<body>

<div data-role="page" class="leaderboardpage">
	<div data-role="header">
		<h1>Leaderboard</h1>
		<a href="home.php" data-icon="back" data-rel="back" data-add-back-btn="true">Home</a>
	</div>
		
	<div data-role="content">	
		
		<div id="leaderboard">
			
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
						$output = "All Leaderboard Results:";	
					}
					$userName = $row2["Name"];
					$output = $output." <div class='routeresult'>".$count.". <span class='userName'>".$userName."</span> ";
					if($userID == $row["UserID"]){
						echo "<div class='yourResult'>Your Place in the Leaderboard:";
						echo " <div class='routeresult'>".$count.". <span class='userName'>".$userName."</span> ";	
						echo " <span class='distanceresult'> Time: ".$row["min(Time)"]."</span> ";
						echo " <span class='difficultyresult'> Date Ran: ".$row["Date"]."</span></div> <br>";
					}	
				}
				$output = $output." <span class='distanceresult'> Time: ".$row["min(Time)"]."</span> ";
				$output = $output." <span class='difficultyresult'> Date Ran: ".$row["Date"]."</span></div> ";
	
				$count++;
			}
			echo $output;
		?>
		</div>
		
	
	</div>
</div>
</body>
</html>