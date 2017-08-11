<?php
namespace App\Http\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use DB;
use Session;

class ShippingByCsv extends Model{

	
	function addShippingByCsv($formData)
	{
		unset($formData['_token']);
		
		$formData['status'] = (isset($formData['status'])) ? '1' : '0';
		$formData['updated_at'] = date('Y-m-d H:i:s');
		
		// add Shipping Order Amount
		DB::table('shipment_providers')->insert($formData);
		$shipping_order_id = DB::getPdo()->lastInsertId();
		
	}
	
	// get all records
	function getShippingByCsv()
	{
		$per_page = (Session::has('global_discounts.per_page')) ? Session::get('global_discounts.per_page') : 30;
		return DB::table('shipment_providers')->paginate($per_page);	
	}
	
	// get record for pagination report
/*	function getTotalProducts($current_page)
	{
		$current_page = ($current_page) ? $current_page : 1;
		$per_page = (Session::has('global_discounts.per_page')) ? Session::get('global_discounts.per_page') : 30;
		$total_records = DB::table('global_discounts')->count();
		
		$page_to = (($current_page * $per_page) > $total_records) ? $total_records : ($current_page * $per_page);
		
		$msg = 'Showing '. ((($current_page-1) * $per_page) + 1) .' to '. $page_to .' of '. $total_records .' entries';
		
		//return array('total_records' => $total_records, 'current_page' => $current_page, 'per_page' => $per_page, 'message' => $msg);
		return $msg;
	} */
	function deleteShippingByCsv($item_id)
	{
		// delete global_discounts
		DB::table('shipment_providers')->whereIn('id',explode(',',$item_id))->delete();
		
		// delete global_discounts_to_category
	//	DB::table('global_discounts_to_category')->whereIn('global_discount_id',explode(',',$item_id))->delete();
		
		// delete global_discounts_to_products
	//	DB::table('global_discounts_to_products')->whereIn('global_discount_id',explode(',',$item_id))->delete();			
	}
	
	function updateShippingByCsv($formData)
	{
		unset($formData['_token']);
		
		/* if(isset($formData['category_id']))
		{
			$category_id = $formData['category_id'];
			unset($formData['category_id']);
		}
		
		$product_ids = '';
		if(isset($formData['product_id']))
		{
			$product_ids = $formData['product_id'];
			unset($formData['product_id']);
		} */
		
		$shipping_order_amount_id = $formData['shipping_amount_id'];
		unset($formData['shipping_amount_id']);
		
		$formData['status'] = (isset($formData['status'])) ? '1' : '0';
		
		// update global discount
		$formData['title'] = str_replace(',','',$formData['title']);
		$formData['updated_at'] = date('Y-m-d H:i:s');
		
		DB::table('shipment_providers')->where('id',$shipping_order_amount_id)->update($formData);
				
		// delete category
	//	DB::table('global_discounts_to_category')->whereIn('global_discount_id',array('0' => $global_discount_id))->delete();
		
		// add global_discounts_to_category
	/*	if($category_id)
		{
			$insert_data['global_discount_id'] = $global_discount_id;
			$insert_data['category_id'] = $category_id;
			
			DB::table('global_discounts_to_category')->insert($insert_data);	
		} 
		
		// delete global_discounts_to_products
		DB::table('global_discounts_to_products')->whereIn('global_discount_id',array('0' => $global_discount_id))->delete();
		
		// add global_discounts_to_products
		if($product_ids)
		{
			$insert_product['global_discount_id'] = $global_discount_id;
			
			foreach($product_ids as $product_id)
			{
				$insert_product['product_id'] = $product_id;
				DB::table('global_discounts_to_products')->insert($insert_product);
			}
		}	*/
	}
	
}