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
<!--Side Bar-->
<div class="side">
<a class="sidebutton" href="rem.php">Remove record</a>
</div>
<!--Side Bar End--> 
	<h1 class="title">Empty a table</h1>
     <div class="form">
      <form action="rem1.php" method="post">
       <label for="rec" style="margin-left: 7rem">Table name:</label>
        <select id="rec" name="rectype">
          <option value="expense">Expense</option>
          <option value="profit">Profit</option>
          <option value="sales">Sales register</option>
          <option value="purchase">purchase register</option>	
        </select>
    <input type="submit" value="Empty table">
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
    $rectype = $_POST['rectype'];
    $currentUser = strtolower($_SESSION['username']);
	if ($currentUser==='edmzurmati' || $currentUser==='arifullah') {
			$sql2 = "TRUNCATE `$rectype`";
			mysqli_query($conn, $sql2);
			logger($rectype . ' table emptied!');
	    	header('location: home.php');
	} else {echo '<h2>You are not an administrator!</h2>';}
}
?>
</body>
</html>