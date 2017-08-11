<?php namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Http\Models\Front\Users;
use App\Http\Models\Countries;
use App\Http\Controllers\Customers;
use Session;
use Input;
use Illuminate\Http\RedirectResponse;
//use Auth;
use Validator;
use Hash;
use DB;
use Redirect;
use Request;
use Response;


class UserController extends Controller {
	private $data = array();
	
	/**
	 * Create a user controller instance.
	 *
	 * @return void
	*/
	public function __construct()
	{
		//// make object for Users class to use user model
		$this->UsersModel = new Users();
	}

	/**
	 * Index page
	 *
	 * @return Response
	 */
	public function index(){
	}
	
	
	///// creatte an account form page
	public function create_account()
	{
		$this->data['page_title'] = 'Create an Account';
		$CountriesModel = new Countries();
		$this->data['countries'] = DB::table('countries')->orderBy('name', 'ASC')->get();
		return view('front.user.create_account', $this->data);
	}
	
	
	/////// create an account after post and insert value in DB table
	public function create_account_register()
	{
		$post=$_POST;
		$file= $_FILES;
		
		
		if(Request::isMethod('post'))
		{
			//create password format validation rule
			Validator::extend('passwordFormat', function($field,$value,$parameters){
					if(preg_match('/^(?=.*\d)(?=.*[a-zA-Z])(?=.*[*@$!+%~]).{8,12}$/', $value)==true){
						return true;
					}else{
						return false;
					}
			});
			$messages = [
				'password_format' => 'Password length should be between 8-12 characters with combination of alphabet letters, digits & special characters (eg. *@$!+%~).',
			];
				
				$validator = Validator::make(Request::all(),[
				'billing_first_name' => 'required',
				'billing_last_name' => 'required',
				'billing_telephone' => 'required',
				'birth_date' => 'required',
				'billing_email' => 'required',
				'password' =>'required|passwordFormat',
				'passconf' => 'required',
				'newsletter_subscription' => 'required',
				'agree' => 'required',
				'billing_address' => 'required',
				'billing_city' => 'required',
				'billing_post_code' => 'required',
				//'billing_state' => 'required',
				'billing_country' => 'required',
				'g-recaptcha-response' => 'required',
			],$messages);
			
			if ($validator->fails()) { 
				$errors = $validator->errors()->all() ;
				return Redirect::to('create_account')->withInput()->with('error', 'Oops! Your account hasn\'t been created yet. Please check and correct the errors below.')->with('errors', $errors);
			}else{
				$results = DB::table('customers')->where('email',$post['billing_email'])->get();
				if( count($results) > 0 ) {
					return Redirect::to('create_account')->withInput()->with('error','This email  is address already registered .');
				}else {
					$this->UsersModel->insertregistereddata(Request::input());
					 return Redirect::to('create_account')->withInput()->with('success','Account  has been created successfully..');
				}
			}
		}
			
		return view('front.user.create_account');
	}
	
	
	///// Login page form
	public function login()
	{
		$this->data['page_title'] = 'Login';
		return view('front.user.login', $this->data);
	}
	
	////// login logic after post value from login page
	public function logincustomers(){
	 	$post= $_POST; 
	    $password =  Hash::make($post['password']);
		$a= Hash::check($post['password'], $password);
		
		$results = DB::table('customers')->where('email',$post['email'])->where('status',1)->get(); 
		if(count($results)>0){
			foreach($results as $res)
			{
				$pw= $res->password;
			$b =Hash::check($post['password'], $pw); // true
			}
			
			if($a==$b)
			{  
		 		Session::put('userId', $res->id);
				Session::put('userEmail', $res->email);
				Session::put('userFirstName', $res->first_name);
				Session::put('userLastName', $res->last_name);
				
				if($post['redirect']=='checkout'){
					//return Redirect::intended('dashboard');
					return redirect('/checkout');
				}else{
					return Redirect::to('dashboard')->withInput()->with('success','From your My Account Dashboard you have the ability to view a snapshot of your recent account activity and update your account information. You can view your order history or edit your information. ');
				}
				
            }else{
			 	return Redirect::to('login')->withInput()->with('error','Oops! You have entered wrong User ID or Password. Please try again.');
			}
		}else{
			return Redirect::to('login')->withInput()->with('error','We are sorry! Your account does not exist. If you don\'t have an account with us, please proceed to registration page.');
		}	
	}
	
