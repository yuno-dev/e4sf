<?php
	if(!isset($_SESSION["user_nick"])){
		session_start(); 
		ob_start();
		session_destroy();
		header("location: index.php");
	}
?>