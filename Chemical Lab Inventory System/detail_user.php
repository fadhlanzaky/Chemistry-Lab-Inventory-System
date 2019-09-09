<?php
include('session.php');
if(!isset($_SESSION['login_user'])){
header("location: index.php"); // Redirecting To Home Page
}

if(isset($_GET['no_id'])){
	
	$mysqli = new mysqli("localhost", "root", "", "chemical");
	$no_id = mysqli_real_escape_string($mysqli, $_GET['no_id']);
	
	$sql = "SELECT chemical_profile.*, stock.first_stock, stock.percentage,stock.stat_stock, stock.last_stock FROM chemical_profile JOIN stock ON chemical_profile.no_id = stock.no_id where (chemical_profile.no_id = $no_id) or (chemical_profile.2nd_id = $no_id);";
	$sql2 = "SELECT exp_date, stock from exp where (no_id = $no_id) or (2nd_id=$no_id) order by exp_date;";
	$result = mysqli_query($mysqli, $sql) or die("BAD QUERY: $sql");
	$result2 = mysqli_query($mysqli, $sql2) or die("BAD QUERY: $sql");
	$rown = mysqli_fetch_array($result);
	$rown2 = mysqli_fetch_array($result2);
	}
error_reporting(0);
ini_set('display_errors', 0);
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>Material Details || Chemistry Lab Inventory System</title>
    <link rel="stylesheet" type="text/css" href="fontawesome/css/all.css",>
    <script src="js/jquery.js" type="text/javascript"></script>
    <style type="text/css">
    @import url(css/style-details.css);
    </style>
</head>
<body>
<div class="container">
        <div class='x'><a class="close" href="admin.php"><i class="fas fa-times"></i></a></div>
    <div class="name">
        <h1><?php echo $rown['name'];?></h1>
    </div>
        <div class="right">
            <div class="expired">Expired Date
                <div class="date"> 
                    <?php foreach ($result2 as $rown2):echo $rown2['exp_date'],"  <span>:</span>  ",$rown2['stock'],"  <span></span>   ","item","<br>";endforeach;?>
                </div>
            </div>
            <div class="stock">Current Stock
                <div class="qty">
                    <?php echo $rown['last_stock'];?>
                </div>
            </div>
			<div class="percentage">Percentage
                <div class="qty">
                    <?php echo $rown['percentage'];?>%
                </div>
            </div>
			<div class="stat">Status
                <div class="qty">
                    <?php echo $rown['stat_stock'];?>
                </div>
            </div>
           
        </div>

        <div class="left">
            <div class="detail">Product Details
			<div class="output">
				<h3>Barcode ID: <?php echo $rown['no_id'];?></h3>
				<?php if($rown['2nd_id']){
					echo "<h3>2nd Barcode ID: ".$rown['2nd_id']."</h3>";
				}
				?>
				<h3>Nomat: <?php echo $rown['nomat'];?></h3>
				<h3>Brand: <?php echo $rown['brand'].", ".$rown['brand2'];?></h3>
				<h3>Location: <?php echo $rown['loc'];?></h3>
				<h3>Minimal Stock: <?php echo $rown['min_stock'];?></h3>
				<h3>First Stock Added: <?php echo $rown['first_stock'];?></h3>
            </div>
            </div>
            <div class="last">Last Modified 
                <div class="modif">
                    <h2>Action :  <?php echo $rown ['act'];?>  <?php echo $rown ['qty'];?><br> Date :  <?php echo $rown ['last_date'];?><br> By :  <?php echo $rown ['user'];?></h2>
                </div>
            </div>	     
        </div>

</div>
<!------pop up edit--->
<div class="modaledit">
    <div class="hide-btn"><i class="fas fa-times"></i></div>
    <div class="containerm">
        <form id="" action="" method="post">
        <div class="name">
                <h1><?php echo $rown['name'];?></h1>
         </div>
         <div class="right">
            <div class="expired">Expired Date
                <div class="date"> 
                    <?php foreach ($result2 as $rown2):echo $rown2['exp_date'],"  <span>:</span>  ",$rown2['stock'],"  <span></span>   ","item","<br>";endforeach;?>
                </div>
            </div>
            <div class="stock">Current Stock
                <div class="qty">
                    <?php echo $rown['last_stock'];?>
                </div>
            </div>
           
        </div>
        <div class="left">
        <div class="detail">Product details<br>
               <div class="outputt">
                
               <div class="input_fields_wrap"> <Label>Barcode ID : </label> <button class="add_field_button">Add More ID</button>
                <div>
                </div>
                </div><br>
               <div class="nomat">
                <label>Nomat : </label><input type="text" class="no" id="no" name="no" value="<?php echo $rown['nomat'];?>"><br>
               </div>
                <div class="input_fields_wrapb"><label>Brand : </label><button class="add_field_buttonb">Add Brand</button>
                <input type="text" class="merk" id="merk[]" name="merk" value="<?php echo $rown['brand'];?>">
                </div><br>
                
                <label>Location : </label><input type="text" class="loc" id="loc" name="loc" value="<?php echo $rown['loc'];?>"><br>
				<label>Minimal Stock : </label><input type="text" class="min" id="min" name="min" value=" <?php echo $rown['min_stock'];?>"><br>
                <label>First Stock Added : </label><?php echo $rown['first_stock'];?>
                </div>
            </div>
        </div>
		<button class="update" value="" name="submit" type="submit">Save</button>
        </form>
        

        </div>
