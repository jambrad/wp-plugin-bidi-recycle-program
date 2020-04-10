<?php 
namespace Includes\Base;
require "../../vendor/autoload.php";
require_once( dirname (dirname(dirname( dirname( dirname( dirname( __FILE__ ) ) ) ) ) ) . '/wp-load.php' );
	
$DBModel = new DBModel();

if(isset($_POST['dateSorting'])){

	$param = $_POST['dateSorting'];
	$sorting = $DBModel->recycleSortingByDate($param);
	showDetails($sorting);

}else if(isset($_POST['statusSorting'])){

	$param = $_POST['statusSorting'];
	$sorting = $DBModel->recycleSortingStatus($param);
	showDetails($sorting);
	
}

function showDetails($param){
	$output = '';
	foreach ($param as $value) {
		$query_args = array( 'page' => 'bidi_recycle_program', 'return_id' => $value->return_id );
		$returnDetailsURL = add_query_arg( $query_args, admin_url('admin.php?') );

		$output .= '
					<tr>
						<th scope="row" class="check-column"></th>
							<td class="order_number column-order_number has-row-actions column-primary" data-colname="Order">
							<a href="' . $returnDetailsURL . '"
									<strong>
										#' . $value->return_code . ' ' . $value->display_name . '
									</strong>
								</a>
							</td>
						<td class="order_status column-order_status" data-colname="Status">
							<mark class="alert alert-warning">
								<span>
									' . $value->user_email . '
								</span>
							</mark>
						</td>
						<td class="order_date column-order_date" data-colname="Date">
							<time datetime="' . date('F, j Y h:i:sa',strtotime($value->return_date)). '" title="' . date('F, j Y h:i:sa',strtotime($value->return_date)) . '">
								' . date('F, j Y h:i:sa',strtotime($value->return_date)) . '
							</time>
						</td>';
						if($value->return_item_status == 'PENDING'){
		$output .= '
						<td class="order_status column-order_status" data-colname="Status">
							<mark class="alert alert-warning">
								<span>
									' . $value->return_item_status . '
								</span>
							</mark>
						</td>';
						}else{
		$output .= '
						<td class="order_status column-order_status" data-colname="Status">
							<mark class="alert alert-success">
								<span>
									' . $value->return_item_status . '
								</span>
							</mark>
						</td>';
						}
		$output .= '
						<td class="order_status column-order_status" data-colname="Status">
							<a href="' . $returnDetailsURL . '">View</a> / <a href="">Delete</a>
						</td>
					</tr>';
		
	}
	echo $output;
}
// C:\wamp64\www\bidivapor.dev\wp-content\plugins\bidi-recylce-program\templates\submit\sorting.template.php:11:null
