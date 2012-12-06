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
	<style>
	h3{
		font-variant: inherent;
		margin-top: -10px;	
	}
	
	.toptitle{
		margin-top: 5px;	
	}
	
	.bottomtitle{
		margin-top: 35px;	
	}
	</style>
	<div data-role="content">	
	
	<div class="toptitle"><h3>Friends you're following: </h3></div>
	<table> 
				<?php
				include("config.php");
				$query = sprintf("select ID2 from Friends where ID1 = %s", $_SESSION['userID']);
				echo "<ul data-inset=\"true\" data-role=\"listview\" data-filter-placeholder=\"Search users...\" data-filter=\"true\" data-theme=\"b\">";
				$result = mysql_query($query);
				while($row2 = mysql_fetch_array($result))
		  		{
		  			$query2 = sprintf("select Name, UserID from Users where UserID = %s", $row2['ID2']);
		  			$result2 = mysql_query($query2);
		  			while($row = mysql_fetch_array($result2))
		  			{
				  		echo "<li data-corners=\"false\" data-icon=\"arrow-r\" data-iconpos=\"right\" data-theme=\"c\">";
							echo "<a href=\"removeFriend.php?userID=" . $_SESSION['userID'] . "&friendID=" . $row['UserID'] . "\">";
								echo "<p class=\"ui-li-aside ui-li-desc\"><strong>Unfollow <br>User</strong>".$diffLabel."</p>";
								echo "<h3>   ".$row["Name"]."</h3>";
							echo "</a>";
						echo "</li>";

		  			}
		  		}
		  		echo "</ul>";
				?>
	</table> 		
	<?php
	echo "<a data-mini=\"true\" data-role=\"button\" href=\"newChallenge.php?userID=" . $_SESSION['userID'] . "\">Challenge a Friend!</a>";
	?>
	
	<div class="bottomtitle"><h3> Users you're not following: </h3></div>
	<table> 
				<?php
				include("config.php");
				$query = sprintf("select distinct UserID, Name from Users where not exists (select ID2 from Friends where ID1 = %s and UserID = ID2) and UserID <> %s", $_SESSION['userID'], $_SESSION['userID']);
				echo "<ul data-inset=\"true\" data-role=\"listview\" data-filter-placeholder=\"Search users...\" data-filter=\"true\" data-theme=\"b\">";

				$result = mysql_query($query);
				while($row = mysql_fetch_array($result))
		  		{
			  		echo "<li data-corners=\"false\" data-icon=\"arrow-r\" data-iconpos=\"right\" data-theme=\"c\">";
						echo "<a href=\"addFriend.php?userID=" . $_SESSION['userID'] . "&friendID=" . $row['UserID'] . "\">";
							echo "<p class=\"ui-li-aside ui-li-desc\"><strong>Follow <br>User</strong>".$diffLabel."</p>";
							echo "<h3>   ".$row["Name"]."</h3>";
						echo "</a>";
					echo "</li>";
		  		}
		  		echo "</ul>";

				?>
				
		
		</table> 
	    
	    

		</form>

		
	</div><!-- /content -->

</div><!-- /page -->

</body>
</html>