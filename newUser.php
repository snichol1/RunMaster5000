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
		<h1>RunMaster 5000 | Login</h1>
		<a href="home.php" data-icon="back" id="back" class="ui-btn-left">Back</a>

	</div><!-- /header -->

	<div data-role="content">	
		<h3> Create New Account </h3> 

		<?php
			if(isset($_GET['bad'])) echo "<p>Sorry, that user name is already taken.</p>";
		?>

		<form action="addUser.php" method="post">
		<label for="foo">Username:</label>
		<input type="text" name="username" id="foo">
		<label for="bar">Password:</label>
		<input type="password" name="password" id="bar">
	    <input type="submit" value="Create User">
		</form>



	</div><!-- /content -->

</div><!-- /page -->

</body>
</html>