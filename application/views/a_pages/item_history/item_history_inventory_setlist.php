<?php

$columns = array(
  0 =>'',
  1 => 's',
  2 => 'pn',
  3 => 't',
  4 => 'q',
  5 => 'c'

);

$pid=(isset($_GET['pid']))?$_GET['pid']:"";

$date_from=$_GET['date_from'];
$date_to=$_GET['date_to'];


$dfilter="";
if($date_from=="" && $date_to!=""){
$dfilter=" and (DATE_FORMAT(approved_date,'%Y-%m-%d %H:%i:%s')  <= '$date_to')";
}
else if($date_from!="" && $date_to==""){
$dfilter=" and (DATE_FORMAT(approved_date,'%Y-%m-%d %H:%i:%s') >= '$date_from')";
}
else if($date_from!="" && $date_to!=""){
$dfilter=" and (DATE_FORMAT(approved_date,'%Y-%m-%d %H:%i:%s')  >= '$date_from' && DATE_FORMAT(approved_date,'%Y-%m-%d %H:%i:%s')  <= '$date_to')"; 
}



$requestData= $_REQUEST; 
$srchtxt=trim($this->db->escape_str($requestData['search']['value']));


$length=$_REQUEST['length'];
$start=$_REQUEST['start'];
$order_by=$_REQUEST['order'][0]['column'];
$order_byorder=$_REQUEST['order'][0]['dir'];

            // order by pid ASC
$orderby="order by dd DESC";
if(isset($_REQUEST['order'])){
  $orderby=($columns[$order_by]=="")?"order by dd DESC":"order by ".$columns[$order_by]." $order_byorder";
}

$srch="";
if(isset($requestData['search']['value'])){
  $srch = "and (lname like '%$srchtxt%' or type like '%$srchtxt%' or 
  sku like '%$srchtxt%' or product_name like '%$srchtxt%'  or qty like '%$srchtxt%' )";
 //  DATE_FORMAT(a.adjust_date,'%Y-%m-%d') like '%$srchtxt%' or 
}


$q1=$this->db->query("SELECT  DATE_FORMAT(adjust_date,'%Y-%m-%d %H:%i:%s')dd, b.sku s, b.product_name pn,
  a.type as nt, IF(type = 1, 'Add Stock', 'Adjustment') as t, a.adjust_qty q, CONCAT(e.fname,' ',e.mname,' ',e.lname,' ',e.ename) as c
  FROM across_adjustment  as a 
  INNER JOIN across_product as b ON b.pid=a.adid
  INNER JOIN across_p_person as e ON a.adid=e.eid 
  UNION ALL
  SELECT DATE_FORMAT(approved_date,'%Y-%m-%d %H:%i:%s')dd, sku s, product_name pn,
  b.type as nt, IF(type = 1, 'Add Stock', 'Adjustment') as t, qty, CONCAT(e.fname,' ',e.mname,' ',e.lname,' ',e.ename) c 
  FROM across_add_stock as c 
  INNER JOIN across_adjustment  as b on b.pid=c.pid
  INNER JOIN across_product as f ON f.pid=c.pid
  INNER JOIN across_p_person as e ON c.pid=e.eid 
  $srch $dfilter ");
          // group by d
$r1=$q1->result_array();

// study this link  ==> http://localhost/jc/admin/index.php/main/page/80/1/product_inventory_report_solo

// SELECT DATE_FORMAT(a.adjust_date,'%Y-%m-%d')d, b.sku s, b.product_name pn,
//   a.type as nt, IF(type = 1, 'Add Stock', 'Adjustment') as t, a.adjust_qty q, CONCAT(e.fname,' ',e.mname,' ',e.lname,' ',e.ename) as c
//   FROM across_adjustment  as a 
//   INNER JOIN across_product as b ON b.pid=a.adid
//   INNER JOIN across_p_person as e ON a.adid=e.eid where a.remark='1' and DATE_FORMAT(a.adjust_date,'%Y-%m-%d') >='$date_from' and DATE_FORMAT(a.adjust_date,'%Y-%m-%d') <='$date_to' 
//   UNION ALL
//   SELECT  DATE_FORMAT(approved_date,'%Y-%m-%d'), sku s, product_name pn,
//   b.type as nt, IF(type = 1, 'Add Stock', 'Adjustment') as t, qty, CONCAT(e.fname,' ',e.mname,' ',e.lname,' ',e.ename) 
//   FROM across_add_stock as c 
//   INNER JOIN across_adjustment  as b on b.pid=c.pid
//   INNER JOIN across_product as f ON f.pid=c.pid
//   INNER JOIN across_p_person as e ON c.pid=e.eid

$q=$this->db->query("SELECT  DATE_FORMAT(adjust_date,'%Y-%m-%d %H:%i:%s')dd, b.sku s, b.product_name pn,
  a.type as nt, IF(type = 1, 'Add Stock', 'Adjustment') as t, a.adjust_qty q, CONCAT(e.fname,' ',e.mname,' ',e.lname,' ',e.ename) as c
  FROM across_adjustment  as a 
  INNER JOIN across_product as b ON b.pid=a.adid
  INNER JOIN across_p_person as e ON a.adid=e.eid 
  UNION ALL
  SELECT DATE_FORMAT(approved_date,'%Y-%m-%d %H:%i:%s')dd, sku s, product_name pn,
  b.type as nt, IF(type = 1, 'Add Stock', 'Adjustment') as t, qty, CONCAT(e.fname,' ',e.mname,' ',e.lname,' ',e.ename) c 
  FROM across_add_stock as c 
  INNER JOIN across_adjustment  as b on b.pid=c.pid
  INNER JOIN across_product as f ON f.pid=c.pid
  INNER JOIN across_p_person as e ON c.pid=e.eid 
  $srch $dfilter $orderby limit $start, $length");

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
  $date=$r[$x]['dd'];
  $sku=$r[$x]['s'];
  $product_name=$r[$x]['pn'];
  $type=$r[$x]['t'];
    // $type=($r[$x]['newt']=='1')?"Add Stock":"Adjustment";
  $qty=$r[$x]['q'];
  $transacted_by=$r[$x]['c'];

  $data[$x] = array(
   0=>"$date 
   <input type='hidden' id='tbl_i_pid$x' value='$pid' />
   <input type='hidden' id='tbl_i_date$x' value='$date' />
   <input type='hidden' id='tbl_i_sku$x' value='$sku' />
   <input type='hidden' id='tbl_i_product_name$x' value='$product_name' />
   <input type='hidden' id='tbl_i_type$x' value='$type' />
   <input type='hidden' id='tbl_i_qty$x' value='$qty' />
   <input type='hidden' id='tbl_i_transacted_by$x' value='$transacted_by' />
   <input type='hidden' id='tbl_form_datefrom' value=''>
   <input type='hidden' id='tbl_form_dateto' value=''>
   $sttt
   ",
   1=>"$sku",
   2=>"$product_name",
   3=>"$type",
   4=> "$qty",
   5=>"$transacted_by"
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