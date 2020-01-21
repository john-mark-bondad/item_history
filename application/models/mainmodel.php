<?php
class Mainmodel extends CI_Model {

public function __construct(){ $this->load->database(); }






public function getMaxId($tbl,$id){ /*Gets maximum Id from any table*/
$q=$this->db->query("select max($id) as id from $tbl");
$r=$q->result_array();
return ($r[0]['id']==NULL)?"0":$r[0]['id'];
}



public function getMaxVal($tbl,$id,$cond){ /*Gets maximum Id from any table*/
$q=$this->db->query("select max($id) as id from $tbl $cond");
$r=$q->result_array();
return ($r[0]['id']==NULL)?"0":$r[0]['id'];
}


}


