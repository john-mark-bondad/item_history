

<?php
$columns = array(
    0 =>'sku',
    1 => 'product_name',
    2=>''
);

$pid=(isset($_GET['pid']))?$_GET['pid']:"";

$requestData= $_REQUEST; 

$srchtxt=trim($this->db->escape_str($requestData['search']['value']));


$length=$_REQUEST['length'];
$start=$_REQUEST['start'];
$order_by=$_REQUEST['order'][0]['column'];
$order_byorder=$_REQUEST['order'][0]['dir'];

$orderby="order by pid DESC";
if(isset($_REQUEST['order'])){
    $orderby=($columns[$order_by]=="")?"order by pid DESC":"order by ".$columns[$order_by]." $order_byorder";
}

$srch="";
if(isset($requestData['search']['value'])){
    $srch=" and 
    (sku like '%$srchtxt%' or
    product_name like '%$srchtxt%'
)";
}


$q1=$this->db->query("
    select * from across_product where remark='1' 
    $srch ");

$r1=$q1->result_array();

$q=$this->db->query("
    select * from across_product where remark='1'
    $srch  $orderby limit $start,$length");

$r=$q->result_array();
$tcnt=count($r);
$data=array();
for($x=0;$x<$tcnt;$x++){
    $pid=$r[$x]['pid'];
    $sku=$r[$x]['sku'];
    $product_name=$r[$x]['product_name'];

    $data[$x] = array(
       0=>"$sku 
       <input type='hidden' id='tbl_p_pid$x' value='$pid' />
       <input type='hidden' id='tbl_p_sku$x' value='$sku' />
       <input type='hidden' id='tbl_p_product_name$x' value='$product_name' />
       ",
       1=>"$product_name",
       2=>"<button class='btn btn-primary' style=' width:100%; font-size:15px;' title='Select Customer' onclick='SYS_select_product($x);' >
       <span class='glyphicon glyphicon-hand-up'></span>
       </button>"
   );

}


$json_data = array(
    "draw"            => intval( $_REQUEST['draw'] ),
    "recordsTotal"    => intval(count($r)),
    "recordsFiltered" => intval(count($r1)),
    "data"            => $data
);

echo json_encode($json_data);

?>