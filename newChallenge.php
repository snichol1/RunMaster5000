<?php
session_start();
?>


<!DOCTYPE html> 
<html> 
<head> 
	<title>New Goal</title> 
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="themes/blue.css" />
		<link rel="stylesheet" href="http://code.jquery.com/mobile/1.2.0/jquery.mobile.structure-1.2.0.min.css" /> 
		<script src="http://code.jquery.com/jquery-1.7.2.min.js"></script> 
		<script src="http://code.jquery.com/mobile/1.2.0/jquery.mobile-1.2.0.min.js"></script>    
    
</head> 
<body> 

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
		<h1 class="text">Challenge</h1>
		<a href="goals.php" data-icon="back" data-rel="back" data-add-back-btn="true">Back</a>
	</div><!-- /header -->

	<div data-role="content">	
	
<?php echo "<form method=\"post\" action=\"addNewChallenge.php?userID=" . $_SESSION['userID'] . "\">"; ?> 

Select a friend: 
	<?php echo "<input type=\"hidden\" name=\"userID\" value = \"" . $_SESSION['userID'] . "\">"; ?> 
	<select name="friendList">
	<?php
		include("config.php");
		$query = sprintf("select * from Friends, Users where Users.UserID = Friends.ID2 and Friends.ID1='%s'", $_SESSION['userID']);
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
		$query = sprintf("select * from Routes, Records where Records.UserID = '%s' and Records.RouteID = Routes.RouteID", $_SESSION['userID']);
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