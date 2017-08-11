<?php namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Models\Admin\Product;
use App\Http\Models\Admin\Category;
use App\Http\Models\Admin\Brand;
use Session;
use Input;
use Illuminate\Http\RedirectResponse;
use Auth;
use Validator;
use Hash;
use DB;
use Redirect;
use Response;
use Request;
use View;

class CategoryController extends Controller {
	private $data = array();
	private $CategoryModel = null;
	private $Brand = null;
	private $ProductModel = null;
	
	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->middleware('auth');
		$this->ProductModel = new Product();
		$this->CategoryModel = new Category();
		$this->BrandModel = new Brand();
	}

	function index()
	{
		return redirect('web88cms/dashboard');
	}
	
	function listCategories(){
		$categories = $this->CategoryModel->getCategories();
		$categoriesHtml = $this->CategoryModel->createTreeHtml($categories);
		
		$this->data['success'] = Session::get('category.success');
		Session::forget('category.success');
		$this->data['warning'] = Session::get('category.warning');
		Session::forget('category.warning');
		
		$this->data['categories'] = $categories;
		$this->data['categoriesHtml'] = $categoriesHtml;
		
		// get last updated
		$this->data['last_modified'] = DB::table('categories')->orderBy('modifydate','desc')->pluck('modifydate');
		$this->data['page_title'] = 'Categories:: Listing';
		
		return view('admin.category.category_list', $this->data);
	}
	
	public function listAjax(){
		$data = Request::input();
		if(isset($data['new_order']) && is_array($data['new_order'])){
			$this->CategoryModel->updateCategoriesOrder($data['new_order']);
		}		
	}
	
	public function editCategory($category_id){
		$json = array();

		if(Request::isMethod('post') && $category_id)
		{
		
			$validator = Validator::make( Request::all(),[
					'title' => 'required',
				]
			);                
		
			if ($validator->fails()) {  
				$json['error'] = $validator->errors()->all(); 
			}
			else
			{
				$this->CategoryModel->editCategoriesOrder($category_id, Request::input());
				$json['success'] = 'Category has been updated successfully.';
			}   
		}
		
		echo json_encode($json);exit;
	}
	
	public function copyCategory($category_id){
		if($this->CategoryModel->copyCategory($category_id)){
			Session::put('category.success', 'Category copy successfully.');
		}
		else{
			Session::put('category.warning', 'Unable to copy category!');
		}
		return redirect('web88cms/categories/list');
	}
	
	public function deleteCategory($category_id){
		$this->CategoryModel->deleteCategory($category_id);
		Session::put('category.success', 'Category deleted successfully.');

		return redirect('web88cms/categories/list');
	}
	
	public function uploadMenuImage($category_id){
		$json = array();
		
		$fields['image'] = 'required|image|max:1000';
		
		if(isset($_FILES['image2']) && !$_FILES['image2']['error']){
			$fields['image2'] = 'image|max:1000';
		}
		
		$validator = Validator::make( Request::all(), $fields);                
	
		if ($validator->fails()) {  
			$json['error'] = $validator->errors()->all(); 
		}
		else
		{
			//Upload image
			$imageName1 = Request::file('image')->getClientOriginalName();
			$imageName1 = time(). str_replace(' ', '-', $imageName1);
			
			Request::file('image')->move(
				base_path() . '/public/images/category/', $imageName1
			);
			
			$imageName2 = '';
			
			if(isset($_FILES['image2']) && !$_FILES['image2']['error']){
				$imageName2 = Request::file('image2')->getClientOriginalName();
				$imageName2 = time(). str_replace(' ', '-', $imageName2);
				
				Request::file('image2')->move(
					base_path() . '/public/images/category/', $imageName2
				);
			}
			//End
			$data['image'] = $imageName1;
			$data['alt_text'] = Request::input('alt_text');
			$data['image2'] = $imageName2;
			$data['alt_text2'] = Request::input('alt_text2');
			
			$this->CategoryModel->updateCategoryImags($category_id, $data);
			$json['success'] = 'Category has been updated successfully.';
			$json['data'] = $data;
		}
		
		return Response::json($json);
	}
	
	public function homeList($limit = 10){
		$this->data['success'] = Session::get('category.success');
		Session::forget('category.success');
		$this->data['warning'] = Session::get('category.warning');
		Session::forget('category.warning');
		
		$page = 0;		
		if(Input::get('page')){
			$page = Input::get('page');
		}
		
		$this->data['paginate_msg'] = $this->CategoryModel->get_paginate_msg($limit, $page);
		
		$this->data['categories'] = $this->CategoryModel->getHomeCategories($limit);
		$this->data['categoryTabs'] = $this->CategoryModel->getHomeCategoryTabs();

		// get last updated
		$this->data['last_modified'] = DB::table('categories_home')->orderBy('modifydate','desc')->pluck('modifydate');
		$this->data['limit'] = $limit;
		$this->data['page_title'] = 'Home Cateogories:: Listing';
		
		return view('admin.category.home_category', $this->data);
	}
	/****************************************************************************************/
	/*home list category start here*/
	public function categoryhomelist()
	{
		$data['hometabslistviewdata'] = $this->CategoryModel->gettabhomelistviewdata();
		$data['catagroyhomelistviewdata'] = $this->CategoryModel->getcatagroyhomelistviewdata();
		return view('admin.category.category_home_list', $data);
    }
	public function categoryhomelistpostdata()
	{
		/*echo "<pre>";
		print_r($_POST);
		die;*/
		if(Request::isMethod('post'))
		{
			$validator = Validator::make(Request::all(),[
				'cat_title' => 'required',
			]);
			
			if ($validator->fails()) {  
				$json['error'] = $validator->errors()->all(); 
				echo json_encode($json);
				exit;
			}else{
			
				$this->CategoryModel->addcategoryhomelist(Request::input());
				
				echo json_encode(array('success' => 'success'));
				exit;
			}
		}
		return view('admin.category.category_home_list');
	}
	public function tablistinghomelistpostdata()
	{
		/*echo "<pre>";
		print_r($_POST);
		die;*/
		if(Request::isMethod('post'))
		{
			$validator = Validator::make(Request::all(),[
				'title' => 'required',
				'display_order' => 'required|unique:category_home_list_tablisting',
			]);
			
			if ($validator->fails()) {  
				$json['error'] = $validator->errors()->all(); 
				echo json_encode($json);
				exit;
			}else{
			
				$this->CategoryModel->addtablistingcategoryhomelist(Request::input());
				
				echo json_encode(array('success' => 'success'));
				exit;
			}
		}
		return view('admin.category.category_home_list');
	}
	function deletecategoryhomelistpostdata()
	{
		$formData=$_POST;
		
		/*echo "<pre>";
		print_r($formData);
		die;*/
		DB::table('category_home_list')->whereIn('id',explode(',',$formData['id']))->delete();
		DB::table('category_home_addtabproductsdata')->whereIn('homecatid',explode(',',$formData['id']))->delete();
		if($formData['enable_tab']==1){
		DB::select("delete  FROM `category_home_addtabproductsdata` WHERE tabid!='0' and homecatid='0' ");
		}
		return Redirect::to('/web88cms/categories/category_home_list/')->withFlashMessage('category list(s) has been deleted successfully..');
	}
	function editcategoryhomelistpostdata()
	{
		$post = $_POST;
		if(Request::isMethod('post'))
		
			$validator = Validator::make(Request::all(),[
			'cat_title' => 'required',
             ]);
			
			if ($validator->fails()) {  
				$json['error'] = $validator->errors()->all(); 
				echo json_encode($json);
				exit;
			}else{
		
		$results = DB::table('category_home_list')->where('id',$post['id'])->get();
		$data['status'] = (isset($post['status']) && $post['status'] == '1') ? '1' : '';	
		$data['cat_title'] = $post['cat_title'];	
			
			$data['modified'] = date('Y-m-d H:i:s');
			 DB::table('category_home_list')->where('id', $post['id'])->update($data);
			
			echo json_encode(array('success' => 'success'));
				exit;

			}
	}
	
	function deleteselectcategorydata()
	{
		
	/*	echo "<pre>";
		print_r($_POST);
		die;*/
		$post= $_POST;

		$id= $post['id'];
		DB::table('category_home_list')->whereIn('id',explode(',',$post['id']))->delete();
		DB::table('category_home_addtabproductsdata')->whereIn('homecatid',explode(',',$post['id']))->delete();
		 
		
		
	     return Redirect::to('web88cms/categories/category_home_list/')->withFlashMessage('category home list has been deleted successfully..');
	
	
	}
	function deleteAlltopmiddle()
	{
		
		DB::table('category_home_list')->delete();
		DB::table('category_home_addtabproductsdata')->delete();
				
		return Redirect::to('web88cms/categories/category_home_list/')->withFlashMessage('All category home list has been deleted successfully..');
	}
	function edittablisthomedata()
	{
		$post = $_POST;
		if(Request::isMethod('post'))
		
			$validator = Validator::make(Request::all(),[
			'title' => 'required',
			'display_order' => 'required|unique:banner_middle_bottom',
             ]);
			
			if ($validator->fails()) {  
				$json['error'] = $validator->errors()->all(); 
				echo json_encode($json);
				exit;
			}else{
		
		$results = DB::table('category_home_list_tablisting')->where('id',$post['id'])->get();
		$data['status'] = (isset($post['status']) && $post['status'] == '1') ? '1' : '';	
		$data['title'] = $post['title'];
		$data['display_order'] = $post['display_order'];	
			
			$data['modified'] = date('Y-m-d H:i:s');
			 DB::table('category_home_list_tablisting')->where('id', $post['id'])->update($data);
			
			echo json_encode(array('success' => 'success'));
				exit;

			}
	}
	
	function deletetabhomelistpostdata()
	{
		$formData=$_POST;
		DB::table('category_home_list_tablisting')->whereIn('id',explode(',',$formData['id']))->delete();
		return Redirect::to('/web88cms/categories/category_home_list/')->withFlashMessage('category list(s) has been deleted successfully..');
		
	}
	function deleteselecttabdata()
	{
		
		/*echo "<pre>";
		print_r($_POST);
		die;*/
		$post= $_POST;

		$id= $post['id'];
		DB::table('category_home_list_tablisting')->whereIn('id',explode(',',$post['id']))->delete();
		
		 
		
		
	     return Redirect::to('web88cms/categories/category_home_list/')->withFlashMessage('category home list has been deleted successfully..');
	
	
	}
	function deleteAlltabhomedata()
	{
		
		DB::table('category_home_list_tablisting')->delete();
				
		return Redirect::to('web88cms/categories/category_home_list/')->withFlashMessage('All category home list has been deleted successfully..');
	}

	
	/*update display order*/
	
	function update_display_order_all_tab_cat_home()
	{
		$postdata= $_POST;
		$data= array();
		
		if(Request::isMethod('post')){
			$flag = 'success';
		
			foreach($postdata['display_order'] as $key=>$value){
				//// Check display order already exist in db
				$results = DB::select('select id, display_order from category_home_list_tablisting where display_order= '.$value.' &&  id!='.$key);
	
				if(count($results)>0)
				{
					//// Check founded duplicate display order also change in current action yes/no
					if($value == $postdata['display_order'][$results[0]->id]){
						$flag = 'error';
						break;
					}
				}
			}
		}
		
	  
	  	if($flag == 'error')
		{
		    return Redirect::to('web88cms/categories/category_home_list/')->withInput()->with('error', 'Please fill unique display order Field..');
		}else{
			$data= array();
			foreach($postdata['display_order'] as $key=>$value){ 
				$data['display_order'] = $value;
				
				DB::table('category_home_list_tablisting')
				  ->where('id', $key)
				  ->update($data);
			}
			$detaildata['success'] = 'Tab list order has been updated successfully.';
			$detaildata['data'] = $data;
					
			return Redirect::to('web88cms/categories/category_home_list')->withFlashMessage('Tab display order has been changed successfully..');
		}
	}
