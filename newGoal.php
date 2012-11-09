<?php
session_start();
?>

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
		<h1>Set a Goal</h1>
        <a href="home.php" data-icon="back" data-rel="back" data-add-back-btn="true">Back</a>
	</div><!-- /header -->

	<div data-role="content">	
	<?php
		$routeID = $_GET['routeID'];
		$userID = $_GET['userID'];
		include("config.php");
		$RRecord;
		$PR;

		$query = sprintf("select * from Routes where RouteID='%s'", $routeID);
		$result = mysql_query($query);
		while($row = mysql_fetch_array($result))
  		{
  			echo "<h1>Set a goal for " . $row['Name'] . ":</h1>"; 
  		}

  		$goalsQuery = sprintf("SELECT Goals.UserID AS UserID, Users.Name AS Name, Time FROM Goals, Users WHERE Goals.AntagonistID = Users.UserID AND routeID=".$routeID." AND met=0 AND AntagonistID <> ".$userID." AND Goals.UserID=".$userID);
  		$goalsResult = mysql_query($goalsQuery);
  		$goalsRowCheck = mysql_num_rows($goalsResult);
  		if($goalsRowCheck > 0) {
  			while($row = mysql_fetch_array($goalsResult)) {
  				echo "<a href=\"newGoal.php?routeID=". $routeID . "&userID=" . $_GET['userID'] . "\" data-role=\"button\">" . $row['Name'] . "'s PR: " . $row['Time'] . "</a>";
  				//do something about transferring the data back...
  			}
  		}

  		$selfGoalQuery = sprintf("SELECT min(Time) as Time FROM Goals WHERE routeID=".$routeID." AND met=0 AND AntagonistID = ".$userID);
  		$selfGoalResult = mysql_query($selfGoalQuery);
  		$selfGoalRowCheck = mysql_num_rows($selfGoalResult);
  		if($selfGoalRowCheck > 0) {
  			while($row = mysql_fetch_array($selfGoalResult)) {
  				echo "<a href=\"newGoal.php?routeID=". $routeID . "&userID=" . $_GET['userID'] . "\" data-role=\"button\">Your goal: " . $row['Time'] . "</a>";
  				//do something about transferring the data back...
  			}
  		}

  		$PRQuery = sprintf("SELECT min(Time) as Time FROM Records WHERE RouteID = ".$routeID." AND UserID = ".$userID);
  		$PRResult = mysql_query($PRQuery);
  		while($row = mysql_fetch_array($PRResult)) {
  			$PR = $row['Time'];
  		}
  		if($PR != NULL) {
  			echo "<a href=\"newGoal.php?routeID=". $routeID . "&userID=" . $_GET['userID'] . "\" data-role=\"button\">Your PR: " . $PR . "</a>";

  		}
  		

  		$RRquery = sprintf("SELECT min(Time) AS Time FROM Records WHERE RouteID = " . $routeID);
  		$RRResult = mysql_query($RRquery);
  		$RRRowCheck = mysql_num_rows($RRResult);
  		if($RRRowCheck > 0) {
  			while($row = mysql_fetch_array($RRResult)) {
  				$RRecord = $row['Time'];
  				if($RRecord > $PR) {
  					echo "<a href=\"newGoal.php?routeID=". $routeID . "&userID=" . $_GET['userID'] . "\" data-role=\"button\">Route Record: " . $RRecord . "</a>";

  				}
  			}
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
<option value="04">04</option>
<option value="05">05</option>
<option value="06">06</option>
<option value="07">07</option>
<option value="08">08</option>
<option value="09">09</option>
<option value="10">10</option>
<option value="11">11</option>
<option value="12">12</option>
<option value="13">13</option>
<option value="14">14</option>
<option value="15">15</option>
<option value="16">16</option>
<option value="17">17</option>
<option value="18">18</option>
<option value="19">19</option>
<option value="20">20</option>
<option value="21">21</option>
<option value="22">22</option>
<option value="23">23</option>
<option value="24">24</option>
<option value="25">25</option>
<option value="26">26</option>
<option value="27">27</option>
<option value="28">28</option>
<option value="29">29</option>
<option value="30">30</option>
<option value="31">31</option>
<option value="32">32</option>
<option value="33">33</option>
<option value="34">34</option>
<option value="35">35</option>
<option value="36">36</option>
<option value="37">37</option>
<option value="38">38</option>
<option value="39">39</option>
<option value="40">40</option>
<option value="41">41</option>
<option value="42">42</option>
<option value="43">43</option>
<option value="44">44</option>
<option value="45">45</option>
<option value="46">46</option>
<option value="47">47</option>
<option value="48">48</option>
<option value="49">49</option>
<option value="50">50</option>
<option value="51">51</option>
<option value="52">52</option>
<option value="53">53</option>
<option value="54">54</option>
<option value="55">55</option>
<option value="56">56</option>
<option value="57">57</option>
<option value="58">58</option>
<option value="59">59</option>

</select>
Minutes: 
<select name="minutes">
<option value="00" selected = "selected">Minutes</option>
<option value="00">00</option>
<option value="01">01</option>
<option value="02">02</option>
<option value="03">03</option>
<option value="04">04</option>
<option value="05">05</option>
<option value="06">06</option>
<option value="07">07</option>
<option value="08">08</option>
<option value="09">09</option>
<option value="10">10</option>
<option value="11">11</option>
<option value="12">12</option>
<option value="13">13</option>
<option value="14">14</option>
<option value="15">15</option>
<option value="16">16</option>
<option value="17">17</option>
<option value="18">18</option>
<option value="19">19</option>
<option value="20">20</option>
<option value="21">21</option>
<option value="22">22</option>
<option value="23">23</option>
<option value="24">24</option>
<option value="25">25</option>
<option value="26">26</option>
<option value="27">27</option>
<option value="28">28</option>
<option value="29">29</option>
<option value="30">30</option>
<option value="31">31</option>
<option value="32">32</option>
<option value="33">33</option>
<option value="34">34</option>
<option value="35">35</option>
<option value="36">36</option>
<option value="37">37</option>
<option value="38">38</option>
<option value="39">39</option>
<option value="40">40</option>
<option value="41">41</option>
<option value="42">42</option>
<option value="43">43</option>
<option value="44">44</option>
<option value="45">45</option>
<option value="46">46</option>
<option value="47">47</option>
<option value="48">48</option>
<option value="49">49</option>
<option value="50">50</option>
<option value="51">51</option>
<option value="52">52</option>
<option value="53">53</option>
<option value="54">54</option>
<option value="55">55</option>
<option value="56">56</option>
<option value="57">57</option>
<option value="58">58</option>
<option value="59">59</option></select>
Seconds: 
<select name="seconds">
<option value="00" selected = "selected">Seconds</option>
<option value="00">00</option>
<option value="01">01</option>
<option value="02">02</option>
<option value="03">03</option>
<option value="04">04</option>
<option value="05">05</option>
<option value="06">06</option>
<option value="07">07</option>
<option value="08">08</option>
<option value="09">09</option>
<option value="10">10</option>
<option value="11">11</option>
<option value="12">12</option>
<option value="13">13</option>
<option value="14">14</option>
<option value="15">15</option>
<option value="16">16</option>
<option value="17">17</option>
<option value="18">18</option>
<option value="19">19</option>
<option value="20">20</option>
<option value="21">21</option>
<option value="22">22</option>
<option value="23">23</option>
<option value="24">24</option>
<option value="25">25</option>
<option value="26">26</option>
<option value="27">27</option>
<option value="28">28</option>
<option value="29">29</option>
<option value="30">30</option>
<option value="31">31</option>
<option value="32">32</option>
<option value="33">33</option>
<option value="34">34</option>
<option value="35">35</option>
<option value="36">36</option>
<option value="37">37</option>
<option value="38">38</option>
<option value="39">39</option>
<option value="40">40</option>
<option value="41">41</option>
<option value="42">42</option>
<option value="43">43</option>
<option value="44">44</option>
<option value="45">45</option>
<option value="46">46</option>
<option value="47">47</option>
<option value="48">48</option>
<option value="49">49</option>
<option value="50">50</option>
<option value="51">51</option>
<option value="52">52</option>
<option value="53">53</option>
<option value="54">54</option>
<option value="55">55</option>
<option value="56">56</option>
<option value="57">57</option>
<option value="58">58</option>
<option value="59">59</option>

<input type="hidden" name="userID" value = <?php echo $_SESSION['userID']?>>
<input type="hidden" name="routeID" value = <?php echo $_GET['routeid']?>>

</select>


<input type="submit" value="Submit">
</form>

 </div><!-- /content -->

</div><!-- /page -->

</body>
</html>