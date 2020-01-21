<script type="text/javascript">


  function SYS_TableServerside(url,tbl){
    SYS_TableStart(tbl);  
    $(tbl).fadeIn(); 
    $(tbl).DataTable({
      "processing": true,
      "serverSide": true,
      "ajax": {
        "url": url,
        "dataType": "json",
        "error": function(jqXHR, textStatus, errorThrown){
          $(tbl+' tbody').html("<tr><td colspan='10'>No Results Found</td></tr>");
          $(tbl+' .dataTables_info').text("Showing 0 to 0 of 0 entries");
        }
      },
      "columnDefs":[{
        "target":[0,5],
        "orderable":false
      }]

    });
    $(tbl).css({'visibility':'visible'});
    /*$(tbl+" thead th").eq(0).click();*/
  }


  function setcont(n){
    $('.setcont').hide();
    $('#setcont'+n).show();	
  }


  // Choose product Button
  function SYS_choose_product(){

    $('#dialog2').remove();
    $('body').append("<div id='dialog2'></div>"); /*Creates a virtual DOM <div id='dialog1'></div>*/

    SYS_dialog3('#dialog2','700','700px','Product Options');
    $.post(URL+"index.php/item_history/loadItemHistoryProductTable",{mode:'add',pid:""}).done(function(data){
      $("#dialog2").html(data).dialog("open");
    });     
  }


// reset button
function SYS_reset_product(){  
  $('#form_product_name,#form_sku').val("");
}


function  SYS_product_tbl(){
  var link=URL+"index.php/item_history/loadItemHistoryProductSetlist";    
  SYS_TableServerside(link,'#t_maintable1');   
}


function SYS_TableServerside2(url,tbl){
  SYS_TableStart(tbl);  
  $(tbl).fadeIn(); 
  $(tbl).DataTable({
    "processing": true,
    "serverSide": true,
    "ajax": {
      "url": url,
      "dataType": "json",
      "error": function(jqXHR, textStatus, errorThrown){
        $(tbl+' tbody').html("<tr><td colspan='10'>No Results Found</td></tr>");
        $(tbl+' .dataTables_info').text("Showing 0 to 0 of 0 entries");
      }
    },
    "columnDefs":[{
      "target":[0,5],
      "orderable":false
    }]

  });
  $(tbl).css({'visibility':'visible'});
  /*$(tbl+" thead th").eq(0).click();*/
}


function setcont(n){
  $('.setcont').hide();
  $('#setcont'+n).show(); 
}


// When click
function SYS_select_product(x){

  var pid=$('#tbl_p_pid'+x).val();
  var product_name=$('#tbl_p_product_name'+x).val();
  var sku=$('#tbl_p_sku'+x).val();


  $('#form_pid').val(pid);
  $("#form_product_name").val(product_name);
  $('#form_sku').val(sku);

  $("#dialog2").dialog("close"); 

}

// Date Filters
function SYS_inventory_tbl(){ /*   var pdate = $('#search_date').val();  */
var link=URL+"index.php/item_history/loadItemHistoryInventorySetlist";
SYS_TableServerside2(link,"#t_maintable2"); 

}


function SYS_pos_sales_tbl(){
  var link=URL+"index.php/item_history/loadItemHistoryPosSalesSetlist";
  SYS_TableServerside2(link,'#t_maintable3');

}


function SYS_invoice_tbl(){

  var link=URL+"index.php/item_history/loadItemHistoryInvoiceSetlist";
  SYS_TableServerside2(link,"#t_maintable4"); 

}


function show_tbl_inv(n){
if(n==0){ $('#filter_i_pid').val("0"); search_item_history_tbl(); }
else if(n==1){ $('#filter_i_pid').val("1");  search_item_history_tbl(); }
else if(n==2){ $('#filter_i_pid').val("2");  search_item_history_tbl(); }


}





function search_item_history_tbl(){
  var pid=$('#filter_i_pid').val();

  var sid=$('#filter_i_sid').val();

  var invid=$('#filter_i_invid').val();

  var date_from=$('#form_datefrom').val();
  var date_to=$('#form_dateto').val();

// inventory
var link=URL+"index.php/item_history/loadItemHistoryInventorySetlist?name=Xssd23SqQ&date_from="+date_from+"&date_to="+date_to+"&pid="+pid;
SYS_TableServerside2(link,'#t_maintable2');


  // Pos Sales
var link=URL+"index.php/item_history/loadItemHistoryPosSalesSetlist?name=Xssd23SqQ&date_from="+date_from+"&date_to="+date_to+"&sid="+sid;
SYS_TableServerside2(link,"#t_maintable3"); 

// invoice
var link=URL+"index.php/item_history/loadItemHistoryInvoiceSetlist?name=Xssd23SqQ&date_from="+date_from+"&date_to="+date_to+"&invid="+invid;
SYS_TableServerside2(link,"#t_maintable4");


setInterval(function(){
var tot1=($('#tbl_pinv_tot1').val())?$('#tbl_pinv_tot1').val():0;
var tot2=($('#tbl_pinv_tot2').val())?$('#tbl_pinv_tot2').val():0;
var tot3=($('#tbl_pinv_tot3').val())?$('#tbl_pinv_tot3').val():0;

$('#soa_tot1').text(formatCurrency(tot1));
$('#soa_tot2').text(formatCurrency(tot2));
$('#soa_tot3').text(formatCurrency(tot3));

},1000);


}



</script>
