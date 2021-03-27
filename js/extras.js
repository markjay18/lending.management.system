
/* add expenses */
	function addexpenses(){	//add fields for expenses		
		for(var i=1;i<=35;i++){
			var control = document.getElementById("tr_"+i);	
			if(control!=null){				
				if(control.style.display=="none"){
					control.removeAttribute("style");
					document.expenses.expcount.value = i;
					break;
				}
			}
		}
	}
/* remove */
	function removeExp(){ //remove fields for expenses			
		for(var i=35;i>=1;i--){
			var cont = document.getElementById("tr_"+i);
			if(cont!=null){
				if(cont.style.display!="none"){
				cont.style.display="none";
				//var gross=document.getElementById("grosscoll");
				var grosstotal=document.getElementById("grosstotal");
				var totalexp=document.getElementById("totalexp");
				var bankdep=document.getElementById("bankdeposit");
				var x=document.getElementById("amount_"+i);
				var t= +totalexp.value - +x.value;
				var deposit= +grosstotal.value - +t;
				
				bankdep.value=deposit;
				x.value="";
				totalexp.value=t;
				
				document.expenses.expcount.value = i-1;
				break;
				}
			}
		}
	}
/* computation */
	function computeAmount(){
	var gross=document.getElementById("grosscoll").value;
	var grosstotal=document.getElementById("grosstotal").value;
	var oldcoh=document.getElementById("oldcoh").value;
	var bw=document.getElementById("bankwithdraw").value;
	var other_receipt=document.getElementById("other_receipt").value;
	var expcount=document.getElementById("expcount").value;
	var summ=0;
	var t=0;
	var a=0;
	var b=0;
	var totals=0;
		if(grosstotal!="" && expcount!=0){
			for(var i=0;i<=35;i++){

				summ +=parseFloat(document.getElementById("amount_"+(i+1)).value) || 0;
			var totalexp=document.getElementById("totalexp").value=summ.toFixed(2);
				a=parseFloat(grosstotal) - parseFloat(totalexp);
			var bankdep=document.getElementById("bankdeposit").value=a.toFixed(2);
				b= +totalexp + +bankdep;
				t=+grosstotal - +b;
				document.getElementById("coh").value=t.toFixed(2);
				document.getElementById("total").value=b.toFixed(2);

			}
		}else{
			/* alert("Enter Gross Collection First!.");
			document.getElementById("grosscoll").focus(); */
			for(var i=1;i<=35;i++){
				var con = document.getElementById("tr_"+i);
				if(con!=null){
				document.getElementById("amount_"+i).value="";
				con.style.display="none";
				}
			}
			totals=+oldcoh + +gross + +bw + +other_receipt;
			document.getElementById("coh").value=totals.toFixed(2);
			document.getElementById("bankdeposit").value="";
		}
	}
	function compAmount(){
	var z=0;
	var a=0;
	var g=document.getElementById("grosscoll").value;
	var gt=document.getElementById("grosstotal").value;
	var x=document.getElementById("totalexp").value;
	var y=document.getElementById("bankdeposit").value;
		if(gt==""){
			alert("Enter Gross Collection First!.");
			document.getElementById("grosscoll").focus();
			document.getElementById("totalexp").value="";
			document.getElementById("bankdeposit").value="";
		}else{
			z= +x + +y;
			a= +gt - +z;
			document.getElementById("coh").value=a.toFixed(2);
			document.getElementById("total").value=z.toFixed(2);
		}
	}
	
	function addOns(keys){
		
		var oldcoh=document.getElementById("oldcoh");
		var gross=document.getElementById("grosscoll");
		var bw=document.getElementById("bankwithdraw");
		var other_receipt=document.getElementById("other_receipt");
		var grosstotal=document.getElementById("grosstotal");
		
		var total=+oldcoh.value + +gross.value + +bw.value + +other_receipt.value;
		if(keys=="cashonhand" && oldcoh.value==""){
			grosstotal.value=total;
			computeAmount();
		}else if(keys=="bankwithdraw" && other_receipt.value==""){
			grosstotal.value=total;
			computeAmount();
		}else if(keys=="other_receipt" && other_receipt.value==""){
			grosstotal.value=total;
			computeAmount();
		}else{
			grosstotal.value=total;
			compAmount();
			var expc=document.expenses.expcount.value;
			if(expc!=0){
				computeAmount();
			}

		}
	}
	
