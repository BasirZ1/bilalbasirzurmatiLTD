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
      <a href="purchase.php">Purchase Register</a>
      <a class="active" href="stock.php">Stock</a>
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
// Show Data
	$result1 = mysqli_query($conn,"SELECT * FROM stock");
while($row1 = mysqli_fetch_array($result1)) {
  $pName = $row1['product_name'];
  $pQuan = intval($row1['quantity']);
  if($pQuan===0) {
    $sql = "DELETE FROM stock WHERE product_name='$pName'";
	mysqli_query($conn, $sql);
  }
}
	$result = mysqli_query($conn,"SELECT * FROM stock");
echo "<h2 class='table_title'>Stock</h2>
<div class='wrapper'>
<div class='table'>
<div class='row header blue'>
<div class='cell'>Product Id</div>
<div class='cell'>Product Name</div>
<div class='cell'>Quantity</div>
<div class='cell'>Price</div>
<div class='cell'>Total</div>
</div>";	
while($row = mysqli_fetch_array($result))
{
echo "<div class='row'>";
echo "<div class='cell'>" . $row['id'] . "</div>";
echo "<div class='cell'>" . $row['product_name'] . "</div>";
echo "<div class='cell'>" . $row['quantity'] . "</div>";
echo "<div class='cell'>" . $row['price'] . "</div>";
echo "<div class='cell'>" . $row['total'] . "</div>";
echo "</div>";
}
	$sqlTotal = "SELECT SUM(total) FROM stock";
	$sumTotal2 = mysqli_query($conn, $sqlTotal);
	$sumTotal = mysqli_fetch_array($sumTotal2);
	
echo "<div class='row'>
      <div class='cell'>Total</div>
      <div class='cell'></div>
      <div class='cell'></div>
      <div class='cell'></div>";
echo "<div class='cell'>" . $sumTotal[0] . "</div>";
echo "</div></div>";	
echo "</div>";	
?>
	</div>
	<script src="res.js"></script>
</body>
</html>