	///// logout form account
	public function logout()
	{	Session::forget('userId');
		Session::forget('userEmail');
		Session::forget('userFirstName');
		Session::forget('userLastName');
		Session::forget('cart');
		//return Redirect::to('login')->withInput()->with('success','Logged Out.');
		return redirect(\URL::previous())->withInput()->with('success','Logged Out.'); 
	}
	
	////// dashboard after login
	public function dashboard()
	{
		$this->data['page_title'] = 'Account Dashboard';
		if(Session::get('userId')!='' and Session::get('userEmail')!=''){
			//Load left
			$this->data['user_left'] = view('front.user.userLeft');
			
			///Get user detail
			$this->data['userDetail'] = $this->UsersModel->getUserById(Session::get('userId'));
			
			///Get order of user
			$this->data['userOrders'] = $this->UsersModel->getUserOrder(Session::get('userId'));
						
			////Get newsletter subscribation status
			$this->data['newsletterStatus'] = $this->UsersModel->getNewsletterStatus(Session::get('userEmail'));
			
			return view('front.user.dashboard', $this->data);
		}else{
			return Redirect::intended('login')->withInput()->with('error','Oops! You have to need login to access for this section.');
		}
	}
	
	/////// view account information and edit
	public function accountEdit(){
		if(Session::get('userId')!='' and Session::get('userEmail')!=''){
			$this->data['page_title'] = 'Account Edit';
			
			////// After POST data
			$post=$_POST;
			$file= $_FILES;
			if(Request::isMethod('post'))
			{
				//create password format validation rule
				Validator::extend('passwordFormat', function($field,$value,$parameters){
						if(preg_match('/^(?=.*\d)(?=.*[a-zA-Z])(?=.*[*@$!+%~]).{8,12}$/', $value)==true){
							return true;
						}else{
							return false;
						}
				});
				
				$messages = [
					'password_format' => 'Password length should be between 8-12 characters with combination of alphabet letters, digits & special characters (eg. *@$!+%~).',
				];

				$validator = Validator::make(Request::all(),[
					'billing_first_name' => 'required',
					'billing_last_name' => 'required',
					'billing_telephone' => 'required',
					'birth_date' => 'required',
					'billing_email' => 'required|email',
					'current_password' =>'required',
					'password' =>'passwordFormat',
					'billing_address' => 'required',
					'billing_city' => 'required',
					'billing_post_code' => 'required',
					//'billing_state' => 'required',
					'billing_country' => 'required',
				],
											$messages);
				
				if ($validator->fails()) { 
					$errors = $validator->errors()->all() ;
					return Redirect::to('accountedit')->withInput()->with('error', 'Oops! Your account information hasn\'t been updated yet. Please check and correct the errors below.')->with('errors', $errors);
				}else{
					///// check password and confirm password are match or not
					if($post['password']!=$post['passconf']){
						return Redirect::to('accountedit')->withInput()->with('error','Password and Confirm Password are not match!');
					}
					
					///// check password is correct?
					$password =  Hash::make($post['current_password']);
					$a= Hash::check($post['current_password'], $password);
					
					$results = DB::table('customers')->where('id','=', $post['userId'])->get();
					
					if( count($results) > 0 ) {
						
						foreach($results as $res){
							$pw= $res->password;
							$b =Hash::check($post['current_password'], $pw); // true
						}
						
						if($a==$b){
							$results = DB::table('customers')->where('email',$post['billing_email'])->where('id','!=', $post['userId'])->get();
							if( count($results) > 0 ) {
								return Redirect::to('accountedit')->withInput()->with('error','This email address is already in use.');
							}else {
								$this->UsersModel->updateAccount(Request::input());
								 return Redirect::to('accountedit')->withInput()->with('success','Account information has been updated successfully..');
							}
						}else{
							return Redirect::to('accountedit')->withInput()->with('error','Current password is not matched.Please check');
						}
					}
				}
			}
			
			
			//Load left
			$this->data['user_left'] = view('front.user.userLeft');
			
			///Get user detail
			$this->data['userDetail'] = $this->UsersModel->getUserById(Session::get('userId'));
			
			//Country
			$CountriesModel = new Countries();
			$this->data['countries'] = DB::table('countries')->orderBy('name', 'ASC')->get();
			
			//States of current country
			$CountriesModel = new Countries();
			$this->data['states'] = $CountriesModel->getStatesByCountry($this->data['userDetail'][0]->billing_country);
			
			return view('front.user.accountEdit', $this->data);
		}else{
			return Redirect::intended('login')->withInput()->with('error','Oops! You have to need login to access for this section.');
		}		
	}
	
