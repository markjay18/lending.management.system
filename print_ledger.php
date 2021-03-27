<?php 
include 'include/dbcon.php';
include 'session.php';
/*view admin userID*/
$accno=0;
if(isset($_GET['accno'])){
 $accno = $_GET['accno'];
}
 $sql="SELECT * FROM ledger WHERE accno='".$accno."'";
 $query=mysql_query($sql);
 $recordset=mysql_fetch_array($query);

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<title>Print Ledger</title>
</head>

	<link href="css/print.css" rel="stylesheet">

	<script type="text/javascript">
		function printledger(btn_id){
		document.getElementById(btn_id).style.display="none";
		window.print();
	}
	</script>
<body>
<div class="container">
	<p><strong style="color: #81386e; font-size: 30px;">|LADZ</strong>BILL</p>
	<p class="content">Guadalupe Viejo,</p>
	<p class="content">Rosal St. 6946 Makati City</p>
	<p class="content">1211 Metro Manila Philippines</p><br>
	<p class="content">Loan ID# : <?php echo $accno; ?></p><br>
	<p class="content">Member's Payment Ledger</p><br>
	<p class="content">Member's Name: <input type="text" style="margin-right: 110px;" class="view_input" name="" value="<?php echo $recordset['name']; ?>">Print Date: <?php date_default_timezone_set("ASIA/MANILA"); echo "". date('m-d-Y');?></p>
	<button type="button" id="hide" onclick="printledger('hide');" style=" cursor: pointer; margin-left: 70%;">Print</button>
	<p class="content">Payment Scheduled List</p>
	<table class="content" style="width:100%; border-collapse: collapse;" border="1" id="tbl">
		<tr>
			<th width="20px">#</th>
			<th width="150px">Date</th>
			<th width="150px">Amount</th>
			<th width="150px">Payment</th>
			<th width="150px">Extra Payment</th>
			<th width="150px">Method</th>
			<th>Signature</th>
		</tr>
		<?php
		 $sql="SELECT * FROM ledger WHERE accno='".$accno."' AND operator=''";
 		 $query=mysql_query($sql);
 		 $recordset=mysql_fetch_array($query);
 		 $row=mysql_num_rows($query);
 		 if($row == 0){
			echo '<p class="err">No record found in the table.</p>';
		 }else{
			echo '';
		 }
		?>
		<?php  
			$sql="SELECT * FROM ledger WHERE accno='".$accno."' AND operator=''";
	 		$query=mysql_query($sql);
	 		$num_rows=0;
	 		while($recordset=mysql_fetch_array($query)){
	 			$num_rows++;
	 			$total+=$recordset['payamount'];
			?>


		<tr>
			<td align="center"><?php echo $num_rows; ?></td>
			<td align="center"><?php echo $recordset['duedate']; ?></td>
			<td align="center"><?php echo number_format($recordset['payamount'], 2); ?></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
		</tr>
		<?php
	  		}
	  	?>	

	  	<tr>
	  		<th colspan="2">Total</th>
	  		<th><span>&#8369;</span> <?php echo number_format($total); ?></th>
	  		<th></th>
	  		<th></th>
	  		<th></th>
	  		<th></th>
	  	</tr>
	</table><br><br>

	<table class="content" style="width:60.5%; border-collapse: collapse;" border="0" >

		<p class="content">Please make any payment due, by electronic transfer to our GCash account:</p><br>
		<p class="content">Account Number: +639275188177</p>
		<p class="content">Account Name: LADZBILL</p>
		<br><br>

	<tr>
		<td>Prepared by</td>
		<td></td>
		<td>Checked by</td>
		<td></td>
		<td>Received by</td>
		<td></td>
	</tr>
	<tr style="height: 20px;">
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>		
		<td></td>
	</tr>
	<tr>
		<td style="border-top: 1px solid black;">Treasurer</td>	
		<td style="width: 100px;"></td>
		<td style="border-top: 1px solid black;">Loan Officer</td>	
		<td style="width: 100px;"></td>	
		<td style="border-top: 1px solid black;">Member</td>
		<td></td>
	</tr>
</table>

</div>
</body>
</html>