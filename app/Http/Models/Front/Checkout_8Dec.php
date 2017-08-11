<?php
namespace App\Http\Models\Front; // where this file exists

use Illuminate\Database\Eloquent\Model;
use DB;

class Checkout extends Model{
	public function addOrder($data){
		$insert = [
			'customer_id'			=> $data['customer_id'],
			
			'billing_first_name'	=> $data['billing_first_name'],
			'billing_last_name'		=> $data['billing_last_name'],
			'billing_email'			=> $data['billing_email'],
			'billing_telephone'		=> $data['billing_telephone'],
			'billing_country'		=> $data['billing_country'],
			'billing_state'			=> $data['billing_state'],
			'billing_address'		=> $data['billing_address'],
			'billing_city'			=> $data['billing_city'],
			'billing_post_code'		=> $data['billing_post_code'],
			
			'shipping_first_name'	=> $data['shipping_first_name'],
			'shipping_last_name'	=> $data['shipping_last_name'],
			'shipping_email'		=> $data['shipping_email'],
			'shipping_telephone'	=> $data['shipping_telephone'],
			'shipping_country'		=> $data['shipping_country'],
			'shipping_state'		=> $data['shipping_state'],
			'shipping_address'		=> $data['shipping_address'],
			'shipping_city'			=> $data['shipping_city'],
			'shipping_post_code'	=> $data['shipping_post_code'],
			
			'shipping_method'			=> $data['shipping_method'],
			'shipping_estimate_country'	=> $data['shipping_estimate_country'],
			'shipping_estimate_state'	=> $data['shipping_estimate_state'],
			
			'totalPrice'			=> $data['totalPrice'],
			'discount'				=> $data['discount'],
			'promocode_id'			=> $data['promocode_id'],
			'payment_method'		=> $data['payment_method'],
			'payment_status'		=> 'Processing',
			'status'				=> 'Processing',
			'ip_address'			=> $_SERVER['REMOTE_ADDR'],
			'modifydate'			=> date('Y-m-d H:i:s'),
			'createdate'			=> date('Y-m-d H:i:s'),
		];

		DB::table('orders')->insert($insert);
		$orderId = DB::getPdo()->lastInsertId();
		
		$order_id = 'TBM' . sprintf('%05d', $orderId);
		DB::table('orders')->where('id', $orderId)->update(['order_id' => $order_id]);
		
		foreach($data['products'] as $products){
			//Insert into order to product table
			$insert = [
				'order_id'					=> $orderId,
				'product_id'				=> $products['product_id'],
				'quantity'					=> $products['quantity'],
				'color_id'					=> ($products['color_id'] ? $products['color_id'] : ''),
				'special_event_id'			=> $products['special_event_id'],
				'amount'					=> $products['amount'],
				'shipping_amount'			=> $products['shipping_amount'],
				'global_discount'			=> $products['global_discount'],
				'quantity_discount'			=> $products['quantity_discount'],
				'promo_code_discount'		=> $products['promo_code_discount'],
			];
			
			DB::table('order_to_product')->insert($insert);
			
			//update product quantity
			DB::update("update products set quantity_in_stock = (quantity_in_stock - " . $products['quantity'] . "), last_modified = '" . date('Y-m-d H:i:s') . "' where id = ?", [$products['product_id']]);
		}
		
		return $orderId;
	}
	
	public function updateOrderByRefNo($refno, $data){
		$data['modifydate'] = date('Y-m-d H:i:s');
		DB::table('orders')->where('order_id', $refno)->update($data);
	}
	
	public function getOrder($orderId){
		$orders = DB::table('orders as o');
		$orders->select('o.*', 'sb.name as billing_state_name', 'cb.name as billing_country_name', 'ss.name as shipping_state_name', 'cs.name as shipping_country_name');
		
		$orders->leftjoin('states as sb','sb.zone_id', '=','o.billing_state' );
		$orders->leftjoin('countries as cb','cb.country_id', '=','o.billing_country' );
		
		$orders->leftjoin('states as ss','ss.zone_id', '=','o.shipping_state' );
		$orders->leftjoin('countries as cs','cs.country_id', '=','o.shipping_country' );
		
		$orders->where('id', '=', $orderId);

		return $orders->first();
	}
	