	//// Get and update billing info
	public function billingaddress(){
		if(Session::get('userId')!='' and Session::get('userEmail')!=''){
			$this->data['page_title'] = 'Billing Address';
			
			////// After POST data
			$post=$_POST;
			$file= $_FILES;
			if(Request::isMethod('post'))
			{
				$validator = Validator::make(Request::all(),[
					'billing_first_name' => 'required',
					'billing_last_name' => 'required',
					'billing_telephone' => 'required',
					'billing_email' => 'required|email',
					'billing_address' => 'required',
					'billing_city' => 'required',
					'billing_post_code' => 'required',
					//'billing_state' => 'required',
					'billing_country' => 'required',
				]);
				
				if ($validator->fails()) { 
					$errors = $validator->errors()->all() ;
					return Redirect::to('billingaddress')->withInput()->with('error', 'Oops! Your billing information hasn\'t been updated yet. Please check and correct the errors below.')->with('errors', $errors);
				}else{
					$this->UsersModel->updateBillingInfo(Request::input());
					return Redirect::to('billingaddress')->withInput()->with('success','Billing information has been updated successfully..');
				}
			}
			
			
			//Load left
			$this->data['user_left'] = view('front.user.userLeft');
			
			///Get user detail
			$this->data['userDetail'] = $this->UsersModel->getUserById(Session::get('userId'));
			
			//Country
			$CountriesModel = new Countries();
			$this->data['countries'] = DB::table('countries')->orderBy('name', 'ASC')->get();
			
			//States of current country
			$CountriesModel = new Countries();
			$this->data['states'] = $CountriesModel->getStatesByCountry($this->data['userDetail'][0]->billing_country);
			
			return view('front.user.billingaddress', $this->data);
		}else{
			return Redirect::intended('login')->withInput()->with('error','Oops! You have to need login to access for this section.');
		}	
	}
	
	//// Get and update shipping info
	public function shippingaddress(){
		if(Session::get('userId')!='' and Session::get('userEmail')!=''){
			$this->data['page_title'] = 'Shipping Address';
			
			////// After POST data
			$post=$_POST;
			$file= $_FILES;
			if(Request::isMethod('post'))
			{
				$validator = Validator::make(Request::all(),[
					'shipping_first_name' => 'required',
					'shipping_last_name' => 'required',
					'shipping_telephone' => 'required',
					'shipping_email' => 'required|email',
					'shipping_address' => 'required',
					'shipping_city' => 'required',
					'shipping_post_code' => 'required',
					//'shipping_state' => 'required',
					'shipping_country' => 'required',
				]);
				
				if ($validator->fails()) { 
					$errors = $validator->errors()->all() ;
					return Redirect::to('shippingaddress')->withInput()->with('error', 'Oops! Your shipping information hasn\'t been updated yet. Please check and correct the errors below.')->with('errors', $errors);
				}else{
					$this->UsersModel->updateShippingInfo(Request::input());
					return Redirect::to('shippingaddress')->withInput()->with('success','Shipping information has been updated successfully..');
				}
			}
			
			
			//Load left
			$this->data['user_left'] = view('front.user.userLeft');
			
			///Get user detail
			$this->data['userDetail'] = $this->UsersModel->getUserById(Session::get('userId'));
			
			//Country
			$CountriesModel = new Countries();
			$this->data['countries'] = DB::table('countries')->orderBy('name', 'ASC')->get();
			
			//States of current country
			$CountriesModel = new Countries();
			$this->data['states'] = $CountriesModel->getStatesByCountry($this->data['userDetail'][0]->shipping_country);
			
			return view('front.user.shippingaddress', $this->data);
		}else{
			return Redirect::intended('login')->withInput()->with('error','Oops! You have to need login to access for this section.');
		}	
	}
	
