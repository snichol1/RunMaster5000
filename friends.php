<?php
session_start();
?>


<!DOCTYPE html> 
<html> 
<head> 
	<title>RunMaster 5000</title> 
	<meta charset="utf-8" />
  	<meta name="viewport" content="width=device-width, initial-scale=1">
 	 <link rel="stylesheet" href="themes/blue.css" />
  	<link rel="stylesheet" href="http://code.jquery.com/mobile/1.2.0/jquery.mobile.structure-1.2.0.min.css" /> 
  	<script src="http://code.jquery.com/jquery-1.7.2.min.js"></script> 
  	<script src="http://code.jquery.com/mobile/1.2.0/jquery.mobile-1.2.0.min.js"></script> 

</head> 
<body> 

<div data-role="page">

	<div data-role="header">
		<h1>Friends</h1>
		<a href="home.php?userID=<?php echo $_SESSION['userID']?>" data-icon="home" id="home" class="ui-btn-left">Home</a>



	</div><!-- /header -->

	<div data-role="content">	
	
	<h3> Friends you're following: </h3> 
	<table> 
				<?php
				include("config.php");
				$query = sprintf("select ID2 from Friends where ID1 = %s", $_SESSION['userID']);

				$result = mysql_query($query);
				while($row2 = mysql_fetch_array($result))
		  		{
		  			$query2 = sprintf("select Name, UserID from Users where UserID = %s", $row2['ID2']);
		  			$result2 = mysql_query($query2);
		  			while($row = mysql_fetch_array($result2))
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
		  		}
				?>
	</table> 		
		
	<h3> Friends you're not following: </h3> 
	<table> 
				<?php
				include("config.php");
				$query = sprintf("select distinct UserID, Name from Users where not exists (select ID2 from Friends where ID1 = %s and UserID = ID2) and UserID <> %s", $_SESSION['userID'], $_SESSION['userID']);

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