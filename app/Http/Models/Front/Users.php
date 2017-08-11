<?php namespace App\Http\Models\Front; 

use Illuminate\Database\Eloquent\Model;
use DB;
Use REQUEST;
use Hash;

class Users extends Model{
	
	function insertregistereddata($formData)
	{
		if(isset($formData['_token'])){$token = $formData['_token'];}else{$token='';}
		if(isset($formData['billing_first_name'])){$billing_first_name = $formData['billing_first_name'];}else{$billing_first_name='';}
        if(isset($formData['billing_last_name'])&&$formData['billing_last_name']!=''){$billing_last_name = $formData['billing_last_name'];}else{$billing_last_name='';}			
		if(isset($formData['billing_telephone'])){$billing_telephone = $formData['billing_telephone'];}else{$billing_telephone='';}
		  
		if(isset($formData['billing_email'])){$billing_email = $formData['billing_email'];}else{$billing_email='';}
		if(isset($formData['password'])){$password = $formData['password'];}else{$password='';}
		if(isset($formData['newsletter_subscription'])){$newsletter_subscription = $formData['newsletter_subscription'];}else{$newsletter_subscription='';}
		if(isset($formData['agree'])){$agree = $formData['agree'];}else{$agree='';}
		if(isset($formData['billing_address'])){$billing_address = $formData['billing_address'];}else{$billing_address='';}
		if(isset($formData['billing_city'])){$billing_city = $formData['billing_city'];}else{$billing_city='';}
		if(isset($formData['billing_post_code'])){$billing_post_code = $formData['billing_post_code'];}else{$billing_post_code='';}
		if(isset($formData['billing_state'])){$billing_state = $formData['billing_state'];}else{$billing_state='';}
		if(isset($formData['billing_country'])){$billing_country = $formData['billing_country'];}else{$billing_country='';}
		if(isset($formData['birth_date'])){ 
			$input= $formData['birth_date']; 
			$input = str_replace('/', '-', $input);
			$birth_date = date('Y-m-d H:i:s',strtotime($input));
		}else{
			$birth_date='';
		}
			
	    $data['token'] = $token;  
		$data['billing_first_name'] = $billing_first_name ;
		$data['billing_last_name'] = $billing_last_name;
		$data['billing_telephone'] = $billing_telephone;
		$data['birth_date'] = $birth_date;
		$data['billing_email'] = $billing_email;
		$data['password'] = Hash::make($password);
		$data['newsletter_subscription'] = $newsletter_subscription;
		$data['agree'] = $agree;
		$data['billing_address'] = $billing_address;
		$data['billing_city'] = $billing_city;
		$data['billing_post_code'] = $billing_post_code;
		$data['billing_state'] = $billing_state;
		$data['billing_country'] = $billing_country;
		
		$data['shipping_first_name'] = $billing_first_name ;
		$data['shipping_last_name'] = $billing_last_name;
		$data['shipping_telephone'] = $billing_telephone;
		$data['shipping_email'] = $billing_email;
		$data['shipping_address'] = $billing_address;
		$data['shipping_city'] = $billing_city;
		$data['shipping_post_code'] = $billing_post_code;
		$data['shipping_state'] = $billing_state;
		$data['shipping_country'] = $billing_country;
			
		if(isset($formData['status'])){$status = $formData['status'];}else{$status='1';}
		$data['status'] = $status; 
			
		$data['modifydate'] = date('Y-m-d H:i:s');
		$data['createdate'] = date('Y-m-d H:i:s');
			
		$data['first_name'] = $billing_first_name ;
		$data['last_name'] = $billing_last_name;
		$data['telephone'] = $billing_telephone;
		$data['email'] = $billing_email;
		DB::table('customers')->insert($data);
		if($newsletter_subscription=='1')
		{
		$news=array();
		$news['name'] = $billing_first_name;
		$news['email'] = $billing_email;
		$news['status'] = $newsletter_subscription;
		$news['updated_at'] = date('Y-m-d H:i:s');
		$news['created_at'] = date('Y-m-d H:i:s'); 
		DB::table('newsletter')->insert($news);
		}
		$this->sendregistrationmail($data);
		if($newsletter_subscription=='1')
		{$this->sendsubscriptionmail($data);
		}
		return true;
	}
	     
