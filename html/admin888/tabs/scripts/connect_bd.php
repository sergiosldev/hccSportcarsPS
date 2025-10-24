<?php
	include_once(dirname(__FILE__)."/conf/bd_settings.php");                                 
	include_once(dirname(__FILE__)."/conf/settings.php");                                                                      
	//$conn = mssql_connect($dbHost,$dbUser,$dbPass)or die ("No conecta con SQLSERVER");      
	$conndb = new Db();                          
	$conndb->dbHost = $dbHost;
	$conndb->dbDatabase = $dbDatabase;   
	$conndb->dbUser = $dbUser;
	$conndb->dbPass = $dbPass;
	$conndb->connect();
	$conn=$conndb->dbConn; 
?> 