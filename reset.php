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
	<h1 class="title">Reset database</h1>
     <div class="form">
      <form action="reset.php" method="post">
      <input type="text" id="reset" name="reset" required="required" placeholder="Enter reset database in capital letters">
    <input type="submit" value="Reset database">
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
    $pass = $_POST['reset'];  
    $currentUser = strtolower($_SESSION['username']);
	if ($currentUser==='edmzurmati' || $currentUser==='arifullah') {
      if ($pass ==='RESET DATABASE') {
		$op1 = mysqli_query($conn,"SELECT * FROM payable");
		while($row = mysqli_fetch_array($op1)) {
		  $name = $row['name'];
		  $sql = "DROP table `$name`";
		  mysqli_query($conn, $sql);
		}
	    $op2 = mysqli_query($conn,"SELECT * FROM customers");
		while($row = mysqli_fetch_array($op2)) {
		  $name = $row['customer_name'];
		  $sql = "DROP TABLE `$name`";
		  mysqli_query($conn, $sql);
		  
		}
		$op3 = mysqli_query($conn,"SELECT * FROM capital");
		while($row = mysqli_fetch_array($op3)) {
		  $name = $row['location'];
		  $sql = "DROP TABLE `$name`";
		  mysqli_query($conn, $sql);
		  
		}
		$op4 = "TRUNCATE stock";
		mysqli_query($conn, $op4);
		$op5 = "TRUNCATE sales";
		mysqli_query($conn, $op5);
		$op6 = "TRUNCATE purchase";
		mysqli_query($conn, $op6);
		$op7 = "TRUNCATE capital";
		mysqli_query($conn, $op7);
		$op8 = "TRUNCATE payable";
		mysqli_query($conn, $op8);
		$op9 = "TRUNCATE customers";
		mysqli_query($conn, $op9);
		$op10 = "TRUNCATE log";
		mysqli_query($conn, $op10);
		$op11 = "UPDATE `home` SET `budget`= 0,`due`= 0,`stock`= 0,`equity`= 0,`pay`= 0 WHERE 1";
		mysqli_query($conn, $op11);
	    logger('Database reset!');
	    header('location: home.php');
	   } else {
		  echo 'Passphrase is incorrect!';
	   }
		
		
	} else {
		echo "<h1>You are not an administrator</h1>";
	}
}
?>
</body>
</html>