	function sendregistrationmail($formData)
	{ 
		$mail=$formData['billing_email'];;
		$to = $formData['billing_email'];
		$to_name = $formData['billing_first_name'];
		$from = 'shop@tbm.com.my';
		$from_name = 'SHOP TBM';
		$subject = "Congratulations! You have successfully registered with TBM.";
		$message = "Dear ".$formData['billing_first_name'].",<br><br>";
		$message .= "This is to confirm your successful registration with TBM.<br/>";
				
		$message .= "<br><br>Thank you.<br>
		Best regards,<br>
		TBM Online Registration Manager<br>
		TAN BOON MING SDN BHD (494355-D)<br>
		PS 4,5,6 & 7, Taman Evergreen, Batu 4, Jalan Klang Lama, 58100 Kuala Lumpur.<br>
		Tel: (603) 7983-2020 (Hunting Lines)<br>
		Fax: (603) 7982-8141<br>
		info@tbm.com.my<br>
		Business Hours:<br>
		Mon. - Sat.: 9.30am - 9.00pm<br>
		Sun.: 10.00am - 9.00pm <br/>";
		
		$headers = "From:".$from . "\r\n" ;
		$headers .= "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
		
		mail($to,$subject,$message,$headers);
		return true;
	}
	function sendsubscriptionmail($formData)
	{ 
		$mail=$formData['billing_email'];;
		$to = $formData['billing_email'];
		$to_name = $formData['billing_first_name'];
		$from = 'shop@tbm.com.my';
		$from_name = 'SHOP TBM';
		$subject = " Newsletter Subscription with TBM.";
		$message = "Dear ".$formData['billing_first_name'].",<br><br>";
		//$message .= "This is  confirmation  About  successful Subscribtion with TBM.<br/>";
				
		$message .= "This is confirmation for the successful e-news subscription with TBM.<br><br>
You have now been added to the mailing list and will receive the next email information in the coming
days or weeks. If you ever wish to unsubscribe, simply use the unsubscribe link included in each
newsletter. We're excited that we'll have you as a customer soon!
In the meantime, come and like us on Facebook!<br><br>
		
		https://www.facebook.com/tbm2u<br><br>
		
		Thanks again for signing up!<br><br>
		
		Thank you,<br>
		Best regards,<br>
		TBM Online Registration Manager<br>
		TAN BOON MING SDN BHD (494355-D)<br>
		PS 4,5,6 & 7, Taman Evergreen, Batu 4, Jalan Klang Lama, 58100 Kuala Lumpur.<br>
		Tel: (603) 7983-2020 (Hunting Lines)<br>
		Fax: (603) 7982-8141<br>
		info@tbm.com.my<br>
		Business Hours:<br>
		Mon. - Sat.: 9.30am - 9.00pm<br>
		Sun.: 10.00am - 9.00pm <br/>";
		
		$headers = "From:".$from . "\r\n" ;
		$headers .= "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
		
		mail($to,$subject,$message,$headers);
		return true;
	}
	
	
	/////// Update user detail
	function updateAccount($formData){
		if(isset($formData['_token'])){$token = $formData['_token'];}else{$token='';}
		if(isset($formData['billing_first_name'])){$billing_first_name = $formData['billing_first_name'];}else{$billing_first_name='';}
        if(isset($formData['billing_last_name'])&&$formData['billing_last_name']!=''){$billing_last_name = $formData['billing_last_name'];}else{$billing_last_name='';}			
		if(isset($formData['billing_telephone'])){$billing_telephone = $formData['billing_telephone'];}else{$billing_telephone='';}
		  
		if(isset($formData['billing_email'])){$billing_email = $formData['billing_email'];}else{$billing_email='';}
		if(isset($formData['password'])){$password = $formData['password'];}else{$password='';}
		if(isset($formData['billing_address'])){$billing_address = $formData['billing_address'];}else{$billing_address='';}
		if(isset($formData['billing_city'])){$billing_city = $formData['billing_city'];}else{$billing_city='';}
		if(isset($formData['billing_post_code'])){$billing_post_code = $formData['billing_post_code'];}else{$billing_post_code='';}
		if(isset($formData['billing_state'])){$billing_state = $formData['billing_state'];}else{$billing_state='';}
		if(isset($formData['billing_country'])){$billing_country = $formData['billing_country'];}else{$billing_country='';}
		if(isset($formData['birth_date'])){ $input= $formData['birth_date']; 
		$old_date =strtotime($input);
        $birth_date = date('Y-m-d H:i:s',($old_date));}else{$birth_date='';}
			
	    $data['token'] = $token;  
		$data['billing_first_name'] = $billing_first_name ;
		$data['billing_last_name'] = $billing_last_name;
		$data['billing_telephone'] = $billing_telephone;
		$data['birth_date'] = $birth_date;
		$data['billing_email'] = $billing_email;
		if($password!=''){
			$data['password'] = Hash::make($password);
		}
		$data['billing_address'] = $billing_address;
		$data['billing_city'] = $billing_city;
		$data['billing_post_code'] = $billing_post_code;
		$data['billing_state'] = $billing_state;
		$data['billing_country'] = $billing_country;
			
			
		if(isset($formData['status'])){$status = $formData['status'];}else{$status='1';}
		$data['status'] = $status; 
			
		$data['modifydate'] = date('Y-m-d H:i:s');
			
		$data['first_name'] = $billing_first_name ;
		$data['last_name'] = $billing_last_name;
		$data['telephone'] = $billing_telephone;
		$data['email'] = $billing_email;
		
		DB::table('customers')->where('id', $formData['userId'])->update($data);	
		return true;
	}
	