/* add fields for beneficiaries */
	function addBeneficiary(){				
		for(var i=1;i<=10;i++){
			var control = document.getElementById("tr_"+i);	
			if(control!=null){				
				if(control.style.display=="none"){
					control.removeAttribute("style");
					document.membershipform.bencount.value = i;
					/* document.getElementById("tr_remove").style.display="block"; */
					break;
				}
			}
		}
	}
/* remove fields for beneficiaries */
function removeLast(){
	for(var i=10;i>=1;i--){
		var control = document.getElementById("tr_"+i);	
		if(control!=null){				
			if(control.style.display!="none"){
				control.style.display="none";
				
				document.getElementById("ben_first"+i).value="";
				document.getElementById("ben_mi"+i).value="";
				document.getElementById("ben_last"+i).value="";
				document.getElementById("date"+i).value="";
				document.getElementById("ben_age"+i).value="";
				document.getElementById("ben_relationship"+i).value="";
				
				document.membershipform.bencount.value= i - 1;
				break;
			}
		}
	}
}
/* calculate age */
function ageCount() { //looped text fields of age
	for(var i=1;i<=10;i++){
		var date1 = new Date();
		var dob= document.getElementById("date"+i).value;
		var date2=new Date(dob);
		var pattern =/^([0-9]{2})\/([0-9]{2})\/([0-9]{4})$/; //Regex to validate date format (mm/dd/yyyy)
		if (pattern.test(dob)) {
			if(dob!=null){
				var y1 = date1.getFullYear(); //getting current year
				var y2 = date2.getFullYear(); //getting dob year
				var age = y1 - y2;           //calculating age 
				document.getElementById("ben_age"+i).value=age;
			}
		} 
	}
}

function compAge(bdate, agefield){ //compute single age
	var date1 = new Date();
	var dateofbirth= document.getElementById(bdate).value;
	var date2=new Date(dateofbirth);
	var pattern =/^([0-9]{2})\/([0-9]{2})\/([0-9]{4})$/; //Regex to validate date format (mm/dd/yyyy)
	if (pattern.test(dateofbirth)) {
		if(dateofbirth!=null){
			var y1 = date1.getFullYear(); //getting current year
			var y2 = date2.getFullYear(); //getting dob year
			var m1= date1.getMonth();
			var m2= date2.getMonth();
			var age = y1 - y2; //calculating age
			var age1 = (m2+12*y2)-(m1+12*y1) + "months"; // in months
			/* if(age!=0) */
				document.getElementById(agefield).value=age;
			/* else
				document.getElementById("age").value=age1; */
			return true;
		}
	} 
}
function addORfield(){ //add o.r number text fields
	for(var i=1;i<=15;i++){
		var c=document.getElementById("trow_"+i);
		if(c!=null){
			if(c.style.display=="none"){
				c.removeAttribute("style");
				document.commvouchercbi.cvcount.value=i;
				break;
			}
		}
	}
}

function removeORfield(){ //remove fields for ornumber			
	for(var i=15;i>=1;i--){
		var c = document.getElementById("trow_"+i);
		if(c!=null){
			if(c.style.display!="none"){
			c.style.display="none";
			/* document.getElementById("amount_"+(i-35)).value=0; */
			document.commvouchercbi.cvcount.value = i-1;
			break;
			}
		}
	}
}

function addField(tr_row, counter){ //add text fields
	for(var i=1;i<=15;i++){
		var c=document.getElementById(tr_row+i);
		if(c!=null){
			if(c.style.display=="none"){
				c.removeAttribute("style");
				document.getElementById(counter).value=i;
				break;
			}
		}
	}
}

function removeField(tr_row, counter){ //remove fields
	for(var i=15;i>=2;i--){
		var c = document.getElementById(tr_row+i);
		if(c!=null){
			if(c.style.display!="none"){
			c.style.display="none";
			/* document.getElementById("amount_"+(i-35)).value=0; */
			document.getElementById(counter).value = i-1;
			break;
			}
		}
	}
}

function deActivate(url, id){
	if(confirm("Are you sure you want to Deactivate this user?")){
		window.location.href=url+id;
	}
}

