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

<script> 

function showPassword() {
	var password = "cats"; 
	document.getElementById('showPassword').innerHTML = password; 
}
</script> 

<div data-role="page">

	<div data-role="header">
		<h1>RunMaster 5000 | Login</h1>
	</div><!-- /header -->

	<div data-role="content">	
		
		<form action="updateSettings" method="post">
		<label for="foo">Change password:</label>
		<input type="password" name="password" id="bar">
	    <input type="submit" value="Login">
		</form>

        <div id = "showPassword"> <button onclick="showPassword()">Show Password</button> </div> 



	</div><!-- /content -->

</div><!-- /page -->

</body>
</html>