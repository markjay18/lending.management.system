<?php
include 'include/dbcon.php';

$output="";
$sql="SELECT * FROM members WHERE accno LIKE '%".$_POST["searchQ"]."%' OR fullname LIKE '%".$_POST["searchQ"]."%' OR status LIKE '%".$_POST["searchQ"]."%'" or die("could not search");
$result=mysql_query($sql);
if(mysql_num_rows($result) > 0)
{	
			$output .='<table style="width: 96%;" >
					<tr>
					<th style="width: 90px;">Action</th>
					<th>Account No.</th>
					<th>Name</th>
					<th>Date</th>
					<th>Loan</th>
					<th>Balance</th>
					<th>Add. Interest</th>
					<th>Acc. Status</th>
					<th>Sponsor</th>
					</tr>';
		 			while($row = mysql_fetch_array($result)){
			$output .='<tr>
					<td><a href="release.php?ID='.$row['ID'].'" target="_blank"><input type="button" name="" id="info" value="Loan" style="width:50%;"></a></td>
					<td><a href="disbursement_view.php?ID='.$row['ID'].'" target="_blank">'.$row['accno'].'</a></td>
					<td>'.$row['fullname'].'</td>
					<td>'.$row['dater'].'</td>
					<td>'.$row['amountloan'].'</td>
					<td>'.$row['balance'].'</td>
					<td>'.$row['add_interest'].'</td>
					<td>'.$row['status'].'</td>
					<td>'.$row['sponsor'].'</td>';
		 }
					echo $output;
}
else
{
	echo '<p class="err">Data Not Found.</p>';  
}
?>