<?php 
$hostname = "localhost";
$username = "root";
$password = "";
$dbname = "tinyurl";
$link = mysqli_connect($hostname, $username, $password);
mysqli_select_db($link, $dbname) or die("Unknown database!");

?>