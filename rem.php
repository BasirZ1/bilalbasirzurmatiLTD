<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: index.php");
    exit;
}
require 'conn.php';
include 'log.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $currentUser = strtolower($_SESSION['username']);
	$type = $_POST['type'];
	if ($currentUser==='edmzurmati' || $currentUser==='arifullah') {
      if ($type==='drop') {
		$rectype = $_POST['rectype'];
        $record = $_POST['record'];
	    if ($rectype ==='payable') {
		$op1 = mysqli_query($conn,"SELECT * FROM payable");
		while($row = mysqli_fetch_array($op1)) {
		  $name = $row['name'];
		  if($name===$record) {
		    $sql = "DROP table `$name`";
		    mysqli_query($conn, $sql);
			$sql2 = "DELETE FROM payable WHERE name = '$name'";
			mysqli_query($conn, $sql2);
			logger($rectype .' '. $record . ' removed!');
	    	header('location: home.php');
		  } else {echo 'Record not found!';}
		}
	  }
	  elseif ($rectype==='customer') {
	    $op2 = mysqli_query($conn,"SELECT * FROM customers");
		while($row = mysqli_fetch_array($op2)) {
		  $name = $row['customer_name'];
		  if($name===$record) {
		    $sql = "DROP table `$name`";
		    mysqli_query($conn, $sql);
			$sql2 = "DELETE FROM customers WHERE customer_name = '$name'";
			mysqli_query($conn, $sql2);
			logger($rectype .' '. $record . ' removed!');
	    	header('location: home.php');
		  } else {echo 'Record not found!';}  
		}
	  }
	  elseif ($rectype==='capital') {
	    $op3 = mysqli_query($conn,"SELECT * FROM capital");
		while($row = mysqli_fetch_array($op3)) {
		  $name = $row['location'];
		  if($name===$record) {
		    $sql = "DROP table `$name`";
		    mysqli_query($conn, $sql);
			$sql2 = "DELETE FROM capital WHERE location = '$name'";
			mysqli_query($conn, $sql2);
			logger($rectype .' '. $record . ' removed!');
	    	header('location: home.php');
		  } else {echo 'Kahta not found!';} 
		}
	  }
		  elseif ($rectype==='stock') {
		$op4 = mysqli_query($conn,"SELECT * FROM stock");
		while($row = mysqli_fetch_array($op4)) {
		  $name = $row['product_name'];
		  if($name===$record) {
			$sql = "DELETE FROM stock WHERE product_name = '$name'";
			mysqli_query($conn, $sql);
			logger($rectype .' '. $record . ' removed!');
	    	header('location: home.php');
		  } else {echo 'Record not found!';} 
		} 
	 }	
	} elseif ($type==='del') {
		$rectype = $_POST['rectype'];
        $record = $_POST['record'];
		$field = $_POST['field'];
	    if ($rectype ==='payable') {
		$op1 = mysqli_query($conn,"SELECT * FROM payable");
		while($row = mysqli_fetch_array($op1)) {
		  $name = $row['name'];
		  if($name===$record) {
			$sql2 = "DELETE FROM `$record` WHERE id = '$field'";
			mysqli_query($conn, $sql2);
			$sql5 = "ALTER TABLE `$record` DROP `id`";
			mysqli_query($conn, $sql5);
			$sql6 = "ALTER TABLE `$record` ADD `id` INT NOT NULL AUTO_INCREMENT FIRST, ADD PRIMARY KEY (`id`)";
			mysqli_query($conn, $sql6);
			$op2 = mysqli_query($conn, "SELECT * FROM `$record`");
			while($row1 = mysqli_fetch_array($op2)) {
			$id = $row1['id'];
			$idint = intval($id);
			$id1 = $idint-1;
			$dr = $row1['debit'];
			$cr = $row1['credit'];
			$t1 = "SELECT total FROM `$record` WHERE id=$id1";
			$t4 = mysqli_query($conn, $t1);
			$t2 = mysqli_fetch_array($t4);
			$t3 = floatval($t2['total']);
			$t = $t3+$dr-$cr;
			$sql3 = "UPDATE `$record` SET total = $t WHERE id = $id";
			mysqli_query($conn, $sql3);
			}
			  $sql8 = "SELECT total FROM `$record` ORDER BY id DESC LIMIT 1";
		$a4 = mysqli_query($conn, $sql8);
		$a5 = mysqli_fetch_array($a4);
		$a6 = floatval($a5['total']);
			$sql7 = "UPDATE payable SET amount = $a6 WHERE name = '$record'";
			mysqli_query($conn, $sql7);
			logger($record . ' ' . $field . ' deleted!');
	    	header('location: home.php');
		  } else {echo 'Record not found!';}
		}
	  }
	  elseif ($rectype==='customer') {
	    $op3 = mysqli_query($conn,"SELECT * FROM customers");
		while($row = mysqli_fetch_array($op3)) {
		  $name = $row['customer_name'];
		  if($name===$record) {
			$sql2 = "DELETE FROM `$record` WHERE id = '$field'";
			mysqli_query($conn, $sql2);
			$sql5 = "ALTER TABLE `$record` DROP `id`";
			mysqli_query($conn, $sql5);
			$sql6 = "ALTER TABLE `$record` ADD `id` INT NOT NULL AUTO_INCREMENT FIRST, ADD PRIMARY KEY (`id`)";
			mysqli_query($conn, $sql6);
			$op2 = mysqli_query($conn, "SELECT * FROM `$record`");
			while($row1 = mysqli_fetch_array($op2)) {
			$id = $row1['id'];
			$idint = intval($id);
			$id1 = $idint-1;
			$dr = floatval($row1['billed']);
			$cr = floatval($row1['paid']);
			$t1 = "SELECT due FROM `$record` WHERE id=$id1";
			$t4 = mysqli_query($conn, $t1);
			$t2 = mysqli_fetch_array($t4);
			$t3 = floatval($t2['due']);
			$t = $t3+$dr-$cr;
			$sql3 = "UPDATE `$record` SET due = $t WHERE id = $id";
			mysqli_query($conn, $sql3);
			}
			  $sql8 = "SELECT due FROM `$record` ORDER BY id DESC LIMIT 1";
		$a4 = mysqli_query($conn, $sql8);
		$a5 = mysqli_fetch_array($a4);
		$a6 = floatval($a5['due']);
			$sql7 = "UPDATE customers SET amount = $a6 WHERE customer_name = '$record'";
			mysqli_query($conn, $sql7);
			logger($record . ' ' . $field . ' deleted!');
	    	header('location: home.php');
		  } else {echo 'Record not found!';}
		}
	  }
	  elseif ($rectype==='capital') {
	    $op3 = mysqli_query($conn,"SELECT * FROM capital");
		while($row = mysqli_fetch_array($op3)) {
		  $name = $row['location'];
		  if($name===$record) {
			$sql2 = "DELETE FROM `$record` WHERE id = '$field'";
			mysqli_query($conn, $sql2);
			$sql5 = "ALTER TABLE `$record` DROP `id`";
			mysqli_query($conn, $sql5);
			$sql6 = "ALTER TABLE `$record` ADD `id` INT NOT NULL AUTO_INCREMENT FIRST, ADD PRIMARY KEY (`id`)";
			mysqli_query($conn, $sql6);
			$op2 = mysqli_query($conn, "SELECT * FROM `$record`");
			while($row1 = mysqli_fetch_array($op2)) {
			$id = $row1['id'];
			$idint = intval($id);
			$id1 = $idint-1;
			$dr = floatval($row1['debit']);
			$cr = floatval($row1['credit']);
			$t1 = "SELECT total FROM `$record` WHERE id=$id1";
			$t4 = mysqli_query($conn, $t1);
			$t2 = mysqli_fetch_array($t4);
			$t3 = floatval($t2['total']);
			$t = $t3+$dr-$cr;
			$sql3 = "UPDATE `$record` SET total = $t WHERE id = $id";
			mysqli_query($conn, $sql3);
			}
			$sql8 = "SELECT total FROM `$record` ORDER BY id DESC LIMIT 1";
		$a4 = mysqli_query($conn, $sql8);
		$a5 = mysqli_fetch_array($a4);
		$a6 = floatval($a5['total']);
			$sql7 = "UPDATE capital SET amount = $a6 WHERE location = '$record'";
			mysqli_query($conn, $sql7);
			logger($record . ' ' . $field . ' deleted!');
	    	header('location: home.php');
		  } else {echo 'Record not found!';}
		}
	  }  
	} elseif ($type==='upd') {
		$rectype = $_POST['rectype'];
        $record = $_POST['record'];
		$field = $_POST['field'];
		$date = $_POST['date'];
		$details = $_POST['details'];
		$debit = $_POST['dr'];
		$credit = $_POST['cr'];
	    if ($rectype==='payable') {
		$op1 = mysqli_query($conn,"SELECT * FROM payable");
		while($row = mysqli_fetch_array($op1)) {
		  $name = $row['name'];
		  if($name===$record) {
			$sql2 = "UPDATE `$record` SET date = '$date', details = '$details', debit = $debit, credit = $credit WHERE id = '$field'";
			mysqli_query($conn, $sql2);
			$op2 = mysqli_query($conn, "SELECT * FROM `$record`");
			while($row1 = mysqli_fetch_array($op2)) {
			$id = $row1['id'];
			$idint = intval($id);
			$id1 = $idint-1;
			$dr = $row1['debit'];
			$cr = $row1['credit'];
			$t1 = "SELECT total FROM `$record` WHERE id=$id1";
			$t4 = mysqli_query($conn, $t1);
			$t2 = mysqli_fetch_array($t4);
			$t3 = floatval($t2['total']);
			$t = $t3+$dr-$cr;
			$sql3 = "UPDATE `$record` SET total = $t WHERE id = $id";
			mysqli_query($conn, $sql3);
			}
			  $sql8 = "SELECT total FROM `$record` ORDER BY id DESC LIMIT 1";
		$a4 = mysqli_query($conn, $sql8);
		$a5 = mysqli_fetch_array($a4);
		$a6 = floatval($a5['total']);
			$sql7 = "UPDATE payable SET amount = $a6 WHERE name = '$record'";
			mysqli_query($conn, $sql7);
			logger($record . ' ' . $field . ' updated!');
	    	header('location: home.php');
		  } else {echo 'Record not found!';}
		}
	  }
	  elseif ($rectype==='customer') {
	    $op3 = mysqli_query($conn,"SELECT * FROM customers");
		while($row = mysqli_fetch_array($op3)) {
		  $name = $row['customer_name'];
		  if($name===$record) {
			$sql2 = "UPDATE `$record` SET date = '$date', details = '$details', billed = $debit, paid = $credit WHERE id = '$field'";
			mysqli_query($conn, $sql2);
			$op2 = mysqli_query($conn, "SELECT * FROM `$record`");
			while($row1 = mysqli_fetch_array($op2)) {
			$id = $row1['id'];
			$idint = intval($id);
			$id1 = $idint-1;
			$dr = floatval($row1['billed']);
			$cr = floatval($row1['paid']);
			$t1 = "SELECT due FROM `$record` WHERE id=$id1";
			$t4 = mysqli_query($conn, $t1);
			$t2 = mysqli_fetch_array($t4);
			$t3 = floatval($t2['due']);
			$t = $t3+$dr-$cr;
			$sql3 = "UPDATE `$record` SET due = $t WHERE id = $id";
			mysqli_query($conn, $sql3);
			}
			  $sql8 = "SELECT due FROM `$record` ORDER BY id DESC LIMIT 1";
		$a4 = mysqli_query($conn, $sql8);
		$a5 = mysqli_fetch_array($a4);
		$a6 = floatval($a5['due']);
			$sql7 = "UPDATE customers SET amount = $a6 WHERE customer_name = '$record'";
			mysqli_query($conn, $sql7);
			logger($record . ' ' . $field . ' updated!');
	    	header('location: home.php');
		  } else {echo 'Record not found!';}
		}
	  }
	  elseif ($rectype==='capital') {
	    $op3 = mysqli_query($conn,"SELECT * FROM capital");
		while($row = mysqli_fetch_array($op3)) {
		  $name = $row['location'];
		  if($name===$record) {
			$sql2 = "UPDATE `$record` SET date = '$date', details = '$details', debit = $debit, credit = $credit WHERE id = '$field'";
			mysqli_query($conn, $sql2);
			$op2 = mysqli_query($conn, "SELECT * FROM `$record`");
			while($row1 = mysqli_fetch_array($op2)) {
			$id = $row1['id'];
			$idint = intval($id);
			$id1 = $idint-1;
			$dr = floatval($row1['debit']);
			$cr = floatval($row1['credit']);
			$t1 = "SELECT total FROM `$record` WHERE id=$id1";
			$t4 = mysqli_query($conn, $t1);
			$t2 = mysqli_fetch_array($t4);
			$t3 = floatval($t2['total']);
			$t = $t3+$dr-$cr;
			$sql3 = "UPDATE `$record` SET total = $t WHERE id = $id";
			mysqli_query($conn, $sql3);
			}
			$sql8 = "SELECT total FROM `$record` ORDER BY id DESC LIMIT 1";
		$a4 = mysqli_query($conn, $sql8);
		$a5 = mysqli_fetch_array($a4);
		$a6 = floatval($a5['total']);
			$sql7 = "UPDATE capital SET amount = $a6 WHERE location = '$record'";
			mysqli_query($conn, $sql7);
			logger($record . ' ' . $field . ' updated!');
	    	header('location: home.php');
		  } else {echo 'Record not found!';}
		}
	  }  
	} elseif ($type==='rem') {
	  $sql2 = "TRUNCATE `$rectype`";
	  mysqli_query($conn, $sql2);
	  logger($rectype . ' Kahta emptied!');
	  header('location: home.php');	  
	}
	} else {echo '<h2>You are not an administrator!</h2>';}
}
?>
<!doctype html>
<html>
<head>
<link rel="stylesheet" href="style.css">
<link rel="stylesheet" href="login.css">
<meta charset="utf-8">
<title>Bilal Basir Zurmati Co ltd</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<script type="text/javascript">
 function show(a)
    {
        if(a==1) {document.getElementById("drop").style.display="block";
				  document.getElementById("del").style.display="none";
				  document.getElementById("upd").style.display="none";
				  document.getElementById("emp").style.display="none";}
        else if(a==2) {document.getElementById("del").style.display="block";
				  document.getElementById("drop").style.display="none";
				  document.getElementById("upd").style.display="none";
				  document.getElementById("emp").style.display="none";}
		else if(a==3) {document.getElementById("upd").style.display="block";
				  document.getElementById("del").style.display="none";
				  document.getElementById("drop").style.display="none";
				  document.getElementById("emp").style.display="none";}
		else if(a==4) {document.getElementById("emp").style.display="block";
				  document.getElementById("del").style.display="none";
				  document.getElementById("upd").style.display="none";
				  document.getElementById("drop").style.display="none";}
    }
