/*  jQuery ready function. Specify a function to execute when the DOM is fully loaded.  */
$(document).ready(function(){
  
  /* This is the function that will get executed after the DOM is fully loaded */
	$( "#birthdate" ).datepicker({
      changeMonth: true,//this option for allowing user to select month
      changeYear: true //this option for allowing user to select from year range
    });
	$( "#hbirthdate" ).datepicker({
      changeMonth: true,//this option for allowing user to select month
      changeYear: true //this option for allowing user to select from year range
    });	
	$( "#date" ).datepicker({
      changeMonth: true,//this option for allowing user to select month
      changeYear: true //this option for allowing user to select from year range
    });
	
	for(i=1; i<=20; i++){
	$( "#bdate1"+i ).datepicker({
      changeMonth: true,//this option for allowing user to select month
      changeYear: true //this option for allowing user to select from year range
    });
	}
});