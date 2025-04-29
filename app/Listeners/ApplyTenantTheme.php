<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Stancl\Tenancy\Events\TenancyInitialized;

class ApplyTenantTheme
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(TenancyInitialized $event)
    {
        $tenant = $event->tenancy->tenant;
        
        // Atualiza as configurações de tema
        config([
            'theme.colors.primary' => $tenant->primary_color ?? '#3b82f6',
            'theme.colors.info' => $tenant->info_color ?? '#06b6d4',
            'theme.colors.danger' => $tenant->danger_color ?? '#ef4444',
            'theme.colors.success' => $tenant->success_color ?? '#10b981',
            'theme.colors.warning' => $tenant->warning_color ?? '#f59e0b',
            'theme.colors.gray' => $tenant->gray_color ?? '#6b7280',
        ]);
        
        // Você pode adicionar mais configurações de tema aqui se necessário
    }
}
