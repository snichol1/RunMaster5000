<?php
session_start();
if ($_SESSION['userID']) $_SESSION['userID']=$_GET['userID'];
?>



<!DOCTYPE html> 
<html> 
<head> 
	<title>Goals</title> 
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="themes/blue.css" />
		<link rel="stylesheet" href="http://code.jquery.com/mobile/1.2.0/jquery.mobile.structure-1.2.0.min.css" /> 
		<script src="http://code.jquery.com/jquery-1.7.2.min.js"></script> 
		<script src="http://code.jquery.com/mobile/1.2.0/jquery.mobile-1.2.0.min.js"></script>    
	
	
	<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCv5woZWJa4qFr4nO4Dp9dCl3LrPQBMToE&sensor=false"></script>

</head> 
<body> 

<div data-role="page">
<style>
	@font-face {
		font-family: PTSans;
		src: url('PTSans.ttf');
	}
	
	.text{
		font-family: PTSans;
	}
</style>
	<div data-role="header">
		<h1 class="text">Goals</h1>
		<a href=<?php echo "home.php?userID=" . $_SESSION['userID']?> data-icon="home" id="back" class="ui-btn-left">Home</a>

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
    
    <style>
    	.newgoalshead{
    		margin-top: -3px;
    		margin-bottom: 10px;
    	}
    	.newgoals{
    		margin-bottom: 10px;	
    	}
    	.challengehead{
    		margin-bottom: -10px;	
    	}
    	.currgoalshead{
    		margin-bottom: 10px;	
    	}
    	.challengebut{
    		margin-top: -23px;	
    		margin-bottom: 20px;
    	}
    	.lheader{
			font-size: 10px;
			margin-top: 5px;
			margin-bottom: 5px;
		}
    </style>
	<h3 class="newgoalshead head"> New Goals </h3> 
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
					echo "<span class=\"challenger newchallenge\">".$nameRow['Name'] . " challenged you to " . $routeRow['Name']. "!</span>";
					echo "<span class=\"acceptbutton\"><a data-mini=\"true\" data-inline=\"true\" href = \"addToGoals.php?routeID=".$row['RouteID']."&UserID=".$row['ToID']."&AntagonistID=".$row['FromID']."&Time=".$row['Time']."&DateSet=". $row['Date']."\"> Accept the challenge!</a></span>";
					echo "<span class=\"dismissbutton\"><a data-mini=\"true\" data-inline=\"true\" href = \"dismissChallenge.php?routeID=".$row['RouteID']."&AntagonistID=".$row['FromID']."&Time=".$row['Time']."\"> Dismiss.</a></span>";
					echo "</div>";
					
		  		}
		  		if(!$isNewGoal)
		  			echo "<div id=\"nonewgoals\">You have no new goal notifications.</div>"
				?>
		
		</table> 

	    

		</form>
		<hr> 
		<h3 = "challengehead head"> Challenge a friend </h3>
		<?php 
			$userID = $_SESSION['userID']; 

			include("config.php");
			$haveTimes = false;
			$query = sprintf("select * from Records where UserID = '%s'", $userID); 
			$result = mysql_query($query);
			while($row = mysql_fetch_array($result)) {
				$haveTimes = true; 
			}
			if ($haveTimes) echo "<br><a class='challengebut' data-role=\"button\" href=\"newChallenge.php?userID=" . $_SESSION['userID'] . "\">Challenge a Friend!</a> ";
			else {
				echo " </h3 class='challengebut'> Oops! You can't send a challenge until you've run a route yourself."; 
			}

		 ?>
		 
		 <hr>
		 
		<h3 class="currgoalshead head"> Current Goals </h3> 	
		
				<?php
				include("config.php");
				$haveAGoal = false;
				

				
				
				
				$query = sprintf("select Routes.RouteID, Routes.Name, Goals.Time, Goals.UserID, Goals.AntagonistID from Routes, Goals where Goals.RouteID = Routes.RouteID and Goals.UserID = '%s' and Goals.Met = '0'", $_SESSION['userID']);

				$result = mysql_query($query);
				$counter = 0; 
				while($row = mysql_fetch_array($result))
		  		{
		  			if ($counter == 0) {
		  				echo "<div class=\"ui-grid-b\">";
						echo "<div class='ui-block-a lheader'><b>ROUTE</b></div> <div class='ui-block-b lheader'><b>GOAL TIME</b></div> <div class='ui-block-c lheader'><b>CHALLENGER</b></div>";
						echo "</div>";
		  				/*echo "<table>";
				  		echo "<tr>"; 
				  		echo "<td>"; 
				  		echo "<b>Route | </b>"; 
				  		echo "</td>"; 
				  		echo "<td>"; 
				  		echo "<b>Goal Time | </b>"; 
				  		echo "</td>";
						echo "<td> <b>Challenger</b> </td>";
						echo "</tr>"; 
						echo "</table>";*/
		  			}
		  			$haveAGoal = true;
			  		$query = sprintf("select * from Users where UserID = '%s' LIMIT 0, 30 ", $row['AntagonistID']); 
					$userArray = mysql_query($query); 
					$nameRow = mysql_fetch_array($userArray); 
					$challengerName = $nameRow['Name']; 
					
			  		$name = $row['Name']; 
					$time = $row['Time'];
					$routeID = $row['RouteID'];
					$userID = $_SESSION['userID'];
					$counter++; 
					
					echo "<div class=\"ui-grid-b\">";
					echo "<div class='ui-block-a'>". $name . "</div>";
					echo "<div class='ui-block-b'>". $time . "</div>";
					if ($row['AntagonistID'] !=  $_SESSION['userID']) 
						echo "<div class='ui-block-c'>". $challengerName . "</div>";
					else 
						echo "<div class='ui-block-c'>Yourself</div>";
					echo "</div>";
					
					echo "<div class='ui-grid-a'>";
						echo "<div class=\"runbutton ui-block-a\"><a data-mini=\"true\" data-inline=\"\" href = \"route.php?routeID=" . $routeID . "&userID=" . $userID;
						echo "\">"; 
						echo "Run!"; 
				  		echo "</a></div>";
				  		
				  		echo "<div class=\"removebutton ui-block-b\"><a data-mini=\"true\" data-inline=\"\" href = \"removeGoal.php?routeID=" .$routeID; 
					  	echo "&UserID=";
					  	echo $row['UserID'];
					  	echo "&AntagonistID=";
					  	echo $row['AntagonistID'];
				  		echo "\"> Remove"; 
				  		echo "</a></div><br><br>";	  	
					echo "</div>"; 		
					 
		  		}
		  		if(!$haveAGoal){
		  			echo "<div id=\"nogoals\">You have no current goals. Let's solve that problem!</div>";
		  			echo "<h3><i> Step 1: Pick a route </i></h3>";
					include("config.php");
					$query = sprintf("select * from Routes"); 
					$result = mysql_query($query);
					echo "<select id = 'newRoute'>"; 
					while($row = mysql_fetch_array($result))
		  			{
		  				echo "<option value=" . $row['RouteID'] .">" . $row['Name'] . "</option>"; 
		  			}
		  			echo "</select>"; 
		  			
		  			?>
					<h3><i> Step 2: Make it official! </i>
		  			<br><a data-role="button" href="#" onclick="submitRequest()">Add a new goal for this route!</a>
		  			</h3>
		  			<script> 
		  				function submitRequest() {
		  					var baseURL = "addGoalFromGoalsPage.php"; 
		  					var userID = "<?php echo $_SESSION['userID'] ?>";
		  					var routeID = document.getElementById("newRoute").value; 
		  					var completeURL = baseURL + "?userID=" + userID + "&routeID=" + routeID; 
		  					window.location.href = completeURL; 
		  				}
		  			</script> 

		  			<?php 


		  		}
			?>
				
		