	////user subscribe or unsubscribe
	public function newsletter(){
		if(Session::get('userId')!='' and Session::get('userEmail')!=''){
				////// After POST data
				$post=$_POST;
				if(Request::isMethod('post'))
				{
					if(isset($post['nwslttr']) and $post['nwslttr']!='' and $post['nwslttr']=='subscribe'){
						$this->UsersModel->newsletter(Request::input());
						return Redirect::to('dashboard')->withInput()->with('success','Subscribed successfully..');
					}else{
						$this->UsersModel->newsletter(Request::input());
						return Redirect::to('dashboard')->withInput()->with('success','Unsubscribed successfully..');
					}
				}
		}else{
			return Redirect::intended('login')->withInput()->with('error','Oops! You have to need login to access for this section.');
		}	
	}
	 
	////// My Order History
	public function orderhistory($sort='all', $page='1')
	{	
		$this->data['sort'] = $sort;
		$this->data['page'] = $page;
		$this->data['item'] = 10;
		
		if(Session::get('userId')!='' and Session::get('userEmail')!=''){
			$this->data['page_title'] = 'Order History';
			
			//Load left
			$this->data['user_left'] = view('front.user.userLeft');
			
			///Get all order of user
			$this->data['userOrders'] = $this->UsersModel->getUserAllOrder(Session::get('userId'), $sort, $page, $this->data['item']);
			
			//// Total orders
			$totalOrders = DB::table('orders')->where('customer_id',Session::get('userId'))->orderBy('id','desc')->get();
			$this->data['countOrders'] = count($totalOrders);
						
			return view('front.user.orderhistory', $this->data);
		}else{
			return Redirect::intended('login')->withInput()->with('error','Oops! You have to need login to access for this section.');
		}
	}
	
	////Get order detail
	public function orderdetails($id){
		if(Session::get('userId')!='' and Session::get('userEmail')!=''){
			$this->data['page_title'] = 'Order Detail';
			
			//Load left
			$this->data['user_left'] = view('front.user.userLeft');
			
			///Get all order of user
			$this->data['userOrderDetails'] = $this->UsersModel->getOrderDetail($id);
			
			$this->data['orderProducts'] = $this->UsersModel->getOrderToProduct($id);
						
			return view('front.user.orderdetails', $this->data);
		}else{
			return Redirect::intended('login')->withInput()->with('error','Oops! You have to need login to access for this section.');
		}
	}
	
	
	////// get states for a country
	public function getStates(){
		$CountriesModel = new Countries();
		$json['states'] = $CountriesModel->getStatesByCountry(Input::get('country_id'));
		return Response::json($json);
	}
	
	////////////////////////////////////////////////////
	/////////////reset password
	
