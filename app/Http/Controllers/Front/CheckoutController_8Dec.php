<?php namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;

use App\Http\Models\Front\Product;
use App\Http\Models\Countries;
use App\Http\Models\Front\Checkout;
use App\Http\Models\Front\Brands;

use Session;
use Input;
use Illuminate\Http\RedirectResponse;
use Auth;

use Redirect;

use Request;
use Response;
use DB;
use Validator;
use View;
use Mail;

class CheckoutController extends Controller {
	private $data = array();
	private $ProductModel = null;
	private $CheckoutModel = null;

	public function __construct()
	{
		$this->ProductsModel = new Product();
		$this->CheckoutModel = new Checkout();
		$this->BrandsModel = new Brands();
	}

	function index()
	{
		$cart = Session::get('cart');
		$estimateShipping = Session::get('estimateShipping');
		$promocode = Session::get('promocode');
		
		if (!$cart){
			return redirect('/');
		}
		
		$this->data['errors'] = false;
		
		if (Request::isMethod('post'))
		{
			$validation['billing_first_name'] = 'required';
			$validation['billing_last_name'] = 'required';
			$validation['billing_email'] = 'required|email';
			$validation['billing_telephone'] = 'required';
			$validation['billing_country'] = 'required';
			//$validation['billing_state'] = 'required';
			$validation['billing_address'] = 'required';
			$validation['billing_city'] = 'required';
			$validation['billing_post_code'] = 'required';
			
			$validation['shipping_first_name'] = 'required';
			$validation['shipping_last_name'] = 'required';
			$validation['shipping_email'] = 'required|email';
			$validation['shipping_telephone'] = 'required';
			$validation['shipping_country'] = 'required';
			//$validation['shipping_state'] = 'required';
			$validation['shipping_address'] = 'required';
			$validation['shipping_city'] = 'required';
			$validation['shipping_post_code'] = 'required';
			$validation['payment_method'] = 'required';
			
			$validator = Validator::make(Request::all(), $validation);                
		
			if ($validator->fails()) {  
				$this->data['errors'] = $validator->errors('<p>:message</p>')->all(); 
			}
			else
			{
				$data['customer_id'] = Session::get('userId');
				
				$data['billing_first_name'] = Input::get('billing_first_name');
				$data['billing_last_name'] = Input::get('billing_last_name');
				$data['billing_email'] = Input::get('billing_email');
				$data['billing_telephone'] = Input::get('billing_telephone');
				$data['billing_country'] = Input::get('billing_country');
				$data['billing_state'] = Input::get('billing_state');
				$data['billing_address'] = Input::get('billing_address');
				$data['billing_city'] = Input::get('billing_city');
				$data['billing_post_code'] = Input::get('billing_post_code');
				
				$data['shipping_first_name'] = Input::get('shipping_first_name');
				$data['shipping_last_name'] = Input::get('shipping_last_name');
				$data['shipping_email'] = Input::get('shipping_email');
				$data['shipping_telephone'] = Input::get('shipping_telephone');
				$data['shipping_country'] = Input::get('shipping_country');
				$data['shipping_state'] = Input::get('shipping_state');
				$data['shipping_address'] = Input::get('shipping_address');
				$data['shipping_city'] = Input::get('shipping_city');
				$data['shipping_post_code'] = Input::get('shipping_post_code');
				$data['payment_method'] = Input::get('payment_method');
				
				//Add Estimate Shipping
				$data['shipping_method'] = (isset($estimateShipping['shipping_method']) ? $estimateShipping['shipping_method'] : '');
				$data['shipping_estimate_country'] = (isset($estimateShipping['country']) ? $estimateShipping['country'] : '');
				$data['shipping_estimate_state'] = (isset($estimateShipping['state']) ? $estimateShipping['state'] : '');
				
				//Update customer
				//$this->CheckoutModel->updateCustomer(Session::get('userId'), $data);
				//end
				
				$cartProducts = $this->ProductsModel->getCartProducts($cart, $promocode, $estimateShipping);
				$discount = 0;
				
				foreach($cartProducts['products'] as $key => $cartProduct){
					$data['products'][$key]['product_id'] = $cartProduct->cart['product_id'];
					$data['products'][$key]['quantity'] = $cartProduct->cart['quantity'];
					$data['products'][$key]['color_id'] = $cartProduct->cart['color_id'];
					$data['products'][$key]['special_event_id'] = (isset($cartProduct->cart['special_event_id']) ? $cartProduct->cart['special_event_id'] : '0');
					$data['products'][$key]['amount'] = $cartProduct->sale_price;
					
					if(!$cartProduct->free_shipping && $cartProduct->shipping_cost){
						$data['products'][$key]['shipping_amount'] = $cartProduct->shipping_cost;;
					}
					else{
						$data['products'][$key]['shipping_amount'] = 0;
					}
					
					//Discount
					$data['products'][$key]['quantity_discount'] = $cartProduct->cart['quantityDiscount'];
					$data['products'][$key]['global_discount'] = $cartProduct->cart['globalDiscount'];
					$data['products'][$key]['promo_code_discount'] = $cartProduct->cart['promocodeDiscount'];
					
					$discount += ($cartProduct->cart['quantityDiscount'] * $cartProduct->cart['quantity']) + $cartProduct->cart['globalDiscount'] + $cartProduct->cart['promocodeDiscount'];
				}
				
				if($promocode){
					$data['promocode_id'] = $promocode['promocode']->id;
				}
				else{
					$data['promocode_id'] = 0;
				}
				
				$data['totalPrice'] = ($cartProducts['totalPrice'] + $cartProducts['shippingTotal'] - $discount);
				$data['discount'] = $discount;
				
				$orderId = $this->CheckoutModel->addOrder($data);
				Session::put('orderId', $orderId);
				
				return redirect('/checkout/payment');
			}
		}
		
		$this->data['success'] = Session::get('checkout.success');
		Session::forget('checkout.success');
		
		$this->data['warning'] = Session::get('checkout.warning');
		Session::forget('checkout.warning');
		//Session::put('userId', 1);
		if(Session::get('userId')){
			//Put user
			$customer = DB::table('customers')->where('id', Session::get('userId'))->first();	
			$this->data['customer'] = $customer;
			//End
			
			$CountriesModel = new Countries();
			$this->data['countries'] = $CountriesModel->getCountries();
			
			$this->data['billing_states'] = array();
			$this->data['shipping_states'] = array();
			
			if($customer->billing_country){
				$this->data['billing_states'] = $CountriesModel->getStatesByCountry($customer->billing_country);
			}
			if($customer->shipping_country){
				$this->data['shipping_states'] = $CountriesModel->getStatesByCountry($customer->shipping_country);
			}
		}
		
		$this->data['isUserLogin'] = Session::has('userId');
		$cartProducts = $this->ProductsModel->getCartProducts($cart, $promocode, $estimateShipping);
		
		if(!$cartProducts){
			return redirect('/');
		}
		
		$this->data['cartProducts'] = $cartProducts;
		
		$brands = $this->BrandsModel->getBrands();
		$this->data['brands'] = $brands;
		$this->data['brands_scroller'] = View::make('front.module.brands', $this->data);

		$this->data['page_title'] = 'Checkout';
		return view('front.checkout.index',$this->data);
	}
	
