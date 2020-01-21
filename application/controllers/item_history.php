

<?php if ( ! defined("BASEPATH")) exit("No direct script access allowed");

class Item_history extends  CI_Controller {

public function loadMain(){
$this->load->view("a_pages/item_history/item_history_main");	
}

public function loadItemHistoryMainTable(){
$this->load->view("a_pages/item_history/item_history_main_tbl");	
}

public function loadItemHistoryInventoryTable(){
$this->load->view("a_pages/item_history/item_history_inventory_tbl");	
}

public function loadItemHistoryPosSalesTable(){
$this->load->view("a_pages/item_history/item_history_pos_sales_tbl");	
}

public function loadItemHistoryInvoiceTable(){
$this->load->view("a_pages/item_history/item_history_invoice_tbl");	
}

public function loadItemHistoryProductTable(){
$this->load->view("a_pages/item_history/item_history_product_table");	
}

public function loadItemHistoryOptionApi(){
$this->load->view("a_pages/item_history/item_history_option_api");	
}

public function loadItemHistoryProductSetlist(){
$this->load->view("a_pages/item_history/item_history_product_setlist");	
}

public function loadItemHistoryInventorySetlist(){
$this->load->view("a_pages/item_history/item_history_inventory_setlist");	
}

public function loadItemHistoryPosSalesSetlist(){
$this->load->view("a_pages/item_history/item_history_pos_sales_setlist");	
}

public function loadItemHistoryInvoiceSetlist(){
$this->load->view("a_pages/item_history/item_history_invoice_setlist");	
}




}

