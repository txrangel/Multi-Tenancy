<?php

declare(strict_types=1);

use Illuminate\View\Middleware\ShareErrorsFromSession;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserProfileController;
use App\Http\Middleware\CheckPermission;
use Illuminate\Support\Facades\Route;

Route::middleware([
    'web',
    InitializeTenancyByDomain::class, // Inicializa o tenant
    PreventAccessFromCentralDomains::class, // Bloqueia acesso central
    ShareErrorsFromSession::class, // Compartilha erros de sessão com as views
])->group(function () {
    Route::get('/', function () {
        return view('welcome');
    });

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->middleware(['auth', 'verified'])->name('dashboard');
    
    Route::prefix('profiles')->middleware(['auth', 'verified'])->name('profiles.')->controller(ProfileController::class)->group(function () {
        Route::get('/', 'index')
            ->name('index')
            ->middleware(CheckPermission::class . ':profile.index');
        Route::get('/create', 'create')
            ->name('create')
            ->middleware(CheckPermission::class . ':profile.create');
        Route::post('/store', 'store')
            ->name('store')
            ->middleware(CheckPermission::class . ':profile.create');
        Route::get('/{id}/edit', 'edit')
            ->name('edit')
            ->middleware(CheckPermission::class . ':profile.update');
        Route::put('/{id}/update', 'update')
            ->name('update')
            ->middleware(CheckPermission::class . ':profile.update');
        Route::get('/{id}/permissions', 'editPermissions')
            ->name('permissions.update')
            ->middleware(CheckPermission::class . ':profile.permissions.update');
        Route::put('/{id}/permissions', 'updatePermissions')
            ->name('permissions.update')
            ->middleware(CheckPermission::class . ':profile.permissions.update');
        Route::delete('/{id}/destroy', 'destroy')
            ->name('destroy')
            ->middleware(CheckPermission::class . ':profile.delete');
    });

    Route::prefix('permissions')->middleware(['auth', 'verified'])->name('permissions.')->controller(PermissionController::class)->group(function () {
        Route::get('/', 'index')
            ->name('index')
            ->middleware(CheckPermission::class . ':permission.index');
        Route::get('/create', 'create')
            ->name('create')
            ->middleware(CheckPermission::class . ':permission.create');
        Route::post('/store', 'store')
            ->name('store')
            ->middleware(CheckPermission::class . ':permission.create');
        Route::get('/{id}/edit', 'edit')
            ->name('edit')
            ->middleware(CheckPermission::class . ':permission.update');
        Route::put('/{id}/update', 'update')
            ->name('update')
            ->middleware(CheckPermission::class . ':permission.update');
        Route::delete('/{id}/destroy', 'destroy')
            ->name('destroy')
            ->middleware(CheckPermission::class . ':permission.delete');
    });

    Route::prefix('users')->middleware(['auth', 'verified'])->name('users.')->controller(UserController::class)->group(function () {
        Route::get('/', 'index')
            ->name('index')
            ->middleware(CheckPermission::class . ':user.index');
        Route::get('/create', 'create')
            ->name('create')
            ->middleware(CheckPermission::class . ':user.create');
        Route::post('/store', 'store')
            ->name('store')
            ->middleware(CheckPermission::class . ':user.create');
        Route::get('/{id}/edit', 'edit')
            ->name('edit')
            ->middleware(CheckPermission::class . ':user.update');
        Route::put('/{id}/update', 'update')
            ->name('update');
        Route::get('/{id}/edit/password', 'editPassword')
            ->name('edit.password')
            ->middleware(CheckPermission::class . ':user.update.password');
        Route::put('/{id}/update/password', 'updatePassword')
            ->name('update.password')
            ->middleware(CheckPermission::class . ':user.update.password');
        Route::get('/{id}/profiles', 'editProfiles')
            ->name('profiles.update')
            ->middleware(CheckPermission::class . ':user.profiles.update');
        Route::put('/{id}/profiles', 'updateProfiles')
            ->name('profiles.update')
            ->middleware(CheckPermission::class . ':user.profiles.update');
        Route::delete('/{id}/destroy', 'destroy')
            ->name('destroy')
            ->middleware(CheckPermission::class . ':user.delete');
    });

    Route::middleware('auth')->group(function () {
        Route::prefix('user/profile')->name('user.profile.')->controller(UserProfileController::class)->group(function () {
            Route::get('/', 'edit')->name('edit');
            Route::patch('/', 'update')->name('update');
            Route::delete('/', 'destroy')->name('destroy');
        });
    });

    // Inclua as rotas de autenticação do Breeze
    require __DIR__.'/auth.php';
});