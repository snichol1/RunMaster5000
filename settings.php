<?php
session_start();
?>

<!DOCTYPE html> 
<html> 
<head> 
	<title>RunMaster 5000</title> 
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="themes/blue.css" />
		<link rel="stylesheet" href="http://code.jquery.com/mobile/1.2.0/jquery.mobile.structure-1.2.0.min.css" /> 
		<script src="http://code.jquery.com/jquery-1.7.2.min.js"></script> 
		<script src="http://code.jquery.com/mobile/1.2.0/jquery.mobile-1.2.0.min.js"></script>    
</head> 
<body> 

<script> 

function showPassword() {
	var password = "cats"; 
	document.getElementById('showPassword').innerHTML = password; 
}
</script> 

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
		<h1 class="text">Settings</h1>
		<a href=<?php echo "home.php?userID=" . $_SESSION['userID']?> data-icon="home" id="back" class="ui-btn-left">Home</a>
	</div><!-- /header -->

	<div data-role="content">	
		
		<?php
			$correct = $_GET['isCorrect']; 
			if ($correct == 0) echo "<h3 style=\"color: red;\"> The current password you entered is incorrect. Try again. <h3> " 

		?> 
		<form action="updateSettings.php" method="post">
		<label for="foo">Old password:</label>
		<input type="password" name="oldPassword" id="bar">
		<label for="foo">New password:</label>
		<input type="password" name="newPassword" id="bar">

	    <input type="submit" value="Change Password">
		</form>



	</div><!-- /content -->

</div><!-- /page -->

</body>
</html>