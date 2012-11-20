<?php
session_start();
?>


<!DOCTYPE html> 
<html> 
<head> 
	<title>RunMaster 5000</title> 
	<meta name="viewport" content="width=device-width, initial-scale=1"> 
	<link rel="stylesheet" href="http://code.jquery.com/mobile/1.2.0/jquery.mobile-1.2.0.min.css" />
	<script src="http://code.jquery.com/jquery-1.8.2.min.js"></script>
	<script src="http://code.jquery.com/mobile/1.2.0/jquery.mobile-1.2.0.min.js"></script>
	<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCv5woZWJa4qFr4nO4Dp9dCl3LrPQBMToE&sensor=false"></script>

</head> 
<body> 




<div data-role="page">

	<div data-role="header">
		<h1>Favorites</h1>
         <a href="home.php" data-icon="back">Back</a>

	</div><!-- /header -->

	<div data-role="content">	

		<ul data-role="listview" data-inset="true" data-filter="false">
				<?php
				include("config.php");
				$query = sprintf("select Routes.RouteID, Routes.Name, Routes.Distance, Routes.Difficulty from Favorites, Routes where Favorites.RouteID = Routes.RouteID and Favorites.UserID='%s'", $_SESSION['userID']);

				$result = mysql_query($query);
				while($row = mysql_fetch_array($result))
		  		{
			  		echo "<li><a href = \"route.php?routeID=" . $row['RouteID'] . "&userID=" . $_SESSION['userID']; 
			  		echo "\">"; 
			 	 	echo $row['Name']; 
			  		echo "</a> </li>";
		  		}
				?>
				
		</ul>
		
	</div><!-- /content -->

</div><!-- /page -->

</body>
</html>