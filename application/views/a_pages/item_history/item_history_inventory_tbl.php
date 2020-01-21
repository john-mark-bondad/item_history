
<input type='hidden' id='filter_i_pid' value=''>
<!-- <input type='hidden' id='form_datefrom' value=''>
<input type='hidden' id='form_dateto' value=''> -->


<div style='margin-top:1%; padding:2%;' class='table-responsive'>

<table class='table table-bordered table-striped table-condensed table-hover'  id='t_maintable2' >
<thead>
<tr>

<!-- <th style='width:5px;'></th> -->
<th style='width:150px;'>Date</th>
<th style='width:150px;'>SKU</th>
<th style='width:150px;'>Product Name</th>
<th style='width:150px;'>Type</th>
<th style='width:150px;'>Qty</th>
<th style='width:150px;'>Transacted by</th>

</tr>
</thead>
</table>


</div>
<script type="text/javascript">
$(document).ready(function(){

 SYS_inventory_tbl();	
});

SYS.ready(function(){
$( ".datepicker" ).datepicker({
     changeMonth: true,
      changeYear: true,
    dateFormat: "yy-mm-dd"
  });	



});

</script>
</script>