<?php

declare(strict_types=1);

use App\Http\Controllers\ProfileController;
use App\Http\Middleware\SessionDomainMiddleware;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;

Route::middleware([
    'web',
    InitializeTenancyByDomain::class, // Inicializa o tenant
    PreventAccessFromCentralDomains::class, // Bloqueia acesso central
    ShareErrorsFromSession::class, // Compartilha erros de sessão com as views
])->group(function () {
    Route::get('/', function () {
        // dd(tenant(),App\Models\User::all());
        return view('welcome');
    });

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->middleware(['auth', 'verified'])->name('dashboard');

    Route::middleware('auth')->group(function () {
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    });

    // Inclua as rotas de autenticação do Breeze
    require __DIR__.'/auth.php';
});