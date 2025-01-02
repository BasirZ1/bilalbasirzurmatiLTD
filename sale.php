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
      <a href="capital/">Capital</a>  
      <a href="purchase.php">Purchase Register</a>
      <a href="stock.php">Stock</a>
      <a class="active" href="sale.php">Sales Register</a>
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
// Show Data
	$result = mysqli_query($conn,"SELECT * FROM sales ORDER BY invoice_no DESC");
echo "<h2 class='table_title'>Sales Register</h2>
<div class='wrapper'>
<div class='table'>
<div class='row header green'>
<div class='cell'>Invoice no</div>
<div class='cell'>Customer Name</div>
<div class='cell'>Product Name</div>
<div class='cell'>Quantity</div>
<div class='cell'>Price</div>
<div class='cell'>Total</div>
<div class='cell'>Date</div>
</div>";	
while($row = mysqli_fetch_array($result))
{
echo "<div class='row'>";
echo "<div class='cell'>" . $row['Invoice_no'] . "</div>";
echo "<div class='cell'>" . $row['customer_name'] . "</div>";
echo "<div class='cell'>" . $row['product_name'] . "</div>";
echo "<div class='cell'>" . $row['quantity'] . "</div>";
echo "<div class='cell'>" . $row['price'] . "</div>";
echo "<div class='cell'>" . $row['total'] . "</div>";
echo "<div class='cell'>" . $row['date'] . "</div>";
echo "</div>";
}
echo "</div>";	
?>
	</div>
	<script src="res.js"></script>
</body>
</html>