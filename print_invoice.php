<?php 
include 'include/dbcon.php';
include 'session.php';
/*view admin userID*/
$ID=0;
if(isset($_GET['ID'])){
 $ID = $_GET['ID'];
}
 $sql="SELECT * FROM members WHERE ID='".$ID."'";
 $query=mysql_query($sql);
 $recordset=mysql_fetch_array($query);

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<title>Print Invoice</title>
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
	<p class="content">Re: Loan ID# : <?php echo  $recordset['accno']; ?></p>
	<p class="content">Invoice# : <?php echo  $recordset['invoice']; ?></p>
	<p class="content">Reference OR# : <?php echo  $recordset['ref']; ?></p><br>
	<p class="content" style="text-align: center; font-size: 20px;"><strong>INVOICE</strong></p><br>
	<p class="content">Member's Name: <input type="text" style="margin-right: 110px;" class="view_input" name="" value="<?php echo $recordset['fullname']; ?>">Print Date: <?php date_default_timezone_set("ASIA/MANILA"); echo "". date('m-d-Y');?></p><br>
	<button type="button" id="hide" onclick="printledger('hide');" style=" cursor: pointer; margin-left: 50%;">Print</button>
	<p class="content">Activity List</p><br>
	<table class="content" style="width:60%; border-collapse: collapse;" border="0">

		<?php 
			$total_balance=$recordset['amountloan']-$recordset['service_fee'];
		?>
		<tr style="border-bottom: 1px solid black;">
			<th width="20px">Description</th>
			<th width="20px">Debit</th>
			<th width="20px">Credit</th>
			<th width="20px">Balance</th>
		</tr>
	
		<tr>
			<td align="left">Actual Loan Balance</td>
			<td align="center"><?php echo number_format($recordset['balance'], 2);?></td>
			<td align="center"></td>
			<td align="center"><?php echo number_format($recordset['balance'], 2);?></td>
		</tr>
		<tr>
			<td align="left">Principal Applied</td>
			<td align="center"></td>
			<td align="center"><?php echo number_format($recordset['amountloan'], 2);?></td>
			<td align="center"><?php echo number_format($recordset['amountloan'], 2);?></td>
		</tr>
		<tr>
			<td align="left">Disbursement</td>
			<td align="center">0.00</td>
			<td align="center"></td>
			<td align="center"></td>
		</tr>
		<tr>
			<td align="left">Minus Service fee</td>
			<td align="center"><?php echo number_format($recordset['service_fee'], 2);?></td>
			<td align="center"></td>
			<td align="center"><?php echo number_format($recordset['service_fee'], 2);?></td>
		</tr>
		

	  	<tr style="border-top: 1px solid black;">
	  		<th></th>
	  		<th></th>
	  		<th>Amount Recieved</th>
	  		<th><span>&#8369;</span> <?php echo number_format($total_balance, 2); ?></th>
	  	</tr>
	  
	</table><br>
	<p class="content">Please Note: If your payment is recieved more than 10 days past prior to the due date, an additional late fee of <span>&#8369;</span> 25.00 is to be include.</p><br><br>

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