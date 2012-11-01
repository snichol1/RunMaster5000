<!DOCTYPE html> 
<html> 
<head> 
	<title>New Goal</title> 
	<meta name="viewport" content="width=device-width, initial-scale=1"> 
	<link rel="stylesheet" href="http://code.jquery.com/mobile/1.2.0/jquery.mobile-1.2.0.min.css" />
	<script src="http://code.jquery.com/jquery-1.8.2.min.js"></script>
	<script src="http://code.jquery.com/mobile/1.2.0/jquery.mobile-1.2.0.min.js"></script>
  <link rel="stylesheet" href="jquery.ui.datepicker.mobile.css" /> 
    
</head> 
<body> 

<div data-role="page">

	<div data-role="header">
		<h1>
		<?php
		$runNumber = $_GET['routeid'];
			include("config.php");

			$query = sprintf("select * from Routes where RouteID='%s'", $runNumber);
			$result = mysql_query($query);
			while($row = mysql_fetch_array($result))
	  		{
				echo $row['Name']; 
		  	}

		?>
		</h1>
		<a href="home.php" data-icon="back" data-rel="back">Home</a>

	</div><!-- /header -->

	<div data-role="content">	
	<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCv5woZWJa4qFr4nO4Dp9dCl3LrPQBMToE&sensor=false"></script>
				
	<div id="mapcanvas" style="height:288px;width:300px"></div>

	
	<script type="text/javascript">
		$(document).ready(function() {
			
			var startLat= -34.396999;
			var startLng= 150.643997;
			var mapOptions = {
				center: new google.maps.LatLng(startLat, startLng),
				zoom: 8,
				mapTypeId: google.maps.MapTypeId.ROADMAP
			};
			var map = new google.maps.Map(document.getElementById("mapcanvas"),
				mapOptions);
		});
	</script>
	
	<?php
		echo "<p>Your Time: </p>";
		echo "<p>Goal Time: </p>";
	?>
 </div><!-- /content -->

</div><!-- /page -->

</body>
</html>