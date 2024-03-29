<?php
session_start();
?>

<!DOCTYPE html> 
<html>

<head>
	<title>Remove Friend</title> 
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
		<h1>Remove Friend</h1>
		<a href="#" data-icon="check" id="logout" class="ui-btn-right">Logout</a>
                <a href="home.php" data-icon="back" data-rel="back" data-add-back-btn="true">Back</a>

	</div><!-- /header -->

	<div data-role="content">	
		
		<?php
		$name = $_POST["username"]; 
		$userID = $_SESSION["userID"];
		$friendID = $_GET['friendID']; 

		include("config.php"); 
		$query = sprintf("delete from Friends where ID1 = '%s' and ID2 = '%s'", $userID, $friendID); 
		
		mysql_query($query); 
		echo "Friend Removed!"; 
		?>
		
		<script> 
		window.location.href = "friends.php?userID=<?php echo $_SESSION['userID']?>"; 
		</script> 

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