function Activate(url, id){
	if(confirm("Are you sure you want to Activate this user?")){
		window.location.href=url+id;
	}
}

function addAsCollector(url, id){
	if(confirm("Are you sure you want to Add this user as Collector?")){
		window.location.href=url+id;
	}
}

function removeAsCollector(url, id){
	if(confirm("Are you sure you want to Remove this user as Collector?")){
		window.location.href=url+id;
	}
}
function confirmSubmit(){
	if(confirm('DO YOU REALLY WANT TO CONTINUE?')){
		return true;
	}else{
		return false;
	}
}
function allNumbers(inputs){   
    var numbers = /^[0-9]*\.?[0-9]*$/;  
      if(inputs.value.match(numbers))  {  
      return true;  
      }  else  {  
      alert('PLEASE INPUT NUMBERS ONLY');
		inputs.value="";
		inputs.focus();
      return false;  
      }  
}
function checkIfZero(input){
	var x = input.value;
	if(x==0 || x==null){
		alert("THE FIELD MUST NOT BE ZERO, PLEASE INPUT HIGHER THAN ZERO. (e.g. 1)");
		input.value="";
		input.focus();
		return false;  
	}else{
		return true;
	}
}

function randomString() {
	/* abcdefghiklmnopqrstuvwxyz ABCDEFGHIJKLMNOPQRSTUVWXTZ*/
	var chars = "0123456789";
	var string_length = 3;
	var randomstring = '';
	for (var i=0; i<string_length; i++) {
		var rnum = Math.floor(Math.random() * chars.length);
		randomstring += chars.substring(rnum,rnum+1);
	}
	//document.getElementById('rand').value=randomstring;
}

/* html table to excel */
/* function ToExcel(){ */
	var tableToExcel = (function() {
	  var uri = 'data:application/vnd.ms-excel;base64,'
		, template = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40"><head><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>{worksheet}</x:Name><x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]--><meta http-equiv="content-type" content="text/plain; charset=UTF-8"/></head><body><table>{table}</table></body></html>'
		, base64 = function(s) { return window.btoa(unescape(encodeURIComponent(s))) }
		, format = function(s, c) { return s.replace(/{(\w+)}/g, function(m, p) { return c[p]; }) }
	  return function(table, name) {
		if (!table.nodeType) table = document.getElementById(table)
		var ctx = {worksheet: name || 'Worksheet', table: table.innerHTML}
		window.location.href = uri + base64(format(template, ctx))
	  }
	})()
	/* <input type="button" onclick="tableToExcel('testTable', 'W3C Example Table')" value="Export to Excel">
	<table id="testTable"></table> */
/* } */

function loadXMLDoc()
{
var xmlhttp;
if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
    document.getElementById("myDiv").innerHTML=xmlhttp.responseText;
    }
  }
xmlhttp.open("GET","ajax_info.txt",true);
xmlhttp.send();
}
/* ------------------------- */
//Disable right mouse click Script
//By Maximus (maximus@nsimail.com) w/ mods by DynamicDrive
//For full source code, visit http://www.dynamicdrive.com
function disalbleRightClick(){
var message="Function Disabled!";

///////////////////////////////////
function clickIE4(){
if (event.button==2){
alert(message);
return false;
}
}

function clickNS4(e){
if (document.layers||document.getElementById&&!document.all){
if (e.which==2||e.which==3){
alert(message);
return false;
}
}
}

if (document.layers){
document.captureEvents(Event.MOUSEDOWN);
document.onmousedown=clickNS4;
}
else if (document.all&&!document.getElementById){
document.onmousedown=clickIE4;
}

document.oncontextmenu=new Function("alert(message);return false")
}
/* view/print */

function prints(){
	document.getElementById("prints").style.display='none';
	window.print();
}
function printSOA(){
	var pb = document.getElementById("pb");
	var cb = document.getElementById("cb");
	var pbn = document.getElementById("pbn");
	var cbn = document.getElementById("cbn");
	document.getElementById("pby").innerHTML = pb.value;
	document.getElementById("cby").innerHTML = cb.value;
	document.getElementById("pbyname").innerHTML = pbn.value;
	document.getElementById("cbyname").innerHTML = cbn.value;
	pb.style.display="none";
	cb.style.display="none";
	cbn.style.display="none";
	pbn.style.display="none";
	prints();

}
