<?php

$mysqli = new mysqli("localhost", "root", "", "login");
if($mysqli === false){
    die("ERROR: Could not connect. " . $mysqli->connect_error);
}	

if(isset($_POST["username"])) {
	$username = $_POST["username"];
  $query = "SELECT username from logintab where username = '$username'";

  $con = mysqli_query($mysqli, $query);
  $row = mysqli_fetch_array($con);

  if(mysqli_num_rows($con)>0) {
	echo "Registered";
  }else{
      echo "Not Registered";
  }
}
?>