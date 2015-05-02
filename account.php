<?php
session_start();

if(!isset($_SESSION['user']))
{
	header("LOCATION:login.php");
}

?>

