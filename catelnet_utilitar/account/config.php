<?php

	// Connect to database
	$servername = "localhost";
	$username = "root";
	$password = "";
	$dbname = "catelnet";

	$conn = new mysqli($servername, $username, $password, $dbname);
	if ($conn->connect_error) 
		die("Connection failed .");
?>