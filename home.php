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
		<h1>RunMaster 5000</h1>
				<a href="login.php" data-icon="check" id="logout" class="ui-btn-right">Logout</a>
	</div><!-- /header -->

	<div data-role="content">	
		<?php
			$userID = $_SESSION['userID'];
			$name = $_GET['name'];

			include("config.php");
			$query = sprintf("select * from Users where UserID = '%s'", $_GET['userID']); 
				$result = mysql_query($query);
				while($row = mysql_fetch_array($result))
		  		{
					echo "Welcome, " . $row['Name']; 
		  		}
		?>
		<ul data-role="listview" data-inset="true" data-filter="false">
			<?php echo "<li><a href=\"nearby.php?userID=" . $_SESSION['userID'] . "\">Stanford Routes</a></li>" ?>
			<?php echo "<li><a href=\"favorites.php?userID=" . $_SESSION['userID'] . "\">Favorite Routes</a></li>" ?>
			<?php echo "<li><a href=\"search.php?userID=" . $_SESSION['userID'] . "\">Search Routes</a></li>" ?>
			<?php echo "<li><a href=\"goals.php?userID=" . $_SESSION['userID'] . "\">Goals</a></li>" ?>
			<?php echo "<li><a href=\"friends.php?userID=" . $_SESSION['userID'] . "\">Friends</a></li>" ?>
			<?php echo "<li><a href=\"settings.php?userID=" . $_SESSION['userID'] . "\">Settings</a></li>" ?>

		</ul>
	</div><!-- /content -->

</div><!-- /page -->

</body>
</html>