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
	<h1 class="title">Run Query</h1>
     <div class="form">
      <form action="query.php" method="post">
      <input type="text" id="query" name="query" required="required" placeholder="Enter your query">
    <input type="submit" value="Run">
     </form>
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
    $query = $_POST['query'];  
    $currentUser = strtolower($_SESSION['username']);
	if ($currentUser==='edmzurmati' || $currentUser==='arifullah') {
		$sql = mysqli_query($conn, $query);
		$result = mysqli_fetch_array($sql);
		echo '<pre> ' . var_dump($result) . '</pre></div>';
		logger('Run query: ' . $query);
	} else {
		echo "<h1>You are not an administrator</h1>";
	}
}
?>
</body>
</html>