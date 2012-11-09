<?php
session_start();
?>



<!DOCTYPE html> 
<html> 
<head> 
	<title>Goals</title> 
	<meta name="viewport" content="width=device-width, initial-scale=1"> 
	<link rel="stylesheet" href="http://code.jquery.com/mobile/1.2.0/jquery.mobile-1.2.0.min.css" />
	<link rel="stylesheet" href="friends.css"/>
	<script src="http://code.jquery.com/jquery-1.8.2.min.js"></script>
	<script src="http://code.jquery.com/mobile/1.2.0/jquery.mobile-1.2.0.min.js"></script>
</head> 
<body> 

<div data-role="page">

	<div data-role="header">
		<h1>Goals</h1>
                <a href="home.php" data-icon="back" data-rel="back" data-add-back-btn="true">Back</a>

	</div><!-- /header -->

	<div data-role="content">	
	<script> 
	
	 $(function() {
        $( "input[type=submit], a, button" )
            .button()
            .click(function( event ) {
                event.preventDefault();
            });
    });
    </script>
<h3> New Goals </h3> 
				
			<table> 
				<?php
				include("config.php");
				$query = sprintf("select * from Challenge where Challenge.ToID = '%s'", $_SESSION['userID']); 
				$result = mysql_query($query);
				$isNewGoal = false;
				while($row = mysql_fetch_array($result))
		  		{
		  			$isNewGoal = true;
			  		$query = sprintf("select * from Users where UserID = '%s' LIMIT 0, 30 ", $row['FromID']); 
					$userArray = mysql_query($query); 
					$nameRow = mysql_fetch_array($userArray);  
					
					$query = sprintf("select * from Routes where RouteID = '%s' LIMIT 0, 30 ", $row['RouteID']); 
					$routeArray = mysql_query($query); 
					$routeRow = mysql_fetch_array($routeArray);  
					
					echo "<div class=\"newgoals\">";
					echo "<span class=\"challenger\">".$nameRow['Name'] . " challenged you to " . $routeRow['Name']. "!</span>";
					echo "<span class=\"acceptbutton\"><a data-mini=\"true\" data-inline=\"true\" href = \"addToGoals.php?routeID=".$row['RouteID']."&UserID=".$row['ToID']."&AntagonistID=".$row['FromID']."&Time=".$row['Time']."&DateSet=". $row['Date']."\"> Accept the challenge!</a></span>";
					echo "<span class=\"dismissbutton\"><a data-mini=\"true\" data-inline=\"true\" href = \"dismissChallenge.php?routeID=".$row['RouteID']."&AntagonistID=".$row['FromID']."&Time=".$row['Time']."\"> Dismiss :( </a></span>";
					echo "</div>";
					
			  		/*echo "<tr>"; 
			  		echo "<td>"; 
			  		echo $nameRow['Name']; 
			  		echo "  challenged you to " . $routeRow['Name']; 
					echo "!<br></td>"; 
			  		echo "<td>"; 
			  		$name = $row['Name']; 
			  		
			  		echo "<a href = \"addToGoals.php?routeID="; 
				  	echo $row['RouteID'];
				  	echo "&UserID=";
				  	echo $row['ToID'];
				  	echo "&AntagonistID=";
				  	echo $row['FromID'];
				  	echo "&Time=";
				  	echo $row['Time'];
				  	echo "&DateSet=";
				  	echo $row['Date'];
			  		echo "\"> Accept the challenge!"; 
			  		echo "</a>"; 
			
			  		echo "</td>"; 
			  		echo "<td>"; 
			  		echo "<a href = \"dismissChallenge.php?routeID="; 
				  	echo $row['RouteID'];
				  	echo "&UserID=";
				  	echo $row['ToID'];
				  	echo "&AntagonistID=";
				  	echo $row['FromID'];
				  	echo "&Time=";
				  	echo $row['Time'];
				  	echo "&DateSet=";
				  	echo $row['Date'];
			  		echo "\"> Dismiss :( "; 
			  		echo "</a>"; 
					echo "</td>"; 
			  		echo "</tr>"; */
		  		}
		  		if(!$isNewGoal)
		  			echo "<div id=\"nonewgoals\">You have no new goal notifications.</div>"
				?>
		
		</table> 

				
		</ul>
	    
	    

		</form>

				<?php 
		$userID = $_SESSION['userID']; 
		echo "<br><a data-role=\"button\" href=\"newChallenge.php?userID=" . $_SESSION['userID'] . "\">Challenge a Friend!</a>";
		 ?>
		 
		<h3> Current Goals </h3> 	
		
				<?php
				include("config.php");
				$haveAGoal = false;
				echo "<table>";
			  		echo "<tr>"; 
			  		echo "<td>"; 
			  		echo "<b>Route</b>"; 
			  		echo "</td>"; 
			  		echo "<td>"; 
			  		echo "<b>Goal Time</b>"; 
			  		echo "</td>";
					echo "<td> <b>Challenger</b> </td>";
						
					echo "</tr>"; //Remove if reverted
				echo "</table>";

				
				
				
				$query = sprintf("select Routes.RouteID, Routes.Name, Goals.Time, Goals.UserID, Goals.AntagonistID from Routes, Goals where Goals.RouteID = Routes.RouteID and Goals.UserID = '%s' and Goals.Met = '0'", $_SESSION['userID']);

				$result = mysql_query($query);
				while($row = mysql_fetch_array($result))
		  		{
		  			$haveAGoal = true;
			  		$query = sprintf("select * from Users where UserID = '%s' LIMIT 0, 30 ", $row['AntagonistID']); 
					$userArray = mysql_query($query); 
					$nameRow = mysql_fetch_array($userArray); 
					$challengerName = $nameRow['Name']; 
					
			  		$name = $row['Name']; 
					$time = $row['Time'];
					$routeID = $row['RouteID'];
					$userID = $_SESSION['userID'];
					
					
					/*echo "<div class=\"goalentry\"><span class=\"namelabel\">".$name."</span>";
					echo "<span class=\"timelabel\">".$time."</span>";
					echo */
					
					echo "<table>";
			  		echo "<tr>"; 
			  		echo "<td>"; 
			  		$name = $row['Name']; 
			  		echo $name; 
			  		echo "</td>"; 
			  		echo "<td>"; 
			  		$time = $row['Time']; 
			  		echo $time; 
			  		echo "</td>";
			  		
					
					if ($row['AntagonistID'] !=  $_SESSION['userID']) 
						echo "<td>" . "from " . $challengerName . "</td>";
					else 
						echo "<td> Yourself </td>";
						
					echo "</tr>"; //Remove if reverted
					echo "</table>";
					
					echo "<span class=\"runbutton\"><a data-mini=\"true\" data-inline=\"true\" href = \"route.php?routeID=" . $routeID . "&userID=" . $userID;
					echo "\">"; 
			 	 	echo "RUN"; 
			  		echo "</a></span>";
			  		
			  		echo "<span class=\"runbutton\"><a data-mini=\"true\" data-inline=\"true\" href = \"removeGoal.php?routeID=" .$routeID; 
				  	echo "&UserID=";
				  	echo $row['UserID'];
				  	echo "&AntagonistID=";
				  	echo $row['AntagonistID'];
			  		echo "\"> Remove"; 
			  		echo "</a></span><br><br>";	  		
					
			  		/*echo "<td>"; 
					echo "<a href = \"route.php?routeID=" . $row['RouteID'] . "&userID=" . $_SESSION['userID'];
				  		echo "\">"; 
				 	 	echo "RUN!"; 
				  		echo "</a>";
			  		echo "</td>"; 
			  		
			  		echo "<td>"; 
			  		
					echo "<a href = \"removeGoal.php?routeID="; 
				  	echo $row['RouteID'];
				  	echo "&UserID=";
				  	echo $row['UserID'];
				  	echo "&AntagonistID=";
				  	echo $row['AntagonistID'];
			  		echo "\"> Remove"; 
			  		echo "</a>";	  		
			  		
			  		
			  		echo "</td>";  */	
			  		
			  		//echo "</tr>"; 
		  		}
		  		if(!$haveAGoal){
		  			echo "<div id=\"nogoals\">You have no current goals.</div>";

		  		}
			?>
				
		


		 <h3> Goals you've met: </h3> 
		 <table> 
		
				<?php
				include("config.php");
				$query = sprintf("select Routes.RouteID, Routes.Name, Goals.Time, Goals.UserID, Goals.AntagonistID from Routes, Goals where Goals.RouteID = Routes.RouteID and Goals.UserID = '%s' and Goals.Met = '1'", $_SESSION['userID']);

				$result = mysql_query($query);
				$haveMetAGoal = false;
				while($row = mysql_fetch_array($result))
		  		{
		  			$haveMetAGoal = true;
			  		echo "<tr>"; 
			  		echo "<td>"; 
			  		$name = $row['Name']; 
			  		echo $name; 
			  		echo "</td>"; 
			  		echo "<td>"; 
			  		$time = $row['Time']; 
			  		echo $time; 
			  		echo "</td>";
			  		echo "<td>"; 
					echo "<a href = \"route.php?routeID=" . $row['RouteID'] . "&userID=" . $_SESSION['userID'];
				  		echo "\">"; 
				 	 	echo "RUN!"; 
				  		echo "</a>";
			  		echo "</td>";		  		
			  		echo "</tr>"; 
		  		}
		  		if(!$haveMetAGoal)
		  			echo "<div id=\"nometgoals\">You have not met any goals yet.</div>";
			?>
				
		</table> 

	</div><!-- /content -->

</div><!-- /page -->

</body>
</html>