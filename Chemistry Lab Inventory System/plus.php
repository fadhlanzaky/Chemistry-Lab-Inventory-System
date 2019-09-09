<?php
include('session.php');
if(!isset($_SESSION['login_user'])){
header("location: index.php"); // Redirecting To Home Page
}
session_start();
/* Attempt MySQL server connection. Assuming you are running MySQL
server with default setting (user 'root' with no password) */
$conn = mysqli_connect("localhost","root","","chemical");
$error = ' '; 
if (isset($_POST['submit'])){
	

 
// Escape user inputs for security
$chemical_name = $_POST['chemical_name'];
$no_id = $_POST['no_id'];
$min_stock = $_POST['min_stock'];
$nomat = $_POST['nomat'];
$brand = $_POST['brand'];
$unit = $_POST['unit'];
$loc = $_POST['loc'];
$exp_date = $_POST['exp_date'];
$first_stock = $_POST['first_stock'];
$percentage = ($first_stock/$min_stock)*100;
	if ($percentage > 100){
		$percentage = 100;
	}
	if($stock<$min){
		$stat = "Under Safe";
	}
	else{
		$stat = "Safe";
	}
	
// attempt insert query executions
$sql1 = "INSERT INTO chemical_profile (name, no_id, min_stock, nomat, brand, unit, loc) VALUES ('$chemical_name', '$no_id', '$min_stock', '$nomat', '$brand', '$unit', '$loc')";
$sql2 = "INSERT INTO exp (no_id,exp_date, stock) VALUES ('$no_id', '$exp_date', '$first_stock')";
$sql3 = "INSERT INTO stock (no_id,first_stock,last_stock,stat_stock,percentage) VALUES ('$no_id', '$first_stock', '$first_stock', '$stat', '$percentage')";
if($conn->query($sql1) && $conn->query($sql2) && $conn->query($sql3) === true){
	header("location: admin.php");
}else{
$error = "wrong";}
}

// Close connection
?>