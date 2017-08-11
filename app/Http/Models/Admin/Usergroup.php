<?php
namespace App\Http\Models\Admin; // where this file exists

use Illuminate\Database\Eloquent\Model;
use DB; // used for queries like DB::table('table_name')->get();
class Usergroup extends Model{

	/**
	 * Fetch User Groups From DB Table
	 */
	function getUsergroups($item, $page)
	{
		if($page>1){
			$startLimit = ($page-1)*$item;
		}else{
			$startLimit = 0;	
		}
		
		$results = DB::table('usergroups')->orderBy('id','desc')->offset($startLimit)->take($item)->get();		
		return $results;
	}
	
	
	/**
	 * Get Last Update Record From DB Table
	 */
	function getLastUpdated()
	{
		$results = DB::table('usergroups')->select('updated_at')->orderBy('updated_at','desc')->first();
		return $results->updated_at;
	}
	
	
	/**
	 * Insert User Group to DB Table
	 */
	function addUsergroup($formData)
	{
		$results = DB::table('usergroups')->where('groupName',$formData['usergroupName'])->get();

		if(count($results)!=0){
			$json['error'] = "This User Group is Already in Use."; 
			echo json_encode($json);
			exit;
		}else{
			$data['groupName'] = $formData['usergroupName'];
			$data['type'] = $formData['type'];
			$status = $formData['status'];
			if($status==1){
				$data['status']=1;
			}else{
				$data['status']=0;
			}
			
			
			$data['updated_at'] = date('Y-m-d H:i:s');
			$data['created_at'] = date('Y-m-d H:i:s');

			
			DB::table('usergroups')->insert($data);
		}
	}
	
	
	/**
	 * Update User Group to DB Table
	 */
	function updateUsergroup($formData)
	{
		$results = DB::table('usergroups')->where('groupName',$formData['usergroupName'])->get();

		if(count($results)!=0 && $results[0]->id!=$formData['usergroupId']){
			$json['error'] = "This User Group is Already in Use."; 
			echo json_encode($json);
			exit;
		}else{
			$data['groupName'] = $formData['usergroupName'];
			$data['type'] = $formData['type'];
			$status = (isset($formData['status']) && $formData['status'] == '1') ? '1' : '0';
			$data['status'] = $status;
			
			$data['updated_at'] = date('Y-m-d H:i:s');
		
			DB::table('usergroups')->where('id', $formData['usergroupId'])->update($data);	
		}
	}
	
	/**
	 * Delete User Groups From DB Table
	 */
	function deleteUsergroups($formData)
	{
		DB::table('usergroups')->whereIn('id',explode(',',$formData['usergroupId']))->delete();
		
	}
	
	
	/**
	 * Delete User Groups From DB Table
	 */
	function deleteAll()
	{
		DB::table('usergroups')->delete();
		
	}
	
}