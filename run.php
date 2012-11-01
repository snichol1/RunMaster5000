<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <title>
        </title>
        <link rel="stylesheet" href="https://ajax.aspnetcdn.com/ajax/jquery.mobile/1.1.1/jquery.mobile-1.1.1.min.css" />
        <link rel="stylesheet" href="run.css" />
        <style>

        </style>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js">
        </script>
        <script src="https://ajax.aspnetcdn.com/ajax/jquery.mobile/1.1.1/jquery.mobile-1.1.1.min.js">
        </script>
        <script src="my.js">
        </script>
    </head>
    <body>
        <!-- Home -->
        <div data-role="page" id="page1">
            <div data-role="header">
			<h1>
			<?php
			$runNumber = $_GET['id'];
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
					function initialize() {
						var mapOptions = {
							var lat = google.loader.ClientLocation.latitude;
							console.log(lat);
							var long = google.loader.ClientLocation.longitude;
							console.log(long);
							center: new google.maps.LatLng(lat, long),
							zoom: 8,
							mapTypeId: google.maps.MapTypeId.ROADMAP
						};
						var map = new google.maps.Map(document.getElementById("mapcanvas"),
							mapOptions);
					}
				</script>
            </div>
            
            <h3 id = "distance">
            	<?php
				$runNumber = $_GET['id'];
				include("config.php");

				$query = sprintf("select * from Routes where RouteID='%s'", $runNumber);
				$result = mysql_query($query);
				while($row = mysql_fetch_array($result))
		  		{
		  			echo "<h3> Distance:  "; 
		  			echo $row['Distance']; 
		  			echo " miles </h3>"; 
		  			
		  			echo "<h3> Difficulty: "; 
		  			echo $row['Difficulty']; 
		  			echo " out of 5 </h3>"; 
		  		}
		  		echo "<a href=\"leaderboard.php?routeid=".$runNumber."\" data-role=\"button\" data-icon=\"\" data-iconpos=\"right\">Leaderboard</a>";
		  		
				echo "<a href=\"newGoal.php?routeid=".$runNumber."\" data-role=\"button\" data-icon=\"plus\" data-iconpos=\"right\">Add Goal</a>";
				
			?>
			
			
            
            </h3> 
                                    
			<a class = "run" href="index.html" data-role="button" data-icon="none"  data-iconpos="right">Run!</a>

        </div>
        <script>
            //App custom javascript
        </script>
    </body>
</html>