<?php 

/**
* Trigger this file on Plugin uninstall
*
* @package Bidi Recycle Program
*/

namespace Includes\Base;

class DBModel{

	private $wpdb;

	public function __construct( ){
		global $wpdb;
		$this->wpdb = $wpdb;
	}

	// insert return information to the database
	function insertReturnInformation($return_code, $total_prod_qty, $current_date, $return_status, $customer_id){

		$sql = $this->wpdb->prepare(
			"INSERT INTO `wp_bidi_return_information`      
			(`return_id`, `return_code`, `return_total_qty_returned`, `return_date`, `return_item_status`, `customer_id`) 
			values
			(%d, %s, %d, %s, %s, %d)",
			NULL, $return_code, $total_prod_qty, $current_date, $return_status, $customer_id
 		); 		

		if($this->wpdb->query($sql)){
			return array($this->wpdb->insert_id);
		}

	}

	// insert return product list and information
	function insertProductInformation($product_name, $product_order_id, $product_item_id, $product_image, $current_date, $return_id, $return_code){

		$sql = $this->wpdb->prepare(
			"INSERT INTO `wp_bidi_return_product_info`      
			(`product_info_id`, `product_name`, `product_order_id`, `product_item_id`, `product_image`, `product_return_date`, `return_id`, `return_code`) 
			values
			(%d, %s, %d, %d, %s, %s, %d, %s)",
			NULL, $product_name, $product_order_id, $product_item_id, $product_image, $current_date, $return_id, $return_code
 		); 		

		if($this->wpdb->query($sql)){
			return "Success";
		}

	}

	// Get All Data from two tables wp_bidi_return_information and wp_users
	function getAllReturnAndUserData(){
		$sql = "SELECT *
				FROM wp_bidi_return_information wp_bidi_return_information
				INNER JOIN wp_users wp_users ON wp_bidi_return_information.customer_id = wp_users.ID
				";
        $result = $this->wpdb->get_results($sql);
        if($result){
			return $result;
		}
	}

	function getReturnProductData($param){
		$sql = "SELECT *
				FROM wp_bidi_return_information wp_bidi_return_information
		 		INNER JOIN wp_bidi_return_product_info wp_bidi_return_product_info ON wp_bidi_return_information.return_id = wp_bidi_return_product_info.return_id
		 		INNER JOIN wp_users wp_users ON wp_bidi_return_information.customer_id = wp_users.ID
		 		WHERE wp_bidi_return_information.return_id = ".$param."
				";
				
        $result = $this->wpdb->get_results($sql);
        if($result){
			return $result;
		}
	}
    	
}