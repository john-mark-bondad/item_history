<?php

$columns = array(
  0 =>'d',
  1 => 's',
  2 => 'pn',
  3 => 'r',
  4 => 'q',
  5 => 'a',
  6 => 'n'

);

$sid=(isset($_GET['sid']))?$_GET['sid']:"";

$date_from=$_GET['date_from'];
$date_to=$_GET['date_to'];

$dfilter="";
if($date_from=="" && $date_to!=""){
$dfilter=" and (DATE_FORMAT(d.date_added,'%Y-%m-%d %H:%i:%s') <= '$date_to' )";
}
else if($date_from!="" && $date_to==""){
$dfilter=" and (DATE_FORMAT(d.date_added,'%Y-%m-%d %H:%i:%s') >= '$date_from')";
}
else if($date_from!="" && $date_to!=""){
$dfilter=" and (DATE_FORMAT(d.date_added,'%Y-%m-%d %H:%i:%s') >= '$date_from' && DATE_FORMAT(d.date_added,'%Y-%m-%d %H:%i:%s') <= '$date_to')"; 
}


$requestData= $_REQUEST; 

$srchtxt=trim($this->db->escape_str($requestData['search']['value']));


$length=$_REQUEST['length'];
$start=$_REQUEST['start'];
$order_by=$_REQUEST['order'][0]['column'];
$order_byorder=$_REQUEST['order'][0]['dir'];

$orderby="order by a.sid DESC";
if(isset($_REQUEST['order'])){
  $orderby=($columns[$order_by]=="")?"order by a.sid DESC":"order by ".$columns[$order_by]." $order_byorder";
}

$srch="";
if(isset($requestData['search']['value'])){
   // $srch = "and (product_name like '%$srchtxt%' or fname like '%$srchtxt%')";
  $srch = "and (fname like '%$srchtxt%' or receipt_num like '%$srchtxt%' or 
    DATE_FORMAT(date_added,'%Y-%m-%d %H:%i:%s') like '%$srchtxt%' or a.qty like '%$srchtxt%' or amount like '%$srchtxt%' or b.sku like '%$srchtxt%' or b.product_name like '%$srchtxt%' )";
}


// SELECT invoice_num, invoice_date from across_invoice union SELECT amount, qty from across_invoice_items union SELECT name, remark from across_c_person

// select * from across_invoice_items as a right join  across_invoice as b ON a.ssid=b.ssid right join  across_c_person as c ON c.remark='1'=a.remark='1' 

// select * from across_s_items as a RIGHT JOIN across_s_sales_receiptnum as b ON a.amount or b.receipt_num
$q1=$this->db->query(" SELECT a.amount a, a.qty q, b.sku s, b.product_name pn, c.receipt_num r,  DATE_FORMAT(d.date_added,'%Y-%m-%d %H:%i:%s') d, CONCAT(e.fname,' ',e.mname,' ',e.lname,' ',e.ename) as n
 FROM across_s_items as a 
INNER join across_product as b on a.sid=b.pid
INNER join across_s_sales_receiptnum as c on c.id=a.sid 
INNER join  across_transfer_product as d on d.trans_id=a.sid
INNER JOIN across_p_person as e on e.eid=a.sid
where a.remark='1' 
  $srch  $dfilter");

$r1=$q1->result_array();


$q=$this->db->query("SELECT a.amount a, a.qty q, b.sku s, b.product_name pn, c.receipt_num r,  DATE_FORMAT(d.date_added,'%Y-%m-%d %H:%i:%s') d, CONCAT(e.fname,' ',e.mname,' ',e.lname,' ',e.ename) as n
 FROM across_s_items as a 
INNER join across_product as b on a.sid=b.pid
INNER join across_s_sales_receiptnum as c on c.id=a.sid 
INNER join  across_transfer_product as d on d.trans_id=a.sid
INNER JOIN across_p_person as e on e.eid=a.sid
where a.remark='1'
 $srch $dfilter $orderby limit $start,$length");
$r=$q->result_array();


$sttt="";

if($x==0){
  $sttt="
 <input type='hidden' id='tbl_pinv_tot1' value='$tot1'/>
  <input type='hidden' id='tbl_pinv_tot2' value='$tot2'/>
   <input type='hidden' id='tbl_pinv_tot3' value='$tot3'/>
  ";
}


$tcnt=count($r);
$data=array();
for($x=0;$x<$tcnt;$x++){
  // $sid=$r[$x]['sid'];
  $date=$r[$x]['d'];
  $sku=$r[$x]['s'];
  $product_name=$r[$x]['pn'];
  $receipt_num=$r[$x]['r'];
  $qty=$r[$x]['q'];
  $amount=$r[$x]['a'];
  $customer=$r[$x]['n'];
  // $customer=$r[$x]['fname']." ".$r[$x]['ename'].", ".$r[$x]['lname']." ".$r[$x]['mname'];

  $data[$x] = array(
   0=>"$date
   <input type='hidden' id='tbl_pos_sid$x' value='$sid' />
    $sttt
   ",
   1=>"$sku",
   2=>"$product_name",
   3=>"$receipt_num",
   4=>"$qty",
   5=>"$amount",
   6=>"$customer"
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