<?php
	session_start();
	include_once('inc/global.php');
	$endTime = time() - 1800;
	$_SESSION['abaUser'] = "";
	session_destroy();
	unset($_COOKIE['ulvl']);
	setcookie('ulvl', '', $endTime, '/');
	header("Location: " . hris_URL .'login/login.php');
	exit();
?>