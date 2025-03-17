<?php

use App\Http\Controllers\UserProfileController;
use Illuminate\Support\Facades\Route;

foreach (config('tenancy.central_domains') as $domain) {
    Route::middleware('web')->domain($domain)->group(function () {
        Route::get('/', function () {
            return view('welcome');
        });
        
        Route::get('/dashboard', function () {
            return view('dashboard');
        })->middleware(['auth', 'verified'])->name('dashboard');
        
        Route::middleware('auth')->group(function () {
            Route::get('/profile', [UserProfileController::class, 'edit'])->name('profile.edit');
            Route::patch('/profile', [UserProfileController::class, 'update'])->name('profile.update');
            Route::delete('/profile', [UserProfileController::class, 'destroy'])->name('profile.destroy');
        });
    });
}

require __DIR__.'/auth.php';
