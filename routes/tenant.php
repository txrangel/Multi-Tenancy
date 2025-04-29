<?php

declare(strict_types=1);

use Illuminate\View\Middleware\ShareErrorsFromSession;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;
use Illuminate\Support\Facades\Route;

Route::middleware([
    'web',
    InitializeTenancyByDomain::class, // Inicializa o tenant
    PreventAccessFromCentralDomains::class, // Bloqueia acesso central
    ShareErrorsFromSession::class, // Compartilha erros de sessão com as views,
])->group(function () {

    Route::redirect('/','/app')->name('app');
    // Inclua as rotas de autenticação do Breeze
    require __DIR__.'/auth.php';
});