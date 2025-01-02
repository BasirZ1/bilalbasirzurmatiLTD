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
<!--<div class="top"><h1 class="title">Bilal Basir Zurmati Co ltd</h1></div>-->
<div class="main">      
     <div class="topnav" id="myTopnav">
      <a href="../home.php">Home</a>
      <a  href="../capital">Capital</a> 
      <a href="../purchase.php">Purchase Register</a>
      <a href="../stock.php">Stock</a>
      <a href="../sale.php">Sales Register</a>
      <a href="../entry1.php">Sales Entry</a>
      <a href="../entry2.php">Purchase Entry</a>
      <a href="../customers">Customers</a>
      <a href="../payable">Accounts payable</a>
      <a class="active" href="index.php">Roznamcha</a>
	<a href="javascript:void(0);" class="icon" onclick="myFunction()">
		<i class="fa fa-bars"></i></a>
		 <a href="../logout.php"><i class="fa fa-sign-out"></i></a>
	</div>
<!--Side Bar-->
<div class="side">
<a class="sidebutton" href="entry.php">New Entry</a>
</div>
<!--Side Bar End-->    
<!--PHP START-->
      <?php
require '../conn.php';
// Show profit
	$result = mysqli_query($conn,"SELECT * FROM profit ORDER BY profitDate DESC");
echo "<h2 class='table_title'>Profit</h2>
<div class='wrapper'>
<div class='table'>
<div class='row header'>
<div class='cell'>Profit Date</div>
<div class='cell'>Profit Details</div>
<div class='cell'>Profit Amount</div>
</div>";	
while($row = mysqli_fetch_array($result))
{
echo "<div class='row'>";
echo "<div class='cell'>" . $row['profitDate'] . "</div>";
echo "<div class='cell'>" . $row['profitDetails'] . "</div>";
echo "<div class='cell'>" . $row['profitAmount'] . "</div>";
echo "</div>";
}
	$sqlTotal = "SELECT SUM(profitAmount) FROM profit";
	$sumTotal2 = mysqli_query($conn, $sqlTotal);
	$sumTotal = mysqli_fetch_array($sumTotal2);
	
echo "<div class='row green'><div class='cell'>Total</div>
<div class='cell'></div>
<div class='cell'>" . $sumTotal[0] . "</div></div></div></div>";
// Show expense
	$result1 = mysqli_query($conn,"SELECT * FROM expense ORDER BY expenseDate DESC");
echo "<h2 class='table_title'>Expenses</h2>
<div class='wrapper'>
<div class='table'>
<div class='row header'>
<div class='cell'>Expense Date</div>
<div class='cell'>Expense Details</div>
<div class='cell'>Expense Amount</div>
</div>";	
while($row = mysqli_fetch_array($result1))
{
echo "<div class='row'>";
echo "<div class='cell'>" . $row['expenseDate'] . "</div>";
echo "<div class='cell'>" . $row['expenseDetails'] . "</div>";
echo "<div class='cell'>" . $row['expenseAmount'] . "</div>";
echo "</div>";
}
	$sqlTotal = "SELECT SUM(expenseAmount) FROM expense";
	$sumTotal2 = mysqli_query($conn, $sqlTotal);
	$sumTotal = mysqli_fetch_array($sumTotal2);
	
echo "<div class='row green'><div class='cell'>Total</div>
<div class='cell'></div>
<div class='cell'>" . $sumTotal[0] . "</div>";
echo "</div></div></div>";
?>
	</div>
	<script src="../res.js"></script>
</body>
</html>