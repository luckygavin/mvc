<?php 	/* This is my mvc entry */
	//include的顺序不能变
	include('config.php');
	include('mvc/CController.php');
	include('mvc/Model.php');
	include 'controller.php';
	include 'mvc/Urls.php';
	$action = new Urls($_SERVER['PHP_SELF']);
	//$action = new Urls('http://localhost/mvctest/index.php/index');
	$action->run();
?>