</div>

</body>
<script>
function confirmation(){
    var result = confirm("Are you sure want to delete?");
	var noid = "<?php echo $rown['no_id']; ?>";
	var link = "delete.php?no_id="
    if(result){
        window.location.href= link+noid;
    }
}
</script>
<script>
$(".edit").on("click",function(){
      $(".modaledit").toggleClass("showed");
    });
    $(".hide-btn").on("click",function(){
      $(".modaledit").toggleClass("showed");
    });
</script>
<script>
    $(document).ready(function() {
	var max_fields      = 2; //maximum input boxes allowed
	var wrapper   		= $(".input_fields_wrap"); //Fields wrapper
	var add_button      = $(".add_field_button"); //Add button ID
	
	var x = 1; //initlal text box count
	$(add_button).click(function(e){ //on add input button click
		e.preventDefault();
		if(x < max_fields){ //max input box allowed
			x++; //text box increment
			$(wrapper).append('<div><input type="text" class="id" name="id" value="" placeholder="Add new Id"/><a href="#" class="remove_field">-</a></div>'); //add input box
		}
	});
	
	$(wrapper).on("click",".remove_field", function(e){ //user click on remove text
		e.preventDefault(); $(this).parent('div').remove(); x--;
	})
});
</script>
<script>
    $(document).ready(function() {
	var max_fields      = 2; //maximum input boxes allowed
	var wrapper   		= $(".input_fields_wrapb"); //Fields wrapper
	var add_button      = $(".add_field_buttonb"); //Add button ID
	
	var x = 1; //initlal text box count
	$(add_button).click(function(e){ //on add input button click
		e.preventDefault();
		if(x < max_fields){ //max input box allowed
			x++; //text box increment
			$(wrapper).append('<div><input type="text" class="merk" name="merk2" value="" placeholder="New Brand"/><a href="#" class="remove_field">-</a></div>'); //add input box
		}
	});
	
	$(wrapper).on("click",".remove_field", function(e){ //user click on remove text
		e.preventDefault(); $(this).parent('div').remove(); x--;
	})
});
    </script>
	
	<?php 
		$noid2 = $_POST['id'];
		$min_stock = $_POST['min'];  
		$nomat = $_POST['no']; 
		$brand = $_POST['merk']; 
		$brand2 = $_POST['merk2']; 
		$loc = $_POST['loc']; 
		$stockk = $rown['last_stock'];
		
		
		if(isset($_POST['submit']))
        {
			if (empty($_POST['id'])){
				$sqll = "update chemical_profile set nomat = '$nomat' , brand = '$brand' , brand2 = '$brand2' , loc = '$loc' , min_stock = '$min_stock' where (no_id = ".$rown['no_id'].") or (2nd_id = ".$rown['no_id'].");";
			}else{
				$sqll = "update chemical_profile set 2nd_id = '$noid2' , nomat = '$nomat' , brand = '$brand' , brand2 = '$brand2' , loc = '$loc' , min_stock = '$min_stock' where (no_id = ".$rown['no_id'].") or (2nd_id = ".$rown['no_id'].");";
				$sqll2 = "update stock set 2nd_id = '$noid2' where no_id = ".$rown['no_id']."";
				$sqll3 = "update exp set 2nd_id = '$noid2' where no_id = ".$rown['no_id']."";
				$resultt2 = mysqli_query($mysqli, $sqll2);
				$resultt3 = mysqli_query($mysqli, $sqll3);
			}
			$resultt = mysqli_query($mysqli, $sqll);
		
		$percentage = ($stockk/$min_stock)*100;
			if ($percentage > 100){
				$percentage = 100;
			}
		$sqlav = "update stock set percentage = '$percentage' where (no_id = ".$rown['no_id'].") or (2nd_id = ".$rown['no_id'].")";
		$result3 = mysqli_query($mysqli, $sqlav);
		echo "<meta http-equiv='refresh' content='0'>";
		}
	?>
	
</html>