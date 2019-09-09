<?php
include('session.php');
if(!isset($_SESSION['login_user'])){
header("location: index.php"); // Redirecting To Home Page
}
if(isset($_SESSION['login_user']) && $_SESSION['login_user'] != 'admin'){
header("location: user.php");
}
require_once 'config.php';
error_reporting(0);
ini_set('display_errors', 0);
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
    <title>Report | Chemistry Lab Inventory Management</title>
    <link rel="stylesheet" type="text/css" href="fontawesome/css/all.css">
	
    <script src="js/jquery.js" type="text/javascript"></script>
	<script src="js/bootstrap.min.js" type="text/javascript"></script>
    
<style type="text/css">
    @import url(css/style-admin.css);
	@import url(css/style-report.css);
</style>

</head></xml>

<body style="background: url(css/img/Lab3.jpg) center center / cover no-repeat;">
<div class="het">
<button class="downloadex" onclick="tablesToExcel(array1, array2, 'myfile.xls')" value="Export to Excel" >
</div>

<div class="container-pg2r">
  <!---Header Table-->
     <div class="tbl-headerr">
      <table id="1" cellpadding="0" cellspacing="0" border="0">
       <thead>
         <tr>
            <th>No id</th>
            <th>Name</th>
            <th>Nomat</th>
            <th>Brand</th>
            <th>Loc</th>
            <th>Exp_date</th>
			<th>Stock by Exp</th>
            <th>Min Stock</th>
			<th>Unit</th>
			<th>First Stock</th>
			<th>Total Add</th>
			<th>Total Take</th>
			<th>Current Stock</th>
			<th>Percentage</th>
            <th>Status</th>
            
          </tr>
        </thead>
        </table>
      </div>
      <div class="tbl-contentr">
        <table id="2" cellpadding="0" cellspacing="0" border="0">
          <tbody>
<!-----Edit (sesuai database-------->
			<?php $sqlav = "SELECT round(AVG(percentage),1) as AveragePercentage FROM stock";
			$resultav = $dbh -> prepare($sqlav);
			$resultav->execute();
			$rowav = $resultav ->fetch();
			
            
	$sql="SELECT distinct chemical_profile.*, stock.first_stock, stock.last_stock, stock.stat_stock, stock.percentage, stock.adding, stock.take FROM chemical_profile JOIN stock ON chemical_profile.no_id = stock.no_id order by chemical_profile.name";
	$result = $dbh->prepare($sql);
	$result->execute();
	
	foreach($result as $row):
		if(is_null($row['2nd_id'])){$row['2nd_id'] = "null";};
		$sql2 = "select exp_date from exp where (no_id = ".$row['no_id'].") or (no_id = ".$row['2nd_id'].") order by exp_date;";
		$sql3 = "select stock from exp where (no_id = ".$row['no_id'].") or (no_id = ".$row['2nd_id'].") order by exp_date;";
		$ans = $dbh -> prepare($sql2);
		$ans->execute();
		$answ = $dbh -> prepare($sql3);
		$answ->execute();
		echo "<tr><td>&nbsp;".$row["no_id"]."<br> ". $row['2nd_id']."</td><td>".$row['name']."</td><td>".$row['nomat']."</td><td>".$row['brand']."<br>".$row['brand2']."</td><td>".$row['loc']."</td><td>";while ($ansexp = $ans -> fetch()){echo $ansexp['exp_date'],"<br>";}; echo "</td><td>";while ($ansexp = $answ -> fetch()){echo $ansexp['stock'],"<br>";};echo "</td><td>".$row['min_stock']."</td><td>".$row['unit']."</td><td>".$row['first_stock']."</td><td>".$row['adding']."</td><td>".$row['take']."</td><td>".$row['last_stock']."</td><td>".$row['percentage']."</td><td>".$row['stat_stock']."</td></tr>";
		endforeach;
		echo "<tr><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td><td></td></td><td></td><td>Avarage:</td><td>{$rowav['AveragePercentage']}</td><td></td></tr></table>";
		
	$conn -> close();
  ?>
<!----------batas edit----------->
          </tbody>
        </table>
		
      </div>

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
	  </body>
	  </html>