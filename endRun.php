<!DOCTYPE html> 
<html> 
<head> 
	<title>New Goal</title> 
	<meta name="viewport" content="width=device-width, initial-scale=1"> 
	<link rel="stylesheet" href="http://code.jquery.com/mobile/1.2.0/jquery.mobile-1.2.0.min.css" />
	<script src="http://code.jquery.com/jquery-1.8.2.min.js"></script>
	<script src="http://code.jquery.com/mobile/1.2.0/jquery.mobile-1.2.0.min.js"></script>
</head>

<body> 

<div data-role="page">

	<div data-role="header">
		<h1>Run Finished</h1>
		<a href="home.php" data-icon="home">Back</a>
	</div><!-- /header -->
	<h2>Congrats on your run! Keep up the good work.</h2>
	<div id="time"></div>
	<a href="newChallenge.php" data-role="button" data-icon="" data-iconpos="right">Challenge a Friend</a>
	<a href="home.php" data-role="button" data-icon="home" data-iconpos="right">Home</a>
	
	<script type="text/javascript">
		document.getElementById("time").textContent = "Your time was: " sessionStorage.time;
	</script>
</div>
<body>
</html>