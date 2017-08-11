<?php namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Models\Admin\Shipping;
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

class ShippingController extends Controller {
	private $data = array();
	private $ShippingModel = null;
	private $CategoryModel = null;
		
	public function __construct()
	{
		$this->middleware('auth');
		$this->ShippingModel = new Shipping();
		$this->CategoryModel = new Category();
		
	}

	function listShippingOrderAmount()
	{
		$this->data['success'] = Session::get('response');
		Session::forget('response');
		
		
		// get global discounts
		$this->data['shipping_order_amounts'] = $this->ShippingModel->getShippingOrderAmount();
		
		// get pagination record status
	//	$this->data['pagination_report'] = $this->ShippingModel->getTotalProducts(Input::get('page'));
		
		// get category list
//		$this->data['categories'] = $this->CategoryModel->getCategoriesTree();
		
		// get last updated
		$this->data['last_modified'] = DB::table('shipping_order_amounts')->orderBy('updated_at','desc')->pluck('updated_at');
		
		$this->data['page_title'] = 'Shipping Order Amount:: Listing';
		
		return view('admin.shipping.shipping_by_total_amount_list',$this->data);
		
	}
	
	function addShippingOrderAmount()
	{
		if(Request::isMethod('post'))
		{						
			$validator = Validator::make(	Request::all(),[
												'title' => 'required',
												'from_amount' => '',
												'to_amount' => '',
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
				$this->ShippingModel->addShippingOrderAmount(Request::input());

				Session::put('response', 'Shipping order amount added successfully.');

				echo json_encode(array('success' => 'success'));
			}			
		}	
	}
	
	function deleteShippingOrderAmount()
	{		
		$brands = $this->ShippingModel->deleteShippingOrderAmount($_POST['id']);
		Session::put('response', 'Item(s) deleted successfully.');	
	}
	
	
	function updateShippingOrderAmount()
	{
		if(Request::isMethod('post'))
		{						
			$validator = Validator::make(	Request::all(),[
												'title' => 'required',
												'from_amount' => 'required',
												'to_amount' => 'required',
												'charge'	=> 'required'
											]											
										); 			        
	
		  if ($validator->fails()) {  
				$json['error'] = $validator->errors()->all(); 
				echo json_encode($json);
				exit;				
				
			}
			else
			{				
				$this->ShippingModel->updateShippingOrderAmount(Request::input());
				
				Session::put('response', 'Shipping order amount updated successfully.');
				
				echo json_encode(array('success' => 'success'));
			}			
		}	
	}
}