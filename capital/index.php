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
<a class="sidebutton" href="#overview">Overview</a>
<a class="sidebutton" href="entry.php">New Entry</a>
</div>
<!--Side Bar End-->    
<!--PHP START-->
      <?php
require '../conn.php';
// Show overview
	$result = mysqli_query($conn,"SELECT * FROM capital");
echo "<h2 class='table_title' id='overview'>Capital Overview</h2>
<div class='wrapper'>
<div class='table'>
<div class='row header'>
<div class='cell'>Location</div>
<div class='cell'>Amount</div>
</div>";	
while($row = mysqli_fetch_array($result))
{
echo "<div class='row'>";
echo "<a class='capbtn' href='#" . $row['location'] . "'><div class='cell'>" . $row['location'] . "</div></a>";
echo "<div class='cell'>" . $row['amount'] . "</div>";
echo "</div>";
}
	$sqlTotal = "SELECT SUM(amount) FROM capital";
	$sumTotal2 = mysqli_query($conn, $sqlTotal);
	$sumTotal = mysqli_fetch_array($sumTotal2);
	
echo "<div class='row green'><div class='cell'>Total</div>
<div class='cell'>" . $sumTotal[0] . "</div>";
echo "</div></div></div>";//added
$result = mysqli_query($conn,"SELECT * FROM capital");
// Show location tables
while($row = mysqli_fetch_array($result)) {
	$located = $row['location'];
	$result2 = mysqli_query($conn,"SELECT * FROM `$located` ORDER BY id DESC");
echo "<h2 class='table_title' id='" . $row['location'] . "'>" . $row['location'] . "</h2>
<div class='wrapper'>
<div class='table'>
<div class='row header'>
<div class='cell'>Id</div>
<div class='cell'>Date</div>
<div class='cell'>Details</div>
<div class='cell'>Debit</div>
<div class='cell'>Credit</div>
<div class='cell'>Total</div>
</div>";	
while($row2 = mysqli_fetch_array($result2))
{
echo "<div class='row'>";
echo "<div class='cell'>" . $row2['id'] . "</div>";
echo "<div class='cell'>" . $row2['date'] . "</div>";
echo "<div class='cell'>" . $row2['details'] . "</div>";
echo "<div class='cell'>" . $row2['debit'] . "</div>";
echo "<div class='cell'>" . $row2['credit'] . "</div>";
echo "<div class='cell'>" . $row2['total'] . "</div>";
echo "</div>";
}
echo "</div></div>";
	}
?>
	</div>
	<script src="../res.js"></script>
</body>
</html>