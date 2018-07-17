<?php
/*******************************************************************************************************************************************/
	//phpmyadmin
	$servername = "localhost";
	$username = "root";
	$password = "";
	$dbname ="guru";//In some web server (Actually in sub domain),specified database name need to br manully created in phpmyadmin section
	$timeout=45;//in seconds
	$number_of_quetions=5;
/*******************************************************************************************************************************************/
$conn = new mysqli($servername, $username, $password);
	if ($conn->connect_error)
	{
		die("Connection failed: " . $conn->connect_error);
	}
	$sql = "create database $dbname";
	$conn->query($sql);
	$conn->close();
?>