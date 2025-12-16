<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Models\Account;


class AccountController extends Controller
{
	
	// make entry
	public function createAcc(Request $request){
		error_log('hit');
		
		$entry = $request->validate([
			'site' => 'required',
			'username' => 'required',
			'password' => 'required',
			'owner' => 'required'
		]);
		
		//error_log('shit');

		/*
		if ($validator->fails()) {
			return response()->json([
				'success' => false,
				'msg' => $validator->errors()
			], 422);  // 422 = Unprocessable Entity
		}*/
		

		$account = Account::create($entry);
		return response()->json([
			'success' => true,
			'msg' => "Account created",
			'data' => $account
		], 201);
	}
	
	// display entries
	public function getAccs($username){
		$rows = Account::where('owner', $username)->get();
		
		return response()->json([
			'success' => true,
			'data' => $rows
		], 200);
	}
	
	// update entry
	public function updateAcc(Request $request, $id){
		//error_log($id);
		//error_log(json_encode($request->all()));
		
		$account = Account::findOrFail($id);
		//error_log("past find fail");
		$account->update($request->only(['id','site','username','password']));
		
		// PUT A FAIL CONDITION LATER WHEN NO PASS
		
		if ($request->has('id') && $request->input('id') !== $id) {
			error_log(json_encode("request in"));
			$account->id = $request->input('id');
			$account->save();  // manually save the new primary key
		}

		//error_log(json_encode($account));
		
		return response()->json([
			'success' => true,
			'msg' => "Entry updated",
			'data' => $account
		], 201);
	}
	
	
	public function deleteAcc($id){
		//error_log("FUCK THIS SHIT, HIT!!!" . $id);
		/*
		$account = Account::find($id);
		$account->delete();
		*/
		
		// idk how fail() didnt work
		$account = Account::findOrFail($id);
		//error_log(dump($account));
		$account->delete();
		
		/*
		if ($request->has('id') && $request->input('id') !== $id) {
			//$account->id = $request->input('id');
			$account->delete();
		}*/
		
		return response()->json([
			'success' => true,
			'msg' => "Entry " . $id . " deleted",
			'data' => $account
		], 200);
	}
}