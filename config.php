<?php
$host = "mysql-user-master.stanford.edu";
$user = "ccs147thesam";
$pass = "biechaid";
$mysql_database = "c_cs147_thesam";

$link = mysql_connect($host, $user, $pass);
if (!$link) {
    die('Not connected : ' . mysql_error());
}

// Connect to the database
$db_selected = mysql_select_db($mysql_database, $link);
if (!$db_selected) {
    die ('Can\'t use to connect to database : ' . mysql_error());
}
?>