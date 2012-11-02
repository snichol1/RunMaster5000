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
		<h1>Add New Goal</h1>
                <a href="home.php" data-icon="back" data-rel="back" data-add-back-btn="true">Back</a>
	</div><!-- /header -->

	<div data-role="content">	
	<?php
		$runNumber = $_GET['routeid'];
		include("config.php");
		$query = sprintf("select * from Routes where RouteID='%s'", $runNumber);
		$result = mysql_query($query);
		while($row = mysql_fetch_array($result))
  		{
  			echo "Set a new goal for " . $row['Name']; 
  		}


	?> 
	


<form name="input" action="addNewGoal.php" method="get">
Hours: 
<select name="hours">
<option value="00" selected = "selected">Hours</option>
<option value="00">00</option>
<option value="01">01</option>
<option value="02">02</option>
<option value="03">03</option>
</select>
Minutes: 
<select name="minutes">
<option value="00" selected = "selected">Minutes</option>
<option value="00">00</option>
<option value="01">01</option>
<option value="02">02</option>
<option value="03">03</option>
</select>
Seconds: 
<select name="seconds">
<option value="00" selected = "selected">Seconds</option>
<option value="00">00</option>
<option value="01">01</option>
<option value="02">02</option>
<option value="03">03</option>

<input type="hidden" name="userID" value = <?php echo $_GET['userID']?>>
<input type="hidden" name="routeID" value = <?php echo $_GET['routeid']?>>

</select>


<input type="submit" value="Submit">
</form>

 </div><!-- /content -->

</div><!-- /page -->

</body>
</html>