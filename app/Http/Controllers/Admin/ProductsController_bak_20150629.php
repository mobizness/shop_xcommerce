<?php namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Models\Admin\Product;
use App\Http\Models\Admin\Category;
use App\Http\Models\Admin\Brand;
use App\Http\Models\Admin\Color;
use Session;
use Input;
use Illuminate\Http\RedirectResponse;
use Auth;
use Validator;
use Hash;
use DB;
use Redirect;
use Request;

class ProductsController extends Controller {
	private $data = array();
	private $ProductModel = null;
	private $CategoryModel = null;
	private $Brand = null;
	private $Color = null;
	
	
	
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
		$this->ProductModel = new Product();
		$this->CategoryModel = new Category();
		$this->BrandModel = new Brand();
		$this->ColorModel = new Color();
	}

	function index()
	{
		return redirect('web88cms/dashboard');
	}
	
		
	function addProduct()
	{
		if(Request::isMethod('post'))
		{			
			$messages = [
					//'required' => 'The :attribute field is required.',
					'max' => 'Max file size should be less than 2MB.',
				];
										
			$validator = Validator::make(	Request::all(),[
												'product_name' => 'required',
												'product_code' => 'required',
												'categories' => 'required',
												'sale_price' => 'required',
												'large_image' => 'required|image|max:2000'
											],
											$messages
										); 			        
	
		  if ($validator->fails()) {  
				$json['error'] = $validator->errors()->all(); 
				//echo json_encode($json);
				//return Redirect::back()->withErrors($validator);
				return Redirect::back()->withInput()->withErrors($validator);
				exit;				
				
			}
			else
			{
				
				$imageName = null;
				$custom_data = array();
				if(isset($_FILES['large_image']['name']) && $_FILES['large_image']['name']!='')
				{
					
					$imageName = time().'_'.$_FILES['large_image']['name'];
					Request::file('large_image')->move(
						base_path() . '/public/admin/products/large/', $imageName
					);
					
					$custom_data['large_image'] = $imageName;
				}
				
				if(isset($_FILES['thumbnail_image_1']['name']) && $_FILES['thumbnail_image_1']['name']!='')
				{
					
					$thumbnail_image_1 = time().'_'.$_FILES['thumbnail_image_1']['name'];
					Request::file('thumbnail_image_1')->move(
						base_path() . '/public/admin/products/medium/', $thumbnail_image_1
					);
					
					$custom_data['thumbnail_image_1'] = $thumbnail_image_1;
				}
				
				if(isset($_FILES['thumbnail_image_2']['name']) && $_FILES['thumbnail_image_2']['name']!='')
				{
					
					$thumbnail_image_2 = time().'_'.$_FILES['thumbnail_image_2']['name'];
					Request::file('thumbnail_image_2')->move(
						base_path() . '/public/admin/products/medium/', $thumbnail_image_2
					);
					
					$custom_data['thumbnail_image_2'] = $thumbnail_image_2;
				}
				
				// add/update custom values to request input array
				$custom_data['status'] = (Request::input('status') == 'on') ? '1' : '0';
				$custom_data['is_tax'] = (Request::input('is_tax') == 'on') ? '1' : '0';
				$custom_data['is_available'] = (Request::input('is_available') == 'on') ? '1' : '0';
				$custom_data['in_physical_store_only'] = (Request::input('in_physical_store_only') == 'on') ? '1' : '0';
				$custom_data['display_order'] = (Request::input('display_order') != 0) ? Request::input('display_order') : '0';
				
				
				$custom_data['promo_behaviour'] = (Request::input('promo_behaviour')) ? implode(',',Request::input('promo_behaviour')) : '';
								
				if(sizeof($custom_data) > 0)
					Request::merge($custom_data);
	
				//dd(Request::input());
				
				$product_id = $this->ProductModel->addProduct(Request::input());
				
				$this->data['success'] = 'Product added successfully.';
				
				return redirect('/web88cms/products/editProduct/'.$product_id)->with('data', $this->data);
				
				//Redirect::back()->with('data', $this->data);
			}			
		}
		
		// get categories		
		if(Request::old('categories'))
			$this->data['categories'] = $this->CategoryModel->getSelectedCategoriesTree(Request::old('categories'));
		else
			$this->data['categories'] = $this->CategoryModel->getCategoriesTree();	
		
		// get active brands
		$this->data['brands'] = $this->BrandModel->getActiveBrands();
		
		// get active colors
		$this->data['colors'] = $this->ColorModel->getActiveColors();
		
		// set page title
		$this->data['page_title'] = 'Add Product';
		
		return view('admin.products.add_products',$this->data);	
	}
	
	function editProduct($product_id)
	{
		$this->data['success_response'] = Session::get('response');
		Session::forget('response');
		
		if(Request::isMethod('post'))
		{			
			$messages = [
					//'required' => 'The :attribute field is required.',
					'max' => 'Max file size should be less than 2MB.',
				];
										
			$validator = Validator::make(	Request::all(),[
												'product_name' => 'required',
												'product_code' => 'required',
												'categories' => 'required',
												'sale_price' => 'required',
												//'large_image' => 'required|image|max:2000'
											],
											$messages
										); 			        
	
		  if ($validator->fails()) {  
				$json['error'] = $validator->errors()->all(); 
				//echo json_encode($json);
				return Redirect::back()->withErrors($validator);
				exit;				
				
			}
			else
			{
				
				$imageName = null;
				$custom_data = array();
				if(isset($_FILES['large_image']['name']) && $_FILES['large_image']['name']!='')
				{
					
					$imageName = time().'_'.$_FILES['large_image']['name'];
					Request::file('large_image')->move(
						base_path() . '/public/admin/products/large/', $imageName
					);
					
					$custom_data['large_image'] = $imageName;
				}
				
				if(isset($_FILES['thumbnail_image_1']['name']) && $_FILES['thumbnail_image_1']['name']!='')
				{
					
					$thumbnail_image_1 = time().'_'.$_FILES['thumbnail_image_1']['name'];
					Request::file('thumbnail_image_1')->move(
						base_path() . '/public/admin/products/medium/', $thumbnail_image_1
					);
					
					$custom_data['thumbnail_image_1'] = $thumbnail_image_1;
				}
				
				if(isset($_FILES['thumbnail_image_2']['name']) && $_FILES['thumbnail_image_2']['name']!='')
				{
					
					$thumbnail_image_2 = time().'_'.$_FILES['thumbnail_image_2']['name'];
					Request::file('thumbnail_image_2')->move(
						base_path() . '/public/admin/products/medium/', $thumbnail_image_2
					);
					
					$custom_data['thumbnail_image_2'] = $thumbnail_image_2;
				}
				
				// add/update custom values to request input array
				$custom_data['status'] = (Request::input('status') == 'on') ? '1' : '0';
				$custom_data['is_tax'] = (Request::input('is_tax') == 'on') ? '1' : '0';
				$custom_data['is_available'] = (Request::input('is_available') == 'on') ? '1' : '0';
				$custom_data['in_physical_store_only'] = (Request::input('in_physical_store_only') == 'on') ? '1' : '0';
				$custom_data['display_order'] = (Request::input('display_order') != 0) ? Request::input('display_order') : '0';
				
				
				
				
				$custom_data['promo_behaviour'] = (Request::input('promo_behaviour')) ? implode(',',Request::input('promo_behaviour')) : '';
								
				if(sizeof($custom_data) > 0)
					Request::merge($custom_data);
	
				//dd(Request::input());
				
				$this->ProductModel->updateProduct(Request::input(),$product_id);
				
				$this->data['success'] = 'Changes saved successfully.';
				
				Redirect::back()->with('data', $this->data);
			} // end else		
		} // end if(Request::isMethod('post'))
		
		// get product details
		$this->data['details'] = $this->ProductModel->getProductDetails($product_id);
		
		// get categories		
		//$this->data['categories'] = $this->CategoryModel->getCategoriesTree();
		
		$productCategoryList = array();
		if(sizeof($this->data['details']['productCategories']) > 0)
		{
			foreach($this->data['details']['productCategories'] as $productCategories)
			{
				array_push($productCategoryList,$productCategories->category_id);
			}	
		}
		
		$this->data['categories'] = $this->CategoryModel->getSelectedCategoriesTree($productCategoryList);
		
		// get active brands
		$this->data['brands'] = $this->BrandModel->getActiveBrands();
		
		// get active colors
		$this->data['colors'] = $this->ColorModel->getActiveColors();
		
		// get product images
		$this->data['additional_images'] = $this->ProductModel->getProductImages($product_id);
		
		// get quantity discounts
		$this->data['quantity_discounts'] = $this->ProductModel->getQuantityDiscounts($product_id);
		
		// get pagination record status
		$this->data['pagination_report'] = $this->ProductModel->getTotalQuantityDiscounts(Input::get('page'),$product_id);
		
		
		// set page title
		$this->data['page_title'] = 'Edit Product';
		
		return view('admin.products.edit_products',$this->data);		
		
	}
	
	function deleteImage($type,$product_id)
	{		
		DB::table('products')->where('id',$product_id)->update(array($type => ''));
		
		$this->data['success'] = 'Image removed successfully.';
				
		//redirect('/web88cms/products/editProduct/'.$product_id)->with('data', $this->data);
		//Redirect::back('/web88cms/products/editProduct/'.$product_id)->with('data', $this->data);
		return redirect('/web88cms/products/editProduct/'.$product_id)->with('data', $this->data);
	}
	
	function updateShippingInfo($product_id)
	{	
		$this->data	= '';
		if(Request::ismethod('post'))
		{
			$formData = Request::input();
			
			unset($formData['_token']);
			
			$formData['last_modified'] = date('Y-m-d H:i:s');
			
			DB::table('products')->where('id',$product_id)->update($formData);
			
			$this->data['success'] = 'Changes saved successfully.';
		}
		
		return redirect('/web88cms/products/editProduct/'.$product_id)->with('data', $this->data);
	}
	
	function listProducts()
	{
		// response variable is set when item is deleted
		$this->data['success'] = Session::get('response');
		Session::forget('response');
		
		if(Request::get('brand_id'))
		{
			//Session::put('product.per_page',1);
			$this->data['products'] = $this->ProductModel->searchProducts(Input::get());
			
			// get pagination record status
			$this->data['pagination_report'] = $this->ProductModel->getTotalSearchResults(Input::get());
		}
		else
		{
			//Session::put('product.per_page',2);
			// get products
			$this->data['products'] = $this->ProductModel->getProducts();
			
			// get pagination record status
			$this->data['pagination_report'] = $this->ProductModel->getTotalProducts(Input::get('page'));
		}
		
		// get categories		
		//$this->data['categories'] = $this->CategoryModel->getCategoriesTree();
		//$productCategoryList = (Input::get('category_id') != 'all') ? array(Input::get('category_id')) : '';
		$this->data['categories'] = $this->CategoryModel->getSelectedCategoriesTree(array(Input::get('category_id')));	
		
		// get active brands
		$this->data['brands'] = $this->BrandModel->getActiveBrands();
		
		// get last updated
		$this->data['last_modified'] = DB::table('products')->orderBy('last_modified','desc')->pluck('last_modified');
		
		// set page title
		$this->data['page_title'] = 'List Products';
		
		return view('admin.products.list_products', $this->data);	
	}
	
	function setPerPage($per_page,$session_key,$redirect_to,$query_string=null)
	{
		Session::put($session_key.'.per_page',$per_page);
		if($query_string && $query_string !='no_qs')
		{
			$redirect_to .= '?'.$query_string;
		}
		//echo str_replace('~','/',$redirect_to); exit;
		return redirect(str_replace('~','/',$redirect_to));
	}
	
	
	function updateDescription($product_id)
	{		
		DB::table('products')->where('id',$product_id)->update(array('description' => Request::input('content'), 'last_modified' => date('Y-m-d H:i:s') ));		
	}
	
	function updateFeaturedVideo($product_id)
	{
		DB::table('products')->where('id',$product_id)->update(array('features_and_video' => Request::input('content'), 'last_modified' => date('Y-m-d H:i:s') ));
		//echo Request::input('content');
	}
	
	function updateWarrantyAndSupport($product_id)
	{
		DB::table('products')->where('id',$product_id)->update(array('warranty_and_support' => Request::input('content'), 'last_modified' => date('Y-m-d H:i:s') ));
	}
	
	function updateReturnPolicy($product_id)
	{
		DB::table('products')->where('id',$product_id)->update(array('return_policy' => Request::input('content'), 'last_modified' => date('Y-m-d H:i:s') ));
	}
	
	function addImages1($product_id)
	{
		//dd($_FILES);
		
		$files = Input::file('large_image');
		
		$file_uploaded = array();
		if(sizeof($_FILES['large_image']['name']) > 0)
		{
			for($i = 0; $i< sizeof($_FILES['large_image']['name']); $i++)
			{	
				if($_FILES['large_image']['name'][$i] != '' && $_FILES['large_image']['error'][$i] == 0)
				{					
					$imageName = time().'_'.$_FILES['large_image']['name'][$i];
					
					
					
					$files->move(
						base_path() . '/public/admin/products/large/', $imageName
					);
					
					/*Request::file('large_image')->move(
						base_path() . '/public/admin/products/large/', $imageName
					);*/
					
					array_push($file_uploaded,$imageName);
				}	
			}
		}
		
		if(sizeof($file_uploaded) == 0)
		{
			$this->data['success'] = 'Please select valid image.';
				
			return redirect('/web88cms/products/editProduct/'.$product_id)->with('data', $this->data);	
		}
		
		
	}
	
	// reference link : http://tutsnare.com/upload-multiple-files-in-laravel/
	public function addImages($product_id) {
		// getting all of the post data
		$files = Input::file('large_image');
		// Making counting of uploaded images
		$file_count = count($files);
		// start count how many uploaded
		$uploadcount = 0;		
		
		foreach($files as $file) {
		
			$destinationPath = base_path() . '/public/admin/products/large/';	
			if($file)
			{
				$filename = time().'_'.$file->getClientOriginalName();
				$upload_success = $file->move($destinationPath, $filename);
				$uploadcount ++;
				
				DB::table('product_to_images')->insert(array('product_id' => $product_id, 'file_name' => $filename));
			}
		}
		
		if($uploadcount == 0)
		{
			$this->data['error'] = 'Please select valid image.';
		 	return redirect('/web88cms/products/editProduct/'.$product_id)->with('data', $this->data);
		}
		else
		{
		 $this->data['success'] = 'Image(s) saved successfully.';
		 return redirect('/web88cms/products/editProduct/'.$product_id)->with('data', $this->data);
		} 		
	
	}
	
	function deleteAdditionalImage($image_id,$product_id)
	{		
		DB::table('product_to_images')->where('id',$image_id)->delete();
		
		$this->data['success'] = 'Image removed successfully.';
				
		//redirect('/web88cms/products/editProduct/'.$product_id)->with('data', $this->data);
		//Redirect::back('/web88cms/products/editProduct/'.$product_id)->with('data', $this->data);
		return redirect('/web88cms/products/editProduct/'.$product_id)->with('data', $this->data);
	}
	
	function deleteProducts()
	{
		$brands = $this->ProductModel->deleteProducts($_POST['item_id']);
		Session::put('response', 'Item(s) deleted successfully.');	
	}
	
	function categoryProducts()
	{
		$category_id = Request::Input('category_id');
		
		$result = DB::table('products as p')->select('p.*','c.display_order')->leftJoin('product_to_category as c','p.id','=','c.product_id')->where('p.status','1')->where('c.category_id',$category_id)->groupBY('p.id')->get();
		
		if(count($result) > 0)
			echo json_encode(array('products' => $result));
	}
	
	function addQuantityDiscount()
	{
		$formData = Input::get();
		
		if($formData['from_quantity'] != '' && $formData['to_quantity'] != '')
		{
			unset($formData['_token']);
			
			$formData['status'] = (isset($formData['status'])) ? '1' : '0';
			
			DB::table('product_to_quantity_discount')->insert($formData);
			
			$this->data['success'] = 'Quantity discount added successfully.';
				
			return Redirect::back()->with('data', $this->data);
		}
		
		return Redirect::back();
	}
	
	function updateQuantityDiscount()
	{
		$formData = Input::get();
		
		if($formData['from_quantity'] != '' && $formData['to_quantity'] != '')
		{
			unset($formData['_token']);
			
			$discount_id = $formData['discount_id'];
			unset($formData['discount_id']);
			
			$formData['status'] = (isset($formData['status'])) ? '1' : '0';
			
			DB::table('product_to_quantity_discount')->where('id',$discount_id)->update($formData);
			
			$this->data['success'] = 'Quantity discount updated successfully.';
				
			return Redirect::back()->with('data', $this->data);
		}
		
		return Redirect::back();	
	}
	
	function deleteQuantityDiscount()
	{
		$this->ProductModel->deleteQuantityDiscount($_POST['item_id']);
		Session::put('response', 'Item(s) deleted successfully.');
	}
	
	
	/*function listCategories()
	{
		//$categories = DB::table('categories')->get();
		$category = new Category();
		echo '<pre>';// print_r($category->getCategories());
		print_r($category->getCategoriesTree());
			exit;
	}*/
	
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

}
