<?php
	$db_user = 'optical';
	$db_pass = 'optical';
	$host = 'localhost';
	/******************************************************/
	$db_conn = mysqli_connect($host, $db_user, $db_pass);
	if (!$db_conn){
		die('Could not connect: ' . mysqli_error($db_conn));
	}
	
	/******************************************************/
	// select the desired database
	$db_name= "optical";
	$db_select = mysqli_select_db($db_conn,$db_name);
	if (!$db_select){
		die('Database selection failed: ' . mysql_error());
	}
	
	/******************************************************/	
	mysqli_query($db_conn,"SET NAMES 'utf8'");
	
?>