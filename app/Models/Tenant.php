<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Hash;
use Stancl\Tenancy\Database\Models\Tenant as BaseTenant;
use Stancl\Tenancy\Contracts\TenantWithDatabase;
use Stancl\Tenancy\Database\Concerns\HasDatabase;
use Stancl\Tenancy\Database\Concerns\HasDomains;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class Tenant extends BaseTenant implements TenantWithDatabase
{
    use HasDatabase, HasDomains;

    public function domains(): HasMany
    {
        return $this->hasMany(related: Domain::class);
    }

    public static function getCustomColumns(): array
    {
        return [
            'id',
            'name',
            'email',
            'password',
            'photo_path',
            'danger_color',
            'gray_color',
            'info_color',
            'primary_color',
            'success_color',
            'warning_color'
        ];
    }
    protected $hidden = [
        'email',
        'password',
        'remember_token'
    ];

    public function setPasswordAttribute($value): string
    {
        return $this->attributes['password'] = Hash::make(value: $value);
    }

    protected static function boot()
    {
        parent::boot();
        // Exclui os diretórios de cache e armazenamento quando o tenant é excluído permanentemente
        static::deleting(function ($tenant) {
            // Exclui o arquivo de foto (se existir)
            if (Storage::disk('public')->exists($tenant->photo_path)) {
                Storage::disk('public')->delete($tenant->photo_path);
            }
        });
    }
}