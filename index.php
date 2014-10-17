<?php 	/* This is my mvc entry */
	include 'mvc/Urls.php';
	$action = new Urls($_SERVER['PHP_SELF']);
	//$action = new Urls('http://localhost/mvctest/index.php/index');
	$action->run();
?>