	public function getOrderByRefNo($refno){
		$orders = DB::table('orders as o');
		$orders->select('o.*', 'sb.name as billing_state_name', 'cb.name as billing_country_name', 'ss.name as shipping_state_name', 'cs.name as shipping_country_name');
		
		$orders->leftjoin('states as sb','sb.zone_id', '=','o.billing_state' );
		$orders->leftjoin('countries as cb','cb.country_id', '=','o.billing_country' );
		
		$orders->leftjoin('states as ss','ss.zone_id', '=','o.shipping_state' );
		$orders->leftjoin('countries as cs','cs.country_id', '=','o.shipping_country' );
		
		$orders->where('order_id', '=', $refno);

		return $orders->first();
	}
	
	public function getOrderToProduct($order_id){
		$orderToProduct = DB::table('order_to_product as otp');
		$orderToProduct->select('otp.*', 'p.product_name', 'p.product_code', 'p.thumbnail_image_1', 'p.thumbnail_image_2', 'c.title as color_name', 'se.event_type', 'se.token');
		$orderToProduct->leftjoin('colors as c','c.id', '=','otp.color_id' );
		$orderToProduct->leftjoin('products as p','p.id', '=','otp.product_id' );
		$orderToProduct->leftjoin('special_events as se','se.id', '=','otp.special_event_id' );
		$orderToProduct->where('otp.order_id', $order_id);
		
		return $orderToProduct->get();
	}
	
	public function updateCustomer($customer_id, $data){
		$update = [
			'billing_first_name'	=> $data['billing_first_name'],
			'billing_last_name'		=> $data['billing_last_name'],
			'billing_email'			=> $data['billing_email'],
			'billing_telephone'		=> $data['billing_telephone'],
			'billing_country'		=> $data['billing_country'],
			'billing_state'			=> $data['billing_state'],
			'billing_address'		=> $data['billing_address'],
			'billing_city'			=> $data['billing_city'],
			'billing_post_code'		=> $data['billing_post_code'],
			
			'shipping_first_name'	=> $data['shipping_first_name'],
			'shipping_last_name'	=> $data['shipping_last_name'],
			'shipping_email'		=> $data['shipping_email'],
			'shipping_telephone'	=> $data['shipping_telephone'],
			'shipping_country'		=> $data['shipping_country'],
			'shipping_state'		=> $data['shipping_state'],
			'shipping_address'		=> $data['shipping_address'],
			'shipping_city'			=> $data['shipping_city'],
			'shipping_post_code'	=> $data['shipping_post_code'],
			'modifydate'			=> date('Y-m-d H:i:s'),
		];
		
		DB::table('customers')->where('id', $customer_id)->update($update);
	}
	
	public function getPromoCodes($promo_code){
		$result = DB::table('promocodes');
		
		$result->where('promo_code', $promo_code);
		
		$result->where('start_date', '<=', date('Y-m-d'));
		$result->where('end_date', '>=', date('Y-m-d'));
		
		$result->where('status', '=', '1');
		
		$promocode = $result->first();
		
		if($promocode){
			$count = DB::table('orders')->select('id')->where('promocode_id', '=', $promocode->id)->count();
			
			if($count < $promocode->times_to_use){
				$results = DB::table('promocodes_to_product')->select('product_id')->where('promocode_id', '=', $promocode->id)->get();
				$productApply = array();
				
				foreach($results as $result)
				{
					$productApply[] = $result->product_id;
				}
				
				return array(
					'promocode'			=> $promocode,
					'products'			=> $productApply
				);
			}
			else{
				return array('warning' => 'Promo code expired!');
			}
		}
		else{
			return array('warning' => 'Invalid promo code!');
		}
	}
}