	public function resetmail()
	{
		$post=$_POST;
		$email= $post['email'];
		//echo $email;
		$recordSet =DB::table('customers')->where('email',$email)->get();
		
		$total=count($recordSet);
		if($total == 0)
		{
			$response = 'Email does not exist.';
		}
		else
		{
			// Get user details
			$userData = $recordSet;
			//print_r($userData);
			//die;
			$formData = $userData[0];
			$code=  rand(0,99999);
			$data['code'] = $code;
			DB::table('customers')->where('email', $email)->update($data);
			
			// send mail			
			$to = $email;
			$to_name = $formData->first_name;
			
			$from = 'no-reply@docbox.com';
			$from_name = 'Customer Support Team';
			
			$subject = "Password Recovery";
			
			
			
			$to = $formData->email;
			$to_name = $formData->first_name;
			$from = 'shop@tbm.com.my';
			$from_name = 'SHOP TBM';
			$subject = "Reset Password in shop.tbm.com.my";

			$message = "Hello ".$formData->first_name."<br><br>";
			$message .= "Please <a href='http://shop.tbm.com.my/passwordreset?email=".$to."&code=".$code."'>click here</a> to reset your password.<br/>";		
			$message .= "<br><br>Thank you.<br/>";
			$message .= "<br><br>Best Regards,<br/>";
			$message .= "TBM Online Registration Manager<br/>";
			$message .= "TAN BOON MING SDN BHD (494355-D)<br/>";
			$message .= "PS 4,5,6 & 7, Taman Evergreen, Batu 4, Jalan Klang Lama, 58100 Kuala Lumpur.<br/>";
			$message .= "Tel: (603) 7983-2020 (Hunting Lines)<br/>";
			$message .= "Fax: (603) 7982-8141<br/>";
			$message .= "info@tbm.com.my<br/>";
			$message .= "Business Hours:<br/>";
			$message .= "Mon. - Sat.: 9.30am - 9.00pm<br/>";
			$message .= "Sun.: 10.00am - 9.00pm";
				
			$headers = "From:".$from . "\r\n" ;
			$headers .= "MIME-Version: 1.0" . "\r\n";
        	$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
			mail($to,$subject,$message,$headers);
			$response = 'Password has been sent to '.$email;
				
			$response = 'Password has been sent to '.$email.' Kindly  check your email ';
		
		}
		//return $response;
		 return Redirect::to('login')->withInput()->with('success',$response);
	
	}
/************************************************/	
	function passwordreset()
	{ 
		$this->data['page_title'] = 'Reset Password';
		return view('front.user.passwordreset', $this->data);
	}
	
/************************************************/		
	function passwordresetpost()
	{
		$post= $_POST;
		$email= $post['email'];
		$code= $post['code'];
		$password= $post['password'];
		
		
		if(Request::isMethod('post'))
		{
			//create password format validation rule
			Validator::extend('passwordFormat', function($field,$value,$parameters){
					if(preg_match('/^(?=.*\d)(?=.*[a-zA-Z])(?=.*[*@$!+%~]).{8,12}$/', $value)==true){
						return true;
					}else{
						return false;
					}
			});
			$messages = [
				'password_format' => 'Password length should be between 8-12 characters with combination of alphabet letters, digits & special characters (eg. *@$!+%~).',
			];
				$validator = Validator::make(Request::all(),[
				
				'password' =>'required|passwordFormat',
				'passconf' => 'required',
			],$messages);
			
			if ($validator->fails()) { 
				$errors = $validator->errors()->all() ;
				return Redirect::to("http://shop.tbm.com.my/passwordreset?email=".$email."&code=".$code."" )->withInput()->with('error', 'Password length should be between 8-12 characters with combination of alphabet letters, digits & special characters (eg. *@$!+%~).')->with('errors', $errors);
			}else{
				$recordSet =DB::table('customers')->where('email',$email)->where('code',$code)->get();
		
				$total=count($recordSet);
				if($total == 0)
				{
					$response = 'Retry to reset your password.';
				}
		else
		{
				$data['password'] = Hash::make($password);
				$data['code'] = '';
				DB::table('customers')->where('email', $email)->update($data);
				
		       return Redirect::to('login')->withInput()->with('success','Welcome back Dear "'.$email.'" ');
				
			}
		}
	}
	}

}
