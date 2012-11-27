<?php session_start();
$_SESSION['userID']=$_GET['userID'];

?>


<!DOCTYPE html> 
<html> 
<head> 
	<title>Home</title> 
	
	  <meta charset="utf-8" />
	  <meta name="viewport" content="width=device-width, initial-scale=1">
	  <link rel="stylesheet" href="themes/blue.css" />
	  <link rel="stylesheet" href="http://code.jquery.com/mobile/1.2.0/jquery.mobile.structure-1.2.0.min.css" /> 
	  <script src="http://code.jquery.com/jquery-1.7.2.min.js"></script> 
	  <script src="http://code.jquery.com/mobile/1.2.0/jquery.mobile-1.2.0.min.js"></script> 
	
	
	<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCv5woZWJa4qFr4nO4Dp9dCl3LrPQBMToE&sensor=false"></script>

</head> 
<body> 
	<script> 
	
	 $(function() {
        $( "input[type=submit], a, button" )
            .button()
            .click(function( event ) {
                event.preventDefault();
            });
    });
    </script>
<div data-role="page">

	<div data-role="header">
		<h1>Home</h1>
				<a href="login.php" data-icon="check" id="logout" class="ui-btn-right">Logout</a>
	</div><!-- /header -->

	<div data-role="content">	
		<?php
			$userID = $_GET['userID'];
			$name = $_GET['name'];
			
			if ($_GET['changed']) echo "<h3 style=\"color: green;\"> Password successfully changed! </h3>"; 
			include("config.php");
			$query = sprintf("select * from Users where UserID = '%s'", $_GET['userID']); 
				$result = mysql_query($query);
				while($row = mysql_fetch_array($result))
		  		{
					echo "Welcome, " . $row['Name']; 
		  		}
		?>
		
		<h3> Favorites </h3> 
			<?php
			$userID = $_GET['userID'];
			$name = $_GET['name'];
			
			include("config.php");
			$query = sprintf("select Routes.RouteID, Routes.Name, Routes.Distance, Routes.Difficulty from Favorites, Routes where Favorites.RouteID = Routes.RouteID and Favorites.UserID='%s'", $_GET['userID']);
				$result = mysql_query($query);
				$count = 0; 
				while($row = mysql_fetch_array($result))
		  		{
					if ($count < 2) echo "<p><a id='run' href=\"route.php?routeID=" . $row['RouteID'] . "&userID=" . $_GET['userID']. "\">" . $row['Name'] ."</a></p>"; 
					$count++; 
		  		}
		  		
		  		echo "<div class=\"ui-grid-a my-breakpoint\">"; 

		  		if ($count > 2) echo "<div class=\"ui-block-a\" <p> <a href=\"favorites.php?userID=" . $_GET['userID'] . "\">See all favorites</a></p></div>";

				$url = "searchresults.php?name=optional&mysubmit=Search!&userID=" . $_GET['userID']; 
				echo "<div class=\"ui-block-b\"><p><a href = " . $url . "\> See all routes </a></p></div>"; 
			echo "</div>"; 
		?>
		<hr> 
		<h3> Goals </h3> 
		
				<?php
				include("config.php");
				$haveAGoal = false;
				$goalsCount = 0; 
				
				
				$query = sprintf("select Routes.RouteID, Routes.Name, Goals.Time, Goals.UserID, Goals.AntagonistID from Routes, Goals where Goals.RouteID = Routes.RouteID and Goals.UserID = '%s' and Goals.Met = '0'", $_GET['userID']);

				$result = mysql_query($query);
				$counter = 0; 
				while($row = mysql_fetch_array($result))
		  		{
		  			if ($counter == 0) {
		  				echo "<table>";
				  		echo "<tr>"; 
				  		echo "<td>"; 
				  		echo "<b>Route | </b>"; 
				  		echo "</td>"; 
				  		echo "<td>"; 
				  		echo "<b>Goal Time | </b>"; 
				  		echo "</td>";
						echo "<td> <b>Challenger</b> </td>";
						echo "</tr>"; //Remove if reverted
						echo "</table>";
		  			}
		  			$haveAGoal = true;
			  		$query = sprintf("select * from Users where UserID = '%s' LIMIT 0, 30 ", $row['AntagonistID']); 
					$userArray = mysql_query($query); 
					$nameRow = mysql_fetch_array($userArray); 
					$challengerName = $nameRow['Name']; 
					
					if ($goalsCount < 2) {
				  		$name = $row['Name']; 
						$time = $row['Time'];
						$routeID = $row['RouteID'];
						$userID = $_SESSION['userID'];
						$counter++; 
						
						
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
				 	 	echo "Run!"; 
				  		echo "</a></span>";
				  		
				  		echo "<span class=\"removebutton\"><a data-mini=\"true\" data-inline=\"true\" href = \"removeGoal.php?routeID=" .$routeID; 
					  	echo "&UserID=";
					  	echo $row['UserID'];
					  	echo "&AntagonistID=";
					  	echo $row['AntagonistID'];
				  		echo "\"> Remove"; 
				  		echo "</a></span><br><br>";	  
					}	
					$goalsCount++; 	

		  		}
		if ($goalsCount > 2) echo "<a href=\"goals.php?userID=" . $_GET['userID'] . "\"> See all goals </a>";  
		
	?>
		<hr> 
		<h3> Manage my Account </h3> 
		<div class="ui-grid-a my-breakpoint">
			<div class="ui-block-a"> <?php echo "<a href=\"friends.php?userID=" . $_SESSION['userID'] . "\">Friends</a>" ?>      </div>
			<div class="ui-block-b">  	<?php echo "<a href=\"settings.php?userID=" . $_SESSION['userID'] . "&isCorrect=1\">Settings</a>"?>
    </div>
		</div><!-- /grid-a -->
	</div><!-- /content -->

</div><!-- /page -->

</body>
</html>