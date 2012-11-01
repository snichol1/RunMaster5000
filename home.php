<!DOCTYPE html> 
<html> 
<head> 
	<title>RunMaster 5000</title> 
	<meta name="viewport" content="width=device-width, initial-scale=1"> 
	<link rel="stylesheet" href="http://code.jquery.com/mobile/1.2.0/jquery.mobile-1.2.0.min.css" />
	<script src="http://code.jquery.com/jquery-1.8.2.min.js"></script>
	<script src="http://code.jquery.com/mobile/1.2.0/jquery.mobile-1.2.0.min.js"></script>
</head> 
<body> 

<div data-role="page">

	<div data-role="header">
		<h1>RunMaster 5000</h1>
	</div><!-- /header -->

	<div data-role="content">	
		<?php
			$userID = $_GET['id'];
			$name = $_GET['name'];
			echo"<p>Welcome, ".$name."</p>";
		?>
		<ul data-role="listview" data-inset="true" data-filter="false">
			<li><a href="nearby.html">Nearby Runs</a></li>
			<li><a href="favorites.php">Favorite Runs</a></li>
			<li><a href="search.html">Search</a></li>
			<li><a href="goals.php">Goals</a></li>
			<li><a href="friends.php">Friends</a></li>
			<li><a href="newChallenge.php">Challenge a Friend!</a></li>
		</ul>
	</div><!-- /content -->

</div><!-- /page -->

</body>
</html>