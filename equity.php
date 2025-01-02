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
	<h1 class="title">Update Owner equity</h1>
     <div class="form">
      <form action="equity.php" method="post">
      <input type="number" step="0.01" id="equity" name="equity" required="required" placeholder="Enter equity amount">
    <input type="submit" value="Change equity">
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
    $equity = $_POST['equity'];  
    $currentUser = strtolower($_SESSION['username']);
	if ($currentUser==='edmzurmati' || $currentUser==='arifullah') {
       $sql = "UPDATE home SET equity = $equity";
		mysqli_query($conn, $sql);
		logger('Equity updated: ' . $equity);
		header('location: home.php');
	} else {
		echo "<h1>You are not an administrator</h1>";
	}
}
?>
</body>
</html>