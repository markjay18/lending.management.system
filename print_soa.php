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

 $sql="SELECT * FROM members WHERE accno='".$accno."'";
 $queryQ=mysql_query($sql);
 $recordsetQ=mysql_fetch_array($queryQ);

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<title>Print SOA</title>
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
	<p><strong style="color: #81386e; font-size: 30px;">|LADZ</strong>BILL</p><br>
	<p class="content">From :</p>
	<p class="content">Guadalupe Viejo,</p>
	<p class="content">Rosal St. 6946 Makati City</p>
	<p class="content">1211 Metro Manila Philippines</p><br>
	<p class="content">Re: Loan ID# : <?php echo  $recordset['accno']; ?></p>
	<p class="content" style="text-align: center; font-size: 20px;"><strong>Statement of Account (S.O.A)</strong></p><br>
	<p class="content">To : <input type="text" style="margin-right: 300px;" class="view_input" name="" value="<?php echo $recordset['name']; ?>">Statement Date: <?php date_default_timezone_set("ASIA/MANILA"); echo "". date('m-d-Y');?></p>
	<p class="content"><?php echo $recordsetQ['address']; ?></p><br>
	<button type="button" id="hide" onclick="printledger('hide');" style=" cursor: pointer; margin-left: 50%;">Print</button>
	<p class="content">Statement Master List</p><br>
	<table class="content" style="width:60%; border-collapse: collapse;" border="0" id="tbl">
		<tr style="border-bottom: 1px solid black;">
			<th width="20px">#</th>
			<th width="150px">Due Date</th>
			<th width="150px">Date Settled</th>
			<th width="150px">Reference OR#</th>
			<th width="150px">Actual Payment</th>
			<th width="150px">Extra Payment</th>
			<th width="150px">Amount</th>
		</tr>
		<?php
		 $sql="SELECT * FROM ledger WHERE accno='".$accno."'";
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
			$sql="SELECT * FROM ledger WHERE accno='".$accno."'";
	 		$query=mysql_query($sql);
	 		$num_rows=0;
	 		while($recordset=mysql_fetch_array($query)){
	 			$num_rows++;
	 			$amount+=$recordset['payamount'];
	 			$payment+=$recordset['payment'];
	 			$extra+=$recordset['extrapay'];
	 			$total=$amount-$payment-$extra;
			?>


		<tr>
			<td align="center"><?php echo $num_rows; ?></td>
			<td align="center"><?php echo $recordset['duedate']; ?></td>
			<td align="center"><?php echo $recordset['update_date']; ?></td>
			<td align="center"><?php echo $recordset['ref']; ?></td>
			<td align="center"><?php echo $recordset['payment']; ?></td>
			<td align="center"><?php echo $recordset['extrapay']; ?></td>
			<td align="center"><?php echo $recordset['payamount']; ?></td>
		</tr>
		<?php
	  		}
	  	?>	

	  	<tr style="border-top: 1px solid black;">
	  		<th colspan="2"></th>
	  		<th></th>
	  		<th></th>
	  		<th></th>
	  		<th style="text-align: right;">Current Balance</th>
	  		<th><span>&#8369;</span> <?php echo $total; ?></th>
	  	</tr>
	  	<tr>
	  		<th colspan="2"></th>
	  		<th></th>
	  		<th></th>
	  		<th></th>
	  		<th style="text-align: right; border-top: 1px solid black;">Additional Interest</th>
	  		<th style="border-top: 1px solid black;"><?php 
	  			$sql="SELECT * FROM members WHERE accno='".$accno."'";
 				$query=mysql_query($sql);
 				$recordset=mysql_fetch_array($query);
 				$row=$recordset['add_interest'];
 				if($recordset['status']=='Overdue'){
 					echo $row;
 				}else{
 					echo '0';
 				}
	  		?></th>
	  	</tr>
	  	<tr>
	  		<th colspan="2"></th>
	  		<th></th>
	  		<th></th>
	  		<th></th>
	  		<th style="text-align: right; border-top: 1px solid black;">Amount Overdue</th>
	  		<th style="border-top: 1px solid black;"> 
	  		<?php 
	  			$sql="SELECT * FROM members WHERE accno='".$accno."'";
 				$query=mysql_query($sql);
 				$recordset=mysql_fetch_array($query);
 				$row=$recordset['balance'];
 				if($recordset['status']=='Overdue'){
 					echo '<span>&#8369;</span>'.$row;
 				}else{
 					echo '0';
 				}
	  		?></th>
	  	</tr>
	</table><br><br>
	<p class="content">If you have any question with this statement please contact our support Markjay Lajada on: +639275188177 or send an email at support@gmail.com.</p><br>
	<p class="content">Please make any payment due, by electronic transfer to our GCash account:</p><br>
	<p class="content">Account Number: +639275188177</p>
	<p class="content">Account Name: LADZBILL</p><br><br>

<table class="content" style="width:60.5%; border-collapse: collapse;" border="0" >

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