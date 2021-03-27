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
	<title>Generate Income Statement</title>
</head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="jquery-ui-1.10.4.customs/themes/base/jquery.ui.all.css">
	<script src="js/jquery-1.10.2.js"></script>
	<script src="jquery-ui-1.10.4.customs/ui/jquery.ui.core.js"></script>
	<script src="jquery-ui-1.10.4.customs/ui/jquery.ui.widget.js"></script>
	<script src="jquery-ui-1.10.4.customs/ui/jquery.ui.tabs.js"></script>
	<script src="jquery-ui-1.10.4.customs/ui/jquery.ui.datepicker.js"></script>
	<script src="jquery-ui-1.10.4.customs/ui/jquery.ui.dialog.js"></script>
	<script src="js/jquery-1.10.2.js"></script>
	<script src="js/bootstrap.js"></script>

	<link href="css/print.css" rel="stylesheet">

	<script type="text/javascript">
		function printledger(btn_id){
		document.getElementById(btn_id).style.display="none";
		document.getElementById('export').style.display="none";
		document.getElementById('selected').style.display="none";
		window.print();
	}
	</script>
	<script type="text/javascript">
		$(document).ready(function(){
		$('#year').change(function(){
			$('#for').val($('#year').val());
		});	
	});	
	</script>
<body>
<div class="container">
	<p><strong style="color: #81386e; font-size: 30px;">|LADZ</strong>BILL</p>
	<p class="content">Guadalupe Viejo,</p>
	<p class="content">Rosal St. 6946 Makati City</p>
	<p class="content">1211 Metro Manila Philippines</p><br>
	<p class="content" style="text-align: center; font-size: 20px;"><strong>INCOME STATEMENT</strong></p><br>
	<p class="content" style="text-align: center; font-size: 20px; margin-left: 15px;">FOR THE YEAR: <input type="text" id="for" style="width: 50px; font-size: 20px;" class="view_input" name=""></p><br>
	<div id="export" style="width: 96%; display: inline-flex;"><label class="content" >
		<form method="POST">
			Start Date : </label><input type="date" class="content" style="font-size: 15px;" id="date" name="from" autocomplete="off" value="" required>
			<label style="margin-top: 4px; margin-left: 10px; ">End Date : </label><input type="date" class="content" style="font-size: 15px;" id="dater" name="to" autocomplete="off" value="" required>
			<label class="content" style="margin-top: 4px; margin-left: 10px;">
			<button name="submit" id="passed" style="width: 120px; height: 25px; margin-left: 10px; cursor: pointer;"><i class="fa fa-search"></i> Generate Report</button>
		</form>
	</div>
	<table border="1" style="display: none;">
			<tr>
				<th>Date</th>
				<th>Amount</th>
				<th>Invoice#</th>
				<th>OR#</th>
				<th>Interest</th>
				<th>Number of Payment</th>
				<th>Temure (month)</th>
				<th>Service Fee</th>
				<th>Open Balance</th>
			</tr>
			<?php  
			if(isset($_POST['submit'])){
				$from=date('m-d-Y', strtotime($_POST['from']));
				$to=date('m-d-Y', strtotime($_POST['to']));

			$sql="SELECT * FROM loan WHERE date_loan BETWEEN '$from' AND '$to'";
	 		$query=mysql_query($sql);
	 		while($recordset=mysql_fetch_array($query)){
	 			$total_settled+=$recordset['amountloan'];
	 			$total_settled_open+=$recordset['balance'];
	 			$total_fee+=$recordset['service_fee'];
			?>
			<tr>
				<td><?php echo $recordset['date_loan']; ?></td>
				<td><?php echo $recordset['amountloan']; ?></td>
				<td><?php echo $recordset['invoice']; ?></td>
				<td><?php echo $recordset['ref']; ?></td>
				<td><?php echo $recordset['interest_rate']; ?></td>
				<td><?php echo $recordset['num_pay']; ?></td>
				<td><?php echo $recordset['loan_due']; ?></td>
				<td><?php echo $recordset['service_fee']; ?></td>
				<td><?php echo $recordset['balance']; ?></td>
			</tr>
			<?php
	  		}
	  		}
	  		?>
	  		<tr>
	  			<td style="text-align: center; color: #009879;">Total</td>
	  			<td style="color: #009879;"><?php echo number_format($total_settled); ?></td>
	  			<td></td>
	  			<td></td>
	  			<td></td>
	  			<td></td>
	  			<td></td>
	  			<td style="color: #009879;"><?php echo number_format($total_fee, 2); ?></td>
	  			<td style="color: #009879;"><?php echo number_format($total_settled_open, 2); ?></td>
	  		</tr>
	</table>

	<table border="1" style="display: none;">
			<tr>
				<th>Create Date</th>
				<th>Name</th>
				<th>Amount</th>
				<th>Extra</th>
				<th>Method</th>
				<th>Actual Payment</th>
				<th>Last Update</th>
				<th>profit</th>
				<th>Operator</th>
				<th>Remarks</th>
			</tr>
			<?php
				
			if(isset($_POST['submit'])){
				$from=date('m-d-Y', strtotime($_POST['from']));
				$to=date('m-d-Y', strtotime($_POST['to']));

		
		
				$sql="SELECT * FROM ledger WHERE update_date BETWEEN '$from' AND '$to' AND payment!=''";
	 			$query=mysql_query($sql);
	 			while($recordset=mysql_fetch_array($query)){
	 				$total_profit+=$recordset['profit'];
	 	
			?>
			
			<tr>
				<td id="td"><?php echo $recordset['duedate']; ?></td>
				<td><?php echo $recordset['name']; ?></td>
				<td><?php echo $recordset['payamount']; ?></td>
				<td><?php echo $recordset['extrapay']; ?></td>
				<td><?php 
				if($recordset['method']=='Cash'){
					echo '<span style="color: white; background: #ffc107; border-radius: 4px;">'; 
					echo  $recordset['method'];
					echo '</span>';
					}
					if($recordset['method']=='GCash'){
					echo '<span style="color: white; background: blue; border-radius: 4px;">'; 
					echo  $recordset['method'];
					echo '</span>';
					} 

				?></td>
				<td><?php echo $recordset['payment']; ?></td>
				<td><?php echo $recordset['update_date']; ?></td>
				<td><?php echo $recordset['profit']; ?></td>
				<td><?php echo $recordset['operator']; ?></td>
				<td><?php echo $recordset['remarks']; ?></td>
				
			</tr>

			<?php
			}
			}
			?>
			<p class="content" id="selected" style="margin-top: 20px; margin-bottom: 20px;"> Year : </label>
			<select type="text" name="remarks" id="year" class="content" style=" width: 80px; height: 25px; font-size: 15px;" required>
					<option selected></option>
					<option>2020</option>
					<option>2021</option>
					<option>2022</option>
					<option>2023</option>
					<option>2024</option>
					<option>2025</option>
					<option>2026</option>
			</select></p>
		<p class="content">Activity List</p><br>
	<table class="content" style="width:60%; border-collapse: collapse;" border="0">
		<tr style="border-bottom: 1px solid black;">
			<th width="20px">Description</th>
			<th width="20px">Debit</th>
			<th width="20px">Credit</th>
			<th width="20px">Total</th>
		</tr>
	
		<tr>
			<td align="left">Total Loan Released</td>
			<td align="center"><?php echo number_format($total_settled, 2);?></td>
			<td align="center"></td>
			<td align="center"><?php echo number_format($total_settled, 2);?></td>
		</tr>

		<tr>
			<td align="left">GROSS INCOME</td>
			<td align="center"></td>
			<td align="center"></td>
			<td align="center"></td>
		</tr>
		<tr>
			<td align="right">Interest Income</td>
			<td align="center"></td>
			<td align="center"><?php echo number_format($total_profit, 2);?></td>
			<td align="center"><?php echo number_format($total_profit, 2);?></td>
		</tr>
		<tr>
			<td align="right">Service Fee Income</td>
			<td align="center"></td>
			<td align="center"><?php echo number_format($total_fee, 2);?></td>
			<td align="center"><?php echo number_format($total_fee, 2);?></td>
		</tr>
		<?php 
			$gross_income=$total_profit+$total_fee;
		?>

	  	<tr style="border-top: 1px solid black;">
	  		<th></th>
	  		<th></th>
	  		<th>Total GROSS INCOME</th>
	  		<th><span>&#8369;</span> <?php echo number_format($gross_income, 2); ?></th>
	  	</tr>
	  
	</table><br>
	<button type="button" id="hide" onclick="printledger('hide');" style=" cursor: pointer; height: 25px;">Print</button><br><br>

<table class="content" style="width: 30%; border-collapse: collapse;" border="0" >

	<tr>
		<td>Prepared by</td>
		<td></td>
	</tr>
	<tr style="height: 20px;">
		<td></td>
		<td></td>
		
	</tr>
	<tr>
		<td style="border-top: 1px solid black;">Manager</td>	
		<td style="width: 50px;"></td>
		
	</tr>
</table>

</div>
</body>
</html>