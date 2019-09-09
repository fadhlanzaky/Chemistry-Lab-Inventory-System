<?php

$mysqli = new mysqli("localhost", "root", "", "chemical");
if($mysqli === false){
    die("ERROR: Could not connect. " . $mysqli->connect_error);
}	

if(isset($_POST["no_id"])) {
	$noid = $_POST["no_id"];
  $query = "SELECT chemical_profile.name, stock.last_stock FROM chemical_profile JOIN stock ON chemical_profile.no_id = stock.no_id WHERE (chemical_profile.no_id='$noid') or (chemical_profile.2nd_id='$noid')";

  $con = mysqli_query($mysqli, $query);
  $row = mysqli_fetch_array($con);

  if(mysqli_num_rows($con)>0) {
	echo "Registered";
  }else{
      echo "Not Registered";
  }
}
?>