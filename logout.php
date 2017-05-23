<?php
	session_start();
	if(!isset($_SESSION['userSession'])){
		header("Location: Home.php");
	}
	else if(isset($_SESSION['userSession'])!=""){
		header("Location: Home.php");
	}
	
	if(isset($_GET['logout'])){
		session_destroy();
		unset($_SESSION['userSession']);
		header("Location: Signin.php");
	}
?>