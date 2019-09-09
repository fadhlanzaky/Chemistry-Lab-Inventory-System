<?php
include('session.php');
if(!isset($_SESSION['login_user'])){
header("location: index.php"); // Redirecting To Home Page
}
$conn = mysqli_connect("localhost","root","","chemical");
$exp = $conn->real_escape_string($_REQUEST['exp_date']);
$no_id = $conn->real_escape_string($_REQUEST['no_id']);
$tambah = $conn->real_escape_string($_REQUEST['tambah']);
$query = "SELECT stock.stat_stock, stock.last_stock, stock.adding, chemical_profile.min_stock, chemical_profile.user, chemical_profile.act, chemical_profile.last_date from chemical_profile join stock on chemical_profile.no_id = stock.no_id where (chemical_profile.no_id = '$no_id') or (chemical_profile.2nd_id= '$no_id')";
$checkexp = "select exp.exp_date, exp.stock, chemical_profile.no_id from exp join chemical_profile on exp.no_id = chemical_profile.no_id where (exp_date = '$exp') and ((chemical_profile.no_id = '$no_id') or (chemical_profile.2nd_id = '$no_id'))";
$ses_check = mysqli_query($conn, $checkexp);
$roww = mysqli_fetch_array($ses_check);
$newexstock = $roww['stock']+$tambah;

if(mysqli_num_rows($ses_check)>0){
	$queryexp = "update exp set stock = '$newexstock' where (no_id = ".$roww['no_id'].") and (exp_date = '$exp')";
	//mysqli_query($conn,$queryexp);
}else{
	$querynoid = "select no_id, 2nd_id from chemical_profile where (2nd_id = '$no_id') or (no_id = '$no_id');";
	$set = mysqli_query($conn, $querynoid);
	$res = mysqli_fetch_array($set);
	$queryexp = "insert into exp (no_id,2nd_id, exp_date, stock) values ('".$res['no_id']."','".$res['2nd_id']."','$exp','$tambah')";
	//mysqli_query($conn,$queryexp);
}
mysqli_query($conn,$queryexp) or die ("bad query $queryexp");
$ses_sql = mysqli_query($conn, $query);
$row = mysqli_fetch_array($ses_sql);
$last = $row['last_stock'];
$min = $row['min_stock'];
$add = $row['adding'];
 if(is_null($add)){
 $add = 0;}

$totadd = $add+$tambah;
$stock = $last+$tambah;

if($stock>$min){
	$querystat = "update stock set stat_stock = 'Safe' where (no_id = '$no_id') or (2nd_id = '$no_id')";
	mysqli_query($conn,$querystat);
}
if($stock>$min){
	$querystat = "update stock set stat_stock = 'Safe' where (no_id = '$no_id') or (2nd_id = '$no_id')";
	mysqli_query($conn,$querystat);
}
if($stock<$min){
	$querystat = "update stock set stat_stock = 'Under Safe' where (no_id = '$no_id') or (2nd_id = '$no_id')";
	mysqli_query($conn,$querystat);
}

$percentage = ($stock/$min)*100;
	if ($percentage > 100){
		$percentage = 100;
	}
$query1 = "update stock set last_stock = '$stock', adding = '$totadd' where (no_id = '$no_id') or (2nd_id = '$no_id')";
$query2 = "update stock set percentage = '$percentage' where (no_id = '$no_id') or (2nd_id = '$no_id')";
$query3 = "update chemical_profile set user = '$login_session',last_date = CURRENT_TIMESTAMP(), act = 'add', qty='$tambah' where (no_id = '$no_id') or (2nd_id = '$no_id')";
//$query4 = "update chemical_profile set last_date = CURRENT_TIMESTAMP() where no_id = '$no_id'";
//$query5 = "update chemical_profile set act = 'add' where no_id = '$no_id'";

mysqli_query($conn,$query1);
mysqli_query($conn,$query2);
mysqli_query($conn,$query3);
//mysqli_query($conn,$query4);
//mysqli_query($conn,$query5);

if (is_null($status)){
	header("location:detail_user.php?no_id=$no_id ");
}else{
	header("location: details.php?no_id=$no_id");
}

?>