<?php namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Models\Admin\ShippingByCsv;
use App\Http\Models\Admin\Category;
use App\Http\Models\Countries;
use Session;
use Input;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\File;
use League\Csv\Reader;
use Auth;
use Validator;
use Hash;
use DB;
use Redirect;
use Request;


class ShippingByCsvController extends Controller {
	private $data = array();
	private $ShippingByCsvModel = null;
	private $CategoryModel = null;

	public function __construct()
	{
		$this->middleware('auth');
		$this->ShippingByCsvModel = new ShippingByCsv();
		$this->CategoryModel = new Category();

	}

	function listShippingByCsv()
	{
		$this->data['success'] = Session::get('response');
		Session::forget('response');


		// get global discounts
		$this->data['shipping_by_csv'] = $this->ShippingByCsvModel->getShippingByCsv();

		// get pagination record status
	//	$this->data['pagination_report'] = $this->ShippingModel->getTotalProducts(Input::get('page'));

		// get category list
//		$this->data['categories'] = $this->CategoryModel->getCategoriesTree();

		// get last updated
		$this->data['last_modified'] = DB::table('shipping_order_amounts')->orderBy('updated_at','desc')->pluck('updated_at');

		$this->data['page_title'] = 'Shipping By CSV:: Listing';

		return view('admin.shippingbycsv.shipping_csv_import_list',$this->data);

	}

	function addShippingByCsv()
	{

		if(Request::isMethod('post'))
		{
			//echo "<BR>==dd=>".$file = Input::file('file');
			//echo "<BR>==2222=>".$name = time() . '-' . $file->getClientOriginalName();

			//echo "3333==>".$file = Input::file('csv_files');
			echo "<BR>path==<>".$filename = base_path().'\test.csv';

		/*	$file = new \SplFileObject($filename);
			//$reader = new CsvReader($file);
			$reader = new CsvReader($file, ';');
			$reader->setStrict(false);

			print_r($reader); */


			$csv = Reader::createFromPath($filename);
			//$headers = $csv->fetchOne();
			echo "<BR>==>".$provider = $csv->fetchOne(2)[0]; 
//			$providerId = //Insert provider fetched about if does not exist/ get id if exists - table: shipment_providers
			
			$country = $csv->fetchOne(4)[2];
			$countryId = DB::table('countries')->select('country_id')->where('name', '=', $country)->get();  // Return array
			// $countryId = //find country id from db, this will required to insert in shipment_area table:

		/* 	$regions = $csv->fetchOne(5);
			$regindIdMap = //a map which contains db regin id and column number map

			foreach($region as $regions)
			{
				//uper fetch kareli countryId ane providerId thi shipment_area ma enty karvani, jo hoy to khali id fetch karvani
				// db ma thi fetch kareli reginId $regindIdMap map ma columnId sathe store karvani
				// eg. 2nd column ma "Peninsular Malaysia" hoy ane db ma eni id 5 hoy to value [2, 5]
			}

			$weights =  $csv->setOffset(6)->fetchAll();

			foreach ($weight as $weights) {
				$weightFrom = $weight[0];
				$weightTo = $weight[1];

				$shipment_weights_id = //get id from db

				for ($i = 2; $i <= $weight.length; $i++) {
						$charges = $weight[$i];
						$reginId = $regindIdMap[$i];


				    //insert into
				}
				 // Insert weights, get id

			} */

			print_r($res);

			//echo "5555==>".$extension = $file->getClientOriginalExtension();

			exit;


			$validator = Validator::make(	Request::all(),[
												'title' => 'required'
											]
										);



		  if ($validator->fails()) {
				$json['error'] = $validator->errors()->all();
				echo json_encode($json);
				exit;

			}
			else
			{
				$this->ShippingByCsvModel->addShippingByCsv(Request::input());

				Session::put('response', 'Shipping by csv added successfully.');

				echo json_encode(array('success' => 'success'));
			}
		}
	}

	function deleteShippingByCsv()
	{
		$brands = $this->ShippingByCsvModel->deleteShippingByCsv($_POST['id']);
		Session::put('response', 'Item(s) deleted successfully.');
	}


	function updateShippingByCsv()
	{
		if(Request::isMethod('post'))
		{
			$validator = Validator::make(	Request::all(),[
												'title' => 'required'
											]
										);

		  if ($validator->fails()) {
				$json['error'] = $validator->errors()->all();
				echo json_encode($json);
				exit;

			}
			else
			{
				$this->ShippingByCsvModel->updateShippingByCsv(Request::input());

				Session::put('response', 'Shipping by csv updated successfully.');

				echo json_encode(array('success' => 'success'));
			}
		}
	}
}
