<?php 
include 'include/dbcon.php';
include 'session.php';
 /*Get members account number*/
$ID=0;
if(isset($_GET['ID'])){
 $ID = $_GET['ID'];
}
  $sql="SELECT * FROM members WHERE ID='".$ID."'";
  $query=mysql_query($sql);
  $recordsetQ=mysql_fetch_array($query);

	if(isset($_POST['submit'])){
		$accno = $_POST['accno'];
		$duedate = $_POST['duedate'];
		$name = $_POST['name'];
		$payamount= $_POST['payamount'];
		$profit= $_POST['profit'];
		$comment = $_POST['comment'];
	/*insert data from table rows.*/
	foreach ($accno as $key => $value) {

		$sql = "INSERT INTO ledger(accno, duedate, name, payamount, profit, comment) VALUES ('".$value."', '".$duedate[$key]."', '".$name[$key]."', '".$payamount[$key]."', '".$profit[$key]."', '".$comment[$key]."')"; 
		$insertl = mysql_query($sql) or die(mysql_error());

		}

		$status = $_POST['status'];
		$amountloan = $_POST['amountloan'];
		$balance = $_POST['balance'];
		$service_fee = $_POST['service_fee'];
		$invoice = $_POST['invoice'];
		$ref = $_POST['ref'];

		$sql="UPDATE members SET status='Active',  amountloan='".$amountloan."', balance='".$balance."', service_fee='".$service_fee."', invoice='".$invoice."', ref='".$ref."' WHERE ID='".$ID."'";
		$update = mysql_query($sql) or die(mysql_error());

		$accnumber = $_POST['accnumber'];
		$date_loan = $_POST['date_loan'];
		$amountloan = $_POST['amountloan'];
		$interest_rate = $_POST['interest_rate'];
		$num_pay = $_POST['num_pay'];
		$loan_due = $_POST['loan_due'];
		$service_fee = $_POST['service_fee'];
		$balance = $_POST['balance'];
		$invoice = $_POST['invoice'];
		$ref = $_POST['ref'];
		$processed_by = $_POST['processed_by'];


		$sql = "INSERT INTO loan(accnumber, date_loan, amountloan, interest_rate, num_pay, loan_due, service_fee, balance, invoice, ref, processed_by) VALUES ('".$accnumber."', '".$date_loan."', '".$amountloan."', '".$interest_rate."', '".$num_pay."', '".$loan_due."', '".$service_fee."', '".$balance."', '".$invoice."', '".$ref."', '".$processed_by."')";
		$insert = mysql_query($sql) or die(mysql_error());


		header('Location: print_invoice.php?ID='.$recordsetQ['ID']);

}

	

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Loan Release</title>
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

	<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="/resources/demos/style.css">
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

<link href="css/dashboard.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.3/css/font-awesome.min.css">
<script type="text/javascript">
	var x = setInterval(mytimer, 1000);

	function mytimer() {
		var d = new Date();
		document.getElementById('clock').innerHTML = d.toLocaleTimeString();
	}
</script>
<script type="text/javascript">
	$(document).ready(function(){
		$('#btn').hide();
		$('#frame').css({'margin-left':'13%', 'width':'87%'}, "slow");
		$('#btn').click(function(){
			$('nav').show("slow");
			$('#frame').css({'margin-left':'13%', 'width':'87%'}, "slow");
			$('#btn').hide();
		});
		$('#cancel').click(function(){
			$('nav').hide("slow");
			$('#frame').css({'margin-left':'6%', 'width':'94%'}, "slow");
			$('#btn').show();
		});
	});
</script>
<script>
	/*autocomplete field open_balance script*/
$(document).ready(function (){
$('#principal_amount').change(function (){
		var principal = ($(this).val());
		var int = $('#interest').val(); 
		var sum = parseFloat(principal) * parseFloat(int) + parseFloat(principal);
		$("#open_balance").val(sum);
		
	});		
});
</script>
<script>
	/*autocomplete field open_balance script*/
$(document).ready(function (){
$('#principal_amount').change(function (){
		var principal = ($(this).val());
		var int = $('#interest').val(); 
		var sum = parseFloat(principal) * parseFloat(int);
		$("#income").val(sum);
		
	});		
});
</script>
<script>
	/*autocomplete field payment_amount script*/
