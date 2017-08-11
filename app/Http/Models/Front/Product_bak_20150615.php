<?php
namespace App\Http\Models\Front; // where this file exists

use Illuminate\Database\Eloquent\Model;
use DB; // used for queries like DB::table('table_name')->get();
use App\Http\Library\Image_lib;

class Product extends Model{

	public $timestamps = false;

	/**
	 * get all active sub category childs by category id
	*/
	function getSubCategories($category_id = array(),$arr_categories = array())
	{
		$results = DB::table('categories')->where('status','1')->whereIN('parent_id', $category_id)->lists('id');	
		
		if(sizeof($results) > 0)
		{		
			array_push($arr_categories,$results);			
			
			return $this->getSubCategories($results,$arr_categories);
		}
		
		$subCategories = array();
		foreach($arr_categories as $resultSet)
		{
			foreach($resultSet as $item)
			{
				array_push($subCategories,$item);
			}
		}
		return $subCategories;
	}
	
	
	/* get products by category id*/
	/*function getProductsByCategory($category_id)
	{
		//SELECT p.id,p.product_name FROM products p left join `product_to_category` c ON p.id=c.product_id where c.category_id IN (10,11,13,14,15) group by p.id
		$categoryList = $this->getSubCategories(array($category_id));
	
		array_push($categoryList,(int)$category_id);
		
		$results = DB::table('products as p')->select('p.*','c.display_order')->leftJoin('product_to_category as c','p.id','=','c.product_id')->where('p.status','1')->whereIN('c.category_id',$categoryList)->orderBy('c.display_order','asc')->groupBY('p.id')->get();		
	
		return $results;
	}*/
	
	function getProductsByCategory($category_id, $sort = 'new')
	{
		//SELECT p.id,p.product_name FROM products p left join `product_to_category` c ON p.id=c.product_id where c.category_id IN (10,11,13,14,15) group by p.id
		$categoryList = $this->getSubCategories(array($category_id));
	
		array_push($categoryList,(int)$category_id);
		
		$query = DB::table('products as p')->select('p.*','c.display_order')->leftJoin('product_to_category as c','p.id','=','c.product_id')->where('p.status','1')->whereIN('c.category_id',$categoryList);
	
		if($sort == 'priceAsc'){
			$query = $query->orderBy('p.list_price', 'ASC');
		}else if($sort == 'priceDesc'){
			$query = $query->orderBy('p.list_price', 'DESC');
		}else if($sort == 'a-z'){
			$query = $query->orderBy('p.product_name', 'ASC');
		}else if($sort == 'z-a'){
			$query = $query->orderBy('p.product_name', 'DESC');
		}else if($sort == 'date'){
			$query = $query->orderBy('p.last_modified', 'DESC');
		}else if($sort == 'brand'){
			$query = $query->orderBy('p.brand_id', 'ASC');
		}else{
			$query = $query->orderBy('p.id', 'DESC');
		}
	
		$results = $query->orderBy('c.display_order','asc')->groupBY('p.id')->get();
		return $results;		
	}
	
	/* get product banners */
	function getProductBanners($category_id = 0)
	{
		$banners = array();
		$results = DB::table('product_banner_list')->where('category', $category_id)->get();
		
		foreach($results as $result){
				$banners[] = array(
					'title'			=> $result->title,
					'banner'		=> $result->banner,
				);
		}				
		return $banners;	
	}
	
	// get active filters
	function getFilters()
	{
		return DB::table('filters')->where('status','1')->get();
	}
	
	
	/** 
	 * get brands list with total products in specific category 
	 * also count product for sub categories	
	 */	 
	function getBrandFilter($category_id)
	{
		//SELECT b.title as brand_name,count(p.id) as total_products FROM products p left join brands b ON b.id=p.brand_id where p.id IN (select product_id from product_to_category c where c.category_id IN (10,11,13,14,15) group by product_id) AND brand_id <>0 group by b.id
		$categoryList = $this->getSubCategories(array($category_id));
	
		array_push($categoryList,(int)$category_id);
		
		$results = DB::table('products as p')->select('p.brand_id','b.title as brand_name',DB::raw('count(p.id) as total_products'))->leftJoin('brands as b','p.brand_id','=','b.id')->where('p.status','1')->where('p.brand_id','<>',0)->whereIN('p.id',function($query) use ($categoryList){
										$query->select('c.product_id')
										->from('product_to_category as c')
										->whereIN('c.category_id', $categoryList);									
									})->groupBY('b.id')->get();	
		//echo '<pre>'; print_r($results); echo '</pre>'; exit;
		return $results;		
	}
	
