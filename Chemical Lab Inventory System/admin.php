<?php
include('session.php');
if(!isset($_SESSION['login_user'])){
header("location: index.php"); // Redirecting To Home Page
}
if (is_null($status)){
	header("location: user.php");
}
require_once 'config.php';
?>
<!DOCTYPE html>
<html lang="en">
<head><xml>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
	<x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet>
	<x:Name></x:Name>
	<x:WorksheetOptions>
      <x:Panes></x:Panes>
	  <x:DisplayGridlines/>
	</x:WorksheetOptions>
	</x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook>
    <title>Admin || Chemistry Lab Inventory System</title>
    <link rel="stylesheet" type="text/css" href="fontawesome/css/all.css">
  <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <script src="js/jquery.js" type="text/javascript"></script>
	<script src="js/bootstrap.min.js" type="text/javascript"></script>
    
<style type="text/css">
    @import url(css/style-admin.css);
</style>

</head></xml>
<body> 
<section id="section03" class="demo">
  <div class="demoa"><a href="#section04"><span></span></a></div>
  <div id="wrap" class="wrap">
          <form action="" autocomplete="off">
          <input list= "material" onfocus='this.size=1;' onchange="searchmat();" id="search" name="search" type="text" placeholder="What're we looking for ?" onkeyup="searchfunction()"><input id="search_submit" value="Rechercher" type="submit">
          <datalist id="material">
		  <?php 
			$sql="SELECT distinct name, no_id from chemical_profile order by name;";
			$result = $dbh->prepare($sql);
			$result->execute();
				foreach ($result as $row):
				echo "<option data-value='details.php?no_id={$row['no_id']}' value= {$row['name']}></option>";
				endforeach;
			?>
			<Script>
				function searchmat(){
					var sel = $('#search').val();
					var matdet = $('#material [value="'+sel+'"]').data('value');
					location= matdet;
				}
			</script>
			
			</datalist>
		  </form>
  </div> 
   
  <header>
      
    <!-- partial:index.partial.html -->
  <div class="all">
    <div class="lefter"><button class='but' onclick="window.location.href = 'logout.php';">out</button>
      <div class="text">Sign Out</div>
    </div>
    
  <div class="leftt">
    <div class="text">Add User</div><button class='but' onclick="window.location.href = 'addUser.php';">User</button>
  </div>
  <div class="center">
    <div class="explainer"></div>
    <div class="text"><?php echo $login_session; ?></div>
    </div>
  <div class="rightt"><button class="but" onclick="window.location.href = 'add_stock.php';">add</button>
    <div class="text" >Add Stock</div>
  </div>
  <div class="righter"><button class="but" onclick="window.location.href = 'take_stock.php';">take</button>
    <div class="text">Take Stock</div>
  </div>
  </div>

    
  </header>
 
