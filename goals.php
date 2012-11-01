<!DOCTYPE html> 
<html> 
<head> 
	<title>Goals</title> 
	<meta name="viewport" content="width=device-width, initial-scale=1"> 
	<link rel="stylesheet" href="http://code.jquery.com/mobile/1.2.0/jquery.mobile-1.2.0.min.css" />
	<link rel="stylesheet" href="friends.css"/>
	<script src="http://code.jquery.com/jquery-1.8.2.min.js"></script>
	<script src="http://code.jquery.com/mobile/1.2.0/jquery.mobile-1.2.0.min.js"></script>
	
	
	</style> 

</head> 
<body> 

<div data-role="page">

	<div data-role="header">
		<h1>Goals</h1>
		<a href="home.php" data-icon="back">Home</a>

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
	
		<h3> Goals </h3> 
		<table> 
		
				<?php
				include("config.php");
				$query = sprintf("select Routes.RouteID, Routes.Name, Goals.Time, Goals.UserID, Goals.AntagonistID from Routes, Goals where Goals.RouteID = Routes.RouteID and Goals.UserID = '2' and Goals.Met = '0'");

				$result = mysql_query($query);
				while($row = mysql_fetch_array($result))
		  		{
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
				echo "<a href = \"run.php?id="; 
			  		echo $row['RouteID'];
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
		  		
		  		
		  		echo "</td>"; 
		  		
		  		echo "</tr>"; 
		  		}
			?>
				
		</table> 
		

		<h3> Challenges </h3> 
				
			<table> 
				<?php
				include("config.php");
				$query = "select * from Challenge where Challenge.ToID = '2'"; 
				$result = mysql_query($query);
				while($row = mysql_fetch_array($result))
		  		{
		  		$query = sprintf("select * from Users where UserID = '%s' LIMIT 0, 30 ", $row['FromID']); 
				$userArray = mysql_query($query); 
				$nameRow = mysql_fetch_array($userArray);  
				
				$query = sprintf("select * from Routes where RouteID = '%s' LIMIT 0, 30 ", $row['RouteID']); 
				$routeArray = mysql_query($query); 
				$routeRow = mysql_fetch_array($routeArray);  

		  		echo "<tr>"; 
		  		echo "<td>"; 
		  		echo $nameRow['Name']; 
		  		echo "  beat your best time on " . $routeRow['Name']; 
				echo "</td>"; 
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
		  		echo "</tr>"; 
		  		}
				?>
		
		</table> 

				
		</ul>
	    
	    

		</form>

		
	</div><!-- /content -->

</div><!-- /page -->

</body>
</html>