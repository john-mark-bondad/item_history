<?php

$columns = array(
  0 =>'idt',
  1 => 'inm',
  2 => 's',
  3 => 'pn',
  4 => 'q',
  5 => 'a',
  6 => 'c'

);

$invid=(isset($_GET['invid']))?$_GET['invid']:"";

$date_from=$_GET['date_from'];
$date_to=$_GET['date_to'];

$dfilter="";
if($date_from=="" && $date_to!=""){
$dfilter=" and (DATE_FORMAT(a.invoice_date,'%Y-%m-%d %H:%i:%s') <= '$date_to' )";
}
else if($date_from!="" && $date_to==""){
$dfilter=" and (DATE_FORMAT(a.invoice_date,'%Y-%m-%d %H:%i:%s') >= '$date_from')";
}
else if($date_from!="" && $date_to!=""){
$dfilter=" and (DATE_FORMAT(a.invoice_date,'%Y-%m-%d %H:%i:%s') >= '$date_from' && DATE_FORMAT(a.invoice_date,'%Y-%m-%d %H:%i:%s') <= '$date_to')"; 
}


$requestData= $_REQUEST; 

$srchtxt=trim($this->db->escape_str($requestData['search']['value']));

$length=$_REQUEST['length'];
$start=$_REQUEST['start'];
$order_by=$_REQUEST['order'][0]['column'];
$order_byorder=$_REQUEST['order'][0]['dir'];

$orderby="order by invid DESC";
if(isset($_REQUEST['order'])){
  $orderby=($columns[$order_by]=="")?"order by invid DESC":"order by ".$columns[$order_by]." $order_byorder";
}

$srch="";
if(isset($requestData['search']['value'])){
 // $srch = "and (product_name like '%$srchtxt%' or fname like '%$srchtxt%')";
  $srch = "and (fname like '%$srchtxt%' or invoice_num like '%$srchtxt%' or 
    DATE_FORMAT(invoice_date,'%Y-%m-%d %H:%i:%s') like '%$srchtxt%' or qty like '%$srchtxt%' or amount like '%$srchtxt%' or b.product_name like '%$srchtxt%' )";
}




// $q1=$this->db->query("select  DATE_FORMAT(a.invoice_date,'%Y-%m-%d %H:%i:%s')idt , a.invoice_num inm, b.sku s, b.product_name pn, c.qty q , c.amount a , CONCAT(d.fname,' ',d.mname,' ',d.lname,' ',d.ename) as c  
// FROM across_invoice as a 
//   INNER JOIN  across_product as b ON a.invid=b.pid
//   INNER JOIN  across_invoice_items as c ON a.invid=c.invid 
//   INNER JOIN across_p_person as d on a.invid=d.eid
//   where 
//  a.remark='1' and DATE_FORMAT(a.invoice_date,'%Y-%m-%d %H:%i:%s') >='$date_from' and DATE_FORMAT(a.invoice_date,'%Y-%m-%d %H:%i:%s') <='$date_to' $bridfilter
//   $srch ");

$q1=$this->db->query("select  DATE_FORMAT(a.invoice_date,'%Y-%m-%d %H:%i:%s')idt , a.invoice_num inm, b.sku s, b.product_name pn, c.qty q , c.amount a , CONCAT(d.fname,' ',d.mname,' ',d.lname,' ',d.ename) as c  
FROM across_invoice as a 
  INNER JOIN  across_product as b ON a.invid=b.pid
  INNER JOIN  across_invoice_items as c ON a.invid=c.invid 
  INNER JOIN across_p_person as d on a.invid=d.eid
  where 
 a.remark='1' 
  $srch $dfilter ");


  $r1=$q1->result_array();


  $q=$this->db->query("select  DATE_FORMAT(a.invoice_date,'%Y-%m-%d %H:%i:%s')idt , a.invoice_num inm, b.sku s, b.product_name pn, c.qty q , c.amount a , CONCAT(d.fname,' ',d.mname,' ',d.lname,' ',d.ename) as c  
FROM across_invoice as a 
  INNER JOIN  across_product as b ON a.invid=b.pid
  INNER JOIN  across_invoice_items as c ON a.invid=c.invid 
  INNER JOIN across_p_person as d on a.invid=d.eid
  where 
  a.remark='1' 
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
    // $aci_invid=$r[$x]['invid'];
    // $ai_invid=$r[$x]['invid'];
    // $acp_cid=$r[$x]['cid'];

    $invoice_date=$r[$x]['idt'];
    $invoice_num=$r[$x]['inm'];
    $sku=$r[$x]['s'];
    $product_name=$r[$x]['pn'];
    $qty=$r[$x]['q'];
    $amount=$r[$x]['a'];
    $customer=$r[$x]['c'];
  // $customer=$r[$x]['lname']." ".$r[$x]['ename'].", ".$r[$x]['fname']." ".$r[$x]['mname'];


    $data[$x] = array(
    0=>"$invoice_date
    <input type='hidden' id='tbl_aci_invid$x' value='$invid' />
    <input type='hidden' id='tbl_ai_invid$x' value='$invid' />
    <input type='hidden' id='tbl_acp_cid$x' value='$cid' />

    <input type='hidden' id='tbl_inv_invoice_date$x' value='$invoice_date' />
    <input type='hidden' id='tbl_inv_invoice_num$x' value='$invoice_num' />
    <input type='hidden' id='tbl_inv_sku$x' value='$sku' />
    <input type='hidden' id='tbl_inv_product_name$x' value='$product_name' />
    <input type='hidden' id='tbl_inv_qty$x' value='$qty' />
    <input type='hidden' id='tbl_inv_amount$x' value='$amount' />
    <input type='hidden' id='tbl_inv_customer$x' value='$customer' />
    $sttt
    ",
    1=>"$invoice_num",
    2=>"$sku",
    3=> "$product_name",
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