<hr>
		 <h3> Goals you've met: </h3> 
		 	
		
				<?php
				include("config.php");
				$query = sprintf("select Routes.RouteID, Routes.Name, Goals.Time, Goals.UserID, Goals.AntagonistID from Routes, Goals where Goals.RouteID = Routes.RouteID and Goals.UserID = '%s' and Goals.Met = '1'", $_SESSION['userID']);

				$result = mysql_query($query);
				$haveMetAGoal = false;
				while($row = mysql_fetch_array($result))
		  		{
		  			echo "<div data-role=\"collapsible-set\">"; 
		  			echo "<div data-role=\"collapsible\" data-collapsed=\"true\" collapsedIcon=\"arrow-r\">";
		  			echo "<h3>See your achievements!</h3><table>"; 
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
					echo "<a class = \"runbutton\" href = \"route.php?routeID=" . $row['RouteID'] . "&userID=" . $_SESSION['userID'];
				  		echo "\">"; 
				 	 	echo "RUN!"; 
				  		echo "</a>";
			  		echo "</td>";		  		
			  		echo "</tr>"; 
			  		echo "</table></div></div>";
		  		}
		  		if(!$haveMetAGoal)
		  			echo "<div id=\"nometgoals\">You have not met any goals yet. :( </div>";
			?>
				
	</div><!-- /content -->

</div><!-- /page -->

</body>
</html>