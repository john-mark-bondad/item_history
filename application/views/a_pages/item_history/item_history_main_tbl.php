<div class='t_content' >
  <div id='t_header' style='margin-top:1%;'>
    <button class='btn btn-primary' style='' onclick="SYS_choose_product()"><span class='glyphicon glyphicon-plus'></span>Choose Product</button>
    <button class='btn btn-primary' style='' onclick="SYS_reset_product()" id="basic-addon1"><span class='glyphicon glyphicon-remove'></span>Reset</button>
  </div>

  <input type='hidden' id='filter_i_pid' value="" >
  <input type='hidden' id='filter_i_invid' value=''>

  <div id='product_tbl'>
    <div class='row' style='margin-top:1%;'>
      <div class='col-sm-12'>
        <div class="input-group"> 
          <span class="input-group-addon" id="basic-addon1" ><b>Product Name</b></span>
          <input type='text' id='form_product_name'  placeholder='Product Name'  class='form-control' style='background:#fff; width: 61.4%' disabled>
        </div>
      </div>
    </div>

    <div class='row' style='margin-top:0.5%;margin-bottom:1%;'>
      <div class='col-sm-12'>
        <div class="input-group"> 
          <span class="input-group-addon" id="basic-addon1" ><b>SKU</b></span>
          <input type='text'   id='form_sku' placeholder='SKU'  class='form-control' style='background:#fff; width: 63.8%' disabled>
        </div>
      </div>
    </div>
  </div>



  <!-- Date Filters -->
  <div class='row' style="margin-bottom: 1%;">
    <div class='col-sm-4'>
      <div class="input-group" > 
        <span class="input-group-addon" id="basic-addon1" ><b>Date(From)</b></span>
        <input type='text' id='form_datefrom' class='form-control datepicker'  placeholder="yyyy-mm-dd">
      </div>

    </div>
    <div class='col-sm-4'>

      <div class="input-group" > 
        <span class="input-group-addon" id="basic-addon1" ><b>Date(To)</b></span>
        <input type='text' id='form_dateto' class='form-control datepicker' placeholder="yyyy-mm-dd">
      </div>

    </div>
    <div class='col-sm-4'>
      <button class='btn btn-primary' onclick='search_item_history_tbl()'>Search</button>
    </div>
  </div>
  <div>




    <!-- Nav tabs -->
    <ul class="nav nav-tabs" role="tablist">
      <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab" onclick='show_tbl_inv(0)'>Inventory</a></li>
      <li role="presentation"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab" onclick='show_tbl_inv(1)'>Pos Sales</a></li>
      <li role="presentation" onclick='show_tbl_inv(2)'><a href="#profile1" aria-controls="profile1" role="tab" data-toggle="tab">Invoice</a></li>

    </ul>

    <!-- Tab panes -->
    <div class="tab-content">
      <div role="tabpanel" class="tab-pane active" id="home"><?php  $this->load->view("a_pages/item_history/item_history_inventory_tbl"); ?></div>
      <div role="tabpanel" class="tab-pane" id="profile"><?php  $this->load->view("a_pages/item_history/item_history_pos_sales_tbl"); ?></div>
      <div role="tabpanel" class="tab-pane" id="profile1"><?php  $this->load->view("a_pages/item_history/item_history_invoice_tbl"); ?></div>
    </div>

  </div>





  <script type="text/javascript">
    SYS.ready(function(){
      $( ".datepicker" ).datepicker({
       changeMonth: true,
       changeYear: true,
       dateFormat: "yy-mm-dd"
     }); 

    });

  </script>


