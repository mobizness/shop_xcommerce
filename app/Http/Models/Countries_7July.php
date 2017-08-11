<?php
namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use DB;
use Hash;

class Countries extends Model{

	public function getCountry($country_id)
	{
		return DB::table('countries')->where('country_id', '=', $country_id)->first();
	}
	
	public function getCountries()
	{
		return DB::table('countries')->orderBy('name', 'ASC')->get();
	}
	
	public function getStatesByCountry($country_id){
		return DB::table('states')->where('country_id', '=', $country_id)->orderBy('name', 'ASC')->get();
	}
	
	public function getStates(){
		return DB::table('states')->orderBy('name', 'ASC')->get();
	}
}