	public function payment(){
		$orderId = Session::get('orderId');
		Session::forget('orderId');
		
		if(!$orderId){
			return redirect('/checkout');
		}
		
		$orderInfo = $this->CheckoutModel->getOrder($orderId);
		
		if(!$orderInfo){
			return redirect('/checkout');
		}

		$this->data['sign'] = $this->iPay88_signature('cRFkKfG6nNM07662' . $orderInfo->order_id . str_replace('.','', number_format($orderInfo->totalPrice, 2)). 'MYR');
		$this->data['orderInfo'] = $orderInfo;
		
		return view('front.checkout.payment',$this->data);
	}
	
	public function getStates(){
		$CountriesModel = new Countries();
		$json['states'] = $CountriesModel->getStatesByCountry(Input::get('country_id'));
		return Response::json($json);
	}
	
	private function iPay88_signature($source) {
	  return base64_encode(hex2bin(sha1($source)));
	}
	
	private function hex2bin($hexSource)
	{
		for ($i=0;$i<strlen($hexSource);$i=$i+2)
		{
		  $bin .= chr(hexdec(substr($hexSource,$i,2)));
		}
	  return $bin;
	}
	
	public function successPayment(){
		if (!Request::isMethod('post')){
			return redirect('/');
		}
		
		//// Response
		$merchantcode = Input::get('MerchantCode');
		$paymentid = Input::get('PaymentId');
		$refno = Input::get('RefNo');
		$amount = Input::get('Amount');
		$ecurrency = Input::get('Currency');
		$remark = Input::get('Remark');
		$transid = Input::get('TransId');
		$authcode = Input::get('AuthCode');
		$estatus = Input::get('Status');
		$errdesc = Input::get('ErrDesc');
		$signature = Input::get('Signature');

		
		$this->data['success'] = '';
		$this->data['warning'] = '';

		if(Input::get('Status')){
			Session::forget('cart');
			
			$data = [
				'description'			=> $remark,
				'status'				=> 'New Order',
				'payment_status'		=> 'Paid',
				'transaction_id'		=> $transid,
				'payment_method'		=> ''
			];
			
			$this->CheckoutModel->updateOrderByRefNo($refno, $data);
			
			//Send invoice
			$order = $this->CheckoutModel->getOrderByRefNo($refno);
			$orderToProduct = $this->CheckoutModel->getOrderToProduct($order->id);
			
			$invoice = array(
				'order' 			=> $order,
				'order_to_products'	=> $orderToProduct
			);
			
			$messageData = [
				'fromEmail' 			=> 'shop@tbm.com.my',
				'fromName' 				=> 'TBMonline',
				'toEmail' 				=> $order->billing_email,
				'toName' 				=> $order->billing_first_name . ' ' . $order->billing_last_name,
				'subject'				=> 'TBM::Order #' . $order->order_id
			];
			
			Mail::send('invoice.invoice-html', $invoice, function ($message) use ($messageData) {
				$message->from($messageData['fromEmail'], $messageData['fromName']);
				$message->to($messageData['toEmail'], $messageData['toName']);
				$message->subject($messageData['subject']);
			});
			//End
			
			Session::put('checkout.refno', $refno);
			Session::put('checkout.success', '<strong>Thank you!</strong> Your order has been received. We are now processing your order and you will receive the goods in 3-5 business working days.');
			return redirect('/checkout/orderConfirmation');
		}
		else{
			$data = [
				'description'			=> $errdesc,
				'status'				=> 'Declined',
				'payment_status'		=> 'Payment Error',
			];
			$this->CheckoutModel->updateOrderByRefNo($refno, $data);
			
			Session::put('checkout.warning', '<strong>Sorry!</strong> Your order was declined because ' . $errdesc . '.');
			return redirect('/checkout');
		}
	}
	
	public function failPayment(){
		
	}
	
	public function orderConfirmation(){
		if (!Session::has('checkout.refno')){
			return redirect('/');
		}
		
		$refno = Session::get('checkout.refno');
		
		$this->data['success'] = Session::get('checkout.success');
		Session::forget('checkout.success');
		
		$orderInfo = $this->CheckoutModel->getOrderByRefNo($refno);

		$this->data['orderInfo'] = $orderInfo;
		$this->data['orderProducts'] = $this->CheckoutModel->getOrderToProduct($orderInfo->id);
		
		$brands = $this->BrandsModel->getBrands();
		$this->data['brands'] = $brands;
		$this->data['brands_scroller'] = View::make('front.module.brands', $this->data);
		
		$this->data['page_title'] = 'Order Confirmation';
		
		return view('front.checkout.order-confirmation', $this->data);
	}
}
