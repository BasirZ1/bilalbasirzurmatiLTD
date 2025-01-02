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
	$c = $_POST['quantity'];
	$e = $_POST['price'];
	$f = $c*$e;
	$d = $_POST['date'];
	$expense= $_POST['expense'];
	if($expense!=NULL) {
		$f =  $f + $expense;
		$e = $f/$c;
	}
	$sql = "INSERT INTO purchase (invoice_no, product_name, quantity, price, expense, total, date)
VALUES ('$a', '$b', '$c', '$e', '$expense', '$f', '$d')";
	mysqli_query($conn, $sql);
		logger('New purchase entry invoice no:' . $a);
		echo('<h3 style="color:green;">Entry Successful</h3>');
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
<a class="sidebutton" href="expense.php">Add Expense</a>
</div>
<!--Side Bar End-->  
      <h2 class="table_title">Purchase Entry</h2>
      <div class="form">
      <form action="entry2.php" method="post">
    <label for="invoiceno">Invoice No</label>
      <input type="number" step="0.01" id="invoiceno" name="invoice_no" required="required" placeholder="Invoice No">
    <label for="pname">Product Name</label><!--AA-->
      <input pattern="^(?! )[A-Za-z ]*(?<! )$" list="plist" id="pname" name="product_name" required="required" placeholder="Product Name">
       <datalist id="plist">
  	    <?php 
		  $result = mysqli_query($conn,"SELECT product_name FROM stock");
		  while($row = mysqli_fetch_array($result)) {
		    echo "<option value='" . $row['product_name'] . "'>" . $row['product_name'] . "</option>";
		  }
		?>
	  </datalist><!--ZZ-->
    <label for="quantity">Quantity</label>
      <input type="number" step="0.01" id="quantity" required="required" name="quantity" placeholder="Quantity">
    <label for="price">Price</label>
      <input type="number" step="0.01" id="price" required="required" name="price" placeholder="Price">
    <label for="expense">Expense</label>
      <input type="number" step="0.01" id="expense" name="expense" placeholder="Can be added later">
    <label for="date">Date</label>
      <input type="date" id="date" name="date" required="required" placeholder="Date">
    <input type="submit" value="Submit">
     </form>
	</div>
	</div>
	<script src="res.js"></script>
</body>
</html>