	/////Update billing info
	function updateBillingInfo($formData){
		if(isset($formData['billing_first_name'])){$billing_first_name = $formData['billing_first_name'];}else{$billing_first_name='';}
        if(isset($formData['billing_last_name'])&&$formData['billing_last_name']!=''){$billing_last_name = $formData['billing_last_name'];}else{$billing_last_name='';}			
		if(isset($formData['billing_telephone'])){$billing_telephone = $formData['billing_telephone'];}else{$billing_telephone='';}
		  
		if(isset($formData['billing_email'])){$billing_email = $formData['billing_email'];}else{$billing_email='';}
		if(isset($formData['billing_address'])){$billing_address = $formData['billing_address'];}else{$billing_address='';}
		if(isset($formData['billing_city'])){$billing_city = $formData['billing_city'];}else{$billing_city='';}
		if(isset($formData['billing_post_code'])){$billing_post_code = $formData['billing_post_code'];}else{$billing_post_code='';}
		if(isset($formData['billing_state'])){$billing_state = $formData['billing_state'];}else{$billing_state='';}
		if(isset($formData['billing_country'])){$billing_country = $formData['billing_country'];}else{$billing_country='';}
			
		$data['billing_first_name'] = $billing_first_name ;
		$data['billing_last_name'] = $billing_last_name;
		$data['billing_telephone'] = $billing_telephone;
		$data['billing_email'] = $billing_email;
		$data['billing_address'] = $billing_address;
		$data['billing_city'] = $billing_city;
		$data['billing_post_code'] = $billing_post_code;
		$data['billing_state'] = $billing_state;
		$data['billing_country'] = $billing_country;
			
		$data['modifydate'] = date('Y-m-d H:i:s');
			
		DB::table('customers')->where('id', $formData['userId'])->update($data);	
		return true;
	}
	
	/////Update shipping info
	function updateShippingInfo($formData){
		if(isset($formData['shipping_first_name'])){$shipping_first_name = $formData['shipping_first_name'];}else{$shipping_first_name='';}
        if(isset($formData['shipping_last_name'])&&$formData['shipping_last_name']!=''){$shipping_last_name = $formData['shipping_last_name'];}else{$shipping_last_name='';}			
		if(isset($formData['shipping_telephone'])){$shipping_telephone = $formData['shipping_telephone'];}else{$shipping_telephone='';}
		  
		if(isset($formData['shipping_email'])){$shipping_email = $formData['shipping_email'];}else{$shipping_email='';}
		if(isset($formData['shipping_address'])){$shipping_address = $formData['shipping_address'];}else{$shipping_address='';}
		if(isset($formData['shipping_city'])){$shipping_city = $formData['shipping_city'];}else{$shipping_city='';}
		if(isset($formData['shipping_post_code'])){$shipping_post_code = $formData['shipping_post_code'];}else{$shipping_post_code='';}
		if(isset($formData['shipping_state'])){$shipping_state = $formData['shipping_state'];}else{$shipping_state='';}
		if(isset($formData['shipping_country'])){$shipping_country = $formData['shipping_country'];}else{$shipping_country='';}
			
		$data['shipping_first_name'] = $shipping_first_name ;
		$data['shipping_last_name'] = $shipping_last_name;
		$data['shipping_telephone'] = $shipping_telephone;
		$data['shipping_email'] = $shipping_email;
		$data['shipping_address'] = $shipping_address;
		$data['shipping_city'] = $shipping_city;
		$data['shipping_post_code'] = $shipping_post_code;
		$data['shipping_state'] = $shipping_state;
		$data['shipping_country'] = $shipping_country;
			
		$data['modifydate'] = date('Y-m-d H:i:s');
			
		DB::table('customers')->where('id', $formData['userId'])->update($data);	
		return true;
	}
	
	///// Subscribe and unsubscribe
	function newsletter($formData){
		$data['name'] = $formData['userName'];
		$data['email'] = $formData['userEmail'];
			
		if(isset($formData['nwslttr']) and $formData['nwslttr']!='' and $formData['nwslttr']=='subscribe'){
			$result = DB::table('newsletter')->where('email',$formData['userEmail'])->get();
			if(count($result)>0){
				$data['status'] = 1;
				$data['updated_at'] = date('Y-m-d H:i:s');
				DB::table('newsletter')->where('email', $formData['userEmail'])->update($data);	
			}else{
				$data['status'] = 1;
				$data['updated_at'] = date('Y-m-d H:i:s');
				$data['created_at'] = date('Y-m-d H:i:s');
				DB::table('newsletter')->insert($data);
			}
		}else{
			$data['status'] = 0;
			$data['updated_at'] = date('Y-m-d H:i:s');
			DB::table('newsletter')->where('email', $formData['userEmail'])->update($data);
		}
		
		return true;
	}
	
	
	/////Get Newsletter Status
	function getNewsletterStatus($email){
		$result = DB::table('newsletter')->where('email',$email)->get();
		if(isset($result[0]->status)){
			return $result[0]->status;	
		}else{
			return 0;	
		}
	}
		
