<?php
session_start();
$_SESSION['userID']=$_GET['userID'];

?>


<!DOCTYPE html> 
<html> 
<head> 
	<title>RunMaster 5000</title> 
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
		<h1 class="text">Favorites</h1>
		<a href=<?php echo "home.php?userID=" . $_SESSION['userID']?> data-icon="home" id="back" class="ui-btn-left">Home</a>

	</div><!-- /header -->
	<div data-role="content">	
	<h3> Your Favorite Routes </h3> 

		<ul data-role="listview" data-inset="true" data-filter="false">
				<?php
				$count = 0; 
				include("config.php");
				$query = sprintf("select Routes.RouteID, Routes.Name, Routes.Distance, Routes.Difficulty from Favorites, Routes where Favorites.RouteID = Routes.RouteID and Favorites.UserID='%s'", $_SESSION['userID']);

				$result = mysql_query($query);
				while($row = mysql_fetch_array($result))
		  		{
			  		echo "<li><a href = \"route.php?routeID=" . $row['RouteID'] . "&userID=" . $_SESSION['userID']; 
			  		echo "\">"; 
			 	 	echo $row['Name']; 
			  		echo "</a> </li>";
			  		$count++; 
		  		}
		  	?>
				
		</ul>
		<?php
			if ($count == 0) echo "<h2>... oops, you don't have any! Add some!</h2>"; 
		?> 
	
	<style>
	
	</style>
	
	<div data-role="collapsible-set" data-collapsed-icon="arrow-r" data-expanded-icon="arrow-d" data-mini="true">
	<hr> 
	<h3> Edit Favorites List </h3> 
	<div data-role="collapsible" data-collapsed="true" >
	<h3>Add to Favorites</h3>
	<?php
				include("config.php");
				$addCount == 0; 
				$routesQuery = sprintf("select * from Routes"); 
				$routesResult = mysql_query($routesQuery);
				while($row = mysql_fetch_array($routesResult))
		  		{
		  			$query = sprintf("select Routes.RouteID, Routes.Name, Routes.Distance, Routes.Difficulty from Favorites, Routes where Favorites.RouteID = '%s' and Favorites.UserID='%s'", $row['RouteID'],$_SESSION['userID']);
					$result = mysql_query($query);
					$included = 0; 
					while($newRow = mysql_fetch_array($result))
			  		{
			  			$included = 1; 
			  		}
					if ($included == 0) {
						$addCount++; 
				  		echo "<p><a href = \"editFavorites.php?routeID=" . $row['RouteID'] . "&userID=" . $_SESSION['userID'] . "&action=add"; 
				  		echo "\">"; 
				 	 	echo $row['Name']; 
				  		echo "</a> </p>";
					}
		  		}
		  		if ($addCount == 0) echo "You've already added all available runs to your favorites!"; 
				?>				
				
	</div>
	
	<div data-role="collapsible">
	<h3>Remove from Favorites</h3>
	<?php
				include("config.php");
				$query = sprintf("select Routes.RouteID, Routes.Name, Routes.Distance, Routes.Difficulty from Favorites, Routes where Favorites.RouteID = Routes.RouteID and Favorites.UserID='%s'", $_SESSION['userID']);

				$result = mysql_query($query);
				$removeCount = 0; 
				while($row = mysql_fetch_array($result))
		  		{
			  		echo "<p><a href = \"editFavorites.php?routeID=" . $row['RouteID'] . "&userID=" . $_SESSION['userID'] . "&action=remove"; 
			  		echo "\">"; 
			 	 	echo $row['Name']; 
			  		echo "</a> </p>";
			  		$removeCount++; 
		  		}
		  		if ($removeCount == 0) echo "Oops, you don't have any favorites yet!"; 
				?>
	</div>
	
</div>
		
	</div><!-- /content -->

</div><!-- /page -->


</body>
</html>