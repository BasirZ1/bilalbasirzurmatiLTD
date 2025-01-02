<!doctype html>
<html>
<head>
<link rel="stylesheet" href="style.css">
<link rel="stylesheet" href="login.css">
<meta charset="utf-8">
<title>Bilal Basir Zurmati Co ltd</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>
<div class="log">
	<h1 class="title">Register a new user</h1>
     <div class="form">
      <form action="signup.php" method="post">
      <input type="text" id="username" name="username" required="required" placeholder="Enter a username">
      <input type="password" id="password" name="password" required="required" placeholder="Enter a password">
    <input type="submit" value="Create new user">
     </form>
	</div>

	</div>
<!--PHP START-->
	<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: index.php");
    exit;
}
require 'conn.php';
include 'log.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];  
    $password = $_POST['password'];  
    $currentUser = strtolower($_SESSION['username']);
	if ($currentUser==='edmzurmati' || $currentUser==='arifullah') {
       $sql = "INSERT INTO login (username, password) VALUES ('$username', '$password')";
		mysqli_query($conn, $sql);
		logger('New user created: ' . $username);
		header('location: home.php');
	} else {
		echo "<h1>You are not an administrator</h1>";
	}
}
?>
</body>
</html>