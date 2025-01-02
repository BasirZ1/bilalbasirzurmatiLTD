<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: index.php");
    exit;
}
?>
<!doctype html>
<html>
<head>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="style.css">
<link rel="stylesheet" href="table.css">
<meta charset="utf-8">
<title>Bilal Basir Zurmati Co ltd</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>
<!--<div class="top"><h1 class="title">Bilal Basir Zurmati Co ltd</h1></div>-->
<div class="main">      
    <div class="topnav" id="myTopnav">
      <a href="home.php">Home</a> 
      <a href="capital/index.php">Capital</a>  
      <a class="active" href="purchase.php">Purchase Register</a> 
      <a href="stock.php">Stock</a> 
      <a href="sale.php">Sales Register</a> 
      <a href="entry1.php">Sales Entry</a> 
      <a href="entry2.php">Purchase Entry</a> 
      <a href="customers/">Customers</a>
      <a href="payable/">Accounts payable</a> 
	  <a href="roznamcha/">Roznamcha</a>
      <a href="javascript:void(0);" class="icon" onclick="myFunction()">
		  <i class="fa fa-bars"></i></a>
	  <a href="logout.php"><i class="fa fa-sign-out"></i></a>
	</div>
      <?php
require 'conn.php';
require 'log.php';
	//For transfering purchase to stock
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$a = $_POST['invoice_no'];
	$b = $_POST['product_name'];
	$c = $_POST['quantity'];
	$e = $_POST['price'];
	$f = $c*$e;
	$sql2 = "SELECT product_name FROM `stock` WHERE product_name ='$b'";
	$p = mysqli_query($conn, $sql2);
	$row = mysqli_fetch_array($p);
	if (is_null($row)){
		$sql3 = "INSERT INTO stock (product_name, quantity, price, total) VALUES ('$b', '$c', '$e', '$f')";
		mysqli_query($conn, $sql3);
		echo('<h4 style="color:green;">New product added to stock</h4>');
		logger($c . ' amount of ' . $b . 'added to stock');
	} else {
		$sql4 ="UPDATE stock SET quantity = quantity + $c WHERE product_name = '$b'";
		mysqli_query($conn, $sql4);
		$sql5 ="UPDATE stock SET price = $e WHERE product_name = '$b'";
		mysqli_query($conn, $sql5);
		$sql6 ="SELECT quantity, price FROM `stock` WHERE product_name = '$b'";
		$n2 = mysqli_query($conn, $sql6);
		$n = mysqli_fetch_array($n2);
		$t = $n[0]*$n[1];
		$sql7 ="UPDATE stock SET total = $t WHERE product_name = '$b'";
		mysqli_query($conn, $sql7);
		echo('<h4 style="color:green;">Stock updated successfully</h4>');
		logger($c . ' amount of ' . $b . 'added to stock');
	}
	$sql = "DELETE FROM purchase WHERE product_name='$b' AND Invoice_no='$a'";
	mysqli_query($conn, $sql);
} //end of transfer
// Show Data
	$result = mysqli_query($conn,"SELECT * FROM purchase ORDER BY invoice_no DESC");
echo "<h2 class='table_title'>Purchase Register</h2>
<div class='wrapper'>
<div class='table'>
<div class='row header'>
<div class='cell'>Invoice no</div>
<div class='cell'>Product Name</div>
<div class='cell'>Quantity</div>
<div class='cell'>Price</div>
<div class='cell'>Expense</div>
<div class='cell'>Total</div>
<div class='cell'>Date</div>
<div class='cell'>Transfer</div>
</div>";	
while($row = mysqli_fetch_array($result))
{
echo "<div class='row'>";
echo "<div class='cell'>" . $row['Invoice_no'] . "</div>";
echo "<div class='cell'>" . $row['product_name'] . "</div>";
echo "<div class='cell'>" . $row['quantity'] . "</div>";
echo "<div class='cell'>" . $row['price'] . "</div>";
echo "<div class='cell'>" . $row['expense'] . "</div>";
echo "<div class='cell'>" . $row['total'] . "</div>";
echo "<div class='cell'>" . $row['date'] . "</div>";
echo "<div class='cell'><form method='post' action='purchase.php'>
<input name='invoice_no' type='hidden' value='" . $row['Invoice_no'] . "'>
<input name='product_name' type='hidden' value='" . $row['product_name'] . "'>
<input name='quantity' type='hidden' value='" . $row['quantity'] . "'>
<input name='price' type='hidden' value='" . $row['price'] . "'>
<input type='submit' value='&#10003;'>
</form></div>";	
echo "</div>";
}
echo "</div>";
?>
	</div>
	<script src="res.js"></script>
</body>
</html>