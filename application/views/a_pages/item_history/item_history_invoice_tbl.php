
<input type='hidden' id='filter_i_invid' value=''>
<!-- <input type='hidden' id='form_datefrom' value=''>
<input type='hidden' id='form_dateto' value=''> -->


<input type='hidden' id='filter_a' value=''>
<input type='hidden' id='filter_b' value=''>


<div style='margin-top:1%; padding:2%;' class='table-responsive'>

	<table class='table table-bordered table-striped table-condensed table-hover' id='t_maintable4'>
		<thead>
			<tr>
				<th style='width:150px;'>Date of Invoice</th>
				<th style='width:200px;'>Invoice#</th>
				<th style='width:150px;'>SKU</th>
				<th style='width:150px;'>Product Name</th>
				<th style='width:55px;'>Qty</th>
				<th style='width:150px;'>Amount</th>
				<th style='width:150px;'>Customer</th>
			</tr>
		</thead>
	</table>


</div>

<script type="text/javascript">
	$(document).ready(function(){

		SYS_invoice_tbl();	
		// search_item_history_tbl();
	});
	SYS.ready(function(){
$( ".datepicker" ).datepicker({
     changeMonth: true,
      changeYear: true,
    dateFormat: "yy-mm-dd"
  });	



});

</script>