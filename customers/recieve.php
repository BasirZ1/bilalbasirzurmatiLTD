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
	$customer = $_POST['customer_name'];
    $a = $_POST['date'];
	$b = $_POST['details'];
	$amount = $_POST['amount'];
	$sqlCustomer = "SELECT customer_name FROM customers where customer_name='$customer'";
	$sqlCustomer2 = mysqli_query($conn, $sqlCustomer);
  	$customerName = mysqli_fetch_array($sqlCustomer2);
if ($customer===$customerName['customer_name']) {
		$sql2 = "INSERT INTO `$customer` (date, details, paid) VALUES ('$a', '$b', $amount)";
		mysqli_query($conn, $sql2);
		$sql3 = "SELECT due FROM `$customer` WHERE id=(SELECT MAX(id) FROM `$customer` WHERE id NOT IN (SELECT MAX(id) FROM `$customer`))";
		$t = mysqli_query($conn, $sql3);
		$t2 = mysqli_fetch_array($t);
		$t3 = floatval($t2['due']);
		$t4 = $t3 - $amount;
		$sql4 ="UPDATE `$customer` SET due = $t4 WHERE id=(SELECT max(id) FROM `$customer`)";
		mysqli_query($conn, $sql4);
		$sql5 = "UPDATE customers SET amount = $t4 WHERE customer_name = '$customer'";
		mysqli_query($conn, $sql5);
		echo('<h3 style="color:green;">Amount recieved successfully</h3>');
		logger($amount . ' recieved from ' . $customer);
	} else {
		echo('<h3 style="color:red;">Customer does not exit</h3>');
	}
}
?>
<!--PHP END -->
<!--<div class="top"><h1 class="title">Bilal Basir Zurmati Co ltd</h1></div>-->
<div class="main">           
     <div class="topnav" id="myTopnav">
      <a href="../home.php">Home</a>
      <a href="../capital/">Capital</a> 
      <a href="../purchase.php">Purchase Register</a>
      <a href="../stock.php">Stock</a>
      <a href="../sale.php">Sales Register</a>
      <a href="../entry1.php">Sales Entry</a>
      <a href="../entry2.php">Purchase Entry</a>
      <a class="active" href="index.php">Customers</a>
      <a href="../payable/">Accounts payable</a>
      <a href="../roznamcha/">Roznamcha</a>
	<a href="javascript:void(0);" class="icon" onclick="myFunction()">
		  <i class="fa fa-bars"></i></a>
	<a href="../logout.php"><i class="fa fa-sign-out"></i></a>
	</div>
<!--Side Bar-->
<div class="side">
<a class="sidebutton" href="index.php">Overview</a>
<a class="sidebutton" href="recieve.php">Recieve amount</a>
</div>
<!--Side Bar End-->    

     <h2 class="table_title">Recieve amount</h2>
     <div class="form">
      <form action="recieve.php" method="post">
    <label for="customer_name">Customer Name</label>
          <!--AA-->
       <select id="customer_name" name="customer_name" required>
  	    <?php 
		  $result = mysqli_query($conn,"SELECT customer_name FROM customers");
		  while($row = mysqli_fetch_array($result)) {
		    echo "<option value='" . $row['customer_name'] . "'>" . $row['customer_name'] . "</option>";
		  }
		?>
	  </select><!--ZZ-->
    <label for="details">Details</label>
      <input type="text" id="details" name="details" required="required" placeholder="Details">
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