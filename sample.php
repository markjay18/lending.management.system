<?php
include 'include/dbcon.php';
$record_per_page = 10;
$ID=0;
if(isset($_GET['ID'])){
 $ID = $_GET['ID'];
}else{
	$ID = 1;
}



?>

<!DOCTYPE html>
<html>
<head>
	<title>Sample</title>
</head>
<meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

<!--Link and script for datepicker JQuery-UI
--><link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <link rel="stylesheet" href="/resources/demos/style.css">
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

<script>
	$(document).ready(function(){
  
  /* This is the function that will get executed after the DOM is fully loaded */
	$( "#date" ).datepicker({
	  dateFormat: 'mm-dd-yy',
      changeMonth: true,//this option for allowing user to select month
      changeYear: true //this option for allowing user to select from year range
    });
});
</script>
<body>
	<h3>Sample</h3>
<form method="post">
	<input type="date" id="date" name="from">
	<input type="date" id="date" name="to">
	<button>Hanapin</button>
</form>
	<table id="customers">
			<tr>
				<th>ID</th>
				<th>firstname</th>
				<th>last</th>
				
			</tr>
			<?php 
			
			
			if($ID){
			$start_from = ($ID-1) * $record_per_page;
			$sql="SELECT * FROM sample order by ID";
			}else {
			$start_from = 0;
		}
			$sql="SELECT * FROM sample WHERE dater BETWEEN '$from' AND '$to' limit $start_from, $record_per_page";
			$query=mysql_query($sql); 
	

	 		while($recordset=mysql_fetch_array($query)){
			?>
			<tr>
				<td><?php echo $recordset['ID']; ?></td>
				<td><?php echo $recordset['fname']; ?></td>
				<td><?php echo $recordset['lname']; ?></td>
			</tr>
			<?php
			}
	  		?>
		</table>
		<?php
		$total_record =mysql_num_rows($query);
		$total_pages = ceil($total_record/$record_per_page);
		$start_loop = $ID;
		$difference = $total_pages - $ID;
		if($difference <= 10){
			$start_loop - 10;
		}
		$end_loop=$start_loop + 3;
		if($ID > 1){
			echo "<a href='sample.php?ID=1'><button>first</button></a>";
			echo "<a href='sample.php?ID=".($ID - 1)."'><button><<</button></a>";
		}
		for($i=$start_loop; $i<=$end_loop; $i++)
		{
			echo "<button><a style='text-decoration:none;' href='sample.php?ID=".$i."'>".$i."</a></button>";
		}
		if($ID <= $end_loop){
			echo "<a href='sample.php?ID=".($ID + 1)."'><button>>></button></a>";
			echo "<a href='sample.php?ID=".$total_pages."'><button>last</button></a>";
		}
		?>

</body>
</html>