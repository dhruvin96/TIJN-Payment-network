<?php
	define('DB_HOST', 'localhost');
	define('DB_NAME', 'cs631');
	define('DB_USER','root');
	define('DB_PASSWORD','');
 
	$con=mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD) or die("Failed to connect to Server: " . mysql_error());
	$db=mysqli_select_db($con,DB_NAME) or die("Unable to reach database:" . mysql_error());
?>