/******************************************************************************************************/	
	
	
		
/*********************************************************************************************************/	
	
/*********************************************************************************************************/	
	
/*********************************************************************************************************/	
	
/*homeproduct list start from here*/
	
	public function categoryhomeproductslist()
	{// get last updated
	// response variable is set when item is deleted
	    $tabid=Request::get('tabid');
		 $homecatid=Request::get('homecatid');
		if((isset($_GET['rec'])&&$_GET['rec']!=''))
		{
			$this->data['num_rec_per_page'] = $num_rec_per_page = $_GET['rec'];
		}
		else
		{
		$this->data['num_rec_per_page'] = $num_rec_per_page = 10;
		}
		if (isset($_GET["page"])) { $page  = $_GET["page"]; } else { $page=1; }; 
        $start_from = ($page-1) * $num_rec_per_page; 
		$pagedata = DB::table('category_home_addtabproductsdata')->where('tabid',$tabid);
		$total_records = $pagedata->count();
		$this->data['total_pages'] = ceil($total_records / $num_rec_per_page); 
         $this->data['start_from']=$start_from  =(($page-1) * ($num_rec_per_page));
	     /*Showing 3 to 4 of 8 entries*/
		 if(Request::get('brand_id')||Request::get('product_name')||Request::get('product_code')||Request::get('price_from')||Request::get('price_to')||Request::get('category_id
		 '))
		 {
		   $formData=Input::get();
		  $this->data['listselectedproducts'] = $this->CategoryModel->search_list_selected_producted($start_from, $num_rec_per_page,$formData,$tabid,$homecatid);
		 }
		 else
		{  $this->data['listselectedproducts'] = $this->CategoryModel->list_selected_producted($start_from, $num_rec_per_page,$tabid,$homecatid);
		}
		 
      
		$page_to = (($page * $num_rec_per_page) > $total_records) ? $total_records : ($page * $num_rec_per_page);
		
		$this->data['msg'] = 'Showing '. ((($page-1) * $num_rec_per_page) + 1) .' to '. $page_to .' of '. $total_records .' entries';
		/*Showing 3 to 4 of 8 entries end*/
	
	     $this->data['products'] = $this->CategoryModel->getProductsforcategory_homeproduct();
		$this->data['success'] = Session::get('response');
		Session::forget('response');
		
		//$this->data['products'] = $this->CategoryModel->getProductsforcategory_homeproduct();
		
		$this->data['last_modified'] = DB::table('products')->orderBy('last_modified','desc')->pluck('last_modified');
		$this->data['categories'] = $this->CategoryModel->getSelectedCategoriesTree(array(Input::get('category_id')));	
		$this->data['brands'] = $this->BrandModel->getActiveBrands();
		return view('admin.category.category_home_products_list', $this->data);
    }
	
	function addtabproductsdata()
	{
		/*echo "<pre>";
		print_r($_POST);
		die;*/
		
		$postdata=$_POST;
		$productid=$postdata['productid'][0];
		$productsid = explode(",", $productid);
		$tabid=$postdata['tabid'];
		$homecatid=$postdata['homecatid'];
		
		$modified = date('Y-m-d H:i:s');
		$created = date('Y-m-d H:i:s');
		
		 DB::table('category_home_addtabproductsdata')->where('tabid',$tabid)->where('homecatid',$homecatid)->delete();
		foreach ($productsid as $product_id)
		{
			 $data["productid"]= $product_id;
			$data["modified"]= $modified;
			$data["created"]= $created;
			$data["tabid"]= $tabid;
			$data["homecatid"]= $homecatid;
			DB::table('category_home_addtabproductsdata')->insert($data);
			
		}
		echo json_encode(array('success' => 'success'));
				exit; 
				
		
		//return Redirect::to('web88cms/categories/category_home_products_list')->withInput()->with('success','Tab display order has been changed successfully..');
	}
	/*update display order*/
	function update_display_order_allategory_home_products_list()
	{
		
		/*echo "<pre>";
		print_r($_POST);
		die;*/ 
		
		$postdata= $_POST;
		$tabid=$postdata['tabid'];
		$homecatid=$postdata['homecatid'];
		$data= array();
		
		if(Request::isMethod('post')){
			$flag = 'success';
		
			foreach($postdata['myorder'] as $key=>$value){
				
				//// Check display order already exist in db
				$results = DB::select('select productid, display_order from category_home_addtabproductsdata where display_order= '.$value.'&&productid!='.$key. '&& tabid= '.$tabid. '&& homecatid= '.$homecatid);

	
				if(count($results)>0)
				{
					//// Check founded duplicate display order also change in current action yes/no
					if($value == $postdata['myorder'][$results[0]->productid]){
						$flag = 'error';
						break;
					}
				}
			}
		}
		
	  
	  	if($flag == 'error')
		{
		    return Redirect::to('web88cms/categories/category_home_products_list?tabid='.$tabid.'&homecatid='.$homecatid)->withInput()->with('error', 'Please fill unique display order Field..');
		}else{
			$data= array();
			foreach($postdata['myorder'] as $key=>$value){ 
				$data['display_order'] = $value;
				
				DB::table('category_home_addtabproductsdata')
				  ->where('productid', $key)
				  ->update($data);
			}
			$detaildata['success'] = 'category home product list order has been updated successfully.';
			$detaildata['data'] = $data;
					
			return Redirect::to('web88cms/categories/category_home_products_list/?tabid='.$tabid.'&homecatid='.$homecatid)->withFlashMessage('category home product list order has been changed successfully..');
		}
	}
	
	
	function deletechoosenhomeproductfrmlist()
	{
		$post= $_POST;

		$productid= $post['product_id'];
		$tabid=$post['tabid'];
		$homecatid=$post['homecatid'];
		 
		 DB::table('category_home_addtabproductsdata')->where('productid',$productid)->where('tabid',$tabid)->where('homecatid',$homecatid)->delete();
		
	     return Redirect::to('web88cms/categories/category_home_products_list/?tabid='.$tabid.'&homecatid='.$homecatid)->withFlashMessage('category home product has been deleted successfully..');
	
	
	}
	function deleteAllhomecatlist()
	{$tabid= Request::get('tabid');
	$homecatid= Request::get('homecatid');
			$formData= Request::input();
			
			/*echo "<pre>";
			print_r($formData);
			echo $tabid;
			die;*/
		
		$tabid= Request::get('tabid');
		$homecatid= Request::get('homecatid');
		
		DB::table('category_home_addtabproductsdata')->where('tabid',$tabid)->where('homecatid',$homecatid)->delete();
				
		return Redirect::to('web88cms/categories/category_home_products_list/?tabid='.$tabid.'&homecatid='.$homecatid)->withFlashMessage('All category home product  has been deleted successfully..');
	}
	
	
	function deleteselectedcatsdata()
	{
		if(Request::isMethod('post'))
		{
			$tabid= Request::get('tabid');
			$homecatid= Request::get('homecatid');
			$formData= Request::input();
			
			/*echo "<pre>";
			print_r($formData);
			echo $tabid;
			die;*/
			DB::table('category_home_addtabproductsdata')->where('tabid',$tabid)->where('homecatid',$homecatid)->whereIn('productid',explode(',',$formData['product_id']))->delete();
				
			return Redirect::to('web88cms/categories/category_home_products_list/?tabid='.$tabid.'&homecatid='.$homecatid)->withFlashMessage('All category home product(s) has been deleted successfully..');
		}
	}
	 
	
	
	
	 
	
}