</script>
</head>

<body>
<div class="log">
	<button type="button" onClick="show(1)" class="buttonT">Remove</button>
    <button type="button" onClick="show(2)" class="buttonT">Delete</button>
    <button type="button" onClick="show(3)" class="buttonT">Update</button>
    <button type="button" onClick="show(4)" class="buttonT">Empty</button>     
      <!--Drop-->
      <form action="rem.php" method="post" id="drop">
      <h1 class="title">Remove kahta</h1>
       <label for="rec" style="margin-left: 7rem">Kahta location:</label>
        <select id="rec" name="rectype">
          <option value="capital">Capital</option>
          <option value="customer">Customer</option>
          <option value="payable">Account payable</option>
          <option value="stock">Remove a stock</option>	
        </select>
        <input type="text" id="record" name="record" required="required" placeholder="Enter kahta name">
        <input type="hidden" name="type" value="drop">
    <input type="submit" value="Remove record">
     </form>
     <!--del-->
     <form action="rem.php" method="post" id="del">
       <h1 class="title">Delete</h1>
       <label for="rec" style="margin-left: 7rem">Delete from:</label>
        <select id="rec" name="rectype">
          <option value="capital">Capital</option>
          <option value="customer">Customer</option>
          <option value="payable">Account payable</option>
        </select>
        <input type="text" id="record" name="record" required="required" placeholder="Enter kahta name">
        <input type="number" id="field" name="field" required="required" placeholder="Enter record id">
        <input type="hidden" name="type" value="del">
    <input type="submit" value="Delete record">
     </form>
     <!--Upd-->
     <form action="rem.php" method="post" id="upd">
       <h1 class="title">Update</h1>
       <label for="rec" style="margin-left: 7rem">Update from:</label>
        <select id="rec" name="rectype">
          <option value="capital">Capital</option>
          <option value="customer">Customer</option>
          <option value="payable">Account payable</option>
        </select>
        <input type="text" id="record" name="record" required="required" placeholder="Enter kahta name">
        <input type="number" id="field" name="field" required="required" placeholder="Enter record id">
        <legend style="margin-left: 7rem">Update to:</legend>
        <label for="date" style="margin-left: 7rem">Date</label>
      <input type="date" id="date" name="date" placeholder="Date" required="required">
      <input type="text" id="details" name="details" required="required" placeholder="Details">
      <input type="number" step="0.01" name="dr" required="required" placeholder="Enter debit">
      <input type="number" step="0.01" name="cr" required="required" placeholder="Enter credit">
        <input type="hidden" name="type" value="upd">
    <input type="submit" value="Update record">
     </form>
     <!--emp-->
      <form action="rem.php" method="post" id="emp">
       <h1 class="title">Empty kahta</h1>
       <label for="rec" style="margin-left: 7rem">Kahta name:</label>
        <select id="rec" name="rectype">
          <option value="expense">Expense</option>
          <option value="profit">Profit</option>
          <option value="sales">Sales register</option>
          <option value="purchase">purchase register</option>	
        </select>
        <input type="hidden" name="type" value="emp">
    <input type="submit" value="Empty table">
     </form>
    </div>
</div>
</body>
</html>