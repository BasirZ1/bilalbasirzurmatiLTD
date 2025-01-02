<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: ../index.php");
    exit;
}
?>
<!doctype html>
<html>
<head>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="../style.css">
<link rel="stylesheet" href="../table.css">
<meta charset="utf-8">
<title>Bilal Basir Zurmati Co ltd</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>
<!--PHP-->
<?php
require '../conn.php';
include '../log.php';
// Insert Data
if($_SERVER["REQUEST_METHOD"] == "POST") {
	$location = $_POST['location'];
    $a = $_POST['date'];
	$b = $_POST['details'];
	$option = $_POST['drcr'];
	$amount = $_POST['amount'];
	$sqlLocation = "SELECT location FROM capital where location='$location'";
	$sqlLocation2 = mysqli_query($conn, $sqlLocation);
  	$capitalLocations = mysqli_fetch_array($sqlLocation2);
if ($location===$capitalLocations['location']) {
	if($option==='dr') {
		$sql2 = "INSERT INTO `$location` (date, details, debit) VALUES ('$a', '$b', $amount)";
		mysqli_query($conn, $sql2);
		$sql3 = "SELECT total FROM `$location` WHERE id=(SELECT MAX(id) FROM `$location` WHERE id NOT IN (SELECT MAX(id) FROM `$location`))";
		$t = mysqli_query($conn, $sql3);
		$t2 = mysqli_fetch_array($t);
		$t3 =  floatval($t2['total']);
		$t4 = $t3 + $amount;
		$sql4 ="UPDATE `$location` SET total = $t4 WHERE id=(SELECT max(id) FROM `$location`)";
		mysqli_query($conn, $sql4);
		$sql5 = "UPDATE capital SET amount = $t4 WHERE location = '$location'";
		mysqli_query($conn, $sql5);
		echo('<h3 style="color:green;">Amount debited successfully</h3>');
		logger($amount . 'debited to' . $location);
	} else if($option==='cr') {
		$sql2 = "INSERT INTO `$location` (date, details, credit) VALUES ('$a', '$b', $amount)";
		mysqli_query($conn, $sql2);
		$sql3 = "SELECT total FROM `$location` WHERE id=(SELECT MAX(id) FROM `$location` WHERE id NOT IN (SELECT MAX(id) FROM `$location`))";
		$t = mysqli_query($conn, $sql3);
		$t2 = mysqli_fetch_array($t);
		$t3 = floatval($t2['total']);
		$t4 = $t3 - $amount;
		$sql4 = "UPDATE `$location` SET total = $t4 WHERE id=(SELECT max(id) FROM `$location`)";
		mysqli_query($conn, $sql4);
		$sql5 = "UPDATE capital SET amount = $t4 WHERE location = '$location'";
		mysqli_query($conn, $sql5);
		echo('<h3 style="color:red;">Amount credited successfully</h3>');
		logger($amount . 'credited to' . $location);
		
	}
} else {
	$createTable = "CREATE TABLE `$location` ( id INT NOT NULL AUTO_INCREMENT , date DATE NOT NULL , details VARCHAR(65) NOT NULL , debit DECIMAL(10,2) NOT NULL , credit DECIMAL(10,2) NOT NULL , total DECIMAL(10,2) NOT NULL , PRIMARY KEY (id)) ENGINE = InnoDB;";
	mysqli_query($conn, $createTable);
	if($option==='dr') {
		$sql2 = "INSERT INTO `$location` (date, details, debit, total) VALUES ('$a', '$b', $amount, $amount)";
		mysqli_query($conn, $sql2);
		$sql5 = "INSERT INTO capital (location, amount) VALUES ('$location', $amount)";
		mysqli_query($conn, $sql5);
		echo('<h3 style="color:green;">Amount debited successfully</h3>');
		echo('<h3 style="color:green;">New location added successfully</h3>');
		logger($amount . 'debited to' . $location);
	} else if($option==='cr') {
		$sql2 = "INSERT INTO `$location` (date, details, credit, total) VALUES ('$a', '$b', $amount, -$amount)";
		mysqli_query($conn, $sql2);
		$sql5 = "INSERT INTO capital (location, amount) VALUES ('$location', -$amount)";
		mysqli_query($conn, $sql5);
		echo('<h3 style="color:red;">Amount credited successfully</h3>');
		echo('<h3 style="color:red;">New location added successfully</h3>');
		logger($amount . 'credited to' . $location);
	}
}
}
?>
<!--PHP END -->
<!--<div class="top"><h1 class="title">Bilal Basir Zurmati Co ltd</h1></div>-->
<div class="main">      
     <div class="topnav" id="myTopnav">
      <a href="../home.php">Home</a>
      <a class="active" href="index.php">Capital</a> 
      <a href="../purchase.php">Purchase Register</a>
      <a href="../stock.php">Stock</a>
      <a href="../sale.php">Sales Register</a>
      <a href="../entry1.php">Sales Entry</a>
      <a href="../entry2.php">Purchase Entry</a>
      <a href="../customers/">Customers</a>
      <a href="../payable/">Accounts payable</a>
	  <a href="../roznamcha/">Roznamcha</a>
	<a href="javascript:void(0);" class="icon" onclick="myFunction()">
		  <i class="fa fa-bars"></i></a>
	<a href="../logout.php"><i class="fa fa-sign-out"></i></a>
	</div>
<!--Side Bar-->
<div class="side">
<a class="sidebutton" href="index.php">Overview</a>
<a class="sidebutton" href="entry.php">New Entry</a>
</div>
<!--Side Bar End-->  

     <h2 class="table_title">New Entry</h2>
     <div class="form">
      <form action="entry.php" method="post">
    <label for="location">Location</label>
      <!--AA-->
      <input list="llist" pattern="^(?! )[A-Za-z ]*(?<! )$" id="location" name="location" required="required" placeholder="location">
       <datalist id="llist">
  	    <?php 
		  $result = mysqli_query($conn,"SELECT location FROM capital");
		  while($row = mysqli_fetch_array($result)) {
		    echo "<option value='" . $row['location'] . "'>" . $row['location'] . "</option>";
		  }
		?>
	  </datalist><!--ZZ-->
    <label for="details">Details</label>
      <input type="text" id="details" name="details" required="required" placeholder="Details">
    <input type="radio" name="drcr" value="dr" checked> Debit<br>
  <input type="radio" name="drcr" value="cr"> Credit<br>
      <input type="number" step="0.01" name="amount" required="required" placeholder="Enter amount">
      <label for="date">Date</label>
      <input type="date" id="date" name="date" placeholder="Date" required="required">
    <input type="submit" value="Submit">
     </form>
	</div>
	</div>
	<script src="../res.js"></script>
</body>
</html>