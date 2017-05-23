<?php
	$DBHost= "localhost";
	$DBUser = "root";
	$DBPass = "";
	$DBName = "test";
	
	$DBcon= new MySQLi($DBHost,$DBUser,$DBPass,$DBName);
	
	if($DBcon->connect_errno){
		die("Error: ".$DBCon->connect_error);
	}

?>
