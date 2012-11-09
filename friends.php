<?php
session_start();
?>


<!DOCTYPE html> 
<html> 
<head> 
	<title>RunMaster 5000</title> 
	<meta name="viewport" content="width=device-width, initial-scale=1"> 
	<link rel="stylesheet" href="http://code.jquery.com/mobile/1.2.0/jquery.mobile-1.2.0.min.css" />
	<link rel="stylesheet" href="friends" />
	<script src="http://code.jquery.com/jquery-1.8.2.min.js"></script>
	<script src="http://code.jquery.com/mobile/1.2.0/jquery.mobile-1.2.0.min.js"></script>
</head> 
<body> 

<div data-role="page">

	<div data-role="header">
		<h1>RunMaster 5000</h1>
		<a href="home.php" data-icon="back" id="home" class="ui-btn-left">Home</a>



	</div><!-- /header -->

	<div data-role="content">	
	
	<h3> Friends you're following: </h3> 
	<table> 
				<?php
				include("config.php");
				$query = sprintf("select Users.UserID, Users.Name from Users, Friends where Friends.ID2 = Users.UserID and Friends.ID1 = '%s' and Friends.isConnected = 'true'", $_SESSION['userID']);

				$result = mysql_query($query);
				while($row = mysql_fetch_array($result))
		  		{
			  		echo "<tr>"; 
			  		echo "<td>"; 
			  		echo $row['Name']; 
			  		echo "</td>"; 
			  		echo "<td>"; 
			  		echo "<form action=\"removeFriend.php?userID=" . $_SESSION['userID'] ."\" method=\"post\"> <input type=\"hidden\" name=\"username\" id=\"foo\" value = "; 
			  		echo $row['Name']; 
			  		echo "> "; 
			  		echo "<input type=\"hidden\" name=\"friendID\" id=\"foo\" value = "; 
			  		echo $row['UserID']; 
			  		echo ">"; 
			  		echo "<input type=\"submit\" value="; 
			  		echo "Unfollow"; 
			  		echo "> </form>";
			  		echo "</td>"; 
			  		echo "<tr>"; 
		  		}
				?>
	</table> 		
		
	<h3> Friends you're not following: </h3> 
	<table> 
				<?php
				include("config.php");
				$query = sprintf("select distinct Users.UserID, Users.Name from Users, Friends where Friends.ID2 = Users.UserID and Friends.ID1 = '%s' and Friends.isConnected = 'false'", $_SESSION['userID']);

				$result = mysql_query($query);
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
		  		}
				?>
				
		
		</table> 
	    
	    

		</form>

		
	</div><!-- /content -->

</div><!-- /page -->

</body>
</html>