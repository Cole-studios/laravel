<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\UserController;
use App\Http\Controllers\AccountController;


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// temporary, for testing only
Route::get('/db-test', function () {
    try {
        DB::connection()->getPdo();
        return "Connected! DB name: " . DB::connection()->getDatabaseName();
    } catch (\Exception $e) {
        return "Error: " . $e->getMessage();
    }
});



// ║ ║ ╔══ ╔══ ╔═╗
// ║ ║ ╚═╗ ╠══ ╠╦╝
// ╚═╝ ══╝ ╚══ ║ ║

// login has issues here, relocated to web.php

Route::post('/createLogin', [UserController::class, 'createLogin']);

Route::post('/logout', [UserController::class, 'logout']);

Route::post('/logout', [UserController::class, 'logout']);

Route::post('/changePass', [UserController::class, 'changePass']);

Route::post('/uploadPic/{username}', [UserController::class, 'uploadPic']);

Route::get('/getPic/{username}', [UserController::class, 'getPic']);


/*
Route::options('/createLogin', function () {
    return response('', 201)
        ->header('Access-Control-Allow-Origin', '*')
        ->header('Access-Control-Allow-Methods', 'POST, GET, OPTIONS')
        ->header('Access-Control-Allow-Headers', 'Content-Type, Authorization');
});
*/


// Accounts

Route::get('/getaccs/{username}', [AccountController::class, 'getAccs']);

Route::post('/createAcc', [AccountController::class, 'createAcc']);

Route::put('/updateAcc/{id}', [AccountController::class, 'updateAcc']);

Route::delete('/deleteAcc/{id}', [AccountController::class, 'deleteAcc']);

