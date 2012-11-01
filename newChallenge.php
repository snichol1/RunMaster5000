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
		<h1>Challenge</h1>
		<a href="goals.php" data-icon="back" data-rel="back" data-add-back-btn="true">Back</a>
	</div><!-- /header -->

	<div data-role="content">	
	
<form action="addNewChallenge.php" method = "post">
Select a friend: 
	<select name="friendList">
	<?php
		include("config.php");
		$query = sprintf("select * from Friends, Users where Users.UserID = Friends.ID2 and Friends.ID1='%s'", "2");
		$result = mysql_query($query);
		while($row = mysql_fetch_array($result))
  		{
			echo "<option value = "; 
  			echo $row['ID2']; 
  			echo ">"; 
  			echo $row['Name']; 
  			echo "</option>"; 
  		}
	?> 
	</select>
Select a personal best: 
	<select name="runList">
	<?php
		include("config.php");
		$query = sprintf("select * from Routes, Records where Records.UserID = '%s' and Records.RouteID = Routes.RouteID", "2");
		$result = mysql_query($query);
		while($row = mysql_fetch_array($result))
  		{
			echo "<option value = "; 
  			echo $row['RouteID']; 
  			echo ">"; 
  			echo $row['Name'] . " in " . $row['Time']; 
  			echo "</option>"; 
  		}
	?> 
	</select>	
	<br/> 
	<input type="submit" value = "Submit">
</form>




 </div><!-- /content -->

</div><!-- /page -->

</body>
</html>