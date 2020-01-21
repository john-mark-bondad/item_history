<?php
$pid=$this->db->escape_str($_POST['pid']);
$str="";


$q=$this->db->query("
select * from across_product where pid='$pid and remark='1'
");
$r=$q->result_array();

$ar=array();
for($x=0;$x<count($r);$x++){
$ar[$x]=array(
'pid'=>$r[$x]['pid']
	);	
}



echo json_encode($ar);

?>