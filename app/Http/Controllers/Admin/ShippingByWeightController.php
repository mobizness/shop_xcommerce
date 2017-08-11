<?php namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Models\Admin\ShippingByWeight;
use App\Http\Models\Admin\Category;
use App\Http\Models\Countries;
use Session;
use Input;
use Illuminate\Http\RedirectResponse;
use Auth;
use Validator;
use Hash;
use DB;
use Redirect;
use Request;

class ShippingByWeightController extends Controller {
	private $data = array();
	private $ShippingByWeightModel = null;
	private $CategoryModel = null;

	public function __construct()
	{
		$this->middleware('auth');
		$this->ShippingByWeightModel = new ShippingByWeight();
		$this->CategoryModel = new Category();

	}

	function listShippingByWeight()
	{
		$this->data['success'] = Session::get('response');
		Session::forget('response');


		// get global discounts
		$this->data['shipping_total_weights'] = $this->ShippingByWeightModel->getShippingByWeight();

		// get pagination record status
	//	$this->data['pagination_report'] = $this->ShippingModel->getTotalProducts(Input::get('page'));

		// get category list
//		$this->data['categories'] = $this->CategoryModel->getCategoriesTree();
	    $CountriesModel = new Countries();
		$this->data['countries'] = $CountriesModel->getCountries();
		$this->data['states'] = $CountriesModel->getStates();
		// get last updated
		$this->data['last_modified'] = DB::table('shipping_total_weights')->orderBy('updated_at','desc')->pluck('updated_at');

		$this->data['page_title'] = 'By Total Weight of Products:: Listing';

		return view('admin.shippingbyweight.shipping_by_weight_list',$this->data);

	}

	function addShippingByWeight()
	{
		if(Request::isMethod('post'))
		{
			$validator = Validator::make(	Request::all(),[
												'title' => 'required',
												'from_weight' => '',
												'to_weight' => '',
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
				$this->ShippingByWeightModel->addShippingByWeight(Request::input());

				Session::put('response', 'Shipping By Total Weight added successfully.');

				echo json_encode(array('success' => 'success'));
			}
		}
	}

	function deleteShippingByWeight()
	{
		$brands = $this->ShippingByWeightModel->deleteShippingByWeight($_POST['id']);
		Session::put('response', 'Item(s) deleted successfully.');
	}


	function updateShippingByWeight()
	{
		if(Request::isMethod('post'))
		{
			$validator = Validator::make(	Request::all(),[
												'title' => 'required',
												'from_weight' => '',
												'to_weight' => '',
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
				$this->ShippingByWeightModel->updateShippingByWeight(Request::input());

				Session::put('response', 'Shipping By Total Weight updated successfully.');

				echo json_encode(array('success' => 'success'));
			}
		}
	}
}