<!-----Container Panel------>        
   <div class="container">
   
    <div class="left">
		<?php
			$query = "SELECT chemical_profile.name,chemical_profile.no_id, exp.exp_date FROM chemical_profile INNER JOIN exp ON chemical_profile.no_id=exp.no_id WHERE exp_date BETWEEN CURRENT_DATE AND CURRENT_DATE + INTERVAL 3 MONTH"; 
			$ses_sql2 = $dbh->prepare($query);
			$ses_sql2->execute();
		?>
		<div class="titlenotif">Near Exp. Date:</div>
		<b><?php echo "<div class= 'card-deck'>"; while($rows = $ses_sql2->fetch()){echo "<div class='card'>
    <div class='card-body'>
      <h5 class='card-title'>".$rows['name']."</h5>
      <p class='card-text'><small class='text-muted'>Exp. Date is :".$rows['exp_date']."</small></p>
    </div>
  </div>";} echo "</div>" ?></b>
  </div>
    <div class="bleft">
    <?php
			$query = "SELECT chemical_profile.name, exp.exp_date FROM chemical_profile INNER JOIN exp ON chemical_profile.no_id=exp.no_id WHERE exp_date < CURRENT_DATE"; 
			$ses_sql2 = $dbh->prepare($query);
			$ses_sql2->execute();
		?>
    <div class="titlenotif">Expired:</div>
    <b><?php echo "<div class= 'bcard-deck'>"; while($rows = $ses_sql2->fetch()){echo "<div class='bcard'>
    <div class='bcard-body'>
      <h5 class='bcard-title'>".$rows['name']."</a></h5>
      <p class='card-text'><small class='btext-muted'>Exp. Date is :".$rows['exp_date']."</small></p>
    </div>
  </div>";} echo "</div>" ?></b>
    </div>
    <div class="line"></div>
    <div class="bright">
    <?php
				$query = "SELECT chemical_profile.name, stock.last_stock FROM chemical_profile INNER JOIN stock ON chemical_profile.no_id=stock.no_id WHERE stock.last_stock = 0"; 
				$ses_sql1 = $dbh->prepare($query);
				$ses_sql1->execute();
				$queryexpstat = "update stock inner join exp on (stock.no_id = exp.no_id) or (stock.2nd_id = exp.no_id) set stat_stock = 'Expired' where exp_date < NOW();";
				$ses_sqll = $dbh->prepare($queryexpstat);
				$ses_sqll->execute();

		?>
    <div class="titlenotif">Stock Empty:</div>
      <b><?php echo "<div class= 'bcard-deck'>"; while($row = $ses_sql1 ->fetch()){echo "<div class='bcard'>
      <div class='bcard-body'>
      <h5 class='bcard-title'>".$row['name']."</h5>
      <p class='card-text'><small class='btext-muted'>Last Stock is :".$row['last_stock']."</small></p>
      </div>
      </div>";} echo "</div>" ?></b>
    </div>
    <div class="right">
			<?php
				$query = "SELECT chemical_profile.name, stock.last_stock FROM chemical_profile INNER JOIN stock ON chemical_profile.no_id=stock.no_id WHERE (stock.last_stock <= chemical_profile.min_stock) and stock.last_stock != 0"; 
				$ses_sql1 = $dbh->prepare($query);
				$ses_sql1->execute();

			?>
		<div class="titlenotif">Under Safe Stock:</div>
		<b><?php echo "<div class= 'card-deck'>"; while($row = $ses_sql1 ->fetch()){echo "<div class='card'>
    <div class='card-body'>
      <h5 class='card-title'>".$row['name']."</h5>
      <p class='card-text'><small class='text-muted'>Last Stock is :".$row['last_stock']."</small></p>
    </div>
  </div>";} echo "</div>" ?></b>
	
	</div>
    
  </div>
</section>

<!-------page2------>
<section id="section04" class="demo">
  <div class="arrow bounce">
    <button class="fa fa-arrow-down fa-rotate-180" onclick="window.location.href='#section03';"></button>
  </div>
  <button class="download" onclick="window.location.href='report.php';" value="Export to Excel"></button>
  <button class="newmat" onclick="addnew()"></button>
  <div class="container-pg2">
  <!---Header Table-->
     <div class="tbl-header">
      <table id="1" cellpadding="0" cellspacing="0" border="0">
       <thead>
         <tr>
            <th>No id</th>
            <th>Name</th>
            <th>Exp date</th>
			<th>Stock by Exp</th>
            <th>Total Stock</th>
            <th>Percentage</th>
          </tr>
        </thead>
        </table>
      </div>
      <div class="tbl-content">
        <table id="2" cellpadding="0" cellspacing="0" border="0">
          <tbody>
<!-----Isi tabel-------->
			<?php $sqlav = "SELECT round(AVG(percentage),1) as AveragePercentage FROM stock";
			$resultav = $dbh -> prepare($sqlav);
			$resultav->execute();
			$rowav = $resultav ->fetch();
			
            
	$sql="SELECT distinct chemical_profile.*, stock.last_stock, stock.percentage FROM chemical_profile JOIN stock ON chemical_profile.no_id = stock.no_id order by chemical_profile.name";
	$result = $dbh->prepare($sql);
	$result->execute();
		foreach ($result as $row):
		if(is_null($row['2nd_id'])){$row['2nd_id'] = "null";};
		$sql2 = "select exp_date from exp where (no_id = ".$row['no_id'].") or (no_id=".$row['2nd_id'].") order by exp_date;";
		$sql3 = "select stock from exp where (no_id = ".$row['no_id'].") or (no_id=".$row['2nd_id'].") order by exp_date;";
		$ans = $dbh -> prepare($sql2);
		$ans->execute();
		$answ = $dbh -> prepare($sql3);
		$answ->execute();
		echo "<tr><td>&nbsp;".$row['no_id']."<br> ". $row['2nd_id']."</td><td><a href='details.php?no_id={$row['no_id']}';'>".$row['name']."</a></td><td>";while ($ansexp = $ans -> fetch()){echo $ansexp['exp_date'],"<br>";}; echo "</td><td>";while ($ansexp = $answ -> fetch()){echo $ansexp['stock'],"<br>";};echo "</td><td>".$row['last_stock']."</td><td>".$row['percentage']."</td></tr>";
		endforeach;
		echo "<tr><td></td><td></td><td></td><td></td><td>Avarage:</td><td>{$rowav['AveragePercentage']}</td></tr></table>";
		
	$conn -> close();
  ?>
<!----------batas ----------->
          </tbody>
        </table>
		
      </div>
 <script>$(window).on("load resize ", function() {
    var scrollWidth = $('.tbl-content').width() - $('.tbl-content table').width();
    $('.tbl-header').css({'padding-right':scrollWidth});
  }).resize();</script>   
       
  </div>
 
</section>
<script>
	var array1 = new Array();
    var array2 = new Array();
    var n = 2; //Total table
    for ( var x=1; x<=n; x++ ) {
        array1[x-1] = x;
        array2[x-1] = x + 'th';
    }

    var tablesToExcel = (function () {
        var uri = 'data:application/vnd.ms-excel;base64,'
        , template = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40"><head><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets>'
        , templateend = '</x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]--></head>'
        , body = '<body>'
        , tablevar = '<table>{table'
        , tablevarend = '}</table>'
        , bodyend = '</body></html>'
        , worksheet = '<x:ExcelWorksheet><x:Name>'
        , worksheetend = '</x:Name><x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet>'
        , worksheetvar = '{worksheet'
        , worksheetvarend = '}'
        , base64 = function (s) { return window.btoa(unescape(encodeURIComponent(s))) }
        , format = function (s, c) { return s.replace(/{(\w+)}/g, function (m, p) { return c[p]; }) }
        , wstemplate = ''
        , tabletemplate = '';

        return function (table, name, filename) {
            var tables = table;

            for (var i = 0; i < tables.length; ++i) {
                wstemplate += worksheet + worksheetvar + i + worksheetvarend + worksheetend;
                tabletemplate += tablevar + i + tablevarend;
            }

            var allTemplate = template + wstemplate + templateend;
            var allWorksheet = body + tabletemplate + bodyend;
            var allOfIt = allTemplate + allWorksheet;

            var ctx = {};
            for (var j = 0; j < tables.length; ++j) {
                ctx['worksheet' + j] = name[j];
            }

            for (var k = 0; k < tables.length; ++k) {
                var exceltable;
                if (!tables[k].nodeType) exceltable = document.getElementById(tables[k]);
                ctx['table' + k] = exceltable.innerHTML;
            }

            //document.getElementById("dlink").href = uri + base64(format(template, ctx));
            //document.getElementById("dlink").download = filename;
            //document.getElementById("dlink").click();

            window.location.href = uri + base64(format(allOfIt, ctx));

        }
    })();
	</script>
	<script>
		function addnew(){
			return window.location.href='add_new.php';
		}
	</script>
	
<script>
function searchfunction() {
  // Declare variables 
  var input, filter, table, tr, td, i, txtValue;
  input = document.getElementById("search");
  filter = input.value.toUpperCase();
  table = document.getElementById("2");
  tr = table.getElementsByTagName("tr");

  // Loop through all table rows, and hide those who don't match the search query
  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[1];
    if (td) {
      txtValue = td.textContent || td.innerText;
      if (txtValue.toUpperCase().indexOf(filter) > -1) {
        tr[i].style.display = "";
      } else {
        tr[i].style.display = "none";
      }
    } 
  }
}
</script>
</body>
</head>
</html>