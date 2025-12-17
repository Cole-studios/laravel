<?php

namespace App\Http\Controllers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use App\Models\User;
use App\Models\Account;


class UserController extends Controller
{	
	// make login
	public function createLogin(Request $request){
		$params = $request->validate([
			'username' => 'required',
			'password' => 'required',
			'email' => 'required|email|unique:login'
		]);
		$params['password'] = Hash::make($params['password']);
		$user = User::create($params);
		
		event(new Registered($user));
		
		$user->sendEmailVerificationNotification();
		
		return response()
		->json([
			'success' => true,
			'msg' => 'Account successfully created! Check your email for verification',
			'user' => $user->username
		], 201);
	}
	
	// login the login for the user to login as login thus allowing the login in the login to be used by the user for their uses
	public function login(Request $request){
		$credentials = $request->validate([
			'username' => 'required',
			'password' => 'required',
		]);
		
		if (Auth::attempt($credentials)){
			// session stuff? idk
			$request->session()->regenerate();
			
			return response()->json([
				'success' => true,
				'msg' => 'Close enough. Welcome back Privyet. o7'
			], 200);
		}
		
		// debug
		return response()->json([
			'success' => false,
			'msg' => 'Error'
		], 400);
		/*
		return response()->json([
			'success' => false,
			'msg' => 'Error'
		], 400); */
	}
	
	public function logout(Request $request){
		// Get the current user's information
		$user = Auth::user();

		// Log the user out
		Auth::logout();
		
		return response()
		->json([
			'success' => true,
			'msg' => 'Logged out successfully. See you next time komran o7'
		], 200);
	}

	
	// change pass
	public function changePass(Request $request){
		
		error_log("changePass hit");
		$request->validate([
			'username' => 'required',
			'password' => 'required'
		]);
		
		error_log("finding user");
		$user = User::findOrFail($request->username);
		
		error_log("updating");
		$user->update($request->only([ 'password' ]));
		$user->password = Hash::make($request->password);
		
		error_log("saving");
		$user->save();
		
		error_log("done");
		return response()->json([
			'success' => true,
			'msg' => "User password updated"
		], 201);
	}
		
		/*
		error_log("in");
		$user = User::findOrFail($id);
		
		error_log("past find fail");
		$account->update($request->only(['password']));
		
		// PUT A FAIL CONDITION LATER WHEN NO PASS
		
		

		//error_log(json_encode($account));
		
		return response()->json([
			'success' => true,
			'msg' => "Entry updated",
			'data' => $account
		], 201);*/

	/*
	// Profile info *DEFUNCT*
	public function getProfile(Request $request){
		$user = User::where('username', $username)->first();
		
		
		return response()->json([
			'success' => true,
			'data' => $user
		], 200);
	}*/
	
	
	// Upload a profile picture
    public function uploadPic(Request $request){
		error_log("uploadPic hit");
        $request->validate([
            //'profilepic' => 'required|file|image|max:1535',
            //'username'   => 'required|string'
            'profilepic' => 'required|image|mimes:jpeg,png|max:2048',
            'username'   => 'required'
        ]);
		
		error_log("uploadPic hit");
		
		error_log($request->username);
		
		$user = Auth::user();
        //$user = User::where('username', $request->username)->first();
		
		error_log("user def");
		
        if (!$user) {
			error_log("khant");
            return response()
			->json([
				'success' => false,
				'msg' => 'User not found'], 404);
			//->header('Access-Control-Allow-Origin', '*');
        } else {
			error_log("in");
		}
		
		error_log("reading file");
        $file = $request->file('profilepic');
		
		error_log("getting file contents");
        $contents = file_get_contents($file->getRealPath());
		
		// limit seems to be around 255~279 kb, attempts to change yield nothing, oof
		error_log("[ Raw size: " . filesize($file->getRealPath()) . "] [ Encoded size: " . strlen(base64_encode($contents)) . " ]");
		error_log("saving to profilepic column");
        $user->profilepic = base64_encode($contents);
        $user->save();

        return response()
			->json([
				'success' => true,
				'msg' => 'Profile picture changed'
			], 200)
			->header('Content-Type', 'image/jpeg');
    }
	

    // Get profile picture
    public function getPic(Request $request, $username)
    {
		error_log("get where");
        $user = Auth::user();
		//$user = User::where('username', $request->username)->first();
		
		error_log("user exist?");
		if (!$user || !$user->profilepic) {
			error_log("> nope, bye");
			return response()
			->json([
				'success' => false,
				'msg' => 'Cannot find user'
			], 400);
		}
		
		error_log("> yes, encoding");
		$image = base64_decode($user->profilepic);
		
		error_log("return!");
		return response($image)
			->header('Content-Type', 'image/jpeg');
    }
	
}

