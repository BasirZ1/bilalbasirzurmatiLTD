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
	<h1 class="title">Bilal Basir Zurmati Co ltd</h1>
     <div class="form">
      <form action="index.php" method="post">
      <input type="text" id="username" name="username" required="required" placeholder="Enter your username">
      <input type="password" id="password" name="password" required="required" placeholder="Enter your password">
    <input type="submit" value="Login">
     </form>
	</div>

	</div>
<!--PHP START-->
	<?php 
// Check login
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: home.php");
    exit;
}

require 'conn.php';
include 'log.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];  
    $password = $_POST['password'];  
      
        //to prevent from mysqli injection  
        $username = stripcslashes($username);  
        $password = stripcslashes($password);  
        $username = mysqli_real_escape_string($conn, $username);  
        $password = mysqli_real_escape_string($conn, $password);  
      
        $sql = "select password from login where username = '$username' and password = '$password'";  
        $result = mysqli_query($conn, $sql);  
        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);  
        $count = mysqli_num_rows($result);  

                            
        if($count == 1){
			// Password is correct, so start a new session
            session_start();
                            
            // Store data in session variables
            $_SESSION["loggedin"] = true;
            $_SESSION["username"] = $username;  
            logger('logged in successfully');
            header("location: home.php");
        }  
        else{  
            echo "<h1> Login failed. Invalid username or password.</h1>";  
            logger('login failed');
        }
}
?>
</body>
</html>