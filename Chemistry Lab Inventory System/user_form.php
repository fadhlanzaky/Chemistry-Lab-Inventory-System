<?php
session_start();
/* Attempt MySQL server connection. Assuming you are running MySQL
server with default setting (user 'root' with no password) */
$conn = mysqli_connect("localhost","root","","login");
$error = ''; 
// Escape user inputs for security
$fullname = $_POST['fullname'];
$username = $_POST['username'];
$password = $_POST['password'];
$status = $_POST['akses'];

if ($_POST['akses']==="admin"){
// attempt insert query executions
$sql1 = "INSERT INTO logintab (fullname, username, password, status) VALUES ('$fullname', '$username', '$password', '$status');";
	if($conn->query($sql1) === true){
		header("location: admin.php");
}}

if($_POST['akses']!=="admin"){
$sql1 = "INSERT INTO logintab (fullname, username, password) VALUES ('$fullname', '$username', '$password');";
if($conn->query($sql1) === true){
	header("location: admin.php");
}
}	
	


// Close connection
?>