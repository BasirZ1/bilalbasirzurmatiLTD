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
<!--PHP-->
<?php
require 'conn.php';
include 'log.php';
// Insert Data
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $a = $_POST['invoice_no'];
    $b = $_POST['customer_name'];
	$c = $_POST['product_name'];
	$d = $_POST['quantity'];
	$e = $_POST['price'];
	$pay = $_POST['paid'];
	$f = $d*$e;
	$due = $f-$pay;
	$g = $_POST['date'];
	
	$sql2 = "SELECT product_name FROM stock WHERE product_name ='$c'";
	$sql_quan = "SELECT quantity FROM stock WHERE product_name ='$c'";
	$p = mysqli_query($conn, $sql2);
	$q = mysqli_query($conn, $sql_quan);
	$p2 = mysqli_fetch_array($p);
	$q2 = mysqli_fetch_array($q);

	if ($p2 != null){
		$q3 = floatval($q2['quantity']);
		 	if($q3 >= $d) {
			//insert customer
	$sqlCustomer = "SELECT customer_name FROM customers where customer_name='$b'";
	$sqlCustomer2 = mysqli_query($conn, $sqlCustomer);
  	$customersName = mysqli_fetch_array($sqlCustomer2);
if ($b===$customersName['customer_name']) {
		$sql2 = "INSERT INTO `$b` (date, details, billed, paid, due) VALUES ('$g', 'Bill No: $a', $f, $pay, $due)";
		mysqli_query($conn, $sql2);
		$sql3 = "SELECT due FROM `$b` WHERE id=(SELECT MAX(id) FROM `$b` WHERE id NOT IN (SELECT MAX(id) FROM `$b`))";
		$t = mysqli_query($conn, $sql3);
		$t2 = mysqli_fetch_array($t);
		$t3 = floatval($t2['due']);
		$t4 = $t3 + $due;
		$sql4 ="UPDATE `$b` SET due = $t4 WHERE id=(SELECT max(id) FROM `$b`)";
		mysqli_query($conn, $sql4);
		$sql5 = "UPDATE customers SET amount = $t4 WHERE customer_name = '$b'";
		mysqli_query($conn, $sql5);
		echo('<h3 style="color:green;">Due added successfully</h3>');
		logger('Due added to ' . $b);
} else {
	$createTable = "CREATE TABLE `$b` ( id INT NOT NULL AUTO_INCREMENT , date DATE NOT NULL , details VARCHAR(65) NOT NULL , billed DECIMAL(10,2) NOT NULL , paid DECIMAL(10,2) NOT NULL , due DECIMAL(10,2) NOT NULL , PRIMARY KEY (id)) ENGINE = InnoDB;";
	mysqli_query($conn, $createTable);
		$sql2 = "INSERT INTO `$b` (date, details, billed, paid, due) VALUES ('$g', 'Invoice no: $a', $f, $pay, $due)";
		mysqli_query($conn, $sql2);
		$sql5 = "INSERT INTO customers (customer_name, amount) VALUES ('$b', $due)";
		mysqli_query($conn, $sql5);
		echo('<h3 style="color:green;">New Customer added successfully</h3>');
		logger('New customer ' . $b . ' added to database');
}//customer end
		$sql = "INSERT INTO sales (invoice_no, customer_name, product_name, quantity, price, total, paid, due, date)
VALUES ('$a', '$b', '$c', '$d', '$e', '$f', '$pay', '$due', '$g')";
	    mysqli_query($conn, $sql);
		$sql4 ="UPDATE stock SET quantity = quantity - $d WHERE product_name = '$c'";
		mysqli_query($conn, $sql4);
		$sql6 ="SELECT quantity, price FROM `stock` WHERE product_name = '$c'";
		$n2 = mysqli_query($conn, $sql6);
		$n = mysqli_fetch_array($n2);
		$z = $n[0]*$n[1];
		$sql7 ="UPDATE stock SET total = $z WHERE product_name = '$c'";
		mysqli_query($conn, $sql7);
		echo('<h3 style="color:green;">Entry Successful</h3>');
		logger('New sale entry of invoice no:' . $a);
			} else {
						echo('<h3 style="color:red;">Entry Unsuccessful</h3>');
						echo('<h4 style="color:red;">' . $c . ' ' . $q3 . ' Left!</h4>');}
	} else {
		echo('<h3 style="color:red;">Product not available</h3>');
	}
}
?>
<!--PHP END -->
<!--<div class="top"><h1 class="title">Bilal Basir Zurmati Co ltd</h1></div>-->
<div class="main">      
 	<div class="topnav" id="myTopnav">
      <a href="home.php">Home</a>
      <a href="capital/index.php">Capital</a> 
      <a href="purchase.php">Purchase Register</a>
      <a href="stock.php">Stock</a>
      <a href="sale.php">Sales Register</a>
      <a class="active" href="entry1.php">Sales Entry</a>
      <a href="entry2.php">Purchase Entry</a>
      <a href="customers/">Customers</a>
      <a href="payable/">Accounts payable</a>
	  <a href="roznamcha/">Roznamcha</a>
	<a href="javascript:void(0);" class="icon" onclick="myFunction()">
		  <i class="fa fa-bars"></i></a>
	<a href="logout.php"><i class="fa fa-sign-out"></i></a>
	</div>
     <h2 class="table_title">Sales Entry</h2>
     <div class="form">
      <form action="entry1.php" method="post">
    <label for="invoiceno">Invoice No</label>
      <input type="number" step="0.01" id="invoiceno" name="invoice_no" required="required" placeholder="Invoice No">

    <label for="cname">Customer Name</label>
     <!--AA-->
      <input list="clist" id="cname" name="customer_name" required="required" pattern="^(?! )[A-Za-z ]*(?<! )$" placeholder="Customer Name">
       <datalist id="clist">
  	    <?php 
		  $result = mysqli_query($conn,"SELECT customer_name FROM customers");
		  while($row = mysqli_fetch_array($result)) {
		    echo "<option value='" . $row['customer_name'] . "'>" . $row['customer_name'] . "</option>";
		  }
		?>
	  </datalist><!--ZZ-->
    <label for="pname">Product Name</label>
     <!--AA-->
      <select id="pname" name="product_name" required placeholder="Product Name">
  	    <?php 
		  $result = mysqli_query($conn,"SELECT product_name FROM stock");
		  while($row = mysqli_fetch_array($result)) {
		    echo "<option value='" . $row['product_name'] . "'>" . $row['product_name'] . "</option>";
		  }
		?>
	  </select>
	  <!--EE-->
    <label for="quantity">Quantity</label>
      <input type="number" step="0.01" id="quantity" name="quantity" required="required" placeholder="Quantity">
    <label for="price">Price</label>
      <input type="number" step="0.01" id="price" name="price" placeholder="Price">
    <label for="paid">Amount paid</label>
      <input type="number" step="0.01" id="paid" name="paid" placeholder="Amount paid" required="required">
    <label for="date">Date</label>
      <input type="date" id="date" name="date" placeholder="Date">
    <input type="submit" value="Submit">
     </form>
	</div>
	</div>
	<script src="res.js"></script>
</body>
</html>