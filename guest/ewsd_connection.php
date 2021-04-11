<?php
	define("SERVERNAME", "localhost");
	define("USERNAME", "root");
	define("PASSWORD", "");
	define("DATABASENAME", "ewsd");
	

	// Create connection
	$db = new mysqli(SERVERNAME, USERNAME, PASSWORD,DATABASENAME);

	// Check connection
	if ($db->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	} 

	// Create connection
	$conn = new mysqli(SERVERNAME, USERNAME, PASSWORD,DATABASENAME);

	// Check connection
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	} 
?>
