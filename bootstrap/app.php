<?php

use App\Http\Middleware\HandleAppearance;
use App\Http\Middleware\HandleInertiaRequests;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Foundation\Http\Middleware\HandleCors;
use Illuminate\Http\Middleware\AddLinkHeadersForPreloadedAssets;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
	->withMiddleware(function (Middleware $middleware) {
		$middleware->validateCsrfTokens(except: [
			'http://localhost:5000/*',
			'/api/login',
			'/api/createLogin',
			'/api/deleteLogin',
			'/api/uploadPic',
			'/api/getPic',
			'/login',
			'/createLogin',
			'/api/createAcc',
			'/api/updateAcc',
			'/api/deleteAcc'
		]);
		
		//$middleware->append(HandleCors::class);
	/*

    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->encryptCookies(except: ['appearance', 'sidebar_state']);

        $middleware->web(append: [
            HandleAppearance::class,
            HandleInertiaRequests::class,
            AddLinkHeadersForPreloadedAssets::class,
        ]);*/
    })
	
    ->withExceptions(function (Exceptions $exceptions): void {
    })->create();