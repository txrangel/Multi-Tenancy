<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Hash;
use Stancl\Tenancy\Database\Models\Tenant as BaseTenant;
use Stancl\Tenancy\Contracts\TenantWithDatabase;
use Stancl\Tenancy\Database\Concerns\HasDatabase;
use Stancl\Tenancy\Database\Concerns\HasDomains;

class Tenant extends BaseTenant implements TenantWithDatabase
{
    use HasDatabase, HasDomains;

    public function domains(): HasMany{
        return $this->hasMany(related: Domain::class);
    }

    public static function getCustomColumns(): array{
        return [
            'id',
            'name',
            'email',
            'password'
        ];
    }

    protected $hidden = [
        'password',
        'remember_token'
    ];

    // public function setPasswordAttribute($value): string{
    //     return $this->attributes['password'] = Hash::make(value: $value);
    // }
}