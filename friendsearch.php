<?php
session_start();
?>

<!DOCTYPE html>
<html>
<head>
	<title>Stanford Routes</title> 
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="themes/blue.css" />
	<link rel="stylesheet" href="http://code.jquery.com/mobile/1.2.0/jquery.mobile.structure-1.2.0.min.css" /> 
	<link rel="stylesheet" type="text/css" href="style.css">
	<script src="http://code.jquery.com/jquery-1.7.2.min.js"></script> 
	<script src="http://code.jquery.com/mobile/1.2.0/jquery.mobile-1.2.0.min.js"></script> 

	<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCv5woZWJa4qFr4nO4Dp9dCl3LrPQBMToE&sensor=false"></script>

	
</head>
<body>

	<?php
		include("config.php");
		$query = sprintf("select distinct UserID, Name from Users where not exists (select ID2 from Friends where ID1 = %s and UserID = ID2) and UserID <> %s", $_SESSION['userID'], $_SESSION['userID']);

		$result = mysql_query($query);
		
		echo "<ul data-role=\"listview\" data-filter-placeholder=\"Search people...\" data-filter=\"true\" data-theme=\"b\">";

		while($row = mysql_fetch_array($result))
  		{
	  		echo "<tr>"; 
	  		echo "<td>"; 
	  		echo $row['Name']; 
	  		echo "</td>"; 
	  		echo "<td>"; 
	  		echo "<form action=\"addFriend.php?userID=" . $_SESSION['userID']. "\" method=\"post\"> <input type=\"hidden\" name=\"username\" id=\"foo\" value = "; 
	  		echo $row['Name']; 
	  		echo "> "; 
	  		echo "<input type=\"hidden\" name=\"friendID\" id=\"foo\" value = "; 
	  		echo $row['UserID']; 
	  		echo ">"; 

	  		echo "<input type=\"submit\" value="; 
	  		echo "Follow";
	  		echo "> </form>";
	  		echo "</td>";
	  		echo "</tr>";
	  		
	  		
	  		
	  		echo "<li data-corners=\"false\" data-icon=\"arrow-r\" data-iconpos=\"right\" data-theme=\"c\">";
	  			echo "<p>". $row['Name'] . "</p>";
				//echo "<a href=\"route.php?routeID=".$row["RouteID"]."&userID=".$_GET["userID"]."\">";
					//echo "<p class=\"ui-li-aside ui-li-desc\"><strong>".$row["Distance"]."</strong> mi<br>".$diffLabel."</p>";
					//echo "<h3>".$row["Name"]."</h3>";
				//echo "</a>";
			echo "</li>";
  		}
	echo "</ul>";

	?>

</body>
</html>