<?php

namespace App\Providers\Filament;

use App\Http\Middleware\SessionDomainMiddleware;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;

class AppPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        $panel = $panel
            ->id('app')
            ->path('app')
            ->login(fn() => view('auth.login'))
            ->discoverResources(in: app_path('Filament/App/Resources'), for: 'App\\Filament\\App\\Resources')
            ->discoverPages(in: app_path('Filament/App/Pages'), for: 'App\\Filament\\App\\Pages')
            ->discoverClusters(in: app_path('Filament/Clusters'), for: 'App\\Filament\\Clusters')
            ->pages([
                Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/App/Widgets'), for: 'App\\Filament\\App\\Widgets')
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->middleware(middleware: [
                SessionDomainMiddleware::class,
                'web',
                InitializeTenancyByDomain::class, // Inicializa o tenant
                PreventAccessFromCentralDomains::class, // Bloqueia acesso central
            ])
            ->authMiddleware([
                'auth'
            ])
            ->brandLogo(fn() => view('filament.logo'))
            ->darkModeBrandLogo(fn() => view('filament.dark-logo'))
            ->brandLogoHeight('62px')
            ->favicon(fn()=>url("storage/" . tenant()->photo_path))
            ->colors([
                'primary'   => Color::hex(config('theme.colors.primary')),
                'info'      => Color::hex(config('theme.colors.info')),
                'danger'    => Color::hex(config('theme.colors.danger')),
                'success'   => Color::hex(config('theme.colors.success')),
                'warning'   => Color::hex(config('theme.colors.warning')),
                'gray'      => Color::hex(config('theme.colors.gray')),
            ]);
        return $panel;
    }
}
