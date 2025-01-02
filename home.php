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
<link rel="stylesheet" href="login.css">
<meta charset="utf-8">
<title>Bilal Basir Zurmati Co ltd</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>
<!--<div class="top"><h1 class="title">Bilal Basir Zurmati Co ltd</h1></div>-->
<div class="main">      
    <div class="topnav" id="myTopnav">
      <a class="active" href="home.php">Home</a>
      <a href="capital/index.php">Capital</a>  
      <a href="purchase.php">Purchase Register</a>
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
<!--PHP START-->	
<?php
	require 'conn.php';
	//Budget Total
	$budget1 = "SELECT SUM(amount) FROM capital";
	$budget2 = mysqli_query($conn, $budget1);
	$budget3 = mysqli_fetch_array($budget2);
	$budgetH = "UPDATE home SET budget = $budget3[0]";
	mysqli_query($conn, $budgetH);
	//Stock Total
	$stock1 = "SELECT SUM(total) FROM stock";
	$stock2 = mysqli_query($conn, $stock1);
	$stock3 = mysqli_fetch_array($stock2);
	$stockH = "UPDATE home SET stock = $stock3[0]";
	mysqli_query($conn, $stockH);
	//due Total
	$due1 = "SELECT SUM(amount) FROM customers";
	$due2 = mysqli_query($conn, $due1);
	$due3 = mysqli_fetch_array($due2);
	$dueH = "UPDATE home SET due = $due3[0]";
	mysqli_query($conn, $dueH);
	//Payable Total
	$pay1 = "SELECT SUM(amount) FROM payable";
	$pay2 = mysqli_query($conn, $pay1);
	$pay3 = mysqli_fetch_array($pay2);
	$payH = "UPDATE home SET pay = $pay3[0]";
	mysqli_query($conn, $payH);
	//Roznamcha Total
	$exp1 = "SELECT SUM(expenseAmount) FROM expense";
	$exp2 = mysqli_query($conn, $exp1);
	$exp3 = mysqli_fetch_array($exp2);
	$expH = "UPDATE home SET expense = $exp3[0]";
	$prof1 = "SELECT SUM(profitAmount) FROM profit";
	$prof2 = mysqli_query($conn, $prof1);
	$prof3 = mysqli_fetch_array($prof2);
	$profH = "UPDATE home SET profit = $prof3[0]";
	mysqli_query($conn, $profH);
	//retrieve
	$sql = "SELECT * FROM home";
	$sql2 = mysqli_query($conn, $sql);
	$home = mysqli_fetch_array($sql2);
	if($home!=null) {
	$totalasset = $home[0]+$home[1]+$home[2]+$home[6];
	$totallaib = $home[3] + $home[4] + $home[5];
	$profitH = $totalasset - $totallaib;
echo "<h2 align='center' style='font-size:3vw;'>Income Statement</h2>
		<pre style='font-size:1.8vw;'><span style='color: darkgreen;'>
	Total capital: 					" . $home[0] . "
	Accounts recievable:				" . $home[1] . "
	Total Stock:					" . $home[2] . "
	Roznamcha Profits:					" . $home[6] . "
	Total Assets:							" . $totalasset . "</span><span style='color: darkred;'>
	Owners equity:					" . $home[3] . "
	Accounts payable:				" . $home[4] . "
	Roznamcha Expense:					" . $home[5] . "
	Total laibility:						" . $totallaib . "</span><span style='color: darkblue;'>
	Profit:								" . $profitH . "</span>
	</pre>";
	}
?>
	</div>
	<script src="res.js"></script>	
<!--Footer-->
<footer>
    <div class="footer-menu">
      <ul class="f-menu">
        <li><a href="query.php">Run a query</a></li>
        <li><a href="signup.php">Register new user</a></li>
        <li><a href="change.php">Change password</a></li>
        <li><a href="equity.php">Update equity</a></li>
        <li><a href="rem.php">Remove record</a></li>
        <li><a href="showlog.php">Activity Log</a></li>
        <li><a href="reset.php">Reset database</a></li>
      </ul>
    </div>
</footer>
</body>
</html>