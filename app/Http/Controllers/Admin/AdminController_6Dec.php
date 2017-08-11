<?php namespace App\Http\Controllers\Admin;
use Illuminate\Support\Facades\Paginator;

use App\Http\Controllers\Controller;
use App\Http\Models\User;
use App\Http\Models\Admin\Orders;
use App\Http\Models\Admin\Banner; 
use Session;
use Input;
use Illuminate\Http\RedirectResponse;
use App\Http\Models\Admin\Category;
use Auth;
use Validator;
use Hash;
use DB;
use Redirect;
//use App\Http\Requests\Request;
use Request;

use View;

class AdminController extends Controller {
	private $data = array();
	private $BannerModel = null;
	private $CategoryModel = null;
	/*
	|--------------------------------------------------------------------------
	| Home Controller
	|--------------------------------------------------------------------------
	|
	| This controller renders your application's "dashboard" for users that
	| are authenticated. Of course, you are free to change or remove the
	| controller as you wish. It is just here to get your app started!
	|
	*/

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->middleware('auth');
		$this->BannerModel = new Banner();
		$this->CategoryModel = new Category();
	}

	function index()
	{
		return redirect('web88cms/dashboard');
	}
	
	function login()
	{	
		return redirect('/web88cms/dashboard');
	}
	
	function logout()
	{
		//return redirect('/auth/logout/');	
		Auth::logout();
		return redirect('web88cms/login');
	}

	/**
	 * Show the application dashboard to the user.
	 *
	 * @return Response
	 */
	public function dashboard()
	{
		
		//// Get orders for dashboard order graph
		$data['graphOrders'] = DB::select("SELECT sum(totalPrice) as totalPrice,MONTH(modifydate) as month FROM `orders` where YEAR(modifydate)=YEAR(CURDATE()) and payment_status='Paid' group by MONTH(modifydate) order by MONTH(modifydate)" );
		
		//// Get today sale dashboard order graph
		$data['todaySale'] = DB::select("SELECT sum(totalPrice) as totalPrice FROM `orders` where YEAR(modifydate)=YEAR(CURDATE()) and MONTH(modifydate)=MONTH(CURDATE()) and DAY(modifydate)=DAY(CURDATE()) and payment_status='Paid' group by MONTH(modifydate) order by MONTH(modifydate)" );
		
		//// Get customers for dashboard customer graph
		$data['newCustomers'] = DB::select("SELECT count(id) as countCustomers,MONTH(createdate) as month FROM `customers` where YEAR(createdate)=YEAR(CURDATE()) group by MONTH(createdate) order by MONTH(createdate)" );
		
		//// Get returning customers for dashboard customer graph
		$data['returnCustomers'] = DB::select("SELECT MONTH( modifydate ) AS month, count(customer_id) as countCustomers FROM  `orders` WHERE YEAR( modifydate ) = YEAR( CURDATE( ) ) GROUP BY MONTH( modifydate ) ORDER BY MONTH( modifydate )");

		///// GET last 5 orders
	//	$data['last5Orders'] = DB::select("select *, sum(order_to_product.quantity) as quantity from orders inner join order_to_product on orders.id = order_to_product.order_id group by order_to_product.order_id order by orders.id desc limit 5 offset 0");
		$last5orders = DB::select("select id from orders order by id desc limit 5");
		$orderModel = new Orders();
		foreach ($last5orders as $last5order) {
			$order = $orderModel->getOrderTax($last5order->id);
			$data['last5Orders'][] = $order;
		}
			
		///// GET life time sales
		$data['lifetimesales']= DB::select("SELECT sum(totalPrice)   as totalsale FROM orders WHERE payment_status='Paid'" );
		
		//////// Get average order
  		$data['totalorder']= DB::select("select AVG(`totalPrice`) as average FROM orders WHERE payment_status='Paid'" );
		
		////// GET Best Sellers
		$data['bestsellers']= DB::select("SELECT p.id as product_id,p.product_name ,p.sale_price, dertable.quantityordered  FROM products p INNER JOIN (SELECT DISTINCT(product_id)  as pro_id ,SUM(quantity) as quantityordered FROM `order_to_product` WHERE `order_id` IN (SELECT id
FROM orders WHERE STATUS = 'Completed') group by product_id  order by SUM(quantity) DESC) as dertable ON p.id=dertable.pro_id limit 0,5");
  		
		///// Get New Customers
		$data['newcustomers']= DB::select("SELECT `first_name` ,id, `email`, `createdate`FROM `customers` order by`createdate` desc limit 0,5");
		
		///// GET most viwed product
		$data['mostViwedProducts'] = DB::select("SELECT * FROM products inner join viewProduct on products.id = viewProduct.product_id order by viewProduct.views_count desc limit 5 offset 0");
		
		$data['search_terms'] = DB::select("select * from search_terms order by last_searched desc limit 5 offset 0");
				
		return view('admin.dashboard')->with('data', $data);
	}
	
	function updatePassword($user_id)
	{
		if(Request::isMethod('post'))
		{
			//DB::table('password_resets')->insert(array('token' => Input::get('_token')));// exit;
		
			$password           = Input::get('password');
			$passwordconf       = Input::get('password_confirmation');
			
			$validator = Validator::make(	Request::all(),[
												'password' => 'required|confirmed|min:6',
												'password_confirmation' => 'required_with:password|min:6',
											]
										);                
	
		  if ($validator->fails()) {  
				$json['error'] = $validator->errors()->all(); 
				echo json_encode($json);
				exit;
				//return Redirect::back()->withErrors($validator);
				//echo Redirect::back()->withErrors($validator); exit;
				
			}
			else
			{
				//echo Hash::make($password); // hash password
				$user = User::find($user_id);
				$user->password = Hash::make($password);
				$user->save();
				
				echo json_encode(array('success' => 'success'));
				exit;	
			}			
		}
		return view('admin.updatePassword');
	}
	
	
	function updateAvtar($user_id)
	{
		if(Request::isMethod('post'))
		{
			//DB::table('password_resets')->insert(array('token' => Input::get('_token')));// exit;
		
			$messages = [
				//'required' => 'The :attribute field is required.',
				'max' => 'Max file size should be less than 2MB.',
			];
			
			$validator = Validator::make(	Request::all(),[
												'avtarImage' => 'required|image|mimes:jpeg,png,gif|max:2000',
											],
											$messages
										);                
	
		  if ($validator->fails()) {  
				$json['error'] = $validator->errors()->all(); 
				echo json_encode($json);
				exit;
				//return Redirect::back()->withErrors($validator);
				//echo Redirect::back()->withErrors($validator); exit;
				
			}
			else
			{
				//echo '<pre>'; print_r($_FILES); exit;
				$imageName = time().'_'.$_FILES['avtarImage']['name'];
				Request::file('avtarImage')->move(
					base_path() . '/public/admin/avtar/', $imageName
				);
				
				$user = User::find($user_id);
				$user->image = $imageName;
				$user->save();
				
				echo json_encode(array('success' => $imageName));
				exit;	
			}			
		}
		return view('admin.updatePassword');
	}
	/*function getUserDetails($id)
	{
		$user = new User();
		$data['userDetails'] = $user->getUser($id);
		return view('admin.profile', $data);
	}
	
	function getAlbums()
	{
		$user = new User();
		$data['albums'] = $user->getAlbums();
		return view('admin.albums', $data);
	}
	
	public function checkSession()
	{
		Session::put('session_key', 'sad adl lasdla');
		echo Session::get('session_key');
		exit;
		//return view('admin.dashboard');
	}*/


        public function bannertop()
	{
		
		$currentdate=date('Y-m-d');
		 $resultsdata = DB::update("UPDATE banner_top SET status= 0 WHERE end_date <'".$currentdate."' ");
		
		if((isset($_GET['rec'])&&$_GET['rec']!=''))
		{
			$data['num_rec_per_page'] = $num_rec_per_page = $_GET['rec'];
		}
		else
		{
		$data['num_rec_per_page'] = $num_rec_per_page = 10;
		}
		if (isset($_GET["page"])) { $page  = $_GET["page"]; } else { $page=1; }; 
        $start_from = ($page-1) * $num_rec_per_page; 
		$pagedata = DB::table('banner_top');
		$total_records = $pagedata->count();
		$data['total_pages'] = ceil($total_records / $num_rec_per_page); 
         $data['start_from']=$start_from  =(($page-1) * ($num_rec_per_page)); 
		 $data['banner_alltopdata'] = DB::select("SELECT * FROM banner_top");
		$data['banner_topdata'] = DB::select("SELECT * FROM banner_top LIMIT $start_from, $num_rec_per_page" );
		
		/*Showing 3 to 4 of 8 entries*/

		$page_to = (($page * $num_rec_per_page) > $total_records) ? $total_records : ($page * $num_rec_per_page);
		if($page_to==0){
			$data['msg'] = 'Showing '. $page_to .' to '. $page_to .' of '. $total_records .' entries';
		}else{ 
		$data['msg'] = 'Showing '. ((($page-1) * $num_rec_per_page) + 1) .' to '. $page_to .' of '. $total_records .' entries';
		}
		//$data['msg'] = 'Showing '. ((($page-1) * $num_rec_per_page) + 1) .' to '. $page_to .' of '. $total_records .' entries';
		/*Showing 3 to 4 of 8 entries end*/
		
		$data['page_title']='Index Top Banners:: Listing';
		
		$data['lastUpdated'] = $this->BannerModel->getLastUpdatedtop();
		return View::make('admin.index_banner_top_list')->with('result', $data);
	}
	public function bannermiddletop()
	{
		$currentdate=date('Y-m-d');
		 $resultsdata = DB::update("UPDATE banner_middle_top SET status= 0 WHERE end_date <'".$currentdate."' ");
		
		if((isset($_GET['rec'])&&$_GET['rec']!=''))
		{
			$data['num_rec_per_page'] = $num_rec_per_page = $_GET['rec'];
		}
		else
		{
		$data['num_rec_per_page'] = $num_rec_per_page = 10;
		}
		if (isset($_GET["page"])) { $page  = $_GET["page"]; } else { $page=1; }; 
        $start_from = ($page-1) * $num_rec_per_page; 
		$pagedata = DB::table('banner_middle_top');
		$total_records = $pagedata->count();
		$data['total_pages'] = ceil($total_records / $num_rec_per_page); 
         $data['start_from']=$start_from  =(($page-1) * ($num_rec_per_page));
		 $data['banner_allmiddletopdata'] = DB::select("SELECT * FROM banner_middle_top"); 
		$data['banner_middletopdata'] = DB::select("SELECT * FROM banner_middle_top LIMIT $start_from, $num_rec_per_page" );
		
		/*Showing 3 to 4 of 8 entries*/

		$page_to = (($page * $num_rec_per_page) > $total_records) ? $total_records : ($page * $num_rec_per_page);
		if($page_to==0){
			$data['msg'] = 'Showing '. $page_to .' to '. $page_to .' of '. $total_records .' entries';
		}else{ 
		$data['msg'] = 'Showing '. ((($page-1) * $num_rec_per_page) + 1) .' to '. $page_to .' of '. $total_records .' entries';
		}
		//$data['msg'] = 'Showing '. ((($page-1) * $num_rec_per_page) + 1) .' to '. $page_to .' of '. $total_records .' entries';
		/*Showing 3 to 4 of 8 entries end*/
		
		$data['page_title']='Index Middle Top Banners:: Listing';
		
		//$data['banner_middletopdata']= DB::table('banner_middle_top')->select('*')->take($num_rec_per_page)->get();
		$data['lastUpdated'] = $this->BannerModel->getLastUpdatedmiddletop();					 		
		return View::make('admin.index_middle_top_list')->with('result', $data);
	}
	public function bannermiddlebottom()
	{
		
		$currentdate=date('Y-m-d');
		 $resultsdata = DB::update("UPDATE banner_middle_bottom SET status= 0 WHERE end_date <'".$currentdate."' ");
		//$data['banner_middlebottomdata']= DB::table('banner_middle_bottom')->select('*')->get();
		if((isset($_GET['rec'])&&$_GET['rec']!=''))
		{
			$data['num_rec_per_page'] = $num_rec_per_page = $_GET['rec'];
		}
		else
		{
		$data['num_rec_per_page'] = $num_rec_per_page = 10;
		}
		if (isset($_GET["page"])) { $page  = $_GET["page"]; } else { $page=1; }; 
        $start_from = ($page-1) * $num_rec_per_page; 
		$pagedata = DB::table('banner_middle_bottom');
		
		$data['banner_allmiddlebottomdata'] = DB::select("SELECT * FROM banner_middle_bottom" );
		
		$total_records = $pagedata->count();
		$data['total_pages'] = ceil($total_records / $num_rec_per_page); 
        $data['start_from']=$start_from  =(($page-1) * ($num_rec_per_page)); 
		$data['banner_middlebottomdata'] = DB::select("SELECT * FROM banner_middle_bottom LIMIT $start_from, $num_rec_per_page" );
		
		
		
		/*Showing 3 to 4 of 8 entries*/

		$page_to = (($page * $num_rec_per_page) > $total_records) ? $total_records : ($page * $num_rec_per_page);
		
		if($page_to==0){
			$data['msg'] = 'Showing '. $page_to .' to '. $page_to .' of '. $total_records .' entries';
		}else{ 
		$data['msg'] = 'Showing '. ((($page-1) * $num_rec_per_page) + 1) .' to '. $page_to .' of '. $total_records .' entries';
		}
		//$data['msg'] = 'Showing '. ((($page-1) * $num_rec_per_page) + 1) .' to '. $page_to .' of '. $total_records .' entries';
		
		
		$data['page_title']='Index Middle Bottom Banners:: Listing';
							 
		$data['lastUpdated'] = $this->BannerModel->getLastUpdatedmiddlebottom();		
		return View::make('admin.index_middle_bottom_list')->with('result', $data);
	}
	public function leftbanner()
	{
		$currentdate=date('Y-m-d');
		 $resultsdata = DB::update("UPDATE banner_left SET status= 0 WHERE end_date <'".$currentdate."' ");
		//return view('admin.left_banner_list');
		
		//$data['banner_leftdata']= DB::table('banner_left')->select('*')->get();	
		
		if((isset($_GET['rec'])&&$_GET['rec']!=''))
		{
			$data['num_rec_per_page'] = $num_rec_per_page = $_GET['rec'];
		}
		else
		{
		$data['num_rec_per_page'] = $num_rec_per_page = 10;
		}
		if (isset($_GET["page"])) { $page  = $_GET["page"]; } else { $page=1; }; 
        $start_from = ($page-1) * $num_rec_per_page; 
		$pagedata = DB::table('banner_left');
		$total_records = $pagedata->count();
		$data['total_pages'] = ceil($total_records / $num_rec_per_page); 
         $data['start_from']=$start_from  =(($page-1) * ($num_rec_per_page)); 
		 $data['banner_allleftdata'] = DB::select("SELECT * FROM banner_left");
		$data['banner_leftdata'] = DB::select("SELECT * FROM banner_left LIMIT $start_from, $num_rec_per_page" );
		
		/*Showing 3 to 4 of 8 entries*/

		$page_to = (($page * $num_rec_per_page) > $total_records) ? $total_records : ($page * $num_rec_per_page);
		if($page_to==0){
			$data['msg'] = 'Showing '. $page_to .' to '. $page_to .' of '. $total_records .' entries';
		}else{ 
		$data['msg'] = 'Showing '. ((($page-1) * $num_rec_per_page) + 1) .' to '. $page_to .' of '. $total_records .' entries';
		}
		//$data['msg'] = 'Showing '. ((($page-1) * $num_rec_per_page) + 1) .' to '. $page_to .' of '. $total_records .' entries';
		/*Showing 3 to 4 of 8 entries end*/
		
		
		
		
		$data['page_title']='Left Banners:: Listing';
		
		$data['lastUpdated'] = $this->BannerModel->getLastUpdatedleft();				 
		
		return View::make('admin.left_banner_list')->with('result', $data);
	} 
	
	public function leftpromotionbanner()
	{
		$currentdate=date('Y-m-d');
		 $resultsdata = DB::update("UPDATE banner_left_promotion SET status= 0 WHERE end_date <'".$currentdate."' ");
		//return view('admin.left_promotion_banner_list');
		//$data['banner_leftpromotiondata']= DB::table('banner_left_promotion')->select('*')->get();	
		if((isset($_GET['rec'])&&$_GET['rec']!=''))
		{
			$data['num_rec_per_page'] = $num_rec_per_page = $_GET['rec'];
		}
		else
		{
		$data['num_rec_per_page'] = $num_rec_per_page = 10;
		}
		if (isset($_GET["page"])) { $page  = $_GET["page"]; } else { $page=1; }; 
        $start_from = ($page-1) * $num_rec_per_page; 
		$pagedata = DB::table('banner_left_promotion');
		$total_records = $pagedata->count();
		$data['total_pages'] = ceil($total_records / $num_rec_per_page); 
         $data['start_from']=$start_from  =(($page-1) * ($num_rec_per_page)); 
		 $data['banner_allleftpromotiondata'] = DB::select("SELECT * FROM banner_left_promotion");
		$data['banner_leftpromotiondata'] = DB::select("SELECT * FROM banner_left_promotion LIMIT $start_from, $num_rec_per_page" );
		
		/*Showing 3 to 4 of 8 entries*/

		$page_to = (($page * $num_rec_per_page) > $total_records) ? $total_records : ($page * $num_rec_per_page);
		if($page_to==0){
			$data['msg'] = 'Showing '. $page_to .' to '. $page_to .' of '. $total_records .' entries';
		}else{ 
		$data['msg'] = 'Showing '. ((($page-1) * $num_rec_per_page) + 1) .' to '. $page_to .' of '. $total_records .' entries';
		}
		//$data['msg'] = 'Showing '. ((($page-1) * $num_rec_per_page) + 1) .' to '. $page_to .' of '. $total_records .' entries';
		/*Showing 3 to 4 of 8 entries end*/
		
		
		
		
		$data['page_title']='Left Promotion Banners:: Listing';
						 
		$data['lastUpdated'] = $this->BannerModel->getLastUpdatedleftpromotion();
		return View::make('admin.left_promotion_banner_list')->with('result', $data);
	}
	public function productbanner()
	{
		//return view('admin.product_banner_list');
		//$data['banner_productdata']= DB::table('product_banner_list')->select('*')->get();
		
		$currentdate=date('Y-m-d');
		 $resultsdata = DB::update("UPDATE product_banner_list SET status= 0 WHERE end_date <'".$currentdate."' ");
		
		if((isset($_GET['rec'])&&$_GET['rec']!=''))
		{
			$data['num_rec_per_page'] = $num_rec_per_page = $_GET['rec'];
		}
		else
		{
		$data['num_rec_per_page'] = $num_rec_per_page = 10;
		}
		if (isset($_GET["page"])) { $page  = $_GET["page"]; } else { $page=1; }; 
        $start_from = ($page-1) * $num_rec_per_page; 
		$pagedata = DB::table('product_banner_list');
		$total_records = $pagedata->count();
		$data['total_pages'] = ceil($total_records / $num_rec_per_page); 
         $data['start_from']=$start_from  =(($page-1) * ($num_rec_per_page)); 
		$data['banner_productdata'] = DB::select("SELECT * FROM product_banner_list LIMIT $start_from, $num_rec_per_page" );
		
		$page_to = (($page * $num_rec_per_page) > $total_records) ? $total_records : ($page * $num_rec_per_page);
		
		if($page_to==0){
			$data['msg'] = 'Showing '. $page_to .' to '. $page_to .' of '. $total_records .' entries';
		}else{ 
		$data['msg'] = 'Showing '. ((($page-1) * $num_rec_per_page) + 1) .' to '. $page_to .' of '. $total_records .' entries';
		}
		//$data['msg'] = 'Showing '. ((($page-1) * $num_rec_per_page) + 1) .' to '. $page_to .' of '. $total_records .' entries';
		/*Showing 3 to 4 of 8 entries end*/
		
		
		$data['page_title']='Product Banners:: Listing';
		
		$this->data['page_title']='tes';					 
		$data['lastUpdated'] = $this->BannerModel->getLastUpdatedproduct();
		$data['getcategories'] = $this->BannerModel->getcategorydata();
		$data['categories'] = $this->CategoryModel->getCategoriesTree();
		return View::make('admin.product_banner_list')->with('result', $data);
	}
	
	
	
	
	
	public function aboutusEdit()
	{
		$data['content'] = DB::select('select * from aboutus where id = 1');
		$data['obj'] = DB::select('select * from aboutusobjective');
		return View::make('admin.aboutusEdit')->with('result', $data);
		
		//return view::make('admin.aboutusEdit', $data);	
	}
	
	public function aboutusUpdate()
	{	
		if(Request::isMethod('post')){
			$content1 = Request::input('content1');
			$content2 = Request::input('content2');
			$content3 = Request::input('content3');
			$content4 = Request::input('content4');
			$content5 = Request::input('content5');
			$content6 = Request::input('content6');
			$content7 = Request::input('content7');
			$content8 = Request::input('content8');
			$content9 = Request::input('content9');
			$content10 = Request::input('content10');
			$content11 = Request::input('content11');
			$content12 = Request::input('content12');
			$content13 = Request::input('content13');
			$content14 = Request::input('content14');
			$content15 = Request::input('content15');
			$content16 = Request::input('content16');
			$content17 = Request::input('content17');
			$content18 = Request::input('content18');
			$content19 = Request::input('content19');
			$content20 = Request::input('content20');
			$icon1 = Request::input('icon1');
			$icon2 = Request::input('icon2');
 		   $affected = DB::update("update aboutus set content1 = ?,
		   												content2 = ?,
														content3 = ?,
														content4 = ?,
														content5 = ?,
														content6 = ?,
														content7 = ?,
														content8 = ?,
														content9 = ?,
														content10 = ?,
														content11 = ?,
														content12 = ?,
														content13 = ?,
														content14 = ?,
														content15 = ?,
														content16 = ?,
														content17 = ?,
														content18 = ?,
														content19 = ?,
														content20 = ?,
														icon1 = ?,
														icon2 = ?
														 where id = 1", [$content1, $content2, $content3, $content4, $content5, $content6, $content7, $content8, $content9, $content10, $content11, $content12, $content13, $content14, $content15, $content16, $content17, $content18, $content19, $content20, $icon1, $icon2]);
		}else{
			return view('admin.aboutusEdit');	
		}
	}
	
	public function aboutusObjective()
	{
		if(Request::isMethod('post')){
			$validator = Validator::make(Request::all(),[
				'objText' => 'required',
			]);
			
			if ($validator->fails()) {  
				$json['error'] = $validator->errors()->all(); 
				echo json_encode($json);
				exit;
			}else{
				$objText = Request::input('objText');
				$status = Request::input('status');
				if($status==1){
					$status=1;
				}else{
					$status=0;
				}
			
				$affected = DB::update("insert into aboutusObjective set objText = ?,
		   												status = ? ", [$objText, $status]);
														 
				echo json_encode(array('success' => 'success'));
				exit;
			}
		}
	}
	
	public function aboutusUpdateObjective(){
		if(Request::isMethod('post')){
			$validator = Validator::make(Request::all(),[
				'objText' => 'required',
			]);
			
			if ($validator->fails()) {  
				$json['error'] = $validator->errors()->all(); 
				echo json_encode($json);
				exit;
			}else{
				$objId = Request::input('objId');
				$objText = Request::input('objText');
				$status = Request::input('status');
				if($status==1){
					$status=1;
				}else{
					$status=0;
				}
			
				$affected = DB::update("Update aboutusObjective set objText = ?,
		   												status = ? where id=?", [$objText, $status, $objId]);
														 
				echo json_encode(array('success' => 'success'));
				exit;
			}
		}
	}
	
	public function aboutusDeleteObjective(){
		if(Request::isMethod('post')){
				$objId = Request::input('objId');
			
				$deleted  = DB::delete("delete from aboutusObjective where id='".$objId."'");
														 
				echo json_encode(array('success' => 'success'));
				exit;
		}
	}
	
	

}
