<!DOCTYPE html> 
<html>

<head>
	<title>VoteCaster | Submit</title> 
	<meta charset="utf-8">
	<meta name="apple-mobile-web-app-capable" content="yes">
 	<meta name="apple-mobile-web-app-status-bar-style" content="black">
	<meta name="viewport" content="width=device-width, initial-scale=1"> 

	<link rel="stylesheet" href="jquery.mobile-1.2.0.css" />
	<link rel="stylesheet" href="style.css" />
	<link rel="apple-touch-icon" href="appicon.png" />
	<link rel="apple-touch-startup-image" href="startup.png">
	
	<script src="jquery-1.8.2.min.js"></script>
	<script src="jquery.mobile-1.2.0.js"></script>

</head> 
<body> 

<div data-role="page">

	<div data-role="header">
		<h1>My Title</h1>
		<a href="#" data-icon="check" id="logout" class="ui-btn-right">Logout</a>

	</div><!-- /header -->

	<div data-role="content">	
	<?php
	session_start();
	include("config.php");

	$username = mysql_real_escape_string($_POST['Name']);
	$password = md5(mysql_real_escape_string($_POST['Password']));
	echo "<p>$password"</p>;
	if (!isset($username) || !isset($password)) {
		header("<p>There seems to have been an error.</p>");    
	}

	elseif (empty($username) || empty($password)) {
		header("<p>There seems to have been an error.</p>");
	} else {
		$result   = mysql_query("select * from Users where Name='$username' AND Password='$password'");
		$rowCheck = mysql_num_rows($result);
		if ($rowCheck > 0) {
			while ($row = mysql_fetch_array($result)) {
				$_SESSION['id'] = $row['UserID'];  
			}
			header("<p>Thank you, <strong>".$_POST["username"]."</strong>. You are now logged in.</p>");     
		} else {
			header("<p>Thank you, <strong>".$_POST["username"]."</strong>. You are now logged in.</p>");
		}
	}
	?> 

	</div><!-- /content -->

		
	<script type="text/javascript">
		$("#logout").click(function() {
			localStorage.removeItem('username');
			$("#form").show();
			$("#logout").hide();
		});
	</script>
</div><!-- /page -->

</body>
</html>