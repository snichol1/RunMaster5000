<?php
session_start();
?>
<!DOCTYPE html> 
<html>

<head>
	<title>Home</title> 
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
	//session_start();
	include("config.php");

	$name = mysql_real_escape_string($_POST['name']);
	$password = mysql_real_escape_string($_POST['password']);
	echo "<p>".$password."</p>";
	if (!isset($name) || !isset($password)) {
		echo "<p>There seems to have been an error.</p>";    
	}

	elseif (empty($name) || empty($password)) {
		echo "<p>There seems to have been an error.</p>";
	} else {
		$result   = mysql_query("select * from Users where Name='$name' AND Password='$password'");
		$rowCheck = mysql_num_rows($result);
		if ($rowCheck > 0) {
			while ($row = mysql_fetch_array($result)) {
				$id = $row['UserID'];
				$name = $row['Name'];
			// store session data
				$_SESSION['userID']=$row['UserID'];
			}
			$url = "home.php?userID=" . $id . "&userName=" . $name;
			echo "<p>URL:".$url."</p>";
			
			
			//echo"<p>Thank you, <strong>".$_POST["name"]."</strong>. You are now logged in.</p>";
			//echo "<p>UserID: ".$_SESSION['id']."</p>";
				echo("<script>
				<!--
				location.replace(\"$url\");
				-->
				</script>");
		} else {
			echo "<p>Hmm. Something's not right; try again?</p>";
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