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
<script type="text/javascript">
 function show(a)
    {
        if(a==1) {document.getElementById("exp").style.display="block";
				  document.getElementById("prof").style.display="none";}
        else if(a==2) {document.getElementById("prof").style.display="block";
					   document.getElementById("exp").style.display="none";}
    }
</script>
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
// Insert Data
if($_SERVER["REQUEST_METHOD"] == "POST") {
    $a = $_POST['date'];
	$b = $_POST['details'];
	$ep = $_POST['ep'];
	$amount = $_POST['amount'];
	if($ep==='e') {
	  $sql2 = "INSERT INTO expense (expenseDate, expenseDetails, expenseAmount) VALUES ('$a', '$b', $amount)";
	  mysqli_query($conn, $sql2);
	} elseif($ep==='p') {
	  $sql2 = "INSERT INTO profit (profitDate, profitDetails, profitAmount) VALUES ('$a', '$b', $amount)";
	  mysqli_query($conn, $sql2);
	}
}
?>
<!--PHP END -->
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
<a class="sidebutton" href="index.php">Roznamcha</a>
</div>
<!--Side Bar End-->  

     <h2 class="table_title">Roznamcha Entry</h2>
     <button type="button" onClick="show(1)" class="buttonT">Expense</button>
     <button type="button" onClick="show(2)" class="buttonT">Profit</button>
          <div  class="form">
    <!--Expense Form-->
    <form id="exp" action="entry.php" method="post">
    <h3>Expense</h3>
    <input type="hidden" name="ep" value="e">
    <label for="details">Expense Details</label>
      <input type="text" id="details" name="details" required="required" placeholder="Expense Details">
	<label for="amount">Expense Amount</label>
      <input type="number" id="amount" step="0.01" name="amount" required="required" placeholder="Enter expense amount">
    <label for="date">Expense Date</label>
      <input type="datetime-local" id="date" name="date" required="required">
      <input type="submit" value="Submit">
     </form>
     <!--Profit Form-->
     <form id="prof" action="entry.php" method="post">
    <h3>Profit Entry</h3>
    <input type="hidden" name="ep" value="p">
    <label for="details">Profit Details</label>
      <input type="text" id="details" name="details" required="required" placeholder="Profit Details">
	<label for="amount">Profit Amount</label>
      <input type="number" id="amount" step="0.01" name="amount" required="required" placeholder="Enter profit amount">
    <label for="date">Profit Date</label>
      <input type="datetime-local" id="date" name="date" required="required">
      <input type="submit" value="Submit">
     </form>
	</div>
	</div>
	<script src="../res.js">
	window.addEventListener('load', () => {
  const now = new Date();
  now.setMinutes(now.getMinutes() - now.getTimezoneOffset());
  document.getElementById('date').value = now.toISOString().slice(0, -1);
});</script>
</body>
</html>