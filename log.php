<?php

function logger (string $log_action) {
require 'conn.php';
	date_default_timezone_set("Asia/Kabul");
	$date = date("Y-m-d H:i:s");
	if(!empty($_SERVER['REMOTE_ADDR'])) {
	$ip = $_SERVER['REMOTE_ADDR'];
	}
	if(!empty($_SESSION["username"])) {
	$username = $_SESSION["username"];
	}
	$logger = "INSERT INTO log (`date`,`ip`,`username`,`action`) values ('$date','$ip', '$username', '$log_action')";
	mysqli_query($conn, $logger);
}