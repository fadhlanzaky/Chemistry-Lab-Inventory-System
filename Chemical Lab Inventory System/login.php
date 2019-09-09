<?php
session_start(); // Starting Session
$conn = mysqli_connect("localhost", "root", "", "login");
$error = ''; // Variable To Store Error Message
if (isset($_POST['submit'])) {
if (empty($_POST['username']) || empty($_POST['password'])) {
$error = "Username and Password should be filled!";
}
else{
// Define $username and $password
$username = $_POST['username'];
$password = $_POST['password'];
// mysqli_connect() function opens a new connection to the MySQL server.
// $conn = mysqli_connect("localhost", "root", "", "login");
// SQL query to fetch information of registerd users and finds user match.
$query = "SELECT username, password from logintab where username=? AND password=? LIMIT 1";
// To protect MySQL injection for Security purpose
$stmt = $conn->prepare($query);
$stmt->bind_param("ss", $username, $password);
$stmt->execute();
$stmt->bind_result($username, $password);
$stmt->store_result();
$row = $stmt->fetch();
if($row) //fetching the contents of the row
{
$_SESSION['login_user'] = $username; // Initializing Session
header("location: admin.php"); 
}

else {
$error = "Password or Username are invalid!";
}	// Redirecting To Profile Page
}

mysqli_close($conn); // Closing Connection
}
?>