$(document).ready(function (){
$('#number_payment').change(function (){
		var open = ($(this).val());
		var number = $('#open_balance').val(); 
		var divide = parseFloat(number) / parseFloat(open);
		$("#payment_amount").val(divide);
		
	});		
});
</script>
<script>
	/*autocomplete field payment_amount script*/
$(document).ready(function (){
$('#number_payment').change(function (){
		var open = ($(this).val());
		var number = $('#income').val();  
		var divide = parseFloat(number) / parseFloat(open);
		$("#income").val(divide);
		
	});		
});
</script>
<script>
	/*autocomplete field payment_amount script*/
$(document).ready(function (){
$('#number_payment').change(function (){
		var open = ($(this).val());
		var number = $('#open_balance').val(); 
		var amount = $('#payment_amount').val(); 
		var sub = parseFloat(number) - parseFloat(amount);
		$("#total").val(sub);
		
	});		
});
</script>
<script type="text/javascript">
	$(document).ready(function (){
		var html = '<tr><td><input type="text" style="font-size: 16px; border: none; color: #81386e;" name="accno[]" readonly value="<?php echo $recordsetQ['accno']; ?>"></td><td><input type="text" style="font-size: 16px; padding: 5px;" id="due_date" name="duedate[]" placeholder="--/--/----" required></td><td><input type="text" style="font-size: 16px; border: none; color: #81386e;" name="name[]" readonly value="<?php echo $recordsetQ['fullname']; ?>"></td><td><input type="text" style="font-size: 16px; padding: 5px; width: 150px;" id="payment_amount" value="" name="payamount[]" required></td><td><input type="text" style="font-size: 16px; padding: 5px; width: 150px;" id="profit" value="" name="profit[]" required></td><td><input type="text" style="font-size: 16px; border: none; color: #81386e;" readonly name="comment[]" value="N/A"></td><td><button name="add" id="info" class="remove" style="width:100%; background: #f2574f;"><i class="fa fa-trash"></i></button></td></tr>';


		$('#info').click(function(){
			$('#customers').append(html);
		});
		$('#customers').on('click','.remove', function(){
			$(this).closest('tr').remove();
		});
		});
</script>
<script>
	$(document).ready(function(){
  
  /* This is the function that will get executed after the DOM is fully loaded */
	$( "#due_date" ).datepicker({
	  dateFormat: 'mm-dd-yy',
      changeMonth: true,//this option for allowing user to select month
      changeYear: true //this option for allowing user to select from year range
    });
});
</script>
<script type="text/javascript">
		function confirmed(){
			alert("Data has been saved.");
		}
