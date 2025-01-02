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
	<h1 class="title">Change Password</h1>
     <div class="form">
      <form action="change.php" method="post">
      <input type="password" id="oldp" name="oldp" required="required" placeholder="Enter your old password">
      <input type="password" id="newp" name="newp" required="required" placeholder="Enter your new password">
    <input type="submit" value="Change password">
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
    $oldP = $_POST['oldp'];  
    $newP = $_POST['newp'];  
    $userN = $_SESSION['username'];
        $sql = "select password from login where username = '$userN' and password = '$oldP'";  
        $result = mysqli_query($conn, $sql);
		$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
        $count = mysqli_num_rows($result);  

                            
        if($count == 1){
			// Password is correct, so start change password
			$sql2 = "UPDATE login SET password = '$newP' WHERE username = '$userN'";
			mysqli_query($conn, $sql2);
			logger('Changed his password');
			header('location: home.php');
        }  
        else{  
            echo "<h1> Password change failed. Old password is incorrect</h1>";
            logger('Password change failed');
        }
}
?>
</body>
</html>