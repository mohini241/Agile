<?php
	$db = mysqli_connect('localhost', 'root', '', 'agile');
 
	if(!$db){
		die("Error: Failed to connect to database!");
	}
?>