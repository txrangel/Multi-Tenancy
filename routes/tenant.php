<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;

/*
|--------------------------------------------------------------------------
| Tenant Routes
|--------------------------------------------------------------------------
|
| Here you can register the tenant routes for your application.
| These routes are loaded by the TenantRouteServiceProvider.
|
| Feel free to customize them however you want. Good luck!
|
*/

Route::middleware([
    'web',
    InitializeTenancyByDomain::class,
    PreventAccessFromCentralDomains::class,
])->group(function () {
    Route::get('/', function () {
        dd(tenant(),\App\Models\User::all());
        // return 'This is your multi-tenant application. The id of the current tenant is ' . tenant('id');
    });
    Route::get('/test-login', function () {
        return view('test-login');
    });

    Route::post('/test-login', function () {
        $credentials = [
            'email' => 'joao.silva@teste.com',
            'password' => '12345678',
        ];

        if (Auth::attempt($credentials)) {
            return 'Login successful!';
        }

        return 'Login failed!';
    })->name('teste');
});
