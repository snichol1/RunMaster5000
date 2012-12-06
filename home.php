<?php session_start();
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

<div data-role="page">

	<div data-role="header">
		<h1><div class="headtext">Home</div></h1>
				<a href="login.php" data-icon="check" id="logout" class="ui-btn-right">Logout</a>
	</div><!-- /header -->
	
	<div data-role="content">	
		<style>
			@font-face {
				font-family: PTSans;
				src: url('PTSans.ttf');
			}
			
			.headtext{
				font-family: PTSans;
			}
		</style>
		<?php
			$userID = $_SESSION['userID'];
			$name = $_GET['name'];
			
			if ($_GET['changed']) echo "<h3 style=\"color: green;\"> Password successfully changed! </h3>"; 
			include("config.php");
			$query = sprintf("select * from Users where UserID = '%s'", $_GET['userID']); 			
			$result = mysql_query($query);

			$champQuery = "select UserID, RouteID, mins.Time from Records, (select min(Time) as Time from Records group by RouteID) mins where Records.Time = mins.Time and UserID = " . $userID;
			$champResult = mysql_query($champQuery);
			$champCheck = mysql_num_rows($champResult);
				while($row = mysql_fetch_array($result))
		  		{
					echo "<h3>";
					if($champCheck > 0) echo "<img src=\"trophy.jpg\" />";
					echo $row['Name'] . "</h3>"; 
		  		}
		?>
		<ul data-role="listview" data-inset="true" data-filter="false">
			<?php echo "<li><a class=\"\" href=\"searchresults.php?name=optional&mysubmit=Search!&userID=" . $_SESSION['userID'] . "\">Routes</a></li>" ?>
			<?php echo "<li><a class=\"\" href=\"favorites.php?userID=" . $_SESSION['userID'] . "\">Favorite Routes</a></li>" ?>
			<!---<?php echo "<li><a href=\"searchresults.php?name=optional&mysubmit=Search!&userID=" . $_SESSION['userID'] . "\">Search Routes</a></li>" ?> -->
			<?php echo "<li><a class=\"\" href=\"newRoute.php?userID=" . $_SESSION['userID'] . "\">Create a New Route</a></li>" ?>
			<?php echo "<li><a class=\"\" href=\"goals.php?userID=" . $_SESSION['userID'] . "\">Goals";
				$chQuery = "SELECT * FROM Challenge WHERE ToID = " . $userID;
				$chResult = mysql_query($chQuery);
				$chCheck = mysql_num_rows($chResult);
				if($chCheck > 0) echo "  <div class=\"\" style=\"color: red; float: right;\">New challenge!</div>";
				echo "</a></li>"; ?>
			<?php echo "<li><a class=\"\" href=\"friends.php?userID=" . $_SESSION['userID'] . "\">Friends</a></li>" ?>
			<?php echo "<li><a class=\"\" href=\"settings.php?userID=" . $_SESSION['userID'] . "&isCorrect=1\">Settings</a></li>" ?>

		</ul>
	</div><!-- /content -->

</div><!-- /page -->

</body>
</html>