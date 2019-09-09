<?php
include('session.php');
if(!isset($_SESSION['login_user'])){
header("location: index.php"); // Redirecting To Home Page
}
	if(isset($_GET['no_id'])){
	$mysqli = new mysqli("localhost", "root", "", "chemical");
	$no_id = mysqli_real_escape_string($mysqli, $_GET['no_id']);
	
	$sql = "DELETE FROM chemical_profile where no_id = $no_id";
	$result = mysqli_query($mysqli, $sql) or die("BAD QUERY: $sql");
	
	header("location: admin.php");
	}
?>