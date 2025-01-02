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
<!--PHP Start-->
<?php
require 'conn.php';
include 'log.php';
// Insert Data
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $a = $_POST['invoice_no'];
	$b = $_POST['product_name'];
	$expense= $_POST['expense'];
	$Te = "SELECT expense from purchase where invoice_no = '$a'";
	$Te1 = mysqli_query($conn, $Te);
	$Te2 = mysqli_fetch_array($Te1);
	$Te3 = floatval($Te2['expense']);
	if($Te3===0.00) {
	$sql = "SELECT total from purchase where invoice_no = '$a'";
	$t = mysqli_query($conn, $sql);
	$t1 = mysqli_fetch_array($t);
	$t2 = floatval($t1['total']);
	$total = $t2 + $expense;
	$sql2 = "SELECT quantity from purchase where invoice_no = '$a'";
	$q = mysqli_query($conn, $sql2);
	$q1 = mysqli_fetch_array($q);
	$q2 = floatval($q1['quantity']);
	$price = $total/$q2;
	$sql3 = "UPDATE purchase SET expense = $expense, total = $total, price = $price WHERE invoice_no = '$a'";
	mysqli_query($conn, $sql3);
		echo('<h3 style="color:green;">Expense added successfully!</h3>');
		logger('Expense added to invoice no: ' . $a);
	} else {
	$sql = "SELECT total from purchase where invoice_no = '$a'";
	$t = mysqli_query($conn, $sql);
	$t1 = mysqli_fetch_array($t);
	$t2 = floatval($t1['total']);
	$total = $t2 + $expense;
	$sql2 = "SELECT quantity from purchase where invoice_no = '$a'";
	$q = mysqli_query($conn, $sql2);
	$q1 = mysqli_fetch_array($q);
	$q2 = floatval($q1['quantity']);
	$price = $total/$q2;
	$sql3 = "UPDATE purchase SET expense = $expense + $Te3, total = $total, price = $price WHERE invoice_no = '$a'";
	mysqli_query($conn, $sql3);
		echo('<h3 style="color:red;">Expense updated!</h3>');
		logger('Expense updated in invoice no: ' . $a);
	}
}
?>
<!--PHP END-->
<!--<div class="top"><h1 class="title">Bilal Basir Zurmati Co ltd</h1></div>-->
<div class="main">      
    <div class="topnav" id="myTopnav">		
      <a href="home.php">Home</a>
      <a href="capital/index.php">Capital</a> 
      <a href="purchase.php">Purchase Register</a>
      <a href="stock.php">Stock</a>
      <a href="sale.php">Sales Register</a>
      <a href="entry1.php">Sales Entry</a>
      <a class="active" href="entry2.php">Purchase Entry</a>
      <a href="customers/">Customers</a>
      <a href="payable/">Accounts payable</a>
      <a href="roznamcha/">Roznamcha</a>
	<a href="javascript:void(0);" class="icon" onclick="myFunction()">
		  <i class="fa fa-bars"></i></a>
	<a href="logout.php"><i class="fa fa-sign-out"></i></a>
	</div>
<!--Side Bar-->
<div class="side">
<a class="sidebutton" href="entry2.php">New Entry</a>
</div>
<!--Side Bar End-->  
      <h2 class="table_title">Add Expense</h2>
      <div class="form">
      <form action="expense.php" method="post">
    <label for="inv">Invoice No</label>
   <!--AA-->
      <select id="inv" name="invoice_no" required placeholder="Invoice no">
  	    <?php 
		  $result = mysqli_query($conn,"SELECT Invoice_no FROM purchase");
		  while($row = mysqli_fetch_array($result)) {
		    echo "<option value='" . $row['Invoice_no'] . "'>" . $row['Invoice_no'] . "</option>";
		  }
		?>
	  </select>
	  <!--EE-->
    <label for="pname">Product Name</label>
<!--AA-->
      <select id="pname" name="product_name" required placeholder="Product Name">
  	    <?php 
		  $result = mysqli_query($conn,"SELECT product_name FROM purchase");
		  while($row = mysqli_fetch_array($result)) {
		    echo "<option value='" . $row['product_name'] . "'>" . $row['product_name'] . "</option>";
		  }
		?>
	  </select>
	  <!--EE-->
    <label for="expense">Expense</label>
      <input type="number" step="0.01" id="expense" name="expense" required="required" placeholder="Expense">
    <input type="submit" value="Submit">
     </form>
	</div>
	</div>
	<script src="res.js"></script>
</body>
</html>