</script>
<body>
	<div class="header">
		<p class="logo"><strong>|LADZ</strong>BILL</p>
			<p class="id">
				<p class="time"><?php date_default_timezone_set("ASIA/MANILA"); echo "". date('m-d-Y');?> | <p id="clock"></p></p> 
				<p class="name">|Lord:</p> 
				<input type="text" name="operator" class="acc" value="<?php echo "" .$_SESSION['uid']; ?>" size="14px;" readonly >
			</p>
		<button><a href="logout.php" onclick="return confirm('Are you sure you want to logout?')">Logout</a></button>
	</div>	
		<label>
			<i class="fa fa-bars" id="btn"></i>
		</label>
	<nav>
		<header></header>
		<ul>
			<li><a href="dashboard.php"><i class="fa fa-dashboard"></i> Dashboard</a></li>
			<li><a href="membership.php"><i class="fa fa-user-plus"></i> Association</a></li>
			<li><a href="" class="<?php echo (!isset($_GET['page'])) ? "active" : ""; ?>"><i class="fa fa-user"></i> Personal Loan</a></li>
			<li><a href="marketing.php"><i class="fa fa-calendar-check-o"></i> Marketing</a></li>
			<li><a href="collection.php"><i class="fa fa-money"></i> Collections</a></li>
			<div id="cancel"><</div>
		</ul>
	</nav>

	<div id="frame">
			<p class="dash">Loan Release</p>
					<p class="direction">Loan Management System > Personal Loan > Loan Release > Create</p>
					<p class="line"></p>
					<?php
					  $sql="SELECT * FROM members WHERE ID='".$ID."'";
  					  $query=mysql_query($sql);
  					  $recordsetQ=mysql_fetch_array($query);
  					  if($recordsetQ['balance']!='0'){
  					  	echo '<p class="err">This member is not yet elligible for loan. Please settle previous payment before proceeding to the next loan. Current Balance: '.$recordsetQ['balance'].'</p>';
  					  }else{
  					  	echo '<p class="succ">Please fill all fields are required.</p>';
  					  }

					?>
		<form method="POST" onsubmit="return confirmSubmit('Please review all the details below before proceeding.')">	

						<label>Account Number : </label>
							<input type="text" name="accnumber" class="view_input" value="<?php echo $recordsetQ['accno']; ?>" readonly required>
						<br><br>

						<div style="float: left; width: 20%;">
							<label>Interest Rate *</label>
							<select type="text" id="interest" name="interest_rate" class="input" value="" required>
								<option selected>0.10</option>
								<option>0.125</option>
								<option>0.15</option>
							</select>
						</div>


						<div style="float: left; width: 20%; margin-left: 20px; ">
							<label>Principal Loan * </label>
							<input type="text" id="principal_amount" name="amountloan" class="input" value="" required>
						</div>

						<div style="float: left; width: 20%; margin-left: 20px; ">
							<label>Number of Payment * </label>
							<input type="text" id="number_payment" name="num_pay" class="input" value="" required>
						</div>

						<div style="float: left; width: 20%; margin-left: 20px; ">
							<label>Loan Duration (month) * </label>
							<input type="text" name="loan_due" class="input" value="" required>
						</div>

						<div style="width: 20%;">
						<label>Service Fee * </label>
						<input type="text" name="service_fee" class="input" value="" required>
						</div>

						<div style="float: left; width: 20%; ">
							<label>Invoice# * </label>
							<input type="text" name="invoice" class="input" value="" required>
						</div>

						<div style="float: left; width: 20%; margin-left: 20px;">
							<label>Reference OR# * </label>
							<input type="text" name="ref" class="input" value="" required>
						</div><br>

						<div style="width: 20%;">
						<label>Open Balance (autocomplete) : </label>
						<input type="text" id="open_balance" style="font-size: 28px; background: white; color: #81386e;" name="balance" class="view_input" value="" placeholder="---" readonly>
						</div>

						<input type="hidden" name="date_loan" class="acc" value="<?php date_default_timezone_set("ASIA/MANILA"); echo "". date('m-d-Y');?>" required>
						<input type="hidden" name="processed_by" value="<?php echo "" .$_SESSION['uid']; ?>">

		<p class="top">Please Add Member Schedule Payment :</p>
		<table id="customers" style="width: 96%;">
			<tr>
				<th>Account No.</th>
				<th>Date</th>
				<th>Name</th>
				<th>Payment Amount</th>
				<th>Interest</th>
				<th>Remarks</th>
				<th>Action</th>
			</tr>

			<tr>
				<td><input type="text" style="font-size: 16px; border: none; color: #81386e;" name="accno[]" readonly value="<?php echo $recordsetQ['accno']; ?>"></td>
				<td><input type="text" style="font-size: 16px; padding: 5px;" id="due_date" name="duedate[]" placeholder="--/--/----" autocomplete="off" required /></td>
				<td><input type="text" style="font-size: 16px; border: none; color: #81386e;" name="name[]" readonly value="<?php echo $recordsetQ['fullname']; ?>"></td>
				<td><input type="text" style="font-size: 16px; padding: 5px; border-radius: 4px; border: 1px solid rgb(245 245 245); width: 150px;" id="payment_amount" name="payamount[]" required placeholder="auto" readonly></td>
				<td><input type="text" style="font-size: 16px; padding: 5px; border-radius: 4px; border: 1px solid rgb(245 245 245); width: 150px;" id="income" name="profit[]" placeholder="auto" required readonly></td>
				<td><input type="text" style="font-size: 16px; border: none; color: #81386e;" readonly name="comment[]" value="N/A"></td>
				<td><button name="add" id="info" style="width: 70%;"><i class="fa fa-plus"></i></button></td>
			</tr>

		</table>
						<p class="line"></p>
						<button class="button" name="submit" style=" float: left; width: 6%;" onclick="confirmed()"><i class="fa fa-save"></i> Post</button>
		</form>

	</div>

	<div class="footer">
		<p>- LADZBILL | Version 1.0.0.1 @ 2021</p>
	</div>
</body>
</html>
</html>