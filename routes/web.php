<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Laravel\Fortify\Features;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\UserController;


Route::get('/', function () {
    return Inertia::render('welcome', [
        'canRegister' => Features::enabled(Features::registration()),
    ]);
})->name('home');



Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', function () {
        return Inertia::render('dashboard');
    })->name('dashboard');
});

// temporary, for testing only
Route::get('/db-test', function () {
    try {
        DB::connection()->getPdo();
        return "Connected! DB name: " . DB::connection()->getDatabaseName();
    } catch (\Exception $e) {
        return "Error: " . $e->getMessage();
    }
});

Route::get('/test', function () {
    return view('test', ['test' => 'ASDF']);
});


// for accounts
/*
Route::post('/createEntry', [AccountController::class, 'createEntry']);

Route::get('/getaccs/{user}', [AccountController::class, 'getAccs']);

Route::put('/updateEntry/{user}', [AccountController::class, 'updateEntry']);

Route::delete('/deleteEntry/{user}', [AccountController::class, 'deleteEntry']);

*/


Route::post('/api/login', [UserController::class, 'login']);




require __DIR__.'/settings.php';