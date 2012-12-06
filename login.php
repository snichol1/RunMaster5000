<!DOCTYPE html> 
<html> 
<head> 
  <title>RunMaster5000 | Login</title>
  <link rel="apple-touch-startup-image" href="themes/startup.png">
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="themes/blue.css" />
    <link rel="stylesheet" href="themes/loginstyle.css" />

  <link rel="stylesheet" href="http://code.jquery.com/mobile/1.2.0/jquery.mobile.structure-1.2.0.min.css" /> 
  <script src="http://code.jquery.com/jquery-1.7.2.min.js"></script> 
  <script src="http://code.jquery.com/mobile/1.2.0/jquery.mobile-1.2.0.min.js"></script> 
<link href='http://fonts.googleapis.com/css?family=Open+Sans+Condensed:300' rel='stylesheet' type='text/css'>

  
  </head> 
<body> 

<div data-role="page">

	<div data-role="header">
		<h1><img src="runmaster5000.png" alt="some_text"></h1>
	</div><!-- /header -->

	<div data-role="content">	
		<?php
			if(isset($_GET['bad'])) echo "<p>Login failed. Check your username and password and try again.</p>";
		?>
		<form action="enter.php" method="post">
		<input type="text"  placeholder='Username' name="name" id="foo" autofocus>
		<input type="password" placeholder='Password' name="password" id="bar">
	    <input type="submit" value="Login">
		</form>

<p> &nbsp </p> 
        <a href="newUser.php" data-icon="plus"> <b> Add New Account </b> </a>

<p id = "citation"> Thanks Phil Roeder for the photo (flickr) </p> 

	</div><!-- /content -->

</div><!-- /page -->

</body>
</html>