	//////Get user detail by ID from DB table
	function getUserById($id){
		$result = DB::table('customers')->where('id',$id)->get();
		
		$billingState = DB::table('states')->where('zone_id', $result[0]->billing_state)->get();
		
		$billingCountry = DB::table('countries')->where('country_id', $result[0]->billing_country)->get();
		
		$shippingState = DB::table('states')->where('zone_id', $result[0]->shipping_state)->get();
		$shippingCountry = DB::table('countries')->where('country_id', $result[0]->shipping_country)->get();
		if(isset($billingCountry[0]->name) && !empty($billingCountry[0]->name)){
		$result[0]->billing_country_name = $billingCountry[0]->name;
		}else{
		$result[0]->billing_country_name = '';
		}
		if(isset($billingState[0]->name) && !empty($billingState[0]->name)){
		$result[0]->billing_state_name = $billingState[0]->name;
		}else{
		$result[0]->billing_state_name = '';
		}
		if(isset($shippingCountry[0]->name) && !empty($shippingCountry[0]->name)){
		$result[0]->shipping_country_name = $shippingCountry[0]->name;
		}else{ $result[0]->shipping_country_name = '';
		}
		
		if(isset($shippingState[0]->name) && !empty($shippingState[0]->name)){
		$result[0]->shipping_state_name = $shippingState[0]->name;
		}else{ $result[0]->shipping_state_name ='';}
		return $result;
	}
	
	//////Ger order for use for dashboard
	function getUserOrder($customerId){
		$result = DB::table('orders')->where('customer_id',$customerId)->orderBy('id','desc')->take(5)->get();
		return $result;	
	}
	
	//////Ger all order history
	function getUserAllOrder($customerId, $sort, $page, $item){
		
		if($page>1){
			$startLimit = ($page-1)*$item;
		}else{
			$startLimit = 0;	
		}
		
		if($sort=='3months')
		{
			$createdate = date('Y-m-d 00:00:00', strtotime("-3 month"));
		}
		elseif($sort=='6months')
		{
			$createdate = date('Y-m-d 00:00:00', strtotime('-6 month'));
		}
		elseif($sort=='1year')
		{
			$createdate = date('Y-m-d 00:00:00', strtotime("-1 year"));
		}
		elseif($sort=='all')
		{
			$createdate = date('Y-m-d 00:00:00', strtotime("1972-01-01 00:00:00"));
		}
		else
		{
			$createdate = date('Y-m-d 00:00:00', strtotime("-7 day"));
		}
		
		$result = DB::select("select * from orders where customer_id = '".$customerId."' and createdate > '" . $createdate . "' order by id desc limit ".$startLimit.", ".$item);
		return $result;	
	}
	
	////Get order detai by id
	function getOrderDetail($id){
		$result = DB::table('orders')->where('id',$id)->get();
		
		$billingState = DB::table('states')->where('zone_id', $result[0]->billing_state)->get();
		$billingCountry = DB::table('countries')->where('country_id', $result[0]->billing_country)->get();
		
		$shippingState = DB::table('states')->where('zone_id', $result[0]->shipping_state)->get();
		$shippingCountry = DB::table('countries')->where('country_id', $result[0]->shipping_country)->get();
		
		$result[0]->billing_country_name = (isset($billingCountry[0]->name) ? $billingCountry[0]->name : '');
		$result[0]->billing_state_name = (isset($billingState[0]->name) ? $billingState[0]->name : '');
		
		$result[0]->shipping_country_name = (isset($shippingCountry[0]->name) ? $shippingCountry[0]->name : '');
		$result[0]->shipping_state_name = (isset($shippingState[0]->name) ? $shippingState[0]->name : '');
		
		return $result;	
	}
	
	////Get product list for an order
	public function getOrderToProduct($order_id){
		return DB::table('order_to_product as otp')->select('otp.*', 'p.product_name', 'p.product_code', 'p.thumbnail_image_1', 'p.thumbnail_image_2', 'c.title as color_name')->leftjoin('colors as c','c.id', '=','otp.color_id' )->leftjoin('products as p','p.id', '=','otp.product_id' )->where('otp.order_id', $order_id)->get();
	}
	
}
?>