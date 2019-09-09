<?php
include('session.php');
if(!isset($_SESSION['login_user'])){
header("location: index.php"); // Redirecting To Home Page
}
$conn = mysqli_connect("localhost","root","","chemical");

$no_id = $conn->real_escape_string($_REQUEST['no_id']);
$kurang = $conn->real_escape_string($_REQUEST['kurang']);
$query = "SELECT exp.stock, stock.stat_stock, stock.last_stock, stock.take, chemical_profile.min_stock, chemical_profile.user, chemical_profile.act, chemical_profile.last_date from chemical_profile join stock on chemical_profile.no_id = stock.no_id JOIN exp ON chemical_profile.no_id = exp.no_id where (chemical_profile.no_id = '$no_id') or (chemical_profile.2nd_id = '$no_id') order by exp_date limit 1";

$ses_sql = mysqli_query($conn, $query);
$row = mysqli_fetch_array($ses_sql);
$stat = $row['stat_stock'];
$last = $row['last_stock'];
$min = $row['min_stock'];
$expstock = $row['stock'];
$take = $row['take'];
if(is_null($take)){
	$take = 0;
}
$totake = $take+$kurang;

$stock = $last-$kurang;
	if($stock<0){
		$stock=0;
	}
$percentage = ($stock/$min)*100;
	if ($percentage > 100){
		$percentage = 100;
	}

if($stock<$min){
	$querystat = "update stock set stat_stock = 'Under Safe' where (2nd_id = '$no_id') or (no_id = '$no_id')";
	mysqli_query($conn,$querystat);
}

if($kurang<$expstock){
	$finstock = $expstock-$kurang;
	$query = "update exp set stock = '$finstock' where (2nd_id = '$no_id') or (no_id = '$no_id') order by exp_date limit 1;";
	mysqli_query($conn,$query);
}

if ($kurang>=$expstock){
	$kurang1 = $kurang;
	while ($kurang>$expstock){
		$kurang = $kurang-$expstock;
		$query = "delete from exp where (2nd_id = '$no_id') or (no_id = '$no_id') order by exp_date limit 1;";
		mysqli_query($conn,$query);
		$query2 = "select stock from exp where (2nd_id = '$no_id') or (no_id = '$no_id') order by exp_date limit 1;";
		$ses_sql = mysqli_query($conn, $query2);
		$row = mysqli_fetch_array($ses_sql);
		$expstock = $row['stock'];
	}
	$expstock = $expstock-$kurang;
	$query = "update exp set stock = '$expstock' where (2nd_id = '$no_id') or (no_id = '$no_id') order by exp_date limit 1;";
	mysqli_query($conn,$query);
}

$queryempty = "update stock set stat_stock = 'Empty' where last_stock = 0";
$querydel = "delete from exp where stock = 0";
$query1 = "update stock set last_stock = '$stock', percentage = '$percentage', take = '$totake' where (2nd_id = '$no_id') or (no_id = '$no_id')";
$query3 = "update chemical_profile set user = '$login_session', last_date = NOW(), act = 'take', qty='$kurang1' where (2nd_id = '$no_id') or (no_id = '$no_id')";

mysqli_query($conn, $queryempty);
mysqli_query($conn,$querydel);
mysqli_query($conn,$query1);
mysqli_query($conn,$query3);


if (is_null($status)){
	header("location:detail_user.php?no_id=$no_id ");
}else{
	header("location: details.php?no_id=$no_id");
}

?>