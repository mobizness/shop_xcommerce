<?php namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Models\Admin\ShippingByCategory;
use App\Http\Models\Admin\Category;
use Session;
use Input;
use Illuminate\Http\RedirectResponse;
use Auth;
use Validator;
use Hash;
use DB;
use Redirect;
use Request;

class ShippingByCategoryController extends Controller {
	private $data = array();
	private $ShippingByCategoryModel = null;
	private $CategoryModel = null;
		
	public function __construct()
	{
		$this->middleware('auth');
		$this->ShippingByCategoryModel = new ShippingByCategory();
		$this->CategoryModel = new Category();
		
	}

	function listShippingByCategory()
	{
		$this->data['success'] = Session::get('response');
		Session::forget('response');
		
		
		// get global discounts
		$this->data['product_categories'] = $this->ShippingByCategoryModel->getShippingByCategory();
		
		// get pagination record status
		$this->data['pagination_report'] = $this->ShippingByCategoryModel->getTotalProducts(Input::get('page'));
		
		// get category list
		$this->data['categories'] = $this->CategoryModel->getCategoriesTree();
		
		// get last updated
		$this->data['last_modified'] = DB::table('shipping_product_categories')->orderBy('updated_at','desc')->pluck('updated_at');
		
		$this->data['page_title'] = 'By Product Category :: Listing';
		
		return view('admin.shippingbycategory.shipping_by_category_list',$this->data);
		
	}
	
	function addShippingByCategory()
	{
		if(Request::isMethod('post'))
		{						
			$validator = Validator::make(	Request::all(),[
												'title' => 'required',
												'charge'	=> ''
											]											
										); 			        
	
		  if ($validator->fails()) {  
				$json['error'] = $validator->errors()->all(); 
				echo json_encode($json);
				exit;				
				
			}
			else
			{				
				$this->ShippingByCategoryModel->addShippingByCategory(Request::input());
				
				Session::put('response', 'By product category added successfully.');
				
				echo json_encode(array('success' => 'success'));
			}			
		}	
	}
	
	function deleteShippingByCategory()
	{		
		$brands = $this->ShippingByCategoryModel->deleteShippingByCategory($_POST['item_id']);
		Session::put('response', 'Item(s) deleted successfully.');	
	}
	
	
	function updateShippingByCategory()
	{
		if(Request::isMethod('post'))
		{						
			$validator = Validator::make(	Request::all(),[
												'title' => 'required',
												'charge'	=> ''
											]											
										); 			        
	
		  if ($validator->fails()) {  
				$json['error'] = $validator->errors()->all(); 
				echo json_encode($json);
				exit;				
				
			}
			else
			{				
				$this->ShippingByCategoryModel->updateShippingByCategory(Request::input());
				
				Session::put('response', 'By product category updated successfully.');
				
				echo json_encode(array('success' => 'success'));
			}			
		}	
	}
}