	/** 
	 * get color list in specific category 
	 * also get colors for products listed in sub categories	
	 */	 
	function getColorFilter($category_id)
	{
		//SELECT c.id as color_id,c.hex_code FROM `colors` c left join product_to_color pc ON pc.color_id=c.id where c.status='1' AND pc.product_id IN (select product_id from product_to_category c where c.category_id IN (10,11,13,14,15) group by product_id)
		$categoryList = $this->getSubCategories(array($category_id));
	
		array_push($categoryList,(int)$category_id);
		
		$results = DB::table('colors as c')->select('c.id as color_id','c.hex_code')->leftJoin('product_to_color as pc','pc.color_id','=','c.id')->where('c.status','1')->whereIN('pc.product_id',function($query) use ($categoryList){
										$query->select('c.product_id')
										->from('product_to_category as c')
										->whereIN('c.category_id', $categoryList);									
									})->get();	
		return $results;		
	}
	
	// get nested sub categories
	function getSubCategoriesNested($parent_id = 0)
	{
		$categories = array();
		$results = DB::table('categories')->select('*', 'id as category_id')->where('parent_id', '=', $parent_id)->orderBy('order_no', 'ASC')->get();
		
		foreach($results as $result){
			$categories[] = array(
				'category_id'			=> $result->category_id,
				'title'					=> $result->title,
				'total_products'		=> $this->getTotalProducts($result->category_id),
				//'iconKeyword'			=> $result->iconKeyword,
				//'image'				=> $result->image,
				//'parent_id'			=> $result->parent_id,
				//'order_no'			=> $result->order_no,
				'sub_categories'		=> $this->getSubCategoriesNested($result->category_id),
			);
		}
				
		return $categories;	
	}
	
	// get total products in category and it's subcategories
	function getTotalProducts($category_id = 0)
	{
		//select count(id) as total_products,category_id from product_to_category where category_id IN (10,11,13,14,15)
		
		// get subcategories
		$categoryList = $this->getSubCategories(array($category_id));
	
		array_push($categoryList,(int)$category_id);		
		
		$results = DB::table('product_to_category as pc')->select(DB::raw('count(pc.id) as total_products'))->leftjoin('products as p','p.id', '=','pc.product_id' )->where('p.status','<>',0)->whereIN('category_id', $categoryList)->pluck('total_products');
				
		return $results;	
	}
	
	/*------- Added by Tirthraj --------------- */
	public function getProduct($product_id)
	{
		$product = DB::table('products as p');
		$product->select('p.*', 'b.title as brand_name');
		$product->leftJoin('brands as b', 'p.brand_id', '=', 'b.id');
		$product->where('p.id', $product_id);
		$product->where('p.status', '1');
		
		return $product->first();
	}
	
	public function getProductImages($product_id)
	{
		$images = DB::table('product_to_images')->where('product_id', $product_id)->get();
		
		foreach($images as $key => $image){
			$images[$key]->file_name = $this->resizeProductImage($image->file_name);
		}
		
		return $images;
	}
	
	public function resizeProductImage($file_name){
		if(file_exists(public_path() . '/admin/products/large/' . $file_name)){
			$Image_lib = new Image_lib();
			
			if(!file_exists(public_path() . '/admin/products/medium/' . $file_name)){
				//Resize
				$config['image_library'] = 'gd2';		
				$config['source_image'] = public_path() . '/admin/products/large/' . $file_name;
				$config['create_thumb'] = false;
				$config['maintain_ratio'] = TRUE;
				
				// generate thumbnail
				$config['new_image'] = public_path() . '/admin/products/medium/' . $file_name;
				$config['width'] = 200;
				$config['height'] = 200;
				
				$Image_lib->initialize_img($config);	
				if ( ! $Image_lib->resize())
				{
					//echo $this->Image->display_errors();
				}
			}
			
			if(!file_exists(public_path() . '/admin/products/small/' . $file_name)){
				
			}
			
			return $file_name;
		}
		else{
			return false;
		}
	}
	
	public function getBreadcrumbCategory($category_id)
	{
		return DB::table('categories')->select('id', 'title')->where('id', $category_id)->where('status', '1')->first();
	}
	
	public function getProductColors($product_id)
	{
		$product = DB::table('product_to_color as ptc');
		$product->select('ptc.*', 'c.title as color_name', 'c.hex_code');
		$product->leftJoin('colors as c', 'ptc.color_id', '=', 'c.id');
		$product->where('ptc.product_id', $product_id);
		$product->where('c.status', '1');
		//echo '<pre>';print_r($product->get());exit;
		return $product->get();
	}
	
}