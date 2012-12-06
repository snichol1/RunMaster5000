<?php
session_start();
?>

<!DOCTYPE html>
<html>
<head>
	<title>Search</title> 
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1"> 
	<link rel="stylesheet" href="themes/blue.css" />
	<link rel="stylesheet" href="http://code.jquery.com/mobile/1.2.0/jquery.mobile.structure-1.2.0.min.css" /> 
	<script src="http://code.jquery.com/jquery-1.7.2.min.js"></script> 
	<script src="http://code.jquery.com/mobile/1.2.0/jquery.mobile-1.2.0.min.js"></script>  
	<script src="js/search.js"></script>
	
	<link rel="stylesheet" type="text/css" href="style.css">
	<link rel="stylesheet" type="text/css" href="searchstyle.css">
	
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
	
	#search{
		color: white;
		background: black;
		height: 40px;
		width: 100px;
		text-align: center;
	}

	.distspecify{
		font-size: 10px;	
	}
	
	#selectedDist{
		margin-left: auto;
		margin-right: auto;
	}
	
	#name{
		margin-right: 10px;
	}
	
	#distance{
		margin-right: 10px;
	}
	
	#difficulty{
		margin-right: 10px;
	}
	
	.headtitle{
		font-size: 20px;
		font-family: "Arial";
		margin-bottom: 0px;
		margin-top: -10px;
		margin-left: auto;
		margin-right: auto;
	}
		
	.headtitlebottom{
		font-size: 20px;
		font-family: "Arial";
		margin-bottom: 5px;
		margin-top: 20px;
		margin-left: auto;
		margin-right: auto;	
	}
</style>

<div data-role="header">
	<h1 class="text">Filter</h1>
	
	<a href="searchresults.php?mysubmit=Search!" data-icon="back" data-rel="back" data-add-back-btn="true">Back</a>
</div><!-- /header -->
	
<div data-role="content">	

<?php echo "<form action=\"searchresults.php?userID=" . $_GET['userID'] . "\" id=\"searchform\" method=\"get\">" ?>

<form action="searchresults.php" id="searchform" method="get">
	<!---// Location Entry
	<div data-role="fieldcontain">
	    <label for="name">Location:</label>
	    <input type="text" name="location" id="location" value=""  />
	</div>	---->
	
	<!--- Hides the text field because of mofified design. -->
	<script type="text/javascript"> 
	$(document).ready(function(){
	       $(".routenamefield").hide();	 
	});
	</script>

	
	<div class="routenamefield" data-role="fieldcontain" hidden=tu>
	    <label for="name" hidden=true><b>Route Name:</b></label>
	    <input type="text" name="name" id="name" value="optional"  />
	</div>	
	
	<!--- Distance Selector ---->
	    <div id="distanceselector" data-role="">
	        <fieldset data-role="controlgroup" data-type="horizontal">
	            <legend>
	                <div class="headtitle">Distance:</div>
	            </legend>
	            <input id="shortdist" class="dist" name="shortdist" type="checkbox" onlick="displayDistance()"/>
	            <label for="shortdist">
	                Short
	                <div class="distspecify"> 0 - 2 mi</div>
	            </label>
	            <input id="mediumdist" class="dist" value="mediumdist" name="mediumdist" type="checkbox"/>
	            <label for="mediumdist" onlick="displayDistance()">
	                Medium
	                <div class="distspecify">2 - 5 mi</div>
	            </label>
	            <input id="longdist" class="dist" value="longdist" name="longdist" type="checkbox" />
	            <label for="longdist" onlick="displayDistance()">
	                Long
	                <div class="distspecify">5+ mi</div>
	            </label>
	        </fieldset>
	      <!---  <div class="selectedDist">No distances specified. <br> All distances will be searched.</div> --->
		</div>
		
		
	
	
	<!---- Difficulty Selector ----->
	    <div id="difficultyselector" data-role="">
	        <fieldset data-role="controlgroup" data-type="horizontal">
	            <legend>
	                <div class="headtitlebottom">Difficulty:</div>
	            </legend>
	            <input id="easydiff" class="diff" name="easydiff" type="checkbox"/>
	            <label for="easydiff">
	                Easy
	            </label>
	            <input id="mediumdiff" class="diff" name="mediumdiff" type="checkbox"/>
	            <label for="mediumdiff">
	                Medium
	            </label>
	            <input id="harddiff" class="diff" name="harddiff" type="checkbox" />
	            <label for="harddiff">
	                Hard
	            </label>
	        </fieldset>
	        <!--- <div class="selectedDiff">No difficulties specified. <br> All difficulties will be searched.</div> --->
	      </div>
	<br>
	<input type="submit" name="mysubmit" value="Search!" />
	
</form>
</div>
</div>

	<script type="text/javascript">
		var shortSelected = true;
		var medSelected = true;
		var longSelected = true;
		
		$(".dist").click(function() {
			
			if($('input[name=shortdist]').is(':checked') && $('input[name=mediumdist]').is(':checked') && $('input[name=longdist]').is(':checked') ){
				$(".selectedDist").html("Search: <b>All Distances</b>");
			}
			else if( (!$('input[name=shortdist]').is(':checked') && !$('input[name=mediumdist]').is(':checked') && !$('input[name=longdist]').is(':checked'))){
				$(".selectedDist").html("No distances specified. <br> All distances will be searched.");
			}
			else{
				var outputStr = "Search: <b>";

				if($('input[name=shortdist]').is(':checked')){
					outputStr += "Short, "	
				}
				if($('input[name=mediumdist]').is(':checked')){
					outputStr += "Medium, "	
				}
				if($('input[name=longdist]').is(':checked')){
					outputStr += "Long, "	
				}
				outputStr = outputStr.substring(0, outputStr.length-2);
				$(".selectedDist").html(outputStr + "</b>");
			}
			
		});
		
		
		$(".diff").click(function() {
			
			if($('input[name=easydiff]').is(':checked') && $('input[name=mediumdiff]').is(':checked') && $('input[name=harddiff]').is(':checked') ){
				$(".selectedDiff").html("Search: <b>All Difficulties</b>");
			}
			else if( (!$('input[name=easydiff]').is(':checked') && !$('input[name=mediumdiff]').is(':checked') && !$('input[name=harddiff]').is(':checked'))){
				$(".selectedDiff").html("No difficulties specified. <br> All difficulties will be searched.");
			}
			else{
				var outputStr = "Search: <b>";

				if($('input[name=easydiff]').is(':checked')){
					outputStr += "Easy, "	
				}
				if($('input[name=mediumdiff]').is(':checked')){
					outputStr += "Medium, "	
				}
				if($('input[name=harddiff]').is(':checked')){
					outputStr += "Hard, "	
				}
				outputStr = outputStr.substring(0, outputStr.length-2);
				$(".selectedDiff").html(outputStr + "</b>");
			}
			
		});
		
